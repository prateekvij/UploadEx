<?php
	
	$friend=false;
	$query="SELECT * FROM contacts WHERE user='".$user."' AND friend='".$uploader."' AND status='yes'";
	$result=mysqli_query($conn,$query);
	if (mysqli_num_rows($result)) {
		$friend=true;
	}
	$query="SELECT * FROM contacts WHERE user='".$uploader."' AND friend='".$user."' AND status='yes'";
	$result=mysqli_query($conn,$query);
	if (mysqli_num_rows($result)) {
		$friend=true;
	}

?>