<?php
    session_start();
    $open_connect = 1;
    require('connect.php');

    if(
        isset($_POST['prefix_account']) &&
        isset($_POST['fname_account']) &&
        isset($_POST['lname_account']) &&
        isset($_POST['bday_account'])
        ){
        $prefix = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['prefix_account']));
        $fname = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['fname_account']));
        $lname = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['lname_account']));
        $birthday = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['bday_account']));
    } else {
        $_SESSION['updateError'] = 'Updates unsuccessful; data is not valid';
        die(header("location: profile.php"));
    }

    if (
        empty($prefix) ||
        empty($fname) ||
        empty($lname) ||
        empty($birthday)
        ) {
        $_SESSION['updateError'] = 'Updates unsuccessful; data is not valid';
        header("location: profile.php");

    } else {
        $update_sql = "UPDATE `member` SET `title`=?,`first_name`=?,`last_name`=?,`birthdate`=? WHERE member_id='".$_SESSION['id_account']."';";
        $stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt, "ssss", $prefix, $fname, $lname, $birthday);
        mysqli_stmt_execute($stmt);

        $affectedRows = mysqli_stmt_affected_rows($stmt);
        mysqli_stmt_close($stmt);

        if ($affectedRows > 0) {
            $_SESSION['updateSuccess'] = "Updates successful";
            header("location: profile.php");
        } else {
            $_SESSION['updateError'] = "Your information has not changed.";
            header("location: profile.php");
        }
    }
?>