<?php
/**
 * Created by PhpStorm.
 * User: thuongnv
 * Date: 3/21/2016
 * Time: 5:08 PM
 */

defined('_JEXEC') or die;

class ModTZDonate
{
    /**
     * Retrieve breadcrumb items
     *
     * @param   \Joomla\Registry\Registry  &$params  module parameters
     *
     * @return array
     */
    public static function getList($id)
    {
        $idct   = (int)$id;
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

    public static function getCurrency() {

        $valueDefault   = (object) array(
            "title" => 'US.Dollar',
            "code" => "USD",
            "sign" => "$",
            "display" => "0",
            "position" => "0",
            "default" => "1",
            "description" => "");

        $db     = JFactory::getDbo();
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


}