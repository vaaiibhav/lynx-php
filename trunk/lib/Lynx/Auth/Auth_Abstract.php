<?php

  /**
   * @category Lynx
   * @package Lynx_Auth_Abstract
   * @author Travis Crowder
   * @version $Id$
   */

  abstract class Lynx_Auth_Abstract {
  	
  	protected $_identity = NULL;
  	protected $_credential = NULL;
  	
  	public function setIdentity($identity){
  		$this->_identity = $identity;
  		return $this;
  	}
  	
  	public function setCredential($credential){
  		$this->_credential = $credential;
      return $this;  		
  	}
  	
  	abstract public function authenticate();
  	
  }