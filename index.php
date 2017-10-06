<?php

include 'sess.php';
if (loggedin()) {
	header("Location:user.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script language="JavaScript">
	<!--
	function uploader(){
		//alert("Hello");
		var inputfiles=document.getElementById('folder');//= function(e) {
		if (inputfiles.files.length==0) {
			document.getElementById("folder_key").innerHTML="Please Choose a Folder";
		}else{
		    var files = inputfiles.files; // FileList
		    for (var i = 0, f; f = files[i]; ++i)
		    console.debug(files[i].webkitRelativePath);
			uploadFiles(files);
		}
		
	}


	function testing(){
		alert(document.f1.secure.checked);
	}
	function enable_text(status)
	{
		var password=document.getElementsByName("password");
		status=!status;	
		document.f1.password.disabled = status;
	}
	function enable_folder_text(status)
	{
		var password=document.getElementsByName("folder_password");
		status=!status;	
		document.f2.folder_password.disabled = status;
	}
	function uploadFiles(files){

		var loading = document.createElement("img");
		loading.setAttribute("src", "images/loading.gif");
		//loading.setAttribute("height", "768");
		//loading.setAttribute("width", "1024");
		//loading.setAttribute("alt", "Flower");
		
		var relativePath = files[0].webkitRelativePath;
	    var folder = relativePath.split("/");
	    //alert(folder[0]);

		//alert(document.f1.file_input.value);

		// Create a new HTTP requests, Form data item (data we will send to the server) and an empty string for the file paths.
		xhr = new XMLHttpRequest();
		data = new FormData();
		paths = "";
		var reply=document.getElementById("folder_key");
		//var privacy=document..getElementById("privacy");
		var secure=document.f2.folder_password.disabled;
		secure=!secure;
		if (!secure) {
			password="";
		}else{
			password=document.f2.folder_password.value;

		}
		reply.innerHTML="Sending Request";
		//alert(password);
		// Set how to handle the response text from the server
		xhr.onreadystatechange = function(ev){
			console.debug(xhr.responseText);
			reply.innerHTML=xhr.responseText;
		};
		
		// Loop through the file list
		for (var i in files){
			// Append the current file path to the paths variable (delimited by tripple hash signs - ###)
			paths += files[i].webkitRelativePath+"###";
			// Append current file to our FormData with the index of i
			data.append(i, files[i]);
		};
		// Append the paths variable to our FormData to be sent to the server
		// Currently, As far as I know, HTTP requests do not natively carry the path data
		// So we must add it to the request manually.
		data.append('paths', paths);
		data.append('password',password);
		data.append('foldername',folder[0]);
		//data.append('privacy',privacy);
			
		// Open and send HHTP requests to upload.php
		xhr.open('POST', "upload_folder.php", true);
		xhr.send(this.data);
		reply.innerHTML="Uploading....";
		reply.appendChild(loading);
	}
	//-->
</script>
</head>
<body>

<div class="row" style="margin-left:20px;margin-right:20px;margin-top:0px;background-color:#eeeeee;">
    <div class="col-xs-4"><a href="index.php" style="text-decoration:none"><h1 style="margin-left:20px;margin-top:5px;">UploadEx</h1></a></div>
     <!-- Trigger the modal with a button -->
  <div class="col-xs-4"></div>
  <div class="col-xs-4">
  	<a href="login.php"><button style="margin-top:5px;" type="button" class="btn btn-primary btn-md pull-right" >Login / Register</button></a>

	</div>
	 
		
</div>
<div  style="margin-top:50px">
	<div class="row">
		<div class="col-lg-2"></div>
		<div class="col-lg-4">
			<div class="panel panel-primary">
		      <div class="panel-heading">Upload File</div>
		      <div class="panel-body">
				<form name="f1" method="post" enctype="multipart/form-data">
				    <div class="form-group">
				    	<input type="file" name="fileToUpload" id="fileToUpload">
				    </div>
				    <div class="form-group">
				    	<input name="secure" type="checkbox" onclick="enable_text(this.checked)"> Add Password<br>
				    	<input name="password" disabled="true" type="text" value="" >
				    </div>
				    <div class="form-group">
				    	<button type="submit" name="file_upload" class="btn btn-info">Upload File</button>
				    </div>
				    <div class="form-group">
				    <div id="file_key">
				    	<?php
					    	if (isset($_POST['file_upload'])) {
					    		include 'upload.php';
					    	}
				    	
				    	?>
				    </div>
				    </div>
				    
				    <!--<input type="submit" value="Upload Image" name="submit">-->
				</form>
		      </div>
		    </div>
		</div>
		<div class="col-lg-4">
			<div class="panel panel-primary">
		      <div class="panel-heading">Upload Folder</div>
		      <div class="panel-body">
		      <form name="f2" method="post" enctype="multipart/form-data">
				    <div class="form-group">
				    	<input type="file" name="file_input" id="folder" multiple webkitdirectory="">
				    </div>
				    <div class="form-group">
				    	<input name="folder_secure" type="checkbox" onclick="enable_folder_text(this.checked)"> Add Password<br>
				    	<input name="folder_password" disabled="true" type="text" value="" >
				    </div>
				    <div class="form-group">
				    	<button type="button" name="folder_upload" class="btn btn-info" onclick="uploader();">Upload Folder</button>
				    </div>
				    <div class="form-group">
				    <div id="folder_key">
				    	
				    </div>
				    </div>
				    
				    <!--<input type="submit" value="Upload Image" name="submit">-->
				</form>

		      </div>
		    </div>
		</div>
		<div class="col-lg-2"></div>
	</div>

</div>

</body>
</html>
