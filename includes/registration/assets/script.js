const utm = data_js.source_utm;
const htmlLang = document.documentElement.lang;
const registrationMode = data_js.registration_modes;


// Function that writes the title attribute to input
function updateCountryInput() {
    const selectedFlag = document.querySelector(".iti__flag-container .iti__selected-flag");
    if (selectedFlag) {

        let countryTitle = selectedFlag.getAttribute("title");

        const countryInput = document.querySelector(".country input");
        if (countryInput) {
            countryInput.value = countryTitle;
        }
    }
}

// Function that adds event listener to form elements
function updateCountryInput() {
    const countryInput = document.querySelector(".country input");
    const selectedFlag = document.querySelector(".iti__selected-flag");
    if (countryInput && selectedFlag) {
        countryInput.value = selectedFlag.getAttribute("title") || "";
    }
}

function addEventListenersToForm() {
    document.querySelectorAll("input, select, textarea, button").forEach(element => {
        ["change", "input", "click", "focus"].forEach(event => {
            element.addEventListener(event, updateCountryInput);
        });
    });
}

function observeFlagChanges() {
    const selectedFlag = document.querySelector(".iti__selected-flag");
    if (selectedFlag) {
        new MutationObserver(mutations => {
            if (mutations.some(mutation => mutation.attributeName === "aria-expanded")) {
                updateCountryInput();
            }
        }).observe(selectedFlag, { attributes: true });
    }
}

addEventListenersToForm();
observeFlagChanges();

window.onload = function () {
    function getCookie(name) {
        let value = "; " + document.cookie;
        let parts = value.split("; " + name + "=");
        if (parts.length === 2) return parts.pop().split(";").shift();
        return null;
    }

    function deleteCookie(name) {
        document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    }

    let utmPWE = utm;
    let utmCookie = getCookie("utm_params");
    let utmInput = document.querySelector(".utm-class input");

    if (utmCookie && (utmCookie.includes("utm_source=byli") || utmCookie.includes("utm_source=premium"))) {
        deleteCookie("utm_params");
    }

    if (utmInput) {
        utmInput.value = utmPWE;
    }

    const buttonSubmit = document.querySelector(".gform_footer input[type=submit]");

    if (buttonSubmit) {
        buttonSubmit.addEventListener("click", function (event) {
            event.preventDefault();

            const emailValue = document.getElementsByClassName("ginput_container_email")[0].getElementsByTagName("input")[0].value;

            let telValue;
            const telContainer = document.getElementsByClassName("ginput_container_phone")[0];

            if (telContainer) {
                telValue = telContainer.getElementsByTagName("input")[0].value;
            } else {
                telValue = "123456789";
            }

            let countryValue = "";
            const countryContainer = document.getElementsByClassName("country")[0];
            if (countryContainer) {
                const countryInput = countryContainer.getElementsByTagName("input")[0];
                if (countryInput) {
                    countryValue = countryInput.value;
                }
            }

            localStorage.setItem("user_email", emailValue);
            localStorage.setItem("user_country", countryValue);
            localStorage.setItem("user_tel", telValue);

            if (htmlLang === "pl-PL") {
                localStorage.setItem("user_direction", "rejpl");
            } else {
                localStorage.setItem("user_direction", "rejen");
            }

            const areaContainer = document.getElementsByClassName("input-area")[0];
            if (areaContainer) {
                const areaValue = areaContainer.getElementsByTagName("input")[0].value;
                localStorage.setItem("user_area", areaValue);
            }

        });
    }
}
