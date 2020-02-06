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

class PlgTZ_Portfolio_PlusMediaTypeModelImage_Gallery extends TZ_Portfolio_PlusPluginModelAdmin
{

    // This function to upload and save data with data saved in com
    public function save($data){

        $app            = JFactory::getApplication();
        $input  = $app -> input;

        // Get params
        $params         = $this -> getState('params');

        $slider_max_key = 0;

        // Get some params
        $mime_types     = $params -> get('image_gallery_mime_type','image/jpeg,image/gif,image/png,image/bmp');
        $mime_types     = explode(',',$mime_types);
        $file_types     = $params -> get('image_gallery_file_type','bmp,gif,jpg,jpeg,png');
        $file_types     = explode(',',$file_types);
        $file_sizes     = $params -> get('image_gallery_file_size',10);
        $file_sizes     = $file_sizes * 1024 * 1024;

        // Get and Process data
        $image_data = $input -> get('jform', array(), 'array');

        if(isset($image_data['media'])) {
            if(isset($image_data['media'][$this->getName()])) {
                $image_data = $image_data['media'][$this->getName()];
            }else{
                $image_data = array();
            }
        }else{
            $image_data = array();
        }

        $media  = null;
        if($data -> media && !empty($data -> media)) {
            $media  = new JRegistry;
            $media -> loadString($data -> media);
            $media  = $media -> get($this -> getName());

            if(isset($media -> url) && !empty($media -> url)){
                $slider_max_key = PlgTZ_Portfolio_PlusMediaTypeImage_GalleryLibrary::getMaxKey($media -> url);
            }
        }

        // Remove Image file when tick to remove file box
        if(isset($image_data['url_remove']) && $image_data['url_remove']){

            // Before upload image to file must delete original file
            foreach($image_data['url_remove'] as $i => $url){

                // Set data when save as copy article
                if($input -> getCmd('task') == 'save2copy' && $input -> getInt('id')){
                    $image_data['url_remove'][$i]   = null;
                    $image_data['url'][$i]          = '';
                }

                if(isset($url) && !empty($url)) {
                    $old_ext        = JFile::getExt($url);
                    $file_not_ext   = preg_replace('/\.'. $old_ext.'$/i','',$url);

                    $image_url  = $file_not_ext.'_o'.'.'.$old_ext;
                    // Remove original image
                    if(JFile::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.str_replace('/',DIRECTORY_SEPARATOR,
                            $image_url))){
                        // Remove image resized
                        if($image_size = $params -> get('image_gallery_size')){

                            $image_size = $this -> prepareImageSize($image_size);

                            foreach($image_size as $_size){
                                $size           = json_decode($_size);
                                $image_url = $file_not_ext.'_' . $size->image_name_prefix. '.' . $old_ext;
                                JFile::delete(JPATH_ROOT.DIRECTORY_SEPARATOR.$image_url);
                            }
                        }

                        unset($image_data['url'][$i]);
                        unset($image_data['url_remove'][$i]);
                    }
                }

            }
        }

