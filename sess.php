<?php

session_start();

function loggedin(){
	if (!empty($_SESSION['username'])) {
		$user=$_SESSION["username"];
		return true;
	}
	else{
		return false;
	}
}




?>