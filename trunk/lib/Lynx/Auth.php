<?php

  /**
   * @category Lynx
   * @package Lynx_Auth
   * @author Travis Crowder
   * @version $Id$
   */

  class Lynx_Auth {
  	
  	protected $_db = NULL;
  	protected $_table = 'users';
  	protected $_pkey = 'user_id';
  	protected $_userColumn = 'login';
  	protected $_passwordColumn = 'peaches';
  	protected $_user = NULL;
  	protected $_password = NULL;
  	protected $_authType = NULL;
  	protected $_authTypes = array('MD5', 'SHA1');
  	
  	public function __construct(Lynx_Database $db, $user = NULL, $pass = NULL, $authType = NULL){
  		$this->_db = $db;
  		if($user != NULL)
  		  $this->_user = $user;
  		if($pass != NULL)
  		  $this->_password = $pass;
  		if($authType != NULL && in_array($authType, $this->_authTypes))
  		  $this->_authType = $authType;
  	}
  	
  	public function authenticate(){
  		$sql = "SELECT `".$this->_pkey."` FROM `".$this->_table."` WHERE `".$this->_userColumn."` = ? AND `".$this->_passwordColumn."` = ";
  		// check for encryption
  		if(in_array($this->_authType, strtoupper($this->_authTypes)))
  		  $sql .= $this->_authType.'(';
  		$sql .= "?";   		
  		// check for encryption -- close paranthesis
  		if(in_array($this->_authType, strtoupper($this->_authTypes)))
        $sql .= ')';
  		$res = $this->_db->rows($sql, array($this->_user, $this->_password));
  		if(count($res) == 1)
  		  return $res;
  		return false;
  	}
  	
  }