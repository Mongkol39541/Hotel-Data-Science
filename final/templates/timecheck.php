<?php
session_start();
$roomtype = $_SESSION['roomtype'];
$bedtype = $_SESSION['bedtype'];
$date = $_POST['datefilter'];

?>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "9hotel_reservation";
$conn = mysqli_connect($servername, $username, $password, $dbname);
?>
<?php
if (empty($date)) {
    echo '<div class="text-danger">Please select check-in/check out dates.</div>';
    echo "<script>
    $('#use-member-address').prop('disabled',true);
    $('#fname').prop('disabled',true);
    $('#lname').prop('disabled',true);
    $('#email').prop('disabled',true);
    $('#phone').prop('disabled',true);
    $('#submit').prop('disabled',true);
    </script>";
} else {
    $date_explode = explode('-', $date);
    $date_check_in = $date_explode[0];
    $date_check_out = $date_explode[1];
    $check_in_final = str_replace('/','-',$date_check_in);
    $check_out_final = str_replace('/','-',$date_check_out);
    ?>
    <?php
    if ($check_in_final < date("Y-m-d")) {
        echo '<div class="text-danger">Please select valid check-in/check out dates.</div>';
    } else {
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
        if (is_null($row)) {
            $designated_room = null;
        } else {
            $designated_room = $row['room_id'];
        } 
        ?>
        <?php
        $roomchecking = array($designated_room);
        if (is_null($designated_room)) {
            echo '<div class="text-danger">This room is not available.</div>';
            echo "<script>
                $('#use-member-address').prop('disabled',true);
                $('#fname').prop('disabled',true);
                $('#lname').prop('disabled',true);
                $('#email').prop('disabled',true);
                $('#phone').prop('disabled',true);
                $('#submit').prop('disabled',true);
                </script>";
        } else {
            echo '<div class="text-success">This room is available.</div>';
            echo "<script>
                $('#use-member-address').prop('disabled',false);
                $('#fname').prop('disabled',false);
                $('#lname').prop('disabled',false);
                $('#email').prop('disabled',false);
                $('#phone').prop('disabled',false);
                $('#submit').prop('disabled',false);
                </script>";
            $_SESSION['designated_room'] = $designated_room;
            $_SESSION['check_in'] = $check_in_final;
            $_SESSION['check_out'] = $check_out_final;
        }
        mysqli_close($conn);
    }
}
    ?>