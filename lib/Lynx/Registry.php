<?php
  /**
   * @category Lynx
   * @package Lynx_Registry
   * @author Travis Crowder
   * @version $Id$
   */
  /**
   * Lynx_Registry
   * 
   * Registry class
   */

  class Lynx_Registry {
  	
  	public static $instance = NULL;
  	
  	protected static $_registry = array();
  	
  	protected function __construct(){
  		
  	}
  	
  	/**
  	 * getInstance
  	 * 
  	 * Method to get an instance of the registry
  	 * @return Lynx_Registry self::$_instance
  	 */
  	public static function getInstance(){
  		if(self::$instance == NULL){
  			self::$instance = new Lynx_Registry();
  		}
  		return self::$instance;
  	}
  	
  	/**
  	 * get
  	 * 
  	 * Method to get the value stored
  	 * 
  	 * @param unknown_type $element
  	 * @return mixed self::$_registry[$element]
  	 * @throws Exception if registry element is not set
  	 */
  	public function get($element){
  		if(isset(self::$_registry[$element]))
  		  return self::$_registry[$element];
  		throw new Exception("Registry element [" . $element . "] is not set.");
  	}
  	
  	/**
  	 * set
  	 * 
  	 * Method to set add or update a value to the registry
  	 * 
  	 * @param unknown_type $element
  	 * @param unknown_type $value
  	 * @return void
  	 */
  	public function set($element, $value){
  		self::$_registry[$element] = $value;
  		return $this;
  	}
  	
  }