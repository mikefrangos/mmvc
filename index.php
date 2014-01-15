<?php
//
// PHASE: BOOTSTRAP
//
define('MMVC_INSTALL_PATH', dirname(__FILE__));
define('MMVC_SITE_PATH', MMVC_INSTALL_PATH . '/site');

require(MMVC_INSTALL_PATH.'/src/bootstrap.php');

$mm = CMmvc::Instance();

//
// PHASE: FRONTCONTROLLER ROUTE
//
$mm->FrontControllerRoute();


//
// PHASE: THEME ENGINE RENDER
//
$mm->ThemeEngineRender();
