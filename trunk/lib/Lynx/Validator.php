<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Validator/Validator_Abstract.php');

  class Lynx_Validator extends Lynx_Validator_Abstract {
  	
  	public function __construct($whichValidator = NULL, $data = NULL){
  		$this->_data = $data;
  		switch($whichValidator){
  			case 'alnum':
  				require_once('Validator/Validator_Alnum.php');
  				$this->_validator = new Lynx_Validator_Alnum($this->_data);
  			default:
  				break;
  		}
  	}
  	
  	public function isValid(){
  		return $this->_validator->isValid();
  	}
  	
    public function __call($name, $args){
      $this->_validator->$name($args);
    }
  	
  }