<?php
include_once 'DBH.php';

$query = "SELECT E_mail, UsrPass FROM sysusers";

if (!$conn)
    die("<p>DB error</p>");

if (!$result = mysqli_query($conn, $query))
    die("<p>Query error</p>");


$logins = array(
	"piotrek" => "qwerty",
	"damian" => "asd"
	);

while ($row = mysqli_fetch_row($result)) {
    $logins[$row[0]] = $row[1];
}

mysqli_close($conn);

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