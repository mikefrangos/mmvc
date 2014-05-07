<?php
use \Michelf\MarkdownExtra;

/**
* A model for content stored in database.
* 
* @package MmvcCore
*/
class CMContent extends CObject implements IHasSQL, ArrayAccess, IModule {

  /**
   * Properties
   */
  public $data;


  /**
   * Constructor
   */
  public function __construct($id=null) {
    parent::__construct();
    if($id) {
      $this->LoadById($id);
    } else {
      $this->data = array();
    }
  }


  /**
   * Implementing ArrayAccess for $this->data
   */
  public function offsetSet($offset, $value) { if (is_null($offset)) { $this->data[] = $value; } else { $this->data[$offset] = $value; }}
  public function offsetExists($offset) { return isset($this->data[$offset]); }
  public function offsetUnset($offset) { unset($this->data[$offset]); }
  public function offsetGet($offset) { return isset($this->data[$offset]) ? $this->data[$offset] : null; }


  /**
   * Implementing interface IHasSQL. Encapsulate all SQL used by this class.
   *
   * @param string $key the string that is the key of the wanted SQL-entry in the array.
   */
  public static function SQL($key=null, $args=null) {
    $order_order  = isset($args['order-order']) ? $args['order-order'] : 'ASC';
    $order_by     = isset($args['order-by'])    ? $args['order-by'] : 'id';    
    $groups = "";
    if (isset($args['groups'])) {
      foreach ($args['groups'] as $id) {
    	    $groups .= "OR cg.idGroups={$id} ";
       }
    } 
    $queries = array(
      'drop table content'      => "DROP TABLE IF EXISTS Content;",
      'drop table content2group' => "DROP TABLE IF EXISTS Content2Groups",
      'create table content'    => "CREATE TABLE IF NOT EXISTS Content (id INTEGER PRIMARY KEY, key TEXT KEY, type TEXT, title TEXT, data TEXT, filter TEXT, idUser INT, public INT default NULL, created DATETIME default (datetime('now')), updated DATETIME default NULL, deleted DATETIME default NULL, FOREIGN KEY(idUser) REFERENCES User(id));",
      'create table content2group' => "CREATE TABLE IF NOT EXISTS Content2Groups (idContent INTEGER, idGroups INTEGER, created DATETIME default (datetime('now')), PRIMARY KEY(idContent, idGroups));", 
      'insert content'          => 'INSERT INTO Content (key,type,title,data,filter,public,idUser) VALUES (?,?,?,?,?,?,?);',
      'insert into content2group'  => 'INSERT INTO Content2Groups (idContent,idGroups) VALUES (?,?);',
      'get group memberships'   => 'SELECT * FROM Groups AS g INNER JOIN Content2Groups AS cg ON g.id=cg.idGroups WHERE cg.idContent=? AND g.deleted IS NULL;',
      'select * by id'          => "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id LEFT JOIN Content2Groups as cg ON c.id=cg.idContent WHERE (c.public IS NULL {$groups}) AND c.id=? AND c.deleted IS NULL;",
      'select * by type'        => "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id LEFT JOIN Content2Groups as cg ON c.id=cg.idContent WHERE (c.public IS NULL {$groups}) AND type=? AND c.deleted IS NULL ORDER BY {$order_by} {$order_order};",
      'select * by key'         => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.key=? AND c.deleted IS NULL;',
      'select * by group'       => "SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id LEFT JOIN Content2Groups as cg ON c.id=cg.idContent WHERE (c.public IS NULL {$groups}) AND c.deleted IS NULL;",
      'select *'                => 'SELECT c.*, u.acronym as owner FROM Content AS c INNER JOIN User as u ON c.idUser=u.id WHERE c.deleted IS NULL;;',
      'update content'          => "UPDATE Content SET key=?, type=?, title=?, data=?, filter=?, public=?, updated=datetime('now') WHERE id=?;",
      'update content as deleted' => "UPDATE Content SET deleted=datetime('now') WHERE id=?;",
      'remove from content2group'  => 'DELETE FROM Content2Groups WHERE (idContent=? AND idGroups=?);',
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
      $this->db->ExecuteQuery(self::SQL('drop table content2group'));
      $this->db->ExecuteQuery(self::SQL('drop table content'));
      $this->db->ExecuteQuery(self::SQL('create table content')); 
      $this->db->ExecuteQuery(self::SQL('create table content2group')); 
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world', 'post', 'Hello World', "This is a demo post.\n\nThis is another row in this demo post.", 'plain', NULL, $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-again', 'post', 'Hello World Again', "This is another demo post.\n\nThis is another row in this demo post.", 'plain', NULL, $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('hello-world-once-more', 'post', 'Hello World Once More', "This is one more demo post.\n\nThis is another row in this demo post.", 'plain', NULL, $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('home', 'page', 'Home page', "This is a demo page, this could be your personal home-page.\n\nMmvc is a PHP-based MVC-inspired Content management Framework, based on Lydia. Watch the making of Lydia at: http://dbwebb.se/lydia/tutorial.", 'plain', NULL, $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('about', 'page', 'About page', "This is a demo page, this could be your personal about-page.\n\nMmvc is used as a tool to educate in MVC frameworks.", 'plain', NULL, $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('download', 'page', 'Download page', "This is a demo page, this could be your personal download-page.\n\nYou can download your own copy of Mmvc from https://github.com/mikefrangos/mmvc.", 'plain', NULL, $this->user['id']));      
      $this->db->ExecuteQuery(self::SQL('insert content'), array('bbcode', 'page', 'Page with BBCode', "This is a demo page with some BBCode-formatting.\n\n[b]Text in bold[/b] and [i]text in italic[/i] and [url=http://dbwebb.se]a link to dbwebb.se[/url].  You can also include images using bbcode, such as the lydia logo: [img]http://dbwebb.se/lydia/current/themes/core/logo_80x80.png[/img]", 'bbcode', NULL, $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('htmlpurify', 'page', 'Page with HTMLPurifier', "This is a demo page with some HTML code intended to run through <a href='http://htmlpurifier.org/'>HTMLPurify</a>. Edit the source and insert HTML code and see if it works.\n\n<b>Text in bold</b> and <i>text in italic</i> and <a href='http://dbwebb.se'>a link to dbwebb.se</a>. JavaScript, like this: <javascript>alert('hej');</javascript> should however be removed.", 'htmlpurify', NULL, $this->user['id'])); 
      $this->db->ExecuteQuery(self::SQL('insert content'), array('markdown', 'page', 'Page with Markdown', "This is a demo page with some code intended to run through Markdown. Edit the source and insert Markdown and see if it works.\n\nHere is a paragraph with some **bold** text and some *italic* text and a [link to dbwebb.se](http://dbwebb.se).", 'markdown', NULL, $this->user['id']));
      $this->db->ExecuteQuery(self::SQL('insert content'), array('smartypants', 'page', 'Page with PHP Smartypants Typographer', "This is a demo page with some text intended to run through PHP SmartyPants Typographer. Edit the source and insert some text and see if it works.\n\nThis is \"double quotation marks\".\n\nThese are 'single quotation marks'.\n\nThis is a -- n dash.\n\nThis should be an ellipse...", 'smartypants', NULL, $this->user['id']));
      return array('success', 'Successfully created the database tables and created a default "Hello World" blog post, owned by you.');
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
   * Save content. If it has a id, use it to update current entry or else insert new entry.
   *
   * @returns boolean true if success else false.
   */
  public function Save($add, $remove) {
    $msg = null;
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this['public'], $this['id']));
      $msg = 'update';
    } else {
      $this->db->ExecuteQuery(self::SQL('insert content'), array($this['key'], $this['type'], $this['title'], $this['data'], $this['filter'], $this['public'], $this->user['id']));
      $this['id'] = $this->db->LastInsertId();
      $msg = 'created';
    }
    foreach ($add as $id) {
    	    $this->db->ExecuteQuery(self::SQL('insert into content2group'), array($this['id'], $id));
    }
    foreach ($remove as $id) {
    	    $this->db->ExecuteQuery(self::SQL('remove from content2group'), array($this['id'], $id));
    } 
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully {$msg} content '{$this['key']}'.");
    } else {
      $this->AddMessage('error', "Failed to {$msg} content '{$this['key']}'.");
    }
    return $rowcount === 1;
  }
    
  /**
   * Delete content. Set its deletion-date to enable wastebasket functionality.
   *
   * @returns boolean true if success else false.
   */
  public function Delete() {
    if($this['id']) {
      $this->db->ExecuteQuery(self::SQL('update content as deleted'), array($this['id']));
    }
    $rowcount = $this->db->RowCount();
    if($rowcount) {
      $this->AddMessage('success', "Successfully set content '" . htmlEnt($this['key']) . "' as deleted.");
    } else {
      $this->AddMessage('error', "Failed to set content '" . htmlEnt($this['key']) . "' as deleted.");
     }
    return $rowcount === 1;
  }

  /**
   * Load content by id.
   *
   * @param id integer the id of the content.
   * @returns boolean true if success else false.
   */
  public function LoadById($id) {
       $args=null;
       if (isset($this->user['groups'])) {
          $args['groups'] = Array();
          foreach ($this->user['groups'] as $group) {
    	      array_push($args['groups'],  $group['id']);
          }
       } 
       $res = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by id', $args), array($id));
       if(empty($res)) {
         $this->AddMessage('error', "Failed to load content with id '$id'.");
         return false;
       } else {
         $this->data = $res[0];
         $this->data['groups'] = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get group memberships'), array($id)); 
         return true;
       }
       return false;
  }
  
  /**
   * Check content permissions.
   *
   * @param id integer the id of the content.
   * @returns boolean true if success else false.
   */
  public function CheckGroups($id) {
      $groups = $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('get group memberships'), array($id));	  
      if (!empty($groups)) {
      	   if (!empty($this->user['groups'])) { 
      	   	 if (empty(array_intersect(array_column($this->user['groups'], 'id'), array_column($groups, 'id')))) {
      	   	    $this->AddMessage('notice', 'You do not have permission to view this content. Check your group memberships.');
      	            return false;
      	         }
           } else {
              $this->AddMessage('notice', 'You do not have permission to view this content. Check your group memberships.');
      	      return false;
           }
      } else {
      	   return true;
      }
  }
      	  
    
  
  /**
   * List all content.
   *
   * @returns array with listing or null if empty.
   */
  public function ListAll($args=null) {
    if (isset($this->user['groups'])) {
      $args['groups'] = Array();
      foreach ($this->user['groups'] as $group) {
    	      array_push($args['groups'],  $group['id']);
      }
    } 
    try {
      if(isset($args) && isset($args['type'])) {
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by type', $args), array($args['type']));	    
    } else {	    
        return $this->db->ExecuteSelectQueryAndFetchAll(self::SQL('select * by group', $args));
      }
    } catch(Exception $e) {
      echo $e;
      return null; 
    }  
  }
  
  
  
  /**
   * Get the filtered content.
   *
   * @returns string with the filtered data.
   */
  public function GetFilteredData() {
    return CTextFilter::Filter($this['data'], $this['filter']);
  }

  
  
}
