<?php
  
  /**
   * @category Lynx
   * @package Lynx_Date
   * @author Travis Crowder
   * @version $Id$
   * 
    NEW BSD LICENSE
    Copyright (c) 2009-2010, Travis Crowder
    All rights reserved.
    
    Redistribution and use in source and binary forms, with or without modification,
    are permitted provided that the following conditions are met:
    
        * Redistributions of source code must retain the above copyright notice,
          this list of conditions and the following disclaimer.
    
        * Redistributions in binary form must reproduce the above copyright notice,
          this list of conditions and the following disclaimer in the documentation
          and/or other materials provided with the distribution.
    
        * Neither the name of Travis Crowder nor the names of its
          contributors may be used to endorse or promote products derived from this
          software without specific prior written permission.
    
    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
    ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
    ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
    ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
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
  
  