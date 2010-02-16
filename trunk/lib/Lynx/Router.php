<?php


  class Lynx_Router {
  	
  	protected static $_instance = NULL;
  	
  	protected static $_queryString = NULL;
  	protected static $_currentModule = 'default';
    protected static $_currentController = 'index';
    protected static $_currentAction = 'index';
  	
  	protected function __construct(){
  		
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
  	
  	public static function parse(){
  		// figure out what to parse on
  		$queryParameters = array();
      if(isset($_GET['vars'])){
        $queryParameters = $_GET['vars'];
      } else {
        $queryParameters = preg_replace("#((.*).php[/]?)?(.*)#", "\\3", $_SERVER['REQUEST_URI']);
      }
      $queryParameters = explode("\x2F", $queryParameters);
      
      // get MVC part
      $_REQUEST['module'] = (!empty($queryParameters[0])) ? $queryParameters[0] : 'default';
      $_REQUEST['controller'] = (!empty($queryParameters[0]) && !empty($queryParameters[1])) ? $queryParameters[1] : 'index';
      $_REQUEST['action'] = (!empty($queryParameters[0]) && !empty($queryParameters[1]) && !empty($queryParameters[2])) ? $queryParameters[2] : 'index';
      self::setCurrentModule($_REQUEST['module']);
      self::setCurrentController($_REQUEST['controller']);
      self::setCurrentAction($_REQUEST['action']);
      unset($queryParameters[0], $queryParameters[1], $queryParameters[2]);
      
      // get query string part
      $queryParameters = array_values($queryParameters);
      $queryParams = array();
      for($i = 0; $i<count($queryParameters);$i){
        #if(!isset($queryParameters[$i+1])) die('QP Error'.print_r($queryParameters, true));
        $queryParams[$queryParameters[$i]] = $queryParameters[$i+1];
        $i += 2;
      }
      self::setQueryString($queryParams);
  	}
  	
  	protected static function setQueryString($queryString){
  		$_REQUEST['queryString'] = self::$_queryString = $queryString;
  	}
  	
  	public static function queryString(){
  		return self::$_queryString;
  	}
  	
    final public static function setCurrentModule($name){
      self::$_currentModule = $name;
    }
    
    final public function currentModule(){
      return self::$_currentModule;
    }
    
    final public static function setCurrentController($name){
      self::$_currentController = $name;
    }
    
    final public function currentController(){
      return self::$_currentController;
    }
    
    final public static function setCurrentAction($name){
      self::$_currentAction = $name;
    }
    
    final public function currentAction(){
      return self::$_currentAction;
    }
  	
  }