<?php
if(!isset($_COOKIE['background'])) {
	echo "<body>";
} else {
	$color = $_COOKIE['background'];
	echo "<body style=\"background-color: $color;\">";
}
?>