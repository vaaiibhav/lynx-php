<?php

  require_once('Lynx/Controller/Action_XHTML.php');
  
  class indexController extends Lynx_Controller_Action_XHTML {
  	
  	public function indexAction(){
  		$this->_template->title('Testing');
  		
  		
      /*
  		// authentication test
  		require_once('Lynx/Auth/Auth_Db.php');
  		require_once('Lynx/Auth.php');
  		#$auth = new Lynx_Auth('db', $this->_registry->get('database'));
  		$auth = new Lynx_Auth_Db($this->_registry->get('database'));
  		$auth->setIdentity('travis')->setCredential('password');
  		#$auth->setTable('users')->setEncryption('SHA1');
  		#$auth->setIdentityColumn('login')->setCredentialColumn('peaches');
  		$userId = $auth->authenticate();
  		if($userId)
  		  echo 'logged in';
  		else
  		  echo 'failed authentication';
  		*/
  		
      // Acl tests
      #require_once('Lynx/Acl.php');
      #require_once('Lynx/Acl/Acl_Db.php');
      #require_once('Lynx/Acl/Acl_Role_Db.php');
      #require_once('Lynx/Acl/Acl_Role_Permission_Db.php');
      #require_once('Lynx/Acl/Acl_Permission_Db.php');
      #require_once('Lynx/Acl/Acl_Permission.php');
      #$acl = Lynx_Acl_Db::getInstance($this->_registry->get('database'), $auth);
      #$acl = Lynx_Acl::getInstance();
      
      #$rolePerms = new Lynx_Acl_Role_Permission_Db($this->_registry->get('database'));
      #$role = new Lynx_Acl_Role_Db($this->_registry->get('database'));
      #$admin = $role->create('admin');
      #$mod = $role->create('mod');
      #$member = $role->create('member');
      #$guest = $role->create('guest');
      
      #$perms = new Lynx_Acl_Permission_Db($this->_registry->get('database'));
      #$skipMaintenance = $perms->create('skip_maintenance');
      #$deletePosts = $perms->create('delete_posts');
      
      #$rolePerms->addPermission($admin, $skipMaintenance);
      #$rolePerms->addPermission($mod, $skipMaintenance);
      #$rolePerms->addPermission($mod, $deletePosts);
      
      #$index = new Lynx_Acl_Permission('view_index');
      #$all = new Lynx_Acl_Permission('all');
      
      #$write = new Lynx_Acl_Permission('write');
      #$del = new Lynx_Acl_Permission('delete');
      #$test = new Lynx_Acl_Permission('test');
      #$moderate = new Lynx_Acl_Permission('moderate');
      #$acl->allow($admin, $all)->allow($guest, $index)->deny($guest, $moderate);
      #$acl->deny($mod, $test)->allow($mod, $del)->allow($mod, $write);
      
      #echo ($acl->isAllowed($mod, new Lynx_Acl_Permission('read'))) ? 'YES' : 'NO';
      #echo ($acl->isAllowed($mod, $write)) ? 'YES' : 'NO';
      #echo ($acl->isAllowed($mod, $test)) ? 'YES' : 'NO';
      #$acl = Lynx_Acl_Db::getInstance($this->_registry->get('database'), $auth);
      #echo '<pre>';
      #print_r($acl);
      #echo 'ADMIN ID = '.$admin->getId().'<br />';
      #print_r($perms->getPermissions($admin));
      #echo '</pre>';
      
  		
  		// validator test
  		/*require_once('Lynx/Validator.php');
  		require_once('Lynx/Validator/Validator_Alnum.php');
  		//$validator = new Lynx_Validator_Alnum();
  		$validator = new Lynx_Validator('alnum');
  		$data = 'ABC 123';
  		$validator->setData($data);
  		$validator->setWhitespace(true);
  		if($validator->isValid())
  		  echo 'VALID';
  		else  
  		  echo 'INVALID';
  		  */
  		/*
  		require_once('Lynx/Validator/Validator_Email.php');
  		$v = new Lynx_Validator_Email();
  		$addresses = array('travis@crowder.com', 
  		                   'me@you.com', 
  		                   'travis.crowder@spechal.com', 
  		                   'travis.crowder@spechal.co.uk', '.travis@spechal.com', '.travis.@spechal.com', 'travis.@spechal.com'
  		              );
  		foreach($addresses as $address){
  			$v->setData($address);
  			if($v->isValid())
  			 echo $address.' is valid.<br />';
  			else
  			 echo $address.' is NOT valid.<br />';
  		}
  		*/
  		/*
  		require_once('Lynx/Validator/Validator_GUID.php');
  		$g = new Lynx_Validator_GUID();
  		$g->setData($g->generate());
  		echo $g->isValid();
  		*/
  		/*
  		 * // Usage tests
  		require_once('Lynx/Usage/Usage_Disk.php');
  		require_once('Lynx/Usage/Usage_Memory.php');
  		$u = new Lynx_Usage_Disk('/var/www2');
  		$m = new Lynx_Usage_Memory();
  		echo $u->usage();
  		echo $m->usage();
  		*/
  	}
  	
  	public function ajaxAction(){
  		$this->_template->renderAjax('ajax');
  	}
  	
  	public function captchaAction(){
  		$this->_template->setNoRender();
  		require_once('Lynx/Captcha.php');
      #$c = new Lynx_Captcha();
      #$c->output();
      echo new Lynx_Captcha();
  	}
  	
  }