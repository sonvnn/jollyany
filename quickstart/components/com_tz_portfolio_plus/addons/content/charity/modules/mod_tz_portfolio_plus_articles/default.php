<?php
/*------------------------------------------------------------------------
# plg_extravote - ExtraVote Plugin
# ------------------------------------------------------------------------
# author    Joomla!Vargas
# copyright Copyright (C) 2010 joomla.vargas.co.cr. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://joomla.vargas.co.cr
# Technical Support:  Forum - http://joomla.vargas.co.cr/forum
-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

if(isset($item -> donated) && $item -> donated && $params->get('show_donate')): ?>
    <?php
        // check $item -> currency
        if(isset($item -> currency) && $item -> currency != '') {
            $currency = $item -> currency -> sign;
        }else {
            $currency = '';
        }
    ?>
    <div class="item-causes">
        <div class="charity">
            <div class="donate-goal">
                <div class="donate-progress">
                    <?php
                        $donated    = $item -> donated;
                        $donateSum  = (int)$donated["sumDonate"];
                        $goalDonate = (int)$paramArt->get('tz_crt_goal_money');
                        if($donateSum != 0 && $goalDonate != 0) {
                            $tlDonate   = ($donateSum*100)/$goalDonate;
                            if($tlDonate > 100) {
                                $tlDonate = 100;
                            }
                        }else {
                            $tlDonate   = 0;
                        }
                        // check class
                        if($tlDonate == 0) {
                            $clCkDn = ' dno';
                        }elseif($tlDonate == 100) {
                            $clCkDn = ' dyes';
                        }else {
                            $clCkDn = '';
                        }
                    ?>
                    <div class="item-progress">
                        <div class="child-prgb" style="width:<?php echo $tlDonate;?>%;">
                            <div id="prgb_child<?php echo $item -> id;?>" class="wow slideInLeft animated"><span class="round<?php echo $clCkDn;?>"><?php echo round($tlDonate);?>%</span></div>
                        </div>
                    </div>
                    <?php if($params->get('show_dnted',1) || $params->get('show_gldn',1)):?>
                        <div class="progress-info">
                            <?php if($params->get('show_dnted',1)): ?>
                                <div class="progress-ed"><?php echo $donateSum;?><span> <?php echo JText::_('ADDON_DONATED');?></span></div>
                            <?php endif;?>
                            <?php if($params->get('show_gldn',1)): ?>
                                <div class="progress-final"><?php echo $currency.$goalDonate;?><span> <?php echo JText::_('ADDON_TO_GO');?></span></div>
                            <?php endif;?>
                        </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
<?php
endif;