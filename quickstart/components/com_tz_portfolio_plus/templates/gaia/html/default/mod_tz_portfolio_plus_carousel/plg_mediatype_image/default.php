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

if($item && $image && isset($image -> url) && !empty($image -> url)):
    $image_url  = $image -> url;
    $size = 'o';
    if (isset($item->media->image->url) && !empty($item->media->image->url)) {
        $image_url_ext = JFile::getExt($image->url);
        $image_url = str_replace('.' . $image_url_ext, '_' . $size . '.'
            . $image_url_ext, $item->media->image->url);
        $image_url = JURI::root() . $image_url;
    }
?>
    <div class="tpGallery">

        <div class="tpTools">
            <a href="<?php echo $image_url;?>" class="tpZoom" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo $image -> url; ?>"
               title="<?php echo $item -> title;?>">
                <i class="tp tp-search"></i>
            </a>
        </div>
        <a href="<?php echo $item->link; ?>">
            <img src="<?php echo $image -> url;?>"
                 alt="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
                 title="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
                 itemprop="thumbnailUrl"/>
        </a>
    </div>
<?php endif;?>
