<?php
  
  /**
   * @category Lynx
   * @package Lynx_Controller
   * @author Travis Crowder
   * @version $Id$
   */

  abstract class Lynx_Controller {
  	
  	protected $_registry = NULL;
  	
  	public function __construct(Lynx_Registry $registry){
  		$this->_registry = $registry;
  	}
  	
  	abstract public function indexAction();
  	
  }