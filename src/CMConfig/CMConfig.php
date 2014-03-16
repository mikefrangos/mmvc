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
  public function __construct() {
    parent::__construct();
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
     return array('success', 'Successfully restored default config settings.');
     break;
      
      default:
        throw new Exception('Unsupported action for this module.');
      break;
  }
 }
 
  public static function Save($entry) {
      file_put_contents(MMVC_SITE_PATH.'/data/header.php', $entry);
  /*    return "Filen sparades."; 
    } else {
     return "Filen är inte skrivbar och kunde inte sparas."; 
  } */
 }
 
 public static function Load() {
 	require(MMVC_SITE_PATH.'/data/header.php');
 }
 
 public static function SaveMenu($entry) {
     file_put_contents(MMVC_SITE_PATH.'/data/menu.php', $entry);
 }
 
}
