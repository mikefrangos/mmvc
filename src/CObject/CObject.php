<?php
/**
* Holding a instance of CMmvc to enable use of $this in subclasses.
*
* @package MmvcCore
*/
class CObject {

   protected $mm;
   protected $config;
   protected $request;
   protected $data;
   protected $db;
   protected $views;
   protected $session;
   protected $user;

   /**
    * Constructor
    */
   protected function __construct($mm=null) {
    if(!$mm) {
      $mm = CMmvc::Instance();
    } 	
    $this->mm       = &$mm;
    $this->config   = &$mm->config;
    $this->request  = &$mm->request;
    $this->data     = &$mm->data;
    $this->db       = &$mm->db;
    $this->views    = &$mm->views;
    $this->session  = &$mm->session;
    $this->user     = &$mm->user;

  }

/**
         * Wrapper for same method in CLydia. See there for documentation.
         */
        protected function RedirectTo($urlOrController=null, $method=null, $arguments=null) {
    $this->mm->RedirectTo($urlOrController, $method, $arguments);
  }


        /**
         * Wrapper for same method in CMmvc. See there for documentation.
         */
        protected function RedirectToController($method=null, $arguments=null) {
    $this->mm->RedirectToController($method, $arguments);
  }


        /**
         * Wrapper for same method in CMmvc. See there for documentation.
         */
        protected function RedirectToControllerMethod($controller=null, $method=null, $arguments=null) {
    $this->mm->RedirectToControllerMethod($controller, $method, $arguments);
  }


        /**
         * Wrapper for same method in CMmvc. See there for documentation.
         */
  protected function AddMessage($type, $message, $alternative=null) {
    return $this->mm->AddMessage($type, $message, $alternative);
  }


        /**
         * Wrapper for same method in CMmvc. See there for documentation.
         */
        protected function CreateUrl($urlOrController=null, $method=null, $arguments=null) {
    return $this->mm->CreateUrl($urlOrController, $method, $arguments);
  }
  
}
