<?php
/*------------------------------------------------------------------------

# JContent Migration Add-On

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2011-2018 TZ Portfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

# Family website: http://www.templaza.com

# Family Support: Forum - https://www.templaza.com/Forums.html

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

JModelLegacy::addIncludePath(COM_TZ_PORTFOLIO_PLUS_ADMIN_PATH.'/models');

class PlgTZ_Portfolio_PlusMigrationModelBase extends TZ_Portfolio_PlusModelAddon_Data{

    protected $metaKey;
    protected $sessionKey;
    protected $metaKeyCategory;
    protected $sessionNameSpace;

    protected function saveArticle($data){
        if(!$data){
            return false;
        }
        $table  = $this -> getTable('Content','TZ_Portfolio_PlusTable');

        $key = $table->getKeyName();
        $pk = (!empty($data[$key])) ? $data[$key] : 0;
        $isNew = true;

        try
        {
            // Load the row if saving an existing record.
            if ($pk > 0)
            {
                $table->load($pk);
                $isNew = false;
            }

            // Bind the data.
            if (!$table->bind($data))
            {
                $this->setError($table->getError());

                return false;
            }

//            // Prepare the row for saving
//            $this->prepareTable($table);

            // Check the data.
            if (!$table->check())
            {
                $this->setError($table->getError());

                return false;
            }

            // Store the data.
            if (!$table->store())
            {
                $this->setError($table->getError());

                return false;
            }

            // Check if the article was featured and update the #__tz_portfolio_plus_content_featured_map table
            if ($table -> featured == 1)
            {
                $db = $this->getDbo();
                $query = $db->getQuery(true)
                    ->insert($db->quoteName('#__tz_portfolio_plus_content_featured_map'))
                    ->values($table -> id . ', 0');
                $db->setQuery($query);
                $db->execute();
            }

            // Clean the cache.
            $this->cleanCache();

//            // Trigger the after save event.
//            $dispatcher->trigger($this->event_after_save, array($context, $table, $isNew, $data));
        }
        catch (\Exception $e)
        {
            $this->setError($e->getMessage());

            return false;
        }

        $this->setState($this->getName() . '.new', $isNew);

        if (isset($table-> {$key}))
        {
            $this->setState($this->getName() . '.id', $table-> {$key});

            return $table-> {$key};
        }

        return true;

    }

    protected function generateNewTitle($category_id, $alias, $title)
    {
        // Alter the title & alias
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);

        $query -> select('COUNT(c.id)');
        $query -> from('#__tz_portfolio_plus_content AS c');
        $query -> join('INNER', '#__tz_portfolio_plus_content_category_map AS m ON m.contentid = c.id AND m.main = 1');
        $query -> join('INNER', '#__tz_portfolio_plus_categories AS cc ON cc.id = m.catid AND cc.id = '
            .$category_id);
        $query -> where('c.alias = '.$db -> quote($alias));

        $db -> setQuery($query);

        $result = $db -> loadResult();

        while ($result)
        {
            $title = JString::increment($title);
            $alias = JString::increment($alias, 'dash');

            $result--;
        }

        return array($title, $alias);
    }

    protected function categoryExists($category){

        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);


        $title = JString::strtolower($category->title);
        $alias = JString::strtolower($category->alias);

        $query -> select('id');
        $query -> from('#__tz_portfolio_plus_categories');
        $query -> where('lower(title) = '. $db -> quote($title).' OR lower(alias) = '.$db -> quote($alias));

        $db -> setQuery($query);

        $result = $db -> loadResult();

        if(!$result){
            $result = $this -> createCategory($category);
        }

        return (int) $result;

    }

    protected function createCategory($category){
        $table  = $this -> getTable('Category', 'TZ_Portfolio_PlusTable');

        $fields = $table -> getFields();
        unset($fields['id']);
        unset($fields['params']);
        unset($fields['parent_id']);
        unset($fields['lft']);
        unset($fields['rgt']);
        unset($fields['path']);
        unset($fields['level']);
        unset($fields['extension']);
        $ignoreFields   = array_keys($fields);

        if($parentId = $table -> getRootId()){
            $table -> parent_id = $parentId;

            // Set the new location in the tree for the node.
            $table->setLocation($table->parent_id, 'last-child');
        }

        $table -> set('id', 0);
        $table -> set('extension', 'com_tz_portfolio_plus');
        foreach ($ignoreFields as $field){
            if(property_exists($category, $field) && property_exists($table, $field)) {
                $table-> set($field,$category->{$field});
            }
        }

        $stats  = $this -> getStatistics();

        if($table -> store()){
            $stats -> category++;
            $ajax   = PlgTZ_Portfolio_PlusMigrationAjax::getInstance();
            $ajax -> append('[data-progress-status]', JText::sprintf($this -> text_prefix.'_CATEGORY_MIGRATED'
                    , $category -> id, $table -> id).'<br/>');

            $table -> rebuild();
            $table -> rebuildPath($table -> id);

            // Log the entry into addon_meta table.
            $this -> storeLog($table -> id, $category -> id, $this -> metaKeyCategory);

            $this -> setStatistics($stats);
        }

        return $table -> id;
    }

    public function getStatistics(){

        $session = JFactory::getSession();

        $migrateStat = $session->get($this -> sessionKey, null, $this -> sessionNameSpace);

        if (empty($migrateStat)) {
            $migrateStat = new stdClass();
            $migrateStat -> article = 0;
            $migrateStat -> category= 0;
            $migrateStat -> tag     = 0;
            $migrateStat -> user    = array();

            $session -> set($this -> sessionKey, $migrateStat, $this -> sessionNameSpace);
        }

        return $migrateStat;
    }

    public function setStatistics($value){

        $session = JFactory::getSession();
        $session -> set($this -> sessionKey, $value, $this -> sessionNameSpace);

        return $session;
    }

    protected function storeLog($dataId, $metaId, $metaKey){

        if(!$dataId && !$metaId && !$metaKey){
            return false;
        }

        // Check auto_increment and set it for id field of table addon_meta
        $db     = $this -> getDbo();
        $fields = $db -> getTableColumns('#__tz_portfolio_plus_addon_meta', false);
        if($fields && count($fields) && isset($fields['id']) && $fields['id']){
            if(empty($fields['id'] -> Extra)){
                $query  = 'ALTER TABLE `#__tz_portfolio_plus_addon_meta` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT';
                $db -> setQuery($query);
                $db -> execute();
            }
        }

        // Log the entry into addon_meta table.
        $tblAddonMeta   = $this -> getTable('Addon_Meta', 'TZ_Portfolio_PlusTable');


        if(property_exists($tblAddonMeta, 'addon_id')) {
            $tblAddonMeta->addon_id = $this->getState($this->getName() . '.addon_id');
        }

        // Set data_id with tz content id
        $tblAddonMeta -> data_id    = $dataId;
        // Set meta_id with joomla content id
        $tblAddonMeta -> meta_id    = $metaId;

        $tblAddonMeta -> meta_key   = $metaKey;

        if(!$tblAddonMeta -> store()){
            return false;
        }

        return $tblAddonMeta;

    }

    public function saveArticleCategories($artId, $mainCatid, $secondCatids = array()){
        // Insert categories
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);

        if(!$artId || !$mainCatid){
            return false;
        }

        $catIds = array($mainCatid);

        $table  = $this -> getTable('Content_Category_Map', 'TZ_Portfolio_PlusAddOnMigrationJContentTable');

        // Check contentid map catid and store it
        if($table -> load(array('contentid' => $artId, 'catid' => $mainCatid))){
            if(!$table -> main){
                $table -> main  = 1;
                if(!$table -> store()){
                    $this->setError($table->getError());
                    return false;
                }
            }
        }else{
            if(!$table -> bind(array('contentid' => $artId, 'catid' => $mainCatid, 'main' => 1))){
                $this->setError($table->getError());
                return false;
            }
            if(!$table -> store()){
                $this->setError($table->getError());
                return false;
            }
        }

        // Check and store second category map to content
        if($secondCatids && count($secondCatids)){
            $catIds = array_merge($catIds, $secondCatids);
            foreach($secondCatids as $sCatid){
                if(!$table -> load(array('contentid' => $artId, 'catid' => $sCatid))){
                    $table -> resetAll();
                }
                if(!$table -> bind(array('contentid' => $artId, 'catid' => $sCatid, 'main' => 0))){
                    $this->setError($table->getError());
                    return false;
                }
                if(!$table -> store()){
                    $this->setError($table->getError());
                    return false;
                }
            }
        }

        // Delete all categories did not map article
        $query -> delete('#__tz_portfolio_plus_content_category_map');
        $query -> where('contentid = '.$artId);
        $query -> where('catid NOT IN('.implode(',', $catIds).')');
        $db -> setQuery($query);

        if(!$db -> execute()){
            $this -> setError($db -> getErrorMsg());
            return false;
        }

        return true;
    }

    /**
     * Method to store tags.
     *
     * @param   $tags   The tags list from the tags of table need migrate
     *
     */
    public function saveTags($tags, $articleId){

        $tagIds     = array();
        $stats      = $this -> getStatistics();
        $table      = JTable::getInstance('Tags',            'TZ_Portfolio_PlusTable');
        $tblTagMap  = JTable::getInstance('Tag_Content_Map', 'TZ_Portfolio_PlusAddOnMigrationJContentTable');

        foreach ($tags as $row) {

            $data   = new stdClass();

            foreach ($row as $field => $value){
                $data -> {$field}   = $row -> {$field};
            }

            $data -> id     = 0;

            $table -> id    = null;

            $loadData   = array('title' => $row -> title);
            if(isset($row -> alias) && $row -> alias){
                $loadData['alias']  = $row -> alias;
            }

            if(!$table -> load($loadData)){
                $table -> bind($data);
                if($table -> check()){
                    $table -> store();

                    $stats -> tag++;

                    $ajax   = PlgTZ_Portfolio_PlusMigrationAjax::getInstance();
                    $ajax -> append('[data-progress-status]', JText::sprintf(
                            $this -> text_prefix.'_TAGS_MIGRATED', $row -> id, $table -> id).'<br/>');

                    // Log the entry into addon_meta table.
                    $this -> storeLog($table -> id, $row -> id, $this -> metaKeyTag);
                }
            }

            if($tagId = $table -> id){
                $tagData    = array('tagsid' => $tagId, 'contentid' => $articleId);
                $tblTagMap -> id    = null;
                if(!$tblTagMap -> load($tagData)){
                    $tblTagMap -> bind($tagData);
                    $tblTagMap -> store();
                    $tagIds[]   = $tagId;
                }
            }
        }

        $this -> setStatistics($stats);

        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);

        $query -> clear();
        $query -> delete('#__tz_portfolio_plus_tag_content_map');
        $query -> where('contentid = ' . (int) $articleId);
        $query -> where('tagsid NOT IN('.implode(',', $tagIds).')');

        $db->setQuery($query);
        if(!$db->execute()){
            return false;
        }

        return true;
    }
}