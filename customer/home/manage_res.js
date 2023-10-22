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
    const test = createElement('<p>test</p>');
    $('$lowest_button').appendChild(test);
}