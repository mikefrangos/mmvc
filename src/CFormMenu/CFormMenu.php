<?php
/**
* A form to manage menu details.
* 
* @package MmvcCore
*/
class CFormMenu extends CForm {

  private $object;

  
  /**
   * Constructor
   */
  public function __construct($object, $menus, $id) {
    parent::__construct();
    $this->object = $object;
    $menu = isset($menus[$id]) ? $menus[$id] : array('label'=>'', 'url'=>'');
    $this->AddElement(new CFormElementText('label', array('value'=>$menu['label'], 'required'=>true)))
         ->AddElement(new CFormElementText('url', array('value'=>$menu['url'], 'required'=>true)))
         ->AddElement(new CFormElementSubmit('save', array('callback'=>array($this, 'DoMenuSave'), 'callback-args'=>array($menus, $id)))) 
         ->AddElement(new CFormElementSubmit('delete', array('callback'=>array($this, 'DoMenuDelete'), 'callback-args'=>array($menus, $id))));  
  
    $this->SetValidation('label', array('not_empty'))
         ->SetValidation('url', array('not_empty'));
  }
  
  public function DoMenuSave($form, $menus, $id) {
    $entry = "<?php \$mm->config['menus']['nav navbar-nav'] = ";
    if (isset($menus[$id])) {
    	    $menus[$id]['label'] = $form['label']['value'];
    	    $menus[$id]['url'] = $form['url']['value'];
    } else {
       $menus[] = array('label'=>$form['label']['value'], 'url'=>$form['url']['value']);
    }
    $entry .= var_export($menus, true);
    $entry .= ";";
    
    return $this->object->SaveMenu($entry);
 }
  
 public function DoMenuDelete($form, $menus, $id) {
     $entry = "<?php \$mm->config['menus']['nav navbar-nav'] = "; 
     unset($menus[$id]);
     $menus = array_values($menus);
     $entry .= var_export($menus, true);
     $entry .= ";";
    
     
  /*   $i = 0;
     while ($i < $key) {
        $entry .= "{$i}=> array('label'=>'{$form["{$i}-label"]['value']}', 'url'=>'{$form["{$i}-url"]['value']}'),";
        $i++;
     } 
     while (($i >= $key) && isset($form["{$i}-label"]['value'])) {
       $i++;
       $entry .= "{$i}=> array('label'=>'{$form["{$i}-label"]['value']}', 'url'=>'{$form["{$i}-url"]['value']}'),";
     } 
     $entry .= ");"; */
     return $this->object->SaveMenu($entry);
 } 
 
 
  /**
   * Constructor
   
  public function __construct($object, $menu) {
    parent::__construct();
    $this->object = $object;
    if ($menu) {
      foreach ($menu as $key => $item) {
         $this->AddElement(new CFormElementText("{$key}-label", array('label'=>'label', 'value'=>$item['label'])))
              ->AddElement(new CFormElementText("{$key}-url", array('label'=>'url', 'value'=>$item['url'])))
              ->AddElement(new CFormElementSubmit("{$key}-delete", array('callback'=>array($this, 'DoDeleteMenu'), 'callback-args'=>array($key))));
      }
      $this->AddElement(new CFormElementSubmit('save', array('callback'=>array($this, 'DoMenu')))); 
    } else {
       $this->AddElement(new CFormElementText('label'))
            ->AddElement(new CFormElementText('url'))
            ->AddElement(new CFormElementSubmit('save', array('callback'=>array($this, 'DoMenuCreate'), 'callback-args'=>array($menu))));  
       $this->SetValidation('label', array('not_empty'))
            ->SetValidation('url', array('not_empty'));
     }
  } 
  
   public function DoMenuSave($form, $menu) {
    $entry = "<?php \$mm->config['menus']['nav navbar-nav'] = Array("; 
    $i = 0;
    foreach ($menu as $val) {
        $entry .="{$i}=> array('label'=>'{$val['label']}', 'url'=>'{$val['url']}'),";
        $i++;
    }
    $entry .= "{$i}=> array('label'=>'{$form['label']['value']}', 'url'=>'{$form['url']['value']}'),);";
    return $this->object->SaveMenu($entry);
 } */
 
 public function DoMenu($form) {
    $entry = "<?php \$mm->config['menus']['nav navbar-nav'] = Array("; 
    $i = 0;
    do {
       $entry .= "{$i}=> array('label'=>'{$form["{$i}-label"]['value']}', 'url'=>'{$form["{$i}-url"]['value']}'),";
       $i++;
    } while (isset($form["{$i}-label"]['value']));
    $entry .= ");";
    return $this->object->SaveMenu($entry);
 }
 
 
  
  
}
