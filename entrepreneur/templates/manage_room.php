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

<body class="scroller">
    <header>
        <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
            <div class="position-sticky">
                <div class="list-group list-group-flush mx-3 mt-4">
                    <a href="../index.php" class="list-group-item list-group-item-action py-2 ripple"
                        aria-current="true">
                        <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
                    </a>
                    <a href="../templates/reserva.php" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
                    </a>
                    <a href="../templates/room.php" class="list-group-item list-group-item-action py-2 ripple">
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
                    <a class="nav-link me-3 me-lg-0" href="#" target="_blank">
                        <i class="fab fa-github"></i>
                    </a>
                    <a class="nav-link me-3 me-lg-0" href="https://github.com/Mongkol39541/Hotel-Data-Science.git" target="_blank">
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
        if(isset($_POST['Chang'])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "9hotel_reservation";
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            $sql = "SELECT COUNT(room_id) AS num_id FROM `room`;";
            $result = mysqli_query($conn, $sql);
            $chang = $_POST['Chang'];
            if ($chang == "Insert") {
                $randomID = $_POST['formID'];
                $formType = $_POST['formType'];
                $formPrice = $_POST['formPrice'];
                $formSize = $_POST['formSize'];
                $formBed = $_POST['formBed'];
                $formCapacity = $_POST['formCapacity'];
                $formAdditional = $_POST['formAdditional'];
                $formImage = $_POST['formImage'];
                $sql = "INSERT INTO room (room_id, room_type, size, bed_type, capacity, price_per_night, facility, room_img) VALUES ('$randomID', '$formType', '$formSize', '$formBed', '$formCapacity', '$formPrice', '$formAdditional', '$formImage')";
                if ($conn->query($sql) === TRUE and $randomID != '') {
                    echo '<div class="alert alert-success m-3 alert-dismissible alert-absolute fade show" id="alertExample" role="alert" data-mdb-color="success">';
                    echo '<i class="fas fa-check me-2"></i>';
                    echo 'ID: ' . $randomID . ' 🎉 ';
                    echo '<strong>Congratulations, you have successfully insert your room information.</strong>';
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
            } elseif ($chang == "Update") {
                $randomID = $_POST['formID'];
                $formType = $_POST['formType'];
                $formPrice = $_POST['formPrice'];
                $formSize = $_POST['formSize'];
                $formBed = $_POST['formBed'];
                $formCapacity = $_POST['formCapacity'];
                $formAdditional = $_POST['formAdditional'];
                $formImage = $_POST['formImage'];
                $sql = "UPDATE room SET room_type = '$formType', size = '$formSize', bed_type = '$formBed', capacity = '$formCapacity', price_per_night = '$formPrice', facility = '$formAdditional', room_img = '$formImage' WHERE room_id = '$randomID'";
                if ($conn->query($sql) === TRUE and $randomID != '') {
                    echo '<div class="alert alert-success m-3 alert-dismissible alert-absolute fade show" id="alertExample" role="alert" data-mdb-color="success">';
                    echo '<i class="fas fa-check me-2"></i>';
                    echo 'ID: ' . $randomID . ' 🎉 ';
                    echo '<strong>Congratulations, you have successfully update your room information.</strong>';
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
            } elseif ($chang == "Delete") {
                $randomID = $_POST['formID'];
                $sql = "DELETE FROM room WHERE room_id = '$randomID'";
                if ($conn->query($sql) === TRUE and $randomID != '') {
                    echo '<div class="alert alert-success m-3 alert-dismissible alert-absolute fade show" id="alertExample" role="alert" data-mdb-color="success">';
                    echo '<i class="fas fa-check me-2"></i>';
                    echo 'ID: ' . $randomID . ' 🎉 ';
                    echo '<strong>Congratulations, you have successfully delete your room information.</strong>';
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
            <div class="card" id="animation1">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary btn-block" data-mdb-toggle="modal"
                                data-mdb-target="#InsertModal">Insert Information</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="InsertModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title mx-2">Insert Information</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form mb-5">
                                        <label class="form-label">Room ID</label>
                                        <input type="text" class="form-control" name="formID" required/>
                                    </div>
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room Type</label>
                                            <br>
                                            <div class="btn-group-toggle d-flex flex-column" data-toggle="buttons">
                                                <div class="p-0">
                                                    <input type="radio" class="btn-check" name="formType" id="StandardIn"
                                                        value="Standard" required/>
                                                    <label class="btn btn-secondary m-2" for="StandardIn">Standard</label>
                                                    <input type="radio" class="btn-check" name="formType" id="DeluxeIn"
                                                        value="Deluxe" required/>
                                                    <label class="btn btn-secondary m-2" for="DeluxeIn">Deluxe</label>
                                                    <input type="radio" class="btn-check" name="formType" id="SuiteIn"
                                                        value="Suite" required/>
                                                    <label class="btn btn-secondary m-2" for="SuiteIn">Suite</label>
                                                    <input type="radio" class="btn-check" name="formType" id="ExecutiveIn"
                                                        value="Executive" required/>
                                                    <label class="btn btn-secondary m-2" for="ExecutiveIn">Executive</label>
                                                    <input type="radio" class="btn-check" name="formType" id="FamilyIn"
                                                        value="Family" required/>
                                                    <label class="btn btn-secondary m-2" for="FamilyIn">Family</label>
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
                                                    <input type="range" class="form-range" name="formCapacity" required min="1" max="5" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label" for="formPrice">Room Price ($)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control"
                                                    aria-label="Amount (to the nearest dollar)" name="formPrice" required min="1000" max="30000" />
                                                <div class="invalid-tooltip">Please provide a valid price.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Size (SQM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">SQM</span>
                                                <input type="number" class="form-control" name="formSize" required min="5" max="100" />
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

            <div class="modal fade" id="UpdateModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title mx-2">Update Information</h5>
                                <h5 class="modal-title mx-2 px-2 bg-warning text-light rounded" id="formRID">ID #</h5>
                                <button type="button" class="btn-close" data-mdb-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="form mb-5">
                                        <label class="form-label">Room ID</label>
                                        <input type="text" class="form-control" name="formID" id="formID" required/>
                                    </div>
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room Type</label>
                                            <br>
                                            <div class="btn-group-toggle d-flex flex-column" data-toggle="buttons">
                                                <div class="p-0">
                                                    <input type="radio" class="btn-check" name="formType" id="Standard"
                                                        value="Standard" required/>
                                                    <label class="btn btn-secondary m-2" for="Standard">Standard</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Deluxe"
                                                        value="Deluxe" required/>
                                                    <label class="btn btn-secondary m-2" for="Deluxe">Deluxe</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Suite"
                                                        value="Suite" required/>
                                                    <label class="btn btn-secondary m-2" for="Suite">Suite</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Executive"
                                                        value="Executive" required/>
                                                    <label class="btn btn-secondary m-2" for="Executive">Executive</label>
                                                    <input type="radio" class="btn-check" name="formType" id="Family"
                                                        value="Family" required/>
                                                    <label class="btn btn-secondary m-2" for="Family">Family</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Bed</label>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Single" id="Single"
                                                            name="formBed" required/>
                                                        <label class="form-check-label" for="formBed">Single</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Double" id="Double"
                                                            name="formBed" required/>
                                                        <label class="form-check-label" for="formBed">Double</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="Twin" id="Twin"
                                                            name="formBed" required/>
                                                        <label class="form-check-label" for="formBed">Twin</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" value="King" id="King"
                                                            name="formBed" required/>
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
                                                    aria-label="Amount (to the nearest dollar)" name="formPrice" id="formPrice" required min="1000" max="30000" />
                                                <div class="invalid-tooltip">Please provide a valid price.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Room Size (SQM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">SQM</span>
                                                <input type="number" class="form-control" name="formSize" id="formSize" required min="5" max="100" />
                                                <div class="invalid-tooltip">Please provide a valid size.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Additional items (Other details about the rooms)</label>
                                            <div class="form">
                                                <textarea name="formAdditional" class="form-control" rows="4" id="formfacility" required></textarea>
                                                <div class="invalid-tooltip">Please provide a valid additional.</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form mb-5 position-relative">
                                        <label class="form-label">Room Image</label>
                                        <div class="input-group">
                                            <span class="input-group-text">URL</span>
                                            <input name="formImage" type="text" class="form-control" id="formImage" required />
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

            <div class="modal top fade" id="DeleteModal" tabindex="-1" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="modal-header bg-danger text-light d-flex justify-content-center align-items-center">
                                <h5 class="modal-title">Are you sure?</h5>
                            </div>
                            <div class="modal-body text-center">
                                <i class="fas fa-trash-can fa-3x text-danger"></i>
                                <h5 class="modal-title mt-3 mx-5 bg-danger text-light rounded" id="textDelete"></h5>
                                <input name="formID" type="text" id="outDelete" hidden />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-outline-danger" value="Delete" name="Chang">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <center id="animation2">
                <div class="card mt-3">
                    <div class="card-body">
                        <h2>Room list</h2>
                        <br>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" id="tableSearch">
                                <thead>
                                    <tr>
                                        <th class="text-center">Actions</th>
                                        <th class="text-center">Room ID</th>
                                        <th class="text-center">Room Type</th>
                                        <th class="text-center">Size</th>
                                        <th class="text-center">Bed Type</th>
                                        <th class="text-center">Capacity</th>
                                        <th class="text-center">Price per night</th>
                                        <th class="text-center">Facility</th>
                                        <th class="text-center">Room Img</th>
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
                                        echo '<td class="text-center"><div class="row">';
                                        echo '<div class="col"><button class="mb-1 btn btn-link btn-rounded btn-sm fw-bold" id="Update" data-mdb-toggle="modal" data-mdb-target="#UpdateModal" type="button" data-roomid="' . $row["room_id"] . '">Edit</button></div>';
                                        echo '</div>';
                                        echo '<div class="row">';
                                        echo '<div class="col"><button class="btn btn-link btn-rounded btn-sm fw-bold text-danger" id="Delete" data-mdb-toggle="modal" data-mdb-target="#DeleteModal" type="button" data-roomid="' . $row["room_id"] . '">Delete</button></div>';
                                        echo '</div></td>';
                                        echo '<td class="text-center"><p class="fw-bold mb-1">' . $row["room_id"] . '</p></td>';
                                        if ($row["room_type"] == 'Standard') {
                                            echo '<td class="text-center"><span value="Standard" id="roomtype_' . $row["room_id"] . '" class="badge badge-primary rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        } elseif ($row["room_type"] == 'Deluxe') {
                                            echo '<td class="text-center"><span value="Deluxe" id="roomtype_' . $row["room_id"] . '" class="badge badge-success rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        } elseif ($row["room_type"] == 'Suite') {
                                            echo '<td class="text-center"><span value="Suite" id="roomtype_' . $row["room_id"] . '" class="badge badge-danger rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        } elseif ($row["room_type"] == 'Executive') {
                                            echo '<td class="text-center"><span value="Executive" id="roomtype_' . $row["room_id"] . '" class="badge badge-warning rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        }  else {
                                            echo '<td class="text-center"><span value="Family" id="roomtype_' . $row["room_id"] . '" class="badge badge-info rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                                        }
                                        echo '<td class="text-center"><p class="text-muted mb-0" id="roomsize_' . $row["room_id"] . '">' . $row["size"] . ' sqm</p></td>';
                                        if ($row["bed_type"] == 'Single') {
                                            echo '<td class="text-center"><span id="bedtype_' . $row["room_id"] . '" class="badge rounded-pill d-inline" style="background-color: #C2185B;">' . $row["bed_type"] . '</span></td>';
                                        } elseif ($row["bed_type"] == 'Double') {
                                            echo '<td class="text-center"><span id="bedtype_' . $row["room_id"] . '" class="badge rounded-pill d-inline" style="background-color: #D32F2F;">' . $row["bed_type"] . '</span></td>';
                                        } elseif ($row["bed_type"] == 'Twin') {
                                            echo '<td class="text-center"><span id="bedtype_' . $row["room_id"] . '" class="badge rounded-pill d-inline" style="background-color: #7B1FA2;">' . $row["bed_type"] . '</span></td>';
                                        } elseif ($row["bed_type"] == 'King') {
                                            echo '<td class="text-center"><span id="bedtype_' . $row["room_id"] . '" class="badge rounded-pill d-inline" style="background-color: #00796B;">' . $row["bed_type"] . '</span></td>';
                                        }  else {
                                            echo '<td class="text-center"><span id="bedtype_' . $row["room_id"] . '" class="badge rounded-pill d-inline" style="background-color: #00BFA5;">' . $row["bed_type"] . '</span></td>';
                                        }
                                        echo '<td class="text-center"><p id="capacity_' . $row["room_id"] . '" class="text-muted mb-0">' . $row["capacity"] . ' people</p></td>';
                                        echo '<td class="text-center"><p id="price_' . $row["room_id"] . '" class="text-muted mb-0">' . $row["price_per_night"] . ' $</p></td>';
                                        echo '<td class="text-center"><p id="facility_' . $row["room_id"] . '" class="text-muted mb-0 text-truncate" style="max-width: 150px; white-space: normal;">' . $row["facility"] . '</p></td>';
                                        echo '<td class="text-center"><img src="' . $row["room_img"] . '"style="width: 45px; height: 45px" class="rounded-circle"/></td>';
                                        echo '<input id="roomimg_' . $row["room_id"] . '" value="' . $row["room_img"] . '" hidden/>';
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
    <script src="../static/manage_room.js"></script>
</body>

</html>