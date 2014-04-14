<?php
/**
* A form for editing the user profile.
* 
* @package MmvcCore
*/
class CFormAdminProfile extends CForm {

	private $object;
	
  /**
   * Constructor
   */
  public function __construct($object, $user, $groups) {
    parent::__construct();
    $this->object = $object;
    $checked = !empty($user['groups']) ? array_column($user['groups'], 'name') : array();
    $this->AddElement(new CFormElementHidden('id', array('value'=>$user['id'])))
         ->AddElement(new CFormElementText('acronym', array('readonly'=>true, 'value'=>$user['acronym'])))
         ->AddElement(new CFormElementText('name', array('value'=>$user['name'], 'required'=>true)))
         ->AddElement(new CFormElementText('email', array('value'=>$user['email'], 'required'=>true)))
         ->AddElement(new CFormElementCheckboxMultiple('groups', array('values' => array_column($groups, 'name'), 'checked' => $checked)))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($this, 'DoProfileSave'), 'callback-args'=>array($user, $groups))))
         ->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoDelete'))));
    $this->SetValidation('name', array('not_empty'))
         ->SetValidation('email', array('not_empty'));
  }
  
    /**
   * Save updates to profile information.
   */
  public function DoProfileSave($form, $user, $groups) {
    $user['email'] = $form['email']['value'];
    $user['name'] = $form['name']['value'];
    $user['acronym'] = $form['acronym']['value'];
    $user['id'] = $form['id']['value'];
    $add = array();
    $remove = array();
    $keys = array();
    $members = array_column($user['groups'], 'name'); 
    foreach ($groups as $group) {
    	    $keys[$group['name']] = $group['id'];
    }
    if (!empty($form['groups']['checked'])) {   
       foreach ($members as $member) {
    	    	 if (!in_array($member, $form['groups']['checked'])) {
    	    		    $remove[] = $keys[$member];
    	         }          
       }
       foreach ($form['groups']['checked'] as $checked) {
    	    if (!in_array($checked, $members)) {
    	    	    $add[] = $keys[$checked];
    	    }
       }
    } else {
       $remove = array_column($user['groups'], 'id'); 
    }
    return $this->object->SaveOther($user, $add, $remove);
  /*  $this->AddMessage($ret, 'Saved profile.', 'Failed saving profile.');  
    $this->RedirectToController('profile', $user['id']); */
  
    }
  
  /**
   * Callback to delete the user.
   */
  public function DoDelete($form) {
    $user['id'] = $form['id']['value'];
    $user['acronym'] = $form['acronym']['value'];
    return $this->object->Delete($user);
  /*  $this->RedirectToController('index'); */
  }
  
  
}

