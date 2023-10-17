document.addEventListener("DOMContentLoaded", function () {
    var startDateInput = document.getElementById("startDate");
    var endDateInput = document.getElementById("endDate");

    var startDatePicker = flatpickr(startDateInput, {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        onChange: function (selectedDates, dateStr) {
            startDatePicker.set("maxDate", endDateInput.value);
            if (selectedDates[0] > new Date(endDateInput.value)) {
                endDateInput.value = dateStr;
            }
        },
    });

    var endDatePicker = flatpickr(endDateInput, {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        onChange: function (selectedDates, dateStr) {
            endDatePicker.set("minDate", startDateInput.value);
            if (selectedDates[0] < new Date(startDateInput.value)) {
                startDateInput.value = dateStr;
            }
        },
    });
});