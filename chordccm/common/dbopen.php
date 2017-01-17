<?php
	global $mysqli;
	$mysqli = new mysqli($_DB_HOST, $_DB_USER, $_DB_PASSWORD, $_DB_NAME, $_DB_PORT);
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	
	$mysqli->query("set names utf8;") or die($mysqli->error.__LINE__);
	$mysqli->query("set time_zone='+9:00';") or die($mysqli->error.__LINE__);
?>
