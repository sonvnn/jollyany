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

JLoader::import('com_tz_portfolio_plus.controllers.addon_datas',JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components');

class TZ_Portfolio_Plus_Addon_CharityControllerCurrencies extends TZ_Portfolio_PlusControllerAddon_Datas {

    public function getModel($name = 'currency', $prefix = 'TZ_Portfolio_Plus_Addon_CharityModel', $config = array('ignore_request' => true))
    {
        return parent::getModel($name, $prefix, $config);
    }

    public function setDefault()
    {
        // Check for request forgeries
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $pks = $this->input->post->get('cid', array(), 'array');

        try
        {
            if (empty($pks))
            {
                throw new Exception(JText::_('PLG_CONTENT_CHARITY_CURRENCY_NO_SELECTED'));
            }

            JArrayHelper::toInteger($pks);

            // Pop off the first element.
            $id = array_shift($pks);
            $model = $this->getModel();
            $model->setHome($id);
            $this->setMessage(JText::_('PLG_CONTENT_CHARITY_CURRENCY_HOME_SET'));
        }
        catch (Exception $e)
        {
            JError::raiseWarning(500, $e->getMessage());
        }

        $this->setRedirect(JRoute::_($this -> getAddonRedirect(), false));
    }
}