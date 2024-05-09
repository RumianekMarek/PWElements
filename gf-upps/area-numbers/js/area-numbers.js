jQuery(document).bind("gform_post_render", function (event, form_id) {
    jQuery(function ($) {
        const phone_id = area_data.elements["input_" + form_id][0];
        let area_code = area_data.elements["input_" + form_id][1];
        var main_pattern = '';
        var old_title = '';

        const createPattern = (unknown = false) => {
            if (unknown === true) {
                const pattern = '+999999999';
                console.log(pattern.replace(new RegExp("[0-9]", "g"), "9"));
                return pattern.replace(new RegExp("[0-9]", "g"), "9");
            }
            const titles = $('.iti__selected-flag').attr('title').split('+');
            const pattern = '+' + titles[1] + ' ' + $(phone_id).attr('placeholder');
            console.log(pattern.replace(new RegExp("[0-9]", "g"), "9"));
            return pattern.replace(new RegExp("[0-9]", "g"), "9");
        }

        const updatePhone = (title, number = '') => {
            main_pattern = createPattern();
            newValue = title.split('+');
            if (!$(phone_id).val().startsWith('+')) {
                $(phone_id).val('+' + $(phone_id).val());
            }

            if ($(phone_id).val().startsWith(newValue[1]) || $(phone_id).val().startsWith('+' + newValue[1])) {
            } else {
                $(phone_id).val('+' + newValue[1] + ' ');
                if (main_pattern[$(phone_id).val().length] === '(') {
                    $(phone_id).val($(phone_id).val() + '(');
                }
            }
        }

        const observer = new MutationObserver(function (mutationsList, observer) {
            for (var mutation of mutationsList) {
                if (mutation.type === 'attributes' && mutation.attributeName === 'title') {
                    if ($(mutation.target).attr('title') == 'Unknown') {
                        main_pattern = createPattern(true);
                    } else if ($(phone_id).val().length < 1) {
                        updatePhone($(mutation.target).attr('title'), $(phone_id).val());
                        // } else if ($(mutation.target).attr('title') != old_title) {
                        //     updatePhone($(mutation.target).attr('title'), '');
                    } else {
                        console.log($(mutation.target).attr('title'));
                        main_pattern = createPattern();
                    }
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
            old_title = $(targetUL).attr('title')
            console.log('old - ' + old_title);
            var config = { attributes: true };
            observer.observe(targetUL, config);
            setTimeout(function () { main_pattern = createPattern() }, 200);
        }

        // const checkPattern = (number, pattern) => {
        //     for (i = 0; i < number.length; i++) {
        //         if (pattern[i] != number[i]) {
        //             console.log(pattern[i] + ' ' + number[i]);
        //             if (pattern[i] === '9' && !/[0-9]/.test(number[i])) {
        //                 delete number[i];
        //             } elseif ()
        //         }
        //     }
        // }

        $(phone_id).on('input', function () {
            if (!$(this).val().startsWith('+')) {
                const targetUL = document.querySelector('.iti__selected-flag');
                updatePhone($(targetUL).attr('title'), $(this).val());
            }
        });

        $(phone_id).on('keypress', function (event) {
            const good_char = ['1', '2', '3', '4', '5', '6', '7', '8', '9', '0'];
            const pressedKey = event.originalEvent.key;
            if (!good_char.includes(pressedKey) || main_pattern[$(this).val().length] === undefined) {
                event.preventDefault();
            } else {
                if (main_pattern[$(this).val().length] != '9') {
                    $(this).val($(this).val() + main_pattern[$(this).val().length]);
                }
                if (main_pattern[$(this).val().length] != '9') {
                    $(this).val($(this).val() + main_pattern[$(this).val().length]);
                }
                if (main_pattern[$(this).val().length] != '9') {
                    $(this).val($(this).val() + main_pattern[$(this).val().length]);
                }
            }
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