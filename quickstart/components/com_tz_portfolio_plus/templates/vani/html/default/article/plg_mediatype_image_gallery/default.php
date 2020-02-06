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
$tplParams = TZ_Portfolio_PlusTemplate::getTemplate(true)->params;
$subimage   =   $tplParams->get('subimage', 4);
$params = $this->params;
if($item   = $this -> item) {
	if (isset($this->image_gallery) && $slider = $this->image_gallery) {
		$doc    = JFactory::getDocument();
		if (count($slider -> url)) :
			?>
            <div class="tz_portfolio_plus_image_gallery">
                <div class="main-image">
                    <a data-fancybox="gallery" href="<?php echo $slider->url[0];?>"><div class="overlay"><i class="tps tp-search"></i></div></a>
                    <img src="<?php echo $slider->url[0];?>"
                         alt="<?php echo ($slider -> caption[0])?($slider -> caption[0]):($this -> item -> title);?>"
						<?php if(!empty($slider -> caption[0])):?>
                            title="<?php echo $slider -> caption[0];?>"
						<?php endif; ?>
                    />
	                <?php if($slider -> caption[0]): ?>
                        <p class="caption muted"><?php echo $slider -> caption[0];?></p>
	                <?php endif; ?>
                </div>
                <div class="tprow">
					<?php for($i = 1 ; $i < count($slider -> url); $i++):?>
                        <div class="tp-sm-<?php echo 12/$subimage; ?> tp-xs-6">
                            <div class="subimage">
                                <a data-fancybox="gallery" href="<?php echo $slider->url[$i];?>"><div class="overlay"><i class="tps tp-search"></i></div></a>
                                <div class="bgimage" style="background-image: url('<?php echo $slider -> url[$i];?>');"></div>
                            </div>
	                        <?php if($slider -> caption[$i]): ?>
                                <p class="caption muted"><?php echo $slider -> caption[$i];?></p>
	                        <?php endif; ?>
                        </div>
					<?php endfor; ?>
                </div>
            </div>
			<?php
		endif;
	}
}