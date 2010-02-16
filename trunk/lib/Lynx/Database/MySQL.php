<?php
  
  /**
   * @category Lynx
   * @package Lynx_Database_MySQL
   * @author Travis Crowder
   * @version $Id$
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
     * MySQL class constructor
     *
     * @param array $init Array of initilization parameters
     */
    protected function __construct(array $init){
      $this->_info['host'] = $init['host'];
      $this->_info['user'] = $init['user'];
      $this->_info['pass'] = $init['pass'];
      $this->_info['db'] = $init['db'];
      $this->getConnection();
    }

    public function getConnection(){
      if($this->_link === NULL)
        $this->_link = mysql_connect($this->_info['host'], $this->_info['user'], $this->_info['pass']);
      if(!$this->_link)
        throw new Exception('Database connection failure');
      if(!mysql_select_db($this->_info['db'], $this->_link))
        throw new Exception('Database selection error');
      return $this;
    }
    
    /**
     * Function to replicate mysql_real_escape_string
     *
     * @param string $text
     * @return string
     */
    protected function clean($text){
      $replace = array(
                    "\x00"  => '\x00',
                    "\n"    => '\n',
                    "\r"    => '\r',
                    '\\'    => '\\\\',
                    #"'"     => "\'",
                    #'"'     => '\"',
                    "\x1a"  => '\x1a',
                    '?'     => '&#63;',
                    "'"     => '&#39;',
                    '"'     => '&#34;'
                  );
      return strtr($text, $replace);
    }
    
    protected function dirty($text){
      $replace = array(
                    '\x00'  => "\x00",
                    '\n'    => "\n",
                    '\r'    => "\r",
                    "\\\\"    => "\\",
                    #"'"     => "\'",
                    #'"'     => '\"',
                    '\x1a'  => "\x1a",
                    '&#63;'     => '?',
                    '&#39;'     => "'",
                    '&#34;'     => '"'
                  );
      return strtr($text, $replace);
    }
    
    protected function prepare($sql, array $data = array()){
      $dataCount = count($data);
      if(!$dataCount) return $sql;
      $numToReplace = substr_count($sql, '?');
      if(!$numToReplace) return $sql;
      $data = array_map(array('Database', 'clean'), $data);
      if($dataCount != $numToReplace) throw new Exception('Data count ('.$dataCount.') does not match bind count ('.$numToReplace.') on '.$sql);
      for($i = 0; $i < $numToReplace; $i++){
        if(!isset($data[$i]))
          die($i.' = '.print_r($data, true));
        elseif(is_int($data[$i]))
          $sql = preg_replace("#\?#", $data[$i], $sql, 1);
        elseif(is_string($data[$i]))
          $sql = preg_replace("#\?#", "'".$data[$i]."'", $sql, 1);
        elseif(isset($data[$i]) && !is_array($data[$i]))
          $sql = preg_replace("#\?#", "'".$data[$i]."'", $sql, 1);
        else
          throw new Exception('May only prepare int and string data types and the following was supplied: '.$data[$i]);
      }
      return $sql;
    }

    public function showTables(){
      $q = $this->query("SHOW TABLES");
      return mysql_result($q, 0);
    }

    public function query($sql, array $data = array()){
      $sql = $this->prepare($sql, $data);
      $q = mysql_query($sql, $this->_link) or die(mysql_error().' on '.$sql);
      self::$_queryCount++;
      if(!$q)
        return mysql_error($this->_link);
      return $q;
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
    
    public function queryCount(){
      return self::$_queryCount;
    }

  }