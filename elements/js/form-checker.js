jQuery(document).ready(function ($) {
    const testEmail = () => {
        emailTarget = $('input[type="email"]').val();
        if (/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailTarget)) {
            $('.mail-error').html('&nbsp;').css('background-color', 'transparent');
            return true;
        } else {
            $('.mail-error').text('Error').css('background-color', 'red');
            return false;
        }
    };

    const testTel = () => {
        telTarget = $('input[type="tel"]').val();
        if (/^[0-9+\(\)\s-]*$/.test(telTarget) && telTarget.length > 9) {
            $('.tel-error').html('&nbsp;').css('background-color', 'transparent');
            return true;
        } else {
            $('.tel-error').text('Error').css('background-color', 'red');
            return false;
        }
    };

    const testCons = () => {
        const consTarget = $('input[name="consent"]');
        if (consTarget.is(':checked')) {
            $('.cons-error').html('&nbsp;').css('background-color', 'transparent');
            return true;
        } else {
            $('.cons-error').text('Obowiązkowe').css('background-color', 'red');
            return false;
        }
    };

    const uniqueCheck = (id, value, csrfToken) => {
        var baseUrl = window.location.origin
        $.ajax({
            type: 'POST',
            url: baseUrl + '/wp-content/plugins/PWElements/gf-upps/gf-email-check/gf-email-check.php',
            data: { id: id, value: value, csrf_token: csrfToken },
            dataType: 'json',
            success: function (response) {
                if (response.exists) {
                    $('.mail-error').text('Email już został użyty').css('background-color', 'red');
                } else {
                    $('#xForm').find('form[id="registration"]').submit();
                }
            },
            error: function (xhr, status, error, response) {
                var errorMessage = "Wystąpił błąd podczas sprawdzania emaila. " + error + '  ' + status;

                console.error(errorMessage);
            }
        });
    }

    // $('button[name="step-1-submit"]').on('click', function (event) {
    //     event.preventDefault();

    //     const testerTel = testTel(inner.form_id);
    //     const testerEmail = testEmail(inner.form_id);
    //     const testerCons = testCons(inner.form_id);

    //     if (testerTel && testerEmail && testerCons) {
    //         id = inner.form_id;
    //         value = $('input[type="email"]').val();
    //         token = $('input[name="csrf_token"]').val();
    //         form_id = $('#xForm').find('form[id="registration"]').attr('number');
    //         uniqueCheck(id, value, token, form_id);
    //     }
    // })
});