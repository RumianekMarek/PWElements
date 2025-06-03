<?php

/**
 * Class PWECoutdown for display coutdown timer
 *
 */
class PWECountdown {

    /**
     * Constructor method.
     */
    public function __construct() {
    }

    /**
     * Static method for counting down time
     *
     * @param array $timer for countdown data
     * @param string $target_id script target countdown id
     */
    private static function countingDown($timer, $target_id = '',  $options = []) {

        $showShort = !empty($options['show_short_name_data']);

        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);
        $local = get_locale();
        $timer_seconds = '';
        if(!$mobile && !$showShort){
            if($local == 'pl_PL'){
                $timer_seconds = ' + " " + pluralizePolish(seconds, "sekunda", "sekundy", "sekund").trim()';
            } else {
                $timer_seconds = ' + " " + pluralizeEnglish(seconds, "second").trim()';
            }
        } else if(!$mobile){
            $timer_seconds = ' + " " + pluralizePolish(seconds, "s", "s", "s").trim()';
        }
        if(!$showShort && $target_id != "") {
                echo '
                <script>
                    {
                        const timer = ' . json_encode($timer) .';
                        for(i=0;i<timer.length; i++){
                            timer[i]["countdown_end"] = timer[i]["countdown_end"].replace(/\//g, "-").replace(" ", "T");
                        };
                        let j = 0;
                        jQuery(document).ready(function($) {
                            const intervals = {};

                            function updateCountdownStop(elementId) {
                                clearInterval(intervals[elementId]);
                            }

                            function pluralizePolish(count, singular, plural, pluralGenitive) {
                                if (count === 1 || (count % 10 === 1 && count % 100 !== 11)) {
                                    return `${count} ${singular}`;
                                } else if (count % 10 >= 2 && count % 10 <= 4 && (count % 100 < 10 || count % 100 >= 20)) {
                                    return `${count} ${plural}`;
                                } else {
                                    return `${count} ${pluralGenitive}`;
                                }
                            }

                            function pluralizeEnglish(count, noun) {
                                return `${count} ${noun}${count !== 1 ? "s" : ""}`;
                            }

                            function updateCountdown(elementId) {
                                intervals[elementId] = setInterval(function() {
                                    if(timer[j] != null){
                                        const rightNow = new Date();
                                        const endTime = new Date(timer[j]["countdown_end"]);
                                        endTime.setHours(endTime.getHours());
                                        const distance = endTime - rightNow;

                                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        let endMessage = "";

                                        if ("' . $local . '" == "pl_PL") {
                                            endMessage = pluralizePolish(days, "dzień", "dni", "dni") + " " +
                                                        pluralizePolish(hours, "godzina", "godziny", "godzin") + " " +
                                                        pluralizePolish(minutes, "minuta", "minuty", "minut") ' . $timer_seconds . ';

                                        } else {
                                            endMessage = pluralizeEnglish(days, "day") + " " +
                                                        pluralizeEnglish(hours, "hour") + " " +
                                                        pluralizeEnglish(minutes, "minute") ' . $timer_seconds . ';
                                        }

                                        if(distance < 0){
                                            j++;
                                            if(timer[j] != null && timer[j]["countdown_text"] != ""){
                                                $("#timer-header-text-' . $target_id .'").text(timer[j]["countdown_text"]);
                                                $("#timer-button-' . $target_id . '").text(timer[j]["countdown_btn_text"]);
                                                $("#timer-button-' . $target_id . '").attr("href", timer[j]["countdown_btn_url"]);
                                            }
                                        } else {
                                            $("#pwe-countdown-timer-' . $target_id .'").text(endMessage);
                                        }
                                    } else {
                                        updateCountdownStop(' . $target_id . ');
                                        $("#pwe-countdown-timer-' . $target_id .'").parent().hide(0);
                                    }
                                } , 1000);
                            }
                            updateCountdown(' . $target_id . ');

                            // Change button on sticky main timer
                            function handleClassChange(mutationsList, observer) {
                                for (let mutation of mutationsList) {
                                    if (mutation.type === "attributes" && mutation.attributeName === "class") {
                                        const targetElement = mutation.target;
                                        const customBtn = document.getElementById("timer-button-' . $target_id . '");
                                        const hasStuckedClass = targetElement.classList.contains("is_stucked");
                                        if (customBtn) {
                                            const buttonLink = customBtn.href;

                                            if (hasStuckedClass) {
                                                if (buttonLink.includes("/en/")) {
                                                    customBtn.innerHTML = "<span>REGISTER<br/>Get a free ticket</span>";
                                                    customBtn.href = "/en/registration/";
                                                } else {
                                                    customBtn.innerHTML = "<span>Zarejestruj się<br/>Odbierz darmowy bilet</span>";
                                                    customBtn.href = "/rejestracja/";
                                                }
                                            } else {
                                                if (buttonLink.includes("/en/")) {
                                                    customBtn.innerHTML = "<span>Book a stand</span>";
                                                    customBtn.href = "/en/become-an-exhibitor";
                                                } else {
                                                    customBtn.innerHTML = "<span>Zostań wystawcą</span>";
                                                    customBtn.href = "/zostan-wystawca/";
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            let is_stucked = false;
                            const targetElement = document.querySelector(".sticky-element");
                            const mainTimerElement = document.querySelector("#main-timer");
                            const observer = new MutationObserver(handleClassChange);

                            if (mainTimerElement) {
                                const config = { attributes: true, attributeFilter: ["class"] };
                                const showRegisterBarValue = mainTimerElement.getAttribute("data-show-register-bar");
                                if(targetElement && showRegisterBarValue !== "true") {
                                    observer.observe(targetElement, config);
                                    targetElement.setAttribute("data-is-stucked", is_stucked);
                                }
                            }
                        });
                    }

                </script>';
        } else if($target_id != "") {
            echo '
                <script>
                    {
                        const timer = ' . json_encode($timer) .';
                        for(i=0;i<timer.length; i++){
                            timer[i]["countdown_end"] = timer[i]["countdown_end"].replace(/\//g, "-").replace(" ", "T");
                        };
                        let j = 0;
                        jQuery(document).ready(function($) {
                            const intervals = {};

                            function updateCountdownStop(elementId) {
                                clearInterval(intervals[elementId]);
                            }

                            function pluralizePolish(count, singular, plural, pluralGenitive) {
                                if (count === 1 || (count % 10 === 1 && count % 100 !== 11)) {
                                    return `${count} ${singular}`;
                                } else if (count % 10 >= 2 && count % 10 <= 4 && (count % 100 < 10 || count % 100 >= 20)) {
                                    return `${count} ${plural}`;
                                } else {
                                    return `${count} ${pluralGenitive}`;
                                }
                            }

                            function pluralizeEnglish(count, noun) {
                                return `${count} ${noun}${count !== 1 ? "s" : ""}`;
                            }

                            function updateCountdown(elementId) {
                                intervals[elementId] = setInterval(function() {
                                    if(timer[j] != null){
                                        const rightNow = new Date();
                                        const endTime = new Date(timer[j]["countdown_end"]);
                                        endTime.setHours(endTime.getHours());
                                        const distance = endTime - rightNow;

                                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        let endMessage = "";

                                        if ("' . $local . '" == "pl_PL") {
                                            endMessage = pluralizePolish(days, "d", "d", "d") + " " +
                                                        pluralizePolish(hours, "h", "h", "h") + " " +
                                                        pluralizePolish(minutes, "m", "m", "m") ' . $timer_seconds . ';

                                        } else {
                                            endMessage = pluralizeEnglish(days, "d") + " " +
                                                        pluralizeEnglish(hours, "h") + " " +
                                                        pluralizeEnglish(minutes, "min") ' . $timer_seconds . ';
                                        }

                                        if(distance < 0){
                                            j++;
                                            if(timer[j] != null && timer[j]["countdown_text"] != ""){
                                                $("#timer-header-text-' . $target_id .'").text(timer[j]["countdown_text"]);
                                                $("#timer-button-' . $target_id . '").text(timer[j]["countdown_btn_text"]);
                                                $("#timer-button-' . $target_id . '").attr("href", timer[j]["countdown_btn_url"]);
                                            }
                                        } else {
                                            $("#pwe-countdown-timer-' . $target_id .'").text(endMessage);
                                        }
                                    } else {
                                        updateCountdownStop(' . $target_id . ');
                                        $("#pwe-countdown-timer-' . $target_id .'").parent().hide(0);
                                    }
                                } , 1000);
                            }
                            updateCountdown(' . $target_id . ');

                            // Change button on sticky main timer
                            function handleClassChange(mutationsList, observer) {
                                for (let mutation of mutationsList) {
                                    if (mutation.type === "attributes" && mutation.attributeName === "class") {
                                        const targetElement = mutation.target;
                                        const customBtn = document.getElementById("timer-button-' . $target_id . '");
                                        const hasStuckedClass = targetElement.classList.contains("is_stucked");
                                        if (customBtn) {
                                            const buttonLink = customBtn.href;

                                            if (hasStuckedClass) {
                                                if (buttonLink.includes("/en/")) {
                                                    customBtn.innerHTML = "<span>REGISTER<br/>Get a free ticket</span>";
                                                    customBtn.href = "/en/registration/";
                                                } else {
                                                    customBtn.innerHTML = "<span>Zarejestruj się<br/>Odbierz darmowy bilet</span>";
                                                    customBtn.href = "/rejestracja/";
                                                }
                                            } else {
                                                if (buttonLink.includes("/en/")) {
                                                    customBtn.innerHTML = "<span>Book a stand</span>";
                                                    customBtn.href = "/en/become-an-exhibitor";
                                                } else {
                                                    customBtn.innerHTML = "<span>Zostań wystawcą</span>";
                                                    customBtn.href = "/zostan-wystawca/";
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            let is_stucked = false;
                            const targetElement = document.querySelector(".sticky-element");
                            const mainTimerElement = document.querySelector("#main-timer");
                            const observer = new MutationObserver(handleClassChange);

                            if (mainTimerElement) {
                                const config = { attributes: true, attributeFilter: ["class"] };
                                const showRegisterBarValue = mainTimerElement.getAttribute("data-show-register-bar");
                                if(targetElement && showRegisterBarValue !== "true") {
                                    observer.observe(targetElement, config);
                                    targetElement.setAttribute("data-is-stucked", is_stucked);
                                }
                            }
                        });
                    }

                </script>';
        }

    }

    /**
     * Static method to generate the HTML output for the PWE Countdown.
     *
     * @param array $countdown for countdown data
     * @param string $timer_id script target countdown id
     */
    public static function output($countdown, $timer_id, $options) {
        echo self::countingDown($countdown, $timer_id, $options);
    }
}