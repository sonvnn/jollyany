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

//no direct access
defined('_JEXEC') or die();

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers');
$doc    = JFactory::getDocument();
$app        = JFactory::getApplication('site');
$input      = $app -> input;
$params = &$this -> params;
$tzTemplate = TZ_Portfolio_PlusTemplate::getTemplate(true);
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/all.min.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/v4-shims.min.css');
$doc -> addStyleSheet('components/com_tz_portfolio_plus/css/jquery.fancybox.min.css');
$doc -> addScript('components/com_tz_portfolio_plus/js/jquery.fancybox.min.js');
$doc -> addScript(TZ_Portfolio_PlusUri::base(true).'/templates/gaia/js/template.min.js');
$doc -> addScript(TZ_Portfolio_PlusUri::base(true).'/templates/gaia/js/lightbox.min.js');

$doc -> addScriptDeclaration('gaia('.$this->params.');');
?>

<?php if($this -> items):?>

    <?php
    $params = &$this -> params;
?>
<div id="tpPortfolio" class="tplgaia <?php echo $this->pageclass_sfx;?>">
    <?php if ($params->get('show_page_heading', 1)) : ?>
        <h1 class="page-heading">
            <?php echo $this->escape($params->get('page_heading')); ?>
        </h1>
    <?php endif; ?>

    <div id="tz_options" class="tpFilter clearfix">
        <?php if($params -> get('tz_show_filter',1)):?>
            <div class="option-combo">
                <div id="filter" class="option-set clearfix" data-option-key="filter">
                    <a href="#show-all" data-option-value="*" class="tpFilterItem"><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_SHOW_ALL');?></a>
                    <?php if($params -> get('tz_filter_type','tags') == 'tags'):?>
                        <?php echo $this -> loadTemplate('filter_tags');?>
                    <?php endif;?>
                    <?php if($params -> get('tz_filter_type','tags') == 'categories'):?>
                        <?php echo $this -> loadTemplate('filter_categories');?>
                    <?php endif;?>
                </div>
            </div>
        <?php endif;?>
        <?php if($params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'default'):?>
            <?php if($params -> get('show_limit_box',1)):?>
                <div class="TzShow">
                    <span class="title"><?php echo strtoupper(JText::_('JSHOW'));?></span>
                    <form name="adminForm" method="post" id="TzShowItems"
                          action="<?php echo JRoute::_('index.php?option=com_tz_portfolio_plus&view=portfolio&Itemid='.$this -> Itemid);?>">
                        <?php echo $this -> pagination -> getLimitBox();?>
                    </form>
                </div>
            <?php endif;?>
        <?php endif;?>
    </div>

    <div id="portfolio" class="super-list gaia-items variable-sizes clearfix"
         itemscope itemtype="http://schema.org/Blog">
        <?php echo $this -> loadTemplate('item');?>
    </div>

    <?php if($params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'default'):?>
        <?php if (($params->def('show_pagination', 1) == 1  || ($params->get('show_pagination', 1) == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
            <div class="pagination">
                <?php  if ($params->def('show_pagination_results', 1)) : ?>
                    <p class="counter">
                        <?php echo $this->pagination->getPagesCounter(); ?>
                    </p>
                <?php endif; ?>

                <?php echo $this->pagination->getPagesLinks(); ?>
            </div>
        <?php endif;?>
    <?php endif;?>

    <?php if($params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'ajaxButton'
        || $params -> get('tz_portfolio_plus_layout', 'ajaxButton') == 'ajaxInfiScroll'):?>
        <?php echo $this -> loadTemplate('infinite_scroll');?>
    <?php endif;?>
</div>
<?php
endif;