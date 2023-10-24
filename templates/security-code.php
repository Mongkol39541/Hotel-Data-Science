<?php
    session_start();
    error_reporting(E_ALL);
    $open_connect = 1;
    require("connect.php");

    require("../PHPMailer-master/src/PHPMailer.php");
    require("../PHPMailer-master/src/SMTP.php");
    require("../PHPMailer-master/src/Exception.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;

    if($set_code != 1){
        die(header("location: ../index.php"));
    }

    date_default_timezone_set('Asia/Bangkok');
    $code = rand(1000, 9999);
    $time = time() + 185;
    $_SESSION['timeout'] = $time;

    if (!isset($_COOKIE['se_code'])) {
        setcookie("se_code", "", time() - 3600, "/");
        setcookie("se_code", $code, $time, "/");
        $cookieTime = date("Y-m-d H:i:s", $time);
    } else {
        setcookie("se_code", $code, $time, "/");
        $cookieTime = date("Y-m-d H:i:s", $time);
    }

    if (isset($_SESSION['correctEmail2'])) {
        $send_to_email = $_SESSION['correctEmail2'];
        $send_to_user = '';
    } else {
        $account_sql = "SELECT * FROM member where member_id='".$_SESSION['id_account']."';";
        $result = mysqli_query($conn, $account_sql);
        $account = mysqli_fetch_assoc($result);

        $send_to_email = $account['email'];
        $send_to_user = $account['title'].' '.$account['first_name'];
    }

    function sendMail($send_to, $otp, $name, $time) {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Enter your email ID
        $mail->Username = "pimdaow03@gmail.com";
        $mail->Password = "zwidzlvreuwxzlmr";

        // Your email ID and Email Title
        $mail->setFrom("pimdaow03@gmail.com", "Hotel Reservation");

        $mail->addAddress($send_to);

        // You can change the subject according to your requirement!
        $mail->Subject = "{$otp} is your security code";

        // You can change the Body Message according to your requirement!
        $mail->Body = "Hello, {$name} \n\n\t We received a request to update your infomation. This code will expire at {$time}";
        $mail->send();
    }

    sendMail($send_to_email, $code, $send_to_user, $cookieTime);

?>