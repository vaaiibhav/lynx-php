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

  class Lynx_Acl_Rbac {
  	
  	protected static $_instance = NULL;
  	
  	protected $_hashTable = array();
  	protected $_exempt = FALSE;
  	protected $_auth = NULL;
  	
  	protected function __construct(Lynx_Auth_Abstract $auth){
  	  $this->_auth = $auth;
  	}
  	
  	/**
  	 * @param $args Lynx_Auth_Abstract
  	 */
  	public static function getInstance(){
  		$args = func_get_args();
  		if(func_num_args() != 1 || !($args[0] instanceof Lynx_Auth_Abstract))
  		  throw new Exception('Arguement 1 of '.__METHOD__.' must be of type Lynx_Auth_Abstract');
  		  
  		if(self::$_instance == NULL)
  		  self::$_instance = new Lynx_Acl_Rbac($args[0]);
  		return self::$_instance;
  	}
    
  	public function exempt(){
  		$this->_exempt = TRUE;
  	}
  	
    public function allow($role, $permission){
    	$this->_hashTable[$role][$permission] = TRUE;
    	return $this;
    }
    
    public function deny($role, $permission){
      $this->_hashTable[$role][$permission] = FALSE;
      return $this;
    }
    
    public function isAllowed($role, $permission){
    	if($this->_exempt || !empty($this->_hashTable[$role][$permission]))
    	  return true;
    	return false;
    }
  	
  }