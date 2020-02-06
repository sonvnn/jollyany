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

// No direct access.
defined('_JEXEC') or die;


jimport('joomla.application.component.modellist');

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
// Set the table directory
JTable::addIncludePath(JPATH_COMPONENT_ADMINISTRATOR.DS.'tables');

class PlgTZ_Portfolio_PlusContentCharityModelArticle extends TZ_Portfolio_PlusPluginModelItem{

//    var $donate = null;
//
//    var $params =   null;
//
//    var $package=   null;
//
//    function __construct($donate) {
//
//        parent::__construct();
//        $mainframe  =   JFactory::getApplication();
//        $option     =   'com_tz_portfolio_plus';
//        $params		= $mainframe->getParams($option);
//        if(isset($donate) && !empty($donate)) {
//            $this->donate    =   $donate;
//            $this->params   =   $params;
//            $package        =   JTable::getInstance('tz_licence','Table');
//            $package->load($donate->id);
//            $this->package  =   $package;
//        }
//
//    }


    public function getFormDonate(){

        $model  = JModelLegacy::getInstance('Donate','PlgTZ_Portfolio_PlusContentCharityModel');
        $form   = $model -> getForm();

        return $form;

    }

    public function getNewDonate() {

        $input      = JFactory::getApplication() -> input;
        $pageView   = base64_decode($input -> get('charity_view'));
        $id         = (int)str_replace('paypalre','',$pageView);

        $code       = $this -> getCurrency();

        $parAddon       = $this->addon->params;
        $paramsAddon    = json_decode($parAddon);

        $emailBusiness  = $paramsAddon->paypalEmail;
        $paypaTest      = $paramsAddon->paypalTest;

        if($paypaTest == 1) {
            $linkForm   = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }else {
            $linkForm   = 'https://www.paypal.com/cgi-bin/webscr';
        }

        if(isset($id) && $id != 0) {

            $db     = JFactory::getDbo();
            $query  = $db->getQuery(true);

            $query -> select('*');
            $query -> from('#__tz_portfolio_plus_addon_data');
            $query -> where('id = '.$id);

            $db     -> setQuery($query);
            $rows   = $db   -> loadObject();
            //// tz membership ////

            $user   =   JFactory::getUser();

            $mainframe  =   JFactory::getApplication();
            $menu       =   $mainframe->getMenu();
//            $Itemid     =   $menu->getActive()->id;

            $option     =   'com_tz_portfolio_plus';

            $vDonate    =   $rows -> value;
            $vPaypal    =   json_decode($vDonate);
//            $linkfull   = $this -> getReturnPage();
            $linkfull   = TZ_Portfolio_PlusHelperRoute::getArticleRoute($this -> article -> slug,$this -> article -> catslug);
            $returnLink = base64_encode($linkfull);
            $post_variables = Array(
                'cmd' => '_ext-enter',
                'redirect_cmd' => '_xclick',
                'upload' => '1', //Indicates the use of third-party shopping cart
                'business' => $emailBusiness, //Email address or account ID of the payment recipient (i.e., the merchant). thuongnv123@gmail.com
                'receiver_email' => $emailBusiness, //Primary email address of the payment recipient (i.e., the merchant
//                'order_number' => $id,
//                "invoice" => $id,
                'custom' => $id,
                'item_name' => $vPaypal->firstname,
                "amount" => $vPaypal->money_donate,
                "currency_code" => $code,
                /*
                 * 1 – L'adresse spécifiée dans les variables pré-remplies remplace l'adresse de livraison enregistrée auprès de PayPal.
                 * Le payeur voit l'adresse qui est transmise mais ne peut pas la modifier.
                 * Aucune adresse n'est affichée si l'adresse n'est pas valable
                 * (par exemple si des champs requis, tel que le pays, sont manquants) ou pas incluse.
                 * Valeurs autorisées : 0, 1. Valeur par défaut : 0
                 */
                "address_override" => "0", // 0 ??   Paypal does not allow your country of residence to ship to the country you wish to
                "first_name" => $vPaypal->firstname,
                "last_name" => '',
                "address1" => '',
                "address2" => '',
                "zip" => '',
                "city" => '',
                "state" => '',
                "country" => '',
                "email" => $vPaypal->email,
                "night_phone_b" => '',
//                "return" => JROUTE::_(JURI::root() . 'index.php?option='.$option.'&view=paypalreturn&task=received&on=' . $this->order->invoice . '&pm=paypal&Itemid='.$Itemid),
                "return" => JROUTE::_(JURI::root() . $linkfull.'&addon_task=charity.donate.received&return='.$returnLink),
//                "notify_url" => JROUTE::_(JURI::root() . 'index.php?option='.$option.'&view=paypalreturn&task=notification&tmpl=component'),
                "notify_url" => JROUTE::_(JURI::root() . $linkfull.'&addon_task=charity.donate.notification&return='.$returnLink),
//                "cancel_return" => JROUTE::_(JURI::root() . 'index.php?option='.$option.'&view=paypalreturn&task=paymentcancel&on=' . $this->order->invoice . '&pm=paypal&Itemid='.$Itemid),
                "cancel_return" => JROUTE::_(JURI::root() . $linkfull.'&addon_task=charity.donate.paymentcancel&return='.$returnLink),
                //"undefined_quantity" => "0",
                "ipn_test" => 'NO',
                //"pal" => "NRUBJXESJTY24",
                "image_url" => JURI::root() . 'images/templaza_paypal.jpg',
                "no_shipping" => "1",
                "no_note" => "1");

            //// end tz membership ////

            $html = '<div style="margin: auto; text-align: center;">';
            $html .= '<h3>Thank you for joining us!</h3>';
            $html .= '<form action="'.$linkForm.'" method="post" name="tz_paypal_form" >';
            $html.= '<input type="image" name="submit" src="http://www.paypal.com/en_US/i/btn/x-click-but6.gif" alt="Payment Processing..." />';
            foreach ($post_variables as $name => $value) {
                $html.= '<input type="hidden" name="' . $name . '" value="' . htmlspecialchars($value) . '" />';
            }
            $html.= '</form></div>';
            $html.= ' <script type="text/javascript">';
            $html.= ' document.tz_paypal_form.submit();';
            $html.= ' </script>';

            return $html;

        }else {

            return null;

        }

    }

