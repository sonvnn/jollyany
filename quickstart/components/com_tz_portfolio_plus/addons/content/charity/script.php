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

jimport('joomla.installer.installer');

class plgContentCharityInstallerScript {

    function preflight( $type, $parent ) {

    }

    function postflight( $type, $parent ) {

        if ( $type == 'install' ) {

            $db = JFactory::getDbo();
            $db->setQuery('SELECT id FROM #__tz_portfolio_plus_extensions WHERE name = "plg_content_charity"');
            $id = $db->loadResult();

            $query = $db->getQuery(true);

            // Insert columns.
            $columns = array('extension_id', 'element', 'value', 'content_id', 'published', 'ordering');

            // Insert values.
            $values = array($id, $db->quote('currency'), $db->quote('{"title":"US.Dollar","code":"USD","sign":"$","display":"0","position":"0","default":"1","description":""}'), 0, 1, 0);


            $query
                ->insert($db->quoteName('#__tz_portfolio_plus_addon_data'))
                ->columns($db->quoteName($columns))
                ->values(implode(',', $values));

            // Set the query using our newly populated query object and execute it.
            $db->setQuery($query);

            $db->execute();

        }

    }

}