<?php

  /**
   * This bit is used to demonstrate the Auth/ACL
   */

  require_once('Lynx/Controller/Action_XHTML.php');
  
  class indexController extends Lynx_Controller_Action_XHTML {
  	
  	/**
  	 * @var $_auth Lynx_Auth Holds authentication object
  	 */
  	protected $_auth = NULL;
  	
  	/**
  	 * @var $_acl Lynx_Acl_Abstract
  	 */
  	protected $_acl = NULL;
  	
  	/**
  	 * Require an authenticated user
  	 * 
  	 * @param Lynx_Registry $registry
  	 */
  	public function __construct(Lynx_Registry $registry){
  		parent::__construct($registry);
  		$this->_template->setCurrentTemplate('lynx');
  		require_once('Lynx/Auth/Auth_Db.php');
  		require_once('Lynx/Acl/Acl_Rbac_Db.php');
  		$this->_auth = new Lynx_Auth_Db($registry->get('database'));
  		$_SESSION['Lynx_Auth_ID'] = 'b4764fae-3fc5-11df-bc54-001fe25a4467';
  		if(!empty($_SESSION['Lynx_Auth_ID'])){
  			// load the user by ID
  			$this->_auth->setAuthenticated(TRUE)->loadByKey($_SESSION['Lynx_Auth_ID']);
  		}
  		$this->_acl = Lynx_Acl_Rbac_Db::getInstance($registry->get('database'), $this->_auth);
  		#$this->_acl = Lynx_Acl_Rbac::getInstance($this->_auth);
  	}
  	
  	public function indexAction(){
  		
  		#echo '<pre>'; print_r($this->_acl); echo '</pre>';
  		
  		if(!$this->_acl->isAllowed('skip_maintenance'))
  		  $this->_template->content = 'You are not welcome.';
  		else
  		  $this->_template->content = 'Welcome!';
  		  
  		$this->_template->title('Admin');
  	}
  	
  }