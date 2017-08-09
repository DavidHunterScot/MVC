<?php

require_once "../private/App/Core.php";

$core = new App\Core;

$route = isset($_GET['route']) ? $_GET['route'] : '';

try {
	$core->processRoute($_SERVER['REQUEST_METHOD'], $route);
} catch(RouteNotFoundException $ex) {
	echo "Exception: Route Not Found!";
}
