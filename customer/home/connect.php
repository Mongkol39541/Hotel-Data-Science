<!-- เชื่อมต่อฐานข้อมูล MySQLi Procedural -->
<!-- In process : ยังไม่ได้ใช้ server สำหรับส่งงานจริง -->

<?php

if($open_connect != 1){
    die(header("location: index.php")); //ป้องกันการเข้าถึงไฟล์
}

// กำหนด parameters สำหรับเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
// $dbname = "9hotel_reservation";
$dbname = "myproject";

// Create & Check connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>