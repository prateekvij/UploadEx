<?php
session_start();
if (empty($_GET["key"])) {
	header("Location:index.php");
}
$filehash=$_GET["key"];
require 'db_connect.php';
$sql="SELECT * FROM files WHERE filehash='".$filehash."'";
$result=mysqli_query($conn,$sql);
if (!mysqli_num_rows($result)) {
	echo "No such file found";
}else{
	$extract=mysqli_fetch_array($result);
	$privacy=$extract["privacy"];
	$uploader=$extract["uploader"];
	$filetype=$extract["filetype"];
	$filename=$extract["filename"];
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
		if ($friend) {
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
		header("Location:index.php");
	}
	require 'db_disconnect.php';
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Login Form</title>
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
  	<script src="js/jquery.min.js"></script>
  	<script src="js/bootstrap.min.js"></script>
	

</head>
<body>
<div class="row" style="margin-left:20px;margin-right:20px;margin-top:0px;background-color:#eeeeee;">
    <div class="col-xs-4"><a style="text-decoration:none;" href="index.php"><h1 style="margin-left:20px;margin-top:5px;">UploadEx</h1></a></div>
     <!-- Trigger the modal with a button -->
  <div class="col-xs-4"></div>
	
</div>
<div id="">
	<div class="panel panel-primary"style="position:absolute;top:10vh;left:35vw;padding:5px;width:30vw">
		<div class="panel-heading">Password-Protection</div>
			<div class="panel-body">
				<form  id="authentication" method="POST">
					<div class="form-group">
				    	<input type="password" name="password" placeholder="Enter Password" id="password"></input> 
				    </div>
					<div class="form-group">
						<button class="btn btn-primary" type="submit" id="authenticate" value="Authenicate" name="authenticate">Authenticate</button>
					</div>
					
					<b>
					<p id="notify">
					<?php
					
					if(isset($_POST["authenticate"])){
						require 'db_connect.php';

						if(!empty($_POST['password'])) {
							
							$password=$_POST['password'];

							$sql1="SELECT * FROM files WHERE filehash='".$filehash."' ";
							$result1=mysqli_query($conn,$sql1);
							$numrows1=mysqli_num_rows($result1);
							if($numrows1!=0)
							{
								$extract1=mysqli_fetch_array($result1);
								if ($password==$extract["password"]) {
									$file_url = 'http://localhost/dropbox/files/'.$filehash.".".$filetype;
									header('Content-Type: application/octet-stream');
									header("Content-Transfer-Encoding: Binary"); 
									header("Content-disposition: attachment; filename=\"" .$filename. "\""); 
									readfile($file_url);
									header("Location:index.php");
								}
								else{
									echo "INVALID PASSWORD";
								}
								
							} else {
							
								echo "Invalid Key";
							}

						} else {
							echo "Enter a password";
						}
					}
				?></p>
				</form>
			</div>
		</div>
	</div>
		
	
</div>
</body>
</html>