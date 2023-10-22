<?php

session_start();
$open_connect = 1;
require("connect.php");
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Nine Hotel</title>
    <link rel="icon" href="../static/logoimage.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Open+Sans&family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet">
    <link rel="stylesheet" href="../static/main.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="../static/main.js" defer></script>
</head>
<body>
    <?php
    if(
        !isset($_SESSION['id_account']) ||
        !isset($_SESSION['role_account'])
    ){
        require("index-nav.php");
    } else {
        require("account-nav.php");
    }
    ?>

    <div
        class="p-5 text-center bg-image"
        style="
        background-image: url('https://www.it.kmitl.ac.th/wp-content/themes/itkmitl2017wp/img/life/life-13.jpg');
        height: 400px;
        "
    >
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.2);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h1 class="fw-bold" style="font-size: 3rem;">CONTACT</h1>
            </div>
        </div>
        </div>
    </div>
    <div class="transportations p-reg cb-b2 s-combo-default s-combo-default">
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
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15503.244051726755!2d100.7782323!3d13.7298889!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x311d664988a1bedf%3A0xcc678f180e221cd0!2sKing%20Mongkut&#39;s%20Institute%20of%20Technology%20Ladkrabang!5e0!3m2!1sen!2sth!4v1697700262211!5m2!1sen!2sth"
                                width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>
</body>
</html>