<?php

include 'sess.php';
if (!loggedin()) {
	header("Location:index.php");
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
	function autoRefresh_div()
	 {
	    $("#notifications").load("notification.php");// a function which will load data from other file after x seconds
	  }
 
  setInterval('autoRefresh_div()', 5000); // refresh div after 5 secs

	function search(){
		var results=document.getElementById("results");
		var search=document.getElementById("query").value;
		if (search=="" || search==null) {
			results.innerHTML="Input empty!!!";
		}
		else{
			var loading = document.createElement("img");
			loading.setAttribute("src", "images/loading.gif");
			results.innerHTML="Searching...";
			results.appendChild(loading);

			var xmlhttp=new XMLHttpRequest();
			xmlhttp.onreadystatechange=function(){
				if (xmlhttp.readyState==4 &&xmlhttp.status==200) {
					var reply=xmlhttp.responseText;
					results.innerHTML=reply;
				};

			}
			xmlhttp.open("GET","search_user.php?search="+search,true);
			xmlhttp.send();
		}
			
	}
	function generateURL(url){
		alert('localhost/dropbox/downloadfile.php?key='+url);
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
		privacy=document.f2.folder_privacy.value;
		
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
		data.append('privacy',privacy);
			
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
    <div class="col-xs-4"><a href="index.php" style="text-decoration:none"><h1 style="margin-left:20px;margin-top:5px;">UploadEx</h1></a> </div>
     <!-- Trigger the modal with a button -->
  <div class="col-xs-4"></div>
  <div class="col-xs-4">
  	
  	<a href="logout.php"><button style="margin:5px;" type="button" class="btn btn-primary btn-md pull-right" >Logout</button></a>
  	<button style="margin:5px;" type="button" class="btn btn-primary btn-md pull-right" data-toggle="modal" data-target="#contactModel" >View Contacts</button>
	</div>
	<div class="modal fade" id="contactModel" role="dialog">
	    <div class="modal-dialog">
	    
	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Contacts</h4>
	        </div>
	        <div class="modal-body">
	        <?php
	        	$user=$_SESSION["username"];
	        	require 'db_connect.php';
	        	$sqli="SELECT * FROM contacts WHERE user='$user' AND status='yes' ";
	        	$resulti=mysqli_query($conn,$sqli);
	        	if(!mysqli_num_rows($resulti)) {
	        		echo "No Friends to Show";
	        	}
	        	else{
	        		while ($extracti=mysqli_fetch_array($resulti)) {
	        			$friend=$extracti["friend"];
	        			echo "<a href='profile.php?person=$friend'>$friend</a>";
	        		}
	        	}

	        	require 'db_disconnect.php';
	        ?>
	        
	        </div>
	      </div>
	      
	    </div>
	</div>
	 
</div>
<div class="container" style="margin-top:50px">
	<div class="row">
		<div class="col-lg-8">
			<div class="row">
				<div class="col-lg-6">
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
						    	<select  name="privacy" id="privacy">
								    <option value="public">Public</option>
								    <option value="friends">Friends</option>
								    <option value="private">Private</option>
							    </select>
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
				<div class="col-lg-6">
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
						    	<select  name="folder_privacy" id="folder_privacy">
								    <option value="public">Public</option>
								    <option value="friends">Friends</option>
								    <option value="private">Private</option>
							    </select>
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
			</div>
			<div class="row">
				<div class="col-lg-12" >
					<ul class="nav nav-tabs">
					  <li class="active"><a data-toggle="tab" href="#public">Public</a></li>
					  <li><a data-toggle="tab" href="#friends">Friends</a></li>
					  <li><a data-toggle="tab" href="#private">Private</a></li>
					  
					</ul>

					<div class="tab-content">
					  <div id="public" class="tab-pane fade in active">
					    <h3>Public</h3>
						<?php
						require 'db_connect.php';
						$sql1="SELECT * FROM files WHERE uploader='".$_SESSION['username']."' AND privacy='public'";
						$result1=mysqli_query($conn,$sql1);
						while ($extract1=mysqli_fetch_array($result1)) {
							$filehash=$extract1["filehash"];
							$filename=$extract1["filename"];
							echo '<div class="panel panel-default"><div class="panel-body">'.$filename.'<a href="delete.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Delete</button></a><a href="downloadfile.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Download</button></a><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" onclick="generateURL(\''.$filehash.'\');" >URL</button></div></div>';
						}

						?>				    
					  </div>
					  <div id="friends" class="tab-pane fade">
					    <h3>Friends</h3>
						<?php
						$sql2="SELECT * FROM files WHERE uploader='".$_SESSION['username']."' AND privacy='friends'";
						$result2=mysqli_query($conn,$sql2);
						while ($extract2=mysqli_fetch_array($result2)) {
							$filehash=$extract2["filehash"];
							$filename=$extract2["filename"];
							echo '<div class="panel panel-default"><div class="panel-body">'.$filename.'<a href="delete.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Delete</button></a><a href="downloadfile.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Download</button></a><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" onclick="generateURL(\''.$filehash.'\');" >URL</button></div></div>';
						}

						?>				    
					  </div>
					  <div id="private" class="tab-pane fade">
					    <h3>Private</h3>
						<?php
						$sql3="SELECT * FROM files WHERE uploader='".$_SESSION['username']."' AND privacy='private'";
						$result3=mysqli_query($conn,$sql3);
						while ($extract3=mysqli_fetch_array($result3)) {
							$filehash=$extract3["filehash"];
							$filename=$extract3["filename"];
							echo '<div class="panel panel-default"><div class="panel-body">'.$filename.'<a href="delete.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Delete</button></a><a href="downloadfile.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Download</button></a><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" onclick="generateURL(\''.$filehash.'\');" >URL</button></div></div>';
						}

						?>				    
					  </div>
					  
					</div>		
				</div>
			</div>
		</div>
		<div class="col-lg-4">

			<div id="notifications" style="padding-bottom:10px">
				<?php
					include 'notification.php';
				?>
			</div>
			<div id="search">
				<div class="panel panel-default">
				  <div class="panel-body">
				  	<h4>Search a Friend..</h4>
				  	<div class="form-group">
					  <input name="query" id="query"type="text" class="form-control" ><br>
					  <button class="btn btn-primary" type="button" onclick="search()">Search</button>
					</div>
					<div id="results"></div>
				  </div>
				</div>
				
			</div>
		</div>
	</div>

</div>

</body>
</html>
