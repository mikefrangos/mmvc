<?php
use \Michelf\Markdown; 

/**
 * A wrapper for various text filters
 * 
 * @package MmvcCore
 */
class CTextFilter {

  /**
   * Properties
   */
  public static $purify = null;
  
   /**
   * Filter content according to a filter.
   *
   * @param $data string of text to filter and format according its filter settings.
   * @returns string with the filtered data.
   */
  public static function Filter($data, $filter) {
    switch($filter) {
  /*  case 'php': $data = nl2br(makeClickable(eval('?>'.$data))); break;      
      case 'html': $data = nl2br(makeClickable($data)); break;  */
      case 'htmlpurify': $data = nl2br(CTextFilter::Purify($data)); break;
      case 'bbcode': $data = nl2br(CTextFilter::bbcode2html(htmlEnt($data))); break;
      case 'markdown': $data = CTextFilter::smartyPants(CTextFilter::markdown($data)); break;	      
      case 'smartypants': $data = nl2br(CTextFilter::makeClickable(CTextFilter::smartypants($data))); break;
      case 'plain':
      default: $data = nl2br(CTextFilter::makeClickable(htmlEnt($data))); break;
    }
    return $data;
  }
  
  
  /**
   * Purify it. Create an instance of HTMLPurifier if it does not exists. 
   *
   * @param $text string the dirty HTML.
   * @returns string as the clean HTML.
   */
   public static function Purify($text) {   
    if(!self::$purify) {
      require_once(__DIR__.'/htmlpurifier-4.6.0-standalone/HTMLPurifier.standalone.php');
      $config = HTMLPurifier_Config::createDefault();
      $config->set('Cache.DefinitionImpl', null);
      self::$purify = new HTMLPurifier($config);
    }
    return self::$purify->purify($text);
  }
  
  /**
 * Format text according to Markdown syntax.
 *
 * @param string $text the text that should be formatted.
 * @return string as the formatted html-text.
 */
public static function markdown($text) {
  require_once(__DIR__ . '/php-markdown/Michelf/MarkdownInterface.php');
  require_once(__DIR__ . '/php-markdown/Michelf/Markdown.php'); 
  require_once(__DIR__ . '/php-markdown/Michelf/MarkdownExtra.php');
/*  $ret = Markdown($text);
  return $ret; */
  return Markdown::defaultTransform($text);
}
  
/**
 * Format text according to PHP SmartyPants Typographer.
 *
 * @param string $text the text that should be formatted.
 * @return string as the formatted html-text.
 */
public static function smartyPants($text) {
  require_once(__DIR__ . '/php-smartypants-typographer-1.0.1/smartypants.php');
  return SmartyPants($text);
}

/**
 * Helper, make clickable links from URLs in text.
 */
public static function makeClickable($text) {
  return preg_replace_callback(
    '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', 
    create_function(
      '$matches',
      'return "<a href=\'{$matches[0]}\'>{$matches[0]}</a>";'
    ),
    $text
  );
}

/**
  * Helper, BBCode formatting converting to HTML.
  *
  * @param string text The text to be converted.
  * @returns string the formatted text.
  */
public static function bbcode2html($text) {
  $search = array( 
    '/\[b\](.*?)\[\/b\]/is', 
    '/\[i\](.*?)\[\/i\]/is', 
    '/\[u\](.*?)\[\/u\]/is', 
    '/\[img\](https?.*?)\[\/img\]/is', 
    '/\[url\](https?.*?)\[\/url\]/is', 
    '/\[url=(https?.*?)\](.*?)\[\/url\]/is' 
    );   
  $replace = array( 
    '<strong>$1</strong>', 
    '<em>$1</em>', 
    '<u>$1</u>', 
    '<img src="$1" />', 
    '<a href="$1">$1</a>', 
    '<a href="$1">$2</a>' 
    );     
  return preg_replace($search, $replace, $text);
}
 
  
}
