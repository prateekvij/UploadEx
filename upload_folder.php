<?php
//var_dump($_POST);
//var_dump($_POST['password']);	
session_start();

if (!empty($_POST["password"])){
	//echo "Password Protected<br>";
	$secure=true;
	$password=$_POST["password"];

	//echo $password;
}
else{
	//echo "Unprotected<br>";
	$secure=false;
	$password="";
}

if (!empty($_SESSION['username'])) {
	$uploader=$_SESSION['username'];
	$privacy=$_POST['privacy'];
}
else{
	$uploader="anonymous";
	$privacy="public";
}

date_default_timezone_set('Asia/Kolkata');
$filename=$_POST["foldername"].".rar";
$time=date("Y-m-d G:i:s");
$filetype="rar";
//var_dump($_FILES);
if(sizeof($_FILES) > 0){
	$folderhash=md5(microtime());
	$uploadDir='files/'.$folderhash.'/';
	$fileUploader = new FileUploader($_FILES,$uploadDir);
	//echo "Done Uploading <br> Compressing the folder<br>";
	$error2=shell_exec('"C:\Program Files (x86)\WinRAR\WinRAR.exe" a -ep1 -r "files\\'.$folderhash.'.rar" "files\\'.$folderhash.'\\*"');
	//echo $error2;
	//echo "Done Compression. Doing the Final Step<br>";
	$error3=shell_exec('rm -r "C:\xampp\htdocs\dropbox\files\\'.$folderhash.'"');
	//echo "Done ";
	require 'db_connect.php';
    $sql="INSERT INTO files (filename,filetype,filehash,uploader,privacy,secure,password,time)  VALUES ('".$filename."','".$filetype."','".$folderhash."','".$uploader."','".$privacy."','".$secure."','".$password."','".$time."')";
    if($result=mysqli_query($conn,$sql)){
		echo "Upload Sucess.Please Copy the Following link<br>localhost/dropbox/downloadfile.php?key=".$folderhash;
		///header("Location: user.php");	
	}else{
		//echo mysqli_error($conn);
	}


    require 'db_disconnect.php';
}

class FileUploader{
	public function __construct($uploads,$uploadDir='files/'){
		
		// Split the string containing the list of file paths into an array 
		$paths = explode("###",rtrim($_POST['paths'],"###"));
		
		// Loop through files sent
		
		foreach($uploads as $key => $current)
		{
			// Stores full destination path of file on server
			$this->uploadFile=$uploadDir.rtrim($paths[$key],"/.");
			// Stores containing folder path to check if dir later
			$this->folder = substr($this->uploadFile,0,strrpos($this->uploadFile,"/"));
			
			// Check whether the current entity is an actual file or a folder (With a . for a name)
			if(strlen($current['name'])!=1)
				// Upload current file
				if($this->upload($current,$this->uploadFile)){
					//echo "The file ".$paths[$key]." has been uploadedn\n";
				}
				else 
					echo "Error uploading ".$paths[$key];
		}

	}
	
	private function upload($current,$uploadFile){
		// Checks whether the current file's containing folder exists, if not, it will create it.
		if(!is_dir($this->folder)){
			mkdir($this->folder,0700,true);
		}
		// Moves current file to upload destination
		if(move_uploaded_file($current['tmp_name'],$uploadFile))
			return true;
		else 
			return false;
	}
}
?>