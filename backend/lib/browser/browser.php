<?php

require('sfWebBrowserInvalidResponseException.class.php');
require('sfCurlAdapter.class.php');
require('sfWebBrowser.class.php');


/*
 * This file is part of the sfWebBrowserPlugin package.
 * (c) 2004-2006 Francois Zaninotto <francois.zaninotto@symfony-project.com>
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com> for the click-related functions
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWebBrowser provides a basic HTTP client.
 *
 * @package    sfWebBrowserPlugin
 * @author     Francois Zaninotto <francois.zaninotto@symfony-project.com>
 * @author     Tristan Rivoallan <tristan@rivoallan.net>
 * @version    0.9
 */
class browser extends sfWebBrowser
{
  private static $instance;

  public function getResponseJson()
  {
    $text = $this->getResponseText();

    try {
      return json_decode($text, true, 512, JSON_BIGINT_AS_STRING);
    } catch (Exception $e) {
      return;
    }
  }

  public function getUrl()
  {
    return $this->urlInfo; 
  }


  public function call($uri, $method = 'GET', $parameters = array(), $headers = array(), $changeStack = true)
  {
  	try {
  		return parent::call($uri, $method, $parameters, $headers, $changeStack);	
  	} catch (Exception $e) {
  		return $this;
  	}
  }	

  public static function create($defaultHeaders = array(), $adapterClass = null, $adapterOptions = array()){
    if(!isset(self::$instance)){
      self::$instance = new self($defaultHeaders, $adapterClass, $adapterOptions);
    }

    return self::$instance;
  }


  public function responseIsError()
  {
    return ($this->getResponseCode() == '' || parent::responseIsError()); 
  }
}
