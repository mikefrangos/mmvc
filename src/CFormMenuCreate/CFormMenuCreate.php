<?php
/**
* A form to manage menu details.
* 
* @package MmvcCore
*/
class CFormMenuCreate extends CForm {



  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->AddElement(new CFormElementText('label'))
         ->AddElement(new CFormElementText('url'))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($object, 'DoMenuCreate'))));  
    $this->SetValidation('label', array('not_empty'))
         ->SetValidation('url', array('not_empty'));
  }
  
}
