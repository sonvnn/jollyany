<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 3/10/2016
 * Time: 12:02 PM
 */
// No direct access.
defined('_JEXEC') or die;

if(isset($this->formPaypal) && !empty($this->formPaypal)):
    echo $this->formPaypal;
//    $getValue   = $this->formPaypal->value;
//    $value      = json_decode($getValue);
?>
<!--    <form method="post" name="formPaypal" action="https://www.sandbox.paypal.com/cgi-bin/webscr">-->
<!--        <input type="hidden" value="_ext-enter" name="cmd">-->
<!--        <input type="hidden" value="_xclick" name="redirect_cmd">-->
<!--        <input type="hidden" value="thuongnv123@gmail.com" name="business">-->
<!--        <input type="hidden" value="thuongnv123@gmail.com" name="receiver_email">-->
<!--        <input type="hidden" name="amount" value="--><?php //echo $value->money_donate;?><!--">-->
<!--        <input type="hidden" name="currency_code" value="USD">-->
<!--        <input type="hidden" value="--><?php //echo $value->firstname;?><!--" name="first_name">-->
<!--        <input type="hidden" value="--><?php //echo $value->email;?><!--" name="email">-->
<!--        <input type="hidden" value="https://www.templaza.com/images/templaza_paypal.jpg" name="image_url">-->
<!---->
<!--        <input type="hidden" name="return" value="--><?php //echo $this -> item -> link.'?addon_task=charity.donate.received&return=';?><!--">-->
<!--        <input type="hidden" name="cancel_return" value="--><?php //echo $this -> item -> link;?><!--">-->
<!--        <input type="submit" name="submitPP" value="Thanh toan quay Paypal">-->
<!--    </form>-->
<?php
//$js = '
//function directToPaypal() {
//document.formPaypal.submit();
//}
//setTimeout("directToPaypal()", 5000);
//';
//$doc = JFactory::getDocument();
//$doc -> addScriptDeclaration($js);
//
endif;
?>