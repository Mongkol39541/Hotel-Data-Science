<!-- Reservation -->

<?php
// จัดการ session ควบคุมสิทธิการเข้าใช้งาน
session_start();
unset($_SESSION["datefilter"]);
$open_connect = 1;
require("connect.php");

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die(header("Location: index.php")); //ถ้าไม่มี session ที่สร้างจากระบบlogin จะถูกนำทางกลับไปหน้าหลัก
} elseif(isset($_GET['logout'])){
    session_destroy();
    mysqli_close($conn);
    die(header("Location: index.php"));
}

if(isset($_GET['res_id'])) {
    $res_id = htmlspecialchars($_GET['res_id']);
} else {
    die(header("Location: account.php"));
}

$email = $_SESSION['email_account'];

// ดึงข้อมูลประเภทห้องพัก
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Detail</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <!-- ajax -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

    <style>
        .book-nav {
            border-radius: 0px;
            font-weight: 600;
        }

        .book-nav:hover {
            background: #193460;
            color: #fff;
        }

        .navbar-nav li a {
            color: rgb(72, 72, 72);
        }

        .navbar-nav li a:hover {
            color: #54B4D3;
        }

        @media (min-width: 991px) {
            .dropdown:hover>.dropdown-menu {
                display: block;
                margin-top: 0;
            }

            #navbarButtonsExample {
                margin-left: 20px;
            }
        }

        @media (max-width: 991px) {

            .navbar-nav .nav-item.dropdown .dropdown-menu {
                position: static;
                float: none;
                width: auto;
                margin-top: 0;
                box-shadow: none;
            }

            .navbar-nav .nav-link {
                font-size: 1rem;
                position: relative;
            }

            #firstmenu {
                border-top: 1px solid #eee;
            }

            .user-nav,
            .book-nav {
                margin-bottom: 5px;
            }
        }

        .carousel-inner .carousel-item {
            transition: 2s ease-in-out; /* 1s = 1 second */
        }
    </style>
