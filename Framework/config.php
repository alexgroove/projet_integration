<?php

defined('CORE_EXEC') or die('Restricted Access');

/**
 *
 * Core Framework
 * - config.php
 *
 * Configuration file
 *
 */ 


/**
 *
 * ENVIRONMENT
 *
 */
define('DEVELOPMENT', 'development');
define('PRODUCTION', 'production');
define('TEST_PRODUCTION', 'test_production');
define('ENVIRONMENT', TEST_PRODUCTION);



/**
 *
 * Database setup
 *
 */
define('HOST', 'localhost');
define('USER', 'root');
define('PASSWORD', 'root');
define('DATABASE', 'NAME_OF_YOUR_DATABASE');



/**
 *
 * ENVIRONMENT setup
 *
 */
switch (ENVIRONMENT) {

	case DEVELOPMENT : 
	case TEST_PRODUCTION : 
		spl_autoload_register(function ($class) {
			require_once str_replace('\\', '/', $class).'.php';
		});	
		error_reporting(0);
		set_exception_handler('core_exception_handler');
		set_error_handler('core_error_handler');
		register_shutdown_function(function () {
			if ($error = error_get_last()) {
				call_user_func_array('core_error_handler', $error);
			}
		});
		libxml_use_internal_errors(true);
	break;	

	case PRODUCTION : 
	default: 
		spl_autoload_register(function ($class) {
			@require_once str_replace('\\', '/', $class).'.php';
		});	
		error_reporting(0);
		set_exception_handler(function () {});
		set_error_handler(function () {});
		libxml_use_internal_errors(false);

	break;
}


/**
 *
 * core_exception_handler
 * Default Exception handler
 *
 *
 */
function core_exception_handler (Exception $exception) {
	$msg = "<div style='border: 3px double black; padding: 10px; margin: 25px; font-family: Courier; font-size: 12px;'>";
	$msg .= "<span><strong style='text-decoration: underline;'>Exception</strong></span>";
	$msg .= '<p><strong style=\'color: red; \'>Message</strong>: <strong>'.$exception->getMessage().'</strong><br/>';
	$msg .= 'Code: '.$exception->getCode().'<br/>';
	$msg .= 'File: '.$exception->getFile().'<br/>';
	$msg .= 'Line: '.$exception->getLine().'<br/>';
	$msg .= '</p>';
	$msg .= '</div>';
	echo $msg;
}


/**
 *
 * core_error_handler
 * Default Exception handler
 *
 *
 */
function core_error_handler ($errno, $errstr, $errfile, $errline) {
	$showError = true;
	switch($errno) {
		// Show errors
		case E_ERROR : $error_name = 'Error'; break;
		case E_WARNING : $error_name = 'Warning '; break;
		case E_PARSE : $error_name = 'Parse error'; break;
		case E_NOTICE : $error_name = 'Notice'; break;

		// Hide errors
		default : $showError = true; $error_name = 'Error'; break;

	}
	if (!$showError) {
		return true;
	}
	$msg = "<div style='border: 3px solid red; padding: 10px; margin: 25px; font-family: Courier; font-size: 12px;'>";
	$msg .= "<span><strong style='text-decoration: underline;'>Error</strong></span>";
	$msg .= '<p><strong style=\'color: red; \'>Message</strong>: <strong>'.$errstr.'</strong><br/>';
	$msg .= 'Name: '.$error_name.'<br/>';
	$msg .= 'File: '.$errfile.'<br/>';
	$msg .= 'Line: '.$errline.'<br/>';
	$msg .= '</p>';
	$msg .= '</div>';
	echo $msg;
}









