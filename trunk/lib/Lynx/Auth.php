<?php

  /**
   * @category Lynx
   * @package Lynx_Auth
   * @author Travis Crowder
   * @version $Id$
   */

  class Lynx_Auth {
  	
  	protected $_adapter = NULL;
  	
    public function __construct($whichAdapter = NULL, $params = NULL){
      $this->factory($whichAdapter, $params);
    }
    
    public function factory($whichAdapter = NULL, $params = NULL){
      switch($whichAdapter){
        case 'db':
        case 'database':
          require_once('Lynx/Auth/Auth_Db.php');
          $this->_adapter = new Lynx_Auth_Db($params);
        default:
          break;
      }
      return $this->_adapter;
    }
    
    public function __call($name, $args){
    	return call_user_func_array(array($this->_adapter, $name), $args);
    }
  	
  }