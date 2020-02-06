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
    ?>
    <a data-fancybox href="<?php echo $video -> url;?>"><div class="tz_portfolio_plus_video">
            <img src="<?php echo $video -> thumbnail; ?>"
                 title="<?php echo ($video -> title) ? ($video -> title) : ($item->title); ?>"
                 alt="<?php echo ($video -> title) ? ($video -> title) : ($item->title); ?>"
                 data-href="<?php echo $video->url; ?>"
                 data-type="image"
                 itemprop="thumbnailUrl"/>
        </div></a>
    <?php
endif;?>