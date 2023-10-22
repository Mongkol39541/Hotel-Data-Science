<?php
session_start();
$open_connect = 1;
require("connect.php");
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);
if(isset($_GET['type'])) {
    $selectedRoom = htmlspecialchars($_GET['type']);
} else {
    die(header("Location: account.php"));
}
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
        .item {
            width: 50%;
            float: left;
        }

        .btn-secondary {
            border-radius: 0px;
            height: 46px;
            font-size: 16px;
        }

        .btn-secondary:hover {
            background-color: #4FC3F7;
            border-color: #4FC3F7;
            color: #fff;
        }

        .btn-secondary:focus {
            box-shadow: 0 0 0 0.2rem rgba(23, 162, 184, 0.5);
        }

        .radio1{
            display: none;
        }

        .label1 {
            position: relative;
            color: #54B4D3;
            font-size: 16px;
            border: 2px solid #54B4D3;
            border-radius: 5px;
            padding: 7px 40px;
            display: flex;
            align-items: center;
        }

        .label1:before{
            content: "";
            height: 14px;
            width: 14px;
            border: 3px solid #54B4D3;
            border-radius: 50%;
            margin-right: 15px;
            margin-left: 20px;
        }

        .radio1:checked + .label1 {
            background-color: #54B4D3;
            color: #ffff;
        }

        .radio1:checked + .label1:before{
            height: 16px;
            width: 16px;
            border: 10px solid #54B4D3;
            background-color:#54B4D3;
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
        style="
        background-image: url('https://www.dusit.com/asai-bangkok-chinatown/wp-content/uploads/sites/51/cache/2023/08/Comfort-at-ASAI-Chinatown/25512868.jpg');
        height: 400px;
        "
    >
        <div class="mask" style="background-color: rgba(0, 0, 0, 0.2);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
            <h1 class="fw-bold" style="font-size: 3rem;">Room Details</h1>
            </div>
        </div>
        </div>
    </div>

    <div class="container p-5 mt-3">
        <div class="row mb-2 mx-5">
        <div class="col-md-7">
            <div id="carouselExampleControls" class="carousel slide" data-mdb-ride="carousel">
                <div class="carousel-inner">
                <?php

                $bed_sql = "SELECT DISTINCT bed_type FROM `room` WHERE room_type='$selectedRoom';";

                // start มีแก้ใหม่ตรงนี้ครับพี่
                if (isset($_GET['bed'])) {
                    $selectedBed = $_GET['bed'];
                } else {
                    $selectBedType = mysqli_query($conn, $bed_sql);
                    $selectedBed = mysqli_fetch_row($selectBedType);
                    $selectedBed = $selectedBed[0];
                }
                // end

                $img_sql = "SELECT room_img FROM `room` WHERE room_type='$selectedRoom' and bed_type='$selectedBed' LIMIT 5;";
                $selectImg = mysqli_query($conn, $img_sql);

                $firstImg = true;
                while ($img_row = mysqli_fetch_row($selectImg)) {
                    $item = $firstImg ? ' active' : '';

                    echo '<div class="carousel-item'. $item. '">
                    <img src="'.$img_row[0].'" class="d-block w-100" height=400px" alt="Room Image"/>
                    </div>';

                    $firstImg = false;
                }
                ?>
                </div>
                <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleControls" data-mdb-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md-5 p-5">

            <?php
                $room_sql = "SELECT size, capacity FROM `room` WHERE room_type='$selectedRoom' LIMIT 1;";
                $selectRoomInfo = mysqli_query($conn, $room_sql);
                $RoomInfo = mysqli_fetch_row($selectRoomInfo);

                echo '<h1 class="display-6">'.$selectedRoom.'</h1>';
                echo '<pre>Room Size: '.$RoomInfo[0]."\tMax Adults:".$RoomInfo[1].'</pre>';
                echo '<b class="text-dark font-weight-bold">bed type:</b>';

                // start มีแก้ใหม่ตรงนี้ครับพี่
                $selectBedType = mysqli_query($conn, $bed_sql);

                if (mysqli_num_rows($selectBedType) > 0) {
                    echo '<form action="reservation.php" method="get" target="_blank">';

                    while ($bed = mysqli_fetch_row($selectBedType)) {
                        $bedtype = $bed[0];
                        if ($bedtype == $selectedBed) {
                            $checked = 'checked';
                        } else {
                            $checked = '';
                        }
                        echo '
                            <div class="form-check w-50" style="margin-left: 60px; height:16px; margin-bottom: 30px;">
                                <input class="radio1 form-check-input" type="radio" onclick="RadioClick(this)"
                                    name="bed" id="' . $bedtype . '" value="' . $bedtype . '" ' . $checked . '>
                                <label class="label1 form-check-label" for="' . $bedtype . '">' . $bedtype . '</label>
                            </div>';
                        // end
                    }

                    echo '
                        <input type="hidden" name="type" value="' . $selectedRoom . '">
                        <button type="submit" class="btn btn-secondary w-50 mt-3 font-weight-bold">BOOK NOW</button>
                    </form>';
                }
            ?>

        </div>
    </div>


    <div class="container d-flex justify-content-center flex-column text-center" style="background: #f6f5f5;">
    <div class="d-flex justify-content-center flex-column text-center">
        <h5 class="mt-5">ROOM FEATURES</h5>
        <p>We offer a fascinating fusion of comfort and cultural experience to ensure you have a flavorful journey.</p>
    </div>

    <?php

    $data_sql = "SELECT facility FROM `room` WHERE room_type='$selectedRoom';";
    $selectFacility = mysqli_query($conn, $data_sql);
    $data = mysqli_fetch_row($selectFacility);
    $data = $data[0];
    $items = explode(', ', $data);
    $totalItems = count($items);

    ?>

    <div class="text-center mt-3 mb-4" style="width: 60%; position: relative; left: 50%; transform: translateX(-50%);">
        <?php
            for ($i = 0; $i < $totalItems; $i++) {
                echo '<div class="item"><p class="small">' . $items[$i] . '</p></div>';
            }
        ?>
    </div>
</div>

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>
    <script>
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });

        // มีแก้ใหม่ตรงนี้ครับพี่
        function RadioClick(radio) {
            var selectedOption = radio.value;
            window.location.href = "roomdetail.php?type=<?php echo $selectedRoom ?>&bed=" + selectedOption;
        }

    </script>
</body>
</html>