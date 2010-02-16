<?php

  require_once('Lynx/Controller/Action.php');
  
  class indexController extends Lynx_Controller_Action {
  	
  	public function __destruct(){
  		$this->_registry->get('template')->renderLayout('index.phtml');
  	}
  	
  	public function indexAction(){
  		require_once('Lynx/Template/XHTML.php');
  		$templateConfig = array('currentModule' => $this->_registry->get('module'), 
  		                        'modulesDirectory' => $this->_registry->get('modulesDirectory')
  		                       );
      $Template = new Lynx_Template_XHTML($templateConfig);
      $this->_registry->set('template', $Template);
  		$this->_registry->get('template')->title('Testing');
  	}
  	
  }