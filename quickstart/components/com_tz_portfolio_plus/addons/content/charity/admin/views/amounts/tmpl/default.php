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

//no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(COM_TZ_PORTFOLIO_PLUS_ADMIN_HELPERS_PATH.DIRECTORY_SEPARATOR.'html');

$user		= JFactory::getUser();

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
$saveOrder	= $listOrder == 'ordering';

$addonId    = $this -> state -> get($this -> getName().'.addon_id');

if ($saveOrder)
{
    $saveOrderingUrl = TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
        .'&addon_task=amounts.saveOrderAjax&tmpl=component';
    JHtml::_('tzsortablelist.sortable', 'addonDataList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId).'&addon_view=amounts');?>"
      method="post" name="adminForm" id="adminForm">

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

        <div class="tpContainer">
            <?php
            // Search tools bar
            echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));
            ?>

            <?php if (empty($this->items)){ ?>
                <div class="alert alert-no-items">
                    <?php echo JText::_('JGLOBAL_NO_MATCHING_RESULTS'); ?>
                </div>
            <?php }else{ ?>
            <table class="table table-striped"  id="addonDataList">
                <thead>
                <tr>
                    <th width="1%" class="nowrap center">
                        <?php echo JHtml::_('searchtools.sort','','ordering',$listDirn,$listOrder,null,'asc','JGRID_HEADING_ORDERING', 'icon-menu-2');?>
                    </th>
                    <th width="1%" class="hidden-phone">
                        <?php echo JHtml::_('grid.checkall');?>
                    </th>
                    <th width="1%" class="nowrap center" style="min-width: 55px;">
                        <?php echo JHtml::_('searchtools.sort','JSTATUS','published',$listDirn,$listOrder);?>
                    </th>
                    <th class="nowrap">
                        <?php echo JHtml::_('searchtools.sort','JGLOBAL_TITLE','value.title',$listDirn,$listOrder);?>
                    </th>
                    <th class="nowrap">
                        <?php echo JHtml::_('searchtools.sort','JGLOBAL_FIELDSET_DISPLAY_PRICE','value.price',$listDirn,$listOrder);?>
                    </th>
                    <th class="nowrap" width="1%">
                        <?php echo JHtml::_('searchtools.sort','JGRID_HEADING_ID','id',$listDirn,$listOrder);?>
                    </th>
                </tr>
                </thead>

                <?php if($items = $this->items): ?>
                <tbody>

                <?php foreach($items as $i => $data):
                    $canEdit    = $user->authorise('tzportfolioplus.edit',      'com_tz_portfolio_plus.addon.'.$addonId);
                    $canCheckin = $user->authorise('core.manage',     'com_checkin')
                        || (isset($data->checked_out) && ($data->checked_out == $user -> id || $data -> checked_out == 0));
                    $canChange  = $user->authorise('tzportfolioplus.edit.state',
                            'com_tz_portfolio_plus.addon.'.$addonId) && $canCheckin;
                    $item       = $data->value;
                ?>
                    <tr class="row<?php echo $i%2;?>" sortable-group-id="<?php echo $data->extension_id;?>">
                        <td class="order nowrap center hidden-phone">
                            <?php
                                $iconClass  = '';
                                if($canChange) {
                                    $iconClass  = ' inactive';
                                }elseif(!$saveOrder) {
                                    $iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
                                }
                            ?>
                            <span class="sortable-handler<?php echo $iconClass;?>">
                                <span class="icon-menu"></span>
                            </span>
                            <?php if($canChange && $saveOrder):?>
                                <input type="text" style="display: none" name="order[]" size="5" />
                            <?php endif;?>
                        </td>
                        <td class="center">
                            <?php echo JHtml::_('grid.id', $i,$data->id,false,'cid');?>
                        </td>
                        <td class="center">
                            <div class="btn-group">
                                <?php echo JHtml::_('jgrid.published',$data->published,$i,'amounts.',$canChange,'cb');?>
                            </div>
                        </td>
                        <td>
                            <?php
                            if (isset($data->checked_out) && $data->checked_out){?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $data->editor, $data-> checked_out_time, 'currencies.', $canCheckin); ?>
                            <?php } ?>
                            <?php if($canEdit){?>
                                <a href="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
                                .'&addon_task=amount.edit&id='.(int)$data->id);?>">
                                    <?php echo $this->escape($item->title);?>
                                </a>
                            <?php }else{?>
                                <?php echo $this->escape($item->title);?>
                            <?php }?>
                        </td>
                        <td>
                            <?php echo $item -> price;?>
                        </td>
                        <td width="1%">
                            <?php echo $data -> id;?>
                        </td>
                    </tr>
                <?php
                endforeach; ?>

                </tbody>
                <?php endif;?>

                <tfoot>
                <tr>
                    <td colspan="6">
                        <?php echo $this -> pagination -> getListFooter();?>
                    </td>
                </tr>
                </tfoot>
            </table>
            <?php }?>
        </div>
    </div>

    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="addon_task" value="" />
    <?php echo JHtml::_('form.token'); ?>

</form>