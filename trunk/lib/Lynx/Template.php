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
  	// template title
  	protected $_title = 'Undefined';
  	
  	protected $_registry = NULL;
  	
  	protected $_templatesDirectory = 'templates';
  	
  	protected $_currentTemplate = 'default';
  	
  	public function __construct(){ }
    
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
  	
  }