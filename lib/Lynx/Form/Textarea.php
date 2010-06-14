<?php

  require_once('Lynx/Form/Element.php');

  class Lynx_Form_Textarea extends Lynx_Form_Element {
    
    /**
     * define the standard form elements from the W3C DTD
     */
  	protected $_tag = 'textarea';
  	protected $_self_closing = FALSE;
    /**
     * Extend the parent attributes
     */
    protected $_extended_attributes = array('rows' => NULL, 
                                            'cols' => NULL
                                         );
    
    public function __construct(){
      $this->_attributes = array_merge($this->_attributes, $this->_extended_attributes);
    }
    
    public function __toString(){
    	// open tag
      $out = '<'.$this->_tag;
      
      $out .= $this->outputAttributes();
      
      // close tag
      $out .= '>'.$this->getHTML().'</'.$this->_tag.'>'."\n";
      
      return $out;
    }
    
  }