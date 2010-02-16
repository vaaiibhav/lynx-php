<?php
  
  /**
   * @category Lynx
   * @package Lynx_Database
   * @author Travis Crowder
   * @version $Id$
   */
  
  abstract class Lynx_Database {
  	
  	abstract protected function __construct();
  	
    /**
     * factory
     * 
     * Method to control the creation of database objects.
     * @param array $info
     */
  	final static public function factory(array $info){
    	if(empty($info['adapter']))
        throw new Exception('Missing database adapter.');
      
      if(empty($info['init']))
        throw new Exception('Initialization values missing factory method.');
    	
      switch($info['adapter']){
        case 'mysql':
        case 'MySQL':
        case 'MYSQL':
          require_once('Lynx/Database/MySQL.php');
          return new Lynx_Database_MySQL($info['init']);
          break;
        default:
          throw new Exception('Invalid database adapter.');
          break;
      }
    }
  	
  	abstract protected function clean($sql);
  	abstract protected function dirty($sql);
  	abstract protected function prepare($data, array $array = array());
  	abstract public function query($sql, array $data = array());
  	abstract public function row($sql, array $data = array());
  	abstract public function rows($sql, array $data = array());
  	
  }