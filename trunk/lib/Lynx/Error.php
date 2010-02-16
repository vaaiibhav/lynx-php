<?php

  /**
   * @category Lynx
   * @package Lynx_Error
   * @author Travis Crowder
   * @version $Id$
   */

  /**
   * Lynx_Error
   * 
   * Error handler class
   */

  class Lynx_Error {
  	
  	public function __construct(){ }
  	
  	public function error($errNo, $errStr, $errFile, $errLine){
  		die($errStr.' in '.$errFile.' on line '.$errNo);
  	}
  	
  }