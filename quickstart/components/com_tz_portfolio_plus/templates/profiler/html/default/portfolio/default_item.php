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

defined('_JEXEC') or die();

use Joomla\Utilities\ArrayHelper;

$doc    = JFactory::getDocument();

if($this -> items):
?>
    <?php foreach($this -> items as $i => $item):
        $this -> item   = $item;
        $params         = $item -> params;

        if($params -> get('tz_column_width',230))
            $tzItemClass    = ' tz_item';
        else
            $tzItemClass    = null;

        if($item -> featured == 1)
            $tzItemFeatureClass    = ' tz_feature_item';
        else
            $tzItemFeatureClass    = null;

        $class  = '';
        if($params -> get('tz_filter_type','tags') == 'tags'){
            if($item -> tags && count($item -> tags)){
                $alias  = ArrayHelper::getColumn($item -> tags, 'alias');
                $class  = implode(' ', $alias);
            }
        }
        elseif($params -> get('tz_filter_type','tags') == 'categories'){
            $class  = 'category'.$item -> catid;
            if(isset($item -> second_categories) && $item -> second_categories &&  count($item -> second_categories)) {
                foreach($item -> second_categories as $category){
                    $class  .= ' category'.$category -> id;
                }
            }
        }
        elseif($params -> get('tz_filter_type','tags') == 'letters'){
            $class  = mb_strtolower(mb_substr(trim($item -> title),0,1));
        }
    ?>
