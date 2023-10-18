<?php
// test.php
session_start();

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die("กรุณาเข้าสู่ระบบ"); //ถ้าไม่มี session ที่สร้างจากระบบlogin จะถูกนำทางกลับไปหน้าหลัก
}

echo "หน้าสร้างรายการจองของเทพกุจัง<br>";

// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
if(isset($_GET['type'])) {
    // รับข้อมูลจาก POST
    $selectedRoom = $_GET['type'];

    echo "room type: " . htmlspecialchars($selectedRoom);
} else {
    // ถ้าไม่มีข้อมูลถูกส่งมา
    echo "room type: Null";
}

echo "<br>";

if(isset($_GET['bed'])) {
    // รับข้อมูลจาก POST
    $selectedBed = $_GET['bed'];

    echo "bed type: " . htmlspecialchars($selectedBed);
} else {
    // ถ้าไม่มีข้อมูลถูกส่งมา
    echo "bed type: Null";
}
?>
