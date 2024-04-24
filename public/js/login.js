$(document).ready(function () {
    $('input#password').on('input', function() {
        $('ul#xError').empty();
    });

    $('input#email').on('input', function() {
        $('ul#xError').empty();
    });
});
