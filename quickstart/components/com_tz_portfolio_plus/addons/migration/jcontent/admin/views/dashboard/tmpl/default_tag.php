<?php
/*------------------------------------------------------------------------

# JContent Migration Add-On

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

if($item = $this -> item){
    $user		= JFactory::getUser();
    $iconStates = $this -> getIconStates();
    $canEdit    = $user->authorise('core.edit',       'com_tz_portfolio_plus.tag');
    ?>
    <td class="center">
        <span class="<?php echo $iconStates[$this->escape($item->tagPublished)]; ?>" aria-hidden="true"></span>
    </td>
    <td>
        <?php if($canEdit){ ?>
            <a href="index.php?option=com_tz_portfolio_plus&task=tag.edit&id=<?php echo $item -> tagId;?>">
                <?php echo $this -> escape($item -> tagTitle);?>
            </a>
        <?php }else{ ?>
            <?php echo $this -> escape($item -> tagTitle);?>
        <?php } ?>
    </td>
    <td><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_TAG'); ?></td>
    <td><?php echo $item -> frgTagId; ?></td>
    <td><?php echo $item -> tagId; ?></td>
<?php }