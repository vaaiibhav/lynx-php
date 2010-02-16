<?php
  ini_set('error_reporting', E_ALL | E_STRICT);
  ini_set('display_errors', 'On');
  
  set_include_path(getcwd().DIRECTORY_SEPARATOR.'lib'.DIRECTORY_SEPARATOR.'Lynx'.PATH_SEPARATOR.get_include_path());
  
  require_once('Error.php');
  #set_error_handler(array(new Lynx_Error, 'error'), E_ALL | E_STRICT);

  require_once('Registry.php');
  require_once('Template.php');
  require_once('Controller/Front.php');
  
  $Registry = Lynx_Registry::getInstance();
  
  $controller = Lynx_Controller_Front::getInstance();
  
  $Template = Lynx_Template::getInstance();
  
  $Registry->set('template', $Template);
  
  $controller->run($Registry);
  
  echo '<pre>'; print_r($_REQUEST);