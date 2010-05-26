<?php
  
  /**
   * @category Lynx
   * @package Lynx_Session
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
  
  class Lynx_Session {
  	
  	protected static $_instantiated = FALSE;
  	
  	protected $_variables = array();
  	
  	public function __construct($namespace = 'default'){
  		
  		$this->setSessionNamespace($namespace);
  		
  		if(self::$_instantiated != $namespace){
  			session_start();
  			self::$_instantiated = $namespace;
  		}
  	}
  	
    public function __isset($x){
      if(isset($this->_variables[$x]))
        return true;
      return false;
    }
    
    public function __set($x, $y){
      $this->_variables[$x] = $y;
    }
    
    public function __get($x){
      return $this->_variables[$x];     
    }
  	
  	public function getSessionNamespace(){
  		return session_name();
  	}
  	
  	public function setSessionNamespace($namespace){
  		return session_name($namespace);
  	}
  	
  	public function get($index){
  		return $_SESSION[$index];
  	}
  	
  	public function set($index, $value){
  		$_SESSION[$index] = $value;
  	}
  	
  }