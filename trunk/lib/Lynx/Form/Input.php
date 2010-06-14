<?php

  require_once('Lynx/Form/Element.php');

  class Lynx_Form_Input extends Lynx_Form_Element {
  	
  	/**
     * Extend the parent attributes
     */
    protected $_extended_attributes = array('type' => NULL, 'value' => NULL);
  	
  	protected $_tag = 'input';
  	protected $_self_closing = TRUE;
  	
  	protected $_types = array('text', 
  	                         'password', 
  	                         'file', 
  	                         'checkbox', 
  	                         'radio', 
  	                         'image', 
  	                         'button', 
  	                         'submit', 
  	                         'reset', 
  	                         'hidden'
  	                       );
  	                       
    public function __construct($type = 'text'){
      parent::__construct();
      $this->_attributes = array_merge($this->_attributes, $this->_extended_attributes);
      // set some defaults
      if(in_array($type, $this->_types))
        $this->setAttribute('type', $type);
      else
        $this->setAttribute('type', 'text');
    }
    
    public function __toString(){
    	// open tag
      $out = '<'.$this->_tag;
      
      // add attributes
      $out .= $this->outputAttributes();
      
      // close tag
      $out .= ' />'."\n";
    	
    	return $out;
    }
  	
  }