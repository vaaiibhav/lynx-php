<?php

  /**
   * @category Lynx
   * @package Lynx_Captcha
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

  class Lynx_Captcha {
  	
  	protected static $_code = NULL;
  	
    public function __construct(){
      // create a random string
      $small_letters = range('a', 'z');
      $large_letters = range('A', 'Z');
      $digits = range(0, 9);
      
      $characters = array_merge($small_letters, $large_letters, $digits);
      for($i = 0; $i < 5; $i++){
      	self::$_code .= $characters[array_rand($characters)];
      }
    
      $_SESSION['Lynx_Captcha_code'] = self::$_code;
    }
    
    public function output(){
    	
		  // set width and height
		  $width = 72;
		  $height = 25;
		
		  // create image
		  $image = imagecreate($width, $height);
		
		  $white = imagecolorallocate($image, 255, 255, 255);
		  $black = imagecolorallocate($image, 0, 0, 0);
		
		  // setup the image background
		  imagefill($image, 0, 0, $black);
		
		  // add string to the image
		  imagestring($image, 4, 16, 5, self::$_code, $white);
		
		  imagerectangle($image,0,0,$width-1,$height-1,$black);
		
		  // setup the page headers
		  header("Content-Type: image/jpeg");
		
		  // output the image to the browser
		  imagejpeg($image);
    }
    
    public function __toString(){
    	$this->output();
    }
  	
  }