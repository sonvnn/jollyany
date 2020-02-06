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
$doc->addScriptDeclaration('var tzml4 = {};
tzml4.opacityIn = [0,1];
tzml4.scaleIn = [0.2, 1];
tzml4.scaleOut = 3;
tzml4.durationIn = 800;
tzml4.durationOut = 600;
tzml4.delay = 500;');
?>
<?php for ($i = 0; $i < count($list); $i++) : ?>
    <span class="letters letters-<?php echo ($i+1); ?>"><?php echo $list[$i]; ?></span>

	<?php
	$count  =   $i+1;
	$javascript .=   '
            .add({
    targets: \'#'.$id.' .letters-'.$count.'\',
    opacity: tzml4.opacityIn,
    scale: tzml4.scaleIn,
    duration: tzml4.durationIn
  }).add({
    targets: \'#'.$id.' .letters-'.$count.'\',
    opacity: 0,
    scale: tzml4.scaleOut,
    duration: tzml4.durationOut,
    easing: "easeInExpo",
    delay: tzml4.delay
  })
                ';
	?>
<?php endfor; ?>
<?php $javascript .= '.add({
    targets: \'#'.$id.'\',
    opacity: 0,
    duration: 500,
    delay: 500
  })';