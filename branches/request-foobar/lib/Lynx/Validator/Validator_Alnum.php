<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator_Alnum
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

  class Lynx_Validator_Alnum extends Lynx_Validator_Abstract {
  	
  	protected $_whitespace = NULL;
  	
  	public function __construct($data = NULL, $whitespace = FALSE){
  		$this->_data = $data;
  		$this->_whitespace = $whitespace;
  	}
  	
  	/**
  	 * Checks if the supplied data is valid
  	 * 
  	 * @return bool Returns true if the data is valid, false otherwise
  	 */
  	public function isValid(){
  		$regex = '#^[0-9A-Z';
  		if($this->_whitespace)
  		  $regex .= '\x20';
  		$regex .= ']+$#i';
  		if(preg_match($regex, $this->_data))
  		  return true;
  		return false;
  	}
  	
  	/**
  	 * Set whether or not to allow whitespaces (currently only spaces)
  	 * 
  	 * @param bool $bool Allow whitespace or not
  	 * @return Lynx_Validator_Alnum $this Instance of Lynx_Validator_Alnum
  	 */
  	public function setWhitespace($bool){
  		$this->_whitespace = (bool)$bool;
  		return $this;
  	}
  	
  }