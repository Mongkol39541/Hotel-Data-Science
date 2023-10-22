<?php
    session_start();
    $open_connect = 1;
    require("connect.php");

    if(!isset($_SESSION['id_account']) || ($_SESSION['role_account'] != "owner" && $_SESSION['role_account'] != "recep")) {
        die(header("Location: ../index.php"));
    } elseif(isset($_GET['logout'])){
        session_destroy();
        die(header("Location: ../index.php"));
    }

    $menber_id = $_SESSION['id_account'];
    $email = $_SESSION['acc_email_account'];
    $sql = "SELECT DISTINCT room_type FROM room;";
    $selectRoomType = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrepreneur</title>
    <link rel="icon" href="../static/logoimage.png">
    <link rel="stylesheet" href="../static/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <header>
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="admin.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
                    </a>
                    <a href="reserva.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
                    </a>
                    <a href="room_status.php" class="list-group-item list-group-item-action py-2 ripple active">
                        <i class="fas fa-list-check fa-fw me-3"></i><span>Room info.</span></a>
                    <?php
                        if($_SESSION['role_account'] == "owner") {
                            echo '<a href="dashboard.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-line fa-fw me-3"></i><span>Dashboard</span></a>';
                            echo '<a href="manage_room.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fa-solid fa-network-wired fa-fw me-3"></i><span>Manage Room</span></a>';
                        }
                    ?>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top" id="main-navbar">
            <div class="container">
                <a class="navbar-brand me-2" href="account.php">
                    <img src="../static/logo.png" height="42" alt="Hotel Logo" loading="lazy" style="margin-top: -1px;" />
                </a>
                <button
                class="navbar-toggler"
                type="button"
                data-mdb-toggle="collapse"
                data-mdb-target="#sidebarMenu"
                aria-controls="sidebarMenu"
                aria-expanded="false"
                aria-label="Toggle navigation"
                >
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarButtonsExample">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="userDropdown" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                                <img src="../static/<?php echo $menber_id; ?>.jpg" class="rounded-circle" height="25" /> <?php echo $email ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="account.php?logout=1"><i class="fas fa-arrow-right-to-bracket me-1"></i> Log out</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main style="margin-top: 58px">
        <div class="text-center bg-image" style="background-image: url('../static/roomlist.jpg');height: 450px;">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-white">
                        <h1 class="mb-3">Room Information</h1>
                    </div>
                </div>
            </div>
        </div>
        <?php
        $servername = "localhost";
        $username = "root"; // ใช้ตอนดูโค้ดตัวเอง
        $password = "";
        // $username = "S083ZMBV";  // ใช้ตอนส่งงาน
        // $password = "5047OZB122"; 
        $dbname = "9hotel_reservation";    //ตามที่กำหนดให้
        
        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $sql = "SELECT * FROM room ORDER BY room_id;";
        $result = mysqli_query($conn, $sql);
        ?>

        <div class="container p-5">
            <div class="card" id="animation1">
                <div class="card-body">
                    <h2 class="text-center">Room List</h2>
                </div>
            </div>


            <?php
                if (isset($_POST["cc_in"])) {
                $r_id = $_POST["cc_in"];
                date_default_timezone_set('Asia/Bangkok');
                $new_in = strftime("%Y-%m-%d %T");
                $sql4 = "UPDATE room_status SET counter_checkin = '$new_in', status = 1 WHERE reserve_id = '$r_id'";
                $conn->query($sql4);
                }

                if (isset($_POST["cc_out"])) {
                $r_id = $_POST["cc_out"];
                date_default_timezone_set('Asia/Bangkok');
                $new_out = strftime("%Y-%m-%d %T");
                $sql4 = "UPDATE room_status SET counter_checkout = '$new_out', status = 0 WHERE reserve_id = '$r_id'";
                $conn->query($sql4);
                }

                if (isset($_POST['room_id'])) {
                $room_id = $_POST['room_id'];
                $sql_2 = "SELECT * FROM room WHERE room_id = '$room_id';";
                $result_2 = mysqli_query($conn, $sql_2);
                $col = mysqli_fetch_assoc($result_2);
                echo '<div class="row px-5 mt-3">';
                echo '<div class="col" id="animation4">';
                echo '<div class="card">';
                echo '<img src="'.$col["room_img"].'" class="card-img-top">';
                echo '<div class="card-body">';
                echo '<h4 class="card-title">'.$col['room_id'].'</h5>';
                echo '<p class="card-text">Room Type: '.$col['room_type'].'</p>';    
                echo '<p class="card-text">Size: '.$col['size'].'</p>';    
                echo '<p class="card-text">Bed Type: '.$col['bed_type'].'</p>';    
                echo '<p class="card-text">Price per Night: '.$col['price_per_night'].'</p>';    
                echo '<p class="card-text">Facility: '.$col['facility'].'</p>';
                echo '<p class="card-text">Description: '.$col['room_description'].'</p>'; 
                echo '</div></div></div>';

                $stt_rom = array();
                $sql_3 = "SELECT * FROM room_status JOIN reservation USING (reserve_id, room_id) WHERE room_id = '$room_id' ORDER BY reserve_id;";
                $result_3 = mysqli_query($conn, $sql_3);         
                echo '<div class="col" id="animation5">';
                while ($sta = mysqli_fetch_assoc($result_3)) {
                    echo '<div class="container mb-3 p-3 shadow-5 bg-gradient">';
                    echo '<p>Reserve ID: <b>' . $sta['reserve_id'] . '</b></p>';
                    echo '<p>check-in: ' . $sta['check_in'] . '</p>';
                    echo '<p>check-out: ' . $sta['check_out'] . '</p>';
                    array_push($stt_rom,$sta['status']);

                    echo '<form enctype="multipart/form-data" action="" method="POST">';
                    if ($sta['counter_checkin']=="0000-00-00 00:00:00") {
                    echo '<label for="cc_in">Counter check-in: ';
                    echo '<button type="submit" class="btn btn-info btn-rounded" name="cc_in" value="' . $sta["reserve_id"] . '"><i class="fa-solid fa-check"></i></button></label>';
                    } else if (($sta['counter_checkin']!="0000-00-00 00:00:00") and ($sta['counter_checkout']=="0000-00-00 00:00:00")) {
                    echo 'Counter check-in: <i>'.$sta['counter_checkin'].'</i><br>';
                    echo '<label for="cc_out">Counter check-out: ';
                    echo '<button type="submit" class="btn btn-info btn-rounded" name="cc_out" value="' . $sta["reserve_id"] . '"><i class="fa-solid fa-check"></i></button></label>';
                    } else if (($sta['counter_checkin']!="0000-00-00 00:00:00") and ($sta['counter_checkout']!="0000-00-00 00:00:00")) {
                    echo 'Counter check-in: <i>'.$sta['counter_checkin'].'</i><br>';
                    echo 'Counter check-out: <i>'.$sta['counter_checkout'].'</i>';
                    }
                    echo '</form></div>';
                }

                $output = "";
                foreach ($stt_rom as $s) {
                    if ($s == 1) {
                    $output = "maiwang";
                    break;
                    }
                }

                if ($output == "") {
                    echo "<div class='card border border-success w-50 pt-1'><center>";
                    echo '<h5 class="text-success">Available</h5>';
                    echo "</center></div>";
                } else {
                    echo "<div class='card border border-danger w-50 pt-1'><center>";
                    echo '<h5 class="text-danger">Unavailable</h5>';
                    echo "</center></div>";
                }
                echo "</div>";
                }
            ?>

            <div class="card mt-3" id="animation2">
                <div class="card-body">
                    <div class="row">
                        <?php
                        $sql_0 = "SELECT r.room_id, rs.status FROM room r LEFT JOIN room_status rs USING (room_id) ORDER BY r.room_id ASC, rs.status DESC;";
                        $result_0 = mysqli_query($conn, $sql_0);
                        $num = "-";
                        while ($val = mysqli_fetch_assoc($result_0)) {
                            if ($num == $val["room_id"]) {
                            $num = $val["room_id"];
                            } else {
                            echo '<div class="col-md-2 mb-3">';
                            echo '<form enctype="multipart/form-data" action="" method="POST">';
                            if ($val['status'] == 1) {
                                echo "<span class='badge badge-danger btn-rounded'>";
                                echo '<button type="submit" class="btn btn-danger btn-rounded" name="room_id" value="'. $val["room_id"] . '">';
                            } else {
                                echo "<span class='badge badge-success btn-rounded'>";
                                echo '<button type="submit" class="btn btn-success btn-rounded" name="room_id" value="'. $val["room_id"] . '">';
                            }
                            echo "<h5>" . $val["room_id"] ."</h5>";      
                            echo "</button><span></form></div>";
                            }
                            $num = $val["room_id"];
                        }
                        mysqli_close($conn);
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="transportations p-reg cb-b2 s-combo-default s-combo-default" id="animation3">
          <div class="text-light contained_w" style="background: rgb(16, 35, 95);">
            <div class="heading text-center">
              <h1 class="py-5">How to Get Here</h1>
            </div>
            <div class="content mx-5">
              <div class="row mx-5">
                <div class="col-md-6 px-md-5 mb-4">
                  <div class="leftcol">
                    <div class="contact">
                      <p style="font-size:30px;">The Nine Hotel</p>
                      <p>1 Chalong Krung 1 Alley, Lat Krabang, Bangkok 10520, Thailand</p>
                    </div>
                    <div class="transports accordions t-b2">
                      <p style="font-size:30px;">Contact</p>
                      <p>Phone : 0 2329 8000 - 0 2329 8099</p>
                      <p>Fax : 0 2329 8106</p>
                      <p>E-mail : pr.kmitl@kmitl.ac.th</p>
                    </div>
                  </div>
                </div>
                <div class="col-md-6 px-md-3 mb-4">
                  <div class="rightcol" id="google-maps">
                    <iframe
                      src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15503.244051726755!2d100.7782323!3d13.7298889!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d664988a1bedf%3A0xcc678f180e221cd0!2sKing%20Mongkut&#39;s%20Institute%20of%20Technology%20Ladkrabang!5e0!3m2!1sen!2sth!4v1697700262211!5m2!1sen!2sth"
                      width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                      referrerpolicy="no-referrer-when-downgrade"></iframe>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
    </main>

    <footer id="animation3" class="py-2 mx-5 my-4 border-top">
      <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
    <script src="../static/room_status.js"></script>
    <script>
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });
    </script>
</body>

</html>