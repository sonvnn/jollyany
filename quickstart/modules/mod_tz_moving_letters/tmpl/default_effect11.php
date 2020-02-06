<?php
/*------------------------------------------------------------------------

# TZ Moving Letters

# ------------------------------------------------------------------------

# author   Sonny

# copyright Copyright (C) 2018 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - https://www.templaza.com/Forums.html

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;
$javascript =   'jQuery(\'#'.$id.' .text-wrapper\').each(function(){jQuery(this).html(jQuery(this).text().replace(/([^\x00-\x80]|\w|[\',\.\!\?])/g, "<span class=\'letter\'>$&</span>"));});'. $javascript;
?>
<?php for ($i = 0; $i < count($list); $i++) : ?>
	<span class="text-wrapper text<?php echo ($i+1); ?>">
		<?php echo $list[$i]; ?>
	</span>
	<?php
	$count  =   $i+1;
	$javascript .=   '
        .add({
		    targets: \'#'.$id.' .text'.$count.' .letter\',
		    translateX: [40,0],
		    translateZ: 0,
		    opacity: [0,1],
		    easing: "easeOutExpo",
		    duration: 1200,
		    delay: function(el, i) {
		      return 500 + 30 * i;
		    }
		}).add({
		    targets: \'#'.$id.' .text'.$count.' .letter\',
		    translateX: [0,-30],
		    opacity: [1,0],
		    easing: "easeInExpo",
		    duration: 1100,
		    delay: function(el, i) {
		      return 100 + 30 * i;
		    }
		})
		';
	?>
<?php endfor; ?>