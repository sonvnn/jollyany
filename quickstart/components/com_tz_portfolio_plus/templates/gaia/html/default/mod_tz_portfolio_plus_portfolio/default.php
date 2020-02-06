<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# author    TuanNATemPlaza

# copyright Copyright (C) 2015-2018 tzportfolio.com. All Rights Reserved.

# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

$tzTemplate = TZ_Portfolio_PlusTemplate::getTemplateById($params -> get('template_id'));

$doc = JFactory::getDocument();
$doc->addScript(JUri::root() . '/components/com_tz_portfolio_plus/js/tz_portfolio_plus.min.js');
$doc->addScript(JUri::root() . '/components/com_tz_portfolio_plus/js/jquery.isotope.min.js');
$doc->addStyleSheet(JUri::base(true) . '/components/com_tz_portfolio_plus/css/isotope.min.css');
$doc->addStyleSheet(JUri::base(true) . '/components/com_tz_portfolio_plus/css/tzportfolioplus.min.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/all.min.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/v4-shims.min.css');
$doc -> addStyleSheet('components/com_tz_portfolio_plus/css/jquery.fancybox.min.css');
$doc -> addScript('components/com_tz_portfolio_plus/js/jquery.fancybox.min.js');
$doc -> addScript(JUri::root() . '/components/com_tz_portfolio_plus/templates/gaia/js/lightbox.min.js');

$tplParams = $tzTemplate->params;

$ratio      =   $tplParams->get('ratio','5:3');
list($rwidth,$rheight)  =   explode(':', $ratio);

