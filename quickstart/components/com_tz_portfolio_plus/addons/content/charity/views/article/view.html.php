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

class PlgTZ_Portfolio_PlusContentCharityViewArticle extends JViewLegacy{
    protected $state        = null;
    protected $item         = null;
    protected $params       = null;
    protected $audio        = null;
    protected $formDonate   = null;
    protected $return_page  = null;
    protected $formPaypal   = null;
    protected $ReturnPagePaypal   = null;
    protected $checkPaypal   = null;
    protected $fromPaypal   = null;
    protected $donated      = null;

    public function display($tpl = null){

        $task = JRequest::getString('task');

        $this -> item       = $this -> get('Item');
//        $idct               = $this -> item -> id;
        $state              = $this -> get('State');
        $params             = $state -> get('params');
        $this -> state      = $state;
        $this -> params     = $params;
        $this -> formDonate = $this -> get('FormDonate');
        $this->return_page	= $this->get('ReturnPage');
        $this->formPaypal   = $this->get('NewDonate');
        $this->donated      = $this->get('Donated');
        $this->currency     = $this->get('Currency');

        parent::display($tpl);

    }
}