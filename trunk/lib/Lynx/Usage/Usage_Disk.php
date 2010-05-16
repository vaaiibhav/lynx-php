<?php
  
  /**
   * @category Lynx
   * @package Lynx_Usage
   * @author Travis Crowder
   * @version $Id$
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