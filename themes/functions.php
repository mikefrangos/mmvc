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
 * Check if there is a message
 */
function is_success() {
    $messages = CMmvc::Instance()->session->GetMessages();
    if(!empty($messages)) {
      foreach($messages as $val) {
    	 if ($val['type'] == 'success') {
    	    return TRUE;
    	 }
      }
    }
    return FALSE;
}
 
    
	
/**
* Login menu. Creates a menu which reflects if user is logged in or not.
*/
function login_menu() {
  $mm = CMmvc::Instance();
  if($mm->user['isAuthenticated']) {
    $items = "<a href='" . create_url('user/profile') . "'><img class='gravatar' src='" . get_gravatar(20) . "' alt=''> " . $mm->user['acronym'] . "</a> ";
    if($mm->user['hasRoleAdmin']) {
      $items .= "<a href='" . create_url('acp') . "'>acp</a> ";
    }
    $items .= "<a href='" . create_url('user/logout') . "'>logout</a> ";
  } else {
    $items = "<a href='" . create_url('user/login') . "'>login</a> ";
  }
  return "<nav>$items</nav>";
}


/**
* Create a url by prepending the base_url.
*/
function base_url($url=null) {
  return CMmvc::Instance()->request->base_url . trim($url, '/');
}

/**
 * Create a url to an internal resource.
 *
 * @param string the whole url or the controller. Leave empty for current controller.
 * @param string the method when specifying controller as first argument, else leave empty.
 * @param string the extra arguments to the method, leave empty if not using method.
 */
function create_url($urlOrController=null, $method=null, $arguments=null) {
  return CMmvc::Instance()->CreateUrl($urlOrController, $method, $arguments);
}

/**
 * Prepend the theme_url, which is the url to the current theme directory.
 *
 * @param $url string the url-part to prepend.
 * @returns string the absolute url.
 */
function theme_url($url) {
  return create_url(CMmvc::Instance()->themeUrl . "/{$url}");
}


/**
 * Prepend the theme_parent_url, which is the url to the parent theme directory.
 *
 * @param $url string the url-part to prepend.
 * @returns string the absolute url.
 */
function theme_parent_url($url) {
  return create_url(CMmvc::Instance()->themeParentUrl . "/{$url}");
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
function render_views($region='default') {
  return CMmvc::Instance()->views->Render($region);
}

/**
* Check if region has views. Accepts variable amount of arguments as regions.
*
* @param $region string the region to draw the content in.
*/
function region_has_content($region='default' /*...*/) {
  return CMmvc::Instance()->views->RegionHasView(func_get_args());
}

/**
* Get a gravatar based on the user's email.
*/
function get_gravatar($size=null) {
  return 'http://www.gravatar.com/avatar/' . md5(strtolower(trim(CMmvc::Instance()->user['email']))) . '.jpg?' . ($size ? "s=$size" : null);
}

/**
 * Escape data to make it safe to write in the browser.
 */
function esc($str) {
  return htmlEnt($str);
}

 /**
 * Filter data according to a filter. Uses CMContent::Filter()
 *
 * @param $data string the data-string to filter.
 * @param $filter string the filter to use.
 * @returns string the filtered string.
 */
function filter_data($data, $filter) {
  return CTextFilter::Filter($data, $filter);
}


/**
 * Display diff of time between now and a datetime. 
 *
 * @param $start datetime|string
 * @returns string
 */
function time_diff($start) {
  return formatDateTimeDiff($start);
}
