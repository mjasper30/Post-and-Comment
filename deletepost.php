<?php
    include('dbconn.php');
    $id = $_GET['id'];
    
    // Retrieve the image file path from the database or wherever it is stored
    $result = mysqli_query($conn, "SELECT picture FROM post WHERE post_id='$id'");
    $row = mysqli_fetch_assoc($result);
    $imagePath = 'images/' . $row['picture'];
    
    // Delete the image file if it exists
    if (file_exists($imagePath)) {
        unlink($imagePath);
        // Delete the record from the 'post' table
        mysqli_query($conn, "DELETE FROM post WHERE post_id='$id'");
        
        header('location: home.php');
    }else{
        echo "Image not found in the folder";
    }
    
    
?>