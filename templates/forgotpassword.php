<?php
session_start();
$open_connect = 1;
require("connect.php");

if (isset($_SESSION['correctEmail2']) || isset($_GET['request'])) {
    if (!isset($_COOKIE['se_code'])) {
        $set_code = 1;
        require("security-code.php");
    }
}

// ดึงข้อมูลประเภทห้องพัก
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <script src="../static/main.js" defer></script>
    <link rel="stylesheet" href="../static/main.css">
</head>
<body>

    <?php
        require("index-nav.php");
    ?>

    <div class="container d-flex align-items-center justify-content-center bg-body-tertiary" style="max-width: 420px; height:75%;">

        <div class="container">
            <!-- Pills navs -->
            <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist" style="display:none;">
                <li class="nav-item" role="presentation">
                    <a
                    class="nav-link active"
                    id="tab-1"
                    data-mdb-toggle="pill"
                    href="#pills-login"
                    role="tab"
                    aria-controls="pills-login"
                    aria-selected="true"
                    >step1</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                    class="nav-link"
                    id="tab-2"
                    data-mdb-toggle="pill"
                    href="#pills-login"
                    role="tab"
                    aria-controls="pills-login"
                    aria-selected="false"
                    >step2</a
                    >
                </li>
                <li class="nav-item" role="presentation">
                    <a
                    class="nav-link"
                    id="tab-3"
                    data-mdb-toggle="pill"
                    href="#pills-register"
                    role="tab"
                    aria-controls="pills-register"
                    aria-selected="false"
                    >step3</a
                    >
                </li>
            </ul>
            <!-- Pills navs -->

            <!-- Pills content -->
            <div class="tab-content">
            <div class="tab-pane fade show active" id="pills-1" role="tabpanel" aria-labelledby="tab-login">
                <form method="post" id="mailform" action="validateEmail.php">
                <div class="text-center mb-4">
                    <h2>Enter email address</h2>
                    <p>Enter your registered email address with 9Hotel to receive a verification code for changing password.</p>
                </div>

                <div class="form-floating mb-4">
                    <input type="email" class="form-control" id="mailCheck" name="mailCheck" placeholder="Email address" required>
                    <label for="mailCheck">Email address</label>
                </div>

                <!-- Submit button -->
                <div class="row mb-4 mt-4">
                    <div class="col-md-6 d-flex justify-content-start">
                    <a role="button" href="index.php" class="btn btn-secondary">Cancel</a>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </div>

                </form>
            </div>
            <div class="tab-pane fade" id="pills-2" role="tabpanel" aria-labelledby="tab-login">
                <form method="post" id="codeform" action="validateCode.php">
                <div class="text-center mb-4">
                    <h2>Enter security code</h2>
                    <p>Please check your email. We sent your code to: <a href="forgotpassword.php?request=1">Didn't get a code?</a></p>

                </div>

                <div class="form-floating">
                    <input type="password" class="form-control" id="sixcode" name="sixcode" placeholder="Enter code" required>
                    <label for="sixcode">Enter code</label>
                </div>

                <div class="form-floating" style="display:none;">
                    <input type="password" class="form-control" id="change-form" name="change-form" value="forgetform">
                </div>

                <!-- Submit button -->
                <div class="row mb-4 mt-4">
                    <div class="col-md-6 d-flex justify-content-start">
                    <a role="button" href="profile.php" class="btn btn-secondary">Cancel</a>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Continue</button>
                    </div>
                </div>

                </form>
            </div>
            <div class="tab-pane fade" id="pills-3" role="tabpanel" aria-labelledby="tab-register">
                <form method="post" id="newpassword" action="update-password.php">
                <div class="text-center mb-4">
                    <h2>Create a new password</h2>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="Password1" name="Password1" placeholder="New password">
                    <label for="Password1">New password</label>
                </div>
                <div class="form-floating mb-4">
                    <input type="password" class="form-control" id="Password2" name="Password2" placeholder="Confirm new password">
                    <label for="Password2">Confirm new password</label>
                </div>
                <div class="form-floating" style="display:none;">
                    <input type="password" class="form-control" id="updatePass" name="updatePass" value="forgotindex">
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-3">Save Change</button>
                </form>
            </div>
            </div>
            <!-- Pills content -->

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });

        $(document).ready(function() {
            <?php
                if (isset($_SESSION['correctEmail']) || isset($_GET['request']) || isset($_SESSION['correctEmail2'])) {
                    echo 'const step1 = document.querySelector("#tab-1");';
                    echo 'const step2 = document.querySelector("#tab-2");';
                    echo 'const form1 = document.querySelector("#pills-1");';
                    echo 'const form2 = document.querySelector("#pills-2");';
                    echo 'step2.className = "nav-link active";';
                    echo 'step1.className = "nav-link";';
                    echo 'form2.className = "tab-pane fade show active";';
                    echo 'form1.className = "tab-pane fade";';
                    echo 'step1.setAttribute("aria-selected", false);';
                    echo 'step2.setAttribute("aria-selected", true);';
                    unset($_SESSION['correctEmail']);
                }
            ?>
        });

        $(document).ready(function() {
            <?php
                if (isset($_SESSION['correctCode'])) {
                    echo 'const step2 = document.querySelector("#tab-2");';
                    echo 'const step3 = document.querySelector("#tab-3");';
                    echo 'const form2 = document.querySelector("#pills-2");';
                    echo 'const form3 = document.querySelector("#pills-3");';
                    echo 'step3.className = "nav-link active";';
                    echo 'step2.className = "nav-link";';
                    echo 'form3.className = "tab-pane fade show active";';
                    echo 'form2.className = "tab-pane fade";';
                    echo 'step2.setAttribute("aria-selected", false);';
                    echo 'step3.setAttribute("aria-selected", true);';
                    unset($_SESSION['correctCode']);
                }
            ?>
        });

        <?php
            if (isset($_SESSION['errorCheck'])) {
                echo '   var alertText = "' . $_SESSION['errorCheck'] . '";';
                echo '   var alertDiv = \'';
                echo '   <div class="alert alert-danger position-fixed top-0 start-50 translate-middle-x w-25" style="z-index: 102; margin-top:3%;" role="alert" data-mdb-color="danger" data-mdb-offset="20">';
                echo '        <i class="fas fa-times-circle me-3"></i> \' + alertText + \'';
                echo '    </div>\';';
                echo '   $("body").append(alertDiv);';
                echo '   setTimeout(function() {';
                echo '       $(".alert").remove();';
                echo '   }, 6000);';
                echo '   ';
                unset($_SESSION['errorCheck']);
            }
        ?>
    </script>
</body>
</html>