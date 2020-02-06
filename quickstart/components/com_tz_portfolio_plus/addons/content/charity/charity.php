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

require_once JPATH_SITE . '/components/com_tz_portfolio_plus/addons/content/charity/models/mddonate.php';

class PlgTZ_Portfolio_PlusContentCharity extends TZ_Portfolio_PlusPlugin
{
    protected $autoloadLanguage     = true;
    protected $data_manager         = true;

    public function onAddContentType(){

        $type           = array();
        $type_layout    = new stdClass();
        $lang           = JFactory::getLanguage();

        // Create comment's count type
        $lang_key = 'PLG_' . $this->_type . '_' . $this->_name . '_DONATE_TITLE';
        $lang_key = strtoupper($lang_key);

        if ($lang->hasKey($lang_key)) {
            $type_layout->text = JText::_($lang_key);
        } else {
            $type_layout->text = $this->_name;
        }

        $type_layout->value = $this->_name.':donate';
        $type[]             = clone($type_layout);

        // Create comment type
        $lang_key = 'PLG_' . $this->_type . '_' . $this->_name . '_TITLE';
        $lang_key = strtoupper($lang_key);

        if ($lang->hasKey($lang_key)) {
            $type_layout->text = JText::_($lang_key);
        } else {
            $type_layout->text = $this->_name;
        }

        $type_layout->value = $this->_name;

        $type[]             = clone($type_layout);


        // create event
        $lang_key = 'PLG_' . $this->_type . '_' . $this->_name . '_EVENT';
        $lang_key = strtoupper($lang_key);

        if ($lang->hasKey($lang_key)) {
            $type_layout->text = JText::_($lang_key);
        } else {
            $type_layout->text = $this->_name;
        }

        $type_layout->value = $this->_name.':event';
        $type[]             = clone($type_layout);


        return $type;
    }

    public function onContentDisplayArticleView($context, &$article, $params, $page = 0, $layout = null){
        $input  = JFactory::getApplication() -> input;
        if($charity_view = $input -> get('charity_view')){
            $getPView   = base64_decode($charity_view);
            $idDonate   = str_replace('paypalre','',$getPView);
            $vwPaypalre = 'paypalre';

            return parent::onContentDisplayArticleView($context, $article, $params, $page, $vwPaypalre);
        }

        return parent::onContentDisplayArticleView($context, $article, $params, $page, $layout);

    }

    public function onContentBeforeDisplay($context, &$article, $params, $page = 0, $layout = 'default') {

        list($extension, $vName)   = explode('.', $context);
        $item   = $article;
        if(isset($article -> id)) {

        }

        if($extension == 'module' || $extension == 'modules') {

            if($path = $this -> getModuleLayout($this -> _type, $this -> _name, $extension, $vName, $layout)){
                // Display html
                ob_start();
                include $path;
                $html = ob_get_contents();
                ob_end_clean();
                $html = trim($html);

                return $html;

            }
        }elseif(in_array($context, array('com_tz_portfolio_plus.portfolio', 'com_tz_portfolio_plus.date', 'com_tz_portfolio_plus.featured'
                        , 'com_tz_portfolio_plus.tags', 'com_tz_portfolio_plus.users'))) {
            if($html = $this -> _getViewHtml($context,$item, $params, $layout)) {
                return $html;
            }
        }

    }

    public function onBeforeDisplayAdditionInfo($context, &$article, $params, $page = 0, $layout = 'default'){

        list($extension, $vName)   = explode('.', $context);

        $item   = $article;

        $paramArt   = new JRegistry;
        $paramArt -> loadString($item -> attribs);

        if(isset($article -> id)){
            $item -> donated = ModTZDonate::getList($article->id);
        }

        $item -> currency = ModTZDonate::getCurrency();

        if($extension == 'module' || $extension == 'modules'){

            if($path = $this -> getModuleLayout($this -> _type, $this -> _name, $extension, $vName, $layout)){
                // Display html
                ob_start();
                include $path;
                $html = ob_get_contents();
                ob_end_clean();
                $html = trim($html);
                return $html;
            }

        }

        return '';
    }

}
