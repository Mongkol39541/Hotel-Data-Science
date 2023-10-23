<?php
session_start();
$open_connect = 1;
require("connect.php");

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die(header("Location: ../index.php"));
}

if(isset($_SESSION['correctCode'])){
    unset($_SESSION['correctCode']);
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
    <link rel="stylesheet" href="../static/main.css">
</head>
<body>
    <?php
        require("account-nav.php");

        $account_sql = "SELECT * FROM member where member_id='".$_SESSION['id_account']."';";
        $result = mysqli_query($conn, $account_sql);
        $account = mysqli_fetch_assoc($result);
        $prefix = $account['title'];
        $firstname = $account['first_name'];
        $lastname = $account['last_name'];
        $birthday = $account['birthdate'];
        $email = $account['email'];
    ?>

    <div class="container d-flex align-items-center justify-content-center bg-body-tertiary" style="max-width: 500px; height:70%;">

        <div class="container">

            <form action="update-profile.php" method="post" id="updateProfile" onsubmit="return validateUpdate()">
                <div class="mb-4">
                    <h2>Hello <?php echo $prefix.' '.$firstname; ?></h2>
                </div>

                <!-- Prefix -->
                <div class="mb-3 row">
                    <label for="prefix_account" class="col-sm-2 col-form-label">Prefix</label>
                    <div class="col-sm-10">
                        <select id="prefix_account" name="prefix_account" class="form-select">
                            <option value="" selected>Prefix</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Miss">Miss</option>
                        </select>
                    </div>
                </div>

                <!-- Firstname -->
                <div class="mb-3 row">
                    <label for="fname_account" class="col-sm-2 col-form-label">Firstname</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control rounded" id="fname_account" name="fname_account">
                    </div>
                </div>

                <!-- Lastname -->
                <div class="mb-3 row">
                    <label for="lname_account" class="col-sm-2 col-form-label">Lastname</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control rounded" id="lname_account" name="lname_account">
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3 row">
                    <label for="email_account" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control rounded" id="email_account" disabled>
                    </div>
                </div>

                <!-- Birthday -->
                <div class="mb-2 row">
                    <label for="bday_account" class="col-sm-2 col-form-label">Birthday</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control rounded" id="bday_account" name="bday_account"
                        autocomplete="off" max="<?php echo date('Y-m-d', strtotime('-7 years')); ?>">
                    </div>
                </div>

                <div class="text-center mb-3">
                    <small class="text-danger" id="notation">test</small>
                </div>

                <!-- Submit buttons -->
                <div class="row mb-4 mt-3">
                    <div class="col-md-6 d-flex justify-content-start">
                    <a role="button" href="change-email.php?code=1" class="btn btn-secondary me-2">Change email</a>
                    <a role="button" href="password.php" class="btn btn-secondary">Change password</a>
                    </div>

                    <div class="col-md-6 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Save Change</button>
                    </div>
                </div>
            </form>


        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var email = "<?php echo $email; ?>";
        var name = email.substring(0, 3);

        // แสดง domain ที่ตามหลัง @ และแสดงเฉพาะตัวอักษรสุดท้าย
        var atIndex = email.indexOf('@');
        var domain = email.substring(atIndex - 1);

        document.getElementById("prefix_account").value = "<?php echo $prefix; ?>";
        document.getElementById("fname_account").value = "<?php echo $firstname; ?>";
        document.getElementById("lname_account").value = "<?php echo $lastname; ?>";
        document.getElementById("bday_account").value = "<?php echo $birthday; ?>";
        document.getElementById("email_account").value = name + '*****' + domain;

        var prefix = document.querySelector("#prefix_account");
        var fname = document.querySelector("#fname_account");
        var lname = document.querySelector("#lname_account");
        var birth = document.querySelector("#bday_account");
        var notation = document.querySelector("#notation");
        var noteparent = notation.parentElement;

        function showError(input) {
            const formGroup = input.parentElement;
            const status = formGroup.classList.contains("input-error");
            if (!status) {
                formGroup.classList.toggle("input-error");
            }
        }

        function showSuccess(input) {
            const formGroup = input.parentElement;
            const status = formGroup.classList.contains("input-success");
            if (!status) {
                formGroup.classList.toggle("input-success");
            }
        }

        function resetStatus(inputArr) {
            inputArr.forEach((input) => {
                const formGroup = input.parentElement;

                const statusSuccess = formGroup.classList.contains("input-success");
                if (statusSuccess) {
                    formGroup.classList.toggle("input-success");
                }

                const statusError = formGroup.classList.contains("input-error");
                if (statusError) {
                    formGroup.classList.toggle("input-error");
                }
            });
        }

        function checkRequired(inputArr) {
            var count = 0;
            inputArr.forEach((input) => {
                if (input.value.trim() === '') {
                    showError(input);
                    count++;
                } else {
                    showSuccess(input);
                }
            });
            if (count > 0) {
                notation.innerText = 'Please enter all required information.';
                const status = noteparent.classList.contains("input-error");
                if (!status) {
                    noteparent.classList.toggle("input-error");
                }
            }
        }

        function validateUpdate() {
            resetStatus([prefix, fname, lname, birth]);
            checkRequired([prefix, fname, lname, birth]);
            console.log("test");

            var input_data = [prefix, fname, lname, birth];
            var error = 0;
            input_data.forEach((input) => {
                const formGroup = input.parentElement;
                const statusError = formGroup.classList.contains("input-error");
                if (statusError) {
                    error++;
                }
            });
            if (error == 0) {
                return true;
            } else {
                return false;
            }
        }

        <?php
        if (isset($_SESSION['updateError'])) {
            echo '   var alertText = "' . $_SESSION['updateError'] . '";';
            echo '   var alertDiv = \'';
            echo '   <div class="alert alert-danger position-fixed top-0 start-50 translate-middle-x w-25" style="z-index: 102; margin-top:3%;" role="alert" data-mdb-color="danger" data-mdb-offset="20">';
            echo '        <i class="fas fa-times-circle me-3"></i> \' + alertText + \'';
            echo '    </div>\';';
            echo '   $("body").append(alertDiv);';
            echo '   setTimeout(function() {';
            echo '       $(".alert").remove();';
            echo '   }, 6000);';
            echo '   ';
            unset($_SESSION['updateError']);
        } elseif (isset($_SESSION['updateSuccess'])) {
            echo '   var alertText = "' . $_SESSION['updateSuccess'] . '";';
            echo '   var alertDiv = \'';
            echo '   <div class="alert alert-success position-fixed top-0 start-50 translate-middle-x w-25" style="z-index: 102; margin-top:4%;" role="alert" data-mdb-color="success" data-mdb-offset="20">';
            echo '        <i class="fas fa-times-circle me-3"></i> \' + alertText + \'';
            echo '    </div>\';';
            echo '   $("body").append(alertDiv);';
            echo '   setTimeout(function() {';
            echo '       $(".alert").remove();';
            echo '   }, 6000);';
            unset($_SESSION['updateSuccess']);
        }
        ?>

        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
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
        } elseif (isset($_SESSION['success'])) {
            echo '   var alertText = "' . $_SESSION['success'] . '";';
            echo '   var alertDiv = \'';
            echo '   <div class="alert alert-success position-fixed top-0 start-50 translate-middle-x w-25" style="z-index: 102; margin-top:4%;" role="alert" data-mdb-color="success" data-mdb-offset="20">';
            echo '        <i class="fas fa-times-circle me-3"></i> \' + alertText + \'';
            echo '    </div>\';';
            echo '   $("body").append(alertDiv);';
            echo '   setTimeout(function() {';
            echo '       $(".alert").remove();';
            echo '   }, 6000);';
            unset($_SESSION['success']);
        }
        ?>
    </script>
</body>
</html>