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
  		                        'modulesDirectory' => $this->_registry->get('modulesDirectory')
  		                       );
      $Template = new Lynx_Template_XHTML($templateConfig);
      $this->_registry->set('template', $Template);
  		$this->_registry->get('template')->title('Testing');
  		
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
  	}
  	
  }