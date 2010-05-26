<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Role
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Element.php');

  class Lynx_Acl_Role extends Lynx_Element_Abstract {

  	protected $_parent = NULL;
  	
  	public function __construct($name, $id = NULL){
  		$this->setName($name);
  		if(!empty($id)) $this->setId($id);
  	}
  	
  	public function __toString(){
  		return $this->_name;
  	}
  	
  	public function setParent($parent = NULL){
  		$this->_parent = $parent;
  	}
  	
  	public function getParent(){
  		return $this->_parent;
  	}
    
  }