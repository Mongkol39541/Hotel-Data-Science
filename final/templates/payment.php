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

if (isset($_POST['use-member-address'])) {
    $res_fname = $_SESSION['acc_fname'];
    $res_lname = $_SESSION['acc_lname'];
    $res_email = $_SESSION['acc_email_account'];
} else {
    $res_fname = $_POST['fname'];
    $res_lname = $_POST['lname'];
    $res_email = $_POST['email'];
}

$email = $_SESSION['acc_email_account'];
$roomtype = $_SESSION['roomtype'];
$bedtype = $_SESSION['bedtype'];
$designated_room = $_SESSION['designated_room'];
$check_in_final = $_SESSION['check_in'];
$check_out_final = $_SESSION['check_out'];
$res_phone = $_POST['phone'];
$_SESSION['res_phone'] = $res_phone;
$_SESSION['res_fname'] = $res_fname;
$_SESSION['res_lname'] = $res_lname;
$_SESSION['res_email_account'] = $res_email;
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);
$date1 = new DateTime($check_in_final);
$date2 = new DateTime($check_out_final);
$interval = $date1->diff($date2);
?>

<?php
$sqlroom = "SELECT *
FROM room
WHERE room_type = '$roomtype' AND bed_type = '$bedtype';";
$result = mysqli_query($conn, $sqlroom);
$row = mysqli_fetch_array($result);
$room_img = $row['room_img'];
$price_per_night = $row['price_per_night'];
$facility = $row['facility'];
$size = $row['size'];

$total_price = (float)$price_per_night * $interval->format("%a");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="icon" href="../static/logoimage.png">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <link rel="stylesheet" href="../static/main.css">
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
    <main class='mt-3'>
    <section style="background-color: #eee;">
    <div class="container py-5">
        <div class="card" id="animation1">
        <div class="card-body">
            <div class="row d-flex justify-content-center pb-5">
            <div class="col-md-7 col-xl-5 mb-4 mb-md-0">
                <div class="py-4 d-flex flex-row">
                <h5><span class="far fa-check-square pe-2"></span><b>DUMB</b> |</h5>
                <span class="ps-2">Payment Mockup</span>
                </div>
                <form action="update_reserve_to_db.php" novalidate class='.needs-validation'>
                    <div id='guest-info'>
                        <div class='mb-4 w-75'>
                            <input type="text" class='form-control' placeholder='Card Number' required>
                            <div class='invalid-feedback'>
                                Please enter a Card Number.
                            </div>
                        </div>
                        <div class='mb-4 w-75'>
                            <input type="text" class='form-control'placeholder='Name on Card' required>
                            <div class="invalid-feedback">
                                Please provide a Name.
                            </div>
                        </div>
                        <div class='row mb-3 text-center'>
                            <div class ='col-md-4'>
                                <input type="text" class='form-control' placeholder='Expiry Date' required>
                                <div class='invalid-feedback'>
                                    Please enter an Expiry Date.
                                </div>
                            </div>
                            <div class ='col-md-4'>
                                <input type="password" class='form-control' placeholder='Security Code' required>
                                <div class="invalid-feedback">
                                    Please enter a Security Code.
                                </div>
                            </div>
                        </div>
                        <div class='mb-4'>
                            <button type="submit" class="btn btn-primary" name="submit" id="submit">Confirm Payment</button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="col-md-5 col-xl-4 offset-xl-1">
                <div class="py-4 d-flex justify-content-end">
                <h6><a href="">Cancel and return to website</a></h6>
                </div>
                <div class="rounded d-flex flex-column p-2" style="background-color: #f8f9fa;">
                <div class="p-2 me-3">
                    <h4>Order Recap</h4>
                </div>
                <div class="p-2 d-flex">
                    <div class="col-8"><?php echo $roomtype . ' ' . $bedtype . ' (' . $interval->format('%d days') . ')' ?></div>
                    <div class="ms-auto"><?php echo $total_price?> THB</div>
                    <?php $_SESSION['total_price'] = $total_price; ?>
                </div>
                <div class="p-2 d-flex">
                    <div class="col-8">Tax (0.07%)</div>
                    <div class="ms-auto">+ <?php echo 0.07*$total_price?> THB</div>
                    <?php $final_room_pice = $total_price + 0.07*$total_price; ?>
                    <?php $_SESSION['final_room_price'] = $final_room_pice; ?>
                </div>
                <div class="border-top px-2 mx-2"></div>
                <div class="p-2 d-flex pt-3">
                    <div class="col-8">Total Discount</div>
                    <div class="ms-auto">0.00 THB</div> <!-- TODO: discount code (maybe?) -->
                </div>
                <div class="border-top px-2 mx-2"></div>
                <div class="p-2 d-flex pt-3">
                    <div class="col-8"><b>Total</b></div>
                    <div class="ms-auto"><b class="text-success"><?php echo $final_room_pice?> THB</b></div>
                </div>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    </section>
    </main>

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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

        <?php
        $_SESSION['final_room_pice'] = $final_room_pice;
        ?>
    </script>
    <script src="validitycheckforform.js" type='text/javascript'></script>

    <?php
        mysqli_close($conn);
    ?>
</body>
</html>