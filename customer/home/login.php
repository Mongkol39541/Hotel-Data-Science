<!-- ระบบ login -->
<!-- In process : เชื่อมลิ้งค์เพจ owner, recep -->

<?php
session_start();
$open_connect = 1;
require('connect.php');

// ตรวจสอบข้อมูลการเข้าสู่ระบบ
if (
    isset($_POST['user_email']) &&
    isset($_POST['user_password'])
) {
    $email = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_email']));
    $password = htmlspecialchars(mysqli_real_escape_string($conn, $_POST['user_password']));
} else {
    $_SESSION['loginError'] = "Invalid login, please try again";
    mysqli_close($conn);
    die(header('Location: index.php'));
}

if (empty($email) || empty($password)) {
    $_SESSION['loginError'] = "Invalid login, please try again";
    header('Location: index.php');
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['loginError'] = 'Invalid email, please try again';
    header('Location: index.php');
} else {

    // ตรวจสอบความถูกต้องของบัญชีผู้ใช้ จากฐานข้อมูล member
    $select_sql = "SELECT * 
    FROM member m
    JOIN customer c
    ON (m.member_id = c.member_id)
    WHERE email = ?";
    $stmt = mysqli_prepare($conn, $select_sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $selectData = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($selectData) == 1){
        $account = mysqli_fetch_assoc($selectData);
        $checkPassword = $account['password'];

        $password = $password.$account['salt_password'];

        // ตรวจสอบรหัสผ่าน
        if(password_verify($password, $checkPassword)){

            // ควบคุมสิทธิการใช้งาน ตามบทบาทของบัญชีผู้ใช้
            $_SESSION["id_account"] = $account["member_id"];
            $_SESSION['role_account'] = $account['role'];
            $_SESSION['email_account'] = $email;
            // for reservation
            $_SESSION['customer_id'] = $account['customer_id'];
            $_SESSION['acc_fname'] = $account['first_name'];
            $_SESSION['acc_lname'] = $account['last_name'];
            mysqli_stmt_close($stmt);

            $_SESSION['loginSuccess'] = "Login successful";

            if ($_SESSION['role_account'] == 'customer') {
                header('Location: account.php');
            } elseif ($_SESSION['role_account'] == 'owner') {

                //เพิ่มไฟล์ page ของผู้ประกอบการด้วยโว้ยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยย
                header('Location: owner.php');

            } elseif ($_SESSION['role_account'] == 'recep') {
                //เพิ่มไฟล์ page ของพนักงานด้วยโว้ยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยยย
                header('Location: recep.php');
            }
        }else {
            $_SESSION['loginError'] = "Invalid password, please try again";
            header('Location: index.php'); //รหัสผ่านไม่ถูกต้อง
        }
    }else{
        $_SESSION['loginError'] = "This email is not registered with our website.";
        header('Location: index.php'); //ไม่มีอีเมลนี้ในระบบ
    }
}

//ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);

?>