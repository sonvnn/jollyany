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

class TZ_Portfolio_PlusAddOnMigrationJContentControllerMigrate extends TZ_Portfolio_PlusControllerAddon_Data{

    public function migrate(){
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $app        = \JFactory::getApplication();
        $input      = $this -> input;
        $data       = $input -> post -> get('jform', array(), 'array');
//        $session    = \JFactory::getSession();

        $ajax       = PlgTZ_Portfolio_PlusMigrationAjax::getInstance();

        $model  = $this -> getModel();

        // Validate the posted data.
        // Sometimes the form needs some posted data, such as for plugins and modules.
        $form = $model->getForm($data, false);

        if (!$form)
        {
            $app->enqueueMessage($model->getError(), 'error');
            $ajax -> resolve();
            $ajax -> redirect(\JRoute::_($this -> getAddonRedirect($this -> view_item)
                . $this->getRedirectToItemAppend(), false));

            return false;
        }
        // Test whether the data is valid.
        $validData = $model->validate($form, $data);

        try{
            $model -> migrate($validData);
        }catch (Exception $e){
            echo JLayoutHelper::render('error', array('error' => $e), PLG_MIGRATION_JCONTENT_ADMIN_PATH.'/layouts');
        }

        $app -> setHeader('Content-type','text/x-json; charset=UTF-8');
        $app -> sendHeaders();

        if($ajax && $ajax -> checkData()) {
            echo $ajax->toJSON();
        }

        $app -> close();
    }

    public function purge(){
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        $model  = $this -> getModel();

        // Remove the items.
        if ($model->purge())
        {
            $this->setMessage('Purge History complete!');
        }
        else
        {
            $this->setMessage($model->getError(), 'error');
        }
        $this->setRedirect(\JRoute::_($this -> getAddonRedirect($this -> view_item). $this->getRedirectToItemAppend(), false));
    }
}