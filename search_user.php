<?php
//var_dump($_GET);
$search=$_GET['search'];
echo "Searching ".$search."<br>";
require 'db_connect.php';

$sql1="SELECT * FROM login WHERE username='".$search."'";
$result=mysqli_query($conn,$sql1);
//var_dump($result);
if (!mysqli_num_rows($result)) {
	echo "No result found";
}else{
	echo "Found ";
	while ($extract=mysqli_fetch_array($result)) {
		echo "<a href='profile.php?person=".$extract['username']."'>".$extract['username']."<br>";
	}
}

require 'db_disconnect.php';


?>