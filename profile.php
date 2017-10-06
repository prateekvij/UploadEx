<?php
  $person=$_GET['person'];
  //echo $person."<br>";
  require 'db_connect.php';
  require 'sess.php';
  if (loggedin()) {
    $user=$_SESSION['username'];
  }
  else{
    $user="";
  }
  $status="";

  $friend=false;

  $sql1="SELECT * FROM contacts WHERE user='".$user."' AND friend='".$person."'";
  $result1=mysqli_query($conn,$sql1);
  if (!mysqli_num_rows($result1)) {
    $status="<a ><button type='button' class='btn btn-info btn-md pull-right' style='margin-top:-37px;'id='send_request' onclick='sendRequest()'>Send Request</button></a>";
  }else{
    $extract1=mysqli_fetch_array($result1);
    if ($extract1['status']=="sent") {
      $status="Friend Request Sent";
    }
    else if ($extract1['status']=="received") {
      $status="Pending Friend Request<br><button>Accept</button> <button>Reject</button>";
    }
    else{
      $status="Friends";
      $friend=true;
    }
  }
  
  //echo $status;
  
  
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
  <script type="text/javascript">
    function generateURL(url){
    alert('localhost/dropbox/downloadfile.php?key='+url);
  }
    function sendRequest(){
    
    var from=<?php echo "'".$user."'"; ?>;
    var to=<?php echo "'".$person."'"; ?>;

    var xmlhttp=new XMLHttpRequest();
    var response="";
    
    
    xmlhttp.onreadystatechange=function(){
      if (xmlhttp.readyState==4 && xmlhttp.status==200) {
        var response=xmlhttp.responseText;
        //alert(response);
        location.reload();
        //window[response](string);

        
      }
    }
    xmlhttp.open('POST','send_request.php',true);
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send('to='+to+'&from='+from);      
    

      
  }
  </script>
</head>
<body>

  <div class="row" style="margin-left:20px;margin-right:20px;margin-top:0px;background-color:#eeeeee;">
      <div class="col-xs-4"><a style="text-decoration:none;" href="index.php"><h1 style="margin-left:20px;margin-top:5px;">UploadEx</h1></a></div>
       <!-- Trigger the modal with a button -->
    <div class="col-xs-4"></div>
  	
  </div>

<div class="row" style="margin-left:20px;margin-right:20px;margin-top:10px;">
	<div class="col-lg-6"><h2><?php echo $person; ?></h2> <!--<button type="button" class="btn btn-info btn-md pull-right" style="margin-top:-37px;">--><div><?php echo $status; ?></div></div>

</div>
<div class="container row" style="margin-left:5px;margin-top:20px;">


<div class="col-xs-4">
	<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#public">Public</a></li>
  <li><a data-toggle="tab" href="#friends">Shared with friends</a></li>
</ul>

<div class="tab-content">
  <div id="public" class="tab-pane fade in active">
    <h3>Public</h3>
    <?php
    $sql2="SELECT * FROM files WHERE uploader='".$person."' AND privacy='public'";
    $result2=mysqli_query($conn,$sql2);
    if (!mysqli_num_rows($result2)) {
      echo "No files to display";
     }
     else{
      while ($extract2=mysqli_fetch_array($result2)) {
        $filehash=$extract2["filehash"];
        $filename=$extract2["filename"];
        echo '<div class="panel panel-default"><div class="panel-body">'.$filename.'<a href="downloadfile.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Download</button></a><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" onclick="generateURL(\''.$filehash.'\');" >URL</button></div></div>';
            }
      
     }

    ?>

  </div>
  <div id="friends" class="tab-pane fade">
    <h3>Friends</h3>
    <?php
      if ($friend) {
        
        $sql3="SELECT * FROM files WHERE uploader='".$person."' AND privacy='friends'";
        $result3=mysqli_query($conn,$sql3);
        if (!mysqli_num_rows($result3)) {
          echo "No files to display";
         }
         else{
          while ($extract3=mysqli_fetch_array($result3)) {
            $filehash=$extract3["filehash"];
            $filename=$extract3["filename"];
            echo '<div class="panel panel-default"><div class="panel-body">'.$filename.'<a href="downloadfile.php?key='.$filehash.'"><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" >Download</button></a><button  type="button" class="btn btn-primary btn-md pull-right" style="margin-left:1px" onclick="generateURL(\''.$filehash.'\');" >URL</button></div></div>';
          }
      
     
        } 
      }
      else{
        echo "To view what he shares with friends, send him a Friend request";  
      }
    ?>
  </div>
</div>
</div>

<div class="col-xs-4"></div>
</div>



</body>
</html>