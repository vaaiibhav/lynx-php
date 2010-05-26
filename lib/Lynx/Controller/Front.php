<?php
  /**
   * @category Lynx
   * @package Lynx_Controller_Front
   * @author Travis Crowder
   * @version $Id$
   * 
    NEW BSD LICENSE
    Copyright (c) 2009-2010, Travis Crowder
    All rights reserved.
    
    Redistribution and use in source and binary forms, with or without modification,
    are permitted provided that the following conditions are met:
    
        * Redistributions of source code must retain the above copyright notice,
          this list of conditions and the following disclaimer.
    
        * Redistributions in binary form must reproduce the above copyright notice,
          this list of conditions and the following disclaimer in the documentation
          and/or other materials provided with the distribution.
    
        * Neither the name of Travis Crowder nor the names of its
          contributors may be used to endorse or promote products derived from this
          software without specific prior written permission.
    
    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
    ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
    ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
    ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
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