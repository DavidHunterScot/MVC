<?php

namespace App;

class FrontController extends Controller {

	public function test() {
		echo $this->view('test', ['message' => 'Hello, world!']);
	}

}