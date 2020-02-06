<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once dirname(__FILE__) . '/helper.php';

$doc    = JFactory::getDocument();
$doc -> addScript('modules/mod_tz_moving_letters/js/anime.min.js');
$doc->addStyleSheet('modules/mod_tz_moving_letters/css/style.css');

$list       =   mod_TZ_Moving_Letters_Helper::getList($params);
$effect     =   $params->get('effect',3);
$textalign  =   $params->get('textalign','center');
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require JModuleHelper::getLayoutPath('mod_tz_moving_letters', $params->get('layout', 'default'));