        // Upload images
        if($files = $input -> files -> get('jform', array(), 'array')) {

            $slider_files   = array();

            $_fileName      = ((!$data -> alias)?uniqid() .'tz_portfolio_plus_'.time():$data -> alias)
                                .'-'.$data -> id;

            // Get images data from form
            if(isset($files['media']) && isset($files['media'][$this -> getName()])){
                $files  = $files['media'][$this -> getName()];
                if (isset($files['url_client']) && !empty($files['url_client'])) {
                    $slider_files   = $files['url_client'];
                }
            }

            jimport('joomla.filesystem.file');

            // Upload images files
            if(count($slider_files)) {
                $image_gallery       = new JImage();

                foreach($slider_files as $i => $slide){

                    $filename       = null;
                    $original       = null;
                    $imageType      = null;
                    $tmp_name       = $slide['tmp_name'];

                    $slider_max_key ++;

                    // Save image with save as copy
                    if($input -> getCmd('task') == 'save2copy' && $input -> getInt('id')){
                        if(!isset($image_data['url_server'][$i])
                            || (isset($image_data['url_server'][$i]) && empty($image_data['url_server'][$i]))){
                            if(isset($image_data['url'][$i]) && $image_data['url'][$i]) {
                                $ext        = JFile::getExt($image_data['url'][$i]);
                                $path_copy  = str_replace('.'.$ext,'_o.'.$ext, $image_data['url'][$i]);
                                if(JFile::exists(JPATH_ROOT.DIRECTORY_SEPARATOR.$path_copy)) {
                                    $image_data['url_server'][$i]   = $path_copy;
                                    $image_data['url'][$i]          = '';
                                }
                            }
                        }
                    }

                    // Upload image from client if it have data
                    if(isset($tmp_name) && !empty($tmp_name)){
                        $imageType  = JFile::getExt($slide['name']);
                        $imageType  = strtolower($imageType);

                        //-- Check image information --//
                        // Check MIME Type
                        if (!in_array($slide['type'], $mime_types)) {
                            $app->enqueueMessage(JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_ERROR_WARNINVALID_MIME'), 'notice');
                            return false;
                        }

                        // Check file type
                        if (!in_array($imageType, $file_types)) {
                            $app->enqueueMessage(JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_ERROR_WARNFILETYPE'), 'notice');
                            return false;
                        }

                        // Check file size
                        if ($slide['size'] > $file_sizes) {
                            $app->enqueueMessage(JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_ERROR_WARNFILETOOLARGE'), 'notice');
                            return false;
                        }
                        //-- End check thumbnail information --//

                        // Before upload image to file must delete original file
                        if ($media && isset($media->url) && isset($media->url[$i]) && !empty($media->url[$i])) {
                            $slider_url     = $media->url[$i];
                            $slider_type    = JFile::getExt($slider_url);
                            $slider_url     = str_replace('.' . $slider_type, '_o'. '.' . $slider_type, $slider_url);

                            // Execute delete image
                            JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                    $slider_url));
                        }

                        $original   = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_ROOT . DIRECTORY_SEPARATOR . $_fileName
                                        .'-' . $slider_max_key . '_o.' . $imageType;

                        // Upload original thumbnail
                        if (JFile::upload($tmp_name, $original)) {
                            $filename   = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_BASE . '/'
                                            . $_fileName .'-' . $slider_max_key . '.' . $imageType;
                        }

                        if($input -> getCmd('task') == 'save2copy' && $input -> getInt('id')){
                            $image_data['url_server'][$i]   = null;
                        }
                    }
                    // Upload image from server
                    elseif(isset($image_data['url_server'][$i]) && !empty($image_data['url_server'][$i])) {

                        // Get image's ext
                        $imageType     = JFile::getExt($image_data['url_server'][$i]);

                        $image_gallery -> destroy();

                        $image_gallery -> loadFile(JPATH_ROOT . DIRECTORY_SEPARATOR
                            . $image_data['url_server'][$i]);

                        // Get image's server properties
                        $slider_property    = $image_gallery->getImageFileProperties($image_gallery->getPath());

                        //-- Check thumbnail information --//
                        // Check MIME Type
                        if (!in_array($slider_property->mime, $mime_types)) {
                            $app->enqueueMessage(JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_ERROR_WARNINVALID_MIME'), 'notice');
                            return false;
                        }

                        // Check file type
                        if (!in_array($imageType, $file_types)) {
                            $app->enqueueMessage(JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_ERROR_WARNFILETYPE'), 'notice');
                            return false;
                        }

                        // Check file size
                        if ($slider_property->filesize > $file_sizes) {
                            $app->enqueueMessage(JText::_('PLG_MEDIATYPE_IMAGE_GALLERY_ERROR_WARNFILETOOLARGE'), 'notice');
                            return false;
                        }
                        //-- End check thumbnail information --//

                        // Before upload image to file must delete original file
                        if ($media && isset($media->url) && isset($media->url[$i]) && !empty($media->url[$i])) {
                            $slider_url     = $media->url[$i];
                            $slider_type    = JFile::getExt($slider_url);
                            $slider_url     = str_replace('.' . $slider_type, '_o'. '.' . $slider_type, $slider_url);

                            // Execute delete image
                            JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                    $slider_url));
                        }

                        $original   = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_ROOT . DIRECTORY_SEPARATOR . $_fileName
                                        .'-' . $slider_max_key . '_o.' . $imageType;

                        // Upload original thumbnail
                        if (JFile::copy($image_gallery->getPath(), $original)) {
                            $filename   = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_BASE . '/' . $_fileName
                                            .'-' . $slider_max_key . '.' . $imageType;
                        }

                    }


                    // Upload image with resize
                    if($filename && !empty($filename)) {
                        if ($params && $image_size = $params->get('image_gallery_size')) {
                            $image_size = $this -> prepareImageSize($image_size);

                            if (JFile::exists($original)) {

                                $image_gallery -> destroy();
                                $image_gallery -> loadFile($original);

                                foreach ($image_size as $_size) {
                                    $size = json_decode($_size);

                                    // Before upload image to file must delete original file
                                    if ($media && isset($media->url) && isset($media->url[$i]) && !empty($media->url[$i])) {
                                        $slider_url     = $media->url[$i];
                                        $slider_type    = JFile::getExt($slider_url);
                                        $slider_url     = str_replace('.' . $slider_type, '_'
                                                            . $size -> image_name_prefix . '.'
                                                            . $slider_type, $slider_url);

                                        // Execute delete image
                                        JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                                $slider_url));
                                    }

                                    // Create new ratio from new with of image size param
                                    $sliderProperties   = $image_gallery->getImageFileProperties($original);
                                    $newH               = ($sliderProperties->height * $size->width) / ($sliderProperties->width);
                                    $newImage           = $image_gallery->resize($size->width, $newH);

                                    $newPath = COM_TZ_PORTFOLIO_PLUS_MEDIA_ARTICLE_ROOT . DIRECTORY_SEPARATOR
                                        . $_fileName . '-' . $slider_max_key
                                        . '_' . $size->image_name_prefix . '.' . $imageType;

                                    // Generate image to file
                                    $newImage->toFile($newPath, $sliderProperties->type);

                                }
                            }
                        }
                        $image_data['url'][$i] = $filename;
                    }
                }

            }

