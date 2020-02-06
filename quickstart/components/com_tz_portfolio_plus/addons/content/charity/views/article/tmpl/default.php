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
$params = $this -> params;
if(isset($this -> item) && $this -> item && $params->get('show_article_events',0) && $params->get('show_article_donate',0)):
    $params = $this -> params;
    $doc = JFactory::getDocument();
    $doc->addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/charity.css');

    if($params -> get('load_style', 0)){
        $doc -> addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/style.css');
    }
    $paypal_url     =   $params->get('paypalTest',0) ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
    $paypal_email   =   $params->get('paypalEmail','');
    $linkfull       =   TZ_Portfolio_PlusHelperRoute::getArticleRoute($this -> item -> slug,$this -> item -> catslug);
    $currentCode    =   $this->currency->display ? $this->currency->sign : $this->currency->code;
    $addon = $this -> state -> get($this -> getName().'.addon');
    $itemID = $this -> item -> id;
    $crt_evt_start  = $params->get('crt_evt_start','');
    $crt_evt_end    = $params->get('crt_evt_end','');
    $tzdate		= JFactory::getDate();
    $unix       = $tzdate -> toUnix();

    if($crt_evt_start != '' && $crt_evt_end != ''):
        if ($unix < strtotime($crt_evt_start) || $unix > strtotime($crt_evt_end)) return false;
    endif;
    ?>
    <?php if($params->get('show_article_events',0)): ?>
        <?php

        if($crt_evt_start != '' && $crt_evt_end != ''):
            $dateStart  = JHtml::_('date', $crt_evt_start, 'd F Y');
            $dateEnd    = JHtml::_('date', $crt_evt_end, 'd F Y');
            $doc->addScript(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/js/jquery.lwtCountdown-1.0.js');

            ?>
            <div class="evens">

                <h3><?php echo JText::_('PLG_CHARITY_REMAINING_TIME'); ?></h3>
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

        <?php endif; ?>
    <?php endif; ?>
    <?php if($params->get('show_article_donate',0)): ?>
    <div class="portfolio_cause">
        <div class="charity">
            <div class="donate-goal">
                <div class="donate-progress">
                    <?php
                    // Get donated
                    if(isset($this->donated) && !empty($this->donated)):
                        $donated    = $this->donated;

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
                                <div id="prgb_child" class="wow slideInLeft animated">
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
                }else {
                    ?>
                    <button id="tz-charity-donate" class="btn btn-donate" type="button" data-toggle="modal" data-target="#form-charity-donate"><?php echo JText::_('SITE_BUTTON_DONATE_THIS_CAUSE');?></button>
                <?php
                }
                ?>
            </div>

            <?php if($donated_status != 1 && $donated_status != 2):?>
                <div class="tz-form-donate donate-detail">
                    <div class="modal fade donate-modal" id="form-charity-donate" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <div class="content-head">
                                        <?php
                                        if($media  = $this -> item -> media){
                                            if(isset($media -> image -> url) && $imgUrl = $media -> image -> url){
                                                if(isset($imgUrl) && $imgUrl != '') {
                                                    if ($size = $params->get('mt_image_size', 'o')) {
                                                        $image_url_ext = JFile::getExt($imgUrl);
                                                        $image_url = str_replace('.' . $image_url_ext, '_' . $size . '.'
                                                            . $image_url_ext, $imgUrl);
                                                        $imgUrl = JURI::root() . $image_url;
                                                        echo '<div class="bg-header" style="background-image: url('.$imgUrl.')"></div>';
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    if($form    = $this -> formDonate):
                                        ?>
                                        <form action="<?php echo $paypal_url; ?>" method="post" class="form-horizontal"
                                              enctype="multipart/form-data" id="donateForm" name="donateForm">
                                            <p class="desc-specify"><?php echo JText::_('SITE_DESC_PLEASE_SPECIFY_DONATE');?></p>
                                            <?php
                                            $amounts    = $params -> get('tz_crt_amounts','');
                                            ?>

                                            <div class="choose-item">
                                                <?php
                                                if($amounts != '') {
                                                    $arrAmount  = explode(',', $amounts);
                                                    foreach($arrAmount as $i => $amV) {
                                                        echo '<div class="item-input">';
                                                        if ($this->currency->position) {
                                                                echo '<label>'.(int)$amV.' '.$currentCode.'</label>';
                                                        } else {
                                                            echo '<label>'.$currentCode.(int)$amV.'</label>';
                                                        }

                                                        echo '<input name="amount_check" id="input_amount_'.$i.'" class="input_donate" type="radio" value="'.(int)$amV.'" />' . '</div>';
                                                    }

                                                }
                                                $ct_amounts = $params -> get('tz_crt_ct_amounts','');
                                                if($ct_amounts != 0) {
                                                    echo '<div class="item-input">' .
                                                        '<input name="amount-custom" type="text" class="form-control donate-form-text-input" placeholder="'.JText::_('SITE_DESC_PLEASE_AMOUNT_DONATE_CUSTOM').'" value="" />' .
                                                        '</div>'
                                                    ;
                                                }
                                                ?>
                                            </div>
                                            <div class="error-dialog">
                                                <div class="error-select-amount"><?php echo JText::_('SITE_DESC_PLEASE_SELECT_AMOUNT_DONATE');?></div>
                                                <div class="donate-number-error">
                                                    <?php echo JText::_('SITE_DONATE_ONLY_NUMBER'); ?>
                                                </div>
                                            </div>

                                            <div class="about-donate">
                                                <div class="item"><?php echo $form -> getInput('email','value');?></div><button class="btn btn-primary radius-small" name="ok" type="submit"><?php echo JText::_('PLG_CRT_DONATE_NOW'); ?></button>
                                            </div>

                                            <input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
                                            <input type="hidden" name="amount" value="">
                                            <input type="hidden" name="cmd" value="_donations">
                                            <input type="hidden" name="item_name" value="<?php echo $this -> item -> title; ?>">
                                            <input type="hidden" name="item_number" value="<?php echo $this -> item -> id;?>"/>
                                            <input type="hidden" name="currency_code" value="<?php echo $this->currency->code; ?>">
                                            <input type="hidden" name="notify_url" value="<?php echo JRoute::_(JURI::root() . 'index.php?option=com_tz_portfolio_plus&view=addon&addon_task=donate.notification&addon_id='.$addon -> id); ?>">
                                            <input type="hidden" name="return" value="<?php echo $this->item->fullLink; ?>">
                                            <?php echo JHtml::_( 'form.token' ); ?>
                                        </form>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif?>

        </div>
    </div>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            var $ctDonate = '';
            $('.tz-form-donate .choose-item .item-input').on("click", function(){
                $('.tz-form-donate .choose-item .item-input').removeClass('selected');
                $('input[name="amount_check"]').prop('checked', false);
                $(this).addClass('selected');
                $(this).find('.input_donate').prop('checked', true);
                $('.tz-form-donate .donate-form-text-input').val('');
            });

            $(".donate-form-text-input").keypress(function (e) {
                //if the letter is not digit then display error and don't type anything
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which!=46)) {
                    //display error message
                    $(".donate-number-error").show().fadeOut(1600);
                    return false;
                }else {
                    $(".donate-number-error").hide().fadeOut(1600);
                }
            });
//        console.log($ctDonate);
            $('#donateForm').on("submit", function() {
                if($('.tz-form-donate .donate-form-text-input').length > 0) {
                    $ctDonate   = $('.tz-form-donate .donate-form-text-input').val();
                }else {
                    $ctDonate   = '';
                }
                if($("input[name='amount_check']").is(':checked') == true || $ctDonate != '') {
                    if($ctDonate == '') {
                        $ctDonate   = $("input[name='amount_check']:checked").val();
                    }
                }else {
                    $('.error-select-amount').show().fadeOut(3000);
                    return false;
                }
                document.donateForm.amount.value = $ctDonate;
            });

        });
    </script>
<?php endif; ?>


<?php
endif; // end if isset($this -> item) && $this -> item
?>

