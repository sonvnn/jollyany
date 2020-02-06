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

class TZ_Portfolio_Plus_Addon_CharityHelpers{

    public static function addSubmenu($vName)
    {
        TZ_Portfolio_PlusHtmlSidebar::addEntry('Currencies','addon_view=currencies',$vName == 'currencies');
        TZ_Portfolio_PlusHtmlSidebar::addEntry('Donates','addon_view=donates',$vName == 'donates');
        TZ_Portfolio_PlusHtmlSidebar::addEntry('Amounts','addon_view=amounts',$vName == 'amounts');
    }
}