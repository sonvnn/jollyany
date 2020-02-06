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
//$javascript =   'jQuery(\'#'.$id.' .text-wrapper\').each(function(){jQuery(this).css(\'margin-left\',-(jQuery(this).width()/2)+\'px\')});'. $javascript;
?>
<?php for ($i = 0; $i < count($list); $i++) :
	$strarray   =   preg_split('/[\s,]+/', $list[$i]);
	?>
	<span class="text-wrapper text<?php echo ($i+1); ?>">
		<?php for ($j = 0; $j < count($strarray); $j++) : ?>
			<span class="word"><?php echo $strarray[$j]; ?></span>
		<?php endfor; ?>
	</span>
	<?php
	$count  =   $i+1;
	$javascript .=   '
		.add({
		    targets: \'#'.$id.' .text'.$count.' .word\',
		    scale: [14,1],
		    opacity: [0,1],
		    easing: "easeOutCirc",
		    duration: 800,
		    delay: function(el, i) {
		      return 800 * i;
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