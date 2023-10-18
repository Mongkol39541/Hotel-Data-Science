<?php
// จัดการ session ควบคุมสิทธิการเข้าใช้งาน
session_start();
$open_connect = 1;
require("connect.php");

// ดึงข้อมูลประเภทห้องพัก
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The 9 Hotel</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito&family=Open+Sans&family=Poppins&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" rel="stylesheet">
    <link rel="stylesheet" href="img/style.css">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>

    <script src="img/script.js" defer></script>
    <style>
        .book-nav,
        .login-nav,
        .signup-nav {
            border-radius: 0px;
            font-weight: 600;
        }

        .signup-nav:hover {
            background: #3B71CA;
        }

        .book-nav:hover,
        .login-nav:hover {
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
            .book-nav,
            .login-nav,
            .signup-nav {
                margin-bottom: 5px;
            }
        }
    </style>
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

    <div class="container mt-3">
        <h1>แสดงข้อมูลห้องพัก</h1>
        <br>
        <?php
        $selectRoomType = mysqli_query($conn, $sql);
        if (mysqli_num_rows($selectRoomType) > 0) {
            while($row = mysqli_fetch_row($selectRoomType)) {
                $roomtype = $row[0];
                $bed_sql = "SELECT DISTINCT bed_type FROM `room` WHERE room_type='$roomtype';";
                $selectBedType = mysqli_query($conn, $bed_sql);
                echo '<div class="btn-group shadow-none me-2">
                    <a role="button" class="dropdown-toggle btn btn-primary me-2" data-mdb-toggle="dropdown" aria-expanded="false">'.
                        $roomtype.
                    '</a>
                    <ul class="dropdown-menu">';
                if (mysqli_num_rows($selectBedType) > 0) {
                    while($bed = mysqli_fetch_row($selectBedType)) {
                        $bedtype = $bed[0];
                        echo '<li><a class="dropdown-item" target="_blank" href="test.php?type='.$roomtype.'&bed='.$bedtype.'">'.$bedtype.'</a></li>';
                    }
                }
                echo "</ul></div>";
            }
        }
        ?>
    </div>
    <script>
        // เพิ่ม event listener สำหรับ dropdown-toggle
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });
    </script>
</body>
</html>