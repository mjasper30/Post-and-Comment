<?php 
	include('dbconn.php');
	$username = $_POST['username'];
	$password = $_POST['password'];
	$firstname = $_POST ['firstname'];
	$lastname = $_POST ['lastname'];
				
	mysqli_query($conn,"insert into user (username, password, firstname, lastname) values ('$username', '$password', '$firstname', '$lastname')");
?>

<script>
	alert('Successfully Signed Up! You can now Log in your Account');
	window.location = 'index.php';
</script>