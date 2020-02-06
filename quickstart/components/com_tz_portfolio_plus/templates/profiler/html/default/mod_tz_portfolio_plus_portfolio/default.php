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

if (!$tzTemplate) $tzTemplate = TZ_Portfolio_PlusTemplate::getTemplate(true);
$tplParams = $tzTemplate->params;
$ratiointro      =   $tplParams->get('ratiointro','5:3');
list($rwidth,$rheight)  =   explode(':', $ratiointro);
$doc -> addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');
if($params -> get('load_style', 0)) {
    $doc->addStyleSheet(JUri::base(true) . '/modules/'.$module -> module.'/css/basic.css');
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
            afterColumnWidth : function(colCount, colWidth){
                jQuery(\'#portfolio' . $module->id . ' .element\').map(function () {
                    var colHeight = (colWidth * '.$rheight.') / '.$rwidth.';
                    jQuery(this).find(\'.TzArticleMedia\').height(colHeight);
                    jQuery(this).find(\'.TzPortfolioDescription\').css(\'padding-top\',colHeight);
                });
                jQuery(\'.TzInner>.profiler-intro\').each(function (i, el) {
            jQuery(el).width(jQuery(el).width()).height(jQuery(el).height());
            jQuery(el).find(\'.TzPortfolioDescription\').css(\'position\',\'absolute\').css(\'padding-top\',\'\');
        });
        jQuery(".tplProfiler .TzInner>.profiler-intro").each(function(i, el) {
            var image_box = jQuery(el).find(\'.TzArticleMedia\');

            var current_height = jQuery(image_box). height();
            jQuery(el).on("hover", function(event){

                jQuery(el).find(\'.TzPortfolioDescription\').fadeOut({
                    duration: 80,
                    complete: function () {
                        jQuery( image_box ).animate({
                                height: "100%"
                            },
                            {
                                start: function () {
                                    jQuery(el).find(\'.TzPortfolioDescription\').css(\'z-index\',\'0\');
                                },
                                complete : function () {
                                    jQuery(el).find(\'.TzPortfolioDescription\').fadeIn({
                                        start : function () {
                                            jQuery(this).addClass(\'info-hover\');
                                        },
                                        duration: 200
                                    }).css(\'z-index\',\'3\');
                                },
                                easing: \'easeOutQuart\'
                            });
                    }
                });

            });
            jQuery(el).on("mouseleave", function(event){
                jQuery(el).removeClass(\'dark_bg\');
                jQuery(el).find(\'.TzPortfolioDescription\').fadeOut({
                    complete: function () {
                        jQuery( image_box ).animate({
                            height: current_height
                        }, {
                            start : function () {
                                jQuery(el).find(\'.TzPortfolioDescription\').css(\'z-index\',\'0\');
                                jQuery(el).find(\'.TzPortfolioDescription\').removeClass(\'info-hover\');
                            },
                            duration: 400,
                            easing: \'easeOutBack\'
                        });
                    },
                    duration: 30
                });

            });
        });
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
    <div id="TzContent<?php echo $module->id; ?>" class="tz_portfolio_plus_portfolio<?php echo $moduleclass_sfx;?> tplProfiler TzContent">
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
        <div id="portfolio<?php echo $module->id; ?>" class="masonry row ">
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
                $itemParams = new JRegistry();
                $itemParams->loadString($item -> attribs);
                ?>
                <div class="element <?php echo implode(' ', $item_filter)?>"
                     data-date="<?php echo strtotime($item -> created); ?>"
                     data-title="<?php echo $item -> title; ?>"
                     data-hits="<?php echo (int) $item -> hits; ?>"
                     itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
                    <div class="TzInner">
                        <?php if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))){ ?>
                            <div class="profiler-intro">
                                <?php
                                if(isset($item->event->onContentDisplayMediaType)){
                                    ?>
                                    <div class="TzArticleMedia">
                                        <?php echo $item->event->onContentDisplayMediaType;?>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="TzPortfolioDescription">
                                    <div class="header-box">
                                        <?php
                                        if ($params -> get('show_title', 1)) {
                                            echo '<h3 class="TzPortfolioTitle"><a href="' . $item->link . '">' . $item->title . '</a></h3>';
                                            ?>
                                            <?php if ($params->get('show_module_tpl_profiler_position',1) && $itemParams->get('tpl_profiler_position','')) : ?>
                                                <div class="position"><?php echo $itemParams->get('tpl_profiler_position',''); ?></div>
                                            <?php endif; ?>
                                            <?php if ($params->get('show_module_tpl_profiler_practice_area',0) && $itemParams->get('tpl_profiler_practice_area','')) : ?>
                                                <div class="practice_area"><i class="tpb tp-leanpub"></i> <?php echo $itemParams->get('tpl_profiler_practice_area',''); ?></div>
                                            <?php endif; ?>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <?php if (($params->get('show_module_tpl_profiler_phone',0) && $itemParams->get('tpl_profiler_phone','')) || ($params->get('show_module_tpl_profiler_email',0) && $itemParams->get('tpl_profiler_email','')) || ($params->get('show_module_tpl_profiler_twitter',0) && $itemParams->get('tpl_profiler_twitter','')) || ($params->get('show_module_tpl_profiler_facebook',0) && $itemParams->get('tpl_profiler_facebook','')) || ($params->get('show_module_tpl_profiler_linkedin',0) && $itemParams->get('tpl_profiler_linkedin','')) || ($params->get('show_module_tpl_profiler_google_plus',0) && $itemParams->get('tpl_profiler_google_plus',''))) : ?>
                                        <div class="information">
                                            <?php if ($params->get('show_module_tpl_profiler_email',0) && $itemParams->get('tpl_profiler_email','')) : ?>
                                                <div class="profiler-email"><a href="mailto:<?php echo $itemParams->get('tpl_profiler_email',''); ?>"><?php echo $itemParams->get('tpl_profiler_email',''); ?></a></div>
                                            <?php endif; ?>
                                            <?php if ($params->get('show_module_tpl_profiler_phone',0) && $itemParams->get('tpl_profiler_phone','')) : ?>
                                                <div class="profiler-phone"><i class="tps tp-phone"></i> <?php echo $itemParams->get('tpl_profiler_phone',''); ?></div>
                                            <?php endif; ?>
                                            <?php if (($params->get('show_module_tpl_profiler_twitter',0) && $itemParams->get('tpl_profiler_twitter','')) || ($params->get('show_module_tpl_profiler_facebook',0) && $itemParams->get('tpl_profiler_facebook','')) || ($params->get('show_module_tpl_profiler_linkedin',0) && $itemParams->get('tpl_profiler_linkedin','')) || ($params->get('show_module_tpl_profiler_google_plus',0) && $itemParams->get('tpl_profiler_google_plus',''))) : ?>
                                                <div class="profiler-social">
                                                    <?php if ($params->get('show_module_tpl_profiler_twitter',0) && $itemParams->get('tpl_profiler_twitter','')) : ?>
                                                        <span class="profiler-twitter"><a href="https://twitter.com/<?php echo $itemParams->get('tpl_profiler_twitter',''); ?>" target="_blank"><i class="tpb tp-twitter"></i></a></span>
                                                    <?php endif; ?>
                                                    <?php if ($params->get('show_module_tpl_profiler_facebook',0) && $itemParams->get('tpl_profiler_facebook','')) : ?>
                                                        <span class="profiler-facebook"><a href="https://www.facebook.com/<?php echo $itemParams->get('tpl_profiler_facebook',''); ?>" target="_blank"><i class="tp tp-facebook"></i></a></span>
                                                    <?php endif; ?>
                                                    <?php if ($params->get('show_module_tpl_profiler_linkedin',0) && $itemParams->get('tpl_profiler_linkedin','')) : ?>
                                                        <span class="profiler-linkedin"><a href="https://www.linkedin.com/in/<?php echo $itemParams->get('tpl_profiler_linkedin',''); ?>" target="_blank"><i class="tpb tp-linkedin-in"></i></a></span>
                                                    <?php endif; ?>
                                                    <?php if ($params->get('show_module_tpl_profiler_google_plus',0) && $itemParams->get('tpl_profiler_google_plus','')) : ?>
                                                        <span class="profiler-google-plus"><a href="https://plus.google.com/+<?php echo $itemParams->get('tpl_profiler_google_plus',''); ?>" target="_blank"><i class="tpb tp-google-plus-g"></i></a></span>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>