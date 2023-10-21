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
</head>

<body>
    <header>
        <nav class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="admin.php" class="list-group-item list-group-item-action py-2 ripple active">
                        <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
                    </a>
                    <a href="reserva.php" class="list-group-item list-group-item-action py-2 ripple">
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
        <div class="text-center bg-image" style="background-image: url('../static/admin.jpg');height: 450px;">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-white">
                        <h1 class="mb-3">ADMINISTRATOR</h1>
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
                        echo '<img src="../static/' .$row["member_id"] .'.jpg" style="height: 18rem;" class="card-img-top" alt="Fissure in Sandstone">';
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
        
        <div class="transportations p-reg cb-b2 s-combo-default s-combo-default" id="animation6">
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
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15503.244051726755!2d100.7782323!3d13.7298889!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d664988a1bedf%3A0xcc678f180e221cd0!2sKing%20Mongkut&#39;s%20Institute%20of%20Technology%20Ladkrabang!5e0!3m2!1sen!2sth!4v1697700262211!5m2!1sen!2sth"
                                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="py-2 mx-5 my-4 border-top" >
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
    <script src="../static/admin.js"></script>
</body>

</html>