    public function getPaymentResponseReceived () {

    }

    public function getReturnPage() {

        $returnPage = $this->article->fullLink;

        return $returnPage;

    }

    public function getCurrency() {

        $valueDefault   = (object) array(
            "title" => 'US.Dollar',
            "code" => "USD",
            "sign" => "$",
            "display" => "0",
            "position" => "0",
            "default" => "1",
            "description" => "");

        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true)
            -> select('*')
            -> from('#__tz_portfolio_plus_addon_data')
            -> where('element=\'currency\' AND value LIKE '.$db -> quote('%"default":"1"%'). ' OR value LIKE '.$db -> quote('%"default":1%'));

        $db -> setQuery($query);
        $currency   = $db -> loadObject();

        if(isset($currency) && !empty($currency)) {
            $value      = json_decode($currency -> value);
        }else {
            $value      = $valueDefault;
        }

        return $value;

    }

    public function getDonated() {

        $idct   = $this -> article -> id;
        $db     = JFactory::getDbo();
        $query  = $db -> getQuery(true);

        $query  -> select('*')
                -> from('#__tz_portfolio_plus_addon_data')
                -> where('element = \'donate\' AND published = 1 AND content_id = '.$idct);

        $db->setQuery($query);

        $row = $db -> loadObjectList();

        $return = array();
        $sumDonate = 0;
        $countD     = 0;

        foreach($row as $i => $value) {

            $vDonate    = json_decode($value->value); // money donate
            if (isset($vDonate->mc_gross)) {
                $countD++;
                $mDonate    = $vDonate->mc_gross;
                $sumDonate  += (float)($mDonate);
            }
        }

        $return['countDonate'] = $countD;
        $return['sumDonate'] = $sumDonate;

        return $return;

    }
}