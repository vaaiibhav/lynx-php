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
    
  }