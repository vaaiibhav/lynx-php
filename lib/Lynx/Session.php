<?php
  
  /**
   * @category Lynx
   * @package Lynx_Session
   * @author Travis Crowder
   * @version $Id$
   */
  
  class Lynx_Session {
  	
  	protected static $_instantiated = FALSE;
  	
  	public function __construct($namespace = 'default'){
  		
  		$this->setSessionNamespace($namespace);
  		
  		if(self::$_instantiated != $namespace){
  			session_start();
  			self::$_instantiated = $namespace;
  		}
  	}
  	
  	public function getSessionNamespace(){
  		return session_name();
  	}
  	
  	public function setSessionNamespace($namespace){
  		return session_name($namespace);
  	}
  	
  	public function get($index){
  		return $_SESSION[$index];
  	}
  	
  	public function set($index, $value){
  		$_SESSION[$index] = $value;
  	}
  	
  }