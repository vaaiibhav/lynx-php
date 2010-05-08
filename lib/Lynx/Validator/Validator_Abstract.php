<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator_Alnum
   * @author Travis Crowder
   * @version $Id$
   */

  abstract class Lynx_Validator_Abstract {
  	
  	protected $_data = NULL;
    protected $_validator = NULL;
  	
  	public function __construct($data){
  		$this->_data = $data;
  	}
  	
  	public function setData($data){
  		$this->_data = $this->_validator->_data = $data;
  	}
  	
  	abstract public function isValid();
  	
    public function out(){
      return $this->_data;
    }
  	
  }