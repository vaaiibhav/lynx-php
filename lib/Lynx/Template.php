<?php

  /**
   * @category Lynx
   * @package Lynx_Template
   * @author Travis Crowder
   * @version $Id$
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
  	
  	// template title
  	protected $_title = 'Undefined';
  	
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
     * title
     * 
     * Method to set the template title
     * @param string $title
     */
    public function title($title = NULL){
    	if($title != NULL)
    	 $this->_title = $title;
    	return $this->_title;
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