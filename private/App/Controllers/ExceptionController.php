<?php

namespace App;

require_once "../private/App/Controller.php";

class ExceptionController extends Controller {

	public function exception(\Exception $exception) {
		return $this->view('exception', ['exception' => get_class($exception), 'exception_message' => $exception->getMessage()]);
	}

}