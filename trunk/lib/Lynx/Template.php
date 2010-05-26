<?php

  /**
   * @category Lynx
   * @package Lynx_Template
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
   * Lynx_Template
   * 
   * Class used to generate template files
   *
   */
  class Lynx_Template {
  	
  	/**
  	 * Define template elements
  	 */
  	
  	/**
  	 * @var $_render bool Whether or not to render the template
  	 */
  	protected $_render = TRUE;
  	
  	
  	
  	protected $_registry = NULL;
  	
  	protected $_variables = array();
  	
  	protected $_templatesDirectory = 'templates';
  	
  	protected $_partialsDirectory = 'partials';
  	
  	protected $_currentTemplate = 'default';
  	
  	protected $_config = array();
  	
  	public function __construct(array $config){
  	  $this->_config = $config;
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
  	
  	public function setNoRender(){
  		$this->_render = FALSE;
  		return $this;
  	}
    
    /**
     * setTemplatesDirectoryName
     * 
     * Method to set the directory name that houses the templates
     * @param string $name
     */
    final public function setTemplatesDirectoryName($name){
      $this->_templatesDirectory = $name;
    }
    
    /**
     * templatesDirectoryName
     * 
     * Method to return the current directory name for the templates
     * @return string
     */
    final public function templatesDirectoryName(){
      return $this->_templatesDirectory;
    }
    
    /**
     * setPartialsDirectoryName
     * 
     * Method to set the directory name that houses the template partials
     * @param string $name
     */
    final public function setPartialsDirectoryName($name){
      $this->_partialsDirectory = $name;
    }
    
    /**
     * partialsDirectoryName
     * 
     * Method to return the current directory name for the template partials
     * @return string
     */
    final public function partialsDirectoryName(){
      return $this->_partialsDirectory;
    }
    
    /**
     * setCurrentTemplate
     * 
     * Method to set the template name
     * @param string $name
     */
    final public function setCurrentTemplate($name){
      $this->_currentTemplate = $name;
    }
    
    /**
     * currentTemplate
     * 
     * Method to return the current template name
     * @return string
     */
    final public function currentTemplate(){
      return $this->_currentTemplate;
    }
    
    public function FQDN(){
    	return $this->_config['fqdn'];
    }
  	
  }