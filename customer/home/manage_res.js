// changing form when clicked edit information
// no for loop gang
function edit_info() {
    $('#use-member-address').prop('disabled',false);
    $('#fname').prop('disabled',false);
    $('#lname').prop('disabled',false);
    $('#email').prop('disabled',false);
    $('#address').prop('disabled',false);
    $('#address').prop('disabled',false);
    $('#date_editor').prop('disabled',false);
    $('#delete').remove();
    $('#edit').remove();

    // adding button
    var confirm_date = document.createElement('input');
    confirm_date.type = 'button';
    confirm_date.id = 'confirm_date';
    confirm_date.name = 'confirm_date';
    confirm_date.class = 'btn btn-primary'
    confirm_date.value = 'Confirm Date';
    var button_parent = document.getElementById('date_button');
    button_parent.appendChild(confirm_date);
}