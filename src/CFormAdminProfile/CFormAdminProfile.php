<?php
/**
* A form for editing the user profile.
* 
* @package MmvcCore
*/
class CFormAdminProfile extends CForm {

	
  /**
   * Constructor
   */
  public function __construct($object, $user, $groups) {
    parent::__construct();
    $this->AddElement(new CFormElementHidden('id', array('value'=>$user['id'])))
         ->AddElement(new CFormElementText('acronym', array('readonly'=>true, 'value'=>$user['acronym'])))
         ->AddElement(new CFormElementText('name', array('value'=>$user['name'], 'required'=>true)))
         ->AddElement(new CFormElementText('email', array('value'=>$user['email'], 'required'=>true)))
         ->AddElement(new CFormElementCheckboxMultiple('groups', array('values' => array_column($groups, 'name'), 'checked' => array_column($user['groups'], 'name'))))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($object, 'DoProfileSave'), 'callback-args'=>array($user, $groups))))
         ->AddElement(new CFormElementSubmit('delete', array('callback'=>array($object, 'DoDelete'))));
    $this->SetValidation('name', array('not_empty'))
         ->SetValidation('email', array('not_empty'));
  }
  
  
}

