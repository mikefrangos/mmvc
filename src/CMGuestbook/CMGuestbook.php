<?php
/**
* A model for a guestbok, to show off some basic controller & model-stuff.
* 
* @package MmvcCore
*/
class CMGuestbook extends CObject implements IHasSQL, IModule {


  /**
   * Constructor
   */
  public function __construct() {
    parent::__construct();
  }


  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null) {
    $queries = array(
      'drop table guestbook'    => 'DROP TABLE IF EXISTS Guestbook;',
      'create table guestbook'  => "CREATE TABLE IF NOT EXISTS Guestbook (id INTEGER PRIMARY KEY, entry TEXT, parent INTEGER default NULL, created DATETIME default (datetime('now')));",
      'insert into guestbook'   => 'INSERT INTO Guestbook (entry, parent) VALUES (?,?);',
      'select * from guestbook' => 'SELECT * FROM Guestbook ORDER BY id DESC;',
      'select * by id'          => "SELECT * FROM Guestbook WHERE id=?",
      'delete from guestbook'   => 'DELETE FROM Guestbook;',
     );
    if(!isset($queries[$key])) {
      throw new Exception("No such SQL query, key '$key' was not found.");
    }
    return $queries[$key];
  }


 /**
   * Implementing interface IModule. Manage install/update/deinstall and equal actions.
   */
  public function Manage($action=null) {
    switch($action) {
      case 'install': 
    try {
      $this->db->ExecuteQuery(self::SQL('drop table guestbook'));
      $this->db->ExecuteQuery(self::SQL('create table guestbook'));
     return array('success', 'Successfully created the database tables (or left them untouched if they already existed).');
    } catch(Exception$e) {
      die("$e<br/>Failed to open database: " . $this->config['database'][0]['dsn']);
    }
    break;
      
      default:
        throw new Exception('Unsupported action for this module.');
      break;
  }
 }
  

  /**
   * Add a new entry to the guestbook and save to database.
   */
  public function Add($entry, $parent) {
    $this->db->ExecuteQuery(self::SQL('insert into guestbook'), array($entry, $parent));
    $rowcount = $this->db->RowCount();
    if($rowcount) {
        $this->session->AddMessage('success', 'Successfully inserted new message.');
    } else {
        $this->AddMessage('error', 'Failed to insert new guestbook item into database.');
    }
    return $rowcount === 1;
  }
  

  /**
   * Delete all entries from the guestbook and database.
   */
  public function DeleteAll() {
    $this->db->ExecuteQuery(self::SQL('delete from guestbook'));
    $this->session->AddMessage('info', 'Removed all messages from the database table.');
    return true;
  }
  
  
  /**
   * Read all entries from the guestbook & database.
   */
  public function ReadAll() {
    try {
      return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * from guestbook'));
    } catch(Exception $e) {
      return array();    
    }
  }
  
  public function Read($id=null) {
    if (isset($id)) {
      try {
    	return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id'), (array($id)));
      } catch(Exception $e) {
      	return false;
      } 
    } else {
      try {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * from guestbook'));
      } catch(Exception $e) {
        return array();    
      }
   }
    	  
  }
    
   

  
}
