<?php

  require_once('Lynx/Element/XHTML.php');

  abstract class Lynx_Form_Element extends Lynx_XHTML_Element {
  	
  	protected $_validators = array();
  	protected $_errors = array();
  	
  	/**
     * define the standard form elements from the W3C DTD
     */
  	
  	public function __construct($tag = NULL, $self_closing = NULL){
  		if(!empty($tag))
  		  $this->_tag = $tag;
  		if(!empty($self_closing))
  		  $this->selfClosing($self_closing);
  	}
  	
  	public function isValid(){
  		if(!count($this->_validators))
  		  return true;
  		foreach($this->_validators as $validator){
  			if(!$validator->setData($_REQUEST[$this->getAttribute('name')])->isValid()){
  				$this->_errors[$this->getAttribute('name')] = $validator->getMessage();
  			}
  		}
  		return count($this->_errors) == 0;
  	}
  	
  	public function addValidator(X_Validator $validator){
  		$this->_validators[] = $validator;
  	}
  	
  	public function getErrors(){
  		return $this->_errors;
  	}
  	
  }