const accent_color = data_js.accent_color;

// Header button
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

    const mainLogo = document.getElementById('main-logo');
    const existingLink = mainLogo.querySelector('a');

    if (mainLogo) {
        // Move all children of the <a> element (i.e. logo) to its parent (i.e. #main-logo)
        while (existingLink.firstChild) {
            mainLogo.insertBefore(existingLink.firstChild, existingLink);
        }

        // We remove the empty element <a>
        existingLink.remove();

        // Create new links
        const leftLink = document.createElement('a');
        const rightLink = document.createElement('a');

        const pwePageLink = htmlLang === 'pl-PL' ? 'https://warsawexpo.eu/' : 'https://warsawexpo.eu/en/';
        const mainPage = htmlLang === 'pl-PL' ? '/' : '/en/';

        const commonStyles = {
            position: 'absolute',
            top: '0',
            width: '50%',
            height: '100%',
            zIndex: '10'
        };

        // Assign a style to the left link
        Object.assign(leftLink.style, commonStyles);
        leftLink.style.left = '0';
        leftLink.href = pwePageLink;
        leftLink.target = '_blank';

        // Assign a style to the right link
        Object.assign(rightLink.style, commonStyles);
        rightLink.style.right = '0';
        rightLink.href = mainPage;

        mainLogo.appendChild(leftLink);
        mainLogo.appendChild(rightLink);  
    }




    const squaresModeBgs = document.querySelectorAll('.pwe-header-background .pwe-bg-image');

    if (squaresModeBgs && squaresModeBgs.length > 0) {
        let currentIndex = 0;
        let isFirstLoop = true;

        function changeBackground() {
            // Wyzeruj wszystkie obrazy
            squaresModeBgs.forEach((bg) => bg.classList.remove('visible'));

            // Jeśli jesteśmy w pierwszej pętli, pokaż pierwszy obrazek tylko na początku
            if (isFirstLoop) {
                if (currentIndex === 0) {
                    squaresModeBgs[0].classList.add('visible'); // Pierwszy obrazek na 3 sekundy
                    setTimeout(() => {
                        currentIndex = 1;
                        changeBackground(); // Przejdź do drugiego obrazu po 3 sekundach
                    }, 3000);
                } else if (currentIndex === 1) {
                    squaresModeBgs[1].classList.add('visible'); // Drugi obrazek na 10 sekund
                    setTimeout(() => {
                        currentIndex = 2;
                        changeBackground(); // Przejdź do trzeciego obrazu po 10 sekundach
                    }, 10000);
                } else if (currentIndex === 2) {
                    squaresModeBgs[2].classList.add('visible'); // Trzeci obrazek na 10 sekund
                    setTimeout(() => {
                        isFirstLoop = false; // Ustaw flagę, że pierwsza pętla się skończyła
                        currentIndex = 1; // Ustaw na drugi obraz na początek kolejnych pętli
                        changeBackground();
                    }, 10000);
                }
            } else {
                // Kolejne pętle: tylko drugi i trzeci obrazek
                if (currentIndex === 1) {
                    squaresModeBgs[1].classList.add('visible'); // Drugi obrazek na 10 sekund
                    setTimeout(() => {
                        currentIndex = 2;
                        changeBackground();
                    }, 10000);
                } else if (currentIndex === 2) {
                    squaresModeBgs[2].classList.add('visible'); // Trzeci obrazek na 10 sekund
                    setTimeout(() => {
                        currentIndex = 1;
                        changeBackground();
                    }, 10000);
                }
            }
        }

        changeBackground();
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



