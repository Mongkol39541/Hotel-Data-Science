<?php
session_start();
$open_connect = 1;
require("connect.php");

if(!isset($_POST['mailCheck']) || empty($_POST['mailCheck'])) {
    $_SESSION['errorCheck'] = 'Change email unsuccessful; email is not valid';
    die(header("location: forgotpassword.php"));
} else {
    $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['mailCheck']));
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errorCheck'] = 'Change email unsuccessful; email is not valid';
    die(header("location: forgotpassword.php"));
} else {

    $check_email_sql = "SELECT email FROM member WHERE email = '$email';";
    $check_email = mysqli_query($conn, $check_email_sql);

    if (mysqli_num_rows($check_email) == 0) {
        $_SESSION['errorCheck'] = 'This email is not registered with our website.';
        die(header("location: forgotpassword.php"));
    } else {
        $_SESSION['correctEmail'] = true;
        $_SESSION['correctEmail2'] = $email;
        header("location: forgotpassword.php");
    }

}