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
$image  = $this -> image;
$params = $this -> params;

if($item && $image && isset($image -> url) && !empty($image -> url)):
    $image_url  = $image -> url;
    $width = $height = 0;
    $size = 'o';
    if (isset($image->temp) && !empty($image->temp)) {
        $image_url_ext = JFile::getExt($image->temp);
        $image_url = str_replace('.' . $image_url_ext, '_' . $size . '.'
            . $image_url_ext, $image->temp);
        list($width, $height) = getimagesize(JPATH_ROOT.DIRECTORY_SEPARATOR.$image_url);
        $image_url = JURI::root() . $image_url;
    }
?>
    <div class="tz_portfolio_plus_image" style="background-image: url('<?php echo $image -> url;?>');">
        <div class="ImageOverlayMg"></div>
        <div class="iconhover">
            <span class="white-rounded"><a class="popup-item" href="<?php echo $image_url;?>" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo $image -> url; ?>"><i class="tps tp-search"></i></a></span>
            <span class="white-rounded"><a href="<?php echo $item->link; ?>"><i class="tps tp-link"></i></a></span>
        </div>
    </div>
<?php endif;?>