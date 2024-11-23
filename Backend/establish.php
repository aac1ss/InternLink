<?php
session_start();
    $db_server = "localhost";
    $db_user = "root";
    $db_pass = "";
    $db_name = "InternLink";
    $conn = mysqli_connect($db_server,$db_user,$db_pass,$db_name);
    if(!$conn)
        echo "Connection Failed";
    else {
        echo "connection established";
    }
     
?>
