<?php
	require 'sess.php';
	require 'db_connect.php';
	if (!loggedin()) {
		die();
	}
	$user=$_SESSION["username"];
	$person=$_GET["person"];
	$sql1 = "UPDATE notification SET seen='1',reply='accepted' WHERE ( person='$person' AND user='$user' )";
	$sql2 = "UPDATE contacts SET status='yes' WHERE (user='".$user."' AND friend ='".$person."') OR (user='$person' AND friend='$user')";

	$result1=mysqli_query($conn,$sql1);
	if ($result1) {
		echo "sucess";
	}
	else{
		echo mysqli_error($conn);
	}
	
	$result2=mysqli_query($conn,$sql2);
	if ($result2) {
		echo "sucess";
	}
	else{
		echo mysqli_error($conn);
	}
	
	require 'db_disconnect.php';
	header("Location:index.php");
?>