<?php
    session_start();
    if (!isset($_SESSION['id'])){
        header('location:index.php');
    }
    
    $user_id=$_SESSION['id'];
    $member_query = mysqli_query($conn, "SELECT * from user where user_id = '$user_id'") or die("Error failed " . mysqli_error());
    $member_row = mysqli_fetch_array($member_query);
    
    $fullname = $member_row['firstname']." ".$member_row['lastname'];
    $testname = "Test Name";
?>