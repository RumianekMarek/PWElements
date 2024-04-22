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
    private static function countingDown($timer, $target_id = '') {
        if($target_id != ""){
        echo '
        <script>
            {
            const timer = ' . json_encode($timer) .';
            const locale = "' . get_locale() .'";
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
                            if (locale == "pl_PL") {
                                endMessage = pluralizePolish(days, "dzień", "dni", "dni") + " " +
                                             pluralizePolish(hours, "godzina", "godziny", "godzin") + " " +
                                             pluralizePolish(minutes, "minuta", "minuty", "minut") + " " +
                                             pluralizePolish(seconds, "sekunda", "sekundy", "sekund").trim();
                            } else {
                                endMessage = pluralizeEnglish(days, "day") + " " +
                                             pluralizeEnglish(hours, "hour") + " " +
                                             pluralizeEnglish(minutes, "minute") + " " +
                                             pluralizeEnglish(seconds, "second").trim();
                            }

                            if(distance < 0){
                                j++;
                                if(timer[j] != null && timer[j]["countdown_text"] != ""){
                                    $("#timer-header-text-' . $target_id .'").text(timer[j]["countdown_text"]);
                                    $("#timer-button-' . $target_id . '").text(timer[j]["countdown_btn_text"]);
                                    $("#timer-button-' . $target_id . '").attr("href", timer[j]["countdown_btn_url"]);
                                }
                            } else {
                                // const endMessage = days + " dni " + hours + " godzin " + minutes + " minut " + seconds + " sekund ";
                                $("#pwe-countdown-timer-' . $target_id .'").text(endMessage);
                            }
                        } else {
                            updateCountdownStop(' . $target_id . ');
                            $("#pwe-countdown-timer-' . $target_id .'").parent().hide(0);
                        }
                    } , 1000);
                }
                updateCountdown(' . $target_id . ');
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
    public static function output($countdown, $timer_id) {
        echo self::countingDown($countdown, $timer_id, );
    }
}