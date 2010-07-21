<?php
  define('APP_START_TIME', microtime(true));
  
  ini_set('error_reporting', E_ALL | E_STRICT);
  ini_set('display_errors', 'On');
  
  set_include_path(getcwd().DIRECTORY_SEPARATOR.'lib'.PATH_SEPARATOR.get_include_path());
  
  #require_once('Lynx/Error.php');
  #set_error_handler(array(new Lynx_Error, 'error'), E_ALL | E_STRICT);

  function pprint(array $a){
  	echo '<pre>'; print_r($a); echo '</pre>';
  }
  
  // we are going to use sessions
  session_start();
  #$Session = new Lynx_Session();
  
  require_once('Lynx/Registry.php');
  
  require_once('Lynx/Database.php');
  
  $init = array('adapter' => 'MySQL', 
                'init' => array(
                'host' => 'localhost', 
                'user' => 'lynx', 
                'pass' => 'lynxproject', 
                'db' => 'lynx', 
                'prefix' => ''));
  try {
    $Database = Lynx_Database::factory($init);
    #$Database->debug();
  } catch(Exception $e){
  	die('Failed to initialize the database.');
  }
  
  require_once('Lynx/Controller/Front.php');
  
  $Registry = Lynx_Registry::getInstance();
  $Registry->set('database', $Database);
  
  $controller = Lynx_Controller_Front::getInstance();
  
  $controller->run($Registry);
  
  // debug info
  /*
  require_once('Lynx/Usage/Usage_Memory.php');
  $memory = new Lynx_Usage_Memory;
  echo 'Query Count = '.$Database::queryCount();
  echo '<br />';
  echo 'Memory Usage = '.($memory->usage()/1024).'KB';
  echo '<br />';
  echo 'Peak Memory = '.($memory->peak()/1024).'KB';
  echo '<br />';
  echo 'Run Time = '.(microtime(true) - APP_START_TIME);
  */