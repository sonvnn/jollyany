<?php
/*------------------------------------------------------------------------

# Flipbook Gallery Addon

# ------------------------------------------------------------------------

# author    Sonny

# copyright Copyright (C) 2019 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

class PlgTZ_Portfolio_PlusMediaTypeModelImage_Gallery extends TZ_Portfolio_PlusPluginModelAdmin
{

	// This function to upload and save data with data saved in com
	public function save($data){
		$app            =   JFactory::getApplication();
		$input          =   $app -> input;

		// Get params
		$params         =   $this -> getState('params');

		$tmp_folder     =   $input -> get('image_gallery_folder','');
		$gallery_images=   $input -> get('image_gallery_image',array(),'RAW');
		$gallery_source=   $input -> get('image_gallery_source',array());
		$gallery_title =   $input -> get('image_gallery_image_title',array(),'RAW');
		$featured_image =   $input -> get('image_featured','','RAW');
		$config         =   JFactory::getConfig();
		$tmp_part       =   $config->get('tmp_path') . '/' .$tmp_folder ;

		$tmp_dest       =   JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'tz_portfolio_plus'.DIRECTORY_SEPARATOR.'image_gallery';
		$arr_server     =   array();
		$arr_client     =   array();
		for ($i = 0; $i<count($gallery_source); $i++) {
			$gallery_data              =   new stdClass();
			$gallery_data -> image     =   $gallery_images[$i];
			$gallery_data -> title     =   $gallery_title[$i];
			switch ($gallery_source[$i]) {
				case 'server':
					$arr_server[]   =   $gallery_data;
					break;
				case 'client':
					$arr_client[]   =   $gallery_data;
					break;
			}
		}

		if ($params && $image_size = $params->get('image_gallery_size')) {
			if($image_size && !is_array($image_size) && preg_match_all('/(\{.*?\})/',$image_size,$match)) {
				$image_size = $match[1];
			}
		}

		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');
		if (count($arr_client) && !JFolder::exists($tmp_dest.DIRECTORY_SEPARATOR.$data->id)) {
			JFolder::create($tmp_dest.DIRECTORY_SEPARATOR.$data->id);
		}
		if($input -> getCmd('task') == 'save2copy' && $input -> getInt('id')){
			if (JFolder::exists($tmp_dest.DIRECTORY_SEPARATOR. $input -> getInt('id'))) {
				JFolder::copy($input -> getInt('id'), $data->id, $tmp_dest, true);
			}
		}

		// Delete all unnecessary image
		if (JFolder::exists($tmp_dest.DIRECTORY_SEPARATOR.$data->id)) {
			$img_server     =   JFolder::files($tmp_dest.DIRECTORY_SEPARATOR.$data->id, '.', false, false);
			if (count($img_server)) {
				foreach ($img_server as $img) {
					$img_flag   =   false;
					for($i = 0; $i<count($arr_server); $i++) {
						if ($arr_server[$i] -> image == $img) {
							$img_flag   =   true;
							break;
						}
					}
					if (!$img_flag) {
						JFile::delete($tmp_dest.DIRECTORY_SEPARATOR.$data->id.DIRECTORY_SEPARATOR.$img);

						//Delete resize file
						if (isset($image_size) && count($image_size)) {
							foreach ($image_size as $_size) {
								$size = json_decode($_size);

								$resizePath = $tmp_dest.DIRECTORY_SEPARATOR.$data->id.DIRECTORY_SEPARATOR.'resize' . DIRECTORY_SEPARATOR
									. JFile::stripExt($img)
									. '_' . $size->image_name_prefix . '.' . JFile::getExt($img);
								if (JFile::exists($resizePath)) {
									JFile::delete($resizePath);
								}
							}
						}
					}
				}
			}
		}

		// Move upload image from tmp to images folder
		for ($i = 0; $i<count($arr_client); $i++) {
			if (JFile::exists($tmp_part. '/' . $arr_client[$i] -> image)) {
				JFile::move($tmp_part. '/' . $arr_client[$i] -> image, $tmp_dest.DIRECTORY_SEPARATOR.$data->id.DIRECTORY_SEPARATOR.JFile::getName($arr_client[$i] -> image));
			}

			if (!JFolder::exists($tmp_dest.DIRECTORY_SEPARATOR.$data->id.DIRECTORY_SEPARATOR.'resize')) {
				JFolder::create($tmp_dest.DIRECTORY_SEPARATOR.$data->id.DIRECTORY_SEPARATOR.'resize');
			}

			if (isset($image_size) && count($image_size)) {
				foreach ($image_size as $_size) {
					$size = json_decode($_size);
					$tmpresizePath = $tmp_part.DIRECTORY_SEPARATOR.'resize' . DIRECTORY_SEPARATOR
						. JFile::stripExt($arr_client[$i] -> image)
						. '_' . $size->image_name_prefix . '.' . JFile::getExt($arr_client[$i] -> image);
					$resizePath = $tmp_dest.DIRECTORY_SEPARATOR.$data->id.DIRECTORY_SEPARATOR.'resize' . DIRECTORY_SEPARATOR
						. JFile::stripExt($arr_client[$i] -> image)
						. '_' . $size->image_name_prefix . '.' . JFile::getExt($arr_client[$i] -> image);
					if (JFile::exists($tmpresizePath)) {
						JFile::move($tmpresizePath, $resizePath);
					}
				}
			}
		}
		if (JFolder::exists($tmp_part)) {
			JFolder::delete($tmp_part);
		}

		$image_data             =   array();
		$image_data['url']     =   $gallery_images;
		$image_data['caption']    =   $gallery_title;
		$image_data['featured'] =   $featured_image;

		$this -> __save($data,$image_data);
	}

	public function delete(&$article){
		if($article){
			if(is_object($article)){
				if($article -> id && !empty($article -> id)) {
					$tmp_dest       =   JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'tz_portfolio_plus'.DIRECTORY_SEPARATOR.'image_gallery';

					jimport('joomla.filesystem.folder');
					if (JFolder::exists($tmp_dest.DIRECTORY_SEPARATOR.$article->id)) {
						JFolder::delete($tmp_dest.DIRECTORY_SEPARATOR.$article->id);
					}
				}
			}
		}
	}
}