<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    DuongTVTemPlaza

# copyright Copyright (C) 2015 templaza.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;
$doc        = JFactory::getDocument();
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/all.min.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/v4-shims.min.css');
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
?>

<div class="tpBlog blog<?php echo $this->pageclass_sfx;?>" itemscope itemtype="http://schema.org/Blog">
    <?php if ($this->params->get('show_page_heading', 1)) : ?>
        <h1>
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>

    <?php if ($this->params->get('page_subheading')) : ?>
        <h2 class="TzCategoryTitle">
            <?php echo $this->escape($this->params->get('page_subheading')); ?>
        </h2>
    <?php endif; ?>

    <?php if($this->params -> get('use_filter_first_letter',0)):?>
        <div class="TzLetters">
            <?php echo $this -> loadTemplate('letters');?>
        </div>
    <?php endif;?>

    <?php $date = null;?>
    <?php if (!empty($this->items)) :
        ?>
        <div class="TzItemsRow">
            <?php
            foreach ($this->items as $key => &$item) : ?>

                <?php if(isset($item -> date_group) AND !empty($item -> date_group)
                    AND $date != strtotime(date(JText::_('COM_TZ_PORTFOLIO_PLUS_DATE_FORMAT_LC3'),strtotime($item -> date_group))) ):?>
                    <div class="date-group">
                        <div class="clearfix"></div>
                        <h2 class="text-info date"><?php echo JHtml::_('date',$item -> date_group,JText::_('COM_TZ_PORTFOLIO_PLUS_DATE_FORMAT_LC3'));?></h2>
                    </div>
                <?php endif;?>
                <div class="TzItem <?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
                     itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                    <div class="clr"></div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($this->link_items)) : ?>
        <?php echo $this->loadTemplate('links'); ?>
    <?php endif; ?>
    <div class="clearfix"></div>

    <?php if (($this->params->def('show_pagination', 1) == 1  || ($this->params->get('show_pagination', 1) == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
        <div class="pagination">
            <?php echo $this->pagination->getPagesLinks(); ?>

            <?php  if ($this->params->def('show_pagination_results', 1)) : ?>
                <p class="TzCounter">
                    <?php echo $this->pagination->getPagesCounter(); ?>
                </p>
            <?php endif; ?>
        </div>
    <?php  endif; ?>
    <div class="clearfix"></div>
</div>
