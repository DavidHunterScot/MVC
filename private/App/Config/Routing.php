<?php

/*---------------------------------------
 *	App/Config/Routing.php
 *---------------------------------------*/

use App\Route;
use App\Controller;
use App\FrontController;

Route::get('', function() {
	echo "Welcome visitor!";
});

Route::get('about', function() {
	echo "This is the about page!";
});

Route::get('post', function() {
	?>

	<form method="post">
		<p><button type="submit">Submit</button></p>
	</form>

	<?php
});

Route::post('post', function() {
	echo "<p>POST!</p>";
});

Route::get('test', 'FrontController@test');
