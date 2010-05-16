<?php
  
  /**
   * @category Lynx
   * @package Lynx_Usage
   * @author Travis Crowder
   * @version $Id$
   */

  class Lynx_Usage {
  	
  	public function __construct($whichUsage = NULL, $data = NULL){
  		
  		switch($whichUsage){
  			case 'disk':
  				require_once('Lynx/Usage/Usage_Disk.php');
  				$this->_child = new Lynx_Usage_Disk($this->_data);
  			case 'memory':
          require_once('Lynx/Usage/Usage_Memory.php');
          $this->_child = new Lynx_Usage_Memory();
  			default:
  				break;
  		}
  		
  	}
  	
  	/**
  	 * Calls child usage class methods
  	 * 
  	 * @param string $name Method name
  	 * @param mixed $args Method arguements
  	 */
    public function __call($name, $args){
      $this->_child->$name($args);
    }
  	
  }