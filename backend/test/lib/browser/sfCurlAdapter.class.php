<?php

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
 * @author     Ben Meynell <bmeynell@colorado.edu>
 * @version    0.9
 */

class sfCurlAdapter
{
  protected
    $options = array(),
    $curl    = null,
    $headers = array();

  /**
   * Build a curl adapter instance
   * Accepts an option of parameters passed to the PHP curl adapter:
   *  ssl_verify  => [true/false]
   *  verbose     => [true/false]
   *  verbose_log => [true/false]
   * Additional options are passed as curl options, under the form:
   *  userpwd => CURL_USERPWD
   *  timeout => CURL_TIMEOUT
   *  ...
   *
   * @param array $options Curl-specific options
   */
  public function __construct($options = array())
  {
    if (!extension_loaded('curl'))
    {
      throw new Exception('Curl extension not loaded');
    }

    $this->options = $options;
    $curl_options = $options;
    
    $this->curl = curl_init();

    // cookies
    if (isset($curl_options['cookies']))
    {
      $cookie_file = dirname(__FILE__).'/cookies.txt';

      curl_setopt($this->curl, CURLOPT_COOKIESESSION, false);
      curl_setopt($this->curl, CURLOPT_COOKIEJAR, $cookie_file);
      curl_setopt($this->curl, CURLOPT_COOKIEFILE, $cookie_file);
      unset($curl_options['cookies']);
    }

    // default settings
    curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($this->curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, false);
    curl_setopt($this->curl, CURLOPT_FRESH_CONNECT, true);
    
    if(isset($this->options['followlocation']))
    {
      curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, (bool) $this->options['followlocation']);
    }
    
    // activate ssl certificate verification?
    
    if (isset($this->options['ssl_verify_host']))
    {
      curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, (bool) $this->options['ssl_verify_host']);
    }
    if (isset($curl_options['ssl_verify']))
    {
      curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, (bool) $this->options['ssl_verify']);
      unset($curl_options['ssl_verify']);
    }
    // verbose execution?
    if (isset($curl_options['verbose']))
    {
      curl_setopt($this->curl, CURLOPT_NOPROGRESS, false);
      curl_setopt($this->curl, CURLOPT_VERBOSE, true);
      unset($curl_options['cookies']);
    }
    
    
    // Additional options
    foreach ($curl_options as $key => $value)
    {
      $const = constant('CURLOPT_' . strtoupper($key));
      if(!is_null($const))
      {
        curl_setopt($this->curl, $const, $value);
      }
    }
    
    // response header storage - uses callback function
    curl_setopt($this->curl, CURLOPT_HEADERFUNCTION, array($this, 'read_header'));
  }

  /**
   * Submits a request
   *
   * @param string  The request uri
   * @param string  The request method
   * @param array   The request parameters (associative array)
   * @param array   The request headers (associative array)
   *
   * @return sfWebBrowser The current browser object
   */
  public function call($browser, $uri, $method = 'GET', $parameters = array(), $headers = array())
  {
    // uri
    curl_setopt($this->curl, CURLOPT_URL, $uri);

    // request headers
    $m_headers = array_merge($browser->getDefaultRequestHeaders(), $browser->initializeRequestHeaders($headers));
    $request_headers = explode("\r\n", $browser->prepareHeaders($m_headers));
    curl_setopt($this->curl, CURLOPT_HTTPHEADER, $request_headers);
   
    // encoding support
    if(isset($headers['Accept-Encoding']))
    {
      curl_setopt($this->curl, CURLOPT_ENCODING, $headers['Accept-Encoding']);
    }
    
    // timeout support
    if(isset($this->options['Timeout']))
    {
      curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->options['Timeout']);
    }
    
    if (!empty($parameters))
    {
      if (!is_array($parameters))
      {
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $parameters);
      }
      else
      {
        // multipart posts (file upload support)
        $has_files = false;
        foreach ($parameters as $name => $value)
        {
          if (is_array($value)) {
            continue;
          }
          if (is_file($value))
          {
            $has_files = true;
            $parameters[$name] = '@'.realpath($value);
          }
        }
        if($has_files)
        {
          curl_setopt($this->curl, CURLOPT_POSTFIELDS, $parameters);
        }
        else
        {
          curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($parameters, '', '&'));
        }
      }
    }

    // handle any request method
    curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $method);

    $response = curl_exec($this->curl);

    if (curl_errno($this->curl))
    {
      throw new Exception(curl_error($this->curl));
    }

    $requestInfo = curl_getinfo($this->curl);

    $browser->setResponseCode($requestInfo['http_code']);
    $browser->setResponseHeaders($this->headers);
    $browser->setResponseText($response);

    // clear response headers
    $this->headers = array();

    return $browser;
  }

  public function __destruct()
  {
    curl_close($this->curl);
  }

  protected function read_header($curl, $headers)
  {
    $this->headers[] = $headers;
    
    return strlen($headers);
  }
}
