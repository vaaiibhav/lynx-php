<?php

  require_once('Lynx/Form/Element.php');

  class Lynx_Form_Label extends Lynx_Form_Element {
    
    /**
     * define the standard form elements from the W3C DTD
     */
  	protected $_tag = 'label';
  	protected $_self_closing = FALSE;
    /**
     * Extend the parent attributes
     */
    protected $_extended_attributes = array('for' => NULL, 
                                            'onblur' => NULL, 
                                            'onfocus' => NULL, 
                                            'accesskey' => NULL
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