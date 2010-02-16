<?php
  /**
   * @category Lynx
   * @package Lynx_Controller_Front
   * @author Travis Crowder
   * @version $Id$
   */

  /**
   *  Lynx_Controller_Front
   *
   *  Class used to control the program flow via FrontController pattern
   */

  require_once('Lynx/Router.php');

  class Lynx_Controller_Front {
    
    static protected $_instance = NULL;
    
    protected $_modulesDirectory = 'modules';
    protected $_controllersDirectory = 'controllers';
    
    protected function __construct(){
      $this->start();
    }
    
    /** 
     * getInstance
     * 
     * Method to get an instance of the object
     * @return Lynx_Controller_Front self::$_instance
     */
    public static function getInstance(){
    	if(self::$_instance == NULL)
    	 self::$_instance = new Lynx_Controller_Front;
    	return self::$_instance;
    }
    
    /**
     *  __clone
     *
     *  Clone method is not allowed
     *  @access private
     */
    private function __clone(){ }
    
    /**
     *  start
     *
     *  start() is used to parse the query string data
     *  @access private
     *  @return void
     */
    protected function start(){
    	Lynx_Router::parse();
    }
    
    /**
     *  run
     *
     *  run is used to execute the specified Controller
     *  @final
     *  @param Lynx_Registry $registry Used upon instanitation of the Controller objects
     *  @return void
     */
    final public function run(Lynx_Registry $registry){
    	$Router = Lynx_Router::getInstance();
    	// pass the current module, controller and action to the Registry
    	$registry->set('module', $Router->currentModule())
    	         ->set('controller', $Router->currentController())
    	         ->set('action', $Router->currentAction())
    	         ->set('modulesDirectory', $this->getModulesDirectoryName());
    	
      // load up the business logic ... module's controller
      $controllerDirectory = '';
      
      $controllerDirectory .= ($this->getModulesDirectoryName()) ? $this->getModulesDirectoryName().DIRECTORY_SEPARATOR : '';
      
      $controllerDirectory .= $_REQUEST['module'].DIRECTORY_SEPARATOR;
      
      $controllerDirectory .= ($this->getControllersDirectoryName()) ? $this->getControllersDirectoryName().DIRECTORY_SEPARATOR : '';
      
      require_once($controllerDirectory.$_REQUEST['controller'].'Controller.php');
      
      $controller = $_REQUEST['controller'].'Controller';
      $controller = new $controller($registry);
      $controller->{$_REQUEST['action'].'Action'}();
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