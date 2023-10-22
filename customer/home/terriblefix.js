// turning off and on the form when 'Use member info' is checked
$('#use-member-address').change(function() {
    if(this.checked) {
        $('#fname').prop('disabled',true).addClass('bg-secondary');
        $('#lname').prop('disabled',true).addClass('bg-secondary');
        $('#email').prop('disabled',true).addClass('bg-secondary');
    } else {
        $('#fname').prop('disabled',false).removeClass('bg-secondary');
        $('#lname').prop('disabled',false).removeClass('bg-secondary');
        $('#email').prop('disabled',false).removeClass('bg-secondary');
    }
    });