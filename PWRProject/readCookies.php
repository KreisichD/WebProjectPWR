<html>
<head>
    <meta charset="utf-8" />
    <title>Read Cookies</title>

</head>
<body>
	<p>Cookies saved on server:</p>
	
	<?php
	foreach($_COOKIE as $key => $value)
		print("<p>$key: $value</p>");
	?>

	<a href="/site/index.html">Back to main site</a>
</body>
</html>

