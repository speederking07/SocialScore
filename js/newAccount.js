$(document).ready(function () {

    $('.peselCheck').focusout(function () {
        var person = $(this);
        person.removeClass('valid');
        person.removeClass('invalid');
        if (person.val() === '') {
            person.addClass('valid');
            person.parent().children('span').attr('data-success', 'Unknown parent');
        } else if (!correctPesel(person.val())) {
            person.addClass('invalid');
            person.parent().children('span').attr('data-error', 'Incorrect pesel');
        } else {
            $.ajax({
                url: "person_exist.php",
                data: {'pesel': person.val()},
                type: "GET"
            })
                .done(function (msg) {
                    if (msg === "Not found") {
                        person.addClass('invalid');
                        $('#helper-text').attr('data-error', 'Person does not exist');
                    } else {
                        person.addClass('valid');
                        person.parent().children('span').attr('data-success', msg);
                    }
                    buttonCheck();
                })
                .fail(function () {
                    alert("Unable to connect to server");
                });
        }
    });

    $('.loginCheck').focusout(function () {
        var t = $(this);
        t.removeClass('valid');
        t.removeClass('invalid');
        if (t.val() === '') {
            t.addClass('invalid');
            t.parent().children('span').attr('data-success', 'Login is empty');
        } else {
            $.ajax({
                url: "login_exist.php",
                data: {'login': t.val()},
                type: "GET"
            })
                .done(function (msg) {
                    if (msg === "false") {
                        t.addClass('valid');
                    } else {
                        t.addClass('invalid');
                    }
                    buttonCheck();
                })
                .fail(function () {
                    alert("Unable to connect to server");
                });
        }
    });

    $("#password2").focusout(function () {
        var p1 = $('#password1');
        var p2 = $('#password2');
        p1.removeClass('valid');
        p2.removeClass('valid');
        p1.removeClass('invalid');
        p2.removeClass('invalid');
        if (p1.val() !== p2.val()) {
            p1.addClass('invalid');
            p2.addClass('invalid');
        } else {
            p1.addClass('valid');
            p2.addClass('valid');
        }
        buttonCheck();
    });

    $('#addBtn').click(function () {
        $('#addForm').submit();
    });
});

function buttonCheck() {
    if ($('#login').hasClass('valid') && $('#pesel').hasClass('valid') && $('#password1').hasClass('valid')
        && $('#password2').hasClass('valid')) {
        $('#addBtn').removeClass('disabled');
    } else $('#addBtn').addClass('disabled');
}
