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
  	
    public function __construct(Lynx_Database $db){
    	$this->_db = $db;
    }
    
    public function allow(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission){

    }
    
    public function deny(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission){
    	
    }
    
    public function isAllowed(Lynx_Acl_Role $role, Lynx_Acl_Resource $resource){
    	
    }
  	
  }