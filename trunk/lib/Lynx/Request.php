<?php

  require_once('Lynx/Singleton/Singleton_Abstract.php');

  class Lynx_Request extends Lynx_Singleton_Abstract {
  	
  	public static function getInstance(){
  		if(self::$_instance == NULL)
  		  self::$_instance = new Lynx_Request();
  		return self::$_instance;
  	}
  	
  }