<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @author Travis Crowder
   * @version $Id$
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

  require_once('Lynx/Acl.php');

  class Lynx_Acl_Db extends Lynx_Acl {
  	
  	/**
  	 * @var Lynx_Database
  	 */
  	protected $_db = NULL;
    
  	/**
  	 * @param Lynx_Database $db
  	 * @param Lynx_Auth_Abstract $auth
  	 */
    protected function __construct(Lynx_Database $db, Lynx_Auth_Abstract $auth){
    	$this->_db = $db;
      $this->_auth = $auth;
      if($auth->authenticated()){
      	// get and load permissions
      }
    }
    
    /**
     * @param Lynx_Database
     * @param Lynx_Auth_Abstract
     */
    public static function getInstance(){
    	$args = func_get_args();
      if(func_num_args() != 2)
        throw new Exception(__METHOD__.' requires 2 parameters of type Lynx_Database and Lynx_Auth_Abstract');
      
      if($args[0] instanceof Lynx_Database)
        $db = $args[0];
      elseif($args[1] instanceof Lynx_Database)
        $db = $args[1];
      else
        throw new Exception(__METHOD__.' expects Lynx_Database');

      if($args[0] instanceof Lynx_Auth_Abstract)
        $auth = $args[0];
      elseif($args[1] instanceof Lynx_Auth_Abstract)
        $auth = $args[1];
      else
        throw new Exception(__METHOD__.' expects Lynx_Auth_Abstract');  
      
      if(self::$_instance == NULL)
        self::$_instance = new Lynx_Acl_Db($db, $auth);
      return self::$_instance;
    }
  	
  }