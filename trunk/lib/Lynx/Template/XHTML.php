<?php

  /**
   * @category Lynx
   * @package Lynx_Template_XHTML
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Lynx/Template.php');
  
  class Lynx_Template_XHTML extends Lynx_Template {
  	
  	protected $_docType = NULL;
  	
  	protected $_fileExtension = '.phtml';
  	
  	// template title
    protected $_title = 'Undefined';
  	
  	public function __construct(array $config, $docType = NULL){
  		parent::__construct($config);
  		$this->selectDocType($docType);
  	}
  	
  	public function selectDocType($choice = NULL){
  		switch($choice){
  			case 'XHTML1':
  			case 'strict':
  			case 'Strict':
  			default:
  				$this->_docType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">';
  		}
  	}
  	
  	public function docType(){
  		return $this->_docType;
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
  	
  	public function renderLayout($source, $buffer = FALSE){
  		if(!$this->_render) return true;
  		$tmp = $this->templatesDirectoryName();
      $path = (!empty($tmp)) ? $this->templatesDirectoryName().DIRECTORY_SEPARATOR : '';
      $path .= $this->currentTemplate().DIRECTORY_SEPARATOR;
      $path .= $source;
      $this->render($path, $buffer);
  	}
  	
  	public function renderPartial($source, $buffer = FALSE){
  		$tmp = $this->_config['modulesDirectory'];
      $path = (!empty($tmp)) ? $tmp.DIRECTORY_SEPARATOR : '';
      $path .= $this->_config['currentModule'].DIRECTORY_SEPARATOR;
      $tmp = $this->partialsDirectoryName();
      $path .= (!empty($tmp)) ? $tmp.DIRECTORY_SEPARATOR : '';
      $path .= $this->_config['currentController'].DIRECTORY_SEPARATOR;
      $path .= $source . $this->getTemplateFileExtension();
  		$this->render($path, $buffer);
  	}
  	
  	public function renderAjax($source, $buffer = FALSE){
  	  $this->setNoRender();
  	  $this->renderPartial($source, $buffer);
  	}
  	
  	public function render($source, $buffer = FALSE){
  		if(!$buffer)
  		  require_once($source);
  		else 
  		  $buffer = file_get_contents($source);
  		return $buffer;
  	}
  	
  	protected function getTemplateFileExtension(){
  		return $this->_fileExtension;
  	}
  	
  	public function templatePath(){
  		return parent::FQDN().'/'.$this->templatesDirectoryName().'/'.$this->currentTemplate();
  	}
  	
  }