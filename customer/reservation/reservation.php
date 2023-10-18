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
                    <img src="../static/logo.png" width="40" alt="Hotel Data Science Logo" />
                    <h3 class="pt-2"><span class="navbar-text px-2">HTDS</span></h3>
                </a>
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
                    aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="navbar-nav ms-auto d-flex flex-row">
                    <a class="nav-link me-3 me-lg-0" href="#">
                        <img src="../static/M088.jpg" class="rounded-circle" height="30" />
                    </a>
                </ul>
            </div>
        </nav>
    </header>
    <!-- TODO: navbar, proper calendar, proper form -->
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
    <main style="margin-top: 100px">
    <div class='text-center'>
        lorem ipsum
    </div>
    <hr>
    <form  id='timecheck' action="timechecktest.php" method="post">
    <div class='container'>
        <div class='row'>
            <div class='text-center col-md-6'>
                <div class='card mt-3'>
                    test
                </div>
            </div>
            <div class='card border border-secondary border-1 mb-3 col-md-6'>
                <h3 class='card-header mt-3 text-center'>Your details</h3>
                <hr>
                <div clas='card-body'>
                    <div class='card-text'>
                    <!-- select a room type and size -->
                        <div class='text-start md'>
                            <label for="room">placeholder</label>
                            <select name='room'>
                                <!-- showing room list -->
                                <!-- อาจจะย้ายส่วนนี้ไปข้างนอก -->
                            <?php
                            $sql = "SELECT DISTINCT room_type, bed_type FROM room;";
                            $result = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_assoc($result)) {
                                $roomtype = $row['room_type'];
                                $bedtype = $row['bed_type'];
                                echo "<option value='$roomtype|$bedtype' name=''>".htmlspecialchars($roomtype)." ".htmlspecialchars($bedtype)."</option>";
                            }
                            mysqli_close($conn);
                            ?>
                            </select>
                        </div>
                        <br>
                        <div class='mb-2'>
                            <!-- daterangepicker -->       
                            <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
                            <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
                            <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
                            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

                            <input type="text" name="datefilter" value="" class='form-control'/>

                            <script type="text/javascript">
                            $(function() {

                            $('input[name="datefilter"]').daterangepicker({
                                autoUpdateInput: false,
                                opens: 'center',
                                locale: {
                                    cancelLabel: 'Clear'
                                }
                            });

                            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                                $(this).val(picker.startDate.format('YYYY/MM/DD') + ' - ' + picker.endDate.format('YYYY/MM/DD'));
                            });

                            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                                $(this).val('');
                            });

                            });
                            </script>
                        </div>
                        <!-- use member address instead -->
                        <div class='form-check mb-2'>
                            <input type="checkbox" class="form-check-input" id="use-member-address" name="use-member-address">
                            <label for="use-member-address">Use member address</label>
                        </div>
                        <!-- information will be sent to guestdb later -->
                        <div id='guest-info'>
                            <div class='row mb-2'>
                                <div class ='col-md-6'>
                                    <div class='form-outline'>
                                        <input type="text" class='form-control' name="fname" id="fname">
                                        <label class="form-label" for="fname" required>First name</label>
                                    </div>
                                </div>
                                <div class ='col-md-6'>
                                    <div class='form-outline'>
                                        <input type="text" class='form-control' name="lname" id="lname">
                                        <label class="form-label" for="lname" required>Last name</label>
                                    </div>
                                </div>
                            </div>
                            <div class='mb-2'>
                                <div class='form-outline'>
                                    <input type="tel" class='form-control' name="phone" id="phone">
                                    <label class="form-label" for="phone" required>Phone</label>
                                </div>
                            </div>
                            <div class='mb-2'>
                                <div class='form-outline'>
                                    <input type="email" class='form-control' name="email" id="email">
                                    <label class="form-label" for="email" required>Email</label>
                                </div>
                            </div>
                            <div class='mb-2'>
                                <div class='form-outline'>
                                    <textarea name="address" class='form-control' id="address" cols="30" rows="5"></textarea>
                                    <label class="form-label" for="address" required>Address</label>
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
    <!-- terrible code -->
    <script>
        $('#use-member-address').change(function() {
        if(this.checked) {
            $('#fname').prop('disabled',true);
            $('#lname').prop('disabled',true);
            $('#phone').prop('disabled',true);
            $('#email').prop('disabled',true);
            $('#address').prop('disabled',true);
        } else {
            $('#fname').prop('disabled',false);
            $('#lname').prop('disabled',false);
            $('#phone').prop('disabled',false);
            $('#email').prop('disabled',false);
            $('#address').prop('disabled',false);
        }
        });
        // fixing no border in input
        document.querySelectorAll('.form-outline').forEach((formOutline) => {
        new mdb.Input(formOutline).init();
        });
    </script>
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