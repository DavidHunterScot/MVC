<?php

require_once "../private/App/Core.php";
require_once "../private/App/Controllers/ExceptionController.php";

use \App\ExceptionController;

$core = new App\Core;

$route = isset($_GET['route']) ? $_GET['route'] : '';

try {
	$core->processRoute($_SERVER['REQUEST_METHOD'], $route);
} catch(Exception $ex) {
	$controller = new ExceptionController();
	echo $controller->exception($ex);
}
