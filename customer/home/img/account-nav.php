<?php
$email = $_SESSION['email_account'];
?>

<header>
   <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <!-- Navbar brand -->
            <a class="navbar-brand me-2" href="account.php">
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
                        <a class="nav-link" href="account.php">Home</a>
                    </li>

                    <li class="nav-item dropdown mx-2">
                        <a class="nav-link dropdown-toggle" id="roomsDropdown" role="button"
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
                    <div class="btn-group shadow-none me-4 user-nav">
                        <a role="button" class="dropdown-toggle text-dark" data-mdb-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user"></i> <?php echo $email ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <!-- <li><a class="dropdown-item" href="password.php"><i class="fas fa-info-circle me-1"></i> Change Password</a></li> -->
                            <li><a class="dropdown-item" href="account.php?logout=1"><i class="fas fa-arrow-right-to-bracket me-1"></i> Log out</a></li>
                        </ul>
                    </div>
                    <a role="button" class="btn btn-secondary btn-lg px-3 me-2 book-nav" href="#">My Booking</a>
                </div>
            </div>
            <!-- Collapsible wrapper -->
        </div>
    </nav>
    <!-- Navbar -->
    </header>