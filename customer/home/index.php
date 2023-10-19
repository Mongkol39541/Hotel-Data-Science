<!-- หน้าหลักเว็บไซต์โรงแรม : สมัครสมาชิก, เข้าสู่ระบบ -->

<!-- In precess : banner room discover contact footer -->
<?php
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
    <title>The Nine Hotel</title>

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
        .login-nav,
        .signup-nav {
            border-radius: 0px;
            font-weight: 600;
        }

        .signup-nav:hover {
            background: #3B71CA;
        }

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
            .navbar-nav .nav-item.dropdown:hover .dropdown-menu {
                display: block;
            }

            .navbar-nav .nav-item.dropdown .dropdown-menu {
                position: relative;
                width: 100%;
                top: 100%;
                left: 0;
                z-index: 1000;
                float: none;
                box-sizing: border-box;
                box-shadow: none;
            }

            .navbar-nav .nav-link {
                font-size: 1rem;
                position: relative;
            }

            #firstmenu {
                border-top: 1px solid #eee;
            }

            .login-nav,
            .signup-nav {
                margin-bottom: 5px;
            }
        }

        .carousel-inner .carousel-item {
            transition: 2s ease-in-out; /* 1s = 1 second */
        }
    </style>
</head>
<body>
    <header>
        <!-- Navbar -->
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
                            <a class="nav-link" href="discover.php">Discover</a>
                        </li>
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="contact.php">Contact</a>
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

    <!-- Carousel wrapper -->
    <div id="carouselBasicExample" class="carousel slide" data-mdb-ride="carousel" data-mdb-interval="4500">
        <!-- Indicators -->
        <div class="carousel-indicators">
            <button
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide-to="0"
            class="active"
            aria-current="true"
            aria-label="Slide 1"
            ></button>
            <button
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide-to="1"
            aria-label="Slide 2"
            ></button>
            <button
            type="button"
            data-mdb-target="#carouselBasicExample"
            data-mdb-slide-to="2"
            aria-label="Slide 3"
            ></button>
        </div>

        <!-- Inner -->
        <div class="carousel-inner" style="max-height: 500px;">
            <!-- Single item -->
            <div class="carousel-item active">
                <div
                    class="p-5 text-center bg-image"
                    style="
                    background-image: url('https://images.unsplash.com/photo-1598605272254-16f0c0ecdfa5?auto=format&fit=crop&q=80&w=2942&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
                    height: 500px;
                    "
                >
                    <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-white">
                        <h1 class="mb-3 fw-bold" style="font-size: 4rem;">The Nine Hotel</h1>
                        <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Ladkrabang, Bangkok</h2>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <div
                    class="p-5 text-center bg-image"
                    style="
                    background-image: url('https://images.unsplash.com/photo-1611048267451-e6ed903d4a38?auto=format&fit=crop&q=80&w=2944&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
                    height: 500px;
                    "
                >
                    <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-white">
                        <h1 style="font-size: 2.5rem;">Comfortable, fuss-free and functional</h1>
                        </div>
                    </div>
                    </div>
                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <div
                    class="p-5 text-center bg-image"
                    style="
                    background-image: url('https://images.unsplash.com/photo-1621293954908-907159247fc8?auto=format&fit=crop&q=80&w=2940&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D');
                    height: 500px;
                    "
                >
                    <div class="mask" style="background-color: rgba(0, 0, 0, 0.3);">
                    <div class="d-flex justify-content-center align-items-center h-100">
                        <div class="text-white">
                        <h1 class="mb-3 fw-bold" style="font-size: 4rem;">The Nine Hotel</h1>
                        <h2 class="mb-3 fw-bold" style="font-size: 1.5rem;">Ladkrabang, Bangkok</h2>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Inner -->

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Carousel wrapper -->

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
                <!-- <a href="forgot.php" class="forgot-pass">Forgot password?</a> -->
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

    <!-- Discovery -->
    <div class="container p-4">
        <div class="heading text-center">
                <h1 class="text-dark">Discover</h1>
        </div>
        <!-- Tabs navs -->
        <ul class="nav nav-tabs nav-fill mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
            <a
            class="nav-link active"
            id="ex2-tab-1"
            data-mdb-toggle="tab"
            href="#ex2-tabs-1"
            role="tab"
            aria-controls="ex2-tabs-1"
            aria-selected="true"
            >Gallery</a
            >
        </li>
        <li class="nav-item" role="presentation">
            <a
            class="nav-link"
            id="ex2-tab-2"
            data-mdb-toggle="tab"
            href="#ex2-tabs-2"
            role="tab"
            aria-controls="ex2-tabs-2"
            aria-selected="false"
            >Dining</a
            >
        </li>
        <li class="nav-item" role="presentation">
            <a
            class="nav-link"
            id="ex2-tab-3"
            data-mdb-toggle="tab"
            href="#ex2-tabs-3"
            role="tab"
            aria-controls="ex2-tabs-3"
            aria-selected="false"
            >Service</a
            >
        </li>
        </ul>
        <!-- Tabs navs -->

        <!-- Tabs content -->
        <div class="tab-content" id="ex2-content">
        <div
            class="tab-pane fade show active"
            id="ex2-tabs-1"
            role="tabpanel"
            aria-labelledby="ex2-tab-1"
        >
            <section class="p-4 d-flex justify-content-center text-center w-100">
            <div class="lightbox" data-mdb-lightbox="lightbox-jfhsq3xkv">
                <div class="row">
                <div class="col-lg-4">
                    <img src="https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&q=80&w=2940&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Gallery" class="w-100" height="300px">
                </div>
                <div class="col-lg-4">
                    <img src="https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?auto=format&fit=crop&q=80&w=2940&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Gallery" class="w-100" height="300px">
                </div>
                <div class="col-lg-4">
                    <img src="https://images.unsplash.com/photo-1611048267451-e6ed903d4a38?auto=format&fit=crop&q=80&w=2944&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Gallery" class="w-100" height="300px">
                </div>
                </div>
            </div>
            </section>
        </div>
        <div
            class="tab-pane fade"
            id="ex2-tabs-2"
            role="tabpanel"
            aria-labelledby="ex2-tab-2"
        >
            <section class="p-4 d-flex justify-content-center text-center w-100">
                <div class="lightbox" data-mdb-lightbox="lightbox-jfhsq3xkv">
                    <div class="row">
                    <div class="col-lg-4">
                        <img src="https://images.unsplash.com/photo-1557499305-0af888c3d8ec?auto=format&fit=crop&q=80&w=2940&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Gallery" class="w-100" height="300px">
                    </div>
                    <div class="col-lg-4">
                        <img src="https://images.unsplash.com/photo-1532250327408-9bd6e0ce2c49?auto=format&fit=crop&q=80&w=2874&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Gallery" class="w-100" height="300px">
                    </div>
                    <div class="col-lg-4">
                        <img src="https://images.unsplash.com/photo-1662982696492-057328dce48b?auto=format&fit=crop&q=80&w=2874&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                        alt="Gallery" class="w-100" height="300px">
                    </div>
                    </div>
                </div>
            </section>
        </div>
        <div
        class="tab-pane fade"
        id="ex2-tabs-3"
        role="tabpanel"
        aria-labelledby="ex2-tab-3"
        >
        <section class="p-4 d-flex justify-content-center text-center w-100">
            <div class="lightbox" data-mdb-lightbox="lightbox-jfhsq3xkv">
                <div class="row">
                <div class="col-lg-4">
                    <img src="https://images.unsplash.com/photo-1623718649591-311775a30c43?auto=format&fit=crop&q=80&w=2940&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Gallery" class="w-100" height="300px" >
                </div>
                <div class="col-lg-4">
                    <img src="https://images.unsplash.com/photo-1571902943202-507ec2618e8f?auto=format&fit=crop&q=80&w=2875&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Gallery" class="w-100" height="300px">
                </div>
                <div class="col-lg-4">
                    <img src="https://images.unsplash.com/photo-1461963040894-7ee721035376?auto=format&fit=crop&q=80&w=2944&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Gallery" class="w-100" height="300px">
                </div>
                </div>
            </div>
        </section>
        </div>
        </div>
        <!-- Tabs content -->
    </div>


    <!-- How to get here -->
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
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="py-2 mx-5 my-4 border-top">
        <p class="text-center text-body-secondary">© 2023 ISAD, KMITL</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    <?php
    if (isset($_SESSION['loginError'])) {
        echo 'document.body.classList.toggle("show-popup-login");';
        echo 'const loginnote = document.querySelector("#loginnote");';
        echo 'loginnote.className = "loginnote show";';
        echo 'loginnote.innerText = "'.$_SESSION['loginError'].'";';
        unset($_SESSION['loginError']);
    }
    ?>

    <?php
        if (isset($_SESSION['error'])) {
            echo 'document.body.classList.toggle("show-popup-signup");';
            echo '   var alertText = "' . $_SESSION['error'] . '";';
            echo '   var alertDiv = \'';
            echo '   <div class="alert alert-danger position-fixed top-0 start-50 translate-middle-x w-25" style="z-index: 102; margin-top:3%;" role="alert" data-mdb-color="danger" data-mdb-offset="20">';
            echo '        <i class="fas fa-times-circle me-3"></i> \' + alertText + \'';
            echo '    </div>\';';
            echo '   $("body").append(alertDiv);';
            echo '   setTimeout(function() {';
            echo '       $(".alert").remove();';
            echo '   }, 6000);';
            echo '   ';
            unset($_SESSION['error']);
        } elseif (isset($_SESSION['success'])) {
            echo 'document.body.classList.toggle("show-popup-login");';
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