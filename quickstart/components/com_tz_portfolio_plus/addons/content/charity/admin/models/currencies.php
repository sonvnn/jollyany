<?php
/*------------------------------------------------------------------------

# TZ Portfolio Plus Extension

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2015 templaza.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Websites: http://www.templaza.com

# Technical Support:  Forum - http://templaza.com/Forum

-------------------------------------------------------------------------*/

// No direct access
defined('_JEXEC') or die;

class TZ_Portfolio_Plus_Addon_CharityModelCurrencies extends TZ_Portfolio_PlusModelAddon_Datas{

    protected $addon_element   = 'currency';

    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'id',
                'extension_id',
                'type',
                'value',
                'value.title',
                'value.code',
                'value.sign',
                'value.default',
                'value.display',
                'value.position',
                'ordering',
            );
        }

        parent::__construct($config);
    }

    protected function populateState($ordering = 'value.default', $direction = 'desc'){
        $addon_id   = JFactory::getApplication()->input->getInt('addon_id');
        $this -> setState($this -> getName().'.addon_id',$addon_id);

        $published = $this->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
        $this->setState('filter.published', $published);

        // List state information.
        parent::populateState($ordering, $direction);
    }
}