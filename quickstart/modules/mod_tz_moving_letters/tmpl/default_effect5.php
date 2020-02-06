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
	$arrlen     =   count($strarray);
	if ($arrlen%3 == 0) {
		$letters_left   =   implode(' ', array_slice($strarray,0, $arrlen/3));
		$ampersand      =   implode(' ', array_slice($strarray,$arrlen/3, $arrlen/3));
		$letters_right  =   implode(' ', array_slice($strarray,($arrlen/3)*2, $arrlen/3));
	} else {
		$ampersand_len  =   ($arrlen%3 == 1) ? intval($arrlen/3)+1 : intval($arrlen/3);
		$letters_left   =   implode(' ', array_slice($strarray,0, ($arrlen-$ampersand_len)/2));
		$ampersand      =   $arrlen > 2 ? implode(' ', array_slice($strarray,($arrlen-$ampersand_len)/2, $ampersand_len)) : '';
		$letters_right  =   implode(' ', array_slice($strarray,($arrlen-$ampersand_len)/2+$ampersand_len, ($arrlen-$ampersand_len)/2));
	}
	?>
    <div class="text-container">
        <span class="text-wrapper text<?php echo ($i+1); ?>">
            <span class="line line1"></span>
            <span class="letters letters-left"><?php echo $letters_left; ?></span>
            <span class="letters ampersand"><?php echo $ampersand; ?></span>
            <span class="letters letters-right"><?php echo $letters_right; ?></span>
            <span class="line line2"></span>
        </span>
    </div>
	<?php
	$count  =   $i+1;
	$javascript .=   '
		.add({
		    targets: \'#'.$id.' .text'.$count.' .line\',
		    opacity: [0.5,1],
		    scaleX: [0, 1],
		    easing: "easeInOutExpo",
		    duration: 700
		  }).add({
		    targets: \'#'.$id.' .text'.$count.' .line\',
		    duration: 600,
		    easing: "easeOutExpo",
		    translateY: function(e, i, l) {
		      var offset = -0.625 + 0.625*2*i;
		      return offset + "em";
		    }
		  }).add({
		    targets: \'#'.$id.' .text'.$count.' .ampersand\',
		    opacity: [0,1],
		    scaleY: [0.5, 1],
		    easing: "easeOutExpo",
		    duration: 600,
		    offset: \'-=600\'
		  }).add({
		    targets: \'#'.$id.' .text'.$count.' .letters-left\',
		    opacity: [0,1],
		    translateX: ["0.5em", 0],
		    easing: "easeOutExpo",
		    duration: 600,
		    offset: \'-=300\'
		  }).add({
		    targets: \'#'.$id.' .text'.$count.' .letters-right\',
		    opacity: [0,1],
		    translateX: ["-0.5em", 0],
		    easing: "easeOutExpo",
		    duration: 600,
		    offset: \'-=600\'
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