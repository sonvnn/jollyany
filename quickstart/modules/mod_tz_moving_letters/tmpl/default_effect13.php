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
$javascript =   'jQuery(\'#'.$id.' .letters\').each(function(){jQuery(this).html(jQuery(this).text().replace(/([^\x00-\x80]|\w|[\',\.\!\?])/g, "<span class=\'letter\'>$&</span>"));});'. $javascript;
?>
<?php for ($i = 0; $i < count($list); $i++) : ?>
	<div class="text-container">
		<span class="text-wrapper text<?php echo ($i+1); ?>">
		<span class="letters"><?php echo $list[$i]; ?></span>
		<span class="line"></span>
	</span>
	</div>

	<?php
	$count  =   $i+1;
	$javascript .=   '
        .add({
		    targets: \'#'.$id.' .text'.$count.' .line\',
		    scaleX: [0,1],
		    opacity: [0.5,1],
		    easing: "easeInOutExpo",
		    duration: 900
		}).add({
		    targets: \'#'.$id.' .text'.$count.' .letter\',
		    opacity: [0,1],
		    translateX: [40,0],
		    translateZ: 0,
		    scaleX: [0.3, 1],
		    easing: "easeOutExpo",
		    duration: 800,
		    offset: \'-=600\',
		    delay: function(el, i) {
		      return 150 + 25 * i;
		    }
		}).add({
		    targets: \'#'.$id.' .text'.$count.'\',
		    opacity: 0,
		    duration: 1000,
		    easing: "easeOutExpo",
		    delay: 1000
		})
		';
	?>
<?php endfor; ?>