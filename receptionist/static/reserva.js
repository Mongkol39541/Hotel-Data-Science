$(document).ready(function () {
    var table = $('#tableSearch').DataTable({
        lengthChange: true,
        buttons: ['copy', 'excel', 'pdf', 'csv', 'colvis'],
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    table.buttons().container()
        .appendTo('#tableSearch_wrapper .col-md-6:eq(0)');
});