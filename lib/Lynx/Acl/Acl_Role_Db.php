<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Role_Db
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Acl/Acl_Role.php');

  class Lynx_Acl_Role_Db extends Lynx_Acl_Role {
  	
  	protected $_db = NULL;
  	
  	public function __construct(Lynx_Database $db, $name, $id = NULL){
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
  	
  	public function create(){
  		$this->setId(Lynx_Functions::UUID());
  		$sql = "INSERT INTO `".$this->_db->tablePrefix()."roles` (`role_id`, `role_name`) VALUES (?, ?)";
      return $this->_db->query($sql, array($this->getId(), $this->getName()));
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