<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Permission_Db
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Acl/Acl_Permission_Abstract.php');
  require_once('Lynx/Functions.php');

  class Lynx_Acl_Permission_Db extends Lynx_Acl_Permission_Abstract {
  	
  	protected $_db = NULL;
  	
  	public function __construct(Lynx_Database $db, $name = NULL, $id = NULL){
  		parent::__construct($id, $name);
  		$this->_db = $db;  		
  	}
  	
  	public function create(){
  		$this->setId(Lynx_Functions::UUID());
  		$sql = "INSERT INTO `".$this->_db->tablePrefix()."permissions` (`permission_id`, `permission_name`) VALUES (?, ?)";
  		return $this->_db->query($sql, array($this->getId(), $this->getName()));
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