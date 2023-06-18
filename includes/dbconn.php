<?php 
    // Database connection - online
    // $servername = "localhost";
    // $username = "ppibdzqe_ppibdzqe";
    // $password = "f(ZYu7pGq2g{";
    // $dbname = "ppibdzqe_post_and_comment";

    // Database connection - local
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "post_and_comment";
    $conn= new mysqli($servername,$username,$password,$dbname);
    if($conn->connect_error){
        die("Connection Failed:". $conn->connect_error);
    }

?>