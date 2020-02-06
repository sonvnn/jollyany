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
$lightboxopt=   $tplParams->get('lightbox_option',['zoom', 'slideShow', 'fullScreen', 'thumbs', 'close']);
if ($lightboxopt && is_array($lightboxopt)) {
	for ($i = 0 ; $i< count($lightboxopt); $i++) {
		$lightboxopt[$i]  =   '"'.$lightboxopt[$i].'"';
	}
	$lightboxopt=   is_array($lightboxopt) ? implode(',', $lightboxopt) : '';
} else {
	$lightboxopt=   '';
}
$doc = JFactory::getDocument();
$doc -> addStyleSheet('components/com_tz_portfolio_plus/css/jquery.fancybox.min.css');
$doc -> addScript('components/com_tz_portfolio_plus/js/jquery.fancybox.min.js');
$doc -> addStyleSheet('components/com_tz_portfolio_plus/css/all.min.css');
$doc -> addScript('components/com_tz_portfolio_plus/templates/zalta/js/lightbox.min.js');
$doc->addScriptDeclaration('
(function($){
            "use strict";
            $(document).ready(function(){ 
                $(\'#module__' . $module->id . ' .owl-item\').map(function () {
                    var colHeight = ($(this).width() * '.$rheight.')/'.$rwidth.';
                    $(this).find(\'.TzArticleMedia\').height(colHeight);
                });
                $("#module__' . $module->id . ' .owl-carousel").on(\'resized.owl.carousel\', function(event) {
                    $(\'#module__' . $module->id . ' .owl-item\').map(function () {
                        var colHeight = ($(this).width() * '.$rheight.')/'.$rwidth.';
                        $(this).find(\'.TzArticleMedia\').height(colHeight);
                    });
                });
                zalta_lightbox(['.$lightboxopt.']);
            });
            
        })(jQuery);
');
if($list){
?>
<div id="module__<?php echo $module -> id;?>" class="tplzalta tpp-module-carousel tpp-module__carousel<?php echo $moduleclass_sfx;?>">
    <div class="owl-carousel owl-theme element">
        <?php foreach($list as $i => $item){
            // Get article's extrafields
            $extraFields    = TZ_Portfolio_PlusFrontHelperExtraFields::getExtraFields($item, null,
                false, array('filter.list_view' => true, 'filter.group' => $params -> get('order_fieldgroup', 'rdate')));
            $item -> extrafields    = $extraFields;
            ?>
            <div class="TzInner">
                <?php
                if(isset($item->event->onContentDisplayMediaType)){
                    ?>
                    <div class="TzArticleMedia">
                        <?php echo $item->event->onContentDisplayMediaType;?>
                    </div>
                    <?php
                }
                if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))){
                    ?>
                    <div class="TzPortfolioDescription">
                        <div class="header-box">
                            <?php
                            if ($params -> get('show_title', 1)) {
                                echo '<h3 class="TzPortfolioTitle"><a href="' . $item->link . '">' . $item->title . '</a></h3>';
                            }

                            //Call event onContentBeforeDisplay on plugin
                            if(isset($item -> event -> beforeDisplayContent)) {
                                echo $item->event->beforeDisplayContent;
                            }

                            if($params -> get('show_author', 1) or $params->get('show_created_date', 1)
                                or $params->get('show_hit', 1) or $params->get('show_tag', 1)
                                or $params->get('show_category', 1)
                                or !empty($item -> event -> beforeDisplayAdditionInfo)
                                or !empty($item -> event -> afterDisplayAdditionInfo)) {
                                ?>
                                <div class="muted tpMeta">
                                    <?php
                                    if (isset($item->event->beforeDisplayAdditionInfo)) {
                                        echo $item->event->beforeDisplayAdditionInfo;
                                    }
                                    if($params -> get('show_category_main', 1) || $params -> get('show_category_sec', 1)){ ?>
                                        <div class="TZcategory-name">
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
                                            } ?>
                                        </div>
                                    <?php }
                                    if($params -> get('show_author', 1)){ ?>
                                        <div class="TzPortfolioCreatedby">
                                            <i class="tps tp-pencil-alt"></i>
                                            <a href="<?php echo $item -> authorLink;?>"><?php echo $item -> author;?></a>
                                        </div>
                                    <?php }
                                    if ($params->get('show_created_date', 1)) {
                                        ?>
                                        <div class="TzPortfolioDate" itemprop="dateCreated">
                                            <i class="tpr tp-clock"></i>
                                            <?php echo JHtml::_('date', $item->created, JText::_('DATE_FORMAT_LC')); ?>
                                        </div>
                                        <?php
                                    }
                                    if ($params->get('show_hit', 1)) {
                                        ?>
                                        <div class="TzPortfolioHits">
                                            <i class="tps tp-eye"></i>
                                            <?php echo $item->hits; ?>
                                            <meta itemprop="interactionCount" content="UserPageVisits:<?php echo $item->hits; ?>" />
                                        </div>
                                        <?php
                                    }
                                    if ($params->get('show_tag', 1)) {
                                        if (isset($tags[$item->content_id])) {
                                            echo '<div class="tz_tag"><i class="tps tp-tag"></i>&nbsp;';
                                            foreach ($tags[$item->content_id] as $t => $tag) {
                                                echo '<a href="' . $tag->link . '">' . $tag->title . '</a>';
                                                if ($t != count($tags[$item->content_id]) - 1) {
                                                    echo ', ';
                                                }
                                            }
                                            echo '</div>';
                                        }
                                    }

                                    if(isset($item -> event -> afterDisplayAdditionInfo)){
                                        echo $item -> event -> afterDisplayAdditionInfo;
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <?php
                        if(isset($item -> event -> contentDisplayListView)) {
                            echo $item->event->contentDisplayListView;
                        }
                        ?>
                    </div>
                <?php }
                ?>

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