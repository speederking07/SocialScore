$(document).ready(function(){
    $('#slider').carousel({
        duration: 300,
        indicators: true,
    });

    var int = setInterval(function () {
        $('#slider').carousel('next');
    }, 8000);

    $(window).on('resize', function () {
        $('#slider').carousel({
            duration: 300,
            indicators: true,
        });
    })
});