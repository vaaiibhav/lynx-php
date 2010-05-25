<?php

  /**
   * @category Lynx
   * @package Lynx_Element_Abstract
   * @author Travis Crowder
   * @version $Id$
   */

  require_once('Element/Interface.php');
  
  abstract class Lynx_Element_Abstract implements Lynx_Element_Interface {
  
    protected $_id = NULL;
  
    protected $_name;
    
    public function __construct($id = NULL, $name = NULL){
    	if(!empty($id)) $this->setId($id);
    	if(!empty($name)) $this->setName($name);
    }
  
    public function setName($name){
      $this->_name = $name;
      return $this;
    }
    
    public function getName(){
      return $this->_name;
    }
    
    public function setId($id){
      $this->_id = $id;
    }
    
    public function getId(){
      return $this->_id;
    }
  
  }