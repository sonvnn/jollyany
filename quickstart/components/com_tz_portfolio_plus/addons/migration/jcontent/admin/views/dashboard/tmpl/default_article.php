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
    $canEdit    = $user->authorise('core.edit', 'com_tz_portfolio_plus.article.' . $item->artId);
    $canEditOwn = $user->authorise('core.edit.own', 'com_tz_portfolio_plus.article.' . $item->artId)
        && $item->created_by == $userId;
?>
<td class="center">
    <span class="<?php echo $iconStates[$this->escape($item->state)]; ?>" aria-hidden="true"></span>
</td>
<td>
    <?php if ($canEdit || $canEditOwn){ ?>
        <a href="<?php echo JRoute::_('index.php?option=com_tz_portfolio_plus&task=article.edit&id='
            . $item->artId); ?>">
            <?php echo $this->escape($item->title); ?></a>
    <?php }else{ ?>
        <?php echo $this->escape($item->title); ?>
    <?php } ?>
    <div class="small">
        <div class="clearfix">
            <?php echo JText::sprintf('JGLOBAL_LIST_ALIAS', $this->escape($item->alias)); ?>
        </div>
        <?php echo JText::_('JCATEGORY').': '; ?>
        <strong><?php echo $this->escape($item -> catTitle); ?></strong>
        <br/><?php echo JText::_('PLG_MIGRATION_JCONTENT_JOOMLA_CATEGORY').': '; ?>
        <strong><?php echo $this->escape($item -> frgCatTitle); ?></strong>
    </div>
</td>
<td><?php echo JText::_('PLG_MIGRATION_JCONTENT_ARTICLE'); ?></td>
<td><?php echo $item -> frgId; ?></td>
<td><?php echo $item -> artId; ?></td>
<?php }