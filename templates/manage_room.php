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
                <a href="reserva.php" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
                </a>
                <a href="room_status.php" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="fas fa-list-check fa-fw me-3"></i><span>Room info.</span></a>
                <?php
                    if($_SESSION['role_account'] == "owner") {
                    echo '<a href="dashboard.php" class="list-group-item list-group-item-action py-2 ripple"><i class="fas fa-chart-line fa-fw me-3"></i><span>Dashboard</span></a>';
                    echo '<a href="manage_room.php" class="list-group-item list-group-item-action py-2 ripple active" ><i class="fa-solid fa-network-wired fa-fw me-3"></i><span>Manage Room</span></a>';
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
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarButtonsExample"
                aria-controls="navbarButtonsExample" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarButtonsExample">
                <div class="d-flex align-items-center">
                    <div class="btn-group shadow-none me-4 user-nav">
                        <a role="button" class="dropdown-toggle text-dark" data-mdb-toggle="dropdown" aria-expanded="false">
                            <img src="../static/<?php echo $menber_id; ?>.jpg" class="rounded-circle" height="25" />
                            <?php echo $email ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="account.php?logout=1"><i
                                class="fas fa-arrow-right-to-bracket me-1"></i> Log out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
  </header>

    <main style="margin-top: 58px">
        <div class="text-center bg-image"
            style="background-image: url('../static/quickbooks-beginners.jpg');height: 450px;">
            <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
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
                    $formdescription = $_POST['formdescription'];
                    $formfacility = $_POST['formfacility'];
                    $formImage = $_POST['formImage'];
                    $sql = "INSERT INTO room (room_id, room_type, size, bed_type, capacity, price_per_night, facility, room_description, room_img) VALUES ('$randomID', '$formType', '$formSize', '$formBed', '$formCapacity', '$formPrice', '$formdescription', '$formfacility', '$formImage')";
                    try {
                        if (preg_match('/^ROOM_00\d+$/', $randomID)) {
                            $conn->query($sql);
                            $text = 'ID: ' . $randomID . ' 🎉 <strong>Congratulations, you have successfully insert your room information.</strong>';
                            echo <<<EOT
                                <script>
                                    var alertDiv = document.createElement('div');
                                    alertDiv.classList.add('alert', 'alert-success', 'position-fixed');
                                    alertDiv.style.top = '50%';
                                    alertDiv.style.left = '50%';
                                    alertDiv.style.transform = 'translate(-50%, -50%)';
                                    alertDiv.style.zIndex = '102';
                                    alertDiv.setAttribute('role', 'alert');
                                    alertDiv.setAttribute('data-mdb-color', 'success');
                                    alertDiv.setAttribute('data-mdb-offset', '20');
                                    alertDiv.innerHTML = `
                                        <i class="fas fa-check me-2"></i> {$text}
                                    `;

                                    document.body.appendChild(alertDiv);
                                    setTimeout(function() {
                                        alertDiv.remove();
                                    }, 5000);
                                </script>
                                EOT;
                        }
                    } catch (mysqli_sql_exception $e) {
                        $text = "Error: " . $sql . "<br>" . $conn->error;
                        echo <<<EOT
                            <script>
                                var alertDiv = document.createElement('div');
                                alertDiv.classList.add('alert', 'alert-danger', 'position-fixed');
                                alertDiv.style.top = '50%';
                                alertDiv.style.left = '50%';
                                alertDiv.style.transform = 'translate(-50%, -50%)';
                                alertDiv.style.zIndex = '102';
                                alertDiv.setAttribute('role', 'alert');
                                alertDiv.setAttribute('data-mdb-color', 'danger');
                                alertDiv.setAttribute('data-mdb-offset', '20');
                                alertDiv.innerHTML = `
                                    <i class="fas fa-check me-2"></i> {$text}
                                `;

                                document.body.appendChild(alertDiv);
                                setTimeout(function() {
                                    alertDiv.remove();
                                }, 5000);
                            </script>
                            EOT;
                    }
                    mysqli_close($conn);
                } elseif ($chang == "Update") {
                    $randomID = $_POST['formID'];
                    $formType = $_POST['formType'];
                    $formPrice = $_POST['formPrice'];
                    $formSize = $_POST['formSize'];
                    $formBed = $_POST['formBed'];
                    $formCapacity = $_POST['formCapacity'];
                    $formdescription = $_POST['formdescription'];
                    $formfacility = $_POST['formfacility'];
                    $formImage = $_POST['formImage'];
                    $sql = "UPDATE room SET room_type = '$formType', size = '$formSize', bed_type = '$formBed', capacity = '$formCapacity', price_per_night = '$formPrice', facility = '$formfacility', room_description = '$formdescription', room_img = '$formImage' WHERE room_id = '$randomID'";
                    try {
                        if ($conn->query($sql)) {
                            $text = 'ID: ' . $randomID . ' 🎉 <strong>Congratulations, you have successfully updated your room information.</strong>';
                            echo <<<EOT
                                <script>
                                    var alertDiv = document.createElement('div');
                                    alertDiv.classList.add('alert', 'alert-success', 'position-fixed');
                                    alertDiv.style.top = '50%';
                                    alertDiv.style.left = '50%';
                                    alertDiv.style.transform = 'translate(-50%, -50%)';
                                    alertDiv.style.zIndex = '102';
                                    alertDiv.setAttribute('role', 'alert');
                                    alertDiv.setAttribute('data-mdb-color', 'success');
                                    alertDiv.setAttribute('data-mdb-offset', '20');
                                    alertDiv.innerHTML = `
                                        <i class="fas fa-check me-2"></i> {$text}
                                    `;

                                    document.body.appendChild(alertDiv);
                                    setTimeout(function() {
                                        alertDiv.remove();
                                    }, 5000);
                                </script>
                                EOT;
                        }
                    } catch (mysqli_sql_exception $e) {
                        $text = "Error: " . $sql . "<br>" . $conn->error;
                        echo <<<EOT
                            <script>
                                var alertDiv = document.createElement('div');
                                alertDiv.classList.add('alert', 'alert-danger', 'position-fixed');
                                alertDiv.style.top = '50%';
                                alertDiv.style.left = '50%';
                                alertDiv.style.transform = 'translate(-50%, -50%)';
                                alertDiv.style.zIndex = '102';
                                alertDiv.setAttribute('role', 'alert');
                                alertDiv.setAttribute('data-mdb-color', 'danger');
                                alertDiv.setAttribute('data-mdb-offset', '20');
                                alertDiv.innerHTML = `
                                    <i class="fas fa-check me-2"></i> {$text}
                                `;

                                document.body.appendChild(alertDiv);
                                setTimeout(function() {
                                    alertDiv.remove();
                                }, 5000);
                            </script>
                            EOT;
                    }
                    mysqli_close($conn);
                } elseif ($chang == "Delete") {
                    $randomID = $_POST['formID'];
                    $sql = "DELETE FROM room WHERE room_id = '$randomID'";
                    try {
                        if ($conn->query($sql)) {
                            $text = 'ID: ' . $randomID . ' 🎉 <strong>Congratulations, you have successfully delete your room information.</strong>';
                            echo <<<EOT
                                <script>
                                    var alertDiv = document.createElement('div');
                                    alertDiv.classList.add('alert', 'alert-success', 'position-fixed');
                                    alertDiv.style.top = '50%';
                                    alertDiv.style.left = '50%';
                                    alertDiv.style.transform = 'translate(-50%, -50%)';
                                    alertDiv.style.zIndex = '102';
                                    alertDiv.setAttribute('role', 'alert');
                                    alertDiv.setAttribute('data-mdb-color', 'success');
                                    alertDiv.setAttribute('data-mdb-offset', '20');
                                    alertDiv.innerHTML = `
                                        <i class="fas fa-check me-2"></i> {$text}
                                    `;

                                    document.body.appendChild(alertDiv);
                                    setTimeout(function() {
                                        alertDiv.remove();
                                    }, 5000);
                                </script>
                                EOT;
                        }
                    } catch (mysqli_sql_exception $e) {
                        $text = "Error: " . $sql . "<br>" . $conn->error;
                        echo <<<EOT
                            <script>
                                var alertDiv = document.createElement('div');
                                alertDiv.classList.add('alert', 'alert-danger', 'position-fixed');
                                alertDiv.style.top = '50%';
                                alertDiv.style.left = '50%';
                                alertDiv.style.transform = 'translate(-50%, -50%)';
                                alertDiv.style.zIndex = '102';
                                alertDiv.setAttribute('role', 'alert');
                                alertDiv.setAttribute('data-mdb-color', 'danger');
                                alertDiv.setAttribute('data-mdb-offset', '20');
                                alertDiv.innerHTML = `
                                    <i class="fas fa-check me-2"></i> {$text}
                                `;

                                document.body.appendChild(alertDiv);
                                setTimeout(function() {
                                    alertDiv.remove();
                                }, 5000);
                            </script>
                            EOT;
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
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room ID</label>
                                            <input type="text" class="form-control" name="formID" required/>
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
                                    </div>
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room Size (SQM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">SQM</span>
                                                <input type="number" class="form-control" name="formSize" required min="5" max="100" />
                                                <div class="invalid-tooltip">Please provide a valid size.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                            <label class="form-label">Facility</label>
                                            <div class="form">
                                                <textarea name="formfacility" class="form-control" rows="4" required></textarea>
                                                <div class="invalid-tooltip">Please provide a valid facility.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Description</label>
                                            <div class="form">
                                                <textarea name="formdescription" class="form-control" rows="4" required></textarea>
                                                <div class="invalid-tooltip">Please provide a valid description.</div>
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
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room ID</label>
                                            <input type="text" class="form-control" name="formID" id="formID" required/>
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
                                    </div>
                                    <div class="col">
                                        <div class="form mb-5">
                                            <label class="form-label">Room Size (SQM)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">SQM</span>
                                                <input type="number" class="form-control" name="formSize" id="formSize" required min="5" max="100" />
                                                <div class="invalid-tooltip">Please provide a valid size.</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
                                            <label class="form-label">Facility</label>
                                            <div class="form">
                                                <textarea name="formfacility" class="form-control" rows="4" id="formfacility" required></textarea>
                                                <div class="invalid-tooltip">Please provide a valid facility.</div>
                                            </div>
                                        </div>
                                        <div class="form mb-5">
                                            <label class="form-label">Description</label>
                                            <div class="form">
                                                <textarea name="formdescription" class="form-control" rows="4" id="formdescription" required></textarea>
                                                <div class="invalid-tooltip">Please provide a valid description.</div>
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
                                <i class="fa-solid fa-xmark fa-5x text-danger"></i>
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
                                        <th class="text-center">ID</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Size</th>
                                        <th class="text-center">Bed</th>
                                        <th class="text-center">Capacity</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Facility</th>
                                        <th class="text-center">Description</th>
                                        <th class="text-center">Img</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                $servername = "localhost";
                                $username = "root";
                                $password = "";
                                $dbname = "9hotel_reservation";
                                $conn = mysqli_connect($servername, $username, $password, $dbname);
                                $sql = "SELECT room_id, room_type, size, bed_type, capacity, price_per_night, facility, room_img, room_description FROM `room`;";
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
                                        $facility = $row["facility"];
                                        $maxLength = 50;
                                        if (strlen($facility) > $maxLength) {
                                            $facility = substr($facility, 0, $maxLength) . '...';
                                        }
                                        echo '<td class="text-center"><p class="text-muted mb-0">' . $facility . '</p></td>';
                                        echo '<input id="facility_' . $row["room_id"] . '" value="' . $row["facility"] . '" hidden>';
                                        $room_description = $row["room_description"];
                                        $maxLength = 50;
                                        if (strlen($room_description) > $maxLength) {
                                            $room_description = substr($room_description, 0, $maxLength) . '...';
                                        }
                                        echo '<td class="text-center"><p class="text-muted mb-0">' . $room_description . '</p></td>';
                                        echo '<input id="description_' . $row["room_id"] . '" value="' . $row["room_description"] . '" hidden>';
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

        <div id="animation3" class="transportations p-reg cb-b2 s-combo-default s-combo-default" id="animation12">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
    <script src="../static/manage_room.js"></script>
    <script>
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });
    </script>
</body>

</html>