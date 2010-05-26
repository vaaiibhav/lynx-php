<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Role_Permission_Db
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Acl/Acl_Permission_Abstract.php');
  require_once('Lynx/Functions.php');

  class Lynx_Acl_Role_Permission_Db extends Lynx_Acl_Permission_Abstract {
  	
  	public function hasPermission(Lynx_Acl_Role_Db $role, Lynx_Acl_Permission_Db $permission){
  		//
  	}
  	
  	public function addPermission(Lynx_Acl_Role_Db $role, Lynx_Acl_Permission_Db $permission){
      $id = Lynx_Functions::UUID();
      $sql = "INSERT INTO `".$this->_db->tablePrefix()."role_permissions` (`rp_id`, `role_id`, `permission_id`) VALUES (?, ?, ?)";
      if($this->_db->query($sql, array($id, $role->getId(), $permission->getId())))
      	return $id;
      else
      	throw new Exception('Could not add permission');
  	}
  	
  	public function removePermission(Lynx_Acl_Role_Db $role, Lynx_Acl_Permission_Db $permission){
      $sql = "DELETE FROM `".$this->_db->tablePrefix()."role_permissions` WHERE `role_id` = ? AND `permission_id` = ? LIMIT 1";
      if($this->_db->query($sql, array($role->getId(), $permission->getId())))
        return true;
      else
        throw new Exception('Could not remove permission');
  	}
  	
    public function removePermissionById($id){
      $sql = "DELETE FROM `".$this->_db->tablePrefix()."role_permissions` WHERE `rp_id` = ? LIMIT 1";
      if($this->_db->query($sql, array($id)))
        return true;
      else
        throw new Exception('Could not remove permission');
    }
    
    protected function createTable(){
      $sql = "CREATE TABLE `role_permissions` ( 
                `rp_id` char(36) NOT NULL, 
                `role_id` char(36) NOT NULL, 
                `permission_id` char(36) NOT NULL, 
                PRIMARY KEY  (`rp_id`), 
                KEY `role_id` (`role_id`)
              ) ENGINE=MyISAM";
      if($this->_db->query($sql))
        return true;
      else
        throw new Exception('Could not create permission table');
    }
  	
  }