<?php
  
  /**
   * @category Lynx
   * @package Lynx_Database
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
  
  abstract class Lynx_Database {
  	
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
  	
  	abstract protected function __construct();
    abstract protected function _connect();
    abstract public function query($sql, array $bind = array());
    abstract public function row($sql, array $bind = array());
    abstract public function rows($sql, array $bind = array());
    abstract protected function _prepare($sql, array $bind = array());
    abstract protected function _escape($string);
  	
  }