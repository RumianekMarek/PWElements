jQuery(document).ready(function ($) {
    testEmail = false;
    testTel = false;
    $('input[type="email"]').on('input', function (event) {
        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test($(event.target).val())) {
            $('.mail-error').text('OK').css('background-color', 'green');
            testEmail = true;
        } else {
            $('.mail-error').text('Error').css('background-color', 'red');
            testEmail = false;
        }
    });

    $('input[type="tel"]').on('input', function (event) {
        if (/^[0-9+\(\)\s-]*$/.test($(event.target).val()) && $(event.target).val().length > 9) {
            $('.tel-error').text('OK').css('background-color', 'green');
            testTel = true;
        } else {
            $('.tel-error').text('Error').css('background-color', 'red');
            testTel = false;
        }
    });

    $('button[name="step-1-submit"]').on('click', function (event) {
        if (testTel == false || testEmail == false) {
            event.preventDefault(); // Zatrzymywanie domyślnego działania formularza
        }
    })
});