if($params -> get('load_style', 0)) {
    $doc->addStyleSheet(JUri::base(true) . '/modules/'.$module -> module.'/css/basic.css');
}
if ($params->get('height_element')) {
    $doc->addStyleDeclaration('
        #portfolio' . $module->id . ' .TzInner{
            height:' . $params->get('height_element') . 'px;
        }
    ');
}
if($params -> get('enable_resize_image', 0)){
    $doc -> addScript(JUri::base(true) . '/modules/'.$module -> module.'/js/resize.js');
    if ($params->get('height_element')) {
        $doc->addStyleDeclaration('
        #portfolio' . $module->id . ' .tzpp_media img{
            max-width: none;
        }
        #portfolio' . $module->id . ' .tzpp_media{
            height:' . $params->get('height_element') . 'px;
        }
    ');
    }
}
$doc->addScriptDeclaration('
jQuery(function($){
    $(document).ready(function(){
        $("#portfolio' . $module->id . '").tzPortfolioPlusIsotope({
            "mainElementSelector"       : "#TzContent' . $module->id . '",
            "containerElementSelector"  : "#portfolio' . $module->id . '",
            "sortParentTag"             : "filter'.$module->id.'",
            isotope_options             : {
                "filterSelector"            : "#tz_options'.$module -> id.' .option-set"
            },
            "params"                    : {
                "orderby_sec"           : "'.$params -> get('orderby_sec', 'rdate').'",
                "tz_column_width"       : ' . $params->get('width_element') . ',
                "tz_show_filter"        : ' . $params->get('show_filter', 1) . ',
                "tz_filter_type"        : "'.$params -> get('tz_filter_type', 'categories').'"
            },
            afterImagesLoaded       : function(){
                gaia_lightbox();
            } 
        });
    });
    $(window).load(function(){
        var $tzppisotope    = $("#portfolio' . $module->id . '").data("tzPortfolioPlusIsotope");
        if(typeof $tzppisotope === "object"){
            $tzppisotope.imagesLoaded(function(){
                $tzppisotope.tz_init();
            });
        }
    });
});
');
if ($list):
    ?>
    <div id="TzContent<?php echo $module->id; ?>" class="tz_portfolio_plus_portfolio<?php echo $moduleclass_sfx;?> tplgaia TzContent">
        <?php if($show_filter && isset($filter_tag) && isset($categories)):?>
            <div id="tz_options<?php echo $module -> id;?>" class="clearfix">
                <div class="option-combo">
                    <div id="filter<?php echo $module->id;?>" class="option-set clearfix" data-option-key="filter">
                        <a href="#show-all" data-option-value="*" class="btn btn-default btn-small selected"><?php echo JText::_('MOD_TZ_PORTFOLIO_PLUS_PORTFOLIO_SHOW_ALL');?></a>
                        <?php if($params->get('tz_filter_type','categories') == 'tags' && $filter_tag):?>
                            <?php foreach($filter_tag as $i => $itag):?>
                                <a href="#<?php echo $itag -> alias; ?>"
                                   class="btn btn-default btn-small"
                                   data-option-value=".<?php echo $itag -> alias; ?>">
                                    <?php echo $itag -> title;?>
                                </a>
                            <?php endforeach;?>
                        <?php endif;?>
                        <?php if($params->get('tz_filter_type','categories') == 'categories' && $filter_cat): ?>
                            <?php foreach($filter_cat as $i => $icat):?>
                                <a href="#<?php echo $icat -> alias; ?>"
                                   class="btn btn-default btn-small"
                                   data-option-value=".<?php echo $icat -> alias; ?>">
                                    <?php  echo $icat -> title;?>
                                </a>
                            <?php endforeach;?>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        <?php endif?>
        <div id="portfolio<?php echo $module->id; ?>" class="masonry row gaia-items">
            <?php foreach ($list as $i => $item) : ?>
                <?php
                $item_filter    = array();
                if ($params->get('tz_filter_type','') == 'tags' && isset($tags[$item->content_id]) && !empty($tags[$item->content_id])) {
                    $item_filter = ArrayHelper::getColumn($tags[$item->content_id], 'alias');
                }

                if ($params->get('tz_filter_type','') == 'categories' && isset($categories[$item->content_id]) && !empty($categories[$item->content_id])) {
                    if(isset($categories[$item->content_id])){
                        $item_filter    = ArrayHelper::getColumn($categories[$item->content_id], 'alias');
                    }
                }

                ?>
                <div class="element <?php echo implode(' ', $item_filter)?>"
                     data-date="<?php echo strtotime($item -> created); ?>"
                     data-title="<?php echo $item -> title; ?>"
                     data-hits="<?php echo (int) $item -> hits; ?>">
                    <div class="tp-item-box-container"<?php echo trim($tplParams->get('padding')) ? 'style="padding:'.$tplParams->get('padding').'px;"' : ''; ?>>
                        <div class="tp-thumb">
			                <?php

			                // Begin Icon print, Email or Edit
			                if ($params->get('show_cat_print_icon', 0) || $params->get('show_cat_email_icon', 0)
				                || $params -> get('access-edit')) : ?>
                                <div class="tp-item-tools">
                                    <div class="btn-group dropdown pull-right" role="presentation">
                                        <a class="btn dropdown-toggle"
                                           data-target="#" data-toggle="dropdown" href="javascript: void(0);">
                                            <i class="icon-cog"></i> <span class="caret"></span>
                                        </a>
                                        <ul class="dropdown-menu">
							                <?php if ($params->get('show_cat_print_icon', 0)) : ?>
                                                <li class="print-icon"> <?php echo JHtml::_('icon.print_popup', $item, $params); ?> </li>
							                <?php endif; ?>
							                <?php if ($params->get('show_cat_email_icon', 0)) : ?>
                                                <li class="email-icon"> <?php echo JHtml::_('icon.email', $item, $params); ?> </li>
							                <?php endif; ?>

							                <?php if ($params -> get('access-edit')) : ?>
                                                <li class="edit-icon"> <?php echo JHtml::_('icon.edit', $item, $params); ?> </li>
							                <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
			                <?php endif;
			                // End Icon print, Email or Edit
			                ?>
                            <div class="tpPortfolioDescription">
                                <div class="tpInfo">
					                <?php if($params -> get('show_title',1)): ?>
                                        <h3 class="TzPortfolioTitle name" itemprop="name">
                                            <a<?php if($params -> get('tz_use_lightbox', 1)){echo ' class="fancybox fancybox.iframe"';}?>
                                                    href="<?php echo $item ->link; ?>"  itemprop="url">
								                <?php echo $item -> title; ?>
                                            </a>
                                        </h3>
					                <?php endif;?>

					                <?php
					                //-- Start display some information --//
					                if ($params->get('show_category',0)) :
						                ?>
                                        <div class="muted tpMeta">
							                <?php
							                if ($params->get('show_category', 1)) {
								                if (isset($categories[$item->content_id]) && $categories[$item->content_id]) {
									                if (count($categories[$item->content_id]))
										                echo '<div class="tpCategories"><i class="tp tp-folder-open"></i>';
									                foreach ($categories[$item->content_id] as $c => $category) {
										                echo '<a itemprop="genre" href="' . $category->link . '">' . $category->title . '</a>';
										                if ($c != count($categories[$item->content_id]) - 1) {
											                echo ', ';
										                }
									                }
									                echo '</div>';
								                }
							                }
							                ?>
                                        </div>
						                <?php
					                endif;
					                //-- End display some information --//
					                ?>
                                </div>
                            </div>
			                <?php
			                // End Description and some info
			                if(isset($item->event->onContentDisplayMediaType)){
				                ?>
                                <div class="tpArticleMedia">
					                <?php echo $item->event->onContentDisplayMediaType;?>
                                </div>
				                <?php
			                }
			                ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
	    <?php if($params -> get('show_view_all', 0)){?>
            <div class="tpp-portfolio__action text-center">
                <a href="<?php echo $params -> get('view_all_link');?>"<?php echo ($target = $params -> get('view_all_target'))?' target="'
				    .$target.'"':'';?> class="btn btn-primary btn-view-all"><?php
				    echo $params -> get('view_all_text', 'View All Portfolios');?></a>
            </div>
	    <?php } ?>
    </div>
<?php endif; ?>