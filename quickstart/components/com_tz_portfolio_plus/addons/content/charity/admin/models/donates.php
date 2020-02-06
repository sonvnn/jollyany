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

class TZ_Portfolio_Plus_Addon_CharityModelDonates extends TZ_Portfolio_PlusModelAddon_Datas {

    protected $addon_element    = 'donate';

    public function __construct($config = array()) {
        if(empty($config['filter_fields'])) {
            $config['filter_fields'] = array(
                'id',
                'extension_id',
                'type',
                'value',
                'value.title',
                'value.donate',
                'ordering'
            );
        }

        parent::__construct($config);

    }
    public function getListQuery(){
        $query = parent::getListQuery();
        $query->select('c.title')->join('LEFT', '#__tz_portfolio_plus_content AS c ON c.id=d.content_id');
        return $query;
    }

}