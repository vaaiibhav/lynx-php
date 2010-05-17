<?php

  require_once('Lynx/Singleton/Singleton_Abstract.php');
  require_once('Lynx/Request.php');

  class Lynx_Router extends Lynx_Singleton_Abstract {
  	
  	protected $_request = NULL;
  	protected $_modulesDirectory = 'modules';
    protected $_controllersDirectory = 'controllers';
  	
  	protected function __construct(){
  		$this->_request = Lynx_Request::getInstance();
  	}
  	
    /** 
     * getInstance
     * 
     * Method to get an instance of the object
     * @return Lynx_Router self::$_instance
     */
    public static function getInstance(){
      if(self::$_instance == NULL)
       self::$_instance = new Lynx_Router;
      return self::$_instance;
    }
    
    public function getRequest(){
    	return $this->_request;
    }
    
   /**
     * setModulesDirectoryName
     * 
     * Method to set the directory name that houses the modules
     * @param string $name
     */
    final public function setModulesDirectoryName($name){
      $this->_modulesDirectory = $name;
    }
    
    /**
     * setControllersDirectoryName
     * 
     * Method to set the directory name that houses the controllers
     * @param string $name
     */
    final public function setControllersDirectoryName($name){
      $this->_controllersDirectory = $name;
    }
    
    /**
     * getModulesDirectoryName
     * 
     * Method to return the current directory name for the modules
     * @return string
     */
    final public function getModulesDirectoryName(){
      return $this->_modulesDirectory;
    }
    
    /**
     * getControllersDirectoryName
     * 
     * Method to return the current directory name for the controllers
     
     */
    final public function getControllersDirectoryName(){
      return $this->_controllersDirectory;
    }
  	
  }