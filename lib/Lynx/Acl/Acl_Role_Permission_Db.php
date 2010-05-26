<?php

  /**
   * @category Lynx
   * @package Lynx_Acl
   * @subpackage Role_Permission_Db
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