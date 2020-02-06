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


class TZ_Portfolio_PlusAddOnMigrationJContentHelper{

    public static function addSubmenu($vName)
    {
        TZ_Portfolio_PlusHtmlSidebar::addEntry(JText::_('COM_TZ_PORTFOLIO_PLUS_DASHBOARD'),
            'addon_view=dashboard',$vName == 'dashboard');
        TZ_Portfolio_PlusHtmlSidebar::addEntry(JText::_('PLG_MIGRATION_JCONTENT_MIGRATE'),
            'addon_view=migrate',$vName == 'migrate');
    }
}