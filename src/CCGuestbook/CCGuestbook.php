<?php
/**
* A guestbook controller as an example to show off some basic controller and model-stuff.
* 
* @package MmvcCore
*/
class CCGuestbook extends CObject implements IController {

  private $guestbookModel;
  
  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
    $this->guestbookModel = new CMGuestbook();
  }
  

  /**
   * Legacy Index
   * Implementing interface IController. All controllers must have an index action.
   
  public function Index() {   
  
    $this->views->SetTitle('Mmvc Guestbook Example');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
      'entries'=>$this->guestbookModel->ReadAll(), 
      'formAction'=>$this->request->CreateUrl('', 'handler')
    ));
  
  } 

   
   /* Legacy Guestbook handler posts from the form and take appropriate action.
   
  public function Handler() {
    if(empty($_POST['email']) && isset($_POST['doAdd'])) {
      $this->guestbookModel->Add(strip_tags($_POST['newEntry']));
    }
    elseif(empty($_POST['email']) && isset($_POST['doClear'])) {
      $this->guestbookModel->DeleteAll();
    }            
    elseif(empty($_POST['email']) && isset($_POST['doCreate'])) {
      $this->guestbookModel->Init();
    }            
     $this->RedirectTo($this->request->CreateUrl($this->request->controller));
  } 
  
  
  /**
   * The guestbook.
   */
  public function Index($id=null) {
    $form = new CFormGuestbook($this->guestbookModel, $id);
    $threaded = new CThreadedComments($this->guestbookModel->Read($id));
    $threaded->print_comments();
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'The form could not be processed.');
      $this->RedirectToControllerMethod();
    } else if($status === true) {
      $this->RedirectToControllerMethod();
    }
    
    $this->views->SetTitle('Mmvc Guestbook')
         ->AddInclude(__DIR__ . '/guestbook.tpl.php', array(
            'entries'=>$threaded->sorted, 
            'unsorted'=>$this->guestbookModel->Read($id),
            'form'=>$form,
         ));
  }
} 
  /**
* Form for the guestbook
*/ 
class CFormGuestbook extends CForm {

  /**
   * Properties
   */
  private $object;

  /**
   * Constructor
   */
  public function __construct($object, $id) {
    parent::__construct();
    $this->object = $object;
    $this->AddElement(new CFormElementHidden('id', array('value'=>$id)))
         ->AddElement(new CFormElementTextarea('data', array('label'=>'Add entry:')))
         ->AddElement(new CFormElementSubmit('add', array('callback'=>array($this, 'DoAdd'), 'callback-args'=>array($object))))
         ->AddElement(new CFormElementSubmit('Clear', array('callback'=>array($this, 'DoClear'), 'callback-args'=>array($object))));
  }
  

  /**
   * Callback to add the form content to database.
   */
  public function DoAdd($form, $object) {
    return $object->Add(strip_tags($form['data']['value']), $form['id']['value']);
  }
  
   /**
   * Callback to add the form content to database.
   */
  public function DoClear($form, $object) {
    return $object->DeleteAll();
  }
  
  
}
