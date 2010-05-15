<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator_Email
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Validator/Validator_Abstract.php');

  class Lynx_Validator_Email extends Lynx_Validator_Abstract {
  	
  	protected $_checkDNS = FALSE;
  	
  	public function __construct($data = NULL){
  		$this->_data = $data;
  		// check DNS by default
  		$this->setCheckDNS(FALSE);
  	}
  	
  	public function setCheckDNS($bool){
  		$this->_checkDNS = (bool)$bool;
  		return $this;
  	}
  	
  	public function checkDNS($host, $type){
  		if($this->_checkDNS)
  		  if(!$this->verifyDNS($host, $type))
  		    return false;
  		return true;
  	}
  	
  	protected function verifyDNS($host, $type){
  		return checkdnsrr($host, $type);
  	}
  	
  	public function isValid(){

	    if(!preg_match('#@#', $this->_data)) return false;
	    
	    $temp = preg_split('#@#', $this->_data);
	    if(count($temp) != 2) return false;

	    $local = $temp[0];
	    $domain = $temp[1];
	    
	    // make sure neither is too long
	    if(strlen($local) > 64 || strlen($domain) > 255) return false;
	    
	    // check for valid local part
	    if($local[0] == '.' || $local[strlen($local)-1] == '.') return false;
	    
  	  // verify the local characters
      if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))){
        if(!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
          return false;                 
      }
	    
	    // check for valid domain part
	    if(!preg_match('#^[-\.a-z0-9]+$#i', $domain)) return false;
	    
	    // verify no double dots
	    if(preg_match('#\\.\\.#', $domain)) return false;
	    
	    if(!$this->checkDNS($domain, 'MX') || !$this->checkDNS($domain, 'A')) return false;
	
	    return true;
  		
  	}
  	
  }