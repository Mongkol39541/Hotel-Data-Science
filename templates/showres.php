<?php
session_start();
$open_connect = 1;
require("connect.php");

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die(header("Location: index.php"));
} elseif(isset($_GET['logout'])){
    session_destroy();
    mysqli_close($conn);
    die(header("Location: index.php"));
}

$email = $_SESSION['email_account'];
$customer_id = $_SESSION['customer_id'];
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Nine Hotel</title>
    <link rel="icon" href="../static/logoimage.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="../static/main2.js" defer></script>
</head>
<body>
    <header>
        <?php
        require("img/account-nav.php");
        ?>
    </header>
    <div
        class="mb-5 p-5 text-center bg-image"
        style="
        background-image: url('https://www.dusit.com/asai-bangkok-chinatown/wp-content/uploads/sites/51/cache/2023/08/Comfort-at-ASAI-Chinatown/25512868.jpg');
        height: 400px;
        "
    >
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.2);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h1 class="" style="font-size: 3rem;">MY BOOKING</h1>
            </div>
        </div>
        </div>
    </div>
    <!-- Background image -->
    <div class='mb-5 text-center'>
        <button type="button" class="btn btn-primary me-3" onclick="window.location.href='showres.php'" disabled>
            Show upcoming reseravtion
        </button>
        <button type="button" class="btn btn-primary" onclick="window.location.href='past_showres.php'">
            Show past reseravtion
        </button>
    </div>
    
    <div class="container">
      <!--Grid row-->
      <div class="row">
        <!--Grid column-->
        <div class="col-md-12 mb-4">
          <!--Section: Content-->
          <section>
            <!-- connect to a db -->
            <?php
            $servername = "localhost";
            $username = "root"; //ตามที่กำหนดให้
            $password = ""; //ตามที่กำหนดให้
            $dbname = "9hotel_reservation";    //ตามที่กำหนดให้
            // Create connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            ?>

            <?php
            $sql = "SELECT *
            FROM guest g
            JOIN reservation res
            ON (g.reserve_id = res.reserve_id)
            JOIN transaction t
            ON (t.reserve_id = res.reserve_id)
            JOIN room rm
            ON (res.room_id = rm.room_id)
            WHERE customer_id = '$customer_id' AND check_in >= CAST(NOW() AS DATE)";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="row">';
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="bg-image hover-overlay shadow-1-strong rounded ripple" data-mdb-ripple-color="light">';
                echo '<img src="' . $row['room_img'] . '" class="img-fluid" />';
                echo '<div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-md-8 mb-4">';
                echo '<h5>'. 'Reservation ID: ' . $row['reserve_id'] .'</h5>';
                echo '<div>' . $row['room_type'] . ' ' . $row['bed_type'] . '</div>';
                echo '<div>Check in: ' . $row['check_in'] . '</div>';
                echo '<div>Check out: ' . $row['check_out'] . '</div>';
                echo '<a type="button" class="btn btn-primary" href="showres_room_detail.php?res_id='.$row['reserve_id'] .'">Show details</a>';
                echo '</div>';
                echo '</div>';
            }
            mysqli_close($conn);
            ?>
          </section>
          <!--Section: Content-->
        </div>
        <!--Grid column-->
    </div>


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
    </script>

    <script>
        //ปิดการเชื่อมต่อฐานข้อมูล
        mysqli_close($conn);
    </script>

</body>
</html>