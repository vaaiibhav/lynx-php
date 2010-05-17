<?php
  
  /**
   * @category Lynx
   * @package Lynx_Usage
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Usage/Usage_Abstract.php');

  class Lynx_Usage_Memory extends Lynx_Usage_Abstract {
    
    public function __construct($directory = NULL){
      $this->_data = $directory;
    }
    
    /**
     * Calls memory_get_usage(true)
     * 
     * @return int Number of bytes bing used
     */
    public function usage(){
    	return memory_get_usage(true);
    }
    
    /**
     * Calls memory_get_peak_usage(true)
     * 
     * @return int Number of bytes at peak usage
     */
    public function peak(){
    	return memory_get_peak_usage(true);
    }
    
    /**
     * Get the ini setting for memory_limit
     * 
     * @return int Memory limit in bytes
     */
    public function limit(){
    	return ini_get('memory_limit');
    }
    
  }