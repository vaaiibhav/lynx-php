<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Permission_Db
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

  require_once('Lynx/Acl/Acl_Permission.php');
  require_once('Lynx/Functions.php');

  class Lynx_Acl_Permission_Db extends Lynx_Acl_Permission {
  	
  	protected $_db = NULL;
  	
  	public function __construct(Lynx_Database $db, $name = NULL, $id = NULL){
  		parent::__construct($id, $name);
  		$this->_db = $db;  		
  	}
  	
  	public function create($name = NULL){
  		if(!empty($name)) $this->setName($name);
  		$this->setId(Lynx_Functions::UUID());
  		$sql = "INSERT INTO `".$this->_db->tablePrefix()."permissions` (`permission_id`, `permission_name`) VALUES (?, ?)";
  		if($this->_db->query($sql, array($this->getId(), $this->getName())))
  		  return $this;
  		else
  		  return false;
  	}
  	
  	public function getById(){
  		$sql = "SELECT `permission_name` FROM `".$this->_db->tablePrefix()."permissions` WHERE `permission_id` = ? LIMIT 1";
  		return $this->_db->row($sql, $this->getId());
  	}
    
  	public function getByName(){
      $sql = "SELECT `permission_id` FROM `".$this->_db->tablePrefix()."permissions` WHERE `permission_name` = ? LIMIT 1";
      return $this->_db->row($sql, $this->getName());
    }
    
    protected function createTable(){
      $sql = "CREATE TABLE `permissions` (
							 `permission_id` char(36) NOT NULL,
							 `permission_name` varchar(36) NOT NULL,
							 PRIMARY KEY  (`permission_id`),
							 UNIQUE KEY `permission_name` (`permission_name`)
							) ENGINE=MyISAM";
      if($this->_db->query($sql))
        return true;
      else
        throw new Exception('Could not create role table');
    }
  	
  }