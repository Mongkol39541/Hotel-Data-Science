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
    $email = $_SESSION['email_account'];
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
    <link rel="stylesheet" href="../static/style2.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
</head>

<body>
  <header>
    <nav class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a href="admin.php" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
          </a>
          <a href="reserva.php" class="list-group-item list-group-item-action py-2 ripple active">
            <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
          </a>
          <a href="room_status.php" class="list-group-item list-group-item-action py-2 ripple">
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
    <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container">
        <a class="navbar-brand me-2" href="account.php">
          <img src="../static/logo.png" height="42" alt="Hotel Logo" loading="lazy" style="margin-top: -1px;" />
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
        data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false"
        aria-label="Toggle navigation">
        <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarButtonsExample">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li id="firstmenu" class="nav-item mx-2">
              <a class="nav-link" href="account.php">Home</a>
            </li>
            <li class="nav-item dropdown mx-2">
              <a class="nav-link dropdown-toggle" id="roomsDropdown" role="button"
              data-mdb-toggle="dropdown" aria-expanded="false">
              Rooms
            </a>
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
          <div class="d-flex align-items-center">
            <div class="btn-group shadow-none me-4 user-nav">
              <a role="button" class="dropdown-toggle text-dark" data-mdb-toggle="dropdown" aria-expanded="false">
                <img src="../static/<?php echo $menber_id; ?>.jpg" class="rounded-circle" height="25" /> <?php echo $email ?>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="account.php?logout=1"><i class="fas fa-arrow-right-to-bracket me-1"></i> Log out</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </header>

    <main style="margin-top: 58px">
        <div class="text-center bg-image" style="background-image: url('../static/reserva.jpg');height: 450px;">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-white">
                        <h1 class="mb-3">Reserva Information</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-5">
            <center>
                <div class="card" id="animation1">
                    <div class="card-body">
                        <h2>Customer booking information table</h2>
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

                // --- SQL SELECT statement
                $sql = "SELECT * FROM reservation
                    JOIN guest USING (reserve_id)
                    ORDER BY reserve_id";

                $result = mysqli_query($conn, $sql);
                ?>
                <div class="card mt-3" id="animation2">
                    <div class="card-body">
                         <div class="table-responsive">
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                echo '<table id="tableSearch" class="table table-bordered border-primary">';
                                echo '<thead class="bg-info text-light">';
                                echo "<th>reserve_id</th><th>first_name</th><th>last_name</th>".
                                    "<th>email</th><th>phone</th><th>reserve_time</th>".
                                    "<th>check_in</th><th>check_out</th>".
                                    "<th>room_id</th></thead><tbody>";
                                    // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr><td>" . $row["reserve_id"]. "</td><td>" . $row["first_name"] . 
                                    "</td><td>" . $row["last_name"] . "</td><td>" . $row["email"] . "</td><td>" .
                                    $row["phone"] . "</td><td>" . $row["reserve_time"] . "</td><td>" . $row["check_in"] . "</td><td>" . 
                                    $row["check_out"] . "</td><td>" . $row["room_id"] . "</td></tr>";
                                }
                                echo "</tbody></table>";
                            } else {
                                echo "0 results";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </center>
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

    <footer class="py-2 mx-5 my-4 border-top">
      <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
  <script src="../static/reserva2.js"></script>
</body>

</html>