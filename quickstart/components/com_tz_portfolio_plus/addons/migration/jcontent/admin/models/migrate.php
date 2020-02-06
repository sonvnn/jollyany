<?php
/*------------------------------------------------------------------------

# Course Add-On

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2011-2017 tzportfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - http://tzportfolio.com/forum

# Family website: http://www.templaza.com

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

JTable::addIncludePath(PLG_MIGRATION_JCONTENT_ADMIN_PATH.'/tables');

class TZ_Portfolio_PlusAddOnMigrationJContentModelMigrate extends PlgTZ_Portfolio_PlusMigrationModelBase{

    protected $text_prefix = 'PLG_MIGRATION_JCONTENT';
    protected $metaKey          = PLG_MIGRATION_JCONTENT_META_KEY_ARTICLE;
    protected $sessionKey       = PLG_MIGRATION_JCONTENT_SESSION_KEY;
    protected $metaKeyTag       = PLG_MIGRATION_JCONTENT_META_KEY_TAG;
    protected $metaKeyCategory  = PLG_MIGRATION_JCONTENT_META_KEY_CATEGORY;
    protected $sessionNameSpace = PLG_MIGRATION_JCONTENT_SESSION_NAMESPACE;

    protected function populateState(){
        parent::populateState();

        $this -> setState($this -> getName().'.component', PLG_MIGRATION_JCONTENT_COMPONENT);
    }

    protected function loadForm($name, $source = null, $options = array(), $clear = false, $xpath = false)
    {
        if($component = $this -> getState($this -> getName().'.component')){
            if(!JComponentHelper::isInstalled($component)){
                return false;
            }
        }

        \JForm::addFormPath(PLG_MIGRATION_JCONTENT_ADMIN_PATH . '/models/forms');
        \JForm::addFieldPath(PLG_MIGRATION_JCONTENT_ADMIN_PATH . '/models/fields');

        return parent::loadForm($name, $source, $options, $clear, $xpath);
    }

    public function migrate($data, $component = null){

        JLoader::register('PlgTZ_Portfolio_PlusMigrationAjax', COM_TZ_PORTFOLIO_PLUS_ADDON_PATH
            .'/migration/jcontent/libraries/ajax.php');

        $ajax   = PlgTZ_Portfolio_PlusMigrationAjax::getInstance();

        $app    = JFactory::getApplication();

        $migrateStat    = $this -> getStatistics();

        $foreignCatid   = null;
        if($data && isset($data['frgCatid'])){
            $foreignCatid   = $data['frgCatid'];
        }

        // Get the total number of items
        $total  = $this -> getTotalItems($foreignCatid, $data['frgState'], $data['authorid']);

        // Get the real items
        $jItems = $this -> getJContentItems($foreignCatid, $data['frgState'], $data['authorid']);

        // Determines if there is still items to be migrated
        $balance = $total - count($jItems);

        if(!$jItems){
            // No Items
            $ajax -> append('[data-progress-status]', JText::_('PLG_MIGRATION_JCONTENT_NO_ITEM'));
            $this -> setError(JText::_('PLG_MIGRATION_JCONTENT_NO_ITEM'));
            $ajax -> resolve(false);
            return false;
        }

        $table  = $this -> getTable('content', 'TZ_Portfolio_PlusTable');
        $fields = $table -> getFields();
        unset($fields['id']);
        unset($fields['attribs']);
        unset($fields['catid']);
        unset($fields['images']);
        $ignoreFields   = array_keys($fields);

        foreach ($jItems as $key => $item) {

            $categoryId = $data['catid'];
            if(!$data['catid']) {
                $categoryId = $this->migrateCategory($item->catid);
            }

            $tpItems  = array(
                'id' => 0,
                'group' => 0,
                'type' => 'none',
                'associations' => array(),
                'media' => array());

            $_data  = $data;
            $app -> input -> set('jform', $_data);
            foreach($ignoreFields as $field) {
                if(isset($item -> {$field})){
                    $tpItems[$field]  = $item -> {$field};
                }
            }

            list($title, $alias)  = $this -> generateNewTitle($categoryId, $tpItems['alias'], $tpItems['title']);

            $tpItems['alias']   = $alias;
            $tpItems['title']   = $title;
            $tpItems['state']   = ($tpItems['state'] == 2)?0:$tpItems['state'];

            if($artId = $this -> saveArticle($tpItems)){

                $ajax -> append('[data-progress-status]', JText::sprintf('PLG_MIGRATION_JCONTENT_ARTICLE_MIGRATED',
                    $item -> id, $artId).'<br/>');

                $migrateStat -> article++;

                // Store category
                $this -> saveArticleCategories($artId, $categoryId);

                // Migrate the tags now
                $this -> migrateContentTags($artId, $item);

                $this ->setStatistics($migrateStat);

                // Log the entry into addon_meta table.
                $this -> storeLog($artId, $item -> id, $this -> metaKey);
            }

        }

        //Get balance if any
        $hasmore = false;

        if ($balance) {
            $hasmore = true;
        }

        if (!$hasmore) {
            $stat  = JText::sprintf('PLG_MIGRATION_JCONTENT_TOTAL_ARTICLE', $migrateStat->article) . '<br />';
            $stat  .= JText::sprintf('PLG_MIGRATION_JCONTENT_TOTAL_CATEGORY', $migrateStat->category) . '<br />';
            if(isset($migrateStat -> tag) && $migrateStat -> tag){
                $stat  .= JText::sprintf('PLG_MIGRATION_JCONTENT_TOTAL_TAG', $migrateStat->tag) . '<br />';
            }

            $ajax->append('[data-progress-status]', JText::_('PLG_MIGRATION_JCONTENT_FINISHED'));
            $ajax->append('[data-progress-stat]', $stat);

            // we need to clear the stat variable that stored in session.
            $this -> setStatistics(null);
        }

        $ajax -> resolve($hasmore);

        return $hasmore;
    }

    public function migrateCategory($catId){
        $jCategory = $this -> getJCategory($catId);

        $tzCategoryId = $this -> categoryExists($jCategory);
        return $tzCategoryId;
    }

    public function migrateContentTags($articleId, $jArticle)
    {
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);

        $query -> select('t.*');
        $query -> from('#__contentitem_tag_map AS m');
        $query -> join('INNER', '#__tags AS t ON m.tag_id = t.id');
        $query -> where('m.content_item_id = '.$jArticle -> id);

        $db->setQuery($query);

        $result = $db->loadObjectList();

        if (!$result) {
            return;
        }

        JTable::addIncludePath(PLG_MIGRATION_JCONTENT_ADMIN_PATH.'/tables');

        $this -> saveTags($result, $articleId);
    }

    protected function getJCategory($jCatId){

        // Get a storage key.
        $storeId = md5(__METHOD__.':'.$jCatId);

        // Try to load the data from internal storage.
        if (isset($this->cache[$storeId]))
        {
            return $this->cache[$storeId];
        }

        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);

        $query -> select('*');
        $query -> from('#__categories');
        $query -> where('id ='.(int) $jCatId);

        $db -> setQuery($query);

        if($data = $db -> loadObject()){
            $this -> cache[$storeId]    = $data;
            return $data;
        }

        return false;
    }

    public function getTotalItems($categoryId = null, $stateId = '*', $authorId = 0){

        // Get a storage key.
        $storeId    = __METHOD__;
        $storeId   .= ':'.serialize($categoryId);
        $storeId   .= ':'.$stateId;
        $storeId   .= ':'.$authorId;
        $storeId    = md5($storeId);

        // Try to load the data from internal storage.
        if (isset($this->cache[$storeId]))
        {
            return $this->cache[$storeId];
        }

        // Get joomla content data
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('COUNT(1)');
        $query -> from('#__content AS c');

        // Meta_id field is joomla content id
        // Data_id field is TZ Portfolio Plus content id
        $subQuery   = $db -> getQuery(true);
        $subQuery -> select('m.meta_id');
        $subQuery -> from('#__tz_portfolio_plus_addon_meta AS m');
        $subQuery -> where('c.id = m.meta_id');
        $subQuery -> where('m.meta_key = '.$db -> quote($this -> metaKey));

        $tblAddonMeta   = $this -> getTable('Addon_Meta', 'TZ_Portfolio_PlusTable');

        if(property_exists($tblAddonMeta, 'addon_id')) {
            $subQuery -> join('LEFT', '#__tz_portfolio_plus_extensions AS e ON e.id = m.addon_id');
            $subQuery -> where('(m.addon_id = 0 OR (m.addon_id = '.$this->getState($this->getName() . '.addon_id')
                . ' AND e.id = m.addon_id))');
        }

        $query -> where('NOT EXISTS('.(string) $subQuery.' )');

        if ($categoryId != null) {
            if(is_array($categoryId)){
                $query -> where('c.catid IN('.implode(',', $categoryId).')');
            }else {
                $query->where('c.catid = ' . (int)$categoryId);
            }
        }

        if($stateId != null && $stateId != '*') {
            $query -> where('c.state = '.(int) $stateId);
        }

        if ($authorId != '0') {
            $query -> where('c.created_by = '.(int) $authorId);
        }

        $query -> order('c.id');

        $db -> setQuery($query);

        if($result = $db -> loadResult()) {
            $this->cache[$storeId] = $result;
            return $result;
        }

        return false;
    }

    protected function getJContentItems($categoryId = null, $stateId = '*', $authorId = 0, $limit = 10){

        // Get a storage key.
        $storeId    = __METHOD__;
        $storeId   .= ':'.serialize($categoryId);
        $storeId   .= ':'.$stateId;
        $storeId   .= ':'.$authorId;
        $storeId   .= ':'.$limit;
        $storeId    = md5($storeId);

        if(isset($this -> cache[$storeId])){
            return $this -> cache[$storeId];
        }

        // Get joomla content data
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('c.*');
        $query -> from('#__content AS c');

        // Meta_id field is joomla content id
        // Data_id field is TZ Portfolio Plus content id
        $subQuery   = $db -> getQuery(true);
        $subQuery -> select('m.meta_id');
        $subQuery -> from('#__tz_portfolio_plus_addon_meta AS m');
        $subQuery -> where('c.id = m.meta_id');
        $subQuery -> where('m.meta_key = '.$db -> quote($this -> metaKey));

        $tblAddonMeta   = $this -> getTable('Addon_Meta', 'TZ_Portfolio_PlusTable');

        if(property_exists($tblAddonMeta, 'addon_id')) {
            $subQuery -> join('LEFT', '#__tz_portfolio_plus_extensions AS e ON e.id = m.addon_id');
            $subQuery -> where('(m.addon_id = 0 OR (m.addon_id = '.$this->getState($this->getName() . '.addon_id')
                . ' AND e.id = m.addon_id))');
        }

        $query -> where('NOT EXISTS('.(string) $subQuery.' )');

        if ($categoryId != null) {
            if(is_array($categoryId)){
                $query -> where('c.catid IN('.implode(',', $categoryId).')');
            }else {
                $query->where('c.catid = ' . (int)$categoryId);
            }
        }

        if($stateId != null && $stateId != '*') {
            $query -> where('c.state = '.(int) $stateId);
        }

        if ($authorId != '0') {
            $query -> where('c.created_by = '.(int) $authorId);
        }

        $query -> order('c.id');

        $db -> setQuery($query, 0, $limit);

        if($data = $db -> loadObjectList()){
            $this -> cache[$storeId]    = $data;
            return $data;
        }

        return false;
    }
}