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

    /**
     * Initilization information
     *
     * @var array $_info
     */
    private $_info = array();

    /**
     * Resource link to MySQL database
     *
     * @var string $_link Resource link to database
     */
    private $_link = NULL;
    
    /**
     *  Variable to hold the number of queries executed
     *  @var int $_queryCount
     */
    static private $_queryCount = 0;
    
    /**
     * Variable to hold the queries executed
     * @var mixed $_queries
     */
    protected static $_queries = array();
    
    /**
     * Debugging variable used to print queries
     * 
     * @var bool $_debug
     */
    protected $_debug = FALSE;

    /**
     * MySQL class constructor
     *
     * @param array $init Array of initilization parameters
     */
    protected function __construct(array $init){
      $this->_info['host'] = $init['host'];
      $this->_info['user'] = $init['user'];
      $this->_info['pass'] = $init['pass'];
      $this->_info['db'] = $init['db'];
      $this->_info['prefix'] = $init['prefix'];
      $this->getConnection();
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

    public function getConnection(){
      if($this->_link === NULL)
        $this->_link = $this->_connect();
      if(!$this->_link)
        throw new Exception('Database connection failure');
      if(!$this->changeDatabase($this->_info['db'], $this->_link))
        throw new Exception('Database selection error');
      return $this;
    }
    
    /**
     * Create a MySQL database connection
     */
    protected function _connect(){
      return mysql_connect($this->_info['host'], $this->_info['user'], $this->_info['pass']);
    }
    
    /**
     * Selects a MySQL database
     */
    public function changeDatabase($link = NULL, $db = NULL){
      if(!$db)
        $db = $this->_info['db'];
      if(!$link)
        $link = $this->_link;
      return mysql_select_db($db, $link);       
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

    public function showTables(){
      $q = $this->query("SHOW TABLES");
      return mysql_result($q, 0);
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
      $q = mysql_query($prepared, $this->_link) or die(mysql_error());
      return $q;
    }
    
    public function lastId(){
      return $this->result("SELECT LAST_INSERT_ID()");
    }
    
    public function addUpdate($table, $bind = array(), array $id){
      $theId = current($id);
      $sql = (empty($theId)) ? "INSERT INTO" : "UPDATE";
      $sql .= " `$table` SET";
      foreach($bind as $column => $value):
        $sql .= " `$column` = ";
        if($value == NULL)
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
      if(!empty($theId))
        $sql .= " WHERE `".key($id)."` = '".current($id)."'";
      return $this->query($sql);
    }

    public function row($sql, array $data = array()){
      $q = $this->query($sql, $data); // query resource
      return mysql_fetch_assoc($q);
    }

    public function rows($sql, array $data = array()){
      $q = $this->query($sql, $data); // query resource
      $d = array(); // data holder
      while(($r = mysql_fetch_assoc($q)) !== FALSE)
        $d[] = $r;
      return $d;
    }

    public function startTransaction($autoCommit = 0){
      $this->query("SET autocommit = ".(int)$autoCommit);
      $this->query("BEGIN");
    }

    public function commit(){
      $this->query("COMMIT");
    }

    public function rollback(){
      $this->query("ROLLBACK");
    }
    
    public function unicode(){
      $this->query("SET CHARACTER SET utf8");
      $this->query("SET NAMES utf8");
    }
    
    public static function queryCount(){
      return self::$_queryCount;
    }
    
    public function tablePrefix($newPrefix = NULL){
    	if($newPrefix)
    	  $this->_info['prefix'] = $newPrefix;
    	return $this->_info['prefix'];
    }
    
    public function debug($bool = TRUE){
    	$this->_debug = $bool;
    	return $this;
    }

  }