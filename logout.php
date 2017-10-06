<?php
	session_start();
	//Unset the variables stored in session
	unset($_SESSION['username']);
	unset($_SESSION['name']);
	session_destroy();
	//redirect to login page
	header('Location:index.php?msg=logout');

	?>