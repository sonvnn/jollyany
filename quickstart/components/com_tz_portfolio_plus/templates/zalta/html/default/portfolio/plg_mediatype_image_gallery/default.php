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
<div class="tz_portfolio_plus_image_gallery" style="background-image: url('<?php echo $slider -> url[0];?>');">
    <div class="ImageOverlayMg"></div>
    <div class="iconhover">
        <span class="white-rounded"><a class="popup-item" href="<?php echo $slider -> url[0];?>" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo $slider -> url[0]; ?>"><i class="tps tp-search"></i></a></span>
        <span class="white-rounded"><a href="<?php echo $item->link; ?>"><i class="tp tp-link"></i></a></span>
    </div>
</div>
<?php
        }
    }
endif;?>