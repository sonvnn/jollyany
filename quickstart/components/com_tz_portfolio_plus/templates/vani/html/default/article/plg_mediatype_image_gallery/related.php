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

$item   = $this -> item;
$params = $this -> params;

if($item && isset($this->image_gallery) && $slider = $this->image_gallery):
    if($params -> get('mt_image_related_show_image', 1)):
?>
    <a href="<?php echo $item -> link;?>"><div class="tz_portfolio_plus_image" style="background-image: url('<?php echo $slider->url[0];?>');">
        </div></a>
<?php
    endif;
endif;