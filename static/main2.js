document.querySelector('#roomsDropdownindex, #roomsDropdown').addEventListener('click', function (e) {
    e.stopPropagation();
    if (this.id === 'roomsDropdownindex') {
        window.location.href = 'templates/room.php';
    } else if (this.id === 'roomsDropdown') {
        window.location.href = 'room.php';
    }
});

const popLoginBtn = document.querySelector(".login-nav");
const popSignupBtn = document.querySelector(".signup-nav");

popLoginBtn.addEventListener("click", () => {
    document.body.classList.toggle("show-popup-login");
});

popSignupBtn.addEventListener("click", () => {
    document.body.classList.toggle("show-popup-signup");
});

const hideLoginBtn = document.querySelector(".form-popup .close-btn1");
hideLoginBtn.addEventListener("click", () => popLoginBtn.click());

const hideSignupBtn = document.querySelector(".form-popup .close-btn2");
hideSignupBtn.addEventListener("click", () => popSignupBtn.click());

const loginLink = document.querySelector("#login-link");
const signupLink = document.querySelector("#signup-link");

loginLink.addEventListener("click", () => {
    popSignupBtn.click();
    popLoginBtn.click();
});

signupLink.addEventListener("click", () => {
    popSignupBtn.click();
    popLoginBtn.click();
});

const signupForm = document.querySelector("#signup");
const prefix = document.querySelector("#prefix");
const fname = document.querySelector("#firstname");
const lname = document.querySelector("#lastname");
const email = document.querySelector("#email");
const birth = document.querySelector("#birthday");
const password1 = document.querySelector("#password1");
const password2 = document.querySelector("#password2");

const notation = document.querySelector("#notation");
const noteparent = notation.parentElement;
const note = noteparent.querySelector("#notation");


// Show input error messages
function showError(input, message) {
    const formGroup = input.parentElement;
    const note = formGroup.querySelector(".form-label.fs-10px");
    note.innerText = message;
    // formGroup.classList.toggle("input-error");

    const status = formGroup.classList.contains("input-error");
    if (!status) {
        formGroup.classList.toggle("input-error");
    }
}

// Show input success messages
function showSuccess(input) {
    const formGroup = input.parentElement;
    const status = formGroup.classList.contains("input-success");
    if (!status) {
        formGroup.classList.toggle("input-success");
    }
}

// check email is valid
function checkEmail(input) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (re.test(input.value.trim())) {
        showSuccess(input);
    } else {
        if (input.value.trim() !== '') {
            showError(input, 'Email is not valid');
        }
    }

}

// check Required fields
function checkRequired(inputArr) {
    var count = 0;
    inputArr.forEach((input) => {
        if (input.value.trim() === '') {
            showError(input, '*');
            count++;
        } else {
            showSuccess(input);
        }
    });
    if (count > 0) {
        notation.innerText = '* Indicates required question';
        const status = noteparent.classList.contains("input-error");
        if (!status) {
            noteparent.classList.toggle("input-error");
        }
    }
}

// check input length
function checkLength(input, min, max) {
    if (input.value.length < min && input.value.trim() !== '') {
        showError(input, `must be at least ${min} characters`);
    } else if (input.value.length > max) {
        showError(input, `must be less than ${max} characters`);
    } else {
        showSuccess(input);
    }
}

// get Fieldname
// function fieldname(input) {
//     return input.id.charAt(0).toUpperCase() + input.id.slice(1);
// }

// check passwords match
function checkPasswordMatch(input1, input2) {
    const formGroup = input1.parentElement;
    const status = formGroup.classList.contains("input-error");

    if (status) {
        //ถ้ารหัสผ่านไม่ถูกต้อง หรือ เป็นค่าว่าง
        if (input1.value.trim() === '') {
            if (input2.value.trim() !== '') {
                showError(input2, 'Password is required');
            }
        } else {
            if (input2.value.trim() !== '') {
                showError(input2, 'Password is not valid');
            }
        }
    } else {
        if (input1.value !== input2.value &&
            input2.value.trim() !== '') {
            showError(input2, 'Passwords do not match');
        }
    }

}

// reset status
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

// Validate Fuction
function validateSignupForm() {

    // เรียกใช้ฟังก์ชันสำหรับตรวจสอบข้อมูล
    resetStatus([prefix, fname, lname, email, birth, password1, password2, notation]);
    checkRequired([prefix, fname, lname, email, birth, password1, password2]);
    checkEmail(email);
    checkLength(password1, 8, 25);
    checkPasswordMatch(password1, password2);

    var input_data = [prefix, fname, lname, email, birth, password1, password2];
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


// if (isset($_SESSION["success"])) {
//     echo 'document.body.classList.toggle("show-popup-login");';
//     echo 'setTimeout(function() { alert("'.$_SESSION["success"].'"); }, 0);';
//     unset($_SESSION['success']);
// } elseif (isset($_SESSION["error"])) {
//     echo 'document.body.classList.toggle("show-popup-signup");';
//     echo 'setTimeout(function() { alert("'.$_SESSION["error"].'"); }, 0);';
//     unset($_SESSION['error']);
// }

