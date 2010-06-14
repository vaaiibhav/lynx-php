<?php

  require_once('Lynx/Element/XHTML_Element.php');

  class Lynx_XHTML_Break extends Lynx_XHTML_Element {

  	protected $_tag = 'br';
  	
  	public function __toString(){
  		// open tag
      $out = '<'.$this->_tag;
      
      $out .= $this->outputAttributes();
      
      // close tag
      $out .= ' />'."\n";
      
  		return $out;
  	}
  	
  }