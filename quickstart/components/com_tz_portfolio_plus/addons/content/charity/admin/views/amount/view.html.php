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

class TZ_Portfolio_Plus_Addon_CharityViewAmount extends JViewLegacy{

    protected $state;
    protected $item;
    protected $form;
    protected $addonItem;
    protected $addonItems;

    public function display($tpl=null){

        $this->state        = $this->get('State');
        $this->item         = $this->get('Item');
        $this->form         = $this->get('Form');

        if(count($errors = $this->get('Errors'))) {
            JError::raiseError(500,implode("\n",$errors));
            return false;
        }

        $this -> addToolbar();

        parent::display($tpl);

    }

    protected function addToolbar()
    {
        JRequest::setVar('hidemainmenu', true);

        $user		= TZ_Portfolio_PlusUser::getUser();
        $userId		= $user->get('id');
        $isNew		= ($this->item->id == 0);
        $canDo	    = JHelperContent::getActions('com_tz_portfolio_plus');

        // For new records, check the create permission.
        if ($isNew && (count($user->getAuthorisedCategories('com_tz_portfolio_plus', 'core.create')) > 0)) {
            JToolBarHelper::apply('amount.apply');
            JToolBarHelper::save('amount.save');
            JToolBarHelper::save2new('amount.save2new');
            JToolBarHelper::cancel('amount.cancel');
        }else{
            // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
            if ($canDo->get('core.edit') || ($canDo->get('core.edit.own'))) {
                JToolBarHelper::apply('amount.apply');
                JToolBarHelper::save('amount.save');

                // We can save this record, but check the create permission to see if we can return to make a new one.
                if ($canDo->get('core.create')) {
                    JToolBarHelper::save2new('amount.save2new');
                }
            }

            // If checked out, we can still save
            if ($canDo->get('core.create')) {
                JToolBarHelper::save2copy('amount.save2copy');
            }

            JToolBarHelper::cancel('amount.cancel', 'JTOOLBAR_CLOSE');
        }
    }

}