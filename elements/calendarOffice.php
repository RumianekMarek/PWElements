<?php
/**
* Class PWOfficeCalendarElement
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWOfficeCalendarElement extends PWElements {

    /**
     * Constructor method.
    * Calls parent constructor and adds an action for initializing the Visual Composer map.
    */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output() {
        $trade_desc = do_shortcode(
            self::languageChecker(
                <<<PL
                [trade_fair_desc]
                PL,
                <<<EN
                [trade_fair_desc_eng]
                EN
            )
        );
        echo '<script>console.log("'.$fair_desc.'")</script>';
        
        $trade_name = do_shortcode(
            self::languageChecker(
                <<<PL
                [trade_fair_name]
                PL,
                <<<EN
                [trade_fair_name_eng]
                EN
            )
        );

        $trade_start = do_shortcode("[trade_fair_datetotimer]");
        $trade_end = do_shortcode("[trade_fair_enddata]");

        $linker = 'https://outlook.live.com/calendar/0/action/compose?body='.urlencode($trade_desc).'&enddt='.substr($trade_end,0,4).'-'.substr($trade_end,5,2).'-'.substr($trade_end,8,2).'T17%3A00%3A00%3A00&location='.urlencode('Aleja Katowicka 62, 05-830 Nadarzyn').'&path=%2Fcalendar%2Faction%2Fcompose&rru=addevent&startdt='.substr($trade_start,0,4).'-'.substr($trade_start,5,2).'-'.substr($trade_start,8,2).'T10%3A00%3A00%3A00&subject='.urlencode($trade_name);
        
        $output = '<div id="calendar-office" class="pwe-container-calendar-add text-centered">
                    <a class="office" alt="link do kalendarza office" href="' . $linker . '" target="_blank">
                        <img src="/wp-content/plugins/PWElements/media/office.png" alt="ikonka office calendar"/>
                        <p class="font-weight-700">'.
                        self::languageChecker(
                            <<<PL
                            Kalendarz<br>Office
                            PL,
                            <<<EN
                            Office<br>Calendar
                            EN
                        )
                    .'</a>
                </div>';

        return $output;
    }
}
