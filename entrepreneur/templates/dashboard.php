<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Entrepreneur</title>
  <link rel="icon" href="../static/logo.png">
  <link rel="stylesheet" href="../static/style.css">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/material_green.css">
</head>

<body>
  <header>
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
      <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
          <a href="../index.php" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
            <i class="fas fa-user-group fa-fw me-3"></i><span>Administrator</span>
          </a>
          <a href="../templates/reserva.html" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fa-solid fa-table-list fa-fw me-3"></i><span>Reservation info.</span>
          </a>
          <a href="../templates/room.html" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fas fa-list-check fa-fw me-3"></i><span>Room info.</span></a>
          <a href="../templates/dashboard.php" class="list-group-item list-group-item-action py-2 ripple active">
            <i class="fas fa-chart-line fa-fw me-3"></i><span>Dashboard</span></a>
          <a href="../templates/manage_room.php" class="list-group-item list-group-item-action py-2 ripple">
            <i class="fa-solid fa-network-wired fa-fw me-3"></i><span>Manage Room</span>
          </a>
        </div>
      </div>
    </nav>
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php">
          <img src="../static/logo.png" width="40" alt="Hotel Data Science Logo" />
          <h3 class="pt-2"><span class="navbar-text px-2">HTDS</span></h3>
        </a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
          aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fas fa-bars"></i>
        </button>
        <ul class="navbar-nav ms-auto d-flex flex-row">
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-twitter"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-google"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-instagram"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-linkedin"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <i class="fab fa-github"></i>
          </a>
          <a class="nav-link me-3 me-lg-0" href="#">
            <img src="../static/M088.jpg" class="rounded-circle" height="30" />
          </a>
        </ul>
      </div>
    </nav>
  </header>

  <main style="margin-top: 58px">
    <div class="text-center bg-image" style="background-image: url('../static/dashboard.png');height: 450px;">
      <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex justify-content-center align-items-center h-100">
          <div class="text-white">
            <h1 class="mb-3">Dashboard</h1>
          </div>
        </div>
      </div>
    </div>

    <div class="container p-5">
      <center>
        <div class="card">
          <div class="card-body">
            <h2>Summary Report</h2>
          </div>
        </div>

        <form method="POST" action="">
          <div class="card mt-3">
            <div class="card-body">
              <h2>Enter Month and Year</h2>
              <div class="input-group mb-3">
                <input type="month" name="selectedMonth" class="form-control mx-3">
                <div class="input-group-append">
                  <button class="btn btn-primary mx-3 me-2" id="submitBtn" type="submit">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </form>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "9hotel_reservation";
        $desiredMonth = date("Y-m");
        if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST["selectedMonth"])) {
          $desiredMonth = $_POST["selectedMonth"];
          if (empty($desiredMonth)) {
            $desiredMonth = date("Y-m");
          }
        }
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        $sql = "SELECT r.reserve_id, r.room_type, r.check_in, r.check_out, t.payment_date, t.total_price, t.payment_type FROM `reservation` r JOIN `transaction` t USING(reserve_id) WHERE DATE_FORMAT(r.check_in, '%Y-%m') <= '$desiredMonth' AND DATE_FORMAT(r.check_out, '%Y-%m') >= '$desiredMonth';";
        $sql_salary = "SELECT SUM(salary) AS expenses FROM `reception`;";
        $sql_reser = "SELECT COUNT(reserve_id) AS reserve, COUNT(DISTINCT room_id) AS numroom FROM `reservation` WHERE DATE_FORMAT(check_in, '%Y-%m') <= '$desiredMonth' AND DATE_FORMAT(check_out, '%Y-%m') >= '$desiredMonth';";
        $sql_people = "SELECT role, COUNT(*) as count_of_people FROM member GROUP BY role ORDER BY role;";
        $result = mysqli_query($conn, $sql);
        $result_salary = mysqli_query($conn, $sql_salary);
        $result_reser = mysqli_query($conn, $sql_reser);
        $result_people = mysqli_query($conn, $sql_people);
        $income = 0;
        if (mysqli_num_rows($result) > 0) {
          while($row = mysqli_fetch_assoc($result)) {
            $income += $row['total_price'];
          }
        }
        if ($result_salary and $result_reser) {
          $row = mysqli_fetch_assoc($result_salary);
          $expenses = $row['expenses'];
          $row = mysqli_fetch_assoc($result_reser);
          $reserve = $row['reserve'];
          $numroom = $row['numroom'];
        }
        $num_preple = array();
        while($row = mysqli_fetch_assoc($result_people)) {
          array_push($num_preple, $row['count_of_people']);
        }
        ?>

        <div class="row">
          <div class="col mt-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between px-md-1">
                  <div>
                  <p class="mb-0">Customers (person)</p>
                  <h3 class="text-primary"><?php echo $num_preple[0]; ?></h3>
                  </div>
                  <div class="align-self-center">
                    <i class="fa-solid fa-user text-primary fa-3x"></i>
                  </div>
                </div>
                <div class="px-md-1">
                  <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo ($num_preple[0]/array_sum($num_preple))*100; ?>%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col mt-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between px-md-1">
                  <div>
                    <p class="mb-0">Owners (person)</p>
                    <h3 class="text-secondary"><?php echo $num_preple[1]; ?></h3>
                  </div>
                  <div class="align-self-center">
                    <i class="fa-solid fa-user-tie text-secondary fa-3x"></i>
                  </div>
                </div>
                <div class="px-md-1">
                  <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                    <div class="progress-bar bg-secondary" role="progressbar" style="width: <?php echo ($num_preple[1]/array_sum($num_preple))*100; ?>%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col mt-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between px-md-1">
                  <div>
                    <p class="mb-0">Receptions (person)</p>
                    <h3 class="text-dark"><?php echo $num_preple[2]; ?></h3>
                  </div>
                  <div class="align-self-center">
                    <i class="fa-solid fa-user-secret text-dark fa-3x"></i>
                  </div>
                </div>
                <div class="px-md-1">
                  <div class="progress mt-3 mb-1 rounded" style="height: 7px">
                    <div class="progress-bar bg-dark" role="progressbar" style="width: <?php echo ($num_preple[2]/array_sum($num_preple))*100; ?>%"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <div class="row">
          <div class="col mt-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between p-md-1">
                  <div class="d-flex flex-row">
                    <div class="align-self-center">
                      <i class="fa-solid fa-book text-info fa-3x me-4"></i>
                    </div>
                    <div class="align-self-center">
                      <h4>Total Reservations</h4>
                    </div>
                  </div>
                  <div class="align-self-center">
                    <h2 class="h1 mb-0"><?php echo $reserve; ?></h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col mt-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between p-md-1">
                  <div class="d-flex flex-row">
                    <div class="align-self-center">
                      <i class="fa-brands fa-buromobelexperte  text-danger fa-3x px-2"></i>
                    </div>
                    <div class="align-self-center">
                      <h4>Reserved Rooms</h4>
                    </div>
                  </div>
                  <div class="align-self-center">
                    <h2 class="h1 mb-0"><?php echo $numroom; ?></h2>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col mt-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between p-md-1">
                  <div class="d-flex flex-row">
                    <div class="align-self-center">
                      <h2 class="h1 mb-0 me-4">$<?php echo number_format($income); ?></h2>
                    </div>
                    <div class="align-self-center">
                      <h4>Total Revenue</h4>
                      <p class="mb-0">(Price * Tax) - Discount</p>
                    </div>
                  </div>
                  <div class="align-self-center">
                    <i class="fa-solid fa-hand-holding-dollar text-warning fa-3x me-4"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col mt-3">
            <div class="card">
              <div class="card-body">
                <div class="d-flex justify-content-between p-md-1">
                  <div class="d-flex flex-row">
                    <div class="align-self-center">
                      <h2 class="h1 mb-0 me-4">$<?php echo number_format($expenses); ?></h2>
                    </div>
                    <div class="align-self-center">
                      <h4>Total Expenses</h4>
                    </div>
                  </div>
                  <div class="align-self-center">
                    <i class="fa-solid fa-basket-shopping text-success fa-3x"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <h2>Reservation list and Payment list</h2>
            <br>
            <div class="table-responsive">
              <table class="table table-hover" id="tableSearch">
                <thead>
                  <tr>
                    <th>Reserve ID</th>
                    <th>Check IN</th>
                    <th>Check OUT</th>
                    <th>Payment Date</th>
                    <th>Total Price</th>
                    <th>Payment Type</th>
                    <th>Room Type</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $number_of_results = mysqli_num_rows($result);
                    $sql = "SELECT r.reserve_id, r.room_type, r.check_in, r.check_out, t.payment_date, t.total_price, t.payment_type FROM `reservation` r JOIN `transaction` t USING(reserve_id);";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td><p class="fw-bold mb-1">' . $row["reserve_id"] . '</p></td>';
                            echo '<td><p class="text-muted mb-0">' . $row["check_in"] . '</p></td>';
                            echo '<td><p class="text-muted mb-0">' . $row["check_out"] . '</p></td>';
                            echo '<td><p class="text-muted mb-0">' . $row["payment_date"] . '</p></td>';
                            echo '<td><p class="text-muted mb-0">' . $row["total_price"] . '</p></td>';
                            if ($row["payment_type"] == 'Cash') {
                              echo '<td><span class="badge badge-light rounded-pill d-inline">' . $row["payment_type"] . '</span></td>';
                            } else {
                              echo '<td><span class="badge badge-dark rounded-pill d-inline">' . $row["payment_type"] . '</span></td>';
                            }
                            if ($row["room_type"] == 'Standard') {
                              echo '<td><span class="badge badge-primary rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                            } elseif ($row["room_type"] == 'Deluxe') {
                              echo '<td><span class="badge badge-success rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                            } elseif ($row["room_type"] == 'Suite') {
                              echo '<td><span class="badge badge-danger rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                            } elseif ($row["room_type"] == 'Executive') {
                              echo '<td><span class="badge badge-warning rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                            }  else {
                              echo '<td><span class="badge badge-info rounded-pill d-inline">' . $row["room_type"] . '</span></td>';
                            }
                            echo '</tr>';
                        }
                    }
                    mysqli_close($conn);
                 ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <h2>Data Visualization</h2>
          </div>
        </div>

        <div class="card mt-3">
          <div class="card-body">
            <form enctype="multipart/form-data" action="" method="POST">
              <div class="row">
                <div class="col-md-6 mb-4">
                  <label for="startDate" class="form-label">Start Date :</label>
                  <input type="text" id="startDate" name="startDate" class="form-control" data-toggle="flatpickr">
                </div>
                <div class="col-md-6 mb-4">
                  <label for="endDate" class="form-label">End Date :</label>
                  <input type="text" id="endDate" name="endDate" class="form-control" data-toggle="flatpickr">
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-center mb-4">
                  <button type="submit" name="analyze" class="btn btn-info px-3 me-2">Analyze Bookings By Time Period</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        <?php
          if (isset($_POST["analyze"])) {
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "9hotel_reservation";
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            $startDate = $_POST['startDate'];
            $endDate = $_POST['endDate'];
            if ($startDate == '' and $endDate == '') {
              $sql = "SELECT r.reserve_id, r.room_type, r.check_in, r.check_out, t.payment_date, t.total_price, t.payment_type, m.title FROM `reservation` r JOIN `transaction` t USING(reserve_id) JOIN `guest` g USING(reserve_id) JOIN `customer` c USING(customer_id) JOIN `member` m USING(member_id);";
              $sqlDate = "SELECT MIN(payment_date) as earliest_date1, MAX(payment_date) as earliest_date2 FROM `transaction`;";
              $sqlSex = "SELECT  FROM `transaction` JOIN `guest` USING(reserve_id) JOIN `customer` USING(customer_id) JOIN `customer` USING(member_id);";
              $result = mysqli_query($conn, $sqlDate);
              $row = mysqli_fetch_assoc($result);
              $startDate = $row['earliest_date1'];
              $endDate = $row['earliest_date2'];
            } elseif ($startDate == '') {
              $sql = "SELECT r.reserve_id, r.room_type, r.check_in, r.check_out, t.payment_date, t.total_price, t.payment_type, m.title FROM `reservation` r JOIN `transaction` t USING(reserve_id) JOIN `guest` g USING(reserve_id) JOIN `customer` c USING(customer_id) JOIN `member` m USING(member_id) WHERE t.payment_date <= '$endDate' ORDER BY t.payment_date ASC;";
              $sqlDate = "SELECT MIN(payment_date) as earliest_date FROM `transaction` WHERE payment_date <= '$endDate'";
              $result = mysqli_query($conn, $sqlDate);
              $row = mysqli_fetch_assoc($result);
              $startDate = $row['earliest_date'];
            } elseif ($endDate == '') {
              $sql = "SELECT r.reserve_id, r.room_type, r.check_in, r.check_out, t.payment_date, t.total_price, t.payment_type, m.title FROM `reservation` r JOIN `transaction` t USING(reserve_id) JOIN `guest` g USING(reserve_id) JOIN `customer` c USING(customer_id) JOIN `member` m USING(member_id) WHERE t.payment_date >= '$startDate' ORDER BY t.payment_date ASC;";
              $sqlDate = "SELECT MAX(payment_date) as earliest_date FROM `transaction` WHERE payment_date >= '$startDate'";
              $result = mysqli_query($conn, $sqlDate);
              $row = mysqli_fetch_assoc($result);
              $endDate = $row['earliest_date'];
            } else {
              $sql = "SELECT r.reserve_id, r.room_type, r.check_in, r.check_out, t.payment_date, t.total_price, t.payment_type, m.title FROM `reservation` r JOIN `transaction` t USING(reserve_id) JOIN `guest` g USING(reserve_id) JOIN `customer` c USING(customer_id) JOIN `member` m USING(member_id) WHERE t.payment_date >= '$startDate' AND t.payment_date <= '$endDate' ORDER BY t.payment_date ASC;";
            }
            $result = mysqli_query($conn, $sql);

            $daysOfWeek = array(
              'Sunday' => 0,
              'Monday' => 0,
              'Tuesday' => 0,
              'Wednesday' => 0,
              'Thursday' => 0,
              'Friday' => 0,
              'Saturday' => 0,
              );

              $daysOfWeek_male = array(
                'Sunday' => 0,
                'Monday' => 0,
                'Tuesday' => 0,
                'Wednesday' => 0,
                'Thursday' => 0,
                'Friday' => 0,
                'Saturday' => 0,
              );
              
              $daysOfWeek_female = array(
                'Sunday' => 0,
                'Monday' => 0,
                'Tuesday' => 0,
                'Wednesday' => 0,
                'Thursday' => 0,
                'Friday' => 0,
                'Saturday' => 0,
              );

              $linesday = "";
              $totalday = "";
              $payment_cash = 0;
              $payment_credit = 0;
              $room_standard = 0;
              $room_suite = 0;
              $room_deluxe = 0;
              $room_executive = 0;
              $room_family = 0;
              if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                  $paymentDate = new DateTime($row['payment_date']);
                  $dayOfWeek = $paymentDate->format('l');
                  $daysOfWeek[$dayOfWeek] += $row['total_price'];
                  if ($row['title'] == 'Mr.') {
                    $daysOfWeek_male[$dayOfWeek] += $row['total_price'];
                  } elseif ($row['title'] == 'Mrs.') {
                    $daysOfWeek_female[$dayOfWeek] += $row['total_price'];
                  }
                  $linesday .= $row['payment_date'] ." ";
                  $totalday .= $row['total_price'] ." ";
                  if ($row['payment_type'] == 'Cash') {
                    $payment_cash += $row['total_price'];
                  } else {
                    $payment_credit += $row['total_price'];
                  }
                  if ($row['room_type'] == 'Standard') {
                    $room_standard += $row['total_price'];
                  } elseif ($row['room_type'] == 'Suite') {
                    $room_suite += $row['total_price'];
                  } elseif ($row['room_type'] == 'Deluxe') {
                    $room_deluxe += $row['total_price'];
                  } elseif ($row['room_type'] == 'Executive') {
                    $room_executive += $row['total_price'];
                  } else {
                    $room_family += $row['total_price'];
                  }
                }
              }

              $days = "";
              $pays = "";
              foreach ($daysOfWeek as $day => $total) {
                $days .= $day ." ";
                $pays .= $total ." ";
              }

              $pays_male = "";
              foreach ($daysOfWeek_male as $day => $total) {
                $pays_male .= $total ." ";
              }

              $pays_female = "";
              foreach ($daysOfWeek_female as $day => $total) {
                $pays_female .= $total ." ";
              }

              echo '<input type="text" id="start-date" value="' .$startDate . '" hidden>';
              echo '<input type="text" id="end-date" value="' .$endDate . '" hidden>';
              echo '<input type="text" id="days-pie" value="' .$days . '" hidden>';
              echo '<input type="text" id="pays-pie" value="' .$pays . '" hidden>';
              echo '<input type="text" id="paysmale-pie" value="' .$pays_male . '" hidden>';
              echo '<input type="text" id="paysfemale-pie" value="' .$pays_female . '" hidden>';
              echo '<input type="text" id="cash-bar" value="' .$payment_cash . '" hidden>';
              echo '<input type="text" id="credit-bar" value="' .$payment_credit . '" hidden>';
              echo '<input type="text" id="standard-bar" value="' .$room_standard . '" hidden>';
              echo '<input type="text" id="suite-bar" value="' .$room_suite . '" hidden>';
              echo '<input type="text" id="deluxe-bar" value="' .$room_deluxe . '" hidden>';
              echo '<input type="text" id="executive-bar" value="' .$room_executive . '" hidden>';
              echo '<input type="text" id="family-bar" value="' .$room_family . '" hidden>';
              echo '<input type="text" id="lines-lines" value="' .$linesday . '" hidden>';
              echo '<input type="text" id="total-lines" value="' .$totalday . '" hidden>';

              echo '<div class="row mt-3">
                      <div class="col">
                        <div class="card">
                          <div class="card-body">
                            <canvas id="Chart-polarArea"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card">
                          <div class="card-body">
                            <canvas id="Chart-radar"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>';

              echo '<div class="row mt-3">
                      <div class="col">
                        <div class="card">
                          <div class="card-body">
                            <canvas id="Chart-Bar-P"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="col">
                        <div class="card">
                          <div class="card-body">
                            <canvas id="Chart-Bar-R"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>';

              echo '<div class="row mt-3">
                      <div class="col">
                        <div class="card">
                          <div class="card-body">
                            <canvas id="Multiple-Lines"></canvas>
                          </div>
                        </div>
                      </div>
                    </div>';
              echo '</center>';
              echo '</div>';

              mysqli_close($conn);
            }
          ?>
      </center>
    </div>
  </main>


  <footer class="text-center text-lg-start bg-light text-muted">
    <section class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom">
      <div class="me-5 d-none d-lg-block">
        <span>Get connected with us on social networks:</span>
      </div>
    </section>
    <div class="container text-center text-md-start mt-5">
      <div class="row mt-3">
        <div class="col-md-3 mx-auto mb-4">
          <h6 class="text-uppercase fw-bold mb-4">
            <i class="fas fa-gem me-3"></i>Hotel Data Scientist
          </h6>
          <p>
            Hotel Data Scientists leverage data analytics and machine learning to enhance hotel
            operations and guest experiences, optimizing revenue and efficiency. They require
            proficiency in data analysis tools, domain knowledge, and strong communication skills.
          </p>
        </div>
        <div class="col-md-2 mx-auto">
          <h6 class="text-uppercase fw-bold mb-4">
            Tools
          </h6>
          <div class='row'>
            <p class='col'>
              <a href="#!" class="text-reset">HTML</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">CSS</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">Javascript</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">MDBootstrap</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">PHP</a>
            </p>
            <p class='col'>
              <a href="#!" class="text-reset">MySQL</a>
            </p>
          </div>
        </div>
        <div class="col-md-3 mx-auto mb-md-0">
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="fas fa-home me-3"></i>King Mongkut's Institute of Technology Ladkrabang</p>
          <p>
            <i class="fas fa-envelope me-3"></i>
            it@kmitl.ac.th
          </p>
          <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
          <p><i class="fas fa-print me-3"></i> + 01 234 567 89</p>
        </div>
      </div>
    </div>
    <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
      © 2023 Copyright:
      <a class="text-reset fw-bold" href="#">HTDS.com</a>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.1/mdb.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="../static/dashboard2.js"></script>
</body>

</html>