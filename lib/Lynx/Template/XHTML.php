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
  	
  	public function __construct(Lynx_Registry $registry, $docType = NULL){
  		parent::__construct($registry);
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
  	
  	public function render($source, $buffer = FALSE){
  		$tmp = $this->templatesDirectoryName();
  		$path = (!empty($tmp)) ? $this->templatesDirectoryName().DIRECTORY_SEPARATOR : '';
  		$path .= $this->currentTemplate().DIRECTORY_SEPARATOR;
  		$path .= $source; 
  		if(!$buffer)
  		  require_once($path);
  		else 
  		  $buffer = file_get_contents($path);
  		return $buffer;
  	}
  	
  	public function partial($source, $buffer = FALSE){
  		#$tmp = $this->partialsDirectoryName();
      #$path = (!empty($tmp)) ? $this->partialsDirectoryName().DIRECTORY_SEPARATOR : '';
      $path = $source; 
      if(!$buffer)
        require_once($path);
      else 
        $buffer = file_get_contents($path);
      return $buffer;
  	}
  	
  }