<?php
  
  /**
   * @category Lynx
   * @package Lynx_Controller_Action
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Controller/Action.php');

  abstract class Lynx_Controller_Action_XHTML extends Lynx_Controller_Action {
  	
  	protected $_registry = NULL;
  	protected $_template = NULL;
  	
  	public function __construct(Lynx_Registry $registry){
  		parent::__construct($registry);
  		require_once('Lynx/Template/XHTML.php');
  		$templateConfig = array('currentModule' => $this->_registry->get('module'), 
  		                        'currentController' => $this->_registry->get('controller'),
  		                        'modulesDirectory' => $this->_registry->get('modulesDirectory'), 
  		                        'fqdn' => $_REQUEST['fqdn']
  		                       );
      $this->_template = new Lynx_Template_XHTML($templateConfig);
      $this->_registry->set('template', $this->_template);
  		
  	}
  	
  	public function __destruct(){
  	  $this->_template->renderLayout('index.phtml');
  	}
  	
  	abstract public function indexAction();
  	
  }