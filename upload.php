<?php

if (isset($_POST["secure"])){
	//echo "there";
	$secure=true;
	$password=$_POST["password"];
	//echo $password;
}
else{
	//echo "not there";
	$secure=false;
	$password="";
}
//var_dump($_SESSION);
//echo $secure;

if (!empty($_SESSION['username'])) {
	$uploader=$_SESSION['username'];
	$privacy=$_POST['privacy'];
}
else{
	$uploader="anonymous";
	$privacy="public";
}

$target_dir = "files/";

$filehash=md5(microtime());
$filename=$_FILES["fileToUpload"]["name"];
$filetype = pathinfo($filename,PATHINFO_EXTENSION);



$target_file = $target_dir . $filehash.".".$filetype;
$uploadOk = 1;
date_default_timezone_set('Asia/Kolkata');
	
$time=date("Y-m-d G:i:s");


// Check if file already exists
if (file_exists($target_file)) {
    echo "Something went wrong. Please try again";
    $uploadOk = 0;
}
/* Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
*/ // Allow certain file formats

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        //echo "The file ". $filename. " has been uploaded.";
        require 'db_connect.php';
        $sql="INSERT INTO files (filename,filetype,filehash,uploader,privacy,secure,password,time)  VALUES ('".$filename."','".$filetype."','".$filehash."','".$uploader."','".$privacy."','".$secure."','".$password."','".$time."')";
        if($result=mysqli_query($conn,$sql)){
			//echo "Successful Insertion";
			///header("Location: user.php");	
		}else{
			//echo mysqli_error($conn);
		}


        require 'db_disconnect.php';
        echo "<br>Upload Success. Please Copy the Following link<br>localhost/dropbox/downloadfile.php?key=".$filehash;

    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>