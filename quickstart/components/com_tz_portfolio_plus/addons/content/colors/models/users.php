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
require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR.'addons'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'colors'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'ColorExtractor'.DIRECTORY_SEPARATOR.'Color.php';
use League\ColorExtractor\Color;

class PlgTZ_Portfolio_PlusContentColorsModelUsers extends TZ_Portfolio_PlusPluginModelItem{
    public function getItem()
    {
        if($item = parent::getItem()) { // TODO: Change the autogenerated stub
	        if(isset($item -> id)){
		        $media  =   $item->media;
		        $type   =   $item->type;
		        if ($type != 'none' && $media->{$type}) {
			        $db     = JFactory::getDbo();
			        $query  = $db -> getQuery(true)
				        -> select('*')
				        -> from('#__tz_portfolio_plus_addon_data')
				        -> where('content_id = '.$item->id);
			        $db -> setQuery($query);
			        $data_original      =   $db->loadObject();
			        if ($data_original) :
				        $value_original     =   json_decode($data_original->value);
				        $item->pallete      =   explode(',',$value_original->pallete);
				        for ($i=0; $i< count($item->pallete); $i++) {
					        $item->pallete[$i]  =   Color::fromIntToHex($item->pallete[$i]);
				        }
				        $item->aco          =   JRoute::_('index.php?option=com_tz_portfolio_plus&view=addon'
					        . '&addon_id=' . $data_original->extension_id . '&addon_task=colors.download&addon_data_id='
					        . $data_original->id.'_'.JApplication::getHash($data_original -> id).'&article_id='.$item->id.'-'.$item -> alias);
			        endif;
		        }
		        return $item;
	        }
        }
    }
}