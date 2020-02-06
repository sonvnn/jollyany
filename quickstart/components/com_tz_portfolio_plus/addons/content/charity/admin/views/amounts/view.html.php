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

require_once(COM_TZ_PORTFOLIO_PLUS_ADMIN_PATH.'/views/addon_datas/view.html.php');

class TZ_Portfolio_Plus_Addon_CharityViewAmounts extends JViewLegacy{

    protected $state;
    protected $items;
    protected $form;
    protected $sidebar;
    protected $pagination;

    public function display($tpl=null){

        $this->state            = $this->get('State');
        $this->items            = $this->get('Items');
        $this->pagination       = $this->get('pagination');
        $this -> filterForm     = $this -> get('FilterForm');
        $this -> activeFilters  = $this -> get('ActiveFilters');

        TZ_Portfolio_Plus_Addon_CharityHelpers::addSubmenu('amounts');

        $this->addToolbar();

        $this -> sidebar    = JHtmlSidebar::render();

        parent::display($tpl);

    }

    protected function addToolbar(){

        $user       = TZ_Portfolio_PlusUser::getUser();
        $addonId    = $this -> state -> get($this -> getName().'.addon_id');
        $canDo      = TZ_Portfolio_PlusHelperAddon_Datas::getActions( $addonId, 'addon','addon');

        if ($canDo->get('tzportfolioplus.create') ) {
            JToolBarHelper::addNew('amount.add');
        }

        if($canDo -> get('tzportfolioplus.edit')) {
            JToolBarHelper::editList('amount.edit');
        }

        if($canDo -> get('tzportfolioplus.edit.state')) {
            JToolBarHelper::publish('amounts.publish', 'JTOOLBAR_PUBLISH', true);
            JToolBarHelper::unpublish('amounts.unpublish', 'JTOOLBAR_UNPUBLISH', true);
        }

        if ($this->state->get('filter.published') == -2 && $canDo->get('tzportfolioplus.delete')) {
            JToolBarHelper::deleteList('', 'amounts.delete', 'JTOOLBAR_EMPTY_TRASH');
        }
        elseif ($canDo->get('tzportfolioplus.edit.state')) {
            JToolBarHelper::trash('amounts.trash');
        }

        if ($user->authorise('core.admin', 'com_tz_portfolio_plus.addon.'.$addonId)
            || $user->authorise('core.options', 'com_tz_portfolio_plus.addon.'.$addonId))
        {
            TZ_Portfolio_PlusToolbarHelper::preferencesAddon($addonId);
        }
    }

}