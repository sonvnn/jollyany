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
if($params -> get('mt_show_video',1)):
    if($item   = $this -> item) {
        if (isset($this->video) && $video = $this->video) {
?>
<div class="tz_portfolio_plus_video" style="background-image: url('<?php echo $video -> thumbnail; ?>');">
    <div class="ImageOverlayMg"></div>
    <div class="iconhover">
        <span class="white-rounded"><a class="popup-item" href="<?php echo $video->url; ?>" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo $video -> thumbnail; ?>"><i class="tps tp-search"></i></a></span>
        <span class="white-rounded"><a href="<?php echo $item->link; ?>"><i class="tps tp-link"></i></a></span>
    </div>
</div>
<?php
        }
    }
endif;?>