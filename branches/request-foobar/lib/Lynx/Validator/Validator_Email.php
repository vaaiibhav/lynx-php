<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator_Email
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

  require_once('Lynx/Validator/Validator_Abstract.php');

  class Lynx_Validator_Email extends Lynx_Validator_Abstract {
  	
  	protected $_checkDNS = FALSE;
  	
  	public function __construct($data = NULL){
  		$this->_data = $data;
  		// do not check DNS by default
  		$this->setCheckDNS(FALSE);
  	}
  	
  	public function setCheckDNS($bool){
  		$this->_checkDNS = (bool)$bool;
  		return $this;
  	}
  	
  	public function checkDNS($host, $type){
  		if($this->_checkDNS)
  		  if(!$this->verifyDNS($host, $type))
  		    return false;
  		return true;
  	}
  	
  	protected function verifyDNS($host, $type){
  		return checkdnsrr($host, $type);
  	}
  	
  	public function isValid(){

	    if(!preg_match('#@#', $this->_data)) return false;
	    
	    $temp = preg_split('#@#', $this->_data);
	    if(count($temp) != 2) return false;

	    $local = $temp[0];
	    $domain = $temp[1];
	    
	    // make sure neither is too long
	    if(strlen($local) > 64 || strlen($domain) > 255) return false;
	    
	    // check for valid local part
	    if($local[0] == '.' || $local[strlen($local)-1] == '.') return false;
	    
  	  // verify the local characters
      if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/', str_replace("\\\\","",$local))){
        if(!preg_match('/^"(\\\\"|[^"])+"$/', str_replace("\\\\","",$local)))
          return false;                 
      }
	    
	    // check for valid domain part
	    if(!preg_match('#^[-\.a-z0-9]+$#i', $domain)) return false;
	    
	    // verify no double dots
	    if(preg_match('#\\.\\.#', $domain)) return false;
	    
	    // check DNS records
	    if(!$this->checkDNS($domain, 'MX') || !$this->checkDNS($domain, 'A')) return false;
	
	    return true;
  		
  	}
  	
  }