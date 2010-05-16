<?php

  /**
   * @category Lynx
   * @package Lynx_Auth_Db_Abstract
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Auth/Auth_Abstract.php');

  abstract class Lynx_Auth_Db_Abstract extends Lynx_Auth_Abstract {
  	
  	protected $_db = NULL;
  	protected $_tableName = NULL;
  	protected $_identityColumn = NULL;
  	protected $_credentialColumn = NULL;
  	protected $_encryptionType = NULL;
  	
  	abstract public function setDatabase(Lynx_Database $db);
  	abstract public function setTable($table);
  	abstract public function setIdentityColumn($column);
  	abstract public function setCredentialColumn($column);
  	abstract public function setEncryption($type);
  	
  }