<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Role_Db
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

  require_once('Lynx/Acl/Acl_Role.php');

  class Lynx_Acl_Role_Db extends Lynx_Acl_Role {
  	
  	protected $_db = NULL;
  	
  	public function __construct(Lynx_Database $db, $name = NULL, $id = NULL){
  		parent::__construct($name, $id);
  		$this->_db = $db;
  	}
  	
  	public function load($id = NULL){
  		if(!empty($id)) $this->setId($id);
  		$sql = "SELECT `role_name` FROM `".$this->_db->tablePrefix()."roles` WHERE `role_id` = ? LIMIT 1";
  		$data = $this->_db->row($sql, array($this->getId()));
  		if(!empty($data))
  		  $this->setName($data['role_name']);
  		return $this;
  	}
  	
  	public function all(){
  		$sql = "SELECT `role_id`, `role_name` FROM `".$this->_db->tablePrefix()."roles` LIMIT 1";
  		return $this->_db->rows($sql);
  	}
  	
  	public function create($name = NULL){
  		if(!empty($name)) $this->setName($name);
  		$this->setId(Lynx_Functions::UUID());
  		$sql = "INSERT INTO `".$this->_db->tablePrefix()."roles` (`role_id`, `role_name`) VALUES (?, ?)";
      if($this->_db->query($sql, array($this->getId(), $this->getName())))
        return $this;
      else
        return false;
  	}
  	
  	public function remove(){
  		$sql = "DELETE FROM `".$this->_db->tablePrefix()."roles` WHERE `role_id` = ? LIMIT 1";
  		return $this->_db->query($sql, array($this->getId()));
  	}
  	
    protected function createTable(){
      $sql = "CREATE TABLE `roles` (
							 `role_id` char(36) NOT NULL,
							 `role_name` varchar(36) NOT NULL,
							 PRIMARY KEY  (`role_id`)
							) ENGINE=MyISAM";
      if($this->_db->query($sql))
        return true;
      else
        throw new Exception('Could not create role table');
    }
    
  }