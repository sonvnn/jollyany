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
?>
    <div class="tpImage" itemprop="image" itemscope itemtype="https://schema.org/ImageObject">
        <?php if(isset($image -> url_detail) && trim($image -> url_detail)): ?>
            <div class="tz_portfolio_plus_image" style="background-image: url('<?php echo $image -> url_detail;?>');"></div>
        <?php  else : ?>
            <div class="tz_portfolio_plus_image" style="background-image: url('<?php echo $image -> url;?>');"></div>
        <?php endif; ?>
    </div>
<?php endif;