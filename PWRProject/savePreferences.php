<?php
define("MINUTE", 60);

setcookie("background", $_POST["background"], time() + MINUTE);
setcookie("font", $_POST["font"], time() + MINUTE);

?>
<html>
<head>
	<meta charset="utf-8" />
	<title>Cookie saved</title>
</head>
<body>
	<p>Preferences saved ;) Will be in use for one minute</p>

	<a href="AboutUs.html">Back</a>
</body>
</html>