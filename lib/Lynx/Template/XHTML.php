<?php

  /**
   * @category Lynx
   * @package Lynx_Template_XHTML
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
  		  if(is_file($source))
  		    require_once($source);
  		  else
  		    exit('Invalid resource requested: '.$source.' in '.__METHOD__);
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