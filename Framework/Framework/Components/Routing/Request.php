<?php

namespace Framework\Components\Routing;
use Framework\Components\Routing\Interfaces\IRequest;

defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * Core Framework
 * Class Request
 *
 * @author Alexandre Pagé
 *
 */
class Request implements IRequest {
	

	/**
	 *
	 * @constant DASH_STRING_URL_REGEX
	 * This constant is the regular expression that replace the :string route wildcard
	 *
	 */
	const DASH_STRING_URL_REGEX = '/\/[A-Z]([a-zA-Z]*-?[a-zA-Z]*)*\/?/';


	/**
	 *
	 * @constant DASH_PARAM_REGEX
	 * This constant is the regular expression that check if a param match the :string wildcard
	 *
	 */
	const DASH_PARAM_REGEX = '/^[A-Z]([a-zA-Z]*-[a-zA-Z]*)*/';


	/**
	 *
	 * @constant DASH_STRING_URL_REGEX
	 * This constant is the regular expression that replace the :id route wildcard
	 *
	 */	
	const NUMERIC_PARAM = '/\/[0-9]+\/?/';


	/**
	 *
	 * @var $method
	 * @access public
	 *
	 */
	public $method;


	/**
	 *
	 * @var $request
	 * @access public
	 *
	 */
	public $request = "";


	/**
	 *
	 * @var (array) $params 
	 * @access public
	 *
	 */
	public $params = array();


	/**
	 * Constructor
	 * @access public
	 *
	 */
	public function __construct () {
		$this->method = $_SERVER['REQUEST_METHOD'];
		if (isset($_GET['mvc'])) { 
			$this->request = rtrim($_GET['mvc'], '/'); 
		}
		$params = (isset($_GET['mvc'])) ? explode('/', rtrim($_GET['mvc'], '/')) : array('index');
		foreach($params as $param) {
			// Accumulate params when the value is numeric
			// Need to change that behavior to accept text parameter
			switch(true) {
				case (is_numeric($param)) : 
				case (preg_match(self::DASH_PARAM_REGEX, $param) ? true : false) :
					$this->params[] = $param;
					break;
			}
		}
	}


	/**
	 * - getGenericRequest
	 * This method replace the :id string in the request with the right regex.
	 * It also remove the last '/' at the end is present.
	 *	
	 * @access public
	 * @return string regex replacement
	 *
	 */	 
	public function getGenericRequest () {
		$result = preg_replace(self::NUMERIC_PARAM, "/:id/", $this->request);
		$result = preg_replace(self::DASH_STRING_URL_REGEX, '/:string/', $result);
		return rtrim($result, '/');
	}
}



