<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @author Travis Crowder
   * @version $Id$
   */

  abstract class Lynx_Acl_Abstract {
    
    abstract public function addRole(Lynx_Acl_Role $role);
    
    abstract public function removeRole(Lynx_Acl_Role $role);
    
    abstract public function allow(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission);
    
    abstract public function deny(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission);
    
    abstract public function isAllowed(Lynx_Acl_Role $role, Lynx_Acl_Resource $resource);
  	
  }