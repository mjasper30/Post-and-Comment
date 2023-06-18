<?php
	include('dbconn.php');
	session_start();
	$username = $_POST['username'];
	$password = $_POST['password'];

	$query = mysqli_query($conn,"SELECT * FROM user WHERE username='$username' AND password='$password'")or die(mysqli_error());
	$count = mysqli_num_rows($query);
	$row = mysqli_fetch_array($query);

    if ($count > 0){
        $_SESSION['id']=$row['user_id'];
    	echo 'true';
	}else{
	   	echo 'false';
	}	
?>