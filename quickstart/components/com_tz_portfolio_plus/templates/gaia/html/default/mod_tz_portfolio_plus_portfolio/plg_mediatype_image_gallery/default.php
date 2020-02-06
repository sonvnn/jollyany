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

if($params -> get('mt_show_image_gallery',1)):
    ?>
    <div class="tpGallery">
        <div class="tpTools">
            <a href="<?php echo $slider -> url[0];?>" class="tpZoom" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo $slider -> url[0]; ?>"
               title="<?php echo $item -> title;?>">
                <i class="tp tp-search"></i>
            </a>
        </div>
        <a href="<?php echo $item -> link; ?>">
            <img src="<?php echo $slider -> url[0]; ?>"
                 alt="<?php echo ($slider -> caption[0]) ? ($slider -> caption[0]) : ($item->title); ?>"
                 title="<?php echo ($slider -> caption[0]) ? ($slider -> caption[0]) : ($item->title); ?>"
                 itemprop="thumbnailUrl"/>
        </a>
    </div>
    <?php
endif;?>