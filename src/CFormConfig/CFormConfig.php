<?php
/**
* A form to manage config details.
* 
* @package MmvcCore
*/
class CFormConfig extends CForm {



  /**
   * Constructor
   */
  public function __construct($object, $config) {
    parent::__construct();
    $this->AddElement(new CFormElementText('header', array('value'=>$config['theme']['data']['header'])))
         ->AddElement(new CFormElementTextarea('footer', array('value'=>$config['theme']['data']['footer'])))
         ->AddElement(new CFormElementText('logo', array('value'=>$config['theme']['data']['logo'])))
         ->AddElement(new CFormElementText('logo_width', array('value'=>$config['theme']['data']['logo_width'])))
         ->AddElement(new CFormElementText('logo_height', array('value'=>$config['theme']['data']['logo_height'])))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($object, 'DoConfigSave'))));  
     $this->SetValidation('header', array('not_empty'));
  }
  
}
  

