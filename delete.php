<?php
	require 'sess.php';
	require 'db_connect.php';
	$allowed=0;
	if (!loggedin()) {
		$user="";
	}
	else{
		$user=$_SESSION["username"];
	}
	if (empty($_GET["key"])) {
		die();
	}
	$filehash=$_GET["key"];
	require 'db_connect.php';
	$sql1="SELECT * FROM files WHERE filehash='".$filehash."'";
	$result=mysqli_query($conn,$sql1);
	if (!mysqli_num_rows($result)) {
		echo "File no longer Exist";
		die();
	}else{
		$extract=mysqli_fetch_array($result);
		$uploader=$extract["uploader"];
		$filetype=$extract["filetype"];
		if ($user==$uploader) {
			$error3=shell_exec('rm "C:\xampp\htdocs\dropbox\files\\'.$filehash.'.'.$filetype.'"');
			$sql2 = "DELETE FROM files WHERE filehash='".$filehash."'";

			if (mysqli_query($conn, $sql2)) {
			    echo "File deleted successfully";
			    header("Location:index.php");
			} else {
			    echo "Error deleting record: " . mysqli_error($conn);
			}			
		}
		else{
			die('Access Denied');
		}
	}	

	require 'db_disconnect.php';
?>