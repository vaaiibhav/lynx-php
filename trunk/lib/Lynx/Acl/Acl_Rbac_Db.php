<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @author Travis Crowder
   * @version $Id$
   * 
   * 
		NEW BSD LICENSE
		Copyright (c) 2009-2010, Travis Crowder
		All rights reserved.
		
		Redistribution and use in source and binary forms, with or without modification,
		are permitted provided that the following conditions are met:
		
		    * Redistributions of source code must retain the above copyright notice,
		      this list of conditions and the following disclaimer.
		
		    * Redistributions in binary form must reproduce the above copyright notice,
		      this list of conditions and the following disclaimer in the documentation
		      and/or other materials provided with the distribution.
		
		    * Neither the name of Travis Crowder nor the names of its
		      contributors may be used to endorse or promote products derived from this
		      software without specific prior written permission.
		
		THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
		ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
		WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
		DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
		ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
		(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
		LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
		ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
		(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
		SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
   */

  require_once('Lynx/Singleton.php');
  require_once('Lynx/Acl/Acl_Role_Db.php');
  require_once('Lynx/Acl/Acl_Permission_Db.php');
  require_once('Lynx/Acl/Acl_Role_Permission_Db.php');
  require_once('Lynx/Acl/Acl_Auth_Role_Db.php');

  class Lynx_Acl_Rbac_Db extends Lynx_Singleton {
  	
  	protected static $_instance = NULL;
  	
  	protected $_db = NULL;
  	protected $_hashTable = array();
  	protected $_exempt = FALSE;
  	protected $_auth = NULL;
  	protected $_roles = array();
  	protected $_permissions = array();
  	
  	protected function __construct(Lynx_Database $db, Lynx_Auth_Abstract $auth){
  		$this->_db = $db;
  	  $this->_auth = $auth;
  	  if($this->_auth->authenticated()){
  	  	// load permissions
  	  	$Lynx_Acl_Auth_Role_Db = new Lynx_Acl_Auth_Role_Db($db, $auth);
  	  	$this->_roles = $Lynx_Acl_Auth_Role_Db->getRoles();
  	  	$Lynx_Acl_Role_Permission_Db = new Lynx_Acl_Role_Permission_Db($db);
  	  	foreach($this->_roles as $key => $array){
  	  		$tmp = new Lynx_Acl_Role_Db($db);
  	  		$tmp->load($array['role_id']);
  	  		$perms = $Lynx_Acl_Role_Permission_Db->getPermissions($tmp);
  	  		$this->_roles[$key] = $tmp;
  	  		if(!empty($perms)){
  	  			foreach($perms as $key => $arr){
  	  		    $Lynx_Acl_Permission = $this->_permissions[] = new Lynx_Acl_Permission($arr['permission_name'], $arr['permission_id']);
  	  		    $this->allow($this->_roles[$key], $Lynx_Acl_Permission);
  	  			}
  	  		}
  	  	}
  	  }
  	}
  	
  	/**
  	 * @params Lynx_Auth_Abstract Instance of a class the extends Lynx_Auth_Abstract
  	 */
  	public static function getInstance(){
  		$args = func_get_args();
  		if(func_num_args() != 2)
  		  throw new Exception(__METHOD__.' requires Lynx_Databaes and Lynx_Auth_Abstract');
  		if(!($args[0] instanceof Lynx_Auth_Abstract) && !($args[0] instanceof Lynx_Database))
  		  throw new Exception('Arguement 1 of '.__METHOD__.' must be of type Lynx_Auth_Abstract');
  		if(!($args[1] instanceof Lynx_Auth_Abstract) && !($args[1] instanceof Lynx_Database))
        throw new Exception('Arguement 2 of '.__METHOD__.' must be of type Lynx_Database');
        
      if($args[0] instanceof Lynx_Database)
        $db = $args[0];
      else
        $db = $args[1];
        
      if($args[0] instanceof Lynx_Auth_Abstract)
        $auth = $args[0];
      else
        $auth = $args[1];
  		  
  		if(self::$_instance == NULL)
  		  self::$_instance = new Lynx_Acl_Rbac_Db($db, $auth);
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
    
    public function isAllowed($permission){
    	if(!($permission instanceof Lynx_Acl_Permission))
    	  $permission = new Lynx_Acl_Permission($permission);
    	if($this->_exempt)
    	  return true;
    	foreach($this->_roles as $role)
    	  if(!empty($this->_hashTable[$role->getName()][$permission->getName()]))
    	    return true;
    	return false;
    }
  	
  }