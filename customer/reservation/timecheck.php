<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
</head>
<body>
    <!-- connect to a server -->
    <!-- TODO: connect to the uni's server instead of the local -->
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "9hotel_reservation";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    ?>
    <?php
    //gather all the room and reservation information
    $room = $_POST['room'];
    $roomexplode = explode('|', $room);
    $roomtype = $roomexplode[0];
    $bedtype = $roomexplode[1];
    $date = $_POST['datefilter'];
    $date_explode = explode('-', $date);
    $date_check_in = $date_explode[0];
    $date_check_out = $date_explode[1];
    ?>
    <!-- finding occupied -->
    <?php
    //FIXME: fix the fucking table please, kuy
    //add bed_type in reservation
    //fix sample check_in, check_out date
    $sql = "SELECT *
    FROM
        (SELECT res.room_id
        FROM reservation res 
        JOIN room r ON res.room_id = r.room_id
        WHERE r.room_type = '$roomtype' AND r.bed_type = '$bedtype'
        AND ((check_in BETWEEN '$checkin' AND '$checkout')
        OR (check_out BETWEEN '$checkin' AND '$checkout')
        OR (check_in <= '$checkin' AND check_out >= '$checkout'))) occ
    RIGHT JOIN
        (SELECT room_id
        FROM room
        WHERE room_type = '$roomtype' AND bed_type = '$bedtype'
        ) emp
    ON (occ.room_id = emp.room_id)
    WHERE occ.room_id IS NULL;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result); //idk how this works, but it returns only the first result in the array lol
    $designated_room = $row['room_id'];
    ?>
    <!-- checking if there's an available room -->
    <?php
    $roomchecking = array($designated_room);
    if (count($roomchecking) == 1) {
        return 1;
    } else {
        return 0;
    }
    mysqli_close($conn);
    ?>
</body>
</html>