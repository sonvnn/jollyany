<?php
/*------------------------------------------------------------------------

# TZ Portfolio Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2012 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.plugin.plugin');

class plgSystemTpl_Profiler_Params extends JPlugin
{
    public function onContentPrepareForm($form, $data){
        $app    = JFactory::getApplication();
        if($app -> isAdmin()){
            $input  = $app -> input;

            $name = $form->getName();
            if($name == 'com_tz_portfolio_plus.article') {
                $language   = JFactory::getLanguage();
                $language -> load('plg_system_tpl_profiler_params');
                JForm::addFormPath(__DIR__.'/forms');
                $form->loadFile('params', false);
            }
            if($name == 'com_tz_portfolio_plus.category') {
                $language   = JFactory::getLanguage();
                $language -> load('plg_system_tpl_profiler_params');
                JForm::addFormPath(__DIR__.'/forms');
                $form->loadFile('category', false);
            }
            if($name == 'com_modules.module') {
                $module_name   = null;
                if(!empty($data)){
                    if(is_array($data) && isset($data['module'])){
                        $module_name   = $data['module'];
                    }elseif(is_object($data) && isset($data -> module)){
                        $module_name   = $data -> module;
                    }
                }else{
                    $input  = $app -> input;
                    $jform  = $input -> get($form -> getFormControl(),null, 'array');

                    if($jform && isset($jform['module'])){
                        $module_name    = $jform['module'];
                    }
                }
                $module_arr     =   ['mod_tz_portfolio_plus_carousel','mod_tz_portfolio_plus_portfolio'];
                if (in_array($module_name, $module_arr) ) {
                    $language   = JFactory::getLanguage();
                    $language -> load('plg_system_tpl_profiler_params');
                    JForm::addFormPath(__DIR__.'/forms');
                    $form->loadFile('module', false);
                }
            }
        }
        return true;
    }
}