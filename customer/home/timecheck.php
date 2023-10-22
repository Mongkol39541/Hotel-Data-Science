<!-- checking whether the room is occupied or not in the specified timeframe -->
<?php
// timecheck.php
session_start();

// getting roomtype and bedtype
$roomtype = $_SESSION['roomtype'];
$bedtype = $_SESSION['bedtype'];
$date = $_POST['datefilter'];

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
if (empty($date)) {
    echo '<div class="text-danger">Please select check-in/check out dates.</div>';
} else {
    //gather all the room and reservation information
    // get date from reservation
    $date_explode = explode('-', $date);
    $date_check_in = $date_explode[0];
    $date_check_out = $date_explode[1];
    $check_in_final = str_replace('/','-',$date_check_in);
    $check_out_final = str_replace('/','-',$date_check_out);
    ?>
    <!-- finding occupied -->
    <?php
    if ($check_in_final < date("Y-m-d")) {
        echo '<div class="text-danger">Please select valid check-in/check out dates.</div>';
    } else {
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
        if (is_null($row)) {
            $designated_room = null;
        } else {
            $designated_room = $row['room_id'];
        }
        
        ?>
        <!-- checking if there's an available room -->
        <?php
        $roomchecking = array($designated_room);
        if (is_null($designated_room)) {
            echo '<div class="text-danger">This room is not available.</div>';
        } else {
            echo '<div class="text-success">This room is available.</div>';
            $_SESSION['designated_room'] = $designated_room;
            $_SESSION['check_in'] = $check_in_final;
            $_SESSION['check_out'] = $check_out_final;
        }
        mysqli_close($conn);
    }
}
    ?>