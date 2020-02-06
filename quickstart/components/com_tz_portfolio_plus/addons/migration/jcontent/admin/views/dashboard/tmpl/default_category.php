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
    $userId		= $user->get('id');
    $iconStates = $this -> getIconStates();
    $extension  = 'com_tz_portfolio_plus';
    $canEdit    = $user->authorise('core.edit',       $extension . '.category.' . $item->catid);
    $canEditOwn = $user->authorise('core.edit.own',   $extension . '.category.' . $item->catid) && $item-> created_user_id == $userId;
    ?>
    <td class="center">
        <span class="<?php echo $iconStates[$this->escape($item->cPublished)]; ?>" aria-hidden="true"></span>
    </td>
    <td>
        <?php if ($canEdit || $canEditOwn){ ?>
            <a href="<?php echo JRoute::_('index.php?option=com_tz_portfolio_plus&task=category.edit&id='.$item->catid
                . $item->artId); ?>">
                <?php echo $this->escape($item->catTitle); ?></a>
        <?php }else{ ?>
            <?php echo $this->escape($item->catTitle); ?>
        <?php } ?>
    </td>
    <td><?php echo JText::_('JCATEGORY'); ?></td>
    <td><?php echo $item -> frgCatid; ?></td>
    <td><?php echo $item -> catid; ?></td>
<?php }