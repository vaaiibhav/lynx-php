<?php
  
  /**
   * @category Lynx
   * @package Lynx_Usage_Memory
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Usage/Usage_Abstract.php');

  class Lynx_Usage_Memory extends Lynx_Usage_Abstract {
    
    public function __construct($directory = NULL){
      $this->_data = $directory;
    }
    
    public function usage(){
    	return memory_get_usage(true);
    }
    
    public function peak(){
    	return memory_get_peak_usage(true);
    }
    
  }