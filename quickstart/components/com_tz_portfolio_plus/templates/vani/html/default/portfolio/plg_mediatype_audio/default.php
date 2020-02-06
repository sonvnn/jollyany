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
<div class="tpGallery" itemprop="audio" itemscope itemtype="http://schema.org/AudioObject">
    <img src="<?php echo $audio -> thumbnail;?>"
         alt="<?php echo $item -> title;?>"
         data-href="<?php echo $audio -> url; ?>"
         data-type="image"
         itemprop="thumbnailUrl"/>
</div>
<?php }
    }
endif;