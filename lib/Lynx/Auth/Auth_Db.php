<?php

  /**
   * @category Lynx
   * @package Lynx_Auth_Db
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

  require_once('Lynx/Auth/Auth_Db_Abstract.php');

  class Lynx_Auth_Db extends Lynx_Auth_Db_Abstract {
  	
    protected $_pKey = 'user_id';
    protected $_pKeyValue = NULL;
    protected $_authTypes = array('MD5', 'SHA1');
  	
    public function __construct(Lynx_Database $db, $user = NULL, $pass = NULL, $encryptionType = NULL){
      $this->setDatabase($db);
      if($user != NULL)
        $this->setIdentity($user);
      if($pass != NULL)
        $this->setCredential($pass);
      if($encryptionType != NULL && in_array($encryptionType, $this->_authTypes))
        $this->_authType = $encryptionType;
    }
    
    public function setDatabase(Lynx_Database $db){
    	$this->_db = $db;
    	return $this;
    }
    
  	public function setTable($table){
  		$this->_table = $table;
  		return $this;
  	}
  	
  	public function setPrimaryKey($key){
  		$this->_pKey = $key;
  		return $this;
  	}
  	
  	protected function setPrimaryKeyValue($value){
  		$this->_pKeyValue = $value;
  		return $this;
  	}
  	
  	public function primaryKeyValue(){
  		return $this->_pKeyValue;
  	}
  	
  	public function setIdentityColumn($column){
  		$this->_identityColumn = $column;
  		return $this;
  	}
  	
  	public function setCredentialColumn($column){
  		$this->_credentialColumn = $column;
  		return $this;
  	}
  	
  	public function setEncryption($type){
  		$this->_encryptionType = $type;
  	}
    
    public function authenticate(){
      $sql = "SELECT `".$this->_pKey."` FROM `".$this->_table."` WHERE `".$this->_identityColumn."` = ? AND `".$this->_credentialColumn."` = ";
      // check for encryption
      $sql .= (in_array($this->_encryptionType, $this->_authTypes) ? ($this->_encryptionType . '(?)') : '?');
      
      $result = $this->_db->rows($sql, array($this->_identity, $this->_credential));
      
      if(!empty($result[0][$this->_pKey])){
      	// valid user
        $this->setPrimaryKeyValue($result[0][$this->_pKey]);
        $this->_authenticated = TRUE;
        return true;
      }
        
      return false;
    }
  	
  }