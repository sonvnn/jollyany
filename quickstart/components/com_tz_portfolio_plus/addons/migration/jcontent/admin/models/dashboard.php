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

class TZ_Portfolio_PlusAddOnMigrationJContentModelDashboard extends TZ_Portfolio_PlusModelAddon_Datas{

    protected $metaKey          = PLG_MIGRATION_JCONTENT_META_KEY_ARTICLE;
    protected $metaKeyTag       = PLG_MIGRATION_JCONTENT_META_KEY_TAG;
    protected $metaKeyCategory  = PLG_MIGRATION_JCONTENT_META_KEY_CATEGORY;

    protected function populateState($ordering = 'id', $direction = 'desc'){
        parent::populateState($ordering, $direction);

        $input      = JFactory::getApplication() -> input;
        $this -> setState($this -> getName().'.component', $input -> get('component', PLG_MIGRATION_JCONTENT_COMPONENT));

        $type = $this->getUserStateFromRequest($this->context.'.filter.type', 'filter_type', '');
        switch ($type){
            case 'article':
                $type   = $this -> metaKey;
                break;
            case 'tag':
                $type   = $this -> metaKeyTag;
                break;
            case 'category':
                $type   = $this -> metaKeyCategory;
                break;

        }
        $this->setState('filter.type', $type);
    }


    protected function getStoreId($id = '')
    {
        // Compile the store id.
        if($access = $this -> getState('filter.type')) {
            $id .= ':' . $this->getState('filter.type');
        }

        return parent::getStoreId($id);
    }

    protected function tableColumnExists($column, $table='#__tz_portfolio_plus_addon_meta'){

        $storeId    = $this -> getStoreId(__METHOD__.':'.$column.':'.$table);

        if(isset($this -> cache[$storeId])){
            return $this -> cache[$storeId];
        }

        if(!$column || !$table){
            return false;
        }

        $this -> cache[$storeId]    = false;

        $db         = $this -> getDbo();
        $fields = $db -> getTableColumns($table);
        if(array_key_exists($column,$fields)) {
            $this -> cache[$storeId]    = true;
        }

        return $this -> cache[$storeId];
    }

    public function getListQuery(){

        $db         = $this -> getDbo();
        $query      = $db -> getQuery(true);
        $metaKey    = $this -> metaKey;
        $metaKeyCat = $this -> metaKeyCategory;

        $query -> select(
            $this->getState(
                'list.select',
                'c.*, c.id AS artId'
                .', m.*'
                .', cc.title AS catTitle, cc.id AS catid, cc.published AS cPublished, cc.created_user_id'
                .', t.id AS tagId, t.title AS tagTitle, t.alias AS tagAlias, t.published AS tagPublished'
                .', frgc.id AS frgId, frgc.title AS frgTitle'
                .', frgcc.title AS frgCatTitle, frgcc.id AS frgCatid'
                .', frgt.title AS frgTagTitle, frgt.id AS frgTagId'
            )
        );

        $query -> from('#__tz_portfolio_plus_addon_meta AS m');

        if($this -> tableColumnExists('addon_id')) {
            $query -> join('INNER', '#__tz_portfolio_plus_extensions AS e ON e.id = m.addon_id AND e.id ='
                .$this -> getState($this -> getName().'.addon_id'));
        }

        $query -> join('LEFT', '#__tz_portfolio_plus_content AS c ON c.id = m.data_id AND m.meta_key = '
            .$db -> quote($metaKey) );
        $query -> join('LEFT', '#__tz_portfolio_plus_content_category_map AS cm ON cm.contentid = c.id AND cm.main=1' );

        $query -> join('LEFT', '#__content AS frgc ON frgc.id = m.meta_id AND m.meta_key = '.$db -> quote($metaKey) );

        // Join to TZ Portfolio Plus categories table
        $query -> join('LEFT', '#__tz_portfolio_plus_categories AS cc ON (cc.id = m.data_id AND m.meta_key='.
            $db -> quote($metaKeyCat).') OR (cc.id = cm.catid AND m.meta_key = '.$db -> quote($metaKey).')' );

        // Join to Joomla categories table
        $query -> join('LEFT', '#__categories AS frgcc ON (frgcc.id = m.meta_id AND m.meta_key='
            .$db -> quote($metaKeyCat).') OR (frgcc.id = frgc.catid AND m.meta_key = '.$db -> quote($metaKey).')' );

        // Join to TZ Portfolio Plus Tag table
        $query -> join('LEFT', '#__tz_portfolio_plus_tags AS t ON (m.data_id = t.id AND m.meta_key='
            .$db -> quote($this -> metaKeyTag).')');

        // Join to Joomla Tag table
        $query -> join('LEFT', '#__tags AS frgt ON m.meta_id = frgt.id AND m.meta_key='.$db -> quote($this -> metaKeyTag));


        $type   = $this -> getState('filter.type');
        if($type){
            $query -> where('m.meta_key ='.$db -> quote($type));
        }else {
            $query->where('m.meta_key = ' . $db->quote($metaKey)
                . ' OR m.meta_key = ' . $db->quote($metaKeyCat)
                . ' OR m.meta_key = ' . $db->quote($this -> metaKeyTag)
            );
        }

        $query -> group('m.id');

        $query -> order('m.id DESC');

        return $query;
    }

