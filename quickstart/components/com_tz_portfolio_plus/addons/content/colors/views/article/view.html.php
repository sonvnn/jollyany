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

class PlgTZ_Portfolio_PlusContentColorsViewArticle extends JViewLegacy{
    protected $item     = null;
    protected $params   = null;
	protected $head     = false;

    public function display($tpl = null){
        $this -> item   = $this -> get('Item');
        $state          = $this -> get('State');
        $params         = $state -> get('params');
        $this -> params = $params;

	    if(!$this -> head) {
		    $document = JFactory::getDocument();
		    $document->addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/css/style.css');
		    $document->addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/css/ns-default.css');
		    $document->addStyleSheet(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/css/ns-style-growl.css');

		    $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/modernizr.custom.js');
		    $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/classie.js');
		    $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/notificationFx.js');
		    $document->addScript(TZ_Portfolio_PlusUri::root(true) . '/addons/content/colors/js/colors.js');
		    $this -> head   = true;
	    }

        parent::display($tpl);
    }
}