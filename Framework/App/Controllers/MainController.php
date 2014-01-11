<?php

namespace App\Controllers;
use App\Components\SecureController\SecureController;

// File security
defined('CORE_EXEC') or die('Restricted Access');


/**
 *
 * App Main Controller
 *
 * @author Your name
 *
 */
class MainController extends SecureController {


	/**
	 *
	 * @constant PRIVILEDGE_LEVEL
	 * Use this constant to set the needed priviledge level for the controller
	 *
	 */
	const PRIVILEDGE_LEVEL = SecureController::VISITOR;


	/**
	 *
	 * - index
	 * @access public
	 *
	 */
	public function index () {
		
		// Define extra view parameters
		$this->view->set('title', 'Main Page Title');
		$this->view->set('description', 'This is the meta description');
		$this->view->set('keywords', 'Choose your words wisely');
		
		// Render the view
		$content = $this->view->render('App/Views/Main/index');

		// Use setContent to add the content to your response
		$this->response->setContent($content);
		
		// Use setContentType to set the content type of your response. Optional
		$this->response->setContentType('text/html');

		// Use setCaching to activate the HTTP caching in seconds on the client browser. Optional
		$this->response->setCaching(10);

		// Send the respone
		return $this->response->send();
	}
}









