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

class PlgTZ_Portfolio_PlusContentCharityViewPortfolio extends JViewLegacy {

    protected $state        = null;
    protected $item         = null;
    protected $params       = null;
    protected $audio        = null;
    protected $head         = false;
    protected $formDonate   = null;
    protected $donated      = null;
    protected $currency     = null;

    public function display($tpl = null){

        $this -> item   = $this -> get('Item');

        $state              = $this -> get('State');
        $params             = $state -> get('params');
        $this -> params     = $params;

        // get Form Donate
        $this -> formDonate = $this -> get('FormDonate');

        // Get donated
        $this -> donated    = $this -> get('Donated');

        // get Currency
        $this -> currency    = $this -> get('Currency');

        parent::display($tpl);
    }
}