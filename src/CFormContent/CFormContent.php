<?php
/**
* A form to manage content.
* 
* @package MmvcCore
*/
class CFormContent extends CForm {

  /**
   * Properties
   */
  private $content;

  /**
   * Constructor
   */
  public function __construct($content, $groups) {
    parent::__construct();
    $this->content = $content;
    $checked = !empty($content['groups']) ? array_column($content['groups'], 'name') : array();
    $save = isset($content['id']) ? 'save' : 'create';
    $this->AddElement(new CFormElementHidden('id', array('value'=>$content['id'])))
         ->AddElement(new CFormElementText('title', array('value'=>$content['title'])))
         ->AddElement(new CFormElementText('key', array('value'=>$content['key'])))
         ->AddElement(new CFormElementTextarea('data', array('label'=>'Content:', 'value'=>$content['data'])))
         ->AddElement(new CFormElementText('type', array('value'=>$content['type'])))
         ->AddElement(new CFormElementText('filter', array('value'=>$content['filter'])))
         ->AddElement(new CFormElementCheckboxMultiple('groups', array('values' => array_column($groups, 'name'), 'checked' => $checked)))
         ->AddElement(new CFormElementSubmit($save, array('callback'=>array($this, 'DoSave'), 'callback-args'=>array($content, $groups))))
         ->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoDelete'), 'callback-args'=>array($content))));
     $this->SetValidation('title', array('not_empty'))
         ->SetValidation('key', array('not_empty'));
  }
  

  /**
   * Callback to save the form content to database.
   */
  public function DoSave($form, $content, $groups) {
    $content['id']    = $form['id']['value'];
    $content['title'] = $form['title']['value'];
    $content['key']   = $form['key']['value'];
    $content['data']  = $form['data']['value'];
    $content['type']  = $form['type']['value'];
    $content['filter'] = $form['filter']['value'];
    $add = array();
    $remove = array();
    if (!empty($form['groups']['checked'])) {
    	$content['public'] = 1;
        $keys = array();
        $members = array_column($content['groups'], 'name'); 
        foreach ($groups as $group) {
    	    $keys[$group['name']] = $group['id'];
        }
        foreach ($members as $member) {
    	    	 if (!in_array($member, $form['groups']['checked'])) {
    	    		    array_push($remove, $keys[$member]);
    	         }          
        }  
        foreach ($form['groups']['checked'] as $checked) {
    	    if (!in_array($checked, $members)) {
    	    	    array_push($add, $keys[$checked]);
    	    }
        }
    }
    return $content->Save($add, $remove);
  }
  
  /**
   * Callback to delete the content.
   */
  public function DoDelete($form, $content) {
    $content['id'] = $form['id']['value'];
    $content->Delete();
    CMmvc::Instance()->RedirectTo('content');
  }
  
}
