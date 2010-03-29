<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator_Alnum
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Validator/Validator_Abstract.php');

  class Lynx_Validator_Alnum extends Lynx_Validator_Abstract {
  	
  	protected $_whitespace = NULL;
  	
  	public function __construct($data = NULL, $whitespace = FALSE){
  		$this->_data = $data;
  		$this->_whitespace = $whitespace;
  	}
  	
  	public function isValid(){
  		$regex = '#^[0-9A-Z';
  		if($this->_whitespace)
  		  $regex .= '\x20';
  		$regex .= ']+$#i';
  		if(preg_match($regex, $this->_data))
  		  return true;
  		return false;
  	}
  	
  	public function setWhitespace($bool){
  		$this->_whitespace = (bool)$bool;
  	}
  	
  }