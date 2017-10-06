<?php
	$from=$_POST['from'];
	$to=$_POST['to'];
	echo $from.$to;
	require 'db_connect.php';
	
	$sql1="INSERT INTO notification (user,person,type,reply,seen) VALUES ('$to','$from','request','waiting','0')";
	$sql2="INSERT INTO contacts (user,friend,status) VALUES ('$from','$to','sent')";
	$sql3="INSERT INTO contacts (user,friend,status) VALUES ('$to','$from','received')";

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
	$result3=mysqli_query($conn,$sql3);
	if ($result3) {
		echo "sucess";
	}
	else{
		echo mysqli_error($conn);
	}
	require 'db_disconnect.php';


?>