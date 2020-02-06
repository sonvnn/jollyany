<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 3/9/2016
 * Time: 9:03 AM
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(COM_TZ_PORTFOLIO_PLUS_ADMIN_HELPERS_PATH.DIRECTORY_SEPARATOR.'html');

$user       = JFactory::getUser();

$listOrder  = $this -> escape($this -> state -> get('list.ordering'));
$listDirn   = $this -> escape($this -> state -> get('list.direction'));
$saveOrder	= $listOrder == 'ordering';

$addonId    = $this -> state -> get($this -> getName().'.addon_id');

if($saveOrder) {
    $saveOrderingUrl    = TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
        . '&addon_task=donates.saveOrderAjax&tmpl=component';
    JHtml::_('tzsortablelist.sortable', 'addonDataList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}
?>
<form action="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId).'&addon_view=donates');?>"
      method="post" name="adminForm" id="adminForm">
    <?php
        if(!empty($this -> sidebar)) {
        ?>
        <div id="j-sidebar-container" class="span2">
            <?php echo $this -> sidebar;?>
        </div>
        <div id="j-main-container" class="span10">
    <?php
        }else { ?>
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
                        <td width="1%" class="nowrap center">
                            <?php echo JHtml::_('grid.sort','<span class="icon-menu-2"></span>','ordering',$listDirn,$listOrder,null,'asc','JGRID_HEADING_ORDERING');?>
                        </td>
                        <td width="1%" class="hidden-phone">
                            <?php echo JHtml::_('grid.checkall');?>
                        </td>
                        <th class="nowrap">
                            <?php echo JHtml::_('grid.sort','JGLOBAL_NAME','value.firstname',$listDirn,$listOrder);?>
                        </th>
                        <th class="nowrap">
                            <?php echo JHtml::_('grid.sort','JGLOBAL_EMAIL','value.email',$listDirn,$listOrder)?>
                        </th>
                        <th class="nowrap">
                            <?php echo JHtml::_('grid.sort','JGLOBAL_AMOUNT','value.money_donate',$listDirn,$listOrder)?>
                        </th>
                        <td width="nowrap" class="nowrap" style="min-width: 100px">
                            <?php echo JText::_('JFIELD_PLG_CONTENT_TITLE');?>
                        </td>
                        <th width="1%" class="nowrap center" style="min-width: 55px;">
                            <?php echo JHtml::_('grid.sort','JSTATUS','published',$listDirn,$listOrder);?>
                        </th>
                        <th class="nowrap" width="1%">
                            <?php echo JHtml::_('grid.sort','JGRID_HEADING_ID','id',$listDirn,$listOrder);?>
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
                        <td>
                            <?php
                            if (isset($data->checked_out) && $data->checked_out){?>
                                <?php echo JHtml::_('jgrid.checkedout', $i, $data->editor, $data-> checked_out_time, 'donates.', $canCheckin); ?>
                            <?php } ?>
                            <?php if($canEdit){?>
                                <a href="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
                                    .'&addon_task=donate.edit&id='.(int)$data->id);?>">
                                    <?php
                                        if(isset($item->first_name)) {
                                            echo $this->escape($item->first_name).' ';
                                        }
                                        if(isset($item->last_name)) {
                                            echo $this->escape($item->last_name);
                                        }
                                    ?>
                                </a>
                            <?php }else{?>
                                <?php
                                if(isset($item->first_name)) {
                                    echo $this->escape($item->first_name). ' ';
                                }
                                if(isset($item->last_name)) {
                                    echo $this->escape($item->last_name);
                                }
                                ?>
                            <?php }?>
                        </td>

                        <td>
                            <?php if(isset($item -> payer_email)) { echo $item -> payer_email;} ?>
                        </td>

                        <td><?php if(isset($item -> mc_gross)) {echo $item -> mc_gross.' '.$item -> mc_currency;}?></td>

                        <td>
                            <?php echo $data -> title;?>
                        </td>

                        <td class="center">
                            <div class="btn-group">
                                <?php echo JHtml::_('jgrid.published', $data->published, $i, 'donates.', $canChange, 'cb'); ?>
                            </div>
                        </td>

                        <td width="1%">
                            <?php echo $data -> id;?>
                        </td>
                    </tr>

                <?php endforeach;?>
                </tbody>
                <?php endif;?>
                <tfoot>
                <tr>
                    <td colspan="8"><?php echo $this -> pagination -> getListFooter();?></td>
                </tr>
                </tfoot>
            </table>
            <?php } ?>
        </div>
    </div>
    <input type="hidden" name="boxchecked" value="0">
    <input type="hidden" name="addon_task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>