<div id="tzelement<?php echo $item -> id;?>"
     data-date="<?php echo strtotime($item -> created); ?>"
     data-title="<?php echo $this->escape($item -> title); ?>"
     data-hits="<?php echo (int) $item -> hits; ?>"
     class="element <?php echo $class.$tzItemClass.$tzItemFeatureClass;?>"
     itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">

    <div class="TzInner">
        <?php
        if(!isset($item -> mediatypes) || (isset($item -> mediatypes) && !in_array($item -> type,$item -> mediatypes))):
            ?>
            <div class="profiler-intro">
                <?php
                // Start Description and some info
                // Display media from plugin of group tz_portfolio_plus_mediatype
                echo $this -> loadTemplate('media');
                ?>
                <div class="TzPortfolioDescription">
                    <div class="header-box">
                        <?php if($params -> get('show_cat_title',1)): ?>
                            <h3 class="TzPortfolioTitle name" itemprop="name">
                                <?php if($params->get('cat_link_titles',1)) : ?>
                                    <a<?php if($params -> get('tz_use_lightbox', 1)){echo ' class="fancybox fancybox.iframe"';}?>
                                            href="<?php echo $item ->link; ?>"  itemprop="url">
                                        <?php echo $this->escape($item -> title); ?>
                                    </a>
                                <?php else : ?>
                                    <?php echo $this->escape($item -> title); ?>
                                <?php endif; ?>
                            </h3>
                            <?php if ($params->get('show_cat_tpl_profiler_position',0) && $params->get('tpl_profiler_position','')) : ?>
                                <div class="position"><?php echo $params->get('tpl_profiler_position',''); ?></div>
                            <?php endif; ?>
                            <?php if ($params->get('show_cat_tpl_profiler_practice_area',0) && $params->get('tpl_profiler_practice_area','')) : ?>
                                <div class="practice_area"><i class="tpb tp-leanpub"></i> <?php echo $params->get('tpl_profiler_practice_area',''); ?></div>
                            <?php endif; ?>
                        <?php endif;?>
                    </div>
                    <?php if (($params->get('show_cat_tpl_profiler_phone',0) && $params->get('tpl_profiler_phone','')) || ($params->get('show_cat_tpl_profiler_email',0) && $params->get('tpl_profiler_email','')) || ($params->get('show_cat_tpl_profiler_twitter',0) && $params->get('tpl_profiler_twitter','')) || ($params->get('show_cat_tpl_profiler_facebook',0) && $params->get('tpl_profiler_facebook','')) || ($params->get('show_cat_tpl_profiler_linkedin',0) && $params->get('tpl_profiler_linkedin','')) || ($params->get('show_cat_tpl_profiler_google_plus',0) && $params->get('tpl_profiler_google_plus',''))) : ?>
                        <div class="information">
                            <?php if ($params->get('show_cat_tpl_profiler_email',0) && $params->get('tpl_profiler_email','')) : ?>
                                <div class="profiler-email"><a href="mailto:<?php echo $params->get('tpl_profiler_email',''); ?>"><?php echo $params->get('tpl_profiler_email',''); ?></a></div>
                            <?php endif; ?>
                            <?php if ($params->get('show_cat_tpl_profiler_phone',0) && $params->get('tpl_profiler_phone','')) : ?>
                                <div class="profiler-phone"><i class="tps tp-phone"></i> <?php echo $params->get('tpl_profiler_phone',''); ?></div>
                            <?php endif; ?>
                            <?php if (($params->get('show_cat_tpl_profiler_twitter',0) && $params->get('tpl_profiler_twitter','')) || ($params->get('show_cat_tpl_profiler_facebook',0) && $params->get('tpl_profiler_facebook','')) || ($params->get('show_cat_tpl_profiler_linkedin',0) && $params->get('tpl_profiler_linkedin','')) || ($params->get('show_cat_tpl_profiler_google_plus',0) && $params->get('tpl_profiler_google_plus',''))) : ?>
                                <div class="profiler-social">
                                    <?php if ($params->get('show_cat_tpl_profiler_twitter',0) && $params->get('tpl_profiler_twitter','')) : ?>
                                        <span class="profiler-twitter"><a href="https://twitter.com/<?php echo $params->get('tpl_profiler_twitter',''); ?>" target="_blank"><i class="tpb tp-twitter"></i></a></span>
                                    <?php endif; ?>
                                    <?php if ($params->get('show_cat_tpl_profiler_facebook',0) && $params->get('tpl_profiler_facebook','')) : ?>
                                        <span class="profiler-facebook"><a href="https://www.facebook.com/<?php echo $params->get('tpl_profiler_facebook',''); ?>" target="_blank"><i class="tp tp-facebook"></i></a></span>
                                    <?php endif; ?>
                                    <?php if ($params->get('show_cat_tpl_profiler_linkedin',0) && $params->get('tpl_profiler_linkedin','')) : ?>
                                        <span class="profiler-linkedin"><a href="https://www.linkedin.com/in/<?php echo $params->get('tpl_profiler_linkedin',''); ?>" target="_blank"><i class="tpb tp-linkedin-in"></i></a></span>
                                    <?php endif; ?>
                                    <?php if ($params->get('show_cat_tpl_profiler_google_plus',0) && $params->get('tpl_profiler_google_plus','')) : ?>
                                        <span class="profiler-google-plus"><a href="https://plus.google.com/+<?php echo $params->get('tpl_profiler_google_plus',''); ?>" target="_blank"><i class="tpb tp-google-plus-g"></i></a></span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if (($params->get('show_cat_tpl_profiler_description',0) && $params->get('tpl_profiler_description','')) || ($params->get('show_cat_tpl_profiler_signature',0) && $params->get('tpl_profiler_signature',''))) : ?>
                <div class="profiler-desc">
                    <?php if ($params->get('show_cat_tpl_profiler_description',0) && $params->get('tpl_profiler_description','')) : ?>
                        <div class="description"><?php echo $params->get('tpl_profiler_description',''); ?></div>
                    <?php endif; ?>
                    <?php if ($params->get('show_cat_tpl_profiler_signature',0) && $params->get('tpl_profiler_signature','')) : ?>
                        <div class="signature"><img src="<?php echo $params->get('tpl_profiler_signature',''); ?>" /></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php
            // End Description and some info
        endif;?>


    </div>
</div>

    <?php endforeach;?>
<?php endif;?>
