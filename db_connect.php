<?php
	$ssid="root";
	$key="";
	$server="localhost";
	$db="dropbox";

	$conn=mysqli_connect($server,$ssid,$key,$db);
	if (!$conn) {
		die("Connection Failed");
	}
	

?>