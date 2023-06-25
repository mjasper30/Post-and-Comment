<?php
    session_start();
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['id'])) {
      echo "Access denied. Please log in.";
      header("Location: index.php");
      exit;
    }
    
    $user_id=$_SESSION['id'];
    $member_query = mysqli_query($conn, "SELECT * from user where user_id = '$user_id'");
    $member_row = mysqli_fetch_array($member_query);
    
    $fullname = $member_row['firstname']." ".$member_row['lastname'];
?>