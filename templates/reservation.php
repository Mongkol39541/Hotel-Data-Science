<?php

session_start();
$open_connect = 1;
require("connect.php");
if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die(header("Location: ../index.php"));
} elseif(isset($_GET['logout'])){
    session_destroy();
    mysqli_close($conn);
    die(header("Location: ../index.php"));
}

$email = $_SESSION['email_account'];
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);

if(isset($_GET['type'])) {
    $selectedRoom = $_GET['type'];
    $_SESSION['roomtype'] = $selectedRoom;
    $roomtype = $selectedRoom;
}

if(isset($_GET['bed'])) {
    $selectedBed = $_GET['bed'];
    $_SESSION['bedtype'] = $selectedBed;
    $bedtype = $selectedBed;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Making a reservation</title>
    <link rel="icon" href="../static/logoimage.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <link rel="stylesheet" href="../static/main.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
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
                            <i class="fas fa-user"></i> <?php echo $email ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="account.php?logout=1"><i class="fas fa-arrow-right-to-bracket me-1"></i> Log out</a></li>
                        </ul>
                    </div>
                    <a role="button" class="btn btn-secondary btn-lg px-3 me-2 book-nav" href="showres.php">My Booking</a>
                </div>
            </div>
        </div>
    </nav>
    </header>
    <?php
    $sqlroom = "SELECT *
    FROM room
    WHERE room_type = '$roomtype' AND bed_type = '$bedtype';";
    $result = mysqli_query($conn, $sqlroom);
    $row = mysqli_fetch_array($result);
    $room_img = $row['room_img'];
    $price_per_night = $row['price_per_night'];
    $facility = $row['facility'];
    $description = $row['room_description'];
    $size = $row['size'];
    ?>
    <main style="margin-top: 100px">
    <div class='container'>
        <div class='row justify-content-center gap-4'>
            <div class='h-50 card border border-secondary border-1 mb-2 col-md-5'>
                <img src="<?php echo $room_img?>" class="card-img-top" alt="room-img"/>
                <div class='card-body'>
                    <h3 class="card-title mb-2"><?php echo $roomtype . ' ' . $bedtype?></h3>
                    <div>
                        <p class='card-text'>Room size: <?php echo $size?></p>
                    </div>
                    <div>
                        <p class='card-text'>Facility services include: <?php echo $facility?></p>
                    </div>
                    <div>
                        <p class='card-text'>Description services include: <?php echo $description?></p>
                    </div>
                    <div>
                        <p class='card-text'>Price per night: <?php echo $price_per_night?> THB</p>
                    </div>
                </div>
            </div>
            <div class='card border border-secondary border-1 col-md-5'>
                <h3 class='card-header mt-3 text-center'>Your details</h3>
                <hr>
                <div clas='card-body'>
                    <div class='card-text'>
                        <div class='mb-2'>
                            <div class='mb-4'>
                                <input type="text" name="datefilter" id='datefilter' value="" class='form-control' required 
                                placeholder='Check-in/Check out dates'>
                                <div class='invalid-feedback'>
                                    Please provide Check in and Check out date.
                                </div>
                            </div>
                            <div class='mb-3'>
                                <button type="submit" onclick='datecheck(document.getElementById("datefilter").value);'
                                class="btn btn-primary" name="confirm_date" id="confirm_date">Confirm date</button>
                            </div>
                            <div name='result' id='result'>
                            </div>
                            <script>
                                function datecheck(date) {
                                    $.ajax({
                                        type: "POST",
                                        url: "timecheck.php",
                                        data: {datefilter: date},
                                        success: function(result) {
                                            $("#result").html(result);
                                        }
                                    });
                                };
                            </script>
                            <script src="../static/calendar.js" type='text/javascript'></script> 
                        </div>
                        <form  id='reservation' method="post" action='sending_to_payment.php' novalidate class='needs-validation'>
                        <div class='form-check mb-2'>
                            <input type="checkbox" class="form-check-input" id="use-member-address" name="use-member-address">
                            <label for="use-member-address">Use member address</label>
                        </div>
                        <div id='guest-info'>
                            <div class='row mb-3'>
                                <div class ='col-md-6'>
                                    <input type="text" class='form-control' name="fname" id="fname" placeholder='First Name' required>
                                    <div class='invalid-feedback'>
                                        Please enter a First Name.
                                    </div>
                                </div>  
                                <div class ='col-md-6'>
                                    <input type="text" class='form-control' name="lname" id="lname" placeholder='Last Name' required>
                                    <div class="invalid-feedback">
                                        Please enter a Last Name.
                                    </div>
                                </div>
                            </div>
                            <div class='mb-4'>
                                <input type="tel" class='form-control' name="phone" id="phone" placeholder='Phone' required>
                                <div class="invalid-feedback">
                                    Please provide a phone number.
                                </div>
                            </div>
                            <div class='mb-4'>
                                <input type="email" class='form-control' name="email" id="email" placeholder='Email' required>
                                <div class="invalid-feedback">
                                    Please provide an email.
                                </div>
                            </div>
                            <div class='mb-4'>
                                <textarea name="address" class='form-control' id="address" cols="30" rows="5" placeholder='Address' required></textarea>
                                <div class="invalid-feedback">
                                    Please provide an address.
                                </div>
                            </div>
                            <div class='mb-3'>
                                <button type="submit" class="btn btn-primary" name="submit" id="submit">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    </main>

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>

    <script src="../static/terriblefix.js"></script> 
    <script src="../static/validitycheckforform.js"></script> 
    <script>
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });
        <?php
        if (isset($_SESSION['loginSuccess'])) {
            echo '   var alertText = "' . $_SESSION['loginSuccess'] . '";';
            echo '   var alertDiv = \'';
            echo '   <div class="alert alert-success position-fixed top-0 start-50 translate-middle-x w-25" style="margin-top:7%;" role="alert" data-mdb-color="success" data-mdb-offset="20">';
            echo '        <i class="fas fa-check-circle me-3"></i> \' + alertText + \'';
            echo '    </div>\';';
            echo '   $("body").append(alertDiv);';
            echo '   setTimeout(function() {';
            echo '       $(".alert").remove();';
            echo '   }, 4000);';
            unset($_SESSION['loginSuccess']);
        }
        ?>
    </script>
</body>
</html>