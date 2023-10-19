<!-- connect to a session -->
<?php
    session_start();
    $open_connect = 1;
    require("../home/connect.php");
?>
<!-- ยังหาทาง inregrate ไม่ได้ hardcode ไปก่อน จะเขียน ui -->
<!-- TODO: integrate กับ user authentication, room details from roomdetails -->
<?php
$roomtype = $_SESSION['room_type'];
$bedtype = $_SESSION['bed_type'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation</title>
    <link rel="stylesheet" href="static/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="../img/logo.png" height="42" alt="Hotel Logo" loading="lazy" style="margin-top: -1px;" />
                </a>
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <a class="nav-link me-3 me-lg-0" href="#">
                        <img src="../static/M088.jpg" class="rounded-circle" height="30" />
                    </a>
                </ul>
            </div>
        </nav>
    </header>
    <!-- connect to a server -->
    <!-- TODO: connect to the uni's server instead of the local -->
    <?php
    $servername = "localhost";
    $username = "root"; //ตามที่กำหนดให้
    $password = ""; //ตามที่กำหนดให้
    $dbname = "9hotel_reservation";    //ตามที่กำหนดให้
    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    ?>
    <!-- finding occupied -->
    <?php
    $sql = "SELECT *
    FROM room
    WHERE room_type = '$roomtype' AND bed_type = '$bedtype';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result); //idk how this works, but it returns only the first result in the array lol
    $room_img = $row['room_img'];
    $price_per_night = $row['price_per_night'];
    $facility = $row['facility'];
    $size = $row['size'];
    ?>
    <main style="margin-top: 100px">
    <div class='container'>
        <div class='row justify-content-center gap-4'>
            <div class='h-50 card border border-secondary border-1 mb-2 col-md-5'>
                <img src="<?php echo $room_img?>" class="card-img-top" alt="test"/>
                <div class='card-body'>
                    <h3 class="card-title mb-2"><?php echo $roomtype . ' ' . $bedtype?></h3>
                    <div>
                        <p class='card-text'>Room size: <?php echo $size?></p>
                    </div>
                    <div>
                        <p class='card-text'>Facility services include: <?php echo $facility?></p>
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
                            <!-- daterangepicker -->
                            <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
                            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
                            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
                            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                            <div name='test' id='test'>
                            </div>
                            <script>
                                function datecheck(date) {
                                    $.ajax({
                                        type: "POST",
                                        url: "timecheck.php",
                                        data: {datefilter: date},
                                        success: function(result) {
                                            $("#test").html(result);
                                        }
                                    });
                                };
                            </script>
                            <script src="calendar.js" type='text/javascript'></script> 
                        </div>
                        <form  id='reservation' method="post" action='sending_to_payment.php' novalidate class='needs-validation'>
                        <!-- use member address instead -->
                        <div class='form-check mb-2'>
                            <input type="checkbox" class="form-check-input" id="use-member-address" name="use-member-address">
                            <label for="use-member-address">Use member address</label>
                        </div>
                        <!-- information will be sent to guestdb later -->
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
    <!-- too lazy to write for loop lol -->
    <script src="terriblefix.js"></script> 
    <!-- copied pasted from docs for validitiy check in bootstrap style -->
    <script src="validitycheckforform.js"></script> 
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
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2023 Copyright:
            <a class="text-reset fw-bold" href="#">HTDS.com</a>
        </div>
    </footer>
  <!--Footer-->
</body>
</html>