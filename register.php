
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" type="text/css" href="css/registerStyle.css">
	<script type="text/javascript" src="jquery/jquery-1.9.0.js"></script>


</head>
<body>
		<?php
			require 'db_connect.php';
			$username_e="";
			$password_e="";
			
			$empty="";
			

			$conn1=mysqli_connect($server,$ssid,$key,$db);
			if(!$conn1){
				echo "connection failed";
			}

			if(isset($_POST["register"])){

					if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['name']) && !empty($_POST['repassword'])){
						$username=$_POST['username'];
						$password=$_POST['password'];
						$name=$_POST['name'];
						$repassword=$_POST['repassword'];
						


						$sql1="SELECT * FROM login WHERE username='".$username."'";
						$result1=mysqli_query($conn1,$sql1);
						$numrows=mysqli_num_rows($result1);
						if($numrows==0)
						{
							
							if($password == $repassword)
							{
								
								$sql2="INSERT INTO login (name,username,password) VALUES ('".$name."','".$username."','".$password."')";
								if($result2=mysqli_query($conn1,$sql2)){
									echo "<script>(function(){ alert('Registration Sucess'); })(); </script>";
									header("Location: login.php");	
								}else{
									echo mysqli_error($conn1);
								}

								
								
							}
							else{
								$password_e="Passwords didn't match";
								
							}
						} else {
						
						$username_e="Handle already exist";
						
						}

					} else {
						$empty="All fields are required";
					}
				}
			?>
	<form id="registerForm" method="post" action="">
		<div class="details" id="name_d" name="name_d">
			<label class="heading" id="l_name">Your Name</label>
			<input class="inputs" id="name" name="name"></input>
		</div>
		<div class="details" id="username_d" name="username_d">
			<label class="heading" id="l_username">Username</label>
			<input class="inputs" id="username" name="username"></input>
			<p class="error"id="username_e"><?php echo $username_e; ?></p>
		</div>
		
		<div class="details" id="password_d" name="password_d">
			<label class="heading" id="l_password">Password</label>
			<input type="password"class="inputs" id="password" name="password"></input>
		</div>
		<div class="details" id="repassword_d" name="repassword_d">
			<label class="heading" id="l_repassword">Re-enter Password</label>
			<input type="password"class="inputs" id="repassword" name="repassword"></input>
			<p class="error" id="password_e"><?php echo $password_e; ?></p>
		</div>
		<input type="submit" value="register" name="register" id="register" />
		<br>
		<p id="alert">
		
		<?php				
			echo $empty;			
		?></p>


	</form>
</body>
</html>