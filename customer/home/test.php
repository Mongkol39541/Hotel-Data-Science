<?php
// test.php

// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
if(isset($_GET['type'])) {
    // รับข้อมูลจาก POST
    $selectedRoom = $_GET['type'];

    echo "room type: " . htmlspecialchars($selectedRoom);
} else {
    // ถ้าไม่มีข้อมูลถูกส่งมา
    echo "room type: Null";
}
?>
