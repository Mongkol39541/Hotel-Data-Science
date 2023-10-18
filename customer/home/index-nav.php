<header>
        <nav class="navbar navbar-expand-lg navbar-light bg-white">
            <div class="container">
                <!-- Navbar brand -->
                <a class="navbar-brand me-2" href="index.php">
                    <img src="img/logo.png" height="42" alt="Hotel Logo" loading="lazy" style="margin-top: -1px;" />
                </a>

                <!-- Toggle button -->
                <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                    data-mdb-target="#navbarButtonsExample" aria-controls="navbarButtonsExample" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Collapsible wrapper -->
                <div class="collapse navbar-collapse" id="navbarButtonsExample">
                    <!-- Left links me-auto -->
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li id="firstmenu" class="nav-item mx-2">
                            <a class="nav-link" href="index.php">Home</a>
                        </li>

                        <li class="nav-item dropdown mx-2">
                            <a class="nav-link dropdown-toggle" href="#" id="roomsDropdown" role="button"
                                data-mdb-toggle="dropdown" aria-expanded="false">
                                Rooms
                            </a>
                            <!-- Dropdown menu -->
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
                                    if (mysqli_num_rows($selectRoomType) > 0) {
                                        while($row = mysqli_fetch_row($selectRoomType)) {
                                            echo '<li><a class="dropdown-item" href="roomdetail.php?type='.$row[0].'">'.$row[0].'</a></li>';
                                        }
                                    }
                                ?>
                            </ul>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Discover</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                    </ul>
                    <!-- Left links -->

                    <div class="d-flex align-items-center">
                        <button type="button" class="btn btn-secondary btn-lg px-3 me-2 login-nav">Login</button>
                        <button type="button" class="btn btn-info btn-lg me-3 signup-nav">create account</button>
                    </div>
                </div>
                <!-- Collapsible wrapper -->
            </div>
        </nav>
        <!-- Navbar -->
    </header>

    <!-- Popup Form -->
    <div class="night-bg-overlay"></div>

    <div class="form-popup login">
        <span class="close-btn1 material-symbols-rounded">close</span>

        <div class="form-head">
            <img class="img-responsive logo" src="img/logo.png" alt="The 9 Hotel logo">
        </div>
        <div class="form-content">
            <!-- ฟอร์มเข้าสู่ระบบ -->
            <form action="login.php" method="post" id="login">
                <div class="input-field">
                    <input type="email" name="user_email" id="user_email" required>
                    <label for="user_email">Email</label>
                </div>
                <div class="input-field">
                    <input type="password" name="user_password" id="password" required>
                    <label for="password">Password</label>
                </div>
                <!-- <a href="#" class="forgot-pass">Forgot password?</a> -->
                <p class="loginnote" id="loginnote">error description</p>
                <button type="submit" class="login-btn btn btn-info btn-lg">LOG IN</button>
            </form>
            <div class="bottom-link">
                Don't have an account?
                <a href="#" id="signup-link">Signup</a>
            </div>
        </div>
    </div>

    <div class="form-popup signup">
        <span class="close-btn2 material-symbols-rounded">close</span>

        <div class="form-head">
            <img class="img-responsive logo" src="img/logo.png" alt="The 9 Hotel logo">
        </div>
        <div class="form-content">
            <!-- ฟอร์มสมัครสมาชิก -->
            <form action="signup.php" method="post" id="signup" onsubmit="return validateSignupForm()">
                <div class="row mb-3">
                    <div class="col-md-2 required">
                        <label for="prefix" class="form-label fs-14px text-dark">
                            Salutation
                        </label>
                        <label for="prefix" class="form-label fs-10px"></label>
                        <select id="prefix" name="prefix" class="form-select">
                            <option value="" selected>Prefix</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Ms.">Ms.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Miss">Miss</option>
                        </select>
                    </div>
                    <div class="col-md-5 required">
                        <label class="form-label fs-14px text-dark" for="firstname">First Name</label>
                        <label class="form-label fs-10px" for="firstname"></label>
                        <input type="text" class="form-control" id="firstname"
                            name="firstname" placeholder="First Name (English Only)">
                    </div>
                    <div class="col-md-5 required">
                        <label class="form-label fs-14px text-dark" for="lastname">Last Name</label>
                        <label class="form-label fs-10px" for="lastname"></label>
                        <input type="text" class="form-control" id="lastname"
                            name="lastname" placeholder="Last Name (English Only)">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 required">
                        <label class="form-label fs-14px text-dark" for="email">Email</label>
                        <label class="form-label fs-10px" for="email"></label>
                        <input type="email" class="form-control" id="email"
                            name="email" placeholder="Email">
                    </div>
                    <div class="col-md-6 required">
                        <label class="form-label fs-14px text-dark" for="birthday">Birthday</label>
                        <label class="form-label fs-10px" for="birthday"></label>
                        <input type="date" class="form-control" id="birthday"
                            name="birthday" placeholder="Date of Birth" autocomplete="off">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6 required">
                        <label class="form-label fs-14px text-dark" for="password1">Password</label>
                        <label class="form-label fs-10px" for="password1"></label>
                        <input type="password" class="form-control" id="password1"
                            name="password1" placeholder="Password">
                    </div>
                    <div class="col-md-6 required">
                        <label class="form-label fs-14px text-dark" for="password2">Confirm Password</label>
                        <label class="form-label fs-10px" for="password2"></label>
                        <input type="password" class="form-control" id="password2"
                            name="password2" placeholder="Confirm Password">
                    </div>
                    <div class="col-md-12">
                        <p class="text-danger mt-2 mb-0" id="notation">error description</p>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="signup-btn btn btn-info" id="signup-btn">SIGNUP</button>
                </div>
            </form>
            <div class="bottom-link">
                Already have an account? <a href="#" id="login-link">Login</a>
            </div>
        </div>
    </div>

    <script>
    <?php
    if (isset($_SESSION["success"])) {
        echo 'document.body.classList.toggle("show-popup-login");';
        echo 'setTimeout(function() { alert("'.$_SESSION["success"].'"); }, 0);';
        unset($_SESSION['success']);
    } elseif (isset($_SESSION["error"])) {
        echo 'document.body.classList.toggle("show-popup-signup");';
        echo 'setTimeout(function() { alert("'.$_SESSION["error"].'"); }, 0);';
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['loginError'])) {
        echo 'document.body.classList.toggle("show-popup-login");';
        echo 'const loginnote = document.querySelector("#loginnote");';
        echo 'loginnote.className = "loginnote show";';
        echo 'loginnote.innerText = "'.$_SESSION['loginError'].'";';
        unset($_SESSION['loginError']);
    }
    ?>
    </script>
