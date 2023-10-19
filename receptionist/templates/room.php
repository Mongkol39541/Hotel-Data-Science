<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Receptionist</title>
  <link rel="icon" href="../static/logo2.png">
  <link rel="stylesheet" href="../static/style2.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
</head>

<body>
  <header>
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a href="../index.php" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
          </a>
          <a href="../templates/reserva.php" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
          </a>
          <a href="../templates/room.php" class="list-group-item list-group-item-action py-2 ripple active">
            <i class="fas fa-list-check fa-fw me-3"></i><span>Room info.</span></a>
        </div>
      </div>
    </nav>
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
          <img src="../static/logo.png" width="40" alt="Hotel Data Science Logo" />
          <h3 class="pt-2"><span class="navbar-text px-2">HTDS</span></h3>
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <ul class="navbar-nav ms-auto d-flex flex-row">
          <a class="nav-link me-3 me-lg-0" href="#" target="_blank">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#" target="_blank">
            <i class="fab fa-twitter"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#" target="_blank">
            <i class="fab fa-google"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#" target="_blank">
            <i class="fab fa-instagram"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#" target="_blank">
            <i class="fab fa-linkedin"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="https://github.com/Mongkol39541/Hotel-Data-Science.git" target="_blank">
            <i class="fab fa-github"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <img src="../static/M088.jpg" class="rounded-circle" height="30" />
          </a>
        </ul>
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
    
  </main>

  <footer id="animation3" class="text-center text-lg-start bg-light text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
      <div class="me-5 d-none d-lg-block">
        <span>Get connected with us on social networks:</span>
      </div>
    </section>
    <div class="container text-center text-md-start mt-5">
      <div class="row mt-3">
        <div class="col-md-3 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Hotel Data Scientist
          </h6>
          <p>
            Hotel Data Scientists leverage data analytics and machine learning to enhance hotel
            operations and guest experiences, optimizing revenue and efficiency. They require
            proficiency in data analysis tools, domain knowledge, and strong communication skills.
          </p>
        </div>
        <div class="col-md-2 mx-auto">
          <h6 class="text-uppercase fw-bold mb-4">
            Tools
          </h6>
          <div class='row'>
            <p class='col'>
              <a href="https://www.w3schools.com/html/default.asp" class="text-reset" target="_blank">HTML</a>
            </p>
            <p class='col'>
              <a href="https://www.w3schools.com/css/default.asp" class="text-reset" target="_blank">CSS</a>
            </p>
            <p class='col'>
              <a href="https://www.w3schools.com/js/default.asp" class="text-reset" target="_blank">Javascript</a>
            </p>
            <p class='col'>
              <a href="https://mdbootstrap.com/docs/standard/getting-started/installation/" class="text-reset" target="_blank">MDBootstrap</a>
            </p>
            <p class='col'>
              <a href="https://www.w3schools.com/php/default.asp" class="text-reset" target="_blank">PHP</a>
            </p>
            <p class='col'>
              <a href="https://www.w3schools.com/mysql/default.asp" class="text-reset" target="_blank">MySQL</a>
            </p>
          </div>
        </div>
        <div class="col-md-3 mx-auto mb-md-0">
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-home me-3"></i>King Mongkut's Institute of Technology Ladkrabang</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            it@kmitl.ac.th
          </p>
          <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
          <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
        </div>
      </div>
    </div>
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
      © 2023 Copyright:
      <a class="text-reset fw-bold" href="#">HTDS.com</a>
    </div>
  </footer>

  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
  <script src="../static/room2.js"></script>
</body>
</html>
