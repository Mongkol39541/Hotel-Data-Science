<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrepreneur</title>
    <link rel="icon" href="static/logo.png">
    <link rel="stylesheet" href="static/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <header>
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="index.php" class="list-group-item list-group-item-action py-2 ripple active">
                        <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
                    </a>
                    <a href="templates/reserva.html" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
                    </a>
                    <a href="templates/room.html" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-list-check fa-fw me-3"></i><span>Room info.</span></a>
                    <a href="templates/dashboard.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-line fa-fw me-3"></i><span>Dashboard</span></a>
                    <a href="templates/manage_room.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-network-wired fa-fw me-3"></i><span>Manage Room</span>
                    </a>
                </div>
            </div>
        </nav>
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="static/logo.png" width="40" alt="Hotel Data Science Logo" />
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
                        <img src="static/M088.jpg" class="rounded-circle" height="30" />
                    </a>
                </ul>
            </div>
        </nav>
    </header>

    <main style="margin-top: 58px">
        <div class="text-center bg-image" style="background-image: url('static/admin.jpg');height: 450px;">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-white">
                        <h1 class="mb-3">Administrator</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="container p-5">
            <center>
                <div class="row">
                    <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "9hotel_reservation";
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                $sql = "SELECT m.member_id, m.title, m.first_name, m.last_name, m.email, m.birthdate, o.position FROM member m JOIN owner o USING(member_id);";
                $result = mysqli_query($conn, $sql);
            
                $num = 1;
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col p-3" id="animation' . $num . '">';
                        $num += 1;
                        echo '<div class="card" style="width: 18rem;">';
                        echo '<img src="static/' .$row["member_id"] .'.jpg" style="height: 18rem;" class="card-img-top" alt="Fissure in Sandstone">';
                        echo '<div class="card-body">';
                        echo '<h6 class="card-text">' .$row["title"] .$row["first_name"] .' ' .$row["last_name"] .'</h6>';
                        echo '<h6 class="card-text">School of Information Technology</h6>';
                        echo '<h6 class="card-text">Data Science and Business Analytics Program</h6>';
                        echo "<h6 class='card-text'>King Mongkut's Institute of Technology Ladkrabang</h6>";
                        echo '<h6 class="card-text">Email : ' .$row["email"] .'</h6>';
                        echo '<h6 class="card-text mb-3">Birthdate : ' .$row["birthdate"] .'</h6>';
                        echo '<div class="text-center m-2">';
                        echo '<a class="btn text-white btn-lg btn-floating m-2" style="background-color: #ac2bac;" href="#!" role="button">';
                        echo '<i class="fab fa-instagram"></i>';
                        echo '</a>';
                        echo '<a class="btn text-white btn-lg btn-floating m-2" style="background-color: #3b5998;" href="#!" role="button">';
                        echo '<i class="fab fa-facebook-f"></i>';
                        echo '</a>';
                        echo '</div>';
                        echo '<div class="text-center">';
                        if ($row["position"] == 'FED') {
                            echo '<button class="btn btn-success px-3 m-2">Front-End Developer</button>';
                        } elseif ($row["position"] == 'BED') {
                            echo '<button class="btn btn-dark px-3 m-2">Back-End Developer</button>';
                        } elseif ($row["position"] == 'SA') {
                            echo '<button class="btn btn-danger px-3 m-2">System Analyst</button>';
                        } elseif ($row["position"] == 'DB') {
                            echo '<button class="btn btn-warning px-3 m-2">Database Administrator</button>';
                        }
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                mysqli_close($conn);
            ?>
                </div>
            </center>
        </div>
    </main>

    <footer id="animation6" class="text-center text-lg-start bg-light text-muted">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
    <script src="static/index.js"></script>
</body>

</html>