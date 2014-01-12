<?php
/**
* Site configuration, this file is changed by user per site.
*
*/

/*
* Set level of error reporting
*/
error_reporting(-1);
ini_set('display_errors', 1);

/**
 * Set database(s).
 */
$mm->config['database'][0]['dsn'] = 'sqlite:' . MMVC_SITE_PATH . '/data/.ht.sqlite';


/**
 * Set what to show as debug or developer information in the get_debug() theme helper.
 */
$mm->config['debug']['mmvc'] = false;
$mm->config['debug']['session'] = false;
$mm->config['debug']['timer'] = true;
$mm->config['debug']['db-num-queries'] = true;
$mm->config['debug']['db-queries'] = true;


/*
* Define session name
*/
$mm->config['session_name'] = preg_replace('/[:\.\/-_]/', '', __DIR__);
$mm->config['session_key']  = 'mmvc';

/*
* Define server timezone
*/
$mm->config['timezone'] = 'Europe/Stockholm';

/*
* Define internal character encoding
*/
$mm->config['character_encoding'] = 'UTF-8';

/*
* Define language
*/
$mm->config['language'] = 'en';

/**
* Define the controllers, their classname and enable/disable them.
*
* The array-key is matched against the url, for example: 
* the url 'developer/dump' would instantiate the controller with the key "developer", that is 
* CCDeveloper and call the method "dump" in that class. This process is managed in:
* $ly->FrontControllerRoute();
* which is called in the frontcontroller phase from index.php.
*/

$mm->config['controllers'] = array(
  'index'     => array('enabled' => true,'class' => 'CCIndex'),
  'developer' => array('enabled' => true,'class' => 'CCDeveloper'),
  'guestbook' => array('enabled' => true,'class' => 'CCGuestbook'),
  'content' => array('enabled' => true,'class' => 'CCContent'),
  'blog'    => array('enabled' => true,'class' => 'CCBlog'),
  'page'    => array('enabled' => true,'class' => 'CCPage'),
  'user' => array('enabled' => true,'class' => 'CCUser'),
  'acp'       => array('enabled' => true,'class' => 'CCAdminControlPanel'),
  'theme' => array('enabled' => true,'class' => 'CCTheme'),
);

/**
* Settings for the theme.
*/
$mm->config['theme'] = array(
  // The name of the theme in the theme directory
  'name'    => 'grid', 
  'stylesheet'  => 'style.php', 
  'template_file'   => 'index.tpl.php',
  'regions' => array('flash','featured-first','featured-middle','featured-last',
    'primary','sidebar','column-first','column-middle','column-last',
    'footer-column-one','footer-column-two','footer-column-three','footer-column-four',
    'footer',
  ),
  'data' => array(
    'header' => 'Mmvc',
    'slogan' => 'A PHP-based MVC-inspired CMF',
 /*   'favicon' => 'logo_80x80.png',
    'logo' => 'logo_80x80.png',  
    'logo_width'  => 80,
    'logo_height' => 80,  */
    'footer' => '<p>Mmvc &copy; by Mike Frangos </p>',
  ),
);

/**
* Set a base_url to use another than the default calculated
*/
$mm->config['base_url'] = null;

/**
* What type of urls should be used?
* 
* default      = 0      => index.php/controller/method/arg1/arg2/arg3
* clean        = 1      => controller/method/arg1/arg2/arg3
* querystring  = 2      => index.php?q=controller/method/arg1/arg2/arg3
*/
$mm->config['url_type'] = 1;

/**
* How to hash password of new users, choose from: plain, md5salt, md5, sha1salt, sha1.
*/
$mm->config['hashing_algorithm'] = 'sha1salt';

/**
* Allow or disallow creation of new user accounts.
*/
$mm->config['create_new_users'] = true;
