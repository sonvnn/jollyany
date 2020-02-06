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

JLoader::import('image_gallery',__DIR__.DIRECTORY_SEPARATOR.'libraries');

class PlgTZ_Portfolio_PlusMediaTypeImage_Gallery extends TZ_Portfolio_PlusPlugin
{
    protected $autoloadLanguage = true;

    // Display html for views in front-end.
    public function onContentDisplayMediaType($context, &$article, $params, $page = 0, $layout = null){
        if($article){
            if($media = $article -> media){
                if(isset($media -> image_gallery)){
                    $image_gallery  = clone($media -> image_gallery);
                    if(isset($image_gallery -> url) && !empty($image_gallery -> url)
                        && count($image_gallery -> url)){
                        $image_gallery -> thumb_url = array();
                        foreach($image_gallery -> url as $i => &$url) {
                            $image_url_ext  = JFile::getExt($url);
                            if($thumb_size = $params -> get('mt_img_gallery_thumb_size','o')){
                                $thumb_url      = str_replace('.' . $image_url_ext, '_' . $thumb_size . '.'
                                    . $image_url_ext, $url);
                                $thumb_url      = JURI::root() . $thumb_url;
                                $image_gallery -> thumb_url[$i] = $thumb_url;
                            }
                            if($size = $params -> get('mt_img_gallery_size','o')){
                                $image_url      = str_replace('.' . $image_url_ext, '_' . $size . '.'
                                    . $image_url_ext, $url);
                                $url            = JURI::root() . $image_url;
                            }
                        }
                    }
                    $this -> setVariable('slider', $image_gallery);
                }
            }
            $this -> setVariable('item', $article);
            return parent::onContentDisplayMediaType($context, $article, $params, $page, $layout);
        }
    }
}