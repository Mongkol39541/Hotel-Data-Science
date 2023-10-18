<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <!-- connect to a db -->
    <?php
    $servername = "localhost";
    $username = "root"; //ตามที่กำหนดให้
    $password = ""; //ตามที่กำหนดให้
    $dbname = "9hotel_reservation";    //ตามที่กำหนดให้
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    ?>
    <!-- FIXME: guest table คือเหี้ยไร มันจะไปเกี่ยวกับ member ได้ยังไง -->
    
    <?php
    $guest = 'GUEST105'; //hardcode
    $sql = "SELECT *
    FROM guest g 
    JOIN reservation res
    ON (g.reserve_id = res.reserve_id)
    JOIN room rm
    ON (res.room_id = rm.room_id)
    WHERE guest_id = '$guest';";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)) {
        echo $row['reserve_id'] . '<br>'.
        $row['room_type'] . '<br>'.
        $row['check_in'] . ' ' . $row['check_out'] . '<br>'.
        '<img src="'. $row['room_img'] . 'alt="">';
    }
    ?>
</body>
</html>