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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$app    = JFactory::getApplication();

//JFactory::getLanguage()->load('com_content');

// Create shortcuts to some parameters.
$item       = $this -> item;
$params		= $item->params;
$images     = json_decode($item->images);
$urls       = json_decode($item->urls);
$canEdit	= $item->params->get('access-edit');
JHtml::_('behavior.caption');
$user		= JFactory::getUser();
$doc        = JFactory::getDocument();
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/all.min.css');
$doc -> addStyleSheet(TZ_Portfolio_PlusUri::base(true).'/css/v4-shims.min.css');
$tzTemplate = TZ_Portfolio_PlusTemplate::getTemplate(true);
$tplParams = $tzTemplate->params;

$ratiofull      =   $tplParams->get('ratiofull','2:3');
list($rwidth,$rheight)  =   explode(':', $ratiofull);
$doc -> addScriptDeclaration (
        '
        jQuery(document).ready(function(){
            var profileHeight = (jQuery(".tpImage").width() * '.$rheight.') / '.$rwidth.';
            jQuery(".tpArticleMedia .tpImage").height(profileHeight);
        });
        '
);
?>

<div class="tpItemPage item-page<?php echo $this->pageclass_sfx?>"  itemscope itemtype="http://schema.org/Article">
    <meta itemprop="inLanguage" content="<?php echo ($item->language === '*') ? JFactory::getConfig()->get('language') : $item->language; ?>" />
    <?php if ($this->params->get('show_page_heading', 1)) : ?>
        <h2 class="tpHeadingTitle">
            <?php echo $this->escape($this->params->get('page_heading')); ?>
        </h2>
    <?php endif; ?>
    <?php
    if($this -> generateLayout && !empty($this -> generateLayout)) {
        echo $this->generateLayout;
    }else{
        ?>

        <div class="tpHead">
            <?php
            $image_display = false;
            if (trim($this->item->params ->get('mt_image_show_image_article',1))) :
                $image_display  =   true;
                echo $this -> loadTemplate('media');
            endif;
            ?>
            <div class="profiler-head<?php echo $image_display ? ' pw-7' : ''; ?>">
                <?php if($icons = $this -> loadTemplate('icons')):?>
                    <?php echo $this -> loadTemplate('icons');?>
                <?php endif;?>
                <?php if($title = $this -> loadTemplate('title')):?>
                    <?php echo $title;?>
                <?php endif;?>

                <div class="contact">
                    <?php if ($params->get('show_article_tpl_profiler_position',0) && $params->get('tpl_profiler_position','')) : ?>
                        <span class="position"><?php echo $params->get('tpl_profiler_position',''); ?></span>
                    <?php endif; ?>
                    <?php if ($params->get('show_article_tpl_profiler_email',0) && $params->get('tpl_profiler_email','')) : ?>
                        <span class="profiler-email"><i class="tps tp-at"></i> <a href="mailto:<?php echo $params->get('tpl_profiler_email',''); ?>"><?php echo $params->get('tpl_profiler_email',''); ?></a></span>
                    <?php endif; ?>
                    <?php if ($params->get('show_article_tpl_profiler_phone',0) && $params->get('tpl_profiler_phone','')) : ?>
                        <span class="profiler-phone"><i class="tps tp-phone"></i> <?php echo $params->get('tpl_profiler_phone',''); ?></span>
                    <?php endif; ?>
                    <?php if ($params->get('show_article_tpl_profiler_practice_area',0) && $params->get('tpl_profiler_practice_area','')) : ?>
                        <span class="practice_area"><i class="tpb tp-leanpub"></i> <?php echo $params->get('tpl_profiler_practice_area',''); ?></span>
                    <?php endif; ?>
                </div>

                <?php if ($params->get('show_article_tpl_profiler_description',0) && $params->get('tpl_profiler_description','')) : ?>
                    <div class="description"><?php echo $params->get('tpl_profiler_description',''); ?></div>
                <?php endif; ?>

                <?php if ($params->get('show_article_tpl_profiler_signature',0) && $params->get('tpl_profiler_signature','')) : ?>
                    <div class="signature"><img src="<?php echo $params->get('tpl_profiler_signature',''); ?>" /></div>
                <?php endif; ?>

                <?php if (($params->get('show_article_tpl_profiler_twitter',0) && $params->get('tpl_profiler_twitter','')) || ($params->get('show_article_tpl_profiler_facebook',0) && $params->get('tpl_profiler_facebook','')) || ($params->get('show_article_tpl_profiler_linkedin',0) && $params->get('tpl_profiler_linkedin','')) || ($params->get('show_article_tpl_profiler_google_plus',0) && $params->get('tpl_profiler_google_plus',''))) : ?>
                    <div class="profiler-social">
                        <?php if ($params->get('show_article_tpl_profiler_twitter',0) && $params->get('tpl_profiler_twitter','')) : ?>
                            <span class="profiler-twitter"><a href="https://twitter.com/<?php echo $params->get('tpl_profiler_twitter',''); ?>" target="_blank"><i class="tpb tp-twitter"></i></a></span>
                        <?php endif; ?>
                        <?php if ($params->get('show_article_tpl_profiler_facebook',0) && $params->get('tpl_profiler_facebook','')) : ?>
                            <span class="profiler-facebook"><a href="https://www.facebook.com/<?php echo $params->get('tpl_profiler_facebook',''); ?>" target="_blank"><i class="tp tp-facebook"></i></a></span>
                        <?php endif; ?>
                        <?php if ($params->get('show_article_tpl_profiler_linkedin',0) && $params->get('tpl_profiler_linkedin','')) : ?>
                            <span class="profiler-linkedin"><a href="https://www.linkedin.com/in/<?php echo $params->get('tpl_profiler_linkedin',''); ?>" target="_blank"><i class="tpb tp-linkedin-in"></i></a></span>
                        <?php endif; ?>
                        <?php if ($params->get('show_article_tpl_profiler_google_plus',0) && $params->get('tpl_profiler_google_plus','')) : ?>
                            <span class="profiler-google-plus"><a href="https://plus.google.com/+<?php echo $params->get('tpl_profiler_google_plus',''); ?>" target="_blank"><i class="tpb tp-google-plus-g"></i></a></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <div class="tpBody type-standard clearfix">
            <div class="tpArticle clearfix" itemprop="articleBody" data-blog-content>

                <?php if($introtext = $this -> loadTemplate('introtext')):?>
                    <?php echo $introtext;?>
                <?php endif;?>
                <?php if($fulltext = $this -> loadTemplate('fulltext')):?>
                    <?php echo $fulltext;?>
                <?php endif;?>
                <?php if($extrafields = $this -> loadTemplate('extrafields')):?>
                    <?php echo $extrafields;?>
                <?php endif;?>
                <?php if (trim($this->item->params ->get('project_link'))) : ?>
                    <div class="tpPortfolioLink"><a href="<?php echo $this->item->params ->get('project_link'); ?>" title="<?php echo $this->item->params ->get('project_link_title'); ?>" target="_blank" itemprop="url"><?php echo $this->item->params ->get('project_link_title'); ?></a></div>
                <?php endif; ?>
                <?php
                $plugins = array('hikashop_checkout','attachment','vote','social');
                $dispatcher = new JEventDispatcher();
                $html = '';
                foreach ($plugins as $plugin) {

                    if ($plugin_obj = TZ_Portfolio_PlusPluginHelper::getPlugin('content', $plugin)) {
                        $className = 'PlgTZ_Portfolio_PlusContent' . ucfirst($plugin);

                        if (!class_exists($className)) {
                            TZ_Portfolio_PlusPluginHelper::importPlugin('content', $plugin);
                        }
                        if (class_exists($className)) {
                            $registry = new JRegistry($plugin_obj->params);

                            $plgClass = new $className($dispatcher, array('type' => ($plugin_obj->type)
                            , 'name' => ($plugin_obj->name), 'params' => $registry));

                            if (method_exists($plgClass, 'onContentDisplayArticleView')) {
                                $html .= $plgClass->onContentDisplayArticleView('com_tz_portfolio_plus.'
                                    . $this->getName(), $this->item, $this->item->params
                                    , $this->state->get('list.offset'), '');
                            }
                        }
                        if (is_array($html)) {
                            $html .= implode("\n", $html);
                        }
                    }
                }
                echo $html;
                ?>
                <?php if($tag = $this -> loadTemplate('tags')):?>
                    <?php echo $tag;?>
                <?php endif;?>
            </div>

        </div>
        <?php
        $plugins = array('music','charity','googlemap','navigation');
        $dispatcher = new JEventDispatcher();
        $html = '';
        foreach ($plugins as $plugin) {

            if ($plugin_obj = TZ_Portfolio_PlusPluginHelper::getPlugin('content', $plugin)) {
                $className = 'PlgTZ_Portfolio_PlusContent' . ucfirst($plugin);

                if (!class_exists($className)) {
                    TZ_Portfolio_PlusPluginHelper::importPlugin('content', $plugin);
                }
                if (class_exists($className)) {
                    $registry = new JRegistry($plugin_obj->params);

                    $plgClass = new $className($dispatcher, array('type' => ($plugin_obj->type)
                    , 'name' => ($plugin_obj->name), 'params' => $registry));

                    if (method_exists($plgClass, 'onContentDisplayArticleView')) {
                        $html .= $plgClass->onContentDisplayArticleView('com_tz_portfolio_plus.'
                            . $this->getName(), $this->item, $this->item->params
                            , $this->state->get('list.offset'), '');
                    }
                }
                if (is_array($html)) {
                    $html .= implode("\n", $html);
                }
            }
        }
        if ($html) {
            echo '<div class="tpAddons">'.$html.'</div>';
        }
        if($about_author = $this -> loadTemplate('author_about')):
            echo $about_author;
        endif;
        if($related = $this -> loadTemplate('related')):
            echo $related;
        endif;
        $plugins = array('comment');
        $dispatcher = new JEventDispatcher();
        $html = '';
        foreach ($plugins as $plugin) {

            if ($plugin_obj = TZ_Portfolio_PlusPluginHelper::getPlugin('content', $plugin)) {
                $className = 'PlgTZ_Portfolio_PlusContent' . ucfirst($plugin);

                if (!class_exists($className)) {
                    TZ_Portfolio_PlusPluginHelper::importPlugin('content', $plugin);
                }
                if (class_exists($className)) {
                    $registry = new JRegistry($plugin_obj->params);

                    $plgClass = new $className($dispatcher, array('type' => ($plugin_obj->type)
                    , 'name' => ($plugin_obj->name), 'params' => $registry));

                    if (method_exists($plgClass, 'onContentDisplayArticleView')) {
                        $html .= $plgClass->onContentDisplayArticleView('com_tz_portfolio_plus.'
                            . $this->getName(), $this->item, $this->item->params
                            , $this->state->get('list.offset'), '');
                    }
                }
                if (is_array($html)) {
                    $html .= implode("\n", $html);
                }
            }
        }
        echo $html;
    }?>

    <?php

    //Call event onContentAfterDisplay on plugin
    //        echo $item->event->afterDisplayContent;
    ?>
</div>
