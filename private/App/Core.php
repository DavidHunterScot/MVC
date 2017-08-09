<?php

namespace App;

require_once "../private/App/Route.php";
require_once "../private/App/Controller.php";
require_once "../private/App/Config/Routing.php";
require_once "../private/App/Exception/RouteNotFoundException.php";
require_once "../private/App/Exception/ViewNotFoundException.php";

class Core {

	public function processRoute(string $method, string $route) {
		// Get callable action if exists.
		$action = Route::route($method, $route);

		// Check if valid callable action.
		if(is_callable($action)) {
			call_user_func($action);
		} else if(is_string($action) && strpos($action, '@')) {
			// Assume to be controller and action.

			// Split them up so we know which is which.
			$action = explode('@', $action);

			// Pick out the controller as the first part.
			$controller = $action[0];

			// The action method to call as the second part.
			$method = $action[1];

			// Any extra elements are not needed and can be discarded.

			// Check if the controller does not have "Controller" on the end.
			if(!substr($controller, -10) == "Controller") {
				// It doesn't, so append it.
				$controller += "Controller";
			}

			// Check if a valid controller file is missing and throw exception.
			if(!file_exists("../private/App/Controllers/" . $controller . ".php")) {
				throw new \App\Exception\MissingControllerException($controller);
			}

			// Require in the controller class file.
			require_once "../private/App/Controllers/" . $controller . ".php";

			// Prefix $controller with namespace.
			$controller = "\\App\\" . $controller;

			// Reuse $controller variable and create instance of controller class.
			$controller = new $controller();

			// Check if the action method is missing from the controller class and throw exception.
			if(!method_exists($controller, $method)) {
				throw new \App\Exception\MissingControllerMethodException($method);
			}

			// Call action method.
			call_user_func([$controller, $method]);
		} else {
			throw new \App\Exception\RouteNotFoundException();
		}
	}

}