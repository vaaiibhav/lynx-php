<?php
  
  /**
   * @category Lynx
   * @package Lynx_Date
   * @author Travis Crowder
   * @version $Id$
   */

	// IN PROGRESS !!!
	// COMING BACK A MONTH LATER --- REDO IT ALL!!!

  class Lynx_Date {
  	
  	protected $_timestamp = NULL;
  	protected $_locale = NULL;
  	
  	protected $_format_standard = 'g:i:s A';
  	protected $_format_military = 'H:i:s';
  	protected $_format_current_time = NULL;
  	protected $_format_current_date = NULL;
  	
  	public function __construct($unix_timestamp = NULL, $locale = NULL){
  		
  		if($unix_timestamp > 0)
  			$this->setTimestamp($unix_timestamp);
  		else
  			$this->setTimestamp(time());
  			
  		$this->_locale = (!empty($locale)) ? $locale : 'America/Chicago';
  		$this->setLocale($this->_locale);
  		
  	}
  	
  	public function setTimestamp($unix_timestamp){
  		$this->_timestamp = $unix_timestamp;
  		return $this;
  	}
  	
  	public function getTimestamp(){
  		return $this->_timestamp;
  	}
  	
  	public function setLocale($locale){
  		if(!date_default_timezone_set($locale))
  			return false;
  		return $this;
  	}
  	
  	public function setTimeFormat($date_format){
  		$this->_format_current_time = $date_format;
  		return $this;
  	}
  	
  	public function getTimeFormat(){
  		return $this->_format_current_time;
  	}
  	
  	public function getTime(){
  	
  	}
  	
  	public function getStandardTime(){
  		return date("g:i:s A", $this->getTimestamp());
  	}
  	
  	public function getMilitaryTime(){
  		return date("H:i:s", $this->getTimestamp());
  	}
  	
  }
  
  