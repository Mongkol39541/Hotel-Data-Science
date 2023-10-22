<!-- Payment confirm -->
<?php
// จัดการ session ควบคุมสิทธิการเข้าใช้งาน
session_start();
$open_connect = 1;
require("connect.php");

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die(header("Location: index.php")); //ถ้าไม่มี session ที่สร้างจากระบบlogin จะถูกนำทางกลับไปหน้าหลัก
} elseif(isset($_GET['logout'])){
    session_destroy();
    mysqli_close($conn);
    die(header("Location: index.php"));
}

// used for showing logged in user in the top right
$email = $_SESSION['email_account'];

//FINAL RES INFO
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

// for payment
$tax = 0.07;
$discount = 00.00;
$payment_type = 'Credit Card';

// ดึงข้อมูลประเภทห้องพัก
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);

// finding interval between check-in/check out
$date1 = new DateTime($check_in_final);
$date2 = new DateTime($check_out_final);
$interval = $date1->diff($date2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <!-- ajax -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

    <style>
        .book-nav {
            border-radius: 0px;
            font-weight: 600;
        }

        .book-nav:hover {
            background: #193460;
            color: #fff;
        }

        .navbar-nav li a {
            color: rgb(72, 72, 72);
        }

        .navbar-nav li a:hover {
            color: #54B4D3;
        }

        @media (min-width: 991px) {
            .dropdown:hover>.dropdown-menu {
                display: block;
                margin-top: 0;
            }

            #navbarButtonsExample {
                margin-left: 20px;
            }
        }

        @media (max-width: 991px) {

            .navbar-nav .nav-item.dropdown .dropdown-menu {
                position: static;
                float: none;
                width: auto;
                margin-top: 0;
                box-shadow: none;
            }

            .navbar-nav .nav-link {
                font-size: 1rem;
                position: relative;
            }

            #firstmenu {
                border-top: 1px solid #eee;
            }

            .user-nav,
            .book-nav {
                margin-bottom: 5px;
            }
        }

        .carousel-inner .carousel-item {
            transition: 2s ease-in-out; /* 1s = 1 second */
        }
    </style>
</head>
<body>
    <header>
        <?php
        require("img/account-nav.php");
        ?>
    </header>
    <main class='mt-4'>
        <h1 class='text-center'>PAYMENT COMPLETED</h1>
        <div class='text-center'>
            <img src="img/green_checkmark.png" alt="" class='img-fluid'>
        </div>
        
        <center>
        <div class="card w-50 mt-3">
            <div class="card-header">
                <h4>Receipt</h4>
            </div>
            <div class="card-body">
                <?php
                $sql_2 = "SELECT * FROM room WHERE room_id = '$designated_room';";
                $result_2 = mysqli_query($conn, $sql_2);
                $col = mysqli_fetch_assoc($result_2);
                echo '<div class="row px-5 mt-3">';
                echo '<div class="col" id="animation4">';
                echo '<div class="card">';
                echo '<img src="'.$col["room_img"].'" class="card-img-top">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.$col['room_id'].'</h5>';
                echo '<p class="card-text">Room Type: '.$col['room_type'].'</p>';    
                echo '<p class="card-text">Size: '.$col['size'].'</p>';    
                echo '<p class="card-text">Bed Type: '.$col['bed_type'].'</p>';    
                echo '<p class="card-text">Price per Night: '.$col['price_per_night'].' ฿</p>';       
                echo '</div></div></div>';
               
                echo '<div class="col mt-3" id="animation5">';

                echo '<p class="text-start">Name-Surname: ' . $res_fname . 
                    ' ' . $res_lname . '</p>';
                echo '<p class="text-start">Email: ' . $res_email . '</p>';
                echo '<p class="text-start">Phone: ' . $res_phone . '</p>';

                $timestamp1 = strtotime($check_in_final);
                $timestamp2 = strtotime($check_out_final);
                $diff = $timestamp2 - $timestamp1;
                $night = floor($diff / (60 * 60 * 24));

                echo '<p class="text-start">Period: ' . $check_in_final .
                    ' - ' . $check_out_final . '</p>';
                echo '<p class="text-start">Night(s): '. $night .'</p>';
                
                echo '<p class="text-start">Time booking: ' . $date_now . '</p>';
                echo '<p class="text-start">Total Room Charges: ' . $total_price . ' THB</p>';
                echo '<p class="text-start">Total Tax Charges: ' . ($total_price * $tax) . ' THB</p>';
                echo '<p class="text-start">Total Discount: ' . $discount . ' THB</p>';
                echo '<p class="text-start"><b>Grand Total</b>: '.$final_room_pice.' THB</p>';
                
                echo '</div>';
                ?>
            </div>
        </div>
        </center>
    </main>

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });

        <?php
        if (isset($_SESSION['loginSuccess'])) {
            echo '   var alertText = "' . $_SESSION['loginSuccess'] . '";';
            echo '   var alertDiv = \'';
            echo '   <div class="alert alert-success position-fixed top-0 start-50 translate-middle-x w-25" style="margin-top:7%;" role="alert" data-mdb-color="success" data-mdb-offset="20">';
            echo '        <i class="fas fa-check-circle me-3"></i> \' + alertText + \'';
            echo '    </div>\';';
            echo '   $("body").append(alertDiv);';
            echo '   setTimeout(function() {';
            echo '       $(".alert").remove();';
            echo '   }, 4000);';
            unset($_SESSION['loginSuccess']);
        }
        ?>

        <?php
        $_SESSION['final_room_pice'] = $final_room_pice;
        ?>
    </script>

    <?php
        //ปิดการเชื่อมต่อฐานข้อมูล
        mysqli_close($conn);
    ?>

</body>
</html>