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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
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
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-twitter"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-google"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-instagram"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-linkedin"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-github"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <img src="static/M088.jpg" class="rounded-circle" height="30" />
          </a>
        </ul>
      </div>
    </nav>
  </header>

  <main style="margin-top: 58px">
    <div class="text-center bg-image" style="background-image: url('../static/reserva.jpg');height: 450px;">
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
      $conn = mysqli_connect($servername, $username, $password, $dbname) 
          or die("Connection failed: " . mysqli_connect_error());

      $con_2 = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
      $con_2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      // --- SQL SELECT statement
      $sql = "SELECT * FROM room
          ORDER BY room_id;";

      $result = mysqli_query($conn, $sql);
    ?>

    <div class="container p-5">
      <div class="card">
        <div class="card-body">
          <h2>Room List</h2>
        </div>
      </div>
      

      <?php
      if (isset($_POST['room_id'])) {
        $room_id = $_POST['room_id'];
        $sql_2 = "SELECT * FROM room WHERE room_id = '$room_id';";
        $result_2 = mysqli_query($conn, $sql_2);
        $col = mysqli_fetch_assoc($result_2);
        echo '<div class="row p-5">';
        echo '<div class="col-md-6 mb-2">';
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
        echo '<div class="col-md-6 mb-2">';
        while ($sta = mysqli_fetch_assoc($result_3)) {
          echo '<div class="container mb-3 p-3 shadow-5 bg-gradient">';
          echo '<p>Reserve ID: <b>' . $sta['reserve_id'] . '</b></p>';
          echo '<p>check-in: ' . $sta['check_in'] . '</p>';
          echo '<p>check-out: ' . $sta['check_out'] . '</p>';
          array_push($stt_rom,$sta['status']);

          echo '<form action="" method="post">';
          if ($sta['counter_checkin']=="0000-00-00 00:00:00") {
            echo '<label for="cc_in_'.$sta['reserve_id'].'">Counter check-in: ';
            echo '<button type="submit" class="btn btn-info btn-rounded" name="cc_in_'.$sta["reserve_id"].
            '" value="'.$sta["reserve_id"].'"><i class="fa-solid fa-check"></i></button></label>';

            $chang_1 = "cc_in_". $sta["reserve_id"];
            if (isset($_POST[$chang_1])) {
              $r_id = $sta["reserve_id"];

              date_default_timezone_set('Asia/Bangkok');
              $new_in = strftime("%Y-%m-%d %T");

              $sql_4 = "UPDATE room_status
                        SET counter_checkin = :new_in, status = 1
                        WHERE reserve_id = :r_id";
                    
              $stmt = $con_2->prepare($sql_4);
              $stmt->bindParam(':new_in', $new_in, PDO::PARAM_STR);
              $stmt->bindParam(':r_id', $r_id, PDO::PARAM_STR);
                        
              $stmt->execute();
            }
            
          } else if (($sta['counter_checkin']!="0000-00-00 00:00:00") and ($sta['counter_checkout']=="0000-00-00 00:00:00")) {
            echo 'Counter check-in: <i>'.$sta['counter_checkin'].'</i><br>';
            echo '<label for="cc_out_'.$sta['reserve_id'].'">Counter check-out: ';
            echo '<button type="submit" class="btn btn-info btn-rounded" name="cc_out_'.$sta["reserve_id"].
            '" value="'.$sta["reserve_id"].'"><i class="fa-solid fa-check"></i></button></label>';

            $chang_2 = "cc_out_". $sta["reserve_id"];
            if (isset($_POST[$chang_2])) {
              $r_id = $sta["reserve_id"];

              date_default_timezone_set('Asia/Bangkok');
              $new_out = strftime("%Y-%m-%d %T");

              $sql_5 = "UPDATE room_status
                        SET counter_checkout = :new_out, status = 0
                        WHERE reserve_id = :r_id";
                    
              $stmt = $con_2->prepare($sql_5);
              $stmt->bindParam(':new_out', $new_out, PDO::PARAM_STR);
              $stmt->bindParam(':r_id', $r_id, PDO::PARAM_STR);
                        
              $stmt->execute();
            }
          } else if (($sta['counter_checkin']!="0000-00-00 00:00:00") and ($sta['counter_checkout']!="0000-00-00 00:00:00")) {
            echo 'Counter check-in: <i>'.$sta['counter_checkin'].'</i><br>';
            echo 'Counter check-out: <i>'.$sta['counter_checkout'].'</i>';
          }
      
        echo '</div>';
        }

        $output = "";
        foreach ($stt_rom as $s) {
          if ($s == 1) {
            $output = "maiwang";
            break;
          }
        }

        if ($output == "") {
          echo "<div class='card border border-success w-50 p-1'><center>";
          echo '<h5 class="text-success">Available</h5>';
          echo "</center></div>";
        } else {
          echo "<div class='card border border-danger w-50 p-1'><center>";
          echo '<h5 class="text-danger">Unavailable</h5>';
          echo "</center></div>";
        }
      }?>
    </div>

    <div class="card mt-3">
      <div class="card-body">
        <div class="row">
          <?php
            if (mysqli_num_rows($result) > 0) {
            // output data of each row
              while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="col-md-2 mb-3">';
                echo '<form method="post"';
                echo "<span class='badge badge-primary btn-rounded'>";
                echo '<button type="submit" class="btn btn-primary btn-rounded"'.'name="room_id" value="'. $row["room_id"] . '">';
                echo "<h5>" . $row["room_id"] ."</h5>";      
                echo "</button><span></form></div>";    
              }
            } else {
              echo "0 results";
            }
          ?>
        </div>
      </div>
    </div>
    
  </main>

  <footer class="text-center text-lg-start bg-light text-muted">
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
              <a href="#!" class="text-reset">HTML</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">CSS</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">Javascript</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">MDBootstrap</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">PHP</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">MySQL</a>
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

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="../static/room.js"></script>
</body>
</html>
