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

if ($list):
    $id         =   uniqid('tzml');
    $javascript =   'anime.timeline({loop: true})';
	$doc->addStyleDeclaration('
        #'.$id.' .text-wrapper, #'.$id.' .text-container{text-align:'.$textalign.'}
    ');
    ?>
    <div id="<?php echo $id; ?>" class="tzml-container">
    <h2 class="tzml<?php echo $effect; ?>">
	    <?php require JModuleHelper::getLayoutPath('mod_tz_moving_letters', 'default_effect' . $effect); ?>
    </h2>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            <?php echo $javascript.';'; ?>
        });
    </script>
<?php endif; ?>