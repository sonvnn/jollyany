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

// No direct access
defined('_JEXEC') or die;

use Joomla\Registry\Registry;

class TZ_Portfolio_Plus_Addon_CharityModelCurrency extends TZ_Portfolio_PlusModelAddon_Data
{
    protected $addon_element   = 'currency';

    public function setHome($id = 0)
    {

        $user = TZ_Portfolio_PlusUser::getUser();
        $db   = $this->getDbo();

        // Access checks.
        if (!$user->authorise('core.edit.state', 'com_tz_portfolio_plus'))
        {
            throw new Exception(JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
        }

        $table  = $this -> getTable();

        if (!$table->load((int) $id))
        {
            throw new Exception(JText::_('COM_TEMPLATES_ERROR_STYLE_NOT_FOUND'));
        }

        if (!$this->canEditState($table))
        {
            \JLog::add(\JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'), \JLog::WARNING, 'jerror');

            return false;
        }

        // If the table is checked out by another user, drop it and report to the user trying to change its state.
        if (property_exists($table, 'checked_out') && $table->checked_out && ($table->checked_out != $user->id))
        {
            \JLog::add(\JText::_('JLIB_APPLICATION_ERROR_CHECKIN_USER_MISMATCH'), \JLog::WARNING, 'jerror');

            return false;
        }

        // Get data with home
        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true)
            -> select('*')
            -> from('#__tz_portfolio_plus_addon_data')
            -> where('value LIKE '.$db -> quote('%"default":"1"%'),'OR')
            -> where('value LIKE '.$db -> quote('%"default":1%'));
        $db -> setQuery($query);

        $homeData = $db -> loadObjectList();
        if($homeData){
            // un default
            foreach($homeData as $hi => $hdata) {
                $homeValue          = json_decode($hdata -> value);
                $homeValue->default = "0";
                $homeId             = $hdata -> id;
                $registry           = new Registry;
                $registry->loadObject($homeValue);
                $homeValue  = (string) $registry;
                self::unDefault($homeValue,$homeId);
            }
        }

        // Set the new default currency.

        $addonValue = json_decode($table -> value);
        $addonValue ->default   = "1";
        $addonValue = json_encode($addonValue);
        $query -> clear();
        $query -> update('#__tz_portfolio_plus_addon_data')
            -> set('value='.$db -> quote($addonValue))
            -> where('id='.$id);
        $db -> setQuery($query);
        $db -> execute();

        // Clean the cache.
        $this->cleanCache();

        return true;
    }

    public function unDefault($homeValue,$homeId) {

        $db     = $this -> getDbo();
        $query  = $db -> getQuery(true);
        $query -> update('#__tz_portfolio_plus_addon_data')
                -> set('value='.$db -> quote($homeValue))
                -> where('id='.$homeId);
        $db -> setQuery($query);
        $db -> execute();

        return true;

    }

    public function save($data)
    {
        //////////////////////// un Default ////////////////////////

        if($return = parent::save($data)){
            // Get data with home
            $idNew      = $data['id'];
            $valueNew   = $data['value'];
            $newDefault = $valueNew['default'];
            if(isset($newDefault) && $newDefault == 1) {
                $db     = $this -> getDbo();
                $query  = $db -> getQuery(true)
                    -> select('*')
                    -> from('#__tz_portfolio_plus_addon_data')
                    -> where('value LIKE '.$db -> quote('%"default":"1"%'))
                    -> where('id != '.$idNew);
                $db -> setQuery($query);
                $homeData = $db -> loadObjectList();
                if($homeData){
                    // un default
                    foreach($homeData as $hi => $hdata) {
                        $homeValue          = json_decode($hdata -> value);
                        $homeValue->default = "0";
                        $homeId             = $hdata -> id;
                        $registry           = new Registry;
                        $registry->loadObject($homeValue);
                        $homeValue  = (string) $registry;
                        self::unDefault($homeValue,$homeId);
                    }
                }
            }

            return $return;
        }
        return false;
    }
//    protected function prepareTable($table){
//        if(property_exists($table, 'asset_id')) {
//            $table -> set('_trackAssets', false);
//        }
//    }

}