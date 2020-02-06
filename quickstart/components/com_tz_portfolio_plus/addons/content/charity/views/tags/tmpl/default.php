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
if(isset($this -> item) && $this -> item):
    $params = $this -> params;
    $doc = JFactory::getDocument();
    $doc->addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/charity.css');

    if($params -> get('load_style', 0)){
        $doc -> addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/style.css');
    }

    $modelsP    = $this -> getModel();
    $modelAddon = $modelsP->get('addon');
    $idAddon    = $modelAddon -> id;

    $itemID = $this -> item -> id;

    $tzdate		= JFactory::getDate();
    $unix       = $tzdate -> toUnix();

    $crt_evt_start  = $params->get('crt_evt_start','');
    $crt_evt_end    = $params->get('crt_evt_end','');

    if($crt_evt_start != '' && $crt_evt_end != ''):
        if ($unix < strtotime($crt_evt_start) || $unix > strtotime($crt_evt_end)) return false;
    endif;

    $currentCode    =   $this->currency->display ? $this->currency->sign : $this->currency->code;
    // check show events global
    if($params->get('show_tag_events',0)):
        if($crt_evt_start != '' && $crt_evt_end != ''):
            $dateStart  = JHtml::_('date', $crt_evt_start, 'd F Y');
            $dateEnd    = JHtml::_('date', $crt_evt_end, 'd F Y');
            $doc->addScript(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/js/jquery.lwtCountdown-1.0.js');
            ?>
            <div class="evens">
                <h5><?php echo JText::_('PLG_CHARITY_REMAINING_TIME'); ?></h5>
                <?php
                if (($timestamp = strtotime($crt_evt_end)) !== false) {
                    $php_date = getdate($timestamp);
                    // or if you want to output a date in year/month/day format:
                    $date = date("d/m/Y", $timestamp); // see the date manual page for format options
                } else {
                    echo 'invalid timestamp!';
                }



                $second     = 0;
                if($timestamp >= $unix) {
                    $second = $timestamp - $unix;
                }

                $day        = (int)($second / (24*60*60));
                $second     = $second - $day * 24 * 60 * 60;

                $hour       = (int)($second/(60*60));
                $second     = $second - $hour * 60 * 60;

                $minute     = (int)($second / 60);
                $second     = $second - $minute * 60;
                ?>
                <div id="countdown_dashboard<?php echo $itemID;?>">

                    <div class="dash days_dash">
                        <div class="time_number">
                            <?php if($day && $day > 0 && strlen($day) > 2){
                                for($i = 1; $i <= (strlen($day) - 2); $i++){
                                    ?>
                                    <div class="digit">0</div>
                                    <?php
                                }
                            }?>
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                        </div>
                        <span class="dash_title"><?php echo JText::_('ADDON_DAYS');?></span>
                    </div>

                    <div class="dash hours_dash">
                        <div class="time_number">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                        </div>
                        <span class="dash_title"><?php echo JText::_('ADDON_HOURS');?></span>
                    </div>

                    <div class="dash minutes_dash">
                        <div class="time_number">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                        </div>
                        <span class="dash_title"><?php echo JText::_('ADDON_MINUTES');?></span>
                    </div>

                    <div class="dash seconds_dash">
                        <div class="time_number">
                            <div class="digit">0</div>
                            <div class="digit">0</div>
                        </div>
                        <span class="dash_title"><?php echo JText::_('ADDON_SECONDS');?></span>
                    </div>
                </div>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function() {
                    jQuery('#countdown_dashboard<?php echo $itemID;?>').countDown({
                        targetOffset: {
                            'day': <?php echo $day; ?>,
                            'month': 0,
                            'year': 0,
                            'hour': <?php echo $hour; ?>,
                            'min': <?php echo $minute; ?>,
                            'sec': <?php echo $second; ?>
                        },
                        omitWeeks: true
                    });
                });
            </script>

        <?php endif;
    endif; // check show events global ?>
    <?php
    // check show donate global
    if($params->get('show_tag_donate',0)):
        $doc->addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/animate.css');
        $doc->addScript(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/js/wow.min.js');
        ?>
        <div class="charity">
            <div class="donate-goal">
                <div class="donate-progress">
                    <?php
                    // Get donated
                    if(isset($this->donated) && !empty($this->donated)): $donated    = $this->donated; ?>
                        <?php
                        $donateSum  = (float)$donated["sumDonate"];
                        $goalDonate = (float)$params->get('tz_crt_goal_money',0);
                        if($donateSum != 0 && $goalDonate != 0) {
                            $tlDonate   = ($donateSum*100)/$goalDonate;
                            if($tlDonate > 100) {
                                $tlDonate = 100;
                            }
                        }else {
                            $tlDonate   = 0;
                        }
                        ?>
                        <div class="item-progress">
                            <div class="child-prgb" style="width:<?php echo $tlDonate;?>%;">
                                <div id="prgb_child<?php echo $itemID;?>" class="wow slideInLeft animated">
                                </div>
                            </div>
                        </div>

                        <div class="progress-label">
                            <div class="progress-ed">
                                <?php echo JText::_('ADDON_COLLECTED');?>
                                <?php if ($this->currency->position) { ?>
                                    <span><?php echo $donateSum.' '.$currentCode;?></span>
                                <?php } else { ?>
                                    <span><?php echo $currentCode.$donateSum;?></span>
                                <?php }?>
                            </div>
                            <div class="total">
                                <?php echo JText::_('ADDON_DONATOR');?>
                                <span><?php echo $donated["countDonate"];?></span>
                            </div>
                            <div class="progress-final"><?php echo JText::_('ADDON_DONATE_GOAL');?>
                                <?php if ($this->currency->position) { ?>
                                    <span><?php echo $goalDonate.' '.$currentCode;?></span>
                                <?php } else { ?>
                                    <span><?php echo $currentCode.$goalDonate;?></span>
                                <?php }?>
                            </div>
                        </div>

                        <?php
                    endif;
                    ?>
                </div>

                <?php
                // Check button donate
                $donated_status = $params->get('tz_crt_donated_status',0);
                if($donated_status == 1) {
                    echo JText::_('SITE_NPF_FINISHED');
                }elseif($donated_status == 2) {
                    echo JText::_('SITE_NPF_PAUSE');
                }
                ?>
            </div>
        </div>
    <?php endif; // End check show donate global
    ?>
    <?php
endif;