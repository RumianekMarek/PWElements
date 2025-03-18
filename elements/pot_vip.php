<?php

/**
 * Class PWElementConfirmationVip
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementConfirmationVip extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Select form', 'pwelement'),
                'param_name' => 'conf_vip_form',
                'save_always' => true,
                'value' => array_merge(
                    array('Wybierz' => ''), 
                    self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementConfirmationVip',
                ),
            ),
        );
        return $element_output;
    }

     /**
     * Static method to display seccond step form (step2).
     * Returns the HTML output as a string.
     */
    public static function output($atts){

        extract( shortcode_atts( array(
            'conf_vip_form' => '',
        ), $atts ));

        $form_id = self::findFormsID($conf_vip_form);

        // Processing edition shortcode
        $trade_fair_edition_shortcode = do_shortcode('[trade_fair_edition]');
        if (strpos($trade_fair_edition_shortcode, '.') !== false) {
            $trade_fair_edition_text = (get_locale() == 'pl_PL') ? " edycja" : " edition";
        } else {
            $trade_fair_edition_text = (get_locale() == 'pl_PL') ? ". edycja" : ". edition";
        }
        $trade_fair_edition_first = (get_locale() == 'pl_PL') ? "Premierowa Edycja" : "Premier Edition";
        $trade_fair_edition = (!is_numeric($trade_fair_edition_shortcode) || $trade_fair_edition_shortcode == 1) ? $trade_fair_edition_first : $trade_fair_edition_shortcode . $trade_fair_edition_text;

        // Shortcodes of dates
        $start_date = do_shortcode('[trade_fair_datetotimer]');
        $end_date = do_shortcode('[trade_fair_enddata]');

        // Transform the dates to the desired format
        $formatted_date = PWECommonFunctions::transform_dates($start_date, $end_date);

        // Format of date
        if (self::isTradeDateExist()) {
            $actually_date = (get_locale() == 'pl_PL') ? '[trade_fair_date]' : '[trade_fair_date_eng]';
        } else {
            $actually_date = $formatted_date;
        }

        $output = '
        <style>
            .row-parent:has(#pweConfVip) {
                padding: 0 !important;
                max-width: 100%;
            }
            .wpb_column:has(#pweConfVip) {
                max-width: 100%;
            }
            .pwe-conf-vip__wrapper {
            }
            .pwe-conf-vip__columns {
                display: flex;
                min-height: 80vh;
            }
            .pwe-conf-vip__column {
                width: 50%;
                display: flex;
            }
            .pwe-conf-vip__column.bg {
                background-image: url(/doc/background.webp);
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            .pwe-conf-vip__column-content {
                display: flex;
                flex-direction: column;
                justify-content: center;
                max-width: 340px;
                margin: 0 auto;
                padding: 18px;
            }
            .pwe-conf-vip__column-content h2 {
                margin: 0;
            }
            .pwe-conf-vip__column-content p {
                line-height: 1.2;
                font-weight: 600;
            }
            .pwe-conf-vip__column-content-logo {
                max-width: 360px;
            }
            .pwe-conf-vip__column-content-date {
                font-size: 36px !important;
                width: 100% !important;
                color: white !important;
                text-align: center;
                margin: 0;
            }
            .pwe-conf-vip__column-content-btn-container {
                margin-top: 36px;
            }
            .pwe-conf-vip__column-content-btn-container a {
                background-color: black;
                color: white;
                padding: 8px 18px;
                border-radius: 10px;
            }
            .pwe-conf-vip__column-content-btn-container a:hover {
                color: #999 !important;
            }
            .pwe-conf-vip__column-content-edition {
                max-width: 360px;
                width: 100%;
                border-radius: 0;
                background-color: white;
                font-size: 36px;
                margin: 0;
                margin-top: 9px;
                padding: 6px;
                line-height: 1;
                text-transform: uppercase;
                text-align: center;
                font-weight: 700;
                display: flex;
                justify-content: center;
            }
            .pwe-conf-vip__column-content-edition span {
                background: url(/doc/header_mobile.webp) no-repeat center;
                color: transparent;
                    -webkit-background-clip: text;
                background-clip: text;
                font-size: 22px;
            }
            .pwe-conf-vip__footer {
                background-color: #f2f2f2;
            }
            .pwe-conf-vip__footer-wrapper {
                max-width: 1200px;
                display: flex;
                padding: 18px 36px;
                margin: 0 auto;
            } 
            .pwe-conf-vip__footer-column {
                display: flex;
                justify-content: space-around;
                width: 50%;
            }
            .pwe-conf-vip__footer-column p {
                margin: 0;
                font-weight: 600;
                text-align: center;
                display: flex;
                align-items: flex-end;
                margin: 0 auto;
            }
            .pwe-conf-vip__footer-column a {
                display: flex;
            }
            .pwe-conf-vip__footer-column svg {
                width: 30px;
                margin-left: 10px;
                transition: .3s ease;
            }
            .pwe-conf-vip__footer-column a:hover svg {
                transform: scale(1.2);
            }
            .pwe-conf-vip__form {
                visibility: hidden;
                height: 0px;
                width: 0;
                padding: 0;
                margin: 0;
                position: absolute;
                left: -1000px;
            }

            @media(max-width: 1200px) {
                .pwe-conf-vip__footer-column {
                    flex-direction: column;
                }
            }
            @media(max-width: 650px) {
                .wpb_column:has(#pweConfVip) {
                    padding: 0 !important;
                }
                .pwe-conf-vip__columns {
                    flex-direction: column-reverse;
                    min-height: auto;
                }
                .pwe-conf-vip__column {
                    width: 100%;
                }
                .pwe-conf-vip__column-content {
                    max-width: 300px;
                }
                .pwe-conf-vip__column-content-edition span {
                    font-size: 20px;
                }
            }   
            @media(max-width: 550px) {
                .pwe-conf-vip__footer-wrapper {
                    flex-direction: column;
                }
                .pwe-conf-vip__footer-column {
                    width: 100%;
                }
            } 
        </style>';

        $output .= '
        <div id="pweConfVip" class="pwe-conf-vip">
            <div class="pwe-conf-vip__wrapper">
                <div class="pwe-conf-vip__columns">
                    <div class="pwe-conf-vip__column">
                        <div class="pwe-conf-vip__column-content">
                            <h2>'. self::languageChecker('Dziękujemy za aktywację zaproszenia VIP', 'Thank you for activating your VIP invitation') .'</h2>
                            <p>'. self::languageChecker('Na państwa mail wysłaliśmy potwierdzenie wraz z kodem QR upoważniającym do wejścia na targi', 'We have sent a confirmation to your email along with a QR code authorizing entry to the fair.') .'</p>
                            <div class="pwe-conf-vip__column-content-btn-container">'. self::languageChecker('<a href="/">Strona główna</a>', '<a href="/en/">Home page</a>') .'</div>
                        </div>
                    </div>
                    <div class="pwe-conf-vip__column bg">
                        <div class="pwe-conf-vip__column-content">
                            <img class="pwe-conf-vip__column-content-logo" src="'. self::languageChecker('/doc/logo.webp', '/doc/logo-en.webp') .'">';
                            if (!empty($trade_fair_edition_shortcode)) {
                                $output .= '<p class="pwe-conf-vip__column-content-edition"><span>'. $trade_fair_edition .'</span></p>';
                            } $output .= '
                            <h3 class="pwe-conf-vip__column-content-date">'. $actually_date .'</h3>
                        </div>
                    </div>
                </div>
                <div class="pwe-conf-vip__footer">
                    <div class="pwe-conf-vip__footer-wrapper">
                        <div class="pwe-conf-vip__footer-column">
                            <p>PTAK WARSAW EXPO</p>
                            <p>AL. KATOWICKA 62, 05-830 NADARZYN</p>
                        </div>
                        <div class="pwe-conf-vip__footer-column">
                            <p>INFO@WARSAWEXPO.EU</p>
                            <p>'. self::languageChecker('ŚLEDŹ NAS NA', 'FOLLOW US ON') .' <a href="[trade_fair_facebook]" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M512 256C512 114.6 397.4 0 256 0S0 114.6 0 256C0 376 82.7 476.8 194.2 504.5V334.2H141.4V256h52.8V222.3c0-87.1 39.4-127.5 125-127.5c16.2 0 44.2 3.2 55.7 6.4V172c-6-.6-16.5-1-29.6-1c-42 0-58.2 15.9-58.2 57.2V256h83.6l-14.4 78.2H287V510.1C413.8 494.8 512 386.9 512 256h0z"/></svg></a></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pwe-conf-vip__form">
                [gravityform id="'. $conf_vip_form .'" title="false" description="false" ajax="false"]               
            </div>
        </div>
        
        <script>
            jQuery(document).ready(function() {
                var url_string = window.location.href;
                var url = new URL(url_string);

                var getname = url.searchParams.get("getname");
                var getphone = url.searchParams.get("getphone");
                var getemail = url.searchParams.get("getemail");
                var entry_id = url.searchParams.get("entry_id");
                var getid = url.searchParams.get("getid");
                var badge = url.searchParams.get("badge");
                var firma = url.searchParams.get("firma");
                var kanal = url.searchParams.get("kanal");

                let idmail = [];
                if (getid) {
                    idmail = getid.split(",");
                }

                document.getElementById("input_'. $form_id .'_1").value = getname;
                document.getElementById("input_'. $form_id .'_5").value = getphone;
                document.getElementById("input_'. $form_id .'_4").value = getemail;
                document.getElementById("input_'. $form_id .'_9").value = getid;
                document.getElementById("input_'. $form_id .'_10").value = badge;
                document.getElementById("input_'. $form_id .'_11").value = firma;
                document.getElementById("input_'. $form_id .'_13").value = idmail[2];
                document.getElementById("input_'. $form_id .'_15").value = idmail[3]
                document.getElementById("input_'. $form_id .'_17").value = idmail[1];
                document.getElementById("input_'. $form_id .'_18").value = kanal;

                if(getid) {
                    setTimeout(function(){
                        jQuery("#gform_'. $form_id .'").trigger("submit",[true]);
                    }, 200);
                }
            });
        </script>';

        return $output;
    }
}