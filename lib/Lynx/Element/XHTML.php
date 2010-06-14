<?php

  require_once('Lynx/Element.php');

  class Lynx_XHTML_Element extends Lynx_Element {
  	
  	/**
  	 * Unique ID
  	 */
  	protected $_id = NULL;
  	
  	/**
  	 * tag info
  	 */
  	protected $_tag = NULL;
  	protected $_self_closing = FALSE;
  	
  	/**
  	 * content
  	 */
  	protected $_innerHTML = NULL;
  	
    /**
     * define the standard attributes from the W3C DTD
     */    
    protected $_attributes = array('id' => NULL, 
                                   'name' => NULL, 
                                   'class' => NULL, 
                                   'style' => NULL, 
                                   'lang' => NULL, 
                                   'dir' => NULL, 
                                   'title' => NULL, 
                                   'target' => NULL, 
                                   'onsubmit' => NULL, 
                                   'onreset' => NULL, 
                                   'onclick' => NULL, 
                                   'ondblclick' => NULL, 
                                   'onmouseover' => NULL, 
                                   'onmouseout' => NULL, 
                                   'onmousedown' => NULL, 
                                   'onmouseup' => NULL, 
                                   'onkeypress' => NULL, 
                                   'onkeydown' => NULL, 
                                   'onkeyup' => NULL
                             );
    
    public function __construct($tag = NULL){
    	if(!empty($tag))
    	  $this->setTag($tag);
    }
                             
    public function setTag($tag){
    	$this->_tag = $tag;
    }
    
    public function selfClosing($bool = NULL){
    	if(!empty($this->_self_closing))
    	  $this->_self_closing = $bool;
    	return $this->_self_closing;
    }
                             
    public function setAttribute($attribute, $value){
    	if(array_key_exists($attribute, $this->_attributes))
        $this->_attributes[$attribute] = $value;
      return $this;
    }
    
    public function setAttributes(array $attributes){
    	$this->_attributes = $attributes;
    }
    
    public function getAttribute($attribute){
    	if(array_key_exists($attribute, $this->_attributes))
    	  return $this->_attributes[$attribute];
    	return false;
    }
    
    public function getAttributes(){
    	return $this->_attributes;
    }
    
    protected function outputAttributes(){
    	$out = '';
    	foreach($this->_attributes as $attribute => $value)
        if(!empty($value))
          $out .= ' '.$attribute.'="'.$value.'"';
          
      return $out;
    }
    
    public function setHTML($data){
    	$this->_innerHTML = $data;
    	return $this;
    }
    
    public function getHTML(){
    	return $this->_innerHTML;
    }
    
    public function __toString(){
    	// open tag
    	$out = '<'.$this->_tag;
    	
    	$out .= $this->outputAttributes();
    	
    	// close tag
    	if($this->selfClosing())
    	  $out .= ' />';
    	else
    	  $out .= '>'.$this->getHTML().'</'.$this->_tag.'>'."\n";
    	
    	return $out;
    }
    
  }