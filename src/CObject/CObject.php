<?php
/**
* Holding a instance of CMmvc to enable use of $this in subclasses.
*
* @package MmvcCore
*/
class CObject {

   public $config;
   public $request;
   public $data;
   public $db;
   public $views;
   public $session;

   /**
    * Constructor
    */
   protected function __construct() {
    $mm = CMmvc::Instance();
    $this->config   = &$mm->config;
    $this->request  = &$mm->request;
    $this->data     = &$mm->data;
    $this->db       = &$mm->db;
    $this->views    = &$mm->views;
    $this->session  = &$mm->session;

  }

/**
         * Redirect to another url and store the session
         */
        protected function RedirectTo($url) {
    $mm = CMmvc::Instance();
    if(isset($mm->config['debug']['db-num-queries']) && $mm->config['debug']['db-num-queries'] && isset($mm->db)) {
      $this->session->SetFlash('database_numQueries', $this->db->GetNumQueries());
    }    
    if(isset($mm->config['debug']['db-queries']) && $mm->config['debug']['db-queries'] && isset($mm->db)) {
      $this->session->SetFlash('database_queries', $this->db->GetQueries());
    }    
    if(isset($mm->config['debug']['timer']) && $mm->config['debug']['timer']) {
            $this->session->SetFlash('timer', $mm->timer);
    }    
    $this->session->StoreInSession();
    header('Location: ' . $this->request->CreateUrl($url));
  }
  
}