    public function getItems(){

        // Get a storage key.
        $store = $this->getStoreId();

        // Try to load the data from internal storage.
        if (isset($this->cache[$store]))
        {
            return $this->cache[$store];
        }

        try
        {
            // Load the list items and add the items to the internal cache.
            $this->cache[$store] = $this->_getList($this->_getListQuery(), $this->getStart(), $this->getState('list.limit'));
        }
        catch (\RuntimeException $e)
        {
            $this->setError($e->getMessage());

            return false;
        }

        return $this->cache[$store];
    }


    public function getStatistics(){

        // Get a storage key.
        $storeId = $this -> getStoreId(__METHOD__);

        // Try to load the data from internal storage.
        if (isset($this->cache[$storeId]))
        {
            return $this->cache[$storeId];
        }

        $statistics = new stdClass();

        $statistics -> totalJTags               = ($totalJTag   = $this -> getTotalJTags())?$totalJTag:0;
        $statistics -> totalJArticles           = ($totalJArt   = $this -> getTotalJArticles())?$totalJArt:0;
        $statistics -> totalJCategories         = ($totalJCat   = $this -> getTotalJCategories())?$totalJCat:0;
        $statistics -> totalTagsMigrated        = ($totalTagMgr = $this -> getTotalItemsMigrated($this -> metaKeyTag))?$totalTagMgr:0;
        $statistics -> totalArticlesMigrated    = ($totalArtMgr = $this -> getTotalItemsMigrated($this -> metaKey))?$totalArtMgr:0;
        $statistics -> totalCategoriesMigrated  = ($totalArtMgr = $this -> getTotalItemsMigrated($this -> metaKeyCategory))?$totalArtMgr:0;

        $this -> cache[$storeId]    = $statistics;
        return $statistics;
    }

    public function getTotalItemsMigrated($metaKey = null){

        // Get a storage key.
        $storeId = $this -> getStoreId(__METHOD__.':'.$metaKey);

        // Try to load the data from internal storage.
        if (isset($this->cache[$storeId]))
        {
            return $this->cache[$storeId];
        }

        // Get joomla content data
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('COUNT(m.id)');
        $query -> from('#__tz_portfolio_plus_addon_meta AS m');

        if($this -> tableColumnExists('addon_id')) {
            $query -> join('INNER', '#__tz_portfolio_plus_extensions AS e ON e.id = m.addon_id AND e.id ='
                .$this -> getState($this -> getName().'.addon_id'));
        }

        if($metaKey) {
            $query->where('m.meta_key =' . $db->quote($metaKey));
        }

        $db -> setQuery($query);

        if($result = $db -> loadResult()) {
            $this->cache[$storeId] = $result;
            return $result;
        }

        return false;
    }

    public function getTotalJArticles(){

        // Get a storage key.
        $storeId = $this -> getStoreId(__METHOD__);

        // Try to load the data from internal storage.
        if (isset($this->cache[$storeId]))
        {
            return $this->cache[$storeId];
        }

        // Get joomla content data
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('COUNT(*)');
        $query -> from('#__content');

        $db -> setQuery($query);

        if($result = $db -> loadResult()) {
            $this->cache[$storeId] = $result;
            return $result;
        }

        return false;
    }

    public function getTotalJCategories(){

        // Get a storage key.
        $storeId = $this -> getStoreId(__METHOD__);

        // Try to load the data from internal storage.
        if (isset($this->cache[$storeId]))
        {
            return $this->cache[$storeId];
        }

        // Get joomla content data
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('COUNT(*)');
        $query -> from('#__categories');
        $query -> where('extension = '.$db -> quote(PLG_MIGRATION_JCONTENT_COMPONENT));

        $db -> setQuery($query);

        if($result = $db -> loadResult()) {
            $this->cache[$storeId] = $result;
            return $result;
        }

        return false;
    }

    public function getTotalJTags(){

        // Get a storage key.
        $storeId = $this -> getStoreId(__METHOD__);

        // Try to load the data from internal storage.
        if (isset($this->cache[$storeId]))
        {
            return $this->cache[$storeId];
        }

        // Get joomla content data
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> select('COUNT(t.id)');
        $query -> from('#__tags AS t');
        $query -> join('INNER', '#__contentitem_tag_map AS m ON m.tag_id = t.id');
        $query -> join('INNER', '#__content AS c ON c.id = m.content_item_id');
        $query -> group('t.id');

        $db -> setQuery($query);

        if($result = $db -> loadResult()) {
            $this->cache[$storeId] = $result;
            return $result;
        }

        return false;
    }

    public function purge($pks = null){
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);

        $query -> delete('#__tz_portfolio_plus_addon_meta');

        if($this -> tableColumnExists('addon_id')) {
            $query -> where('addon_id = '. $this -> getState($this -> getName().'.addon_id'));
        }
        if($pks && count($pks)){
            $query -> where('id IN('.implode(',', $pks).')');
        }

        $query -> where('(meta_key = '.$db -> quote($this -> metaKey)
            . ' OR meta_key ='.$db -> quote($this ->metaKeyTag)
            . ' OR meta_key ='.$db -> quote($this ->metaKeyCategory).')'
        );

        $db -> setQuery($query);

        if(!$db -> execute()){
            $this->setError($db -> getError());
            return false;
        }

        return true;
    }
}