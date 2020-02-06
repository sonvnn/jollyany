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

class PlgTZ_Portfolio_PlusMigrationAjax{

    protected $rev;
    protected $commands;
    protected static $cache;

    public function __construct($config = array())
    {
        if(!$this -> commands){
            $this -> commands   = array();
        }

        if(!$this -> rev){
            $this -> rev    = new stdClass();
        }

        if(!isset($this -> rev -> props)){
            $this -> rev -> props   = array();
        }

        if(!isset($this -> rev -> html)){
            $this -> rev -> html   = array();
        }

        if(!isset($this -> rev -> resolve)){
            $this -> rev -> resolve   = array();
        }

        if(!self::$cache){
            self::$cache  = array();
        }
    }

    public static function getInstance($config = array()){
        $storeId    = md5(__METHOD__.'::'.serialize($config));

        if(!isset(self::$cache[$storeId])){
            self::$cache[$storeId]    = false;
        }

        if(self::$cache[$storeId]){
            return self::$cache[$storeId];
        }

        self::$cache[$storeId]    = new PlgTZ_Portfolio_PlusMigrationAjax();
        return self::$cache[$storeId];
    }


    public function append($prop, $pos = null) {
        $_prop  = array($prop);
        if ($pos !== null) $_prop[] = $pos;
        $this->rev->props[] = $_prop;
    }

    public function addCommands($type, $data){
        $this -> commands[] = array('type' => $type, 'data' => $data);
        return $this;
    }

    public function toArray() {
        if(isset($this -> rev -> props) && count($this -> rev -> props)){
            foreach($this -> rev -> props as $prop){
                $this -> addCommands('append', $prop);
            }
        }
        if(isset($this -> rev -> html) && count($this -> rev -> html)){
            $this -> addCommands('html', $this -> rev -> html);
        }
        if(isset($this -> rev -> resolve) && count($this -> rev -> resolve)){
            $this -> addCommands('resolve', $this -> rev -> resolve);
        }

        return $this -> commands;

    }

    public function redirect($url = ''){
        $this -> addCommands('redirect', (array) $url);
        return $this;
    }

    public function resolve($message = ''){
        if($message && is_string($message)){
            $this -> rev -> html[]   = $message;
        }else {
            $this->rev->resolve[] = $message;
        }
        return $this;
    }

    public function toJSON(){
        return json_encode($this -> toArray());
    }

    public function checkData(){
        $dataExists = false;

        if(isset($this -> rev -> props) && count($this -> rev -> props)){
            $dataExists = true;
        }
        if(isset($this -> rev -> html) && count($this -> rev -> html)){
            $dataExists = true;
        }
        if(isset($this -> rev -> resolve) && count($this -> rev -> resolve)){
            $dataExists = true;
        }
        return $dataExists;
    }
}