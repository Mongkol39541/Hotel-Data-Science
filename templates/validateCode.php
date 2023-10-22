<?php
session_start();

$form = $_POST['change-form'];
if ($form == "emailform") {
    $loca = "change-email.php";
} elseif ($form == "passwordform") {
    $loca = "forget.php";
} elseif ($form == "forgetform") {
    $loca = "forgotpassword.php";
}

if (isset($_COOKIE['se_code'])) {

    if (time() < $_SESSION['timeout']) {
        if(!isset($_POST['sixcode']) || empty($_POST['sixcode'])) {
            $_SESSION['errorCheck'] = 'Please enter your security code.';
            die(header("location: $loca"));
        } else {
            $code_input = $_POST['sixcode'];
            if ($code_input != $_COOKIE['se_code']) {
                $_SESSION['errorCheck'] = 'Security code is not valid';
                header("location: $loca");
            } else {
                $_SESSION['correctCode'] = true;
                $_SESSION['correctCode2'] = true;
                header("location: $loca");
            }
        }
    } else {
        $_SESSION['errorCheck'] = 'Your security code is no longer valid. Please try again';
        die(header("location: $loca"));
    }
} else {
    $_SESSION['errorCheck'] = 'An issue exists in your security code. Please try again';
    die(header("location: $loca"));
}

?>