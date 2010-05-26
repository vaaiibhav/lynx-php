<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Role
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Acl/Acl_Permission_Abstract.php');

  class Lynx_Acl_Permission extends Lynx_Acl_Permission_Abstract {

  	protected $_parent = NULL;
  	
  	public function __construct($name, $id = NULL){
  		$this->setName($name);
  		if(!empty($id)) $this->setId($id);
  	}
  	
  	public function __toString(){
  		return $this->_name;
  	}
    
  }