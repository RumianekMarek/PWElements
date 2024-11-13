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
            .pwe-conf-vip {
            }
            .pwe-conf-vip__wrapper {
            }
            .pwe-conf-vip__columns {
            display: flex;
    min-height: 90vh;
            }
            .pwe-conf-vip__column {
            width: 50%;
            }
            .pwe-conf-vip__column-content {
            display: flex;
    flex-direction: column;
    justify-content: center;
    max-width: 340px;
    margin: 0 auto;
            }
            .pwe-conf-vip__column-content-btn-container {
            }
            .pwe-conf-vip__column-content-edition {
            }
            .pwe-conf-vip__footer {
            }
            .pwe-conf-vip__footer-column {
            }
            .pwe-conf-vip__form {
            }
        </style>';

        $output .= '
        <div id="pweConfVip" class="pwe-conf-vip">
            <div class="pwe-conf-vip__wrapper">
                <div class="pwe-conf-vip__columns">
                    <div class="pwe-conf-vip__column">
                        <div class="pwe-conf-vip__column-content">
                            <h2>Dziękjemy za aktywację zaproszenia VIP</h2>
                            <p>Na państwa mail wysłaliśmy potwierdzenie wraz z kodem QR upoważniającym do wejścia na targi</p>
                            <div class="pwe-conf-vip__column-content-btn-container">'. self::languageChecker('<a href="/">Strona główna</a>', '<a href="/en/">Home page</a>') .'</div>
                        </div>
                    </div>
                    <div class="pwe-conf-vip__column" style="background-image: url(/doc/background.webp);">
                        <div class="pwe-conf-vip__column-content">';
                            self::languageChecker('<img src="/doc/logo.webp">', '<img src="/doc/logo-en.webp">'); 
                            if (!empty($trade_fair_edition_shortcode)) {
                                $output .= '<p class="pwe-conf-vip__column-content-edition"><span>'. $trade_fair_edition .'</span></p>';
                            } $output .= '
                            <h3>'. $actually_date .'</h3>
                        </div>
                    </div>
                </div>
                <div class="pwe-conf-vip__footer">
                    <div class="pwe-conf-vip__footer-column">
                        <p>PTAK WARSAW EXPO</p>
                        <p>AL. KATOWICKA 62, 05-830 NADARZYN</p>
                    </div>
                    <div class="pwe-conf-vip__footer-column">
                        <p>INFO@WARSAWEXPO.EU</p>
                        <p>ŚLEDŹ NAS NA </p>
                    </div>
                </div>
            </div>
            <div class="pwe-conf-vip__form">
                [gravityform id="'. $conf_vip_form .'" title="false" description="false" ajax="false"]               
            </div>
        </div>';

        return $output;
    }
}