$(document).ready(function () {
    $('.peselCheck').focusout(function () {
        var person = $(this);
        person.removeClass('valid');
        person.removeClass('invalid');
        if(person.val() === ''){
            person.addClass('valid');
            person.parent().children('span').attr('data-success', 'Unknown parent');
        }
        else if(!correctPesel(person.val())){
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

    $('.peselUnique').focusout(function () {
        var person = $(this);
        person.removeClass('valid');
        person.removeClass('invalid');
        if(!correctPesel(person.val())){
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
                        person.addClass('valid');
                        $('#helper-text').attr('data-success', 'Correct pesel');
                    } else {
                        person.addClass('invalid');
                        person.parent().children('span').attr('data-error', 'This pesel belongs to '+msg);
                    }
                    buttonCheck();
                })
                .fail(function () {
                    alert("Unable to connect to server");
                });
        }
    });

    $('.nameValid').focusout(function () {
        var t = $(this);
        var regex = /^[A-Z]+[a-z]+$/;
        t.removeClass('valid');
        t.removeClass('invalid');
        if(regex.test(t.val())) t.addClass('valid');
        else t.addClass('invalid');
    });

    $('#middleName').focusout(function () {
        var t = $(this);
        var regex = /^[A-Z]+[a-z]+$/;
        t.removeClass('valid');
        t.removeClass('invalid');
        if(regex.test(t.val())) t.addClass('valid');
        else t.addClass('invalid');
    });

    $('#email').focusout(function () {
        var t = $(this);
        var regex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9]))\.){3}(?:(2(5[0-5]|[0-4][0-9])|1[0-9][0-9]|[1-9]?[0-9])|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
        t.removeClass('valid');
        t.removeClass('invalid');
        if(regex.test(t.val())) t.addClass('valid');
        else t.addClass('invalid');
    });

    $('#phone').focusout(function () {
        var t = $(this);
        var regex = /^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\./0-9]*$/;
        t.removeClass('valid');
        t.removeClass('invalid');
        if(regex.test(t.val())) t.addClass('valid');
        else t.addClass('invalid');
    });

    $('input').focusout(buttonCheck);

    $('#addBtn').click(function () {
        $('#addForm').submit();
    });
});



function buttonCheck() {
    var ok = true;
    $('input[type=text]').each(function () {
        if (!$(this).hasClass('valid') && !$(this).hasClass('unrequited')) ok = false;
    })
    if(ok) $('#addBtn').removeClass('disabled')
    else $('#addBtn').addClass('disabled')
}