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

if($params -> get('mt_show_video',1)):
    list($width, $height) = getimagesize($video -> thumbnail);
    ?>
    <div class="tpGallery">
        <div class="tpTools">
            <a class="tpZoom" href="<?php echo $video->url; ?>" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo $video -> thumbnail; ?>"
               title="<?php echo $item -> title;?>">
                <i class="tp tp-search"></i>
            </a>
        </div>
        <a href="<?php echo $item -> link; ?>">
            <img src="<?php echo $video -> thumbnail; ?>"
                 title="<?php echo ($video -> title) ? ($video -> title) : ($item->title); ?>"
                 alt="<?php echo ($video -> title) ? ($video -> title) : ($item->title); ?>"
                 itemprop="thumbnailUrl"/>
        </a>

    </div>
    <?php
endif;?>