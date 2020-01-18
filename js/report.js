$(document).ready(function () {
    $('#reportBtn').click(function () {
        $('#reportForm').submit();
    });

    $('#person').focusout(function () {
        var person = $('#person');
        person.removeClass('valid');
        person.removeClass('invalid');
        $.ajax( {
            url: "person_exist.php",
            data: { 'pesel': $('#person').val() },
            type: "POST"
        } )
            .done(function(msg) {
                if(msg === "Not found"){
                    person.addClass('invalid');
                }
                else{
                    person.addClass('valid');

                    $('#helper-text').attr('data-success', msg);
                }
            })
            .fail(function() {
                alert( "Unable to connect to server" );
            });
        checkValid();
    });

    $("#desc").focusout(function () {
        var desc = $("#desc");
        if (desc.val() === ''){
            desc.addClass('invalid');
            desc.removeClass('valid');
        }
        else{
            desc.addClass('valid');
            desc.removeClass('invalid');
        }
        checkValid();
    });

    $('#deedSelect').change(function () {
        checkValid();
    })
});

function checkValid() {
    if ($('#person').hasClass('valid') && $('#deedSelect').val() !== null && $('#desc').hasClass('valid')) {
        $('#reportBtn').removeClass('disabled');
    } else $('#reportBtn').addClass('disabled');
}