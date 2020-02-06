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
$doc    = JFactory::getDocument();
$tzTemplate = TZ_Portfolio_PlusTemplate::getTemplateById($params -> get('template_id'));
if (!$tzTemplate) $tzTemplate = TZ_Portfolio_PlusTemplate::getTemplate(true);
$tplParams = $tzTemplate->params;
$ratiointro      =   $tplParams->get('ratiointro','5:3');
list($rwidth,$rheight)  =   explode(':', $ratiointro);
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/all.min.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/v4-shims.min.css');
$doc -> addScript('https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js');
$doc->addScriptDeclaration('
(function($){
            "use strict";
            $(document).ready(function(){ 
                $(\'#module__' . $module->id . ' .owl-item\').map(function () {
                    var colHeight = ($(this).width() * '.$rheight.')/'.$rwidth.';
                    $(this).find(\'.TzArticleMedia\').height(colHeight);
                    $(this).find(\'.TzPortfolioDescription\').css(\'padding-top\',colHeight);
                });
                $(\'#module__' . $module->id . ' .TzInner>.profiler-intro\').each(function (i, el) {
                    $(el).width(jQuery(el).width()).height(jQuery(el).height());
                    $(el).find(\'.TzPortfolioDescription\').css(\'position\',\'absolute\').css(\'padding-top\',\'\');
                });
                $("#module__' . $module->id . ' .TzInner>.profiler-intro").each(function(i, el) {
                    var image_box = $(el).find(\'.TzArticleMedia\');
                    var current_height = $(image_box). height();
                    $(el).on("hover", function(event){
                        $(el).find(\'.TzPortfolioDescription\').fadeOut({
                            duration: 80,
                            complete: function () {
                                $( image_box ).animate({
                                        height: "100%"
                                    },
                                    {
                                        start: function () {
                                            $(el).find(\'.TzPortfolioDescription\').css(\'z-index\',\'0\');
                                        },
                                        complete : function () {
                                            $(el).find(\'.TzPortfolioDescription\').fadeIn({
                                                start : function () {
                                                    $(this).addClass(\'info-hover\');
                                                },
                                                duration: 200
                                            }).css(\'z-index\',\'3\');
                                        },
                                        easing: \'easeOutQuart\'
                                    });
                            }
                        });
        
                    });
                    $(el).on("mouseleave", function(event){
                        $(el).removeClass(\'dark_bg\');
                        $(el).find(\'.TzPortfolioDescription\').fadeOut({
                            complete: function () {
                                $( image_box ).animate({
                                    height: current_height
                                }, {
                                    start : function () {
                                        $(el).find(\'.TzPortfolioDescription\').css(\'z-index\',\'0\');
                                        $(el).find(\'.TzPortfolioDescription\').removeClass(\'info-hover\');
                                    },
                                    duration: 400,
                                    easing: \'easeOutBack\'
                                });
                            },
                            duration: 30
                        });
                    });
                });
                $("#module__' . $module->id . ' .owl-carousel").on(\'resized.owl.carousel\', function(event) {
                    $(\'#module__' . $module->id . ' .owl-item\').map(function () {
                        var colHeight = ($(this).width() * '.$rheight.')/'.$rwidth.';
                        $(this).find(\'.profiler-intro\').width($(this).width()-30).height($(this).height()-45);
                    });
                })
            });
            
        })(jQuery);
');
if($list){
?>
<div id="module__<?php echo $module -> id;?>" class="tplProfiler tpp-module-carousel tpp-module__carousel<?php echo $moduleclass_sfx;?>">
    <div class="owl-carousel owl-theme element">
        <?php foreach($list as $i => $item){
            // Get article's extrafields
            $extraFields    = TZ_Portfolio_PlusFrontHelperExtraFields::getExtraFields($item, null,
                false, array('filter.list_view' => true, 'filter.group' => $params -> get('order_fieldgroup', 'rdate')));
            $item -> extrafields    = $extraFields;
            $itemParams = new JRegistry();
            $itemParams->loadString($item -> attribs);
            ?>
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
        <?php } ?>
    </div>
</div>
<?php
}