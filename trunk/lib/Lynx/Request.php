<?php

  require_once('Lynx/Singleton/Singleton_Abstract.php');

  class Lynx_Request extends Lynx_Singleton_Abstract {
  	
  	protected static $_queryString = NULL;
    protected static $_currentModule = 'default';
    protected static $_currentController = 'index';
    protected static $_currentAction = 'index';
  	
  	public static function getInstance(){
  		if(self::$_instance == NULL)
  		  self::$_instance = new Lynx_Request();
  		return self::$_instance;
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
    
    public static function parse(){
      // figure out what to parse on
      $queryParameters = array();
      if(isset($_GET['vars'])){
        $queryParameters = $_GET['vars'];
      } else {
        $queryParameters = preg_replace("#((.*)\.php[/]?)?(.*)#", "\\3", $_SERVER['REQUEST_URI']);
        // strip $_GET if present
        if(preg_match('#\?#', $queryParameters)){
          $tmp = split('\?', $queryParameters);
          $queryParameters = $tmp[0];
          unset($tmp);
        }
      }
      $queryParameters = explode("\x2F", $queryParameters);
      // get MVC part
      $_REQUEST['fqdn'] = $_SERVER['SERVER_NAME'];
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
    
    /**
     * What headers have we sent?
     * 
     * @return mixed The headers sent to the client
     */
    public function getHeaders(){
    	return headers_list();
    }
    
    /**
     * Have the headers been sent yet?
     * 
     * @return bool
     */
    public function headersSent(){
    	return headers_sent();
    }
    
    public function setHeader(){
    	
    }
    
    /**
     * Method to unset a previously set header using header()
     * 
     * @since PHP 5.3.0
     * @param string $key Header key
     * @throws Exception Throws Exception when used before PHP 5.3.0
     * @return void
     */
    public function removeheader($key){
    	if(function_exists('header_remove'))
    	 return header_remove($key);
    	throw new Exception('header_remove() has not been implemented it PHP '.phpversion());
    }
  	
  }