            // Check data and change keys of image slider data to store
            if(count($image_data)){
                $image_data['url']     = array_values($image_data['url']);
                $image_data['caption'] = array_values($image_data['caption']);
            }

        }

        unset($image_data['url_server']);

        $this -> __save($data,$image_data);

    }

    public function delete(&$article){
        if($article){
            if(is_object($article)){
                $media  = null;

                if($article -> media && !empty($article -> media)) {
                    $media  = new JRegistry;
                    $media -> loadString($article -> media);

                    $media  = $media -> get($this -> getName());

                    $params = $this -> getState('params');

                    if($media){
                        if(isset($media -> url) && !empty($media -> url)){
                            foreach($media -> url as $i => $url) {
                                if($url && !empty($url)) {
                                    // Delete original image
                                    $image_url = str_replace('.' . JFile::getExt($url),
                                        '_o.' . JFile::getExt($url), $url);
                                    JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                            $image_url));

                                    // Delete image with some size
                                    if($image_size = $params -> get('image_gallery_size', array())){

                                        $image_size = $this -> prepareImageSize($image_size);

                                        if(is_array($image_size) && count($image_size)){
                                            foreach($image_size as $_size){
                                                $size           = json_decode($_size);

                                                // Create file name and execute delete image
                                                $image_url = str_replace('.' . JFile::getExt($url), '_' . $size->image_name_prefix
                                                    . '.' . JFile::getExt($url), $url);
                                                JFile::delete(JPATH_ROOT . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR,
                                                        $image_url));
                                            }
                                        }
                                }
                            }
                        }

                        }
                    }
                }

            }
        }
    }
}