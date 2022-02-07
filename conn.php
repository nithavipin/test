<?php

include __DIR__.'/config.php';



$conn = new mysqli($global_servername, $global_username, $global_password, $global_dbname );
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else{
//    echo "connection successful";
}





?>