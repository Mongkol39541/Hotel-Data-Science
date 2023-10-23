<?php

if($open_connect != 1){
    die(header("location: ../index.php"));
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "9hotel_reservation";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>