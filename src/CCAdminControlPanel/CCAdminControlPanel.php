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
                  'users' => $this->user->ListAll(), 'groups' => $this->user->ListGroups(),
                ));
  }
  
  /**
  * View and edit config options.
  */
  public function Config() {
      $form = new CFormConfig($this, $this->config);
      if($form->Check() === false) {
        $this->AddMessage('notice', 'Some fields did not validate and the form could not be processed.');
        $this->RedirectToController('config');
      }
      $this->views->SetTitle('Site Config');
      $this->views->AddInclude(__DIR__ . '/config.tpl.php', array(
        'is_authenticated'=>$this->user['isAuthenticated'],  
        'config'=>$this->config,
        'config_form'=>$form->GetHTML(),
    ));
  }
  
   /**
  * View and edit config options.
  */
  public function MenuCreate() {
      $form = new CFormMenuCreate($this);
      if($form->Check() === false) {
        $this->AddMessage('notice', 'Some fields did not validate and the form could not be processed.');
        $this->RedirectToController('menucreate');
      }
      $this->views->SetTitle('Menu Create');
      $this->views->AddInclude(__DIR__ . '/menu.tpl.php', array(
        'is_authenticated'=>$this->user['isAuthenticated'],  
        'menu_form'=>$form->GetHTML(),
    ));
  }
  
    /**
  * View and edit config options.
  */
  public function Menu() {
      $form = new CFormMenu($this, $this->config['menus']['nav navbar-nav']);
      if($form->Check() === false) {
        $this->AddMessage('notice', 'Some fields did not validate and the form could not be processed.');
        $this->RedirectToController('menu');
      }
      $this->views->SetTitle('Menu Config');
      $this->views->AddInclude(__DIR__ . '/menu.tpl.php', array(
        'is_authenticated'=>$this->user['isAuthenticated'],  
        'menu_form'=>$form->GetHTML(),
    ));
  }
  
  /**
   * Show list of users in a group.
   */
  public function Group($id) {
    $this->views->SetTitle('Group Index');
    $this->views->AddInclude(__DIR__ . '/group.tpl.php', array(
                  'users' => $this->user->ListAll(array('group' => $id)), 'group' => $this->user->LoadGroupByID($id),
                ));
  }
    	    
 /**
   * View and edit user profile.
   */
  public function Profile($id) {
    $user = $this->user->LoadbyId($id);
    $form = new CFormAdminProfile($this, $user, $this->user->ListGroups());
    if($form->Check() === false) {
      $this->AddMessage('notice', 'Some fields did not validate and the form could not be processed.');
      $this->RedirectToController('profile');
    }
    
    $this->views->SetTitle('User Profile');
    $this->views->AddInclude(__DIR__ . '/profile.tpl.php', array(
      'is_authenticated'=>$this->user['isAuthenticated'],  
      'user'=>$user,
      'profile_form'=>$form->GetHTML(),
    ));
  }
  
  /**
  * Delete a group.
  */
  public function DeleteGroup($id) {
  	  $group = $this->user->LoadGroupByID($id);
  	  $this->user->DeleteGroup($group);
  	  $this->RedirectToController('index');
  }
  
  /**
  * Create a group.
  */
  public function CreateGroup() {
    $form = new CFormGroupCreate($this);
    if($form->Check() === false) {
      $this->AddMessage('notice', 'You must fill in all values.');
      $this->RedirectToController('CreateGroup');
    }
    $this->views->SetTitle('Create group');
    $this->views->AddInclude(__DIR__ . '/create.tpl.php', array('form' => $form->GetHTML()));     
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
    $ret = $this->user->SaveOther($user, $add, $remove);
    $this->AddMessage($ret, 'Saved profile.', 'Failed saving profile.');  
    $this->RedirectToController('profile', $user['id']);
  
    }
  
  /**
   * Callback to delete the user.
   */
  public function DoDelete($form) {
    $user['id'] = $form['id']['value'];
    $user['acronym'] = $form['acronym']['value'];
    $this->user->Delete($user);
    $this->RedirectToController('index');
  }
  
 /**
 * Callback to delete a group
 */
 public function DoCreateGroup($form) {
      if($this->user->CreateGroup($form['acronym']['value'], 
                           $form['name']['value']
                           )) {
         $this->AddMessage('success', "Welcome {$this->user['name']}. Your have successfully created a new account.");
         $this->RedirectToController('index');
       }
 }
 
 public function DoConfigSave($form) {
    $entry = "<?php \$mm->config['theme']['data']['header']='{$form['header']['value']}';";
    $entry .= " \$mm->config['theme']['data']['footer']='{$form['footer']['value']}';";
    $entry .= " \$mm->config['theme']['data']['logo']='{$form['logo']['value']}';";
    $entry .= " \$mm->config['theme']['data']['logo_height']='{$form['logo_height']['value']}';";
    $entry .= " \$mm->config['theme']['data']['logo_width']='{$form['logo_width']['value']}';";
    $this->config['theme']['data']['header'] = $form['header']['value']; 
    CMConfig::Save($entry);
  /*  CMConfig::Load(); */
 /*   $this->RedirectToController('index'); */
 }
 
 public function DoMenuCreate($form) {
    $entry = "<?php \$mm->config['menus']['nav navbar-nav'] = Array("; 
    $i = 0;
    foreach ($this->config['menus']['nav navbar-nav'] as $menu) {
        $entry .="{$i}=> array('label'=>'{$menu['label']}', 'url'=>'{$menu['url']}'),";
        $i++;
    }
    $entry .= "{$i}=> array('label'=>'{$form['label']['value']}', 'url'=>'{$form['url']['value']}'),);";
    CMConfig::SaveMenu($entry);
 }
 
 public function DoMenu($form) {
    $entry = "<?php \$mm->config['menus']['nav navbar-nav'] = Array("; 
    $i = 0;
    do {
       $entry .= "{$i}=> array('label'=>'{$form["{$i}-label"]['value']}', 'url'=>'{$form["{$i}-url"]['value']}'),";
       $i++;
    } while (isset($form["{$i}-label"]['value']));
    $entry .= ");";
    CMConfig::SaveMenu($entry);
 }
 
 public function DoDeleteMenu($form, $key) {
     $entry = "<?php \$mm->config['menus']['nav navbar-nav'] = Array("; 
     $i = 0;
     do {
        $entry .= "{$i}=> array('label'=>'{$form["{$i}-label"]['value']}', 'url'=>'{$form["{$i}-url"]['value']}'),";
        $i++;
     } while ($i < $key);
     while (($i >= $key) && isset($form["{$i}-label"]['value'])) {
       $i++;
       $entry .= "{$i}=> array('label'=>'{$form["{$i}-label"]['value']}', 'url'=>'{$form["{$i}-url"]['value']}'),";
     } 
     $entry .= ");";
     CMConfig::SaveMenu($entry);
 }

} 
