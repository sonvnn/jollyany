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

$params = $this->params;
if($params -> get('mt_show_image_gallery',1)):
    if($item   = $this -> item) {
        if (isset($this->image_gallery) && $slider = $this->image_gallery) {
?>
<div class="tpGallery">
        <div class="tpTools">
            <a href="<?php echo $slider -> url[0];?>" class="tpZoom" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo $slider -> url[0]; ?>"
               title="<?php echo $item -> title;?>">
                <i class="tp tp-search"></i>
            </a>
        </div>
    <a href="<?php echo $this -> item -> link; ?>">
        <img src="<?php echo $slider -> url[0]; ?>"
             alt="<?php echo ($slider -> caption[0]) ? ($slider -> caption[0]) : ($this->item->title); ?>"
             title="<?php echo ($slider -> caption[0]) ? ($slider -> caption[0]) : ($this->item->title); ?>"
             itemprop="thumbnailUrl"/>
    </a>
</div>
<?php
        }
    }
endif;?>