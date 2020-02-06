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

// No direct access
defined('_JEXEC') or die('Restricted access');

class TZ_Portfolio_Plus_AddOn_CharityViewCurrency extends JViewLegacy
{
    protected $item;
    protected $addonItem;
    protected $form;
    protected $state;
    protected $addonItems;

    public function display($tpl = null)
    {
        $this->state    = $this->get('State');
        $this->item     = $this->get('Item');
        $this->form     = $this->get('Form');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode("\n", $errors));
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
            JToolBarHelper::apply('currency.apply');
            JToolBarHelper::save('currency.save');
            JToolBarHelper::save2new('currency.save2new');
            JToolBarHelper::cancel('currency.cancel');
        }else{
            // Since it's an existing record, check the edit permission, or fall back to edit own if the owner.
            if ($canDo->get('core.edit') || ($canDo->get('core.edit.own'))) {
                JToolBarHelper::apply('currency.apply');
                JToolBarHelper::save('currency.save');

                // We can save this record, but check the create permission to see if we can return to make a new one.
                if ($canDo->get('core.create')) {
                    JToolBarHelper::save2new('currency.save2new');
                }
            }

            // If checked out, we can still save
			if ($canDo->get('core.create')) {
                JToolBarHelper::save2copy('currency.save2copy');
            }

			JToolBarHelper::cancel('currency.cancel', 'JTOOLBAR_CLOSE');
        }
    }
}