<?php
/**
* A form to manage config details.
* 
* @package MmvcCore
*/
class CFormConfig extends CForm {

  private $object;

  /**
   * Constructor
   */
  public function __construct($object, $config) {
    parent::__construct();
    $this->object = $object; 
    $this->AddElement(new CFormElementText('header', array('value'=>$config['theme']['data']['header'])))
         ->AddElement(new CFormElementTextarea('footer', array('value'=>$config['theme']['data']['footer'])))
         ->AddElement(new CFormElementText('logo', array('value'=>$config['theme']['data']['logo'])))
         ->AddElement(new CFormElementText('logo_width', array('value'=>$config['theme']['data']['logo_width'])))
         ->AddElement(new CFormElementText('logo_height', array('value'=>$config['theme']['data']['logo_height'])))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($this, 'DoConfigSave'))));  
     $this->SetValidation('header', array('not_empty'));
  }
 
  
  public function DoConfigSave($form) {
    $entry = "<?php \$mm->config['theme']['data']['header']='{$form['header']['value']}';";
    $entry .= " \$mm->config['theme']['data']['footer']='{$form['footer']['value']}';";
    $entry .= " \$mm->config['theme']['data']['logo']='{$form['logo']['value']}';";
    $entry .= " \$mm->config['theme']['data']['logo_height']='{$form['logo_height']['value']}';";
    $entry .= " \$mm->config['theme']['data']['logo_width']='{$form['logo_width']['value']}';";
    $ret = $this->object->Save($entry);
    return $ret; 
  }
  
}
  

