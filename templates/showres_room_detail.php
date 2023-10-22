<?php
session_start();
unset($_SESSION["datefilter"]);
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
if(isset($_GET['res_id'])) {
    $res_id = htmlspecialchars($_GET['res_id']);
    $sql = "SELECT room_type, bed_type FROM reservation JOIN room USING(room_id) WHERE reserve_id='$res_id';";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $_SESSION['res_id'] = $res_id;
    $_SESSION['roomtype'] = $row['room_type'];
    $_SESSION['bedtype'] = $row['bed_type'];
} else {
    die(header("Location: account.php"));
}

if (isset($_POST['use-member-address'])) {
    $fname = $_SESSION['acc_fname'];
    $lname = $_SESSION['acc_lname'];
    $email = $_SESSION['acc_email_account'];
}

$email = $_SESSION['acc_email_account'];
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Detail</title>
    <link rel="icon" href="../static/logoimage.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/ScrollMagic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.7/plugins/animation.gsap.min.js"></script>
    <script src="../static/main.js" defer></script>
    <script src="../static/reservation.js" defer></script>
</head>
<body>
    <header>
        <?php
        require("account-nav.php");
        ?>
    </header>
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

    <?php
    if(isset($_POST['update'])) {
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $res_email = $_POST['email'];
        $phone = $_POST['phone'];
        $check_in_final = $_SESSION['check_in'];
        $check_out_final = $_SESSION['check_out'];
        $sql = "UPDATE guest SET first_name = '$fname', last_name = '$lname', email = '$res_email', phone = '$phone' WHERE reserve_id = '$res_id'";
        $sql1 = "UPDATE reservation SET check_in = '$check_in_final', check_out = '$check_out_final' WHERE reserve_id = '$res_id'";
        try {
            if ($conn->query($sql) and $conn->query($sql1)) {
                $text = 'ID: ' . $res_id . ' 🎉 <strong>Congratulations, you have successfully updated your room information.</strong>';
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
                        }, 4000);
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
                    }, 4000);
                </script>
                EOT;
        }
    } elseif (isset($_POST['delete'])) {
        $sql = "DELETE FROM transaction WHERE reserve_id  = '$res_id';";
        $sql1 = "DELETE FROM reservation WHERE reserve_id = '$res_id';";
        $sql2 = "DELETE FROM guest WHERE reserve_id = '$res_id';";
        try {
            if ($conn->query($sql) && $conn->query($sql1) && $conn->query($sql2)) {
                $text = 'ID: ' . $res_id . ' 🎉 <strong>Congratulations, you have successfully delete your room information.</strong>';
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
                            window.location.href = 'showres.php';
                        }, 4000);
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
                        alertDiv.setAttribute('data-mdb-color', 'success');
                        alertDiv.setAttribute('data-mdb-offset', '20');
                        alertDiv.innerHTML = `
                            <i class="fas fa-check me-2"></i> {$text}
                        `;
                        document.body.appendChild(alertDiv);
                        setTimeout(function() {
                            alertDiv.remove();
                        }, 4000);
                    </script>
                    EOT;
        }
    }
    ?>

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

    <div class="modal top fade" id="DeleteModal" tabindex="-1" aria-hidden="true" data-mdb-backdrop="true" data-mdb-keyboard="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form enctype="multipart/form-data" action="" method="POST">
                    <div class="modal-header bg-danger text-light d-flex justify-content-center align-items-center">
                        <h5 class="modal-title">Are you sure?</h5>
                    </div>
                    <div class="modal-body text-center">
                        <i class="fa-solid fa-xmark fa-5x text-danger"></i>
                        <h5 class="modal-title mt-3 mx-4 bg-danger text-light rounded">Delete ID #<?php echo $res_id?></h5>
                        <input name="formID" type="text" id="outDelete" hidden />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-mdb-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-outline-danger" name="delete">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <main style="margin-top: 100px">
        <div class='container'>
            <div class='row justify-content-center gap-4'>
            <div class='mb-2 col-md-5'>
                <div class="card border border-secondary border-1" id="animation1">
                    <img src="<?php echo $room_img?>" class="card-img-top" alt="room-img"/>
                    <div class='card-body'>
                        <h3 class="card-title mb-2"><?php echo $roomtype . ' ' . $bedtype?></h3>
                        <div class='mb-2'>
                            <p class='card-text'><?php echo $desc?></p>
                        </div>
                        <div>
                            <p class='card-text'>Room size: <?php echo $size?> SQM</p>
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
                </div>
                <div class='card border border-secondary border-1 col h-50 mx-3' id="animation2">
                    <div class='card-header'>
                        <h3 class='text-center'>Your details</h3>
                    </div>
                    <div class="container mt-4 text-center"> 
                        <button type="button" class="btn btn-primary" data-mdb-toggle="modal" data-mdb-target="#modcalend">
                        Show Calender
                        </button>
                    </div>
                    <br>
                    <form method="post" action='' novalidate class='.needs-validation'>
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
                                        <button type="button" onclick='datecheck(document.getElementById("date_editor").value);'
                                        class="btn btn-primary" id="confirm_date" name="confirm_date" id="confirm_date" disabled>Confirm date</button>
                                        <input type="text" id="confirm_hidden" value="" hidden>
                                    </div>
                                    <div name='result' id='result'>
                                    </div>
                                </div>
                            <div class='form-check mb-2'>
                                <input type="checkbox" class="form-check-input" id="use-member-address" name="use-member-address" disabled>
                                <label for="use-member-address">Use member address</label>
                            </div>
                            <div id='guest-info'>
                                <div class='row'>
                                    <div class ='col-md-6 mb-3'>
                                        <input type="text" class='form-control' name="fname" id="fname" placeholder='First Name' 
                                        value='<?php echo $fname ?>' required disabled>
                                        <input type="text" id="fname_hidden" value='<?php echo $fname ?>' hidden>
                                        <div class='invalid-feedback'>
                                            Please enter a First Name.
                                        </div>
                                    </div>  
                                    <div class ='col-md-6 mb-3'>
                                        <input type="text" class='form-control' name="lname" id="lname" placeholder='Last Name' 
                                        value='<?php echo $lname ?>' required disabled>
                                        <input type="text" id="lname_hidden" value='<?php echo $lname ?>' hidden>
                                        <div class="invalid-feedback">
                                            Please enter a Last Name.
                                        </div>
                                    </div>
                                </div>
                                <div class='mb-4'>
                                    <input type="tel" class='form-control' name="phone" id="phone" placeholder='Phone' 
                                    value='<?php echo $phone ?>'required disabled>
                                    <input type="text" id="phone_hidden" value='<?php echo $phone ?>' hidden>
                                    <div class="invalid-feedback">
                                        Please provide a phone number.
                                    </div>
                                </div>
                                <div class='mb-4'>
                                    <input type="email" class='form-control' name="email" id="email" placeholder='Email' 
                                    value='<?php echo $res_email ?>'required disabled>
                                    <input type="text" id="email_hidden" value='<?php echo $res_email ?>' hidden>
                                    <div class="invalid-feedback">
                                        Please provide an email.
                                    </div>
                                </div>
                                <?php
                                $chan = "";
                                if ($_SESSION['show'] == "show_past") {
                                    $chan = "hidden";
                                }
                                ?>
                                <button type="button" class="btn btn-light mb-3 me-3" name="cancel" id="cancel" onclick='cancel_info()' hidden>Cancel Edit</button>
                                <button type="submit" class="btn btn-dark mb-3 me-3" name="update" id="update" hidden>Update Reservation</button>
                                <button type="button" class="btn btn-warning mb-3 me-3" name="edit" id="edit" onclick='edit_info()' <?php echo $chan; ?>>Edit Information</button>
                                <button type="button" class="btn btn-danger mb-3 me-3" id="delete" data-mdb-toggle="modal" data-mdb-target="#DeleteModal" <?php echo $chan; ?>>Delete Reservation</button>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    <script src="../static/calendar.js" type='text/javascript'></script>
    <script src="../static/terriblefix.js" type='text/javascript'></script>
    <script src="../static/manage_res.js" type='text/javascript'></script>
    <script src="../static/validitycheckforform.js" type='text/javascript'></script> 
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
                url: "show_timecheck.php",
                data: {date_editor: date},
                success: function(result) {
                    $("#result").html(result);
                }
            });
        };
    </script>
    <?php
    mysqli_close($conn);
    ?>
</body>
</html>