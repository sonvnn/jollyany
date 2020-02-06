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

//no direct access
defined('_JEXEC') or die;

JHtml::_('behavior.formvalidator');

$addonId    = $this -> state -> get($this -> getName().'.addon_id');

JFactory::getDocument()->addScriptDeclaration('
	Joomla.submitbutton = function(task)
	{
		if (task == "currency.cancel" || document.formvalidator.isValid(document.getElementById("adminForm")))
		{
			Joomla.submitform(task, document.getElementById("adminForm"));
		}
	};
');
?>
<form action="<?php echo JRoute::_(TZ_Portfolio_PlusHelperAddon_Datas::getRootURL($addonId)
    .'&addon_view=currency&addon_layout=edit&id='.$this -> item -> id); ?>"
      method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal tpArticle">
    <?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'details')); ?>
            <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'details', JText::_('JDETAILS', true)); ?>
        <div class="row-fluid">
            <div class="span6">
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('title','value');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('title','value');?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('code','value');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('code','value');?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('sign','value');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('sign','value');?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('display','value');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('display','value');?></div>
                </div>
            </div>
            <div class="span6">
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('position','value');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('position','value');?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('default','value');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('default','value');?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('published');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('published');?></div>
                </div>
                <div class="control-group">
                    <div class="control-label"><?php echo $this -> form -> getLabel('id');?></div>
                    <div class="controls"><?php echo $this -> form -> getInput('id');?></div>
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="control-label"><?php echo $this -> form -> getLabel('description','value');?></div>
            <div class="controls"><?php echo $this -> form -> getInput('description','value');?></div>
        </div>
        <?php echo JHtml::_('bootstrap.endTab'); ?>

    <?php echo JHtml::_('bootstrap.endTabSet'); ?>
    </div>

    <input type="hidden" name="addon_task" value="" />
    <?php echo JHtml::_('form.token'); ?>
</form>
