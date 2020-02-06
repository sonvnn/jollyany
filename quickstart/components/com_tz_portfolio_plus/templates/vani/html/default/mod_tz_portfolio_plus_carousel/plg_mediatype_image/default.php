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

if($item && $image && isset($image -> url) && !empty($image -> url)):
	$image_url  = $image -> url;
	$size = 'o';
	if (isset($image->temp) && !empty($image->temp)) {
		$image_url_ext = JFile::getExt($image->temp);
		$image_url = str_replace('.' . $image_url_ext, '_' . $size . '.'
			. $image_url_ext, $image->temp);
		$image_url = JURI::root() . $image_url;
	}
?>
    <a href="<?php echo $image -> url;?>"><div class="tz_portfolio_plus_image">
            <img src="<?php echo $image -> url;?>"
                 alt="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
                 title="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"
                 data-href="<?php echo $image_url; ?>"
                 data-type="image"
                 itemprop="thumbnailUrl"/>
        </div></a>
<?php endif;?>
