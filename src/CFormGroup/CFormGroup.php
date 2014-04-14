<?php
/**
* A form for creating a new group.
* 
* @package MmvcCore
*/

class CFormGroup extends CForm {

  private $object;
	
  /**
   * Constructor
   */
  public function __construct($object, $id) {
    parent::__construct();
    $this->object = $object;
    $value = isset($id) ? $this->object->LoadGroupbyID($id) : array('id' => '', 'acronym'=>'', 'name'=>'');
    $this->AddElement(new CFormElementHidden('id', array('value'=>$value['id'])))
         ->AddElement(new CFormElementText('acronym', array('value'=>$value['acronym'], 'required'=>true)))
         ->AddElement(new CFormElementText('name', array('value'=>$value['name'], 'required'=>true)))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($this, 'DoSave'))))
         ->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoDelete'), 'callback-args'=>array($value['id']))));
 
    $this->SetValidation('acronym', array('not_empty'))
         ->SetValidation('name', array('not_empty'));
  }
  
    
 /**
 * Callback to delete a group
 */
 public function DoSave($form) {
      $group['acronym'] = $form['acronym']['value'];
      $group['name'] = $form['name']['value'];
      $group['id'] = $form['id']['value'];
      $ret = $this->object->SaveGroup($group);
      return $ret;
     /*    $this->AddMessage('success', "You have successfully created the group '{$form['name']['value']}'.");  
         $this->RedirectToController('index'); 
       } */
 }
  
 /**
  * Delete a group.
  */
  public function DoDelete($form, $id) {
  	  $group = $this->object->LoadGroupByID($id);
  	  return $this->object->DeleteGroup($group);
 
  }
  
}
