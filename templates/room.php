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
    <style>
        .btn-outline-dark {
            border-radius: 0px;
            font-weight: 800;
            height: 46px;
            font-size: 16px;
            border-width: 1px;
            border-color: #A1887F;
        }

        .btn-outline-dark:hover {
            background: #fff;
            color: rgb(206, 162, 105);
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
    <div
        class="p-5 text-center bg-image"
        style="background-image: url('https://www.dusit.com/asai-bangkok-chinatown/wp-content/uploads/sites/51/cache/2021/06/ABCT-Accom/2248916598.jpg'); height: 400px;">
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.2);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h2 class="mb-3 fw-bold" style="font-size: 3rem;">ROOMS</h2>
            </div>
        </div>
        </div>
    </div>
    <div class="container p-5">
        <div class="d-flex justify-content-center flex-column text-center mb-5 mt-2">
            <h5>A comfortable, fuss-free, and functional</h5>
            <p>base of operations with local touches and thoughtful essentials.</p>
        </div>
      <div class="row row-cols-md-2 g-md-5">
        <?php
            $selectRoomType = mysqli_query($conn, $sql);
            if (mysqli_num_rows($selectRoomType) > 0) {
                while($type_row = mysqli_fetch_row($selectRoomType)) {
                    $roomtype = $type_row[0];

                    $roominfo_sql = "SELECT room_img, room_description, size FROM `room` WHERE room_type='$roomtype' LIMIT 1;";
                    $selectRoomInfo = mysqli_query($conn, $roominfo_sql);
                    $info_row = mysqli_fetch_row($selectRoomInfo);

                    $roomImg = $info_row[0];
                    $roomDes = $info_row[1];
                    $roomSize = $info_row[2];

                    echo '<div class="col">
                        <div class="card shadow-sm border-0 rounded-0">
                        <img src="'.$roomImg.'" class="card-img-top rounded-0" alt="Room Image" height="300px">
                        <div class="card-body border-0" style="background: #f6f5f5;">
                        <div class="d-flex justify-content-between">
                            <div>
                            <h3 class="card-text">'.$roomtype.'</h3>
                            <h6 class="card-text">'.$roomSize.'</h6>
                            </div>
                            <p class="card-text small ms-5">'.$roomDes.'</p>
                            </div>
                            <div class="d-md-flex justify-content-center mt-3 mx-5">';
                    $bed_sql = "SELECT DISTINCT bed_type FROM `room` WHERE room_type='$roomtype';";
                    $selectBedType = mysqli_query($conn, $bed_sql);
                    echo '<div class="col-md-6 mb-3 me-3"><div class="btn-group shadow-none me-md-2 w-100">';
                    if (mysqli_num_rows($selectBedType) > 1) {
                            echo '<a role="button" class="dropdown-toggle w-100 btn btn-outline-dark" data-mdb-toggle="dropdown" aria-expanded="false">
                                    Book Now
                                    </a>
                                    <ul class="dropdown-menu">
                                    <li class="disabled"><span class="dropdown-item-text">-- Select bed type --</span></li>';
                            while($bed = mysqli_fetch_row($selectBedType)) {
                                $bedtype = $bed[0];
                                echo '<li><a class="dropdown-item" target="_blank" href="reservation.php?type='.$roomtype.'&bed='.$bedtype.'">'.$bedtype.'</a></li>';
                            }
                            echo '</ul>';
        
                        } else {
                            $bed = mysqli_fetch_row($selectBedType);
                            $bedtype = $bed[0];
                            echo '<a role="button" class="w-100 btn btn-outline-dark" href="reservation.php?type='.$roomtype.'&bed='.$bedtype.'">
                                    Book Now
                                </a>';
                            }
                    echo '</ul></div></div>
                        <div class="col-md-6">
                        <a role="button" class="w-100 btn btn-outline-dark" href="roomdetail.php?type='.$roomtype.'">EXPLORE</a>
                        </div></div>
                        </div>
                        </div>
                        </div>';
                }
            }
        ?>
        </div>
    </div>

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>
</body>
</html>