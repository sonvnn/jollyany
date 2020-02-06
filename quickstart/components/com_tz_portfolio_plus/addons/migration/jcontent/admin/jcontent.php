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

JLoader::import('migration.jcontent.includes.defines', COM_TZ_PORTFOLIO_PLUS_ADDON_PATH);
JLoader::import('helpers.jcontent', PLG_MIGRATION_JCONTENT_ADMIN_PATH);

JLoader::register('PlgTZ_Portfolio_PlusMigrationModelBase', PLG_MIGRATION_JCONTENT_LIBRARIES_PATH
    .'/models/base.php');
JLoader::register('PlgTZ_Portfolio_PlusMigrationAjax', PLG_MIGRATION_JCONTENT_LIBRARIES_PATH.'/ajax.php');

if($controller = TZ_Portfolio_Plus_AddOnControllerLegacy::getInstance('TZ_Portfolio_PlusAddOnMigrationJContent'
    , array('base_path' => PLG_MIGRATION_JCONTENT_ADMIN_PATH))) {

    $input  = JFactory::getApplication()->input;
    $task   = $input -> get('addon_task');

    $controller->execute($task);
    $controller->redirect();
}