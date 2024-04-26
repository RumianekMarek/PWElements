jQuery(document).bind("gform_post_render", function (event, form_id) {
    jQuery(function ($) {

        const phone_id = area_data.elements["input_" + form_id][0];
        $(phone_id).attr('type', 'tel');

        const updatePhone = (title) => {
            newValue = title.split('+');

            if ($(phone_id).val().startsWith(newValue[1]) || $(phone_id).val().startsWith('+' + newValue[1])) {
            } else {
                $(phone_id).val(newValue[1] + ' ' + $(phone_id).val());
            }
        }

        let options = {
            initialCountry: area_data.elements["input_" + form_id][1],
        }

        $(phone_id).intlTelInput(options);

        const targetUL = document.querySelector('.iti__selected-flag');
        updatePhone($(targetUL).attr('title'));

        var observer = new MutationObserver(function (mutationsList, observer) {
            for (var mutation of mutationsList) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'title') {
                    updatePhone($(mutation.target).attr('title'));
                }
            }
        });

        var config = { attributes: true };
        observer.observe(targetUL, config);
    });
})