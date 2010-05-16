<?php

  require_once('Lynx/Controller/Action.php');
  
  class indexController extends Lynx_Controller_Action {
  	
  	public function __destruct(){
  		$this->_registry->get('template')->renderLayout('index.phtml');
  	}
  	
  	public function indexAction(){
  		require_once('Lynx/Template/XHTML.php');
  		$templateConfig = array('currentModule' => $this->_registry->get('module'), 
  		                        'currentController' => $this->_registry->get('controller'),
  		                        'modulesDirectory' => $this->_registry->get('modulesDirectory'), 
  		                        'fqdn' => $_REQUEST['fqdn']
  		                       );
      $Template = new Lynx_Template_XHTML($templateConfig);
      $this->_registry->set('template', $Template);
  		$this->_registry->get('template')->title('Testing');
  		
  		// authentication test
  		require_once('Lynx/Auth/Auth_Db.php');
  		require_once('Lynx/Auth.php');
  		#$auth = new Lynx_Auth('db', $this->_registry->get('database'));
  		$auth = new Lynx_Auth_Db($this->_registry->get('database'));
  		$auth->setIdentity('travis');
  		$auth->setCredential('password');
  		$auth->setTable('users');
  		$auth->setIdentityColumn('login');
  		$auth->setCredentialColumn('peaches');
  		$auth->setEncryption('SHA1');
  		$userId = $auth->authenticate();
  		if($userId)
  		  echo 'logged in';
  		else
  		  echo 'failed authentication';
  		  
  		
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
  		#require_once('Lynx/Usage/Usage_Disk.php');
  		#require_once('Lynx/Usage/Usage_Memory.php');
  		#$u = new Lynx_Usage_Disk('/var/www2');
  		#$m = new Lynx_Usage_Memory();
  		#echo $u->usage();
  		#echo $m->usage();  		
  	}
  	
  }