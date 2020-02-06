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
if(isset($item) && isset($flipbook_gallery)):
	if ($flipbook_gallery->featured) {
		$image  =   $flipbook_gallery->featured;
	} else {
		$image  =   $flipbook_gallery->data[0];
	}
	$image_origin   =   'images/tz_portfolio_plus/flipbook_gallery/'.$item -> id.'/'.$image;
	jimport('joomla.filesystem.file');
	$image_size =   $params->get('mt_cat_flipbook_gallery_size','o');
	if ($image_size != 'o') {
		$image  =   'images/tz_portfolio_plus/flipbook_gallery/'.$item->id.'/resize/'
			. JFile::stripExt($image)
			. '_' . $image_size . '.' . JFile::getExt($image);
	} else {
		$image  =   'images/tz_portfolio_plus/flipbook_gallery/'.$item -> id.'/'.$image;
	}

	?>
    <div class="tz_portfolio_plus_flipbook_gallery">
        <img src="<?php echo $image;?>"
             alt="<?php echo $item -> title;?>"
             data-href="<?php echo JUri::root().$image_origin; ?>"
             data-type="image"
             itemprop="thumbnailUrl"/>
    </div>
	<?php
endif;
?>


