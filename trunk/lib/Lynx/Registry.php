<?php
  /**
   * @category Lynx
   * @package Lynx_Registry
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
  /**
   * Lynx_Registry
   * 
   * Registry class
   */

  class Lynx_Registry {
  	
  	public static $instance = NULL;
  	
  	protected static $_registry = array();
  	
  	protected function __construct(){
  		
  	}
  	
  	/**
  	 * getInstance
  	 * 
  	 * Method to get an instance of the registry
  	 * @return Lynx_Registry self::$_instance
  	 */
  	public static function getInstance(){
  		if(self::$instance == NULL){
  			self::$instance = new Lynx_Registry();
  		}
  		return self::$instance;
  	}
  	
  	/**
  	 * get
  	 * 
  	 * Method to get the value stored
  	 * 
  	 * @param unknown_type $element
  	 * @return mixed self::$_registry[$element]
  	 * @throws Exception if registry element is not set
  	 */
  	public function get($element){
  		if(isset(self::$_registry[$element]))
  		  return self::$_registry[$element];
  		throw new Exception("Registry element [" . $element . "] is not set.");
  	}
  	
  	/**
  	 * set
  	 * 
  	 * Method to set add or update a value to the registry
  	 * 
  	 * @param unknown_type $element
  	 * @param unknown_type $value
  	 * @return void
  	 */
  	public function set($element, $value){
  		self::$_registry[$element] = $value;
  		return $this;
  	}
  	
  }