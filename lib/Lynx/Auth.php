<?php

  /**
   * @category Lynx
   * @package Lynx_Auth
   * @author Travis Crowder
   * @version $Id$
   */

  /** this class is busted for now ... **/

  require_once('Lynx/Auth/Auth_Abstract.php');

  class Lynx_Auth extends Lynx_Auth_Abstract {
  	
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
    
    public function authenticate(){
    	return $this->_adapter->authenticate();
    }
    
    public function __call($name, $args){
      return $this->_adapter->$name($args);
    }
  	
  }