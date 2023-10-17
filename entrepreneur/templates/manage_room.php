<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrepreneur</title>
    <link rel="icon" href="../static/logo.png">
    <link rel="stylesheet" href="../static/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
</head>

<body>
    <header>
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="../index.php" class="list-group-item list-group-item-action py-2 ripple"
                        aria-current="true">
                        <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
                    </a>
                    <a href="../templates/reserva.html" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
                    </a>
                    <a href="../templates/room.html" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-list-check fa-fw me-3"></i><span>Room info.</span></a>
                    <a href="../templates/dashboard.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-line fa-fw me-3"></i><span>Dashboard</span></a>
                    <a href="../templates/manage_room.php"
                        class="list-group-item list-group-item-action py-2 ripple active">
                        <i class="fa-solid fa-network-wired fa-fw me-3"></i><span>Manage Room</span>
                    </a>
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
                        <img src="../static/M088.jpg" class="rounded-circle" height="30" />
                    </a>
                </ul>
            </div>
        </nav>
    </header>

    <main style="margin-top: 58px">
        <div class="text-center bg-image"
            style="background-image: url('../static/quickbooks-beginners.jpg');height: 450px;">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
                <div class="d-flex justify-content-center align-items-center h-100">
                    <div class="text-white">
                        <h1 class="mb-3">Manage Room</h1>
                    </div>
                </div>
            </div>
        </div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "9hotel_reservation";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT COUNT(room_id) AS num_id FROM `room`;";
            $result = mysqli_query($conn, $sql);
            function generateRandomID($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $randomID = $row["num_id"] + 1;
                }
                return 'R' . sprintf("%03d", $randomID);
            }
            $randomID = generateRandomID($result);
            $chang = $_POST['Chang'];
            $formType = $_POST['formType'];
            $formPrice = $_POST['formPrice'];
            $formSize = $_POST['formSize'];
            $formBed = $_POST['formBed'];
            $formCapacity = $_POST['formCapacity'];
            $formAdditional = $_POST['formAdditional'];
            $formImage = $_POST['formImage'];
            if ($chang == "Insert") {
                $sql = "INSERT INTO room (room_id, room_type, size, bed_type, capacity, price_per_night, facility, room_img) VALUES ('$randomID', '$formType', '$formSize', '$formBed', '$formCapacity', '$formPrice', '$formAdditional', '$formImage')";
                if ($conn->query($sql) === TRUE and $randomID != '') {
                    echo '<div class="alert alert-success m-3 alert-dismissible alert-absolute fade show" id="alertExample" role="alert" data-mdb-color="success">';
                    echo '<i class="fas fa-check me-2"></i>';
                    echo 'ID: ' . $randomID . ' 🎉 ';
                    echo '<strong>Congratulations, you have successfully added your room information.</strong>';
                    echo '<button type="button" class="btn-close ms-2" data-mdb-dismiss="alert" aria-label="Close"></button>';
                    echo '</div><br><br>';
                } else {
                    echo '<div class="alert alert-danger m-3 alert-dismissible alert-absolute fade show" id="alertExample" role="alert" data-mdb-color="success">';
                    echo '<i class="fas fa-check me-2"></i>';
                    echo "Error: " . $sql . "<br>" . $conn->error;
                    echo '<button type="button" class="btn-close ms-2" data-mdb-dismiss="alert" aria-label="Close"></button>';
                    echo '</div><br><br>';
                }
                mysqli_close($conn);
            }
        }
        ?>
        <div class="container p-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block mb-4" data-mdb-toggle="modal"
                                data-mdb-target="#InsertModal">Insert Information</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success btn-block mb-4" data-mdb-toggle="modal"
                                data-mdb-target="#UpdateModal">Update Information</button>
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-danger btn-block mb-4" data-mdb-toggle="modal"
                                data-mdb-target="#DeleteModal">Delete Information</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="InsertModal" tabindex="-1" aria-labelledby="InsertModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Insert Information</h5>
                                <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room Type</label>
                                            <br>
                                            <div class="btn-group-toggle d-flex flex-column" data-toggle="buttons">
                                                <div class="p-0">
                                                    <input type="radio" class="btn-check" name="formType" id="Standard"
                                                        value="Standard" autocomplete="off" checked />
                                                    <label class="btn btn-secondary m-2" for="Standard">Standard</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Deluxe"
                                                        value="Deluxe" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Deluxe">Deluxe</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Suite"
                                                        value="Suite" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Suite">Suite</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Executive"
                                                        value="Executive" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Executive">Executive</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Family"
                                                        value="Family" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Family">Family</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Bed</label>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Single"
                                                            name="formBed" checked />
                                                        <label class="form-check-label" for="formBed">Single</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Double"
                                                            name="formBed" />
                                                        <label class="form-check-label" for="formBed">Double</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Twin"
                                                            name="formBed" />
                                                        <label class="form-check-label" for="formBed">Twin</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="King"
                                                            name="formBed" />
                                                        <label class="form-check-label" for="formBed">King</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Capacity (People)</label>
                                            <div class="form-outline">
                                                <div class="range">
                                                    <input type="range" class="form-range" id="formCapacity" name="formCapacity" required min="1" max="5" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label" for="formPrice">Room Price ($)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control"
                                                    aria-label="Amount (to the nearest dollar)" name="formPrice" required />
                                                <div class="invalid-tooltip">Please provide a valid price.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Size (SQM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">SQM</span>
                                                <input type="text" class="form-control" name="formSize" required />
                                                <div class="invalid-tooltip">Please provide a valid size.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Additional items (Other details about the rooms)</label>
                                            <div class="form">
                                                <textarea name="formAdditional" class="form-control" rows="4" required></textarea>
                                                <div class="invalid-tooltip">Please provide a valid additional.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form mb-5 position-relative">
                                        <label class="form-label">Room Image</label>
                                        <div class="input-group">
                                            <span class="input-group-text">URL</span>
                                            <input name="formImage" type="text" class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" value="Insert" name="Chang">OK</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="UpdateModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title">Update Information</h5>
                                <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room Type</label>
                                            <br>
                                            <div class="btn-group-toggle d-flex flex-column" data-toggle="buttons">
                                                <div class="p-0">
                                                    <input type="radio" class="btn-check" name="formType" id="Standard"
                                                        value="Standard" autocomplete="off" checked />
                                                    <label class="btn btn-secondary m-2" for="Standard">Standard</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Deluxe"
                                                        value="Deluxe" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Deluxe">Deluxe</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Suite"
                                                        value="Suite" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Suite">Suite</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Executive"
                                                        value="Executive" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Executive">Executive</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Family"
                                                        value="Family" autocomplete="off" />
                                                    <label class="btn btn-secondary m-2" for="Family">Family</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Bed</label>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Single"
                                                            name="formBed" checked />
                                                        <label class="form-check-label" for="formBed">Single</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Double"
                                                            name="formBed" />
                                                        <label class="form-check-label" for="formBed">Double</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Twin"
                                                            name="formBed" />
                                                        <label class="form-check-label" for="formBed">Twin</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="King"
                                                            name="formBed" />
                                                        <label class="form-check-label" for="formBed">King</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Capacity (People)</label>
                                            <div class="form-outline">
                                                <div class="range">
                                                    <input type="range" class="form-range" id="formCapacity" name="formCapacity" required min="1" max="5" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label" for="formPrice">Room Price ($)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="text" class="form-control"
                                                    aria-label="Amount (to the nearest dollar)" name="formPrice" required />
                                                <div class="invalid-tooltip">Please provide a valid price.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Size (SQM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">SQM</span>
                                                <input type="text" class="form-control" name="formSize" required />
                                                <div class="invalid-tooltip">Please provide a valid size.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Additional items (Other details about the rooms)</label>
                                            <div class="form">
                                                <textarea name="formAdditional" class="form-control" rows="4" required></textarea>
                                                <div class="invalid-tooltip">Please provide a valid additional.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form mb-5 position-relative">
                                        <label class="form-label">Room Image</label>
                                        <div class="input-group">
                                            <span class="input-group-text">URL</span>
                                            <input name="formImage" type="text" class="form-control" required />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary" value="Update" name="Chang">OK</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <center>
                <div class="card mt-3">
                    <div class="card-body">
                        <h2>Room list</h2>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover" id="tableSearch">
                                <thead>
                                    <tr>
                                        <th>Room ID</th>
                                        <th>Room Type</th>
                                        <th>Size</th>
                                        <th>Bed Type</th>
                                        <th>Capacity</th>
                                        <th>Price per night</th>
                                        <th>Facility</th>
                                        <th>Room Img</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "9hotel_reservation";
                                $conn = mysqli_connect($servername, $username, $password, $dbname);
                                $sql = "SELECT room_id, room_type, size, bed_type, capacity, price_per_night, facility, room_img FROM `room`;";
                                $result = mysqli_query($conn, $sql);

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<tr>';
                                        echo '<td><p class="fw-bold mb-1">' . $row["room_id"] . '</p></td>';
                                        if ($row["room_type"] == 'Standard') {
                                            echo '<td><span class="badge badge-primary rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        } elseif ($row["room_type"] == 'Deluxe') {
                                            echo '<td><span class="badge badge-success rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        } elseif ($row["room_type"] == 'Suite') {
                                            echo '<td><span class="badge badge-danger rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        } elseif ($row["room_type"] == 'Executive') {
                                            echo '<td><span class="badge badge-warning rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        }  else {
                                            echo '<td><span class="badge badge-info rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        }
                                        echo '<td><p class="text-muted mb-0">' . $row["size"] . '</p></td>';
                                        if ($row["bed_type"] == 'Single') {
                                            echo '<td><span class="badge rounded-pill d-inline" style="background-color: #C2185B;">' . $row["bed_type"] . '</span></td>';
                                        } elseif ($row["bed_type"] == 'Double') {
                                            echo '<td><span class="badge rounded-pill d-inline" style="background-color: #D32F2F;">' . $row["bed_type"] . '</span></td>';
                                        } elseif ($row["bed_type"] == 'Twin') {
                                            echo '<td><span class="badge rounded-pill d-inline" style="background-color: #7B1FA2;">' . $row["bed_type"] . '</span></td>';
                                        } elseif ($row["bed_type"] == 'King') {
                                            echo '<td><span class="badge rounded-pill d-inline" style="background-color: #00796B;">' . $row["bed_type"] . '</span></td>';
                                        }  else {
                                            echo '<td><span class="badge rounded-pill d-inline" style="background-color: #00BFA5;">' . $row["bed_type"] . '</span></td>';
                                        }
                                        echo '<td><p class="text-muted mb-0">' . $row["capacity"] . '</p></td>';
                                        echo '<td><p class="text-muted mb-0">' . $row["price_per_night"] . '</p></td>';
                                        echo '<td><p class="text-muted mb-0 text-truncate" style="max-width: 150px;">' . $row["facility"] . '</p></td>';
                                        echo '<td><img src="' . $row["room_img"] . '"style="width: 45px; height: 45px" class="rounded-circle"/></td>';
                                        echo '</tr>';
                                    }
                                }
                                mysqli_close($conn);
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </center>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
    <script src="../static/manage_room.js"></script>
</body>

</html>