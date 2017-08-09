<?php

namespace App;

class Controller {

	public function view(string $view, array $args = null) {
		// Check if file doesn't exist and throw exception.
		if(!file_exists("../private/App/Views/" . $view . ".view.php"))
			throw new \ViewNotFoundException();

		// Get the contents of the file and save to variable.
		$content = file_get_contents("../private/App/Views/" . $view . ".view.php");

		// Find and match all template tags formated as {{ tag_name }}
		if (preg_match_all("/{{(\s?[a-zA-Z0-9\(\)]+\s?)}}/", $content, $m)) {
			// For each template tag found...
    		foreach ($m[1] as $i => $tag_name) {
    			// Trim the tag name
    			$tag_name = trim($tag_name);

    			// Check if it exists in the args array and replace it with its content.
    			if(array_key_exists($tag_name, $args))
	    			$content = str_replace($m[0][$i], $args[$tag_name], $content);
	    		else if(function_exists($tag_name))
	    			$content = str_replace($m[0][$i], $tag_name, $content);
    		}
    	}

    	// Return the content.
    	return $content;
	}

}
