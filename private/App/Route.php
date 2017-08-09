<?php

namespace App;

class Route {

	private static $get = [];
	private static $post = [];

	public static function get(string $path, $action) {
		if(!array_key_exists($path, Route::$get)) {
			Route::$get[$path] = $action;
			return true;
		}
		return false;
	}

	public static function post(string $path, $action) {
		if(!array_key_exists($path, Route::$post)) {
			Route::$post[$path] = $action;
			return true;
		}
		return false;
	}

	public static function route(string $method, string $path) {
		if(strtolower($method) == "get" && array_key_exists($path, Route::$get)) {
			return Route::$get[$path];
		} else if(strtolower($method) == "post" && array_key_exists($path, Route::$post)) {
			return Route::$post[$path];
		}
		return false;
	}

}