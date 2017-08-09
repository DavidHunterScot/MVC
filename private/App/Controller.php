<?php

namespace App;

class Controller {

	public function view(string $view, array $args = null) {
		// Check if file doesn't exist and throw exception.
		if(!file_exists("../private/App/Views/" . $view . ".view.php"))
			throw new \ViewNotFoundException();

		// Get the contents of the file and save to variable.
		$content = file_get_contents("../private/App/Views/" . $view . ".view.php");

		// Find and match all function tags formated as {! tag_name !}
		if (preg_match_all("/{!(\s?(.*)+\s?)!}/", $content, $m)) {
			// For each template tag found...
    		foreach ($m[1] as $i => $tag_name) {
    			// Trim the tag name
    			$tag_name = trim($tag_name);

    			// Explode it into an array using spaces as separators.
    			$tag = explode(' ', $tag_name);

    			// Check if 2 elements exist.
    			if(count($tag) == 2) {
    				// Assume the first element is the requested function.
	    			// Check if it is the "extends" function and the second is a valid view path.
	    			if($tag[0] == "extends") {
	    				if(file_exists('../private/App/Views/' . $tag[1] . '.view.php')) {
		    				// Remove the function tag as it has done its job and doesn't need to appear on the page.
		    				$content = str_replace($m[0][$i], "", $content);

		    				// Add on the content of our view as an arg for the base view.
		    				$args['view_content'] = $content;

		    				// Surround the content with the base view's content.
		    				$content = $this->view($tag[1], $args);
		    			} else {
		    				throw new \App\Exception\ViewNotFoundException($tag[1]);
		    			}
	    			}
    			}
    		}
    	}

    	// Find and match all template tags formated as {{ tag_name }}
		if (preg_match_all("/{{(\s?[a-zA-Z0-9\_]+\s?)}}/", $content, $m)) {
			// For each template tag found...
    		foreach ($m[1] as $i => $tag_name) {
    			// Trim the tag name
    			$tag_name = trim($tag_name);

    			// Check if it exists in the args array and replace it with its content.
    			if(array_key_exists($tag_name, $args))
	    			$content = str_replace($m[0][$i], $args[$tag_name], $content);
	    		// Check if the tag is a function, evaluate it as a PHP function, and replace it with the returned value.
	    		else if(function_exists($tag_name))
	    			$content = str_replace($m[0][$i], eval('return ' . $tag_name . '();'), $content);
    		}
    	}

    	// Return the content.
    	return $content;
	}

}
