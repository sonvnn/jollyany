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

// No direct access
defined('_JEXEC') or die;
require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR.'addons'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'colors'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'ColorExtractor'.DIRECTORY_SEPARATOR.'ColorExtractor.php';
require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR.'addons'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'colors'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'ColorExtractor'.DIRECTORY_SEPARATOR.'Palette.php';
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
jimport('joomla.filesystem.file');
JLoader::import('com_tz_portfolio_plus.models.addon_data',JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components');

class PlgTZ_Portfolio_PlusContentModelColors extends TZ_Portfolio_PlusModelAddon_Data{

    public function save($data){
    	$params     =   $this->getState('params');
	    $limitcolor =   $params->get('colorlimit',8);
	    $media  =   json_decode($data->media);
	    $type   =   $data->type;
	    if ($type != 'none' && $media->{$type}) {
		    $db     = JFactory::getDbo();
		    $query  = $db -> getQuery(true)
			    -> select('*')
			    -> from('#__tz_portfolio_plus_addon_data')
			    -> where('content_id = '.$data->id);
		    $db -> setQuery($query);
		    $data_original    =   $db->loadObject();
		    $mediatype      =   $media->{$type};
		    $url            =   '';
		    switch ($type) {
			    case 'image':
				    $url            =   isset($mediatype->url) ? $mediatype->url : '';
				    break;
			    case 'video':
				    $url            =   isset($mediatype->thumbnail) ? $mediatype->thumbnail : '';
				    break;
			    case 'image_gallery':
			    	$url            =   isset($mediatype->url[0]) ? $mediatype->url[0] : '';
			    	break;
		    }

			if (!trim($url)) return false;

		    jimport('joomla.filesystem.file');

		    $fileext    =   JFile::getExt($url);
		    $url   =   preg_replace('/\.'.$fileext.'$/i','_o.'.$fileext, $url);

		    if (!JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.$url)) return false;
		    $palette = Palette::fromFilename(JPATH_ROOT.DIRECTORY_SEPARATOR.$url);
		    // an extractor is built from a palette
		    $extractor = new ColorExtractor($palette);
		    // it defines an extract method which return the most “representative” colors
		    $data_color     =   new stdClass();
		    $data_color->pallete    = implode(',',$extractor->extract($limitcolor));
		    $addon = $this->getState('addon');
		    if ($data_original) {
			    $data_addon['id']           =   $data_original->id;
		    }
		    $data_addon['extension_id']     =   $addon->id;
		    $data_addon['element']          =   'colors';
		    $data_addon['value']            =   json_encode($data_color);
		    $data_addon['content_id']       =   $data->id;
		    $data_addon['published']        =   1;
		    if (!$data_original || ($data_original && ($data_original->value != $data_addon['value']))) {
			    return parent::save($data_addon);
		    }
	    }
    }
}