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

class TZ_Portfolio_PlusAddOnMigrationJContentController extends TZ_Portfolio_Plus_AddOnControllerLegacy{

    protected $default_view     = 'dashboard';

    public function display($cachable = false, $urlparams = array())
    {
        $extension = PLG_MIGRATION_JCONTENT_COMPONENT;
        if(!JComponentHelper::isInstalled($extension)) {
            $app = JFactory::getApplication();
            $app -> enqueueMessage(JText::sprintf('PLG_MIGRATION_K2_EXTENSION_ERROR_INSTALL', $extension, $extension), 'warning');
            return $this;
        }

        JHtml::_('jquery.framework');

        return parent::display($cachable, $urlparams); // TODO: Change the autogenerated stub
    }
}