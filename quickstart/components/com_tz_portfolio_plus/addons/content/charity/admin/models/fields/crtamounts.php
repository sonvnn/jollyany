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

defined('JPATH_PLATFORM') or die;

JFormHelper::loadFieldClass('text');

class JFormFieldCrtAmounts extends JFormFieldText {

    protected $type = 'CrtAmounts';

    protected function getInput(){

        $doc = JFactory::getDocument();

        $doc->addScriptDeclaration('
            jQuery(function($){
                document.adminForm.onsubmit = function(){
                    var $vl_item = 0;
                    $("#tz_amount_'.$this->id.' input").each(function (key, value) {
                        if(key == 0) {
                            $vl_item = $(this).val();
                        }else {
                            $vl_item = $vl_item+","+$(this).val();
                        }
                    });
                    $("#inputAmount'.$this->id.'").val($vl_item);
                };
            });
        ');

        $arrAmount  = self::getAmount();
        $html           = '';
        $valueHidden    = '';
        if(is_array($arrAmount) && !empty($arrAmount)) {
            $html   .= '<div id="tz_amount_'.$this->id.'" class="tz_amount">';
            foreach($arrAmount as $i => $value) {
                $vAmount    = json_decode($value -> value);
                if(isset($this -> value) && !empty($this -> value)) {
                    $oldArrV    = explode(",",$this->value);
                    if (isset($oldArrV[$i])) $vAmount->price = $oldArrV[$i];
                }
                $html       .= '<input id="'.$i.'" class="input-small" type="text" value="'.$vAmount->price.'" placeholder="'.$vAmount->title.'"
                data-placement="bottom" data-toggle="tooltip" aria-invalid="false">';;
            }
            $html   .= '</div>';
            $html   .= '<input id="inputAmount'.$this->id.'" type="hidden" value="'.$valueHidden.'" name="'.$this->name.'">';
        }

        return $html;
    }

    public function getAmount() {

        $db     = JFactory::getDbo();
        $query  = $db->getQuery(true);
        $query  -> select('*');
        $query  -> from('#__tz_portfolio_plus_addon_data');
        $query  -> where('element = "amounts"')
                -> where('published = 1');

        $db     -> setQuery($query);
        $rows   = $db   -> loadObjectList();

        return $rows;
    }
}