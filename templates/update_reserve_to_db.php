<?php
session_start();
$open_connect = 1;
require("connect.php");

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die(header("Location: ../index.php"));
} elseif(isset($_GET['logout'])){
    session_destroy();
    mysqli_close($conn);
    die(header("Location: ../index.php"));
}

$email = $_SESSION['email_account'];
$customer_id = $_SESSION['customer_id'];
$roomtype = $_SESSION['roomtype'];
$bedtype = $_SESSION['bedtype'];
$designated_room = $_SESSION['designated_room'];
$check_in_final = $_SESSION['check_in'];
$check_out_final = $_SESSION['check_out'];
$res_phone = $_SESSION['res_phone'];
$res_fname = $_SESSION['res_fname'];
$res_lname = $_SESSION['res_lname'];
$res_email = $_SESSION['res_email_account'];
$res_date = date("Y-m-d");
$res_time = date("H:i:s");
$total_price = $_SESSION['total_price'];
$final_room_pice = $_SESSION['final_room_pice'];
$date_now = date("Y-m-d H:i:s");
$tax = 0.07;
$discount = 00.00;
$payment_type = 'Credit Card';
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);
$date1 = new DateTime($check_in_final);
$date2 = new DateTime($check_out_final);
$interval = $date1->diff($date2);
?>
\
<?php
$res_id_sql = 'SELECT reserve_id
FROM reservation
ORDER BY CAST(SUBSTRING(reserve_id, 4) AS SIGNED) DESC;';
$result_res = mysqli_query($conn, $res_id_sql);
$res_id_sql_result = mysqli_fetch_assoc($result_res);
$res_id_num_result = substr($res_id_sql_result['reserve_id'], 3);
// final RES_ID
$new_res_id = 'RES' . str_pad(strval($res_id_num_result + 1), 3, '0', STR_PAD_LEFT);
$res_sql = "INSERT INTO reservation VALUES (?, ?, ?, ?, ?);";
$insert_res = mysqli_prepare($conn, $res_sql);
mysqli_stmt_bind_param($insert_res, "sssss", $new_res_id, $date_now, $check_in_final, $check_out_final, $designated_room);
mysqli_stmt_execute($insert_res);
?>

<?php
$guest_id_sql = 'SELECT guest_id
FROM guest
ORDER BY CAST(SUBSTRING(guest_id, 6) AS SIGNED) DESC';
$result_guest = mysqli_query($conn, $guest_id_sql);
$guest_id_sql_result = mysqli_fetch_assoc($result_guest);
$guest_id_num_result = substr($guest_id_sql_result['guest_id'], 5);
$new_guest_id = 'GUEST' . strval($guest_id_num_result) + 1;
$guest_sql = "INSERT INTO guest VALUES (?, ?, ?, ?, ?, ?, ?);";
$insert_guest = mysqli_prepare($conn, $guest_sql);
mysqli_stmt_bind_param($insert_guest, "sssssss", $new_guest_id, $new_res_id, $customer_id, $res_fname, $res_lname, $res_email, $res_phone);
mysqli_stmt_execute($insert_guest);
?>

<?php
$pay_id_sql = 'SELECT payment_id
FROM transaction
ORDER BY CAST(SUBSTRING(payment_id, 4) AS SIGNED) DESC';
$result_pay = mysqli_query($conn, $pay_id_sql);
$pay_id_sql_result = mysqli_fetch_assoc($result_pay);
$pay_id_num_result = substr($pay_id_sql_result['payment_id'], 3);
$new_pay_id = 'PAY' . str_pad(strval($pay_id_num_result + 1), 3, '0', STR_PAD_LEFT);
$pay_sql = "INSERT INTO transaction VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";
$insert_pay = mysqli_prepare($conn, $pay_sql);
mysqli_stmt_bind_param($insert_pay, "ssssdddds", $new_pay_id, $new_res_id, $res_date, $res_time, $total_price, $tax, $discount, $final_room_pice, $payment_type);
mysqli_stmt_execute($insert_pay);
?>
<?php
    mysqli_close($conn);

    header('location: payment_confirm.php');
?>