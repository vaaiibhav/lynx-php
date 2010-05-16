<?php
  
  /**
   * @category Lynx
   * @package Lynx_Singleton
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Singleton/Singleton_Abstract.php');

  class Lynx_Singleton extends Lynx_Singleton_Abstract {
  	
  	protected static $_instance = NULL;
  	
  	protected static $_class = __CLASS__;
  	
  	protected function __construct(){ if(function_exists('get_called_class')) self::$_class = get_called_class(); }
  	
  	/**
  	 * getInstance
  	 * 
  	 * Method to get an instance of the class.
  	 * getInstance in this particular class will never be called, 
  	 * but is defined to require child definitions
  	 * 
  	 * @throws Exception Cannot be called
  	 */
    public static function getInstance(){
      throw new Exception('Cannot call '.__METHOD__);
    }
  	
  }
  
  