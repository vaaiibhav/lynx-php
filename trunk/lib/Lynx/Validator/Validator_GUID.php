<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator_GUID
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Validator/Validator_Abstract.php');

  class Lynx_Validator_GUID extends Lynx_Validator_Abstract {
    
    public function __construct($data = NULL){
      $this->_data = $data;
    }
    
    public function isValid(){
      return preg_match('#^[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}$#', $this->_data);
    }
    
    public function generate(){
    	return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
					      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
					      mt_rand(0, 0x0fff) | 0x4000,
					      mt_rand(0, 0x3fff) | 0x8000,
					      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }
    
  }