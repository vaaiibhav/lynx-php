<?php
  
  /**
   * @category Lynx
   * @package Lynx_Usage
   * @author Travis Crowder
   * @version $Id$
   */

  abstract class Lynx_Usage_Abstract {
  	
  	protected $_data = NULL;
    protected $_child = NULL;
  	
  	public function __construct($data){
  		$this->_data = $data;
  	}
  	
  	public function setData($data){
  		$this->_data = $this->_child->_data = $data;
  	}
  	
  	abstract public function usage();
  	
    public function out(){
      return $this->_data;
    }
  	
  }