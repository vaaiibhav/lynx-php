<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Singleton/Singleton_Abstract.php');

  class Lynx_Acl extends Lynx_Singleton_Abstract {
  	
  	protected static $_instance = NULL;
  	
  	protected $_hashTable = array();
  	protected $_exempt = FALSE;
  	
  	protected function __construct(){ }
  	
  	public static function getInstance(){
  		if(self::$_instance == NULL)
  		  self::$_instance = new Lynx_Acl();
  		return self::$_instance;
  	}
    
  	public function exempt(){
  		$this->_exempt = TRUE;
  	}
  	
    public function allow(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission){
    	$this->_hashTable[$role->getName()][$permission->getName()] = TRUE;
    	return $this;
    }
    
    public function deny(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission){
      $this->_hashTable[$role->getName()][$permission->getName()] = FALSE;
      return $this;
    }
    
    public function isAllowed(Lynx_Acl_Role $role, Lynx_Acl_Permission $permission){
    	if($this->_exempt || !empty($this->_hashTable[$role->getName()][$permission->getName()]))
    	  return true;
    	return false;
    }
  	
  }