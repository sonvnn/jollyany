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

class TZ_Portfolio_PlusAddOnMigrationJContentViewMigrate extends JViewLegacy{

    protected   $form;
    protected   $item;
    protected   $state;
    protected   $component;

    public function display($tpl = null)
    {
        $this->state            = $this->get('State');
        $component      = $this -> state -> get($this -> getName().'.component');
        $this->item     = $this->get('Item');
        $this->form     = $this->get('Form');
        $this -> component  = $component;

        $this -> document -> addScript(TZ_Portfolio_PlusUri::root(true)
            .'/addons/migration/jcontent/admin/js/migrate.js');

        $this->addToolbar();

        TZ_Portfolio_PlusAddOnMigrationJContentHelper::addSubmenu($this -> getName());

        $component  = preg_replace('#^com_#', '', $component);

        $this -> sidebar    = JHtmlSidebar::render();

        return parent::display($tpl); // TODO: Change the autogenerated stub
    }

    protected function addToolbar(){

        $user       = TZ_Portfolio_PlusUser::getUser();
        $addonId    = $this -> state -> get($this -> getName().'.addon_id');
        $canDo	    = TZ_Portfolio_PlusHelperAddon_Datas::getActions( $addonId, 'addon','addon');

        if ($user->authorise('core.admin', 'com_tz_portfolio_plus.addon.'.$addonId)
            || $user->authorise('core.options', 'com_tz_portfolio_plus.addon.'.$addonId))
        {
            $addonId    = $this -> state -> get($this -> getName().'.addon_id');
            JToolbarHelper::link('index.php?option=com_tz_portfolio_plus&view=addon&layout=edit&id='.$addonId
                .'&return='.base64_encode('index.php?option=com_tz_portfolio_plus&view=addon_datas&addon_id='.$addonId
                    .'&addon_view='.$this -> getName()), 'JTOOLBAR_OPTIONS','options');
        }
    }
}