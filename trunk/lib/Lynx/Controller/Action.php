<?php
  
  /**
   * @category Lynx
   * @package Lynx_Controller_Action
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Controller.php');

  abstract class Lynx_Controller_Action extends Lynx_Controller {
  	
  	protected $_registry = NULL;
  	
  	public function __construct(Lynx_Registry $registry){
  		parent::__construct($registry);
  	}
  	
  }