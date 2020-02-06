<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2015 templaza.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

// Register helper class
JLoader::register('TZ_Portfolio_Plus_Addon_CharityHelpers', COM_TZ_PORTFOLIO_PLUS_ADDON_PATH
    .'/content/charity/admin/helpers/charity.php');


if($controller = TZ_Portfolio_Plus_AddOnControllerLegacy::getInstance('TZ_Portfolio_Plus_AddOn_Charity'
    , array('base_path' => COM_TZ_PORTFOLIO_PLUS_ADDON_PATH
    .DIRECTORY_SEPARATOR.'content'
    .DIRECTORY_SEPARATOR.'charity'.DIRECTORY_SEPARATOR.'admin'))) {
    $task   = JFactory::getApplication()->input->get('addon_task');
    $controller->execute($task);
    $controller->redirect();
}