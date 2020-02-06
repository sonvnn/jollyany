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

// Import addon_data model
JLoader::import('com_tz_portfolio_plus.models.addon_data',JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components');

class PlgTZ_Portfolio_PlusContentCharityModelDonate extends TZ_Portfolio_PlusModelAddon_Data {

    public $_idElement = '';

    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        JForm::addFormPath(COM_TZ_PORTFOLIO_PLUS_ADDON_PATH.DIRECTORY_SEPARATOR
            .'content/charity/models/forms');
        $form = $this->loadForm('com_tz_portfolio_plus.content.charity.donate', 'donate',
            array('control' => 'jform', 'load_data' => true));

        if (empty($form))
        {
            return false;
        }

        return $form;
    }

    protected function loadFormData()
    {
        $data = (array) JFactory::getApplication()->getUserState('com_tz_portfolio_plus.content.charity.donate.data', array());

        $this->preprocessData('com_tz_portfolio_plus.content.charity', $data);

        return $data;
    }

    public function getIDElement() {
        return $this -> _idElement;
    }

    public function savePaypal($paypal) {

        $dispatcher = JEventDispatcher::getInstance();
        $input  = JFactory::getApplication()->input;

        $table      = $this->getTable();
        $context    = $this->option . '.' . $this->name; // com_tz_portfolio_plus.donate , this->option = com_tz_portfolio_plus
        $key = $table->getKeyName(); // id
        $pk = (!empty($data[$key])) ? $data[$key] : (int) $this->getState($this->getName() . '.id');
        $isNew = true;

        $data['element'] = $this->name;
        $data['content_id'] = $paypal['item_number'];
        $data['extension_id'] = $input->get('addon_id','');
        $data['value']  =  json_encode($paypal);
        $data['published'] = 1;
        JPluginHelper::importPlugin($this->events_map['save']);

        try {

            // Load the row if saving an existing record.
            if ($pk > 0)
            {
                $table->load($pk);
                $isNew = false;
            }

            // Bind the data.
            if (!$table->bind($data))
            {
                $this->setError($table->getError());
                return false;
            }

            // Prepare the row for saving
            $this->prepareTable($table);

            // Check the data.
            if (!$table->check())
            {
                $this->setError($table->getError());
                return false;
            }

            // Trigger the before save event.
            $result = $dispatcher->trigger($this->event_before_save, array($context, $table, $isNew));

            if (in_array(false, $result, true))
            {
                $this->setError($table->getError());
                return false;
            }

            // Store the data.
            if (!$table->store())
            {
                $this->setError($table->getError());
                return false;
            }

            // Clean the cache.
            $this->cleanCache();

            // Trigger the after save event.
            $dispatcher->trigger($this->event_after_save, array($context, $table, $isNew));

        }catch (Exception $e) {

            $this->setError($e->getMessage());

            return false;

        };

        $this -> _idElement = $table->id;

        return true;
    }
}