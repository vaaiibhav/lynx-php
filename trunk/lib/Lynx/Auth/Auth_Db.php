<?php

  /**
   * @category Lynx
   * @package Lynx_Auth_Db
   * @author Travis Crowder
   * @version $Id$
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
      if(in_array($this->_encryptionType, $this->_authTypes))
        $sql .= $this->_encryptionType.'(';
      $sql .= "?";      
      // check for encryption -- close paranthesis
      if(in_array($this->_encryptionType, $this->_authTypes))
        $sql .= ')';
      
      $result =  $this->_db->rows($sql, array($this->_identity, $this->_credential));
      if(!empty($result[0][$this->_pKey]))
        $this->setPrimaryKeyValue($result[0][$this->_pKey]);
        
      if(strlen($this->primaryKeyValue()))
        return true;
        
      return false;
    }
  	
  }