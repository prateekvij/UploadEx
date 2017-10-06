<?php
	session_start();
	$allowed=0;
	$filehash=$_GET["key"];
	if (empty($_GET["key"])) {
		header("Location:index.php");
	}
	require 'db_connect.php';
	$sql1="SELECT * FROM files WHERE filehash='".$filehash."'";
	$result=mysqli_query($conn,$sql1);
	if (!mysqli_num_rows($result)) {
		echo "No such file found";
	}else{
		$extract=mysqli_fetch_array($result);
		$privacy=$extract["privacy"];
		$uploader=$extract["uploader"];
		$secure=$extract["secure"];
		$filename=$extract["filename"];
		if($secure){
			echo "PASSWORD PROTECTED";
			header("Location:securedownload.php?key=".$filehash."");
		}
		$filetype=$extract["filetype"];
		if ($privacy=="public") {
			$allowed=1;
		}
		else if ($privacy="private") {
			if ($uploader==$_SESSION["username"]) {
				$allowed=1;
			}
			
		}
		else if ($privacy=="friends") {
			require 'match_friend.php';
			if ($friend ) {
				$allowed=1;
			}
		}
		
		else{

		}
		if($uploader==$_SESSION["username"]){
			$allowed=1;
		}
		if (!$allowed) {
			echo "Acess Denied";
		}
		else{

			$file_url = 'http://localhost/dropbox/files/'.$filehash.".".$filetype;
			header('Content-Type: application/octet-stream');
			header("Content-Transfer-Encoding: Binary"); 
			header("Content-disposition: attachment; filename=\"" .$filename. "\""); 
			readfile($file_url);
			
		}




	}
?>