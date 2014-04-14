<?php
/**
* A form for creating a new group.
* 
* @package MmvcCore
*/
class CFormGroupCreate extends CForm {

  private $object;
	
  /**
   * Constructor
   */
  public function __construct($object) {
    parent::__construct();
    $this->object = $object;
    $this->AddElement(new CFormElementText('acronym', array('required'=>true)))
         ->AddElement(new CFormElementText('name', array('required'=>true)))
         ->AddElement(new CFormElementSubmit('create', array('callback'=>array($this, 'DoCreateGroup'))));
         
    $this->SetValidation('acronym', array('not_empty'))
         ->SetValidation('name', array('not_empty'));
  }
  
    
 /**
 * Callback to delete a group
 */
 public function DoCreateGroup($form) {
      $ret = $this->object->CreateGroup($form['acronym']['value'], 
                           $form['name']['value']
                           );
      return $ret;
     /*    $this->AddMessage('success', "You have successfully created the group '{$form['name']['value']}'.");  
         $this->RedirectToController('index'); 
       } */
 }
  
  
}
