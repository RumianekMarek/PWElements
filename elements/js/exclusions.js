const accent_color = data_js.accent_color;

// Headert button
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuButton = document.querySelector('.mobile-menu-button');
    const htmlLang = document.documentElement.lang;

    if (mobileMenuButton) {
        const pweForm = document.querySelector('#pweForm');
        const registerPage = htmlLang === 'pl-PL' ? '/rejestracja/' : '/en/registration/';
        const hrefValue = pweForm ? '#pweForm' : registerPage;
        const textValue = htmlLang === 'pl-PL' ? 'WEŹ UDZIAŁ' : 'TAKE A PART';
        const participateButton = '<a href="' + hrefValue + '" class="participate-button" style="background-color:' + data_js['main2_color'] + ';">' + textValue + '</a>';

        mobileMenuButton.insertAdjacentHTML('beforebegin', participateButton);

        document.querySelector('.participate-button').addEventListener('click', function (event) {
            if (pweForm) {
                event.preventDefault();
                pweForm.scrollIntoView({ behavior: 'smooth' });
                history.replaceState(null, '', window.location.pathname);
            }
        });
    }
});

// // Funkcja do ustawiania cookie
// function setCookie(name, value, hours) {
//     var expires = "";
//     if (hours) {
//         var date = new Date();
//         date.setTime(date.getTime() + (hours * 60 * 60 * 1000));
//         expires = "; expires=" + date.toUTCString();
//     }
//     document.cookie = name + "=" + (value || "") + expires + "; path=/";
// }
// // Funkcja do pobierania parametrów z URL
// function getUTMParameters() {
//     var params = ['utm_source', 'utm_medium', 'utm_campaign'];
//     var utmValues = params.map(function (param) {
//         var value = new URLSearchParams(window.location.search).get(param);
//         return value ? param + '=' + value : '';
//     }).filter(Boolean).join('&');
//     // console.log('Zbierane wartości UTM:', utmValues); // Dodane do debugowania
//     return utmValues;
// }
// // Zapisanie UTM jako jednego ciągu w cookies
// var utmParams = getUTMParameters();
// // console.log('Zapisane w cookies:', utmParams); // Dodane do debugowania
// if (utmParams) {
//     setCookie('utm_params', utmParams, 24);
// }

// // Funkcja do odczytywania cookie
// function getCookie(name) {
//     var nameEQ = name + "=";
//     var ca = document.cookie.split(';');
//     for (var i = 0; i < ca.length; i++) {
//         var c = ca[i];
//         while (c.charAt(0) == ' ') c = c.substring(1, c.length);
//         if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
//     }
//     return null;
// }
// // Odczytanie wartości UTM z cookies
// var utmParams = getCookie('utm_params');
// // console.log('Odczytane z cookies UTM:', utmParams); // Logowanie do konsoli dla debugowania
// // Wklejenie wartości UTM do pola formularza
// if (utmParams) {
//     var utmFields = document.querySelectorAll('.utm-class input[type="text"]');
//     // console.log(utmFields);
//     utmFields.forEach(function (field) {
//         field.value = utmParams;
//     });
// }
