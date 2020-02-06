<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

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

$user		= JFactory::getUser();
$userId		= $user->get('id');
$addonId    = $this -> state -> get($this -> getName().'.addon_id');

$this -> document -> addStyleSheet(TZ_Portfolio_PlusUri::root(true)
    .'/addons/migration/jcontent/admin/css/style.css');

?>

<form action="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)); ?>"
      method="post" name="adminForm" id="adminForm" class="form-horizontal tpp-addon__migrate">
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
        <div class="control-group">
            <div class="control-group tpContainer">
                <h2 class="heading"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_CONTENT');?></h2>
                <p class="muted"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_CONTENT_DESC');?></p>

                <?php if(!JComponentHelper::isInstalled($this -> component)){ ?>
                    <div class="alert alert-no-items">
                        <?php echo JText::sprintf('PLG_MIGRATION_JCONTENT_EXTENSION_ERROR_INSTALL'
                            , $this -> component, $this -> component); ?>
                    </div>
                <?php } ?>
            </div>

            <?php if(JComponentHelper::isInstalled($this -> component)){ ?>
            <?php if($statistics = $this -> statistics){ ?>
            <div class="control-group">
                <div class="row-fluid tpp-addon__migrate-flexbox statistic">
                    <div class="span4 item tpContainer">
                        <div class="left">
                            <span class="icon-file-check migrate-icon"></span>
                        </div>
                        <ul class="info unstyled">
                            <li class="number"><?php echo $statistics -> totalArticlesMigrated;
                                echo ($totalJArt = $statistics -> totalJArticles)?'/'.$totalJArt:''; ?></li>
                            <li><?php echo JText::plural('PLG_MIGRATION_JCONTENT_N_ARTICLES_MIGRATED',
                                    $statistics -> totalArticlesMigrated); ?></li>
                        </ul>
                    </div>
                    <div class="span4 item tpContainer">
                        <div class="left">
                            <span class="icon-folder-plus-2 migrate-icon"></span>
                        </div>
                        <ul class="info unstyled">
                            <li class="number"><?php echo $statistics -> totalCategoriesMigrated;
                                echo ($totalJCat = $statistics -> totalJCategories)?'/'.$totalJCat:''; ?></li>
                            <li><?php echo JText::plural('PLG_MIGRATION_JCONTENT_N_CATEGORIES_MIGRATED',
                                    $statistics -> totalCategoriesMigrated)?></li>
                        </ul>
                    </div>
                    <div class="span4 item tpContainer">
                        <div class="left">
                            <span class="icon-tags-2 migrate-icon"></span>
                        </div>
                        <ul class="info unstyled">
                            <ul class="info unstyled">
                                <li class="number"><?php echo $statistics -> totalTagsMigrated;
                                    echo ($totalJTag = $statistics -> totalJTags)?'/'.$totalJTag:''; ?></li>
                                <li><?php echo JText::plural('PLG_MIGRATION_JCONTENT_N_TAGS_MIGRATED',
                                        $statistics -> totalTagsMigrated); ?></li>
                            </ul>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } ?>

            <div class="control-group tpContainer">
                <h3 class="heading"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_STATISTICS');?>
                    <small class="muted btn-block small"><?php echo JText::_('PLG_MIGRATION_JCONTENT_HEADING_STATISTICS_LIST_DESC');?></small>
                    <hr/>
                </h3>
                <?php
                // Search tools bar
                echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
                ?>

                <?php if (empty($this->items)){ ?>
                    <div class="alert alert-no-items">
                        <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                    </div>
                <?php }else{ ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th width="1%" class="center">
                                <?php echo JHtml::_('grid.checkall'); ?>
                            </th>
                            <th width="1%" style="min-width:55px" class="nowrap center">
                                <?php echo JText::_('JSTATUS'); ?>
                            </th>
                            <th><?php echo JText::_('JGLOBAL_TITLE'); ?></th>
                            <th width="5%"><?php echo JText::_('COM_TZ_PORTFOLIO_PLUS_TYPE'); ?></th>
                            <th width="5%" class="nowrap"><?php echo JText::_('PLG_MIGRATION_JCONTENT_JOOMLA_ID'); ?></th>
                            <th width="1%" class="nowrap hidden-phone"><?php echo JText::_('PLG_MIGRATION_JCONTENT_ID_MIGRATED'); ?></th>
                            <th width="1%" class="nowrap hidden-phone"><?php echo JText::_('JGRID_HEADING_ID'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($this->items as $i => $item) {
                            $this -> item   = $item;
                            $canEdit = $user->authorise('core.edit', 'com_tz_portfolio_plus.article.' . $item->artId);
                            $canEditOwn = $user->authorise('core.edit.own', 'com_tz_portfolio_plus.article.' . $item->artId)
                                && $item->created_by == $userId;
                            ?>
                            <tr>
                                <td class="center">
                                    <?php echo JHtml::_('grid.id', $i, $item->id); ?>
                                </td>
                                <?php
                                switch($item -> meta_key) {
                                    case PLG_MIGRATION_JCONTENT_META_KEY_ARTICLE:
                                        echo $this -> loadTemplate('article');
                                        break;
                                    case PLG_MIGRATION_JCONTENT_META_KEY_TAG:
                                        echo $this -> loadTemplate('tag');
                                        break;
                                    case PLG_MIGRATION_JCONTENT_META_KEY_CATEGORY:
                                        echo $this -> loadTemplate('category');
                                        break;
                                } ?>
                                <td><?php echo $item -> id; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                    <?php echo $this->pagination->getListFooter(); ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>

    <input type="hidden" name="addon_task" value="" />
    <input type="hidden" value="0" name="boxchecked">
    <?php echo JHTML::_('form.token');?>
</form>
