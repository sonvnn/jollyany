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

    $doc = JFactory::getDocument();
    $params = $this -> params;

    $doc->addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/charity.css');

    if($params -> get('load_style', 0)){
        $doc -> addStyleSheet(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/css/style.css');
    }

    $crt_evt_start  = $params->get('crt_evt_start','');
    $crt_evt_end    = $params->get('crt_evt_end','');
    if($crt_evt_start != '' && $crt_evt_end != ''):
        $itemID = $this -> item -> id;
        $dateStart  = JHtml::_('date', $crt_evt_start, 'd F Y');
        $dateEnd    = JHtml::_('date', $crt_evt_end, 'd F Y');
        $doc->addScript(TZ_Portfolio_PlusUri::root(true).'/addons/content/charity/js/jquery.lwtCountdown-1.0.js');
        ?>
        <div class="portfolio_cause detail">
            <div class="evens">
                <?php
                if (($timestamp = strtotime($crt_evt_end)) !== false) {
                    $php_date = getdate($timestamp);
                    // or if you want to output a date in year/month/day format:
                    $date = date("d/m/Y", $timestamp); // see the date manual page for format options
                } else {
                    echo 'invalid timestamp!';
                }

                $tzdate		= JFactory::getDate();
                $unix       = $tzdate -> toUnix();

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

    <?php endif; // check show events global

endif; // end if isset($this -> item) && $this -> item
?>
