<?php
    session_start();
    session_unset();
    $open_connect = 1;
    require('connect.php');
    if(
        isset($_POST['prefix']) &&
        isset($_POST['firstname']) &&
        isset($_POST['lastname']) &&
        isset($_POST['email']) &&
        isset($_POST['birthday']) &&
        isset($_POST['password1']) &&
        isset($_POST['password2'])
        ){
        $prefix = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['prefix']));
        $fname = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['firstname']));
        $lname = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['lastname']));
        $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['email']));
        $birthday = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['birthday']));
        $password1 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password1']));
        $password2 = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['password2']));

    } else {
        $_SESSION['error'] = 'Registration unsuccessful; data is not valid';
        mysqli_close($conn);
        die(header("location: ../index.php"));
    }
    if (
        empty($prefix) ||
        empty($fname) ||
        empty($lname) ||
        empty($email) ||
        empty($birthday) ||
        empty($password1) ||
        empty($password2)
        ) {
        $_SESSION['error'] = 'Registration unsuccessful; data is not valid';
        header("location: ../index.php");

    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'Registration unsuccessful; email is not valid';
        header("location: ../index.php");

    } else if (strlen($password1) < 8) {
        $_SESSION['error'] = 'Registration unsuccessful; password must be at least 8 characters';
        header("location: ../index.php");

    } else if ($password1 != $password2) {
        $_SESSION['error'] = 'Registration unsuccessful; password and confirm password do not match';
        header("location: ../index.php");
    } else {
        $check_email_sql = "SELECT email FROM member WHERE email = '$email';";
        $check_email = mysqli_query($conn, $check_email_sql);

        if (mysqli_num_rows($check_email) > 0) {
            $_SESSION['error'] = 'Registration unsuccessful; This email has already been used for registration.';
            header("location: ../index.php");

        } elseif (!isset($_SESSION['error'])) {
            $check_id_sql = "SELECT member_id FROM member ORDER BY member_id DESC LIMIT 1;";
            $check_id = mysqli_query($conn, $check_id_sql);
            $check_id = mysqli_fetch_row($check_id);
            $mem_number = intval(substr($check_id[0], 1));
            $new_id = "M" . ($mem_number + 1);
            $customer = "C" . ($mem_number + 1);
            $length = random_int(97, 128);
            $salt_account = bin2hex(random_bytes($length));
            $password1 = $password1.$salt_account;
            $passwordHash = password_hash($password1, PASSWORD_DEFAULT);
            $role = 'customer';
            $signup_sql = "INSERT INTO member VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $signup_sql);
            mysqli_stmt_bind_param($stmt, "sssssssss", $new_id, $prefix, $fname, $lname, $email, $passwordHash, $role, $birthday, $salt_account);
            mysqli_stmt_execute($stmt);
            $affectedRows = mysqli_stmt_affected_rows($stmt);
            mysqli_stmt_close($stmt);
            if ($affectedRows > 0) {
                $_SESSION['success'] = "Registration successful";

                $insert_sql = "INSERT INTO customer VALUES('$customer','$new_id')";
                $create_account = mysqli_query($conn, $insert_sql);
                header("location: ../index.php");
            } else {
                $_SESSION['error'] = "Registration unsuccessful; Something went wrong. Please try again.";
                header("location: ../index.php");
            }

        } else {
            $_SESSION['error'] = "Registration unsuccessful; Something went wrong. Please try again.";
            header("location: ../index.php");
        }
    }
    mysqli_close($conn);
?>