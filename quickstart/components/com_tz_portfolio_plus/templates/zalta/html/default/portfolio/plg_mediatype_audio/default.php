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
if($params -> get('mt_show_cat_audio',1)):
    if($item   = $this -> item) {
        if (isset($this->audio) && $audio = $this->audio) {
?>
<div class="tpGallery" itemprop="audio" itemscope itemtype="http://schema.org/AudioObject" style="background-image: url('<?php echo $audio -> thumbnail; ?>');">
    <div class="ImageOverlayMg"></div>
    <div class="iconhover">
        <span class="white-rounded"><a class="popup-item" href="<?php echo $audio -> url;?>" data-id="lightbox<?php echo $item -> id; ?>" data-type="iframe" data-thumb="<?php echo $audio->thumbnail; ?>"><i class="tps tp-search"></i></a></span>
        <span class="white-rounded"><a href="<?php echo $item->link; ?>"><i class="tps tp-link"></i></a></span>
    </div>
</div>
<?php }
    }
endif;