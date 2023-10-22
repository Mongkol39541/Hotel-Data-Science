<?php
session_start();
$open_connect = 1;
require("connect.php");

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account']) ||
    !isset($_SESSION['correctCode2'])
){
    die(header("Location: ../index.php"));
}

if(!isset($_POST['email']) || empty($_POST['email'])) {
    $_SESSION['errorCheck'] = 'Change email unsuccessful; email is not valid';
    die(header("location: profile.php"));
} else {
    $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['errorCheck'] = 'Change email unsuccessful; email is not valid';
    die(header("location: profile.php"));
} else {

    //ตรวจสอบเงื่อนไข ไม่สามารถทำการสมัครสมาชิกด้วยอีเมลเดิมได้
    $check_email_sql = "SELECT email FROM member WHERE email = '$email';";
    $check_email = mysqli_query($conn, $check_email_sql);

    if (mysqli_num_rows($check_email) > 0) {
        $_SESSION['errorCheck'] = 'Change email unsuccessful; This email has already been used for registration.';
        die(header("location: profile.php"));
    } else {
        $update_sql = "UPDATE `member` SET `email`=? WHERE member_id='".$_SESSION['id_account']."';";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);

        $affectedRows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);
        unset($_SESSION['correctCode2']);
        setcookie("se_code", "", time() - 3600, "/");

        if ($affectedRows > 0) {
            $_SESSION['success'] = "Update email successful";
            $_SESSION['email_account'] = $email;
            header("location: profile.php");
        } else {
            $_SESSION['errorCheck'] = "Change email unsuccessful; Something went wrong. Please try again.";
            header("location: profile.php");
        }
    }

}



?>