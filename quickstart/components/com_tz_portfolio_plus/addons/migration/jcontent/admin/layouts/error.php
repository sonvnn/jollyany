<?php
/*------------------------------------------------------------------------

# TZ Portfolio Migration Add-On

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2011-2018 TZ Portfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

# Family website: http://www.templaza.com

# Family Support: Forum - https://www.templaza.com/Forums.html

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

if(isset($displayData['error']) && $error = $displayData['error']){
    $config = JFactory::getConfig();
?>
<h1 class="page-header"><?php echo JText::_('JERROR_AN_ERROR_HAS_OCCURRED'); ?></h1>
<blockquote>
        <span class="label label-inverse"><?php echo $error -> getCode(); ?></span><?php
        echo ' '.$error -> getMessage();?><br/><?php
    echo $error -> getFile();?>
</blockquote>
<?php if($config -> get('debug', 0)){
        echo JLayoutHelper::render('joomla.error.backtrace', array('backtrace' => $error->getTrace()));
} ?>
<?php
}
?>