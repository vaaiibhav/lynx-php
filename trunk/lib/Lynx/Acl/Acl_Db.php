<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Acl/Acl_Abstract.php');

  class Lynx_Acl_Db extends Lynx_Acl_Abstract {
  	
  	protected $_db = NULL;
  	protected $_roles = array();
  	
    public function __construct(Lynx_Database $db){
    	$this->_db = $db;
    }
    
    public function addRole(Lynx_Acl_Role $role){
    	foreach($this->_roles as $object)
    	  if($object === $role)
    	    return true;
    	$this->_roles[] = $role;
    }
    
    public function getRoles(){
    	return $this->_roles;
    }
    
    public function removeRole(Lynx_Acl_Role $role){
    	foreach($this->_roles as $key => $object)
        if($object === $role)
          unset($this->_roles[$key]);
    }
    
    public function allow(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission){

    }
    
    public function deny(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission){
    	
    }
    
    public function isAllowed(Lynx_Acl_Role $role, Lynx_Acl_Resource $resource){
    	
    }
  	
  }