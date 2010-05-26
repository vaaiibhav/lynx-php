<?php
  
  /**
   * @category Lynx
   * @package Lynx_Usage
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

  require_once('Lynx/Usage/Usage_Abstract.php');

  class Lynx_Usage_Disk extends Lynx_Usage_Abstract {
    
    public function __construct($directory = NULL){
      $this->_data = $directory;
    }
    
    public function usage(){
    	return $this->getUsage($this->_data);
    }
    
    protected function getUsage($d, $depth = NULL){
    	$usage = 0;
	    if(is_file($d))
	      return filesize($d);
	
	    if(isset($depth) && $depth < 0)
	      return 0;
	
	    if($d[strlen($d)-1] != '\\' || $d[strlen($d)-1] != '/')
	      $d .= '/';
	
	    $dh=@opendir($d);
	    if(!$dh)
	      return 0;
	
	    while($e = readdir($dh))
	      if($e != '.' && $e != '..')
	        $usage += $this->getUsage($d.$e, isset($depth) ? $depth - 1 : NULL);
	
	    closedir($dh);
	
	    return $usage;
    }
    
  }