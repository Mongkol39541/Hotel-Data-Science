<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking Calendar</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.css" rel="stylesheet" />
</head>
<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "9hotel_reservation";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
$reservations = array();
$sql = "SELECT reservation.check_in, reservation.check_out FROM reservation JOIN room USING (room_id) WHERE room.room_type = 'Standard' AND room.bed_type = 'Single';";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}
?>
<div class="container mt-3"> 
    <center>
        <div class="card">
            <div class="card-body">
                <h2>ปฎิทินการจอง</h2>
                <div id="calendarContainer">
                    <div id="calendarHeader">
                        <div class="row">
                            <div class="col">
                                <button id="prevMonth" class="btn btn-primary">เดือนก่อนหน้า</button>
                            </div>
                            <div class="col">
                                <h3 id="currentMonth"></h3>
                            </div>
                            <div class="col">
                                <button id="nextMonth" class="btn btn-primary">เดือนถัดไป</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="table-primary">อาทิตย์</th>
                                <th class="table-primary">จันทร์</th>
                                <th class="table-primary">อังคาร</th>
                                <th class="table-primary">พุธ</th>
                                <th class="table-primary">พฤหัสบดี</th>
                                <th class="table-primary">ศุกร์</th>
                                <th class="table-primary">เสาร์</th>
                            </tr>
                        </thead>
                            <tbody id="calendarBody" class="text-center">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </center>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const currentMonthElement = document.getElementById("currentMonth");
    const calendarBody = document.getElementById("calendarBody");

    const prevMonthButton = document.getElementById("prevMonth");
    const nextMonthButton = document.getElementById("nextMonth");

    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();

    function generateCalendar(year, month, reservations) {
        const firstDay = new Date(year, month, 1);
        const lastDay = new Date(year, month + 1, 0);
        let dayCounter = 1;
        let html = '';
        for (let i = 0; i < 6; i++) {
            html += '<tr>';
            for (let j = 0; j < 7; j++) {
                const day = (i * 7 + j) - firstDay.getDay() + 1;
                if (day > 0 && day <= lastDay.getDate()) {
                    const current_date = year + '-' + (month + 1).toString().padStart(2, '0') + '-' + day.toString().padStart(2, '0');
                    let status = 'ว่าง';
                    let color = 'success';

                    reservations.forEach(reservation => {
                        if (reservation.check_in <= current_date && current_date <= reservation.check_out) {
                            status = 'ไม่ว่าง';
                            color = 'danger';
                        }
                    });
                    html += '<td class="table-' + color + '">' + day + '<br>' + status + '</td>';
                } else if (dayCounter == 36) {
                    break;
                } else {
                    html += '<td></td>';
                }
                dayCounter += 1;
            }
            html += '</tr>';
        }

        calendarBody.innerHTML = html;
    }

    function changeMonth(change) {
        currentMonth += change;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        currentDate.setFullYear(currentYear, currentMonth);
        generateCalendar(currentYear, currentMonth, <?php echo json_encode($reservations); ?>);
        currentMonthElement.textContent = currentYear + " - " + (currentMonth + 1);
    }

    generateCalendar(currentYear, currentMonth, <?php echo json_encode($reservations); ?>);
    currentMonthElement.textContent = currentYear + " - " + (currentMonth + 1);
    prevMonthButton.addEventListener("click", () => changeMonth(-1));
    nextMonthButton.addEventListener("click", () => changeMonth(1));
});
</script>
<script
  type="text/javascript"
  src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.2/mdb.min.js"
></script>

</body>
</html>