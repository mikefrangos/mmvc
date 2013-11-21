<?php
/**
* Helpers for theming, available for all themes in their template files and functions.php.
* This file is included right before the themes own functions.php
*/

/**
* Print debuginformation from the framework.
*/
function get_debug() {
  $mm = CMmvc::Instance();
  if(empty($mm->config['debug'])) {
    return;
  }
  
  $html = null;
  if(isset($mm->config['debug']['db-num-queries']) && $mm->config['debug']['db-num-queries'] && isset($mm->db)) {
    $flash = $mm->session->GetFlash('database_numQueries');
    $flash = $flash ? "$flash + " : null;
    $html .= "<p>Database made $flash" . $mm->db->GetNumQueries() . " queries.</p>";
  }    
  if(isset($mm->config['debug']['db-queries']) && $mm->config['debug']['db-queries'] && isset($mm->db)) {
    $flash = $mm->session->GetFlash('database_queries');
    $queries = $mm->db->GetQueries();
    if($flash) {
      $queries = array_merge($flash, $queries);
    }
  	  $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $queries) . "</pre>";
  }   
   if(isset($mm->config['debug']['timer']) && $mm->config['debug']['timer']) {
    $html .= "<p>Page was loaded in " . round(microtime(true) - $mm->timer['first'], 5)*1000 . " msecs.</p>";
  }  
  if(isset($mm->config['debug']['mmvc']) && $mm->config['debug']['mmvc']) {
    $html .= "<hr><h3>Debuginformation</h3><p>The content of CMmvc:</p><pre>" . htmlent(print_r($mm, true)) . "</pre>";
  } 
  if(isset($mm->config['debug']['session']) && $mm->config['debug']['session']) {
    $html .= "<hr><h3>SESSION</h3><p>The content of CMmvc->session:</p><pre>" . htmlent(print_r($mm->session, true)) . "</pre>";
    $html .= "<p>The content of \$_SESSION:</p><pre>" . htmlent(print_r($_SESSION, true)) . "</pre>";
  } 
  return $html; 
}

/**
 * Get messages stored in flash-session.
 */
function get_messages_from_session() {
  $messages = CMmvc::Instance()->session->GetMessages();
  $html = null;
  if(!empty($messages)) {
    foreach($messages as $val) {
      $valid = array('info', 'notice', 'success', 'warning', 'error', 'alert');
      $class = (in_array($val['type'], $valid)) ? $val['type'] : 'info';
      $html .= "<div class='$class'>{$val['message']}</div>\n";
    }
  }
  return $html;
}


/**
* Create a url by prepending the base_url.
*/
function base_url($url) {
  return CMmvc::Instance()->request->base_url . trim($url, '/');
}

/**
* Return the current url.
*/
function current_url() {
  return CMmvc::Instance()->request->current_url;
}

/**
* Render all views.
*/
function render_views() {
  return CMmvc::Instance()->views->Render();
}
