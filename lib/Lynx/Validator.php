<?php
  
  /**
   * @category Lynx
   * @package Lynx_Validator
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

  class Lynx_Validator extends Lynx_Validator_Abstract {
  	
  	public function __construct($whichValidator = NULL, $data = NULL){
  		$this->_data = $data;
  		switch($whichValidator){
  			case 'alnum':
  				require_once('Validator/Validator_Alnum.php');
  				$this->_validator = new Lynx_Validator_Alnum($this->_data);
  			default:
  				break;
  		}
  	}
  	
  	public function isValid(){
  		return $this->_validator->isValid();
  	}
  	
    public function __call($name, $args){
      $this->_validator->$name($args);
    }
  	
  }