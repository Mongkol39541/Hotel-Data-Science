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

$email = $_SESSION['email_account'];

// ดึงข้อมูลประเภทห้องพัก
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);

// ตรวจสอบว่ามีข้อมูลที่ถูกส่งมาหรือไม่
if(isset($_POST['type'])) {
    // รับข้อมูลจาก POST
    $selectedRoom = $_POST['type'];
    $_SESSION['roomtype'] = $selectedRoom;
    $roomtype = $selectedRoom;
} else {
    // ถ้าไม่มีข้อมูลถูกส่งมา
}

if(isset($_POST['bed'])) {
    // รับข้อมูลจาก POST
    $selectedBed = $_POST['bed'];
    $_SESSION['bedtype'] = $selectedBed;
    $bedtype = $selectedBed;
} else {
    // ถ้าไม่มีข้อมูลถูกส่งมา
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Making a reservation</title>

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
    
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "9hotel_reservation";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    ?>

    <?php
    $reservations = array();
    $sql = "SELECT reservation.check_in, reservation.check_out FROM reservation JOIN room USING (room_id) WHERE room.room_type = '$roomtype' AND room.bed_type = '$bedtype';";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservations[] = $row;
        }
    }
    ?>

    <div class="container mt-4 text-center"> 
    <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#modcalend">
        Show Calender
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modcalend" tabindex="-1" aria-labelledby="modcalendLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="modcalendLabel">Room booking calender</h2>
                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"> 
                    <center>
                    <div class="card">
                        <div class="card-body">
                            <div id="calendarContainer">
                                <div id="calendarHeader">
                                    <div class="row">
                                        <div class="col">
                                            <button id="prevMonth" class="btn btn-primary">Prev. Month</button>
                                        </div>
                                        <div class="col">
                                            <h3 id="currentMonth"></h3>
                                        </div>
                                        <div class="col">
                                            <button id="nextMonth" class="btn btn-primary">Next Month</button>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="table-primary">Sun</th>
                                            <th class="table-primary">Mon</th>
                                            <th class="table-primary">Tue</th>
                                            <th class="table-primary">Wed</th>
                                            <th class="table-primary">Thu</th>
                                            <th class="table-primary">Fri</th>
                                            <th class="table-primary">Sat</th>
                                        </tr>
                                    </thead>
                                        <tbody id="calendarBody" class="text-center">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    </center>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const currentMonthElement = document.getElementById("currentMonth");
        const calendarBody = document.getElementById("calendarBody");

        const prevMonthButton = document.getElementById("prevMonth");
        const nextMonthButton = document.getElementById("nextMonth");

        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();

        function generateCalendar(year, month, reservations) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            let dayCounter = 1;
            let html = '';
            for (let i = 0; i < 6; i++) {
                html += '<tr>';
                for (let j = 0; j < 7; j++) {
                    const day = (i * 7 + j) - firstDay.getDay() + 1;
                    if (day > 0 && day <= lastDay.getDate()) {
                        const current_date = year + '-' + (month + 1).toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');
                        let status = 'Avaliable';
                        let color = 'success';

                        reservations.forEach(reservation => {
                            if (reservation.check_in <= current_date && current_date <= reservation.check_out) {
                                status = 'Unavaliable';
                                color = 'danger';
                            }
                        });
                        html += '<td class="table-' + color + '">' + day + '<br>' + status + '</td>';
                    } else if (dayCounter == 36) {
                        break;
                    } else {
                        html += '<td></td>';
                    }
                    dayCounter += 1;
                }
                html += '</tr>';
            }

            calendarBody.innerHTML = html;
        }

        function changeMonth(change) {
            currentMonth += change;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            currentDate.setFullYear(currentYear, currentMonth);
            generateCalendar(currentYear, currentMonth, <?php echo json_encode($reservations); ?>);
            currentMonthElement.textContent = currentYear + " - " + (currentMonth + 1);
        }

        generateCalendar(currentYear, currentMonth, <?php echo json_encode($reservations); ?>);
        currentMonthElement.textContent = currentYear + " - " + (currentMonth + 1);
        prevMonthButton.addEventListener("click", () => changeMonth(-1));
        nextMonthButton.addEventListener("click", () => changeMonth(1));
    });
    </script>
    <script
    type="text/javascript"
    src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
    ></script>

    <!-- finding occupied -->
    <?php
    $sqlroom = "SELECT *
    FROM room
    WHERE room_type = '$roomtype' AND bed_type = '$bedtype';";
    $result = mysqli_query($conn, $sqlroom);
    $row = mysqli_fetch_array($result); //idk how this works, but it returns only the first result in the array lol
    $room_img = $row['room_img'];
    $price_per_night = $row['price_per_night'];
    $desc = $row['room_description'];
    $size = $row['size'];
    ?>

    <div class='container mt-4'>
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
                    <div>
                        <p class='card-text'>Price per night: <?php echo $price_per_night?> THB</p>
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
                                    <input type="text" name="datefilter" id='datefilter' value="" 
                                    class='form-control' autocomplete="off"
                                    required placeholder='Check-in/Check out dates'>
                                    <div class='invalid-feedback'>
                                    Please provide Check in and Check out date.
                                    </div>
                                </div>
                                <div class='mb-3'>
                                    <button type="button" onclick='datecheck(document.getElementById("datefilter").value);'
                                    class="btn btn-primary" name="confirm_date" id="confirm_date">Confirm date</button>
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
                                    <input type="text" class='form-control' name="fname" id="fname" placeholder='First Name' required disabled>
                                    <div class='invalid-feedback'>
                                        Please enter a First Name.
                                    </div>
                                </div>  
                                <div class ='col-md-6'>
                                    <input type="text" class='form-control' name="lname" id="lname" placeholder='Last Name' required disabled>
                                    <div class="invalid-feedback">
                                        Please enter a Last Name.
                                    </div>
                                </div>
                            </div>
                            <div class='mb-4'>
                                <input type="tel" class='form-control' name="phone" id="phone" placeholder='Phone' required disabled>
                                <div class="invalid-feedback">
                                    Please provide a phone number.
                                </div>
                            </div>
                            <div class='mb-4'>
                                <input type="email" class='form-control' name="email" id="email" placeholder='Email' required disabled>
                                <div class="invalid-feedback">
                                    Please provide an email.
                                </div>
                            </div>
                            <div class='mb-4'>
                                <button type="submit" class="btn btn-primary" name="submit" id="submit" disabled>Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
   

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- daterangepicker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="calendar.js" type='text/javascript'></script>

    <!-- too lazy to write for loop lol -->
    <script src="terriblefix.js" type='text/javascript'></script>

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