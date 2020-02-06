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

class PlgTZ_Portfolio_PlusContentCharityViewTags extends JViewLegacy{
    protected $item     = null;
    protected $params   = null;
    protected $audio    = null;

    public function display($tpl = null){
        $item           = $this -> get('Item');
        $state          = $this -> get('State');
        $params         = $state -> get('params');
        $this -> item   = $item;

        $_params    = clone($params);
        $artparams  = new JRegistry;
        $artparams  = $artparams -> loadString($item -> attribs);

        $category   = TZ_Portfolio_PlusFrontHelperCategories::getCategoriesById($item -> catid);

        if(isset($category -> params) && $category -> params && is_string($category -> params)) {
            $_params -> loadString($category->params);
        }

        $_params    = $_params -> merge($artparams);

        $params -> set('tz_crt_goal_money', $_params -> get('tz_crt_goal_money'));
        $params -> set('tz_crt_amounts', $_params -> get('tz_crt_amounts'));
        $params -> set('tz_crt_ct_amounts', $_params -> get('tz_crt_ct_amounts'));
        $params -> set('tz_crt_donated_status', $_params -> get('tz_crt_donated_status'));
        $params -> set('crt_evt_start', $_params -> get('crt_evt_start'));
        $params -> set('crt_evt_end', $_params -> get('crt_evt_end'));
        $params -> set('crt_evt_end', $_params -> get('crt_evt_end'));

        if($params -> get('show_mn_donate') == 'article_setting') {
            $params -> set('show_cat_donate', $_params -> get('show_cat_donate'));
        }elseif($params -> get('show_mn_donate') != ''){
            $params -> set('show_cat_donate', $params -> get('show_mn_donate'));
        }

        if($params -> get('show_mn_events') == 'article_setting') {
            $params -> set('show_cat_events', $_params -> get('show_cat_events'));
        }elseif($params -> get('show_mn_events') != ''){
            $params -> set('show_cat_events', $_params -> get('show_mn_events'));
        }

        $this -> params = $params->merge($_params);

        // get Form Donate
        $this -> formDonate = $this -> get('FormDonate');

        // Get donated
        $this -> donated    = $this -> get('Donated');

        // get Currency
        $this -> currency    = $this -> get('Currency');


        parent::display($tpl);
    }
}