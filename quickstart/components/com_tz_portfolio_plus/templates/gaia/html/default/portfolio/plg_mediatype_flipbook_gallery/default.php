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
if($params -> get('mt_cat_flipbook_gallery_show',1)):
	if($item   = $this -> item) {
		if (isset($this->flipbook_gallery) && ($flipbook_gallery = $this->flipbook_gallery) && isset($flipbook_gallery->data) && count($flipbook_gallery->data)) {
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
            <div class="tz_portfolio_plus_flipbook_gallery tpGallery" style="background-image: url('<?php echo $image;?>');">
                <div class="tpTools">
                    <a href="<?php echo $image_origin;?>" class="tpZoom" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo JUri::root().$image; ?>"
                       title="<?php echo $item -> title;?>">
                        <i class="tp tp-search"></i>
                    </a>
                </div>
                <a href="<?php echo $item -> link;?>">
                    <img src="<?php echo $image;?>"
                         alt="<?php echo $item -> title;?>"
                         title="<?php echo $item -> title;?>"
                         itemprop="thumbnailUrl"/>
                </a>
            </div>
			<?php
		}
	}
endif;
?>


