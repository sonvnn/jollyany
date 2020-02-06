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
if($params -> get('mt_cat_grid_gallery_show',1)):
	if($item   = $this -> item) {
		if (isset($this->grid_gallery) && ($grid_gallery = $this->grid_gallery) && isset($grid_gallery->data) && count($grid_gallery->data)) {
			if ($grid_gallery->featured) {
				$image  =   $grid_gallery->featured;
			} else {
				$image  =   $grid_gallery->data[0];
			}
			$image_origin   =   'images/tz_portfolio_plus/grid_gallery/'.$item -> id.'/'.$image;
			jimport('joomla.filesystem.file');
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
                <div class="ImageOverlayMg">
                    <div class="besley-title">
                        <h3 class="TzPortfolioTitle name" itemprop="name">
			                <?php if($params->get('cat_link_titles',1)) : ?>
                                <a href="<?php echo $item ->link; ?>"  itemprop="url">
					                <?php echo $item -> title; ?>
                                </a>
			                <?php else : ?>
				                <?php echo $item -> title; ?>
			                <?php endif; ?>
                        </h3>

                        <div class="iconhover">
                            <span class="white-rounded"><a class="popup-item" href="<?php echo $image_origin;?>" data-id="lightbox<?php echo $item -> id; ?>" data-thumb="<?php echo \JUri::root().$image; ?>"><i class="tps tp-search"></i></a></span>
                            <span class="white-rounded"><a href="<?php echo $item->link; ?>"><i class="tps tp-link"></i></a></span>
                        </div>
                    </div>
                </div>
            </div>
			<?php
		}
	}
endif;
?>


