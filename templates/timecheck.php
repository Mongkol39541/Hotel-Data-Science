<?php
session_start();

if($_POST['datefilter'] != "") {
    $roomtype = $_SESSION['roomtype'];
    $bedtype = $_SESSION['bedtype'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "9hotel_reservation";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $date = $_POST['datefilter'];
    $date_explode = explode('-', $date);
    $date_check_in = $date_explode[0];
    $date_check_out = $date_explode[1];
    $check_in_final = str_replace('/','-',$date_check_in);
    $check_out_final = str_replace('/','-',$date_check_out);


    $sql = "SELECT *
    FROM
        (SELECT res.room_id
        FROM reservation res 
        JOIN room r ON res.room_id = r.room_id
        WHERE r.room_type = '$roomtype' AND r.bed_type = '$bedtype'
        AND ((check_in BETWEEN '$check_in_final' AND '$check_out_final')
        OR (check_out BETWEEN '$check_in_final' AND '$check_out_final')
        OR (check_in <= '$check_in_final' AND check_out >= '$check_out_final'))) occ
    RIGHT JOIN
        (SELECT room_id
        FROM room
        WHERE room_type = '$roomtype' AND bed_type = '$bedtype'
        ) emp
    ON (occ.room_id = emp.room_id)
    WHERE occ.room_id IS NULL;";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $designated_room = $row['room_id'];
    $roomchecking = array($designated_room);
    
    if (count($roomchecking) == 1) {
    echo '<div class="text-success">This room is available.</div>';
    $_SESSION['designated_room'] = $designated_room;
    $_SESSION['check_in'] = $check_in_final;
    $_SESSION['check_out'] = $check_out_final;
    } else {
        echo '<div class="text-danger">This room is not available.</div>';
    }
    mysqli_close($conn);
} else {
    echo '<div class="text-danger">This room is not available.</div>';
}

?>