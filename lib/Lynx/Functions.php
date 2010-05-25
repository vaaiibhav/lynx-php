<?php
  
  /**
   * @category Lynx
   * @package Lynx_Functions
   * @author Travis Crowder
   * @version $Id$
   */

  class Lynx_Functions {
  	
  	protected function __construct(){ }
  	
  	public static function UUID(){
      return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
                mt_rand(0, 0x0fff) | 0x4000,
                mt_rand(0, 0x3fff) | 0x8000,
                mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
  	}
  	
  }