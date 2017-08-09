<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Exception: {{ exception }}</title>

	<link rel="stylesheet" type="text/css" href="https://assets.personaclix.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>

	<div class="jumbotron">
		<div class="container">
			<h2 class="text-danger">An Exception was Caught</h2>
			<p><b>Exception:</b> {{ exception }}</p>
			<p><b>Message:</b> {{ exception_message }}</p>
		</div>
	</div>

</body>
</html>