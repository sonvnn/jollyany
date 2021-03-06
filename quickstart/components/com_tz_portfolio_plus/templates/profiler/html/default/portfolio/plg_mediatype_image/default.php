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
    <a href="<?php echo $item -> link;?>" title="<?php echo isset($image -> caption)?$image -> caption:$item -> title;?>"><div class="overlay"></div>
    <div class="tz_portfolio_plus_image" style="background-image: url('<?php echo $image -> url;?>');">
    </div>
    </a>
<?php endif;?>
