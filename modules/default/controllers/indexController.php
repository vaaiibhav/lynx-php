<?php

  require_once('Lynx/Controller/Action.php');
  
  class indexController extends Lynx_Controller_Action {
  	
  	public function __destruct(){
  		$this->_registry->get('template')->render('index.phtml');
  	}
  	
  	public function indexAction(){
  		require_once('Lynx/Template/XHTML.php');
      $Template = new Lynx_Template_XHTML($this->_registry);
      $this->_registry->set('template', $Template);
  		$this->_registry->get('template')->title('Testing');
  	}
  	
  }