<?php
/*------------------------------------------------------------------------

# Attachment Addon

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2016 tzportfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - http://tzportfolio.com/forum

# Family website: http://www.templaza.com

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR.'addons'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'colors'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'aco.class.php';
require_once JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_tz_portfolio_plus'.DIRECTORY_SEPARATOR.'addons'.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR.'colors'.DIRECTORY_SEPARATOR.'assets'.DIRECTORY_SEPARATOR.'ColorExtractor'.DIRECTORY_SEPARATOR.'Color.php';
use League\ColorExtractor\Color;

class PlgTZ_Portfolio_PlusContentColorsControllerColors extends TZ_Portfolio_PlusControllerLegacy
{
	public function download(){
		$mainframe = JFactory::getApplication();
		$token          = $this -> input -> getString('addon_data_id');
		$addon_data_id  = $this -> input -> getInt('addon_data_id');
		$filename       = $this -> input -> getString('article_id');
		$article_id     =   (int)$filename;

		JLoader::import('com_tz_portfolio_plus.helpers.article', JPATH_ROOT.'/components');
		if($article   = TZ_Portfolio_PlusContentHelper::getArticleById($article_id)){
			$article -> link    = TZ_Portfolio_PlusHelperRoute::getArticleRoute($article_id, $article -> catid);
		}

		// Check addon_data_id token
		$check = JString::substr($token, JString::strpos($token, '_') + 1);
		$hash = JApplicationHelper::getHash($addon_data_id);

		if ($check != $hash)
		{
			$this -> setRedirect($article -> link, JText::_('PLG_CONTENT_COLORS_ACO_NOT_FOUND'), 'warning');
			return false;
		}

		$db     = JFactory::getDbo();
		$query  = $db -> getQuery(true)
			-> select('*')
			-> from('#__tz_portfolio_plus_addon_data')
			-> where('id = '.$addon_data_id);
		$db -> setQuery($query);
		$data_original      =   $db->loadObject();
		if ($data_original) :
			$value_original     =   json_decode($data_original->value);
			$pallete            =   explode(',',$value_original->pallete);
			$aco = new acofile($filename.".aco");
			for ($i=0; $i< count($pallete); $i++) {
				$color        =   Color::fromIntToRgb($pallete[$i]);
				$aco->add("Color".$i, $color->r, $color->g, $color->b);
			}
			$aco->outputAcofile();
			$mainframe -> close();
		else :
			$this -> setRedirect($article -> link, JText::_('PLG_CONTENT_COLORS_ACO_NOT_FOUND'), 'warning');
			return false;
		endif;
	}
}