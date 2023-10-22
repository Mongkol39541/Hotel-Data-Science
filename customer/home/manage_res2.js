// changing form when clicked edit information
// no for loop gang
function edit_info() {
    $('#confirm_date').prop('disabled',false);
    $('#use-member-address').prop('disabled',false);
    $('#fname').prop('disabled',false);
    $('#lname').prop('disabled',false);
    $('#email').prop('disabled',false);
    $('#phone').prop('disabled',false);
    $('#date_editor').prop('disabled',false);
    $('#update').prop('disabled',false);
    $('#delete').remove();
    $('#edit').remove();
}