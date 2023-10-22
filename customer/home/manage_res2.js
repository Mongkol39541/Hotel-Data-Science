// changing form when clicked edit information
// no for loop gang
function edit_info() {
    $('#confirm_date').prop('disabled',false);
    $("#confirm_hidden").val($("#date_editor").val())
    $('#use-member-address').prop('disabled',false);
    $('#fname').prop('disabled',false);
    $('#lname').prop('disabled',false);
    $('#email').prop('disabled',false);
    $('#phone').prop('disabled',false);
    $('#date_editor').prop('disabled',false);
    $('#update').prop('hidden',false);
    $('#cancel').prop('hidden',false);
    $('#delete').prop('hidden', true);
    $('#edit').prop('hidden', true);
}

function cancel_info() {
    $("#date_editor").val($("#confirm_hidden").val());
    $("#fname").val($("#fname_hidden").val());
    $("#lname").val($("#lname_hidden").val());
    $("#email").val($("#email_hidden").val());
    $("#phone").val($("#phone_hidden").val());
    $('#confirm_date').prop('disabled', true);
    $('#use-member-address').prop('disabled', true);
    $('#fname').prop('disabled', true);
    $('#lname').prop('disabled', true);
    $('#email').prop('disabled', true);
    $('#phone').prop('disabled', true);
    $('#date_editor').prop('disabled', true);
    $('#update').prop('hidden', true);
    $('#cancel').prop('hidden',true);
    $('#delete').prop('hidden',false);
    $('#edit').prop('hidden',false);
}