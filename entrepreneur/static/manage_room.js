$(document).ready(function () {
    var table = $('#tableSearch').DataTable({
        lengthChange: true,
        buttons: ['copy', 'excel', 'pdf', 'csv', 'colvis'],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    table.buttons().container()
        .appendTo('#tableSearch_wrapper .col-md-6:eq(0)');
});

(() => {
    'use strict';
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach((form) => {
        form.addEventListener('submit', (event) => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
})();

mdb.Alert.getInstance(document.getElementById("alertExample")).update({
    position: "top-right",
    delay: 2000,
    autohide: false,
    width: "600px",
    offset: 20,
    stacking: false,
    appendToBody: false,
});

