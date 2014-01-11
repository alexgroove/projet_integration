<?php

namespace Framework\Components\Routing;
use Framework\Components\Routing\Interfaces\IResponse;
use Framework\Components\Routing\Exceptions\HeadersAlreadySentException;

defined('CORE_EXEC') or die('Restricted Access');


class Response implements IResponse {


	/**
	 *
	 * HTTP constant codes
	 *
	 */
	const HTTP_OK        = '200 OK';
	const HTTP_NOT_FOUND = '404 Not Found';
	const HTTP_FORBIDDEN = '403 Forbidden';


	/**
	 *
	 * @var $content
	 * @access private
	 *
	 */
	private $content;


	/**
	 *
	 * @var $http_code
	 * @access private
	 *
	 */
	private $http_code;


	/**
	 *
	 * @var $content_type
	 * @access private
	 *
	 */
	private $content_type;

	
	/**
	 *
	 * @var $http_caching
	 * HTTP caching wont happen if the ENVIRONMENT is on DEVELOPMENT
	 * @access private
	 *
	 */
	private $http_caching;


	/**
	 *
	 * @var $filename
	 * @access private
	 *
	 */
	private $filename;
	

	/**
	 *
	 * Response Contructor
	 * @access public
	 * @param (string) $content;
	 * @param (Reponse constant) $http_code
	 * @param (string) $content_type
	 * @param (int) $http_caching - time in second that you want the browser to cache a file
	 *
	 */	
	public function __construct ($content='', $http_code=self::HTTP_OK, $content_type='text/html', $http_caching=-1) {
		$this->content = $content;
		$this->http_code = $http_code;
		$this->content_type = $content_type;
		$this->http_caching = $http_caching;
	}

	
	/**
	 *		
	 * - setContentType		
	 * @access public
	 * @param (string) $content_type
	 *		
	 */
	public function setContentType ($content_type) {
		$this->content_type = $content_type;
	}


	/**
	 *		
	 * - setStatusCode
	 * @access public
	 * @param (Response constant) $http_code
	 *		
	 */
	public function setStatusCode ($http_code) {
		$this->http_code = $http_code;
	}


	/**
	 *		
	 * - setContent	
	 * @access public
	 * @param (string) $content
	 *		
	 */
	public function setContent ($content) {
		$this->content = $content;
	}


	/**
	 *		
	 * - setCaching
	 * @access public
	 * @param (int) $http_caching - number of second you want the browser to cache the response
	 *		
	 */
	public function setCaching ($http_caching=86400) {
		$this->http_caching = $http_caching;
	}


	/**
	 *		
	 * - setFilename
	 * Use this function when you are sending an image or other downloadable file type.
	 * @access public
	 * @param (int) $http_caching - number of second you want the browser to cache the response
	 *		
	 */
	public function setFilename ($filename) {
		$this->filename = $filename;
	}


	/**
	 *		
	 * - send		
	 * @access public
	 * @param $content (optional) - use to faster sending content.
	 * @return true
	 *		
	 */
	public function send ($content='') {
		if (headers_sent()) {
			throw new HeadersAlreadySentException();
		}
		header('HTTP/1.1 '. $this->http_code);
		header('Content-Type: '.$this->content_type);
    header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time() + 2592000));
    header('Vary: Accept-Encoding');
		if (isset($this->filename)) {
			header('Content-Disposition: inline; filename="'.$this->filename.'"');
		}    
		if ($this->http_caching > 0 && ENVIRONMENT != DEVELOPMENT) {
	    header('Pragma: public, cache');
	    header('Cache-Control: no-transform, public, max-age='.$this->http_caching);
	    header('Last-Modified: '.gmdate('D, d M Y H:i:s \G\M\T', time() - 2592000));
	  } else {
	  	header('Pragma: no-cache');
	  	header('Cache-Control: max-age=0, private, no-cache, no-store, must-revalidate');
	  }
		echo empty($content) ? $this->content : $content;
		return true;
	}
}

