<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @author Travis Crowder
   * @version $Id$
   */

  class Lynx_Acl {
  	
  	protected $_roles = array();
  	protected $_resources = array();
  	protected $_hashTable = array();
  	
    public function __construct(){

    }
    
    public function addRole(Lynx_Acl_Role $role, $parent = 0){
    	
    }
    
    public function getRoles(){
    	
    }
    
    public function removeRole(Lynx_Acl_Role $role){
    	
    }
    
    public function addResource(Lynx_Acl_Resource $resource){
    	
    }
    
    public function removeResource(Lynx_Acl_Resource $resource){
    	
    }
    
    public function allow(Lynx_Acl_Role $role, Lynx_Acl_Resource $resource){
    	
    }
    
    public function deny(Lynx_Acl_Role $role, Lynx_Acl_Resource $resource){
    	
    }
    
    public function isAllowed(Lynx_Acl_Role $role, Lynx_Acl_Resource $resource){
    	
    }
  	
  }