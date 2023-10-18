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

    <?php
    if(isset($_GET['type'])) {
        $selectedRoom = htmlspecialchars($_GET['type']);
        echo "<h1>room type: " . $selectedRoom ."</h1><br>";
    } else {
        die(header("Location: account.php"));
    }

        $bed_sql = "SELECT DISTINCT bed_type FROM `room` WHERE room_type='$selectedRoom';";
        $selectBedType = mysqli_query($conn, $bed_sql);

        if (mysqli_num_rows($selectBedType) > 0) {
            echo '<form action="test.php" method="get" target="_blank">';
            $firstBedType = true;
            while ($bed = mysqli_fetch_row($selectBedType)) {
                $bedtype = $bed[0];
                $checked = $firstBedType ? 'checked' : ''; // ตรวจสอบว่าเป็น radio แรกหรือไม่
                echo '
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="bed" id="' . $bedtype . '" value="' . $bedtype . '" ' . $checked . '>
                        <label class="form-check-label" for="' . $bedtype . '">' . $bedtype . '</label>
                    </div>';
                $firstBedType = false;
            }

            echo '
                <input type="hidden" name="type" value="' . $selectedRoom . '">
                <button type="submit" class="btn btn-primary">BOOK NOW</button>
            </form>';
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