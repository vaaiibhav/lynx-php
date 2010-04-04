<?php
  
  /**
   * @category Lynx
   * @package Lynx_Session
   * @author Travis Crowder
   * @version $Id$
   */
  
  class Lynx_Session {
  	
  	protected static $_instantiated = FALSE;
  	
  	protected $_variables = array();
  	
  	public function __construct($namespace = 'default'){
  		
  		$this->setSessionNamespace($namespace);
  		
  		if(self::$_instantiated != $namespace){
  			session_start();
  			self::$_instantiated = $namespace;
  		}
  	}
  	
    public function __isset($x){
      if(isset($this->_variables[$x]))
        return true;
      return false;
    }
    
    public function __set($x, $y){
      $this->_variables[$x] = $y;
    }
    
    public function __get($x){
      return $this->_variables[$x];     
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