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

class PlgTZ_Portfolio_PlusMigrationJContent extends TZ_Portfolio_PlusPlugin
{
    protected $autoloadLanguage = true;
    protected $data_manager     = true;

    public function onContentAfterSave($context, $data, $isnew){}
    public function onContentAfterDelete($context, $table){

        if($context == 'com_tz_portfolio_plus.article' || $context == 'com_tz_portfolio_plus.category'
            || $context == 'com_tz_portfolio_plus.tag') {
            JLoader::import('migration.jcontent.includes.defines', COM_TZ_PORTFOLIO_PLUS_ADDON_PATH);

            $db     = JFactory::getDbo();
            $query  = $db -> getQuery(true);

            $query -> delete('#__tz_portfolio_plus_addon_meta');

            if($context == 'com_tz_portfolio_plus.article') {
                // Remove article migrated log
                $query -> where('data_id = '.$table -> id);
                $query -> where('meta_key = '.$db -> quote(PLG_MIGRATION_JCONTENT_META_KEY_ARTICLE));
            }

            if($context == 'com_tz_portfolio_plus.category') {
                // Remove category migrated log
                $query -> where('data_id = '.$table -> id);
                $query -> where('meta_key = '.$db -> quote(PLG_MIGRATION_JCONTENT_META_KEY_CATEGORY));
            }

            if($context == 'com_tz_portfolio_plus.tag') {
                // Remove category migrated log
                $query -> where('data_id = '.$table -> id);
                $query -> where('meta_key = '.$db -> quote(PLG_MIGRATION_JCONTENT_META_KEY_TAG));
            }

            $db -> setQuery($query);
            $db -> execute();
        }
    }
}