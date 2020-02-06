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

if (!$this->print) :
    $doc    = JFactory::getDocument();

    $lists  = $this -> itemsRelated;
    // Create shortcuts to some parameters.
    $params		= $this->item->params;
    $tmpl       = null;
    if($lists):
        if($params -> get('show_related_article',1)):
?>
<!--     Start related       -->
<div class="tpRelated">
    <?php if($params -> get('show_related_heading',1)):?>
        <?php
            $title    = JText::_('COM_TZ_PORTFOLIO_PLUS_RELATED_ARTICLE');
            if($params -> get('related_heading')){
                $title  = $params -> get('related_heading');
            }
        ?>
        <div class="tpRelatedTitle">
            <h4 class="reset-heading"><?php echo $title;?></h4>
        </div>
    <?php endif;?>
    <?php foreach($lists as $i => $itemR):?>
        <?php if ($i % 2 ==0 ) echo '<div class="related">'; ?>
    <div class="tpItem<?php if($i % 2 == 0) echo ' odd'; else  echo ' even';?>">
        <div class="tpMediaRelated">
            <?php
            if($itemR->event->onContentDisplayMediaType && !empty($itemR->event->onContentDisplayMediaType)) {
	            echo $itemR->event->onContentDisplayMediaType;
            }
            ?>
        </div>
        <?php
        if($params -> get('show_related_title',1)){
        ?>
            <div class="tpRelatedDesc">
                <h3>
                    <a href="<?php echo $itemR -> link;?>"
                       class="tpTitle">
		                <?php echo $itemR -> title;?>
                    </a>
                </h3>
                <time class="muted"><?php echo JHtml::_('date', $itemR->publish_up, JText::_('DATE_FORMAT_LC'));?></time>
            </div>
        <?php
        }?>
    </div>
	    <?php if ($i % 2 !=0 ) echo '</div>'; ?>
    <?php
    endforeach;
    if (count($lists) % 2 != 0) echo '</div>';
    ?>

</div>
            <!--     End related        -->
        <?php endif;?>
    <?php endif;?>
<?php endif;?>