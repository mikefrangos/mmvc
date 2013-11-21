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
  $html = null;
  if(isset($mm->config['debug']['db-num-queries']) && $mm->config['debug']['db-num-queries'] && isset($mm->db)) {
    $html .= "<p>Database made " . $mm->db->GetNumQueries() . " queries.</p>";
  }    
  if(isset($mm->config['debug']['db-queries']) && $mm->config['debug']['db-queries'] && isset($mm->db)) {
    $html .= "<p>Database made the following queries.</p><pre>" . implode('<br/><br/>', $mm->db->GetQueries()) . "</pre>";
  }   
  if(isset($mm->config['debug']['mmvc']) && $mm->config['debug']['mmvc']) {
    $html = "<hr><h3>Debuginformation</h3><p>The content of CMmvc:</p><pre>" . htmlent(print_r($mm, true)) . "</pre>";
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
