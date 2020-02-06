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

class TZ_Portfolio_Plus_Addon_CharityController extends TZ_Portfolio_Plus_AddOnControllerLegacy{
    protected $default_view = 'currencies';

    public function display($cachable = false, $urlparams = array())
    {
        $id		    = $this -> input -> getInt('id');
        $addon_id   = $this -> input -> getInt('addon_id');
        $view       = $this -> input -> get('addon_view');
        $layout     = $this -> input -> get('addon_layout');

        if($layout == 'edit' && in_array($view, array('currency', 'amount', 'donate'))
            && !$this->checkEditId('com_tz_portfolio_plus.edit.'.$view, $id)){

            // Somehow the person just went to the form - we don't allow that.
            $this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
            $this->setMessage($this->getError(), 'error');

            if($view == 'currency'){
                $this -> setRedirect(JRoute::_('index.php?option=com_tz_portfolio_plus&view=addon_datas&addon_id='
                    . $addon_id.'&addon_view=currencies', false));
            }

        }
        return parent::display($cachable, $urlparams); // TODO: Change the autogenerated stub
    }
}