<?php
    session_start();
    $open_connect = 1;
    require('connect.php');


    if(
        isset($_POST['currentPassword']) &&
        isset($_POST['Password1']) &&
        isset($_POST['Password2'])
    ){
        $currentPassword = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['currentPassword']));
        $password1 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['Password1']));
        $password2 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['Password2']));

    } elseif (
        isset($_SESSION['correctCode2']) &&
        isset($_POST['Password1']) &&
        isset($_POST['Password2'])
    ) {
        $form = $_POST['updatePass'];
        if ($form == "forgotindex") {
            $loca = "../index.php";
        } elseif ($form == "forgotaccount") {
            $loca = "profile.php";
        }
        $currentPassword = "aaaaaaaa";
        $password1 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['Password1']));
        $password2 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['Password2']));
    } else {
        $_SESSION['errorCheck'] = 'Change password unsuccessful; data is not valid';
        die(header("location: $loca"));
    }

    if (
        empty($currentPassword) ||
        empty($password1) ||
        empty($password2)
        ) {
        $_SESSION['errorCheck'] = 'Change password unsuccessful; data is not valid';
        header("location: $loca");

    } else if (
        (strlen($currentPassword) < 8) || (strlen($currentPassword) > 30) ||
        (strlen($password1) < 8) || (strlen($password1) > 30) ||
        (strlen($password2) < 8) || (strlen($password2) > 30)
        ) {
        $_SESSION['errorCheck'] = 'Change password unsuccessful; password length is incorrect';
        header("location: $loca");

    } else if ($password1 != $password2) {
        $_SESSION['errorCheck'] = 'Change password unsuccessful; password and confirm password do not match';
        header("location: $loca");
    } else {

        if (isset($_SESSION['id_account'])) {
            $account_sql = "SELECT password, salt_password FROM member where member_id='".$_SESSION['id_account']."';";
            $result = mysqli_query($conn, $account_sql);
            $account = mysqli_fetch_assoc($result);
        }

        $currentPassword = $currentPassword.$account['salt_password'];
        if(password_verify($currentPassword, $account['password']) ||
            isset($_SESSION['correctCode2'])) {

            //สร้าง passwordHash
            $length = random_int(97, 128);
            $salt_account = bin2hex(random_bytes($length));
            $password1 = $password1.$salt_account;
            $passwordHash = password_hash($password1, PASSWORD_DEFAULT);

            if (isset($_SESSION['correctEmail2'])) {
                $update_sql = "UPDATE `member` SET `password`=?,`salt_password`=? WHERE email='".$_SESSION['correctEmail2']."';";
            } else {
                $update_sql = "UPDATE `member` SET `password`=?,`salt_password`=? WHERE member_id='".$_SESSION['id_account']."';";
            }
            $stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $salt_account);
            mysqli_stmt_execute($stmt);

            $affectedRows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            unset($_SESSION['correctCode2']);
            unset($_SESSION['correctEmail2']);
            setcookie("se_code", "", time() - 3600, "/");

            if ($affectedRows > 0) {
                $_SESSION['success'] = "Update password successful";
                header("location: $loca");
            } else {
                $_SESSION['errorCheck'] = "Change password unsuccessful; Something went wrong. Please try again.";
                header("location: $loca");
            }
        } else {
            $_SESSION['errorCheck'] = "Invalid current password, please try again";
            header("location: $loca");
        }
    }
?>