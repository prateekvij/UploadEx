<?php
	function is_session_started()
	{
	    if ( php_sapi_name() !== 'cli' ) {
	        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
	            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
	        } else {
	            return session_id() === '' ? FALSE : TRUE;
	        }
	    }
	    return FALSE;
	}
	if ( is_session_started() === FALSE ) session_start();
	require 'db_connect.php';
	if (empty($_SESSION["username"])) {
		die('You have been logged out');
	}

	$user=$_SESSION["username"];
	$sql="SELECT * FROM notification WHERE user='$user' AND seen='0'";
	$result=mysqli_query($conn,$sql);
	if (mysqli_num_rows($result)) {
		echo "<b><h3>Friend Request Recieved</h3></b>";
		while ($extract=mysqli_fetch_array($result)) {
			$person=$extract["person"];
			echo "<a href='profile.php?person=$person' style='text-decoration:none'><h4>$person<h4></a>";
			echo "<a href='accept.php?person=$person'><button class='btn btn-primary'>Accept</button></a>";
			echo "<a href='decline.php?person=$person'><button class='btn btn-primary'>Deny</button></a>";

			
		}
	}

	require 'db_disconnect.php';
?>