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
$tplParams = $tzTemplate->params;
$lightbox   =   $tplParams->get('lightbox',1);
$doc = JFactory::getDocument();
$doc -> addStyleSheet('components/com_tz_portfolio_plus/templates/amuda/css/jquery.fancybox.min.css');
$doc -> addScript('components/com_tz_portfolio_plus/templates/amuda/js/jquery.fancybox.min.js');
$doc -> addScript('components/com_tz_portfolio_plus/templates/amuda/js/lightbox.js');
$doc->addScriptDeclaration('
(function($){
            "use strict";
            $(document).ready(function(){ 
                amuda_lightbox();
            });
            
        })(jQuery);
');
if($list){
?>
<div id="module__<?php echo $module -> id;?>" class="tplAmuda tpp-module-carousel tpp-module__carousel<?php echo $moduleclass_sfx;?>">
    <div class="owl-carousel owl-theme element">
        <?php foreach($list as $i => $item){
	        if ($lightbox) {
		        $item->link =   JRoute::_(TZ_Portfolio_PlusHelperRoute::getArticleRoute($item -> slug, $item -> catid, $item->language).'&tmpl=component');
	        }
            ?>
            <div class="tp-item-box-container"<?php echo trim($tplParams->get('padding')) ? 'style="padding:'.$tplParams->get('padding').'px;"' : ''; ?>>
                <div class="tp-thumb">
			        <?php
			        if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))):
				        // Start Description and some info
				        ?>
                        <div class="tpPortfolioDescription">
					        <?php if($params -> get('show_title',1)): ?>
                                <h3 class="TzPortfolioTitle name" itemprop="name">
							        <?php if($params->get('cat_link_titles',1)) : ?>
                                        <a<?php if($lightbox){echo ' data-id="lightbox'.$item -> id.'" class="amudaLink"';}?>
                                                href="<?php echo $item ->link; ?>"  itemprop="url">
									        <?php echo $item -> title; ?>
                                        </a>
							        <?php else : ?>
								        <?php echo $item -> title; ?>
							        <?php endif; ?>
                                </h3>
					        <?php endif;?>

					        <?php
					        //-- Start display some information --//
					        if ($params->get('show_author',0) or $params->get('show_category',0)
						        or $params->get('show_created_date',0)
						        or $params->get('show_hit',0) or $params->get('show_tag',0)
						        or !empty($item -> event -> beforeDisplayAdditionInfo)
						        or !empty($item -> event -> afterDisplayAdditionInfo)) :
						        ?>
                                <div class="muted tpMeta">
							        <?php if (isset($item->event->beforeDisplayAdditionInfo)) {
								        echo $item->event->beforeDisplayAdditionInfo;
							        }?>
							        <?php if ($params->get('show_category',0)) : ?>
                                        <div class="tpCategories">
									        <?php
									        if (isset($categories[$item->content_id]) && $categories[$item->content_id]) {
										        if (count($categories[$item->content_id]))
											        echo '<i class="tp tp-folder-open"></i>';
										        foreach ($categories[$item->content_id] as $c => $category) {
											        echo '<a itemprop="genre" href="' . $category->link . '">' . $category->title . '</a>';
											        if ($c != count($categories[$item->content_id]) - 1) {
												        echo ', ';
											        }
										        }
									        }
									        ?>
                                        </div>
							        <?php endif; ?>
							        <?php
							        if ($params->get('show_tag', 0)) :
								        if (isset($tags[$item->content_id])) {
									        echo '<div class="tz_tag"><i class="fa fa-tag" aria-hidden="true"></i> ';
									        foreach ($tags[$item->content_id] as $t => $tag) {
										        echo '<a href="' . $tag->link . '">' . $tag->title . '</a>';
										        if ($t != count($tags[$item->content_id]) - 1) {
											        echo ', ';
										        }
									        }
									        echo '</div>';
								        }
							        endif;
							        ?>
							        <?php
							        if ($params->get('show_hit', 1)) {
								        ?>
                                        <div class="TzPortfolioHits">
                                            <i class="tp tp-eye"></i>
									        <?php echo $item->hits; ?>
                                            <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>" />
                                        </div>
								        <?php
							        } ?>

							        <?php if(isset($item -> event -> afterDisplayAdditionInfo)){
								        echo $item -> event -> afterDisplayAdditionInfo;
							        } ?>

                                </div>
						        <?php
					        endif;
					        //-- End display some information --//
					        ?>
                            <a<?php if($lightbox){echo ' data-id="lightbox'.$item -> id.'" class="amudaLink overlay"';} else { echo ' class="overlay"';}?> href="<?php echo $item->link; ?>"></a>
                        </div>
				        <?php
				        // End Description and some info
			        endif;?>
			        <?php
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
</div>
<?php
}