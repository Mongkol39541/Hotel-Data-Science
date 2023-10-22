<?php
session_start();
$open_connect = 1;
require("connect.php");

// ดึงข้อมูลประเภทห้องพัก
$sql = "SELECT DISTINCT room_type FROM room;";
$selectRoomType = mysqli_query($conn, $sql);

if(
    !isset($_SESSION['id_account']) ||
    !isset($_SESSION['role_account'])
){
    die(header("Location: ../index.php"));
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"></script>
    <link rel="stylesheet" href="../static/main.css">
</head>
<body>
    <?php
        require("account-nav.php");
    ?>

    <div class="container d-flex align-items-center justify-content-center bg-body-tertiary" style="max-width: 420px; height:70%;">

        <div class="container">
            <form action="update-password.php" method="post" id="updatePassword" onsubmit="return validatePassword()">
                <div class="text-center mb-4">
                    <h2>Change Password</h2>
                    <p>Password is at least 8 characters long and <br>less than 30 characters</p>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Current password" required>
                    <label for="currentPassword">Current password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="Password1" name="Password1" placeholder="New password" required>
                    <label for="Password1">New password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="Password2" name="Password2" placeholder="Confirm new password" required>
                    <label for="Password2">Confirm new password</label>
                </div>

                <div class="text-center">
                    <small class="text-danger" id="notation">test</small>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4 mt-4">Save Change</button>

                <!-- Register buttons -->
                <div class="text-center">
                    <a href="forget.php?code=1">Forgot password?</a>
                </div>
            </form>


        </div>
    </div>

    <script>
        document.querySelector('#roomsDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            window.location.href = 'room.php';
        });

        const notation = document.querySelector("#notation");
        const noteparent = notation.parentElement;

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

        function showNote(text) {
            notation.innerText = text;
            const status = noteparent.classList.contains("input-error");
            if (!status) {
                noteparent.classList.toggle("input-error");
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

        function validatePassword() {
            const password = document.querySelector("#currentPassword");
            const password1 = document.querySelector("#Password1");
            const password2 = document.querySelector("#Password2");

            var inputArr = [password, password1, password2];
            resetStatus(inputArr);

            var count = 0;
            inputArr.forEach((input) => {
                if (input.value.trim() === '') {
                    showError(input);
                    count++;
                } else {
                    if ((input.value.length < 8) || (input.value.length > 30)) {
                        showError(input);
                        count++;
                    } else {
                        showSuccess(input);
                    }
                }
            });

            if (count > 0) {
                if (password1.value !== password2.value) {
                    showError(password2);
                    showNote('Passwords is not valid');
                } else {
                    showNote('Password length is incorrect');
                }
                return false;
            }
            else {
                if (password1.value !== password2.value) {
                    showError(password1);
                    showError(password2);
                    showNote('Confirm password does not match');
                    return false;
                } else {
                    return true;
                }
            }
        }
    </script>
</body>
</html>