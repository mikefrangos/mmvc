<?php
/**
 * Admin Control Panel to manage admin stuff.
 * 
 * @package MmvcCore
 */
class CCAdminControlPanel extends CObject implements IController {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }


  /**
   * Show list of users and groups.
   */
  public function Index() {
    $this->views->SetTitle('ACP: Admin Control Panel');
    $this->views->AddInclude(__DIR__ . '/index.tpl.php', array(
    	          'is_admin'=>$this->user['hasRoleAdmin'],  
                  'users' => $this->user->ListAll(), 'groups' => $this->user->ListGroups(),
                ));
  }
  
  /**
  * View and edit config options.
  */
  public function Config() {
      $form = new CFormConfig($this->site, $this->config);
      $status = $form->Check();
      if($status === false) {
        $this->AddMessage('notice', 'Some fields did not validate and the form could not be processed.');
        $this->RedirectToController('config');
      } elseif ($status === true) { 
          $this->RedirectToController('index');
   
      }
      
      $this->views->SetTitle('Site Config');
      $this->views->AddInclude(__DIR__ . '/config.tpl.php', array(
        'is_admin'=>$this->user['hasRoleAdmin'],  
        'config'=>$this->config,
        'config_form'=>$form->GetHTML(),
    ));
  }
  
  public function Group($arg=null, $id=null) {
     $users = "";
     $groups = "";
     $create ="";
     switch ($arg) {
    	case 'edit':
    	case 'create':
    	   $form = new CFormGroup($this->user, $id);
           $status = $form->Check();
           if($status === false) {
              $this->AddMessage('notice', 'You must fill in all values.');
              $this->RedirectToController('group');
           } elseif($status === true) {
              $this->RedirectToController('group');
           }
           $create = $form->GetHtml();
           break;
        case 'view':
           if ($id) {
              $users = $this->user->ListAll(array('group' => $id));
              $groups[] = $this->user->LoadGroupbyID($id);
              break;
           }      
        default: 
          $users = $this->user->ListAll();
          $groups = $this->user->ListGroups();
    }
    $this->views->SetTitle('Group Index');
    $this->views->AddInclude(__DIR__ . '/group.tpl.php', array(
    	          'is_admin'=>$this->user['hasRoleAdmin'],  
                  'users' => $users, 'form' => $create, 'groups' => $groups,
                ));
  }
  
  /**
   * Show and edit menus.
   */
  public function Menu($arg=null, $id=null) {
     $menus = "";
     $create ="";
     switch ($arg) {
    	case 'edit':
    	case 'create':
    	   $form = new CFormMenu($this->site, $this->config['menus']['nav navbar-nav'], $id);
           $status = $form->Check();
           if($status === false) {
              $this->AddMessage('notice', 'You must fill in all values.');
              $this->RedirectToController('menu');
           } elseif($status === true) {
              $this->RedirectToController('menu');
           }
           $create = $form->GetHtml();
           break;
        default: 
          $menus = $this->config['menus']['nav navbar-nav'];
    }
    $this->views->SetTitle('Group Index');
    $this->views->AddInclude(__DIR__ . '/menu.tpl.php', array(
    	          'is_admin'=>$this->user['hasRoleAdmin'],  
                  'form' => $create, 'menus' => $menus,
                ));
  }
    
    	    
 /**
   * View and edit user profile.
   */
  public function Profile($id=null) {
    if ($id) {
      $user = $this->user->LoadbyId($id);
      $form = new CFormAdminProfile($this->user, $user, $this->user->ListGroups());
    } else {
      $this->RedirectTo('user','create');
    }
    $status = $form->Check();
    if($status === false) {
      $this->AddMessage('notice', 'Some fields did not validate and the form could not be processed.');
      $this->RedirectToController('profile');
    } elseif ($status === true) {
    	$this->Addmessage('success', 'Successfully saved profile.');
      	$this->RedirectToController('index');
    }
    
    $this->views->SetTitle('User Profile');
    $this->views->AddInclude(__DIR__ . '/profile.tpl.php', array(
      'is_admin'=>$this->user['hasRoleAdmin'],  
      'user'=>$user,
      'profile_form'=>$form->GetHTML(),
    ));
  }
 

} 
