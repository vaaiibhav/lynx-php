<?php

  /**
   * This bit is used to log users in via Lynx_Auth
   */

  require_once('Lynx/Controller/Action_XHTML.php');
  
  class loginController extends Lynx_Controller_Action_XHTML {
  	
  	public function __construct(Lynx_Registry $registry){
  		parent::__construct($registry);
      $this->_template->setCurrentTemplate('lynx');
      $this->_template->addScript('jquery.min');
  	}
  	
	  public function indexAction(){
	      
	  	$this->_registry->get('template')->title('Login :: Lynx Framework');
	  
	    if(isset($_POST['submit'])){
	      // check it out
	      require_once('Lynx/Auth/Auth_Db.php');
	      $auth = new Lynx_Auth_Db($this->_registry->get('database'));
	      $auth->setIdentity($_POST['user'])->setCredential($_POST['pass']);
	      if($auth->authenticate()){
	        $_SESSION['Lynx_Auth_ID'] = $auth->primaryKeyValue();
	        header('Location: http://'.$_REQUEST['fqdn'].'/index.php/lynx');
	        exit;
	      } else {
	        $this->_template->error = "Authentication failure.";
	      }
	    }
	  }
  
	  public function quitAction(){
	    session_destroy();
	    header('Location: /index.php');
	    exit;
	  }
  	
  }