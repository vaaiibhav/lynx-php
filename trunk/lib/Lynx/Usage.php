<?php
  
  /**
   * @category Lynx
   * @package Lynx_Usage
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Usage/Usage_Abstract.php');

  class Lynx_Usage extends Lynx_Usage_Abstract {
  	
  	public function __construct($whichUsage = NULL, $data = NULL){
  		$this->_data = $data;
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
  	
  	public function usage(){
  		return $this->_child->usage();
  	}
  	
    public function __call($name, $args){
      $this->_child->$name($args);
    }
  	
  }