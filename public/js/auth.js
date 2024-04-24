$(document).ready(function () {
    $('input#password').on('input', function() {
        $('ul#xError').empty();
    });

    $('input#email').on('input', function() {
        $('ul#xError').empty();
    });

    $('input#lname').on('input', function() {
        $('ul#xError').empty();
    });

    $('input#fname').on('input', function() {
        $('ul#xError').empty();
    });

    $('input#pat').on('input', function() {
        $('ul#xError').empty();
    });
});
