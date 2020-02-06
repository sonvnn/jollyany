<?php
/*------------------------------------------------------------------------

# JContent Migration Add-On

# ------------------------------------------------------------------------

# Author:    DuongTVTemPlaza

# Copyright: Copyright (C) 2011-2018 TZ Portfolio.com. All Rights Reserved.

# @License - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL

# Website: http://www.tzportfolio.com

# Technical Support:  Forum - https://www.tzportfolio.com/help/forum.html

# Family website: http://www.templaza.com

# Family Support: Forum - https://www.templaza.com/Forums.html

-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die;

JLoader::import('com_tz_portfolio_plus.controllers.addon_data',JPATH_ADMINISTRATOR.DIRECTORY_SEPARATOR.'components');

class TZ_Portfolio_PlusAddOnMigrationJContentControllerDashboard extends TZ_Portfolio_PlusControllerAddon_Data{

    public function __construct($config = array())
    {
        parent::__construct($config);

        // Define standard task mappings.

        // Value = 0
        $this->registerTask('purges', 'purge');
    }

    public function purge(){
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Get items to publish from the request.
        $cid    = null;
        if($this -> task != 'purges') {
            $cid = $this->input->get('cid', array(), 'array');
        }

        $model  = $this -> getModel();

        // Remove the items.
        if ($model->purge($cid))
        {
            $this->setMessage(JText::_('PLG_MIGRATION_JCONTENT_PURGE_HISTORY_SUCCESS'));
        }
        else
        {
            $this->setMessage($model->getError(), 'error');
        }
        $this->setRedirect(\JRoute::_($this -> getAddonRedirect($this -> view_item). $this->getRedirectToItemAppend(), false));
    }
}