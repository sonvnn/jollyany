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
if($params -> get('mt_show_video',1)):
	if($item   = $this -> item) {
		if (isset($this->video) && $video = $this->video) {
			?>
            <div class="tz_portfolio_plus_video">
                <a href="<?php echo $this -> item -> link; ?>">
                    <img src="<?php echo $video -> thumbnail; ?>"
                         title="<?php echo ($video -> title) ? ($video -> title) : ($this->item->title); ?>"
                         alt="<?php echo ($video -> title) ? ($video -> title) : ($this->item->title); ?>"
                         data-href="<?php echo $video->url; ?>"
                         data-type="image"
                         itemprop="thumbnailUrl"/>
                </a>
            </div>
			<?php
		}
	}
endif;?>