</head>
<body>
    <header>
        <?php
        require("img/account-nav.php");
        ?>
    </header>

    <!-- showing room deail fom res_ID -->
    <?php
    $res_sql = "SELECT *
    FROM reservation r
    JOIN guest g
    ON (r.reserve_id = g.reserve_id)
    JOIN room rm
    ON (r.room_id = rm.room_id)
    JOIN transaction t
    ON (t.reserve_id = r.reserve_id)
    WHERE r.reserve_id = '$res_id';";
    $selectRES_room = mysqli_query($conn, $res_sql);
    $data = mysqli_fetch_assoc($selectRES_room);
    $room_img = $data['room_img'];
    $roomtype = $data['room_type'];
    $bedtype = $data['bed_type'];
    $price_per_night = $data['price_per_night'];
    $desc = $data['room_description'];
    $size = $data['size'];
    $check_in = $data['check_in'];
    $check_out = $data['check_out'];
    $fname = $data['first_name'];
    $lname = $data['last_name'];
    $phone = $data['phone'];
    $res_made = $data['reserve_time'];
    $total_paid = $data['total_price'];
    $res_email = $data['email'];
    $check_in_final = str_replace('-','/',$check_in);
    $check_out_final = str_replace('-','/',$check_out);
    ?>
    <main style="margin-top: 100px">
        <div class='container'>
            <div class='row justify-content-center gap-4'>
                <div class='card border border-secondary border-1 mb-2 col-md-5'>
                    <img src="<?php echo $room_img?>" class="card-img-top" alt="room-img"/>
                    <div class='card-body'>
                        <h3 class="card-title mb-2"><?php echo $roomtype . ' ' . $bedtype?></h3>
                        <div class='mb-2'>
                            <p class='card-text'><?php echo $desc?></p>
                        </div>
                        <div>
                            <p class='card-text'>Room size: <?php echo $size?></p>
                        </div>
                        <div class='mb-2'>
                            <p class='card-text'>Price per night: <?php echo $price_per_night?> THB</p>
                        </div>
                        <div>
                            <p class='card-text fw-bold'>Reservation Made: <?php echo $res_made?></p>
                        </div>
                        <div>
                            <p class='card-text fw-bold'>Total Price: <?php echo $total_paid?> THB</p>
                        </div>
                    </div>
                </div>
                <div class='card border border-secondary border-1 col-md-5 h-50'>
                    <h3 class='card-header mt-3 text-center'>Your details</h3>
                    <hr>
                    <form  id='reservation' method="post" action='payment.php' novalidate class='.needs-validation'>
                    <div clas='card-body'>
                        <div class='card-text'>
                            <div class='mb-2'>
                                    <div class='mb-4'>
                                        <input type="text" name="date_editor" id='date_editor' value="" 
                                        class='form-control' autocomplete="off disable"
                                        required placeholder='Check-in/Check out dates' disabled>
                                        <div class='invalid-feedback'>
                                        Please provide Check in and Check out date.
                                        </div>
                                    </div>
                                    <div class='mb-3' id='date_button' name='date_button'>
                                    </div>
                                    <div name='result' id='result'>
                                    </div>
                                </div>
                            <!-- use member address instead -->
                            <div class='form-check mb-2'>
                                <input type="checkbox" class="form-check-input" id="use-member-address" name="use-member-address" disabled>
                                <label for="use-member-address">Use member address</label>
                            </div>
                            <!-- information will be sent to guestdb later -->
                            <div id='guest-info'>
                                <div class='row mb-3'>
                                    <div class ='col-md-6'>
                                        <input type="text" class='form-control' name="fname" id="fname" placeholder='First Name' 
                                        value='<?php echo $fname ?>' required disabled>
                                        <div class='invalid-feedback'>
                                            Please enter a First Name.
                                        </div>
                                    </div>  
                                    <div class ='col-md-6'>
                                        <input type="text" class='form-control' name="lname" id="lname" placeholder='Last Name' 
                                        value='<?php echo $lname ?>' required disabled>
                                        <div class="invalid-feedback">
                                            Please enter a Last Name.
                                        </div>
                                    </div>
                                </div>
                                <div class='mb-4'>
                                    <input type="tel" class='form-control' name="phone" id="phone" placeholder='Phone' 
                                    value='<?php echo $phone ?>'required disabled>
                                    <div class="invalid-feedback">
                                        Please provide a phone number.
                                    </div>
                                </div>
                                <div class='mb-4'>
                                    <input type="email" class='form-control' name="email" id="email" placeholder='Email' 
                                    value='<?php echo $res_email ?>'required disabled>
                                    <div class="invalid-feedback">
                                        Please provide an email.
                                    </div>
                                </div>
                                <div class='mb-4' id='submit-button' name='submit-button'>
                                </div>
                                <div class='mb-4' name='lowest_button' id='lowest_button'>
                                    <button type="button" class="btn btn-primary" name="edit" id="edit" onclick='edit_info()'>Edit Information</button>
                                    <button type="button" class="btn btn-danger" name="delete" id="delete">Cancel Reservation</button>
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <?php echo $check_in_final . ' - ' . $check_in_final?>
    <script>
        $('#date_editor').daterangepicker({
            "locale": {
                "format": "YYYY/MM/DD"
            },
            "showCustomRangeLabel": false,
            "startDate": "<?php echo $check_in_final ?>",
            "endDate": "<?php echo $check_out_final ?>",
            "opens": "center"
        });
    </script>

    <!-- too lazy to write for loop lol -->
    <script src="manage_res.js" type='text/javascript'></script>

    <!-- copied pasted from docs for validitiy check in bootstrap style -->
    <script src="validitycheckforform.js" type='text/javascript'></script> 

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

    <?php
    // close connection
    mysqli_close($conn);
    ?>
</body>
</html>