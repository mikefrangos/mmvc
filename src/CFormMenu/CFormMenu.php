<?php
/**
* A form to manage menu details.
* 
* @package MmvcCore
*/
class CFormMenu extends CForm {



  /**
   * Constructor
   */
  public function __construct($object, $menu) {
    parent::__construct();
    foreach ($menu as $key => $item) {
       $this->AddElement(new CFormElementText("{$key}-label", array('label'=>'label', 'value'=>$item['label'])))
            ->AddElement(new CFormElementText("{$key}-url", array('label'=>'url', 'value'=>$item['url'])))
            ->AddElement(new CFormElementSubmit("{$key}-delete", array('callback'=>array($object, 'DoDeleteMenu'), 'callback-args'=>array($key))));
 
    }
    $this->AddElement(new CFormElementSubmit('save', array('callback'=>array($object, 'DoMenu'))));  
 /*   $this->SetValidation('label', array('not_empty'))
         ->SetValidation('url', array('not_empty')); */
  }
  
}
