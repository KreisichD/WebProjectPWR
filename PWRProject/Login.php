<?php
$logins = array(
	"piotrek" => "qwerty",
	"damian" => "asd"
	);

$login = $_POST["login"];
$pass = $_POST["pass"];

if (isset($logins[$login]) && $logins[$login] == $pass) {
	session_start();

	$_SESSION["active"] = "xxx";
	$_SESSION["login"] = $login;

	echo 'Logged in!';

	echo '<a href="index.html">back</a>';
}
else {
	session_start();
	session_unset();
	session_destroy();

	echo 'Wrong pass';

	echo '<a href="index.html">back</a>';
}

?>