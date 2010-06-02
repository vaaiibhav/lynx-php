<?php
  
  /**
   * @category Lynx
   * @package Lynx_Controller_Action
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

  require_once('Lynx/Controller/Action.php');

  abstract class Lynx_Controller_Action_XHTML extends Lynx_Controller_Action {
  	
  	protected $_registry = NULL;
  	protected $_template = NULL;
  	
  	public function __construct(Lynx_Registry $registry){
  		parent::__construct($registry);
  		require_once('Lynx/Template/XHTML.php');
  		$templateConfig = array('currentModule' => $this->_registry->get('module'), 
  		                        'currentController' => $this->_registry->get('controller'),
  		                        'modulesDirectory' => $this->_registry->get('modulesDirectory'), 
  		                        'fqdn' => $_REQUEST['fqdn']
  		                       );
      $this->_template = new Lynx_Template_XHTML($templateConfig);
      $this->_registry->set('template', $this->_template);  		
  	}
  	
  	public function __destruct(){
  	  $this->_template->renderLayout('index.phtml');
  	}
  	
  	abstract public function indexAction();
  	
  }