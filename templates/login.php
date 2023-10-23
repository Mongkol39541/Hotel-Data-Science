<?php
session_start();
$open_connect = 1;
require('connect.php');

if (
    isset($_POST['user_email']) &&
    isset($_POST['user_password'])
) {
    $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_email']));
    $password = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_password']));
} else {
    $_SESSION['loginError'] = "Invalid login, please try again";
    mysqli_close($conn);
    die(header('Location: ../index.php'));
}

if (empty($email) || empty($password)) {
    $_SESSION['loginError'] = "Invalid login, please try again";
    header('Location: ../index.php');
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['loginError'] = 'Invalid email, please try again';
    header('Location: ../index.php');
} else {
    $select_sql = "SELECT * 
    FROM member m
    JOIN customer c
    ON (m.member_id = c.member_id)
    WHERE email = ?";
    $stmt = mysqli_prepare($conn, $select_sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $selectData = mysqli_stmt_get_result($stmt);
    $select_sql0 = "SELECT * FROM member WHERE email = ?";
    $stmt0 = mysqli_prepare($conn, $select_sql0);
    mysqli_stmt_bind_param($stmt0, "s", $email);
    mysqli_stmt_execute($stmt0);
    $selectData0 = mysqli_stmt_get_result($stmt0);
    if(mysqli_num_rows($selectData) == 1 || mysqli_num_rows($selectData0) == 1){
        $account = mysqli_fetch_assoc($selectData);
        $account0 = mysqli_fetch_assoc($selectData0);
        $checkPassword = $account0['password'];
        $password = $password.$account0['salt_password'];
        if(password_verify($password, $checkPassword)){
            $_SESSION["id_account"] = $account0["member_id"];
            $_SESSION['role_account'] = $account0['role'];
            $_SESSION['acc_email_account'] = $email;
            $_SESSION['customer_id'] = $account['customer_id'];
            $_SESSION['acc_fname'] = $account0['first_name'];
            $_SESSION['acc_lname'] = $account0['last_name'];
            $_SESSION['loginSuccess'] = "Login successful";
            mysqli_stmt_close($stmt);
            if ($_SESSION['role_account'] == 'customer') {
                header('Location: account.php');
            } elseif ($_SESSION['role_account'] == 'owner' || $_SESSION['role_account'] == 'recep') {
                header('Location: admin.php');
            }
        }else {
            $_SESSION['loginError'] = "Invalid password, please try again";
            header('Location: ../index.php');
        }
    }else{
        $_SESSION['loginError'] = "This email is not registered with our website.";
        header('Location: ../index.php');
    }
}
mysqli_close($conn);

?>