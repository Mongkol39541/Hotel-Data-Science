<?php
session_start();

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die("กรุณาเข้าสู่ระบบ"); //ถ้าไม่มี session ที่สร้างจากระบบlogin จะถูกนำทางกลับไปหน้าหลัก
}

// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
if(isset($_POST['type'])) {
    // รับข้อมูลจาก POST
    $selectedRoom = $_POST['type'];
    $_SESSION['room_type'] = $selectedRoom;

    echo "room type: " . htmlspecialchars($selectedRoom);
} else {
    // ถ้าไม่มีข้อมูลถูกส่งมา
    echo "room type: Null";
}

echo "<br>";

if(isset($_POST['bed'])) {
    // รับข้อมูลจาก POST
    $selectedBed = $_POST['bed'];
    $_SESSION['bed_type'] = $selectedBed;

    echo "bed type: " . htmlspecialchars($selectedBed);
} else {
    // ถ้าไม่มีข้อมูลถูกส่งมา
    echo "bed type: Null";
}
?>
