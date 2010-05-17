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
    	Lynx_Request::parse();
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
    	$Request = $Router->getRequest();
    	// pass the current module, controller and action to the Registry
    	$registry->set('module', $Request->currentModule())
    	         ->set('controller', $Request->currentController())
    	         ->set('action', $Request->currentAction())
    	         ->set('modulesDirectory', $Router->getModulesDirectoryName());
    	
      // load up the business logic ... module's controller
      $controllerDirectory = '';
      
      $controllerDirectory .= ($Router->getModulesDirectoryName()) ? $Router->getModulesDirectoryName().DIRECTORY_SEPARATOR : '';
      
      $controllerDirectory .= $_REQUEST['module'].DIRECTORY_SEPARATOR;
      
      $controllerDirectory .= ($Router->getControllersDirectoryName()) ? $Router->getControllersDirectoryName().DIRECTORY_SEPARATOR : '';
      
      require_once($controllerDirectory.$_REQUEST['controller'].'Controller.php');
      
      $controller = $_REQUEST['controller'].'Controller';
      $controller = new $controller($registry);
      $controller->{$_REQUEST['action'].'Action'}();
      
    }
    
    
    
  }