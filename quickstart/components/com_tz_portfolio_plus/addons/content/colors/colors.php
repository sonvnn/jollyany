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


class PlgTZ_Portfolio_PlusContentColors extends TZ_Portfolio_PlusPlugin
{
    protected $autoloadLanguage     = true;

    public function onAddContentType(){
        $type = new stdClass();
        $lang = JFactory::getLanguage();
        $lang_key = 'PLG_' . $this->_type . '_' . $this->_name . '_TITLE';
        $lang_key = strtoupper($lang_key);

        if ($lang->hasKey($lang_key)) {
            $type->text = JText::_($lang_key);
        } else {
            $type->text = $this->_name;
        }

        $type->value = $this->_name;

        return $type;
    }

    public function onBeforeDisplayAdditionInfo($context, &$article, $params, $page = 0, $layout = 'default'){
        list($extension, $vName)   = explode('.', $context);

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
        }elseif(in_array($context, array('com_tz_portfolio_plus.portfolio', 'com_tz_portfolio_plus.date'
        , 'com_tz_portfolio_plus.featured', 'com_tz_portfolio_plus.tags', 'com_tz_portfolio_plus.users'))){
            if($html = $this -> _getViewHtml($context,$article, $params, $layout)){
                return $html;
            }
        }
    }

//    public function onAfterDisplayAdditionInfo ($context, &$article, $params, $page = 0, $layout = 'default') {
////    	var_dump($context); die();
//    }

	public function onContentAfterSave($context, $data, $isnew)
	{

	}

	public function onAddOnAfterSave($context, $data, $isnew){
		if($context == 'com_tz_portfolio_plus.article') {
			if($model  = $this -> getModel()) {
				if(method_exists($model,'save')) {
					$model->setState('params',$this->params);
					$model->setState('addon',TZ_Portfolio_PlusPluginHelper::getPlugin($this->_type, $this->_name));
					$model->save($data);
				}
			}
		}
	}

	public function onRenderAddonView(){

		tzportfolioplusimport('plugin.modelitem');

		$input      = JFactory::getApplication() -> input;

		if($controller = TZ_Portfolio_PlusPluginHelper::getAddonController($input -> get('addon_id'))){
			$task       = $input->get('addon_task');
			$controller -> execute($task);
			$controller -> redirect();
		}
	}
}
