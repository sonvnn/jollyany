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
if(isset($item) && isset($grid_gallery)):
	if ($grid_gallery->featured) {
		$image  =   $grid_gallery->featured;
	} else {
		$image  =   $grid_gallery->data[0];
	}
	jimport('joomla.filesystem.file');
	$image_origin   =   'images/tz_portfolio_plus/grid_gallery/'.$item -> id.'/'.$image;
	$image_size =   $params->get('mt_cat_grid_gallery_size','o');
	if ($image_size != 'o') {
		$image  =   'images/tz_portfolio_plus/grid_gallery/'.$item->id.'/resize/'
			. JFile::stripExt($image)
			. '_' . $image_size . '.' . JFile::getExt($image);
	} else {
		$image  =   'images/tz_portfolio_plus/grid_gallery/'.$item -> id.'/'.$image;
	}

	?>
    <div class="tz_portfolio_plus_grid_gallery" style="background-image: url('<?php echo $image;?>');">
        <div class="ImageOverlayMg"></div>
        <div class="iconhover">
            <span class="white-rounded"><a class="popup-item" href="<?php echo $image_origin;?>" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo JUri::root().$image; ?>"><i class="tps tp-search"></i></a></span>
            <span class="white-rounded"><a href="<?php echo $item->link; ?>"><i class="tps tp-link"></i></a></span>
        </div>
    </div>
	<?php
endif;
?>


