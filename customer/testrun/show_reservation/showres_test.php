<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="static/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
</head>
<body>
    <!--Main Navigation-->
  <header>
    <!-- Intro settings -->
    <style>
      #intro {
        /* Margin to fix overlapping fixed navbar */
        margin-top: 58px;
      }
      @media (max-width: 991px) {
        #intro {
          /* Margin to fix overlapping fixed navbar */
          margin-top: 45px;
        }
      }
    </style>

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container-fluid">
        <!-- Navbar brand -->
        <a class="navbar-brand" href="index.php">
          <img src="../img/logo.png" height="42" alt="Hotel Logo" loading="lazy" style="margin-top: -1px;" />
        </a>
                <ul class="navbar-nav ms-auto d-flex flex-row">
                <a class="nav-link me-3 me-lg-0" href="#">
                    <img src="../static/M088.jpg" class="rounded-circle" height="30" />
                </a>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Navbar -->

    <!-- Jumbotron -->
    <div id="intro" class="p-5 text-center">
      <h1 class="mb-3 h2">Learn Bootstrap 5 with MDB</h1>
      <p class="mb-3">Best & free guide of responsive web design</p>
    </div>
    <!-- Jumbotron -->
  </header>
  <!--Main Navigation-->

  <!--Main layout-->
  <main class="my-5">
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
            $guest = 'GUEST105'; //hardcode
            $sql = "SELECT *
            FROM guest g 
            JOIN reservation res
            ON (g.reserve_id = res.reserve_id)
            JOIN room rm
            ON (res.room_id = rm.room_id)
            WHERE guest_id = '$guest';";
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($result)) {
                echo '<div class="row">';
                echo '<div class="col-md-4 mb-4">';
                echo '<div class="bg-image hover-overlay shadow-1-strong rounded ripple" data-mdb-ripple-color="light">';
                echo '<img src="' . $row['room_img'] . '" class="img-fluid" />';
                echo '<a href="#!">';
                echo '<div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>';
                echo '</a>';
                echo '</div>';
                echo '</div>';
                echo '<div class="col-md-8 mb-4">';
                echo '<h5>'. 'Reservation ID: ' . $row['reserve_id'] .'</h5>';
                echo '<p>Room type: '.$row['room_type'] . '</p>';
                echo '<p>Bed type: '.$row['bed_type'] . '</p>';
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
  </main>
  <!--Main layout-->

  <!--Footer-->
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
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Copyright:
            <a class="text-reset fw-bold" href="#">HTDS.com</a>
        </div>
    </footer>
  <!--Footer-->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
</body>
</html>