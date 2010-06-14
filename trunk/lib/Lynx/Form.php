<?php

  require_once('Lynx/XHTML_Element.php');

  class Lynx_Form extends Lynx_XHTML_Element {
  	
  	protected $_errors = array();
  	
  	/**
  	 * define the standard form elements from the W3C DTD
  	 */  	
  	/**
  	 * Extend the parent attributes
  	 */
  	protected $_extended_attributes = array('method' => NULL, 
  	                                        'action' => NULL, 
  	                                        'enctype' => NULL, 
  	                                        'accept' => NULL, 
  	                                        'accept-charset' => NULL
  	                                     );
  	
  	/**
  	 * array of X_XHTML_Elements
  	 */
  	protected $_elements = array();
  	
  	public function __construct(){
  		$this->_attributes = array_merge($this->_attributes, $this->_extended_attributes);
  	}
  	
  	public function __toString(){
  		$out = '<form';
  		foreach($this->_attributes as $attribute => $value)
  		  if(!empty($value))
  		    $out .= ' '.$attribute.'="'.$value.'"';
  		$out .= '>'."\n";
  		if(count($this->_elements))
  		  foreach($this->_elements as $e)
  		    $out .= $e;
  		$out .= '</form>';
  		
  		return $out;
  	}
  	
  	public function addElement(X_XHTML_Element $e){
  		$this->_elements[] = $e;
  	}
  	
  	public function addElements(array $els){
  		foreach($els as $e){
  			if($e instanceof X_XHTML_Element)
  			  $this->_elements[] = $e;
  		}
  	}
  	
  	public function isValid(){
  		foreach($this->_elements as $element){
  			if($element instanceof X_Form_Element && !$element->isValid()){
  			  $this->_errors[] = $element->getErrors();
  			}
  		}
  		if(!count($this->_errors))
  		  return true;
  		else
  		  return false;
  	}
  	
  	public function getErrors(){
  		return $this->_errors;
  	}
  	
  }