<?php

/**
 * Class PWElementTicketActConf
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementTicketActConf extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    private static function notification_sender() {
        $query_string = $_SERVER["QUERY_STRING"];
        if ($query_string == '') {
            return false;
        }
        $query_string .= str_repeat('=', strlen($query_string) % 4);

        $decoded_qs = base64_decode($query_string);
        $id_array = explode(',', $decoded_qs);

        $form = GFAPI::get_form($id_array[0]);

        if (is_wp_error($form) || empty($form)) {
            echo '<script>console.error("Nie udało się pobrać formularza.")</script>';
            return false;
        }

        $entry = GFAPI::get_entry($id_array[1]);

        if (is_wp_error($entry) || empty($entry)) {
            echo '<script>console.error("Nie udało się pobrać potwierdzenia.")</script>';
            return false;
        }

        foreach ($form["notifications"] as $id => &$key) {
            if ($key['name'] == 'SPECJALSI A PL Aktywacja') {
                $key['isActive'] = true;
            } else {
                $key['isActive'] = false;
            }
        }

        try {
            GFAPI::send_notifications($form, $entry);
        } catch (Exception $e) {
            echo '<script>console.error("Błąd send_notifications.")</script>';
        }
        return true;
    }

    public static function output($atts) {
        self::notification_sender();

        $fair_logo = (get_locale() == "pl_PL") ? "/doc/logo-color.webp" : "/doc/logo-color-en.webp";

        $trade_fair_edition_shortcode = do_shortcode('[trade_fair_edition]');
        $trade_fair_edition_text = (get_locale() == 'pl_PL') ? ". edycja" : ". edition";
        $trade_fair_edition_first = (get_locale() == 'pl_PL') ? "Edycja Premierowa" : "Premier Edition";
        $trade_fair_edition = (!is_numeric($trade_fair_edition_shortcode) || $trade_fair_edition_shortcode == 1) ? $trade_fair_edition_first : $trade_fair_edition_shortcode . $trade_fair_edition_text;

        $start_date = do_shortcode('[trade_fair_datetotimer]');
        $end_date = do_shortcode('[trade_fair_enddata]');

        // Function to transform the date
        function transform_dates($start_date, $end_date) {
            // Convert date strings to DateTime objects
            $start_date_obj = DateTime::createFromFormat('Y/m/d H:i', $start_date);
            $end_date_obj = DateTime::createFromFormat('Y/m/d H:i', $end_date);

            // Check if the conversion was correct
            if ($start_date_obj && $end_date_obj) {
                // Get the day, month and year from DateTime objects
                $start_day = $start_date_obj->format('d');
                $end_day = $end_date_obj->format('d');
                $month = $start_date_obj->format('m');
                $year = $start_date_obj->format('Y');

                //Build the desired format
                $formatted_date = "{$start_day}-{$end_day}|{$month}|{$year}";
                return $formatted_date;
            } else {
                return "Invalid dates";
            }
        }

        // Transform the dates to the desired format
        $formatted_date = transform_dates($start_date, $end_date);

        if (self::isTradeDateExist()) {
            $actually_date = (get_locale() == 'pl_PL') ? '[trade_fair_date]' : '[trade_fair_date_eng]';
        } else {
            $actually_date = $formatted_date;
        }

        $output = '
        <style>
            .row-parent:has(.pwe-ticket-activation-confirmation){
                max-width: 100%;
                padding: 0 !important;  
            }
            .wpb_column:has(.pwe-ticket-activation-confirmation) {
                max-width: 100%;
            }
            .pwe-ticket-activation-confirmation-wrapper {
                display: flex;
                min-height: 80vh;
            }
            .pwe-ticket-activation-confirmation-left {
                width: 60%;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .pwe-ticket-activation-confirmation-right {
                width: 40%;
                display: flex;
                justify-content: center;
                align-items: center;
                background-image: url(/doc/header_mobile.webp);
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                background-color: #009cff;
            }
            .pwe-ticket-activation-confirmation-left-content {
                padding: 72px;
            }
            .pwe-ticket-activation-confirmation-left-content,
            .pwe-ticket-activation-confirmation-right-content {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .pwe-ticket-activation-confirmation-left h2 {
                font-size: 24px;
                font-weight: 700;
                margin: 0;
            }
            .pwe-ticket-activation-confirmation-left p {
                font-size: 18px;
                margin: 0;
            }
            .pwe-ticket-activation-confirmation-home-btn-container {
                background-color: black;
                padding: 18px;
                border-radius: 40px;
            }
            .pwe-ticket-activation-confirmation-home-btn {
                color: white !important;
                text-transform: uppercase;
                font-size: 18px;
                font-weight: 600;
            }
            .pwe-ticket-activation-confirmation-right {
                max-width: 100%;
            }
            .pwe-ticket-activation-confirmation-right-content {
                padding: 18px;
            }
            .pwe-ticket-activation-confirmation-right img {
                max-width: 400px;
                width: 100%;
            }
            .pwe-ticket-activation-confirmation-right h2 {
                color: white;
                font-size: 56px;
                margin: 0;
            }
            @media (min-width: 768px) and (max-width: 1100px) { 
                .pwe-ticket-activation-confirmation-right h2 { 
                    font-size: calc(24px + (56 - 24) * ( (100vw - 768px) / ( 1100 - 768) )); 
                } 
            }
            @media (min-width: 300px) and (max-width: 550px) { 
                .pwe-ticket-activation-confirmation-right h2 { 
                    font-size: calc(24px + (56 - 24) * ( (100vw - 300px) / ( 550 - 300) )); 
                } 
            }
            .pwelement_'. self::$rnd_id .' .form-2-bottom{
                background-color: #f7f7f7;
                display: flex;
                justify-content: center;
                gap: 18px;
                flex-wrap: wrap;
                padding: 18px;
            }
            .pwelement_'. self::$rnd_id .' .form-2-bottom div{
                flex:1;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap:9px;
            }
            .pwelement_'. self::$rnd_id .' .form-2-bottom div>div{
                flex:1;
                min-width: 200px;
            }
            .pwelement_'. self::$rnd_id .' .form-2-bottom img{
                max-height: 80px;
                object-fit: contain;
            }
            .pwelement_'. self::$rnd_id .' .form-2-bottom :is(.for-exhibitors, .for-visitors){
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .pwelement_'. self::$rnd_id .' .form-2-bottom :is(.for-exhibitors, .for-visitors) p {
                margin-top: 0px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-ticket-activation-confirmation-edition {
                max-width: 400px;
                width: 100%;
                background: white;
                border-radius: 0;
                color: '. self::$accent_color .';
                font-size: 36px;
                margin: 0;
                margin-top: 9px;
                padding: 3px 0;
                line-height: 1;
                text-transform: uppercase;
                text-align: center;
                font-weight: 700;
            }
            @media (max-width:960px) {
                .pwe-ticket-activation-confirmation-left-content {
                    padding: 36px;
                }
            }
            @media (max-width:768px) {
                .pwe-ticket-activation-confirmation-wrapper,
                .pwe-ticket-activation-confirmation-left, 
                .pwe-ticket-activation-confirmation-right {
                    min-height: auto;
                }
                .pwe-ticket-activation-confirmation-wrapper {
                    flex-direction: column;
                }
                .pwe-ticket-activation-confirmation-left,
                .pwe-ticket-activation-confirmation-right {
                    width: 100%;
                    padding: 36px 18px;
                }
                .pwe-ticket-activation-confirmation-left-content {
                    padding: 0 0 36px;
                }
                .pwelement_'. self::$rnd_id .' .form-2-bottom div>div{
                    min-width: unset;
                }
                .pwelement_'. self::$rnd_id .' .form-2-bottom div{
                    flex: unset;
                    width: 100%;
                }
            }
        </style>';

        if (!is_numeric($trade_fair_edition_shortcode) || $trade_fair_edition_shortcode == 1) {
            $output .= '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-ticket-activation-confirmation-edition {
                    font-size: 28px;
                }
            </style>';
        }
        
        $output .= '
        <div class="pwe-ticket-activation-confirmation">
            <div class="pwe-ticket-activation-confirmation-wrapper">
                <div class="pwe-ticket-activation-confirmation-left">
                    <div class="pwe-ticket-activation-confirmation-left-content">'. 
                        self::languageChecker(
                            <<<PL
                            <div class="pwe-ticket-activation-confirmation-confirmation-wrapper">
                                <h2>Dziękujemy za aktywację biletu!</h2>
                                <p style="padding-top: 18px;">Wkrótce otrzymają Państwo maila z unikalnym biletem na targi, zawierający <strong>kod QR</strong>. Prosimy o jego zachowanie, gdyż kod QR umożliwi wejście na <strong>[trade_fair_name]</strong> oraz wszystkie wydarzenia towarzyszące.</p>
                                <p style="padding-top: 18px;">W razie pytań, nasz zespół jest do Państwa dyspozycji.</p>
                                <p><strong>Do zobaczenia na [trade_fair_name]!</strong></p>
                            </div>
                            PL,
                            <<<EN
                            <div class="pwe-ticket-activation-confirmation-confirmation-wrapper">
                                <h2>Thank you for activating your ticket!</h2>
                                <p>You will soon receive an email with a unique ticket to the fair, containing a <strong>QR code</strong>. Please keep it, as the QR code will allow you to enter <strong>[trade_fair_name_eng]</strong> and all accompanying events.</p>
                                <p>If you have any questions, our team is at your disposal.</p>
                                <p><strong>See you at [trade_fair_name_eng]!</strong></p>
                            </div>
                            EN
                        ).'
                    </div>
                    <div class="pwe-ticket-activation-confirmation-home-btn-container">'.
                    self::languageChecker(
                        <<<PL
                        <a href="/" class="pwe-ticket-activation-confirmation-home-btn">Strona główna</a>
                        PL,
                        <<<EN
                        <a href="/en/" class="pwe-ticket-activation-confirmation-home-btn">Home page</a>
                        EN
                    )
                    .'</div>
                </div>
                <div class="pwe-ticket-activation-confirmation-right">
                    <div class="pwe-ticket-activation-confirmation-right-content">
                        <img src="/doc/logo.webp">';
                        if (!empty($trade_fair_edition_shortcode)) {
                            $output .= '<p class="pwe-ticket-activation-confirmation-edition">'. $trade_fair_edition .'</p>';
                        }
                        $output .= '
                        <h2>'. $actually_date .'</h2>
                    </div>
                </div>
            </div>
            <div class="form-2-bottom">
                <div class="logos">
                    <div class="pwe-logo">
                        <a href="https://warsawexpo.eu/" target="_blanc">
                            <img src="' . plugin_dir_url(dirname( __FILE__ )) . "/media/logo_pwe_black.webp" . '">
                        </a>
                    </div>
                    <div class="fair-logo">
                        <a href="'. 
                        self::languageChecker(
                            <<<PL
                               /
                            PL,
                            <<<EN
                                /en/
                            EN
                        )
                        .'"><img src="' . $fair_logo . '"></a>
                    </div>
                </div>
                <div class="numbers">
                    <div class="for-exhibitors">
                        <i class="fa fa-envelope-o fa-3x fa-fw"></i>
                        <p>'. 
                        self::languageChecker(
                            <<<PL
                                "Zostań wystawcą" 
                            PL,
                            <<<EN
                                "Become an exhibitor" 
                            EN
                        )
                    .'<br> <a href="tel:48 517 121 906">+48 517 121 906</a>
                    </div>
                    <div class="for-visitors">
                        <i class="fa fa-phone fa-3x fa-fw"></i>
                        <p>'. 
                        self::languageChecker(
                            <<<PL
                                "Odwiedzający" 
                            PL,
                            <<<EN
                                "Visitors" 
                            EN
                        )
                    .'<br> <a href="tel:48 513 903 628">+48 513 903 628</a>
                    </div>
                </div>
            </div>
        </div>
        ';

        return $output;
    }
}