<!-- หน้าหลักเมื่อลูกค้าเข้าสู่ระบบ -->
<!-- In precess : Navbar link banner room discover contact footer -->

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

$email = $_SESSION['email_account'];
$customer_id = $_SESSION['customer_id'];

// ดึงข้อมูลประเภทห้องพัก
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The 9 Hotel</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
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
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- Navbar brand -->
            <a class="navbar-brand me-2" href="account.php">
                <img src="img/logo.png" height="42" alt="Hotel Logo" loading="lazy" style="margin-top: -1px;" />
            </a>

            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <!-- Left links me-auto -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li id="firstmenu" class="nav-item mx-2">
                        <a class="nav-link" href="account.php">Home</a>
                    </li>

                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" id="roomsDropdown" role="button"
                            data-mdb-toggle="dropdown" aria-expanded="false">
                            Rooms
                        </a>
                        <!-- Dropdown menu -->
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                            if (mysqli_num_rows($selectRoomType) > 0) {
                                while($row = mysqli_fetch_row($selectRoomType)) {
                                    echo '<li><a class="dropdown-item" href="roomdetail.php?type='.$row[0].'">'.$row[0].'</a></li>';
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="discover.php">Discover</a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <!-- Left links -->

                <div class="d-flex align-items-center">
                    <div class="btn-group shadow-none me-4 user-nav">
                        <a role="button" class="dropdown-toggle text-dark" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?php echo $email ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <!-- <li><a class="dropdown-item" href="password.php"><i class="fas fa-info-circle me-1"></i> Change Password</a></li> -->
                            <li><a class="dropdown-item" href="account.php?logout=1"><i class="fas fa-arrow-right-to-bracket me-1"></i> Log out</a></li>
                        </ul>
                    </div>
                    <a role="button" class="btn btn-secondary btn-lg px-3 me-2 book-nav" href="showres.php">My Booking</a>
                </div>
            </div>
            <!-- Collapsible wrapper -->
        </div>
    </nav>
    <!-- Navbar -->
    </header>
    <!-- Background image -->
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
            <h1 class="fw-bold" style="font-size: 3rem;">Room Details</h1>
            </div>
        </div>
        </div>
    </div>
    <!-- Background image -->
    
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
            JOIN room rm
            ON (res.room_id = rm.room_id)
            WHERE customer_id = '$customer_id';";
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
                echo '<button type="button" class="btn btn-primary">Read</button>';
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

</body>
</html>