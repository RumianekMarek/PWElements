jQuery(document).bind("gform_post_render", function (event, form_id) {
    jQuery(function ($) {
        const phone_id = area_data.elements["input_" + form_id][0];
        let area_code = area_data.elements["input_" + form_id][1];
        var main_pattern = '';

        const checkPattern = (patt, inp) => {
            console.log(patt);
            console.log(inp);
        }
        const createPattern = () => {
            const titles = $('.iti__selected-flag').attr('title').split('+');
            const pattern = '+' + titles[1] + ' ' + $(phone_id).attr('placeholder');
            return pattern.replace(new RegExp("[0-9]", "g"), "9");
        }

        const updatePhone = (title, number = '') => {
            newValue = title.split('+');

            if (!$(phone_id).val().startsWith('+')) {
                $(phone_id).val('+' + $(phone_id).val());
            }

            if ($(phone_id).val().startsWith(newValue[1]) || $(phone_id).val().startsWith('+' + newValue[1])) {
            } else {
                $(phone_id).val('+' + newValue[1] + ' ' + number);
            }
        }

        const observer = new MutationObserver(function (mutationsList, observer) {
            for (var mutation of mutationsList) {
                main_pattern = createPattern();
                if (mutation.type === 'attributes' && mutation.attributeName === 'title' && $(mutation.target).attr('title') != 'Unknown' && $(phone_id).val().length < 1) {
                    updatePhone($(mutation.target).attr('title'), $(phone_id).val());
                }
            }
        });

        const succesCountryIp = (countryCode) => {
            let options = {
                initialCountry: countryCode,
                utilsScript: "https://cleanexpo.pl/wp-content/plugins/PWElements/gf-upps/area-numbers/js/utils.js",
                autoPlaceholder: "aggressive",
            }

            $(phone_id).intlTelInput(options);

            var targetUL = document.querySelector('.iti__selected-flag');

            updatePhone($(targetUL).attr('title'));

            var config = { attributes: true };
            observer.observe(targetUL, config);
            setTimeout(function () { main_pattern = createPattern() }, 200);
        }

        $(phone_id).on('input', function () {
            if (!$(this).val().startsWith('+')) {
                const targetUL = document.querySelector('.iti__selected-flag');
                updatePhone($(targetUL).attr('title'), $(this).val());
            }
            checkPattern(main_pattern, $(this).val());
        });

        $(phone_id).attr('type', 'tel');

        if (area_code.toLowerCase() == 'def' || area_code.toLowerCase() == '') {
            fetch("https://ipapi.co/json")
                .then(function (res) { return res.json(); })
                .then(function (data) { succesCountryIp(data.country_code) })
                .catch(function () { console.log('error'); succesCountryIp('PL') });
        } else {
            succesCountryIp(area_code);
        }
    });
})