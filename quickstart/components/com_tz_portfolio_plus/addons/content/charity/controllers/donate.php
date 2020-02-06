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

// No direct access.
defined('_JEXEC') or die;

tzportfolioplusimport('controller.form');
//jimport('joomla.filesystem.file');

class PlgTZ_Portfolio_PlusContentCharityControllerDonate extends TZ_Portfolio_Plus_AddOnControllerForm
{
    var $paypal=   null;
    public function notification() {
        $model = $this->getModel();

        $this->paypal = JRequest::get('post');
//        if (JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR."test.txt"))
//            JFile::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR."test.txt");
//        JFile::write(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR."test.txt",json_encode($this->paypal));
        $addon_id       =   $this->input->getInt('addon_id');
        $params         =   new JRegistry();
        $params->loadString(TZ_Portfolio_PlusPluginHelper::getPluginById($addon_id)->params);
        $emailbusiness    = $params->get('paypalEmail','');


        if (isset($this->paypal['business']) && $this->paypal['business']!=$emailbusiness) {
            die();
        }
        if (isset($this->paypal['payment_status'])) {
            $paypal_status = $this->paypal['payment_status'];
        } else {
            $paypal_status = '';
        }
        if (strcmp($paypal_status, 'Completed') == 0) {
            return $result = $model->savePaypal($this->paypal);
        }
        die();
    }
}