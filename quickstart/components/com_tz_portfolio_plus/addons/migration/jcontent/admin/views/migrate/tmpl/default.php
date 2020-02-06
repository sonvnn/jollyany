<?php
/*------------------------------------------------------------------------

# JContent Migration Add-On

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2011-2018 TZ Portfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

# Family website: http://www.templaza.com

# Family Support: Forum - https://www.templaza.com/Forums.html

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

$addonId    = $this -> state -> get($this -> getName().'.addon_id');
$this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true)
    .'/addons/migration/jcontent/admin/css/style.css');
$this -> document -> addScriptDeclaration('
(function($){
    "use strict";
    $(document).ready(function(){
        $(".tpp-addon__migrate").addOnMigrationMigrate({
            ajaxSettings: {
                "url": "'.TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId).'"
            },
            "component": "'.$this -> component.'",
            addon_task: "migrate.migrate",
            basicTemplate: "<span class=\\"icon-power-cord\\"></span> '.JText::_('PLG_MIGRATION_JCONTENT_MIGRATE_NOW').'",
            loadingTemplate: "<span class=\\"icon-support tpp-spiner\\"></span> '.JText::_('PLG_MIGRATION_JCONTENT_MIGRATING').'"
        });
    });
})(jQuery);
');
?>
<div class="tpp-addon__migrate">
    <form action="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)); ?>"
          method="post" name="adminForm" id="adminForm" class="form-horizontal">
        <?php
        if(!empty($this -> sidebar)){
        ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this -> sidebar; ?>
        </div>
        <div id="j-main-container" class="span10">
            <?php }else{?>
            <div id="j-main-container">
                <?php }?>

                <div class="control-group tpContainer">
                    <h2 class="heading"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_CONTENT');?></h2>
                    <p class="muted"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_CONTENT_DESC');?></p>
                    <?php if(!$this -> form){ ?>
                    <div class="alert alert-no-items">
                        <?php echo JText::sprintf('PLG_MIGRATION_JCONTENT_EXTENSION_ERROR_INSTALL'
                            , ucwords($this -> component), ucwords($this -> component)); ?>
                    </div>
                    <?php } ?>
                </div>

                <div class="row-fluid">
                    <?php if($form = $this -> form){ ?>
                    <div class="span6 tpContainer">
                        <div class="control-group">
                            <h3 class="heading"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_BEFORE_MIGRATE');
                                ?><small class="muted btn-block small"><?php
                                    echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_BEFORE_MIGRATE_DESC'); ?></small>
                                <hr/>
                            </h3>
                        </div>
                        <?php
                        if($this -> component) {
                            echo $form -> renderField('frgCatid');
                            echo $form -> renderField('authorid');
                            echo $form -> renderField('frgState');
                            echo $form -> renderField('catid');
                        ?>
                        <?php } ?>
                        <button type="button" class="btn btn-primary" data-migrate-button><span class="icon-power-cord"></span> <?php
                            echo JText::_('PLG_MIGRATION_JCONTENT_MIGRATE_NOW'); ?></button>
                    </div>
                    <div class="span6">
                        <div class="control-group tpContainer">
                            <h3 class="heading"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_PROGRESS');
                            ?><small class="muted btn-block small"><?php
                                    echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_PROGRESS_DESC'); ?></small>
                                <hr/>
                            </h3>
                            <div data-progress-loading="" class="hide"><span class="icon-support tpp-spiner"></span> <?php
                                echo JText::_('PLG_MIGRATION_JCONTENT_MIGRATING');?></div>
                            <div data-progress-status=""><?php echo JText::_('PLG_MIGRATION_JCONTENT_NO_PROGRESS');?></div>
                        </div>
                        <div class="control-group tpContainer">
                            <h3 class="heading"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_STATISTICS');
                                ?><small class="muted btn-block small"><?php
                                    echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_STATISTICS_DESC'); ?></small>
                                <hr/>
                            </h3>
                            <div data-progress-stat=""></div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <input type="hidden" name="component" value="<?php echo $this -> component; ?>" />
            <input type="hidden" name="addon_task" value="" />
            <?php echo JHtml::_('form.token'); ?>
    </form>
</div>