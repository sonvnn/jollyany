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

if(!defined('PLG_MIGRATION_JCONTENT_ADMIN_PATH')){
    define('PLG_MIGRATION_JCONTENT_ADMIN_PATH', JPath::clean(COM_TZ_PORTFOLIO_PLUS_ADDON_PATH
        .'/migration/jcontent/admin'));
}
if(!defined('PLG_MIGRATION_JCONTENT_SITE_PATH')){
    define('PLG_MIGRATION_JCONTENT_SITE_PATH', JPath::clean(COM_TZ_PORTFOLIO_PLUS_ADDON_PATH
        .'/migration/jcontent'));
}
if(!defined('PLG_MIGRATION_JCONTENT_LIBRARIES_PATH')){
    define('PLG_MIGRATION_JCONTENT_LIBRARIES_PATH', JPath::clean(PLG_MIGRATION_JCONTENT_SITE_PATH
        .'/libraries'));
}
if(!defined('PLG_MIGRATION_JCONTENT_COMPONENT')){
    define('PLG_MIGRATION_JCONTENT_COMPONENT', 'com_content');
}
if(!defined('PLG_MIGRATION_JCONTENT_META_KEY_ARTICLE')){
    define('PLG_MIGRATION_JCONTENT_META_KEY_ARTICLE', '_migration_jcontent_article');
}
if(!defined('PLG_MIGRATION_JCONTENT_META_KEY_CATEGORY')){
    define('PLG_MIGRATION_JCONTENT_META_KEY_CATEGORY', '_migration_jcontent_category');
}
if(!defined('PLG_MIGRATION_JCONTENT_META_KEY_TAG')){
    define('PLG_MIGRATION_JCONTENT_META_KEY_TAG', '_migration_jcontent_tag');
}
//if(!defined('PLG_MIGRATION_JCONTENT_ELEMENT_JCONTENT')){
//    define('PLG_MIGRATION_JCONTENT_ELEMENT_JCONTENT', 'jcontent');
//}
if(!defined('PLG_MIGRATION_JCONTENT_SESSION_KEY')){
    define('PLG_MIGRATION_JCONTENT_SESSION_KEY', 'PLG_MIGRATION_JCONTENT_STAT');
}
if(!defined('PLG_MIGRATION_JCONTENT_SESSION_NAMESPACE')){
    define('PLG_MIGRATION_JCONTENT_SESSION_NAMESPACE', 'MigrationJContentAddon');
}