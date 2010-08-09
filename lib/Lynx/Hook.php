<?php

  /**
   * @category Lynx
   * @package Lynx_Hook
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

  /**
   * Execute bits of code that have been registered
   * 
   * Usage:
   * 
   * class TestHook {
   *   public function appStart(){
   *     echo 'Started';
   *   }
   *   public function appEnd(){
   *     echo 'Finished';
   *   }
   * }
   * 
   * class OtherHook {
   *   public function appEnd($arg){
   *     echo $arg;
   *   }
   * }
   * 
   * Hook::register('TestHook', 'appStart');
   * Hook::register('TestHook', 'appEnd');
   * Hook::register('OtherHook', 'appEnd');
   * 
   * Hook::hook('appStart');
   * 
   * echo 'Hello World!';
   * 
   * $args = 'Bye Bye';
   * Hook::hook('appEnd', $args);
   * 
   */

  final class Lynx_Hook {
    
    protected static $_hooks = array();
    
    protected function __construct(){ }
    
    /**
     * Register a hook and hook point
     * 
     * @param string $hook Class to hook
     * @param string $point Method of Class to execute
     * @param string $file Path to required file
     * @return void
     */
    public static function register($hook, $point, $file = NULL){
      if($file && is_file($file))
        require_once($file);
      if(method_exists($hook, $point)){
        self::$_hooks[$hook][] = $point;
      }
    }
    
    /**
     * Checks to make sure a hook is registered
     * 
     * @param string $hook Class name
     * @param string $point Method of Class to execute
     * @return bool
     */
    public static function isRegistered($hook, $point = NULL){
      if($point == NULL && array_key_exists($hook, self::$_hooks))
        return true;
      if(in_array($point, self::$_hooks[$hook]))
        return true;
      return false;
    }
    
    /**
     * Execute a hook point on all registered hooks
     * 
     * @param string $point Method of registered hooks to execute
     * @param mixed $args Parameter(s) to pass to the hook
     */
    public static function hook($point, &$args = NULL){
      foreach(self::$_hooks as $hook => $points)
        Hook::run($hook, $point, &$args);
    }
    
    /**
     * Run a point in a hook (execute a class method)
     * 
     * @param string $hook Class name of registered hook
     * @param string $point Method of Class to execute
     * @param mixed $args Parameter(s) to pass to the hook
     */
    public static function run($hook, $point, &$args = NULL){
      if(self::isRegistered($hook, $point))
        if(is_array($args))
          call_user_func_array(array($hook, $point), &$args);
        else
          call_user_func_array(array($hook, $point), array(&$args));
    }
    
  }