<?php
/**
* A model for user config options.
* 
* @package MmvcCore
*/
class CMConfig extends CObject implements IModule {
	   
	
  /**
   * Constructor
   */
  public function __construct($mm=null) {
    parent::__construct($mm);
    if (is_file(MMVC_SITE_PATH.'/data/header.php')) {
        require (MMVC_SITE_PATH.'/data/header.php');
    }
    if (is_file(MMVC_SITE_PATH.'/data/menu.php')) {
        require (MMVC_SITE_PATH.'/data/menu.php');
    } 
  
  }
  
  
  public function Manage($action=null) {
     switch ($action) {
     case 'install':
       if (is_file(MMVC_SITE_PATH.'/data/header.php') && is_writable(MMVC_SITE_PATH.'/data/header.php')) {
     	  unlink(MMVC_SITE_PATH.'/data/header.php');
       } 
       if (is_file(MMVC_SITE_PATH.'/data/menu.php') && is_writable(MMVC_SITE_PATH.'/data/menu.php')) {
     	  unlink(MMVC_SITE_PATH.'/data/menu.php');
       } 
       $mm = &$this;
       require(MMVC_SITE_PATH.'/config.php');
       $this->session->SetFlash('entry', '');
       return array('success', 'Successfully restored default config settings.');
       break;
      
     default:
       throw new Exception('Unsupported action for this module.');
     break;
  }
 }
 
  public function Save($entry) {
      if (is_file(MMVC_SITE_PATH.'/data/header.php') && is_writable(MMVC_SITE_PATH.'/data/header.php')) {
     	  unlink(MMVC_SITE_PATH.'/data/header.php');
     	  require(MMVC_SITE_PATH.'/config.php');
      }
      file_put_contents(MMVC_SITE_PATH.'/data/header.php', $entry);
      $mm = &$this;
      $config = substr($entry, 6);
      eval($config);
      $this->session->SetFlash('entry', $entry);
      $header = $this->config['theme']['data']['header'];
      $this->session->AddMessage('success', "Config saved.");  
      return TRUE;

 }
 
 public function SaveMenu($entry) {
     file_put_contents(MMVC_SITE_PATH.'/data/menu.php', $entry);
     $this->session->AddMessage('success', 'Menu saved.');
     $mm = &$this;
     require (MMVC_SITE_PATH.'/data/menu.php');
     $this->session->SetFlash('entry', $entry);
     return true;
 }
 
}
