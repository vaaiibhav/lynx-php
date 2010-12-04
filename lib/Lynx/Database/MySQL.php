<?php
  
  /**
   * @category Lynx
   * @package Lynx_Database_MySQL
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

  require_once('Lynx/Database.php');

  class Lynx_Database_MySQL extends Lynx_Database {

    protected $MySQL_LOCATION = 'localhost';
    protected $MySQL_PORT = 3306;
    protected $MySQL_USER = '';
    protected $MySQL_PASSWORD = '';
    protected $MySQL_DEFAULT_DATABASE = '';
    protected $MYSQL_TABLE_PREFIX = '';
    
    protected $_link = NULL;
    protected $_debug = FALSE;
    protected static $_instance = NULL;
    protected static $_queryCount = 0;
    protected static $_queries = array();
    
    /**
     * Creates a database connection and selects the default database
     */
    protected function __construct($init = array()){
      if(!empty($init)){
        $this->MySQL_LOCATION = (!empty($init['host'])) ? $init['host'] : 'localhost';
        $this->MySQL_PORT = (!empty($init['port'])) ? $init['port'] : 3306;
        $this->MySQL_USER = (!empty($init['user'])) ? $init['user'] : 'root';
        $this->MySQL_PASSWORD = (!empty($init['pass'])) ? $init['pass'] : '';
        $this->MySQL_DEFAULT_DATABASE = (!empty($init['db'])) ? $init['db'] : '';
        $this->MYSQL_TABLE_PREFIX = (!empty($init['prefix'])) ? $init['prefix'] : '';
      }
      $this->_link = $this->_connect();
      $this->changeDatabase($this->_link, $this->MySQL_DEFAULT_DATABASE);
    }
    
    /**
     * Close the MySQL connection
     * 
     * @return void
     */
    public function __destruct(){
      mysql_close($this->_link);
      $this->_link = NULL;
      if($this->_debug){
        echo '<pre>'.print_r(self::$_queries, true).'</pre>';
      }
    }
    
    /**
     * Create a MySQL database connection
     */
    protected function _connect(){
      return mysql_connect($this->MySQL_LOCATION.':'.$this->MySQL_PORT, $this->MySQL_USER, $this->MySQL_PASSWORD);
    }
    
    /**
     * Selects a MySQL database
     */
    public function changeDatabase($link = NULL, $db = NULL){
      if(!$db)
        $db = $this->MySQL_DEFAULT_DATABASE;
      if(!$link)
        $link = $this->_link;
      return mysql_select_db($db, $link);       
    }
    
    /**
     * Singleton accessor to the database instance
     */
    public static function getInstance($db = NULL){
      if(self::$_instance == NULL)
        self::$_instance = new MySQL();
      return self::$_instance;
    }
    
    /** table prefixes **/
    public function tablePrefix($newPrefix = NULL){
      if($newPrefix)
        $this->MYSQL_TABLE_PREFIX = $newPrefix;
      return $this->MYSQL_TABLE_PREFIX;
    }
    
    /**
     * Executes a MySQL query
     */
    public function query($sql, array $bind = array()){
      $prepared = $this->_prepare($sql, $bind);
      self::$_queryCount++;
      self::$_queries[] = $prepared;
      // you must assign the query to a variable to get a resource
      // otherwise it returns boolean
      $q = mysql_query($prepared, $this->_link) or die(mysql_error() .' ON '.$prepared);
      return $q;
    }
    
    public function lastId(){
      return $this->result("SELECT LAST_INSERT_ID()");
    }
    
    public function add($table, $bind = array()){
      $sql = "INSERT INTO";
      $sql .= " `$table` SET";
      foreach($bind as $column => $value):
        $sql .= " `$column` = ";
        if($value === NULL)
          $sql .= "NULL";
        elseif(is_string($value) && !is_numeric($value) || empty($value))
          $sql .= "'".$this->_escape($value)."'";
        elseif((is_string($value) && is_numeric($value)) || is_numeric($value))
          $sql .= $value;
        else
          throw new Exception("Invalid column value passed to ".__METHOD__.' -> '.$value);
        $sql .= ",";
      endforeach;
      if($sql[strlen($sql)-1] == ',')
        $sql = substr($sql, 0, -1);
      if($this->query($sql))
        return true;
    }
    
    public function update($table, $bind = array(), $id = array()){
      $theId = current($id);
      $sql = "UPDATE";
      $sql .= " `$table` SET";
      foreach($bind as $column => $value):
        $sql .= " `$column` = ";
        if($value === NULL)
          $sql .= "NULL";
        elseif(is_string($value) && !is_numeric($value) || empty($value))
          $sql .= "'".$this->_escape($value)."'";
        elseif((is_string($value) && is_numeric($value)) || is_numeric($value))
          $sql .= $value;
        else
          throw new Exception("Invalid column value passed to ".__METHOD__.' -> '.$value);
        $sql .= ",";
      endforeach;
      if($sql[strlen($sql)-1] == ',')
        $sql = substr($sql, 0, -1);
      $sql .= " WHERE `".key($id)."` = '".current($id)."'";
      if($this->query($sql))
        return $theId;
    }
    
    public function replace($table, $bind = array()){
      $sql = "REPLACE INTO";
      $sql .= " `$table` SET";
      foreach($bind as $column => $value):
        $sql .= " `$column` = ";
        if($value === NULL)
          $sql .= "NULL";
        elseif(is_string($value) && !is_numeric($value) || empty($value))
          $sql .= "'".$this->_escape($value)."'";
        elseif((is_string($value) && is_numeric($value)) || is_numeric($value))
          $sql .= $value;
        else
          throw new Exception("Invalid column value passed to ".__METHOD__.' -> '.$value);
        $sql .= ",";
      endforeach;
      if($sql[strlen($sql)-1] == ',')
        $sql = substr($sql, 0, -1);
        
      if($this->query($sql))
        return key($id);
    }
    
    /**
     * Get a query result
     */
    public function result($sql, array $bind = array(), $row = 0){
      $resource = $this->query($sql, $bind);
      if($resource)
        return mysql_result($resource, $row);
      return 0;
    }
    
    /**
     * Get a MySQL row
     */
    public function row($sql, array $bind = array()){
      $resource = $this->query($sql, $bind);
      return mysql_fetch_assoc($resource);
    }
    
    /**
     * Get a MySQL result set
     */
    public function rows($sql, array $bind = array()){
      $resource = $this->query($sql, $bind);
      $results = array();
      while(($row = mysql_fetch_assoc($resource)) !== FALSE){ $results[] = $row; }
      return $results;
    }
    
    /**
     * Prepares a query
     */
    protected function _prepare($sql, array $bind = array()){
      // check if there is anything to bind
      $dataCount = count($bind);
      if(!$dataCount) return $sql;
      // make sure there are elements to bind on
      $numToReplace = substr_count($sql, '?');
      if(!$numToReplace) return $sql;
      // make sure the number of elements being bound equals the number of elements to bind
      if($dataCount != $numToReplace) 
        throw new Exception('Data count ('.$dataCount.') does not match bind count ('.$numToReplace.') on '.$sql);
      
      // bind the elements
      for($i = 0; $i < $numToReplace; $i++){
        if(!isset($bind[$i]) && $bind[$i] !== NULL)
          throw new Exception('Element '.$i.' to be bound is not set');
        if($bind[$i] === NULL)
          $sql = preg_replace('#\?#', "NULL", $sql, 1);
        elseif(is_string($bind[$i]) && !is_numeric($bind[$i]))
          $sql = preg_replace('#\?#', "'".$this->_escape($bind[$i])."'", $sql, 1);
        elseif((is_string($bind[$i]) && is_numeric($bind[$i])) || is_numeric($bind[$i]))
          $sql = preg_replace('#\?#', $bind[$i], $sql, 1);
        else
          throw new Exception('You may only prepare int and string types, not this -> '.$bind[$i]);
      }
        
      return $sql;
    }
    
    public function prepare($string, array $bind = array()){
      return $this->_prepare($string, $bind);
    }
    
    protected function _escape($string){
      $replace = array(
                    "\x00"  => '\x00',
                    "\n"    => '\n',
                    "\r"    => '\r',
                    '\\'    => '\\\\',
                    "'"     => "\'",
                    '"'     => '\"',
                    "\x1a"  => '\x1a',
                    '?'     => '&#63;'
                  );
      return strtr($string, $replace);
    }
    
    /**
     * Begins a transaction
     */
    public function startTransaction($autoCommit = 0){
      $this->query("SET autocommit = ".(int)$autoCommit);
      $this->query("BEGIN");
    }

    /**
     * Commits a transaction
     */
    public function commit(){
      $this->query("COMMIT");
    }

    /**
     * Rolls back a transaction
     */
    public function rollback(){
      $this->query("ROLLBACK");
    }
    
    /**
     * Return rows found from SQL_CALC_FOUND_ROWS
     */
    public function foundRows(){
      return $this->result("SELECT FOUND_ROWS()");
    }
    
    /**
     * Prepares MySQL for unicode characters
     */
    public function unicode(){
      $this->query("SET CHARACTER SET utf8");
      $this->query("SET NAMES utf8");
    }
    
    /**
     * Replicates MySQL UUID()
     */
    public function UUID(){
      return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
    }
    
    public function validUUID($uuid){
      return preg_match("#^[a-z0-9]{8}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{4}-[a-z0-9]{12}$#", $uuid);
    }
    
    /**
     * Get the number of queries issued
     */
    public static function queryCount(){
      return self::$_queryCount;
    }
    
    /**
     * Turns on debugging
     */
    public function debug(){
      $this->_debug = TRUE;
      return $this;
    }

  }