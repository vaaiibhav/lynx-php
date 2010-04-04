<?php
  ini_set('error_reporting', E_ALL | E_STRICT);
  ini_set('display_errors', 'On');
  
  set_include_path(getcwd().DIRECTORY_SEPARATOR.'lib'.PATH_SEPARATOR.get_include_path());
  
  require_once('Lynx/Error.php');
  #set_error_handler(array(new Lynx_Error, 'error'), E_ALL | E_STRICT);

  require_once('Lynx/Session.php');
  require_once('Lynx/Registry.php');
  
  require_once('Lynx/Database.php');
  
  $init = array('adapter' => 'MySQL', 
                'init' => array(
                'host' => 'localhost', 
                'user' => 'lynx', 
                'pass' => 'lynxproject', 
                'db' => 'lynx'));
  try {
    $Database = Lynx_Database::factory($init);
  } catch(Exception $e){
  	die('Failed to initialize the database.');
  }
  
  require_once('Lynx/Controller/Front.php');
  
  #$Session = new Lynx_Session();
  
  $Registry = Lynx_Registry::getInstance();
  $Registry->set('database', $Database);
  
  $controller = Lynx_Controller_Front::getInstance();
  
  $controller->run($Registry);