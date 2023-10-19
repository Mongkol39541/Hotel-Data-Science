<?php
// timecheck.php
session_start();

// getting roomtype and bedtype
$roomtype = $_SESSION['roomtype'];
$bedtype = $_SESSION['bedtype'];

?>
<!-- TODO: connect to the uni's server instead of the local -->
<?php
$servername = "localhost";
$username = "root"; //ตามที่กำหนดให้
$password = ""; //ตามที่กำหนดให้
$dbname = "9hotel_reservation";    //ตามที่กำหนดให้
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>
<?php
//gather all the room and reservation information
// get date from reservation
$date = $_POST['datefilter'];
$date_explode = explode('-', $date);
$date_check_in = $date_explode[0];
$date_check_out = $date_explode[1];
$check_in_final = str_replace('/','-',$date_check_in);
$check_out_final = str_replace('/','-',$date_check_out);
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
$row = mysqli_fetch_assoc($result); //idk how this works, but it returns only the first result in the array lol
$designated_room = $row['room_id'];
?>
<!-- checking if there's an available room -->
<?php
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
?>