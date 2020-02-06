<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Carousel Module

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2011-2018 tzportfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - http://tzportfolio.com/forum

# Family website: http://www.templaza.com

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;
$tzTemplate = TZ_Portfolio_PlusTemplate::getTemplateById($params -> get('template_id'));
if (!$tzTemplate) $tzTemplate = TZ_Portfolio_PlusTemplate::getTemplate(true);
$tplParams = $tzTemplate->params;
$ratio      =   $tplParams->get('ratio','5:3');
list($rwidth,$rheight)  =   explode(':', $ratio);
$doc = JFactory::getDocument();
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/all.min.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/v4-shims.min.css');
$doc -> addStyleSheet('components/com_tz_portfolio_plus/css/jquery.fancybox.min.css');
$doc -> addScript('components/com_tz_portfolio_plus/js/jquery.fancybox.min.js');
$doc -> addScript(TZ_Portfolio_PlusUri::base(true).'/templates/gaia/js/lightbox.min.js');
$doc->addScriptDeclaration('
(function($){
            "use strict";
            $(document).ready(function(){ 
                gaia_lightbox();
            });
            
        })(jQuery);
');
if($list){
?>
<div id="module__<?php echo $module -> id;?>" class="tplgaia tpp-module-carousel tpp-module__carousel<?php echo $moduleclass_sfx;?>">
    <div class="owl-carousel owl-theme element">
        <?php foreach($list as $i => $item){
            ?>
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
	                        if ($params -> get('show_category_main', 1) || $params -> get('show_category_sec', 1)) :
		                        ?>
                                <div class="muted tpMeta">
                                    <div class="tpCategories"><i class="tp tp-folder-open"></i>
			                        <?php if($params -> get('show_category_main', 1)){ ?>
                                        <a href="<?php echo $item -> category_link; ?>"><?php echo $item -> category_title;
				                        ?></a><?php
			                        }
			                        if($params -> get('show_category_sec', 1) && $item -> second_categories
				                        && count($item -> second_categories)){
				                        foreach($item -> second_categories as $secCategory){
					                        ?><span class="tpp-module__carousel-separator">,</span>
                                            <a href="<?php echo $secCategory -> link; ?>"><?php echo $secCategory -> title; ?></a>
				                        <?php }
			                        }
			                        ?>
                                    </div>
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
        <?php } ?>
    </div>
	<?php if($params -> get('show_view_all', 0)){?>
        <div class="tpp-portfolio__action text-center">
            <a href="<?php echo $params -> get('view_all_link');?>"<?php echo ($target = $params -> get('view_all_target'))?' target="'
				.$target.'"':'';?> class="btn btn-primary btn-view-all"><?php
				echo $params -> get('view_all_text', 'View All Portfolios');?></a>
        </div>
	<?php } ?>
</div>
<?php
}