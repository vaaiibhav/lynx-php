<?php

  require_once('Lynx/Form/Element.php');

  class Lynx_Form_Select extends Lynx_Form_Element {
  	
  	/**
     * define the standard form elements from the W3C DTD
     */
  	/**
     * Extend the parent attributes
     */
    protected $_extended_attributes = array('onfocus' => NULL, 
                                            'onblur' => NULL, 
                                            'onchange' => NULL
                                         );
  	protected $_options = array();
  	protected $_selected = NULL;
  	
  	public function __construct(){
  		parent::__construct();
  		$this->_attributes = array_merge($this->_attributes, $this->_extended_attributes);
  		$this->setTag('select');
  	}
  	
  	/**
  	 * Clear all options
  	 * @return X_Form_Select
  	 */
  	public function clearOptions(){
  		$this->_options = array();
  		return $this;
  	}
  	
  	/**
  	 * Set a select option value and text
  	 * @param string $value Option value
  	 * @param string $text Display text
  	 * @return X_Form_Select
  	 */
  	public function setOption($value, $text){
  		$this->_options[] = array('value' => $value, 'text' => $text);
  		return $this;
  	}
  	
  	/**
  	 * Set multiple select options
  	 * @param array $options Array of array(value, text) pairs
  	 * @return false|X_Form_Select Returns false on no options, X_Form_Select otherwise
  	 */
  	public function setOptions(array $options){
  		if(!count($options)) return false;
  		foreach($options as $key => $array)
  		  if(!empty($array['value']) && isset($array['text']))
  		    $this->_options[] = $array;
  		return $this;
  	}
  	
  	/**
  	 * Set the selected option
  	 * @param string $value The option value/key to be selected
  	 */
  	public function setSelected($value){
  		$this->_selected = $value;
  	}
  	
  	public function __toString(){
  		$out = '<'.$this->_tag;
      $out .= $this->outputAttributes();
      $out .= '>'."\n";
      foreach($this->_options as $key => $array){
      	if(empty($array['value'])) continue;
      	$out .= "\t".'<option value="'.$array['value'].'"';
      	if($array['value'] == $this->_selected)
      	  $out .= ' selected="selected"';
      	$out .= '>';
      	$out .= $array['text'];
      	$out .= '</option>'."\n";
      }
      $out .= '</'.$this->_tag.'>'."\n";
  		
  		return $out;
  	}
  	
  }