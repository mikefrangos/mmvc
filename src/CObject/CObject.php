<?php
/**
* Holding a instance of CMmvc to enable use of $this in subclasses.
*
* @package MmvcCore
*/
class CObject {

   public $config;
   public $request;
   public $data;

   /**
    * Constructor
    */
   protected function __construct() {
    $mm = CMmvc::Instance();
    $this->config   = &$mm->config;
    $this->request  = &$mm->request;
    $this->data     = &$mm->data;
  }

}
