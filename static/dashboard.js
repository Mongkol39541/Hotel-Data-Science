document.addEventListener('DOMContentLoaded', function () {
  let controller = new ScrollMagic.Controller();

  let timeline1 = gsap.timeline();
  timeline1.from("#animation1", { duration: 1, x: -200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation1",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline1)
    .addTo(controller);

  let timeline2 = gsap.timeline();
  timeline2.from("#animation2", { duration: 1, x: 200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation2",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline2)
    .addTo(controller);

  let timeline3 = gsap.timeline();
  timeline3.from("#animation3", { duration: 1, y: 200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation3",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline3)
    .addTo(controller);

  let timeline4 = gsap.timeline();
  timeline4.from("#animation4", { duration: 1, x: 200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation4",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline4)
    .addTo(controller);

  let timeline5 = gsap.timeline();
  timeline5.from("#animation5", { duration: 1, x: -200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation5",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline5)
    .addTo(controller);

  let timeline6 = gsap.timeline();
  timeline6.from("#animation6", { duration: 1, x: 200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation6",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline6)
    .addTo(controller);

  let timeline7 = gsap.timeline();
  timeline7.from("#animation7", { duration: 1, x: -200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation7",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline7)
    .addTo(controller);

  let timeline8 = gsap.timeline();
  timeline8.from("#animation8", { duration: 1, x: 200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation8",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline8)
    .addTo(controller);

  let timeline9 = gsap.timeline();
  timeline9.from("#animation9", { duration: 1, x: -200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation9",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline9)
    .addTo(controller);

  let timeline10 = gsap.timeline();
  timeline10.from("#animation10", { duration: 1, x: 200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation10",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline10)
    .addTo(controller);

  let timeline11 = gsap.timeline();
  timeline11.from("#animation11", { duration: 1, y: -200, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation11",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline11)
    .addTo(controller);

  let timeline12 = gsap.timeline();
  timeline12.from("#animation12", { duration: 1, y: 100, opacity: 0 });
  new ScrollMagic.Scene({
    triggerElement: "#animation12",
    triggerHook: 1,
    reverse: true
  })
    .setTween(timeline12)
    .addTo(controller);
});

$(document).ready(function () {
  var table = $('#tableSearch').DataTable({
    lengthChange: true,
    buttons: ['copy', 'excel', 'pdf', 'csv', 'colvis'],
    lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
  });
  table.buttons().container()
    .appendTo('#tableSearch_wrapper .col-md-6:eq(0)');
});

document.addEventListener("DOMContentLoaded", function () {
  var startDateInput = document.getElementById("startDate");
  var endDateInput = document.getElementById("endDate");

  var startDatePicker = flatpickr(startDateInput, {
    dateFormat: "Y-m-d",
    enableTime: false,
    time_24hr: true,
    onChange: function (selectedDates, dateStr) {
      startDatePicker.set("maxDate", endDateInput.value);
      if (selectedDates[0] > new Date(endDateInput.value)) {
        endDateInput.value = dateStr;
      }
    },
  });

  var endDatePicker = flatpickr(endDateInput, {
    dateFormat: "Y-m-d",
    enableTime: false,
    time_24hr: true,
    onChange: function (selectedDates, dateStr) {
      endDatePicker.set("minDate", startDateInput.value);
      if (selectedDates[0] < new Date(startDateInput.value)) {
        startDateInput.value = dateStr;
      }
    },
  });
});

const xpie = document.getElementById('days-pie').value;
x_pie = xpie.split(" ").slice(0, -1);
const ypie = document.getElementById('pays-pie').value;
y_pie = ypie.split(" ").slice(0, -1);
const data_pie = {
  labels: x_pie,
  datasets: [{
    data: y_pie,
    backgroundColor: [
      'rgba(255, 99, 132, 0.8)',
      'rgba(255, 159, 64, 0.8)',
      'rgba(255, 205, 86, 0.8)',
      'rgba(75, 192, 192, 0.8)',
      'rgba(54, 162, 235, 0.8)',
      'rgba(153, 102, 255, 0.8)',
      'rgba(201, 203, 207, 0.8)'
    ],
    hoverOffset: 4
  }]
};
new Chart("Chart-polarArea", {
  type: 'polarArea',
  data: data_pie,
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Daily sales of each day'
      }
    }
  }
});

const ymale = document.getElementById('paysmale-pie').value;
y_male = ymale.split(" ").slice(0, -1);
const yfemale = document.getElementById('paysfemale-pie').value;
y_female = yfemale.split(" ").slice(0, -1);
const data_radar = {
  labels: x_pie,
  datasets: [
    {
      label: 'Male',
      data: y_male,
      backgroundColor: ['rgba(54, 162, 235, 0.8)'],
      hoverOffset: 4
    },
    {
      label: 'Female',
      data: y_female,
      backgroundColor: ['rgba(255, 99, 132, 0.8)'],
      hoverOffset: 4
    }]
};
new Chart("Chart-radar", {
  type: 'radar',
  data: data_radar,
  options: {
    plugins: {
      title: {
        display: true,
        text: 'Daily sales of each day'
      }
    }
  }
});

const xbar1 = document.getElementById('cash-bar').value;
const xbar2 = document.getElementById('credit-bar').value;
const data_bar1 = {
  labels: ['Cash', 'Credit Card'],
  datasets: [{
    data: [xbar1, xbar2],
    backgroundColor: [
      'rgba(75, 192, 192, 0.8)',
      'rgba(54, 162, 235, 0.8)'
    ],
    hoverOffset: 4
  }]
};
new Chart("Chart-Bar-P", {
  type: 'bar',
  data: data_bar1,
  options: {
    plugins: {
      legend: {
        display: false,
      },
      title: {
        display: true,
        text: 'Total credit card usage and transfers'
      }
    }
  }
});

const xbar3 = document.getElementById('standard-bar').value;
const xbar4 = document.getElementById('suite-bar').value;
const xbar5 = document.getElementById('deluxe-bar').value;
const xbar6 = document.getElementById('executive-bar').value;
const xbar7 = document.getElementById('family-bar').value;
const data_bar2 = {
  labels: ['Standard', 'Suite', 'Deluxe', 'Executive', 'Family'],
  datasets: [{
    data: [xbar3, xbar4, xbar5, xbar6, xbar7],
    backgroundColor: [
      'rgba(255, 99, 132, 0.8)',
      'rgba(255, 159, 64, 0.8)',
      'rgba(255, 205, 86, 0.8)',
      'rgba(201, 203, 207, 0.8)'
    ],
    hoverOffset: 4
  }]
};
new Chart("Chart-Bar-R", {
  type: 'bar',
  data: data_bar2,
  options: {
    plugins: {
      legend: {
        display: false,
      },
      title: {
        display: true,
        text: 'Total bookings for each room type'
      }
    }
  }
});

const startDate = document.getElementById('start-date').value;
const endDate = document.getElementById('end-date').value;
const dateRange = [];
const currentDate = new Date(startDate);
while (currentDate <= new Date(endDate)) {
  dateRange.push(currentDate.toISOString().split('T')[0]);
  currentDate.setDate(currentDate.getDate() + 1);
}
const linesday = document.getElementById('lines-lines').value;
const totalday = document.getElementById('total-lines').value;
lines_day = linesday.split(" ").slice(0, -1);
total_day = totalday.split(" ").slice(0, -1);
const paymentData = [];
for (let i = 0; i < lines_day.length; i++) {
  paymentData.push([lines_day[i], parseInt(total_day[i], 10)]);
}
const dailyPayments = {};
paymentData.forEach(([date, amount]) => {
  if (!dailyPayments[date]) {
    dailyPayments[date] = 0;
  }
  dailyPayments[date] += amount;
});
const yAxisData = dateRange.map(date => dailyPayments[date] || 0);
new Chart("Multiple-Lines", {
  type: "line",
  data: {
    labels: dateRange,
    datasets: [{
      data: yAxisData,
      borderColor: 'rgba(255, 99, 132, 1)',
      backgroundColor: 'rgba(255, 99, 132, 0.5)',
      fill: false
    }]
  },
  options: {
    plugins: {
      legend: {
        display: false,
      },
      title: {
        display: true,
        text: 'Daily sales'
      }
    }
  }
});