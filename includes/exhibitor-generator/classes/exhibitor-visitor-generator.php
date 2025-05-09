<?php

/**
 * Class PWEExhibitorVisitorGenerator
 *
 * This class adding creating html for exhibitors to easy register their clients
 */
class PWEExhibitorVisitorGenerator extends PWEExhibitorGenerator {

    /**
     * Constructor method.
     * Calls parent constructor
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to check if there are minimum one more day before fair starts
     *
     * @return bool starting date did not pass
     */
    public static function fairStartDateCheck() {
        $today_date = new DateTime();

        $fair_start_date = new DateTime(do_shortcode('[trade_fair_datetotimer]'));

        $date_diffarance = $today_date->diff($fair_start_date);
        // Check if date doesn't past yet and there is minimum one more day befor fair starts
        if($date_diffarance->invert == 0 && $date_diffarance->days > 0){
            return true;
        }
        return false;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Additionaly can display personated page for Exhibitors registered in Exhibitors Catalog
     *
     * @param array @atts options
     * @return string html output
     */
    public static function output($atts) {
        extract( shortcode_atts( array(
            'generator_form_id' => '',
            'exhibitor_generator_html_text' => '',
            'generator_catalog' => '',
        ), $atts ));

        $company_array = array();
        // $trade_fair_edition_shortcode = do_shortcode('[trade_fair_edition]');
        // $premierEdition = $trade_fair_edition_shortcode =="Premierowa" || $trade_fair_edition_shortcode =="Premier";

        $pweGeneratorWebsite = strpos($_SERVER['REQUEST_URI'], '/generator-odwiedzajacych-pwe') !== false || strpos($_SERVER['REQUEST_URI'], '/en/exhibitor-generator-pwe/') !== false;

        // Check if ?katalog = * exists in the URL
        if(isset($_GET['katalog'])){
            // Verify if the exhibitor catalog is connected to the site
            if ($generator_catalog){
                // Generate personal exhibitor information based on the catalog number
                $catalog_array = self::catalog_data($_GET['katalog']);
                $company_array['exhibitor_token'] = $_GET['katalog'];
                $company_array['exhibitor_heder'] = '';
                $company_array['catalog_logo'] = self::$exhibitor_logo_url = $catalog_array['URL_logo_wystawcy'];
                $company_array['exhibitor_name'] = self::$exhibitor_name = $catalog_array['Nazwa_wystawcy'];
                $company_array['exhibitor_desc'] = self::$exhibitor_desc = $catalog_array['Opis_pl'];
            }
        // Check if ?wystawca=* exists in the URL
        } else if(isset($_GET['wystawca'])){
            // Generate personal exhibitor information based on PWElement config name
            $company_edition = vc_param_group_parse_atts( $atts['company_edition'] );
            foreach ($company_edition as $company){
                if(strtolower($_GET['wystawca']) == strtolower($company['exhibitor_token'])){
                    $company_array = $company;
                    break;
                }
            }
            self::$exhibitor_name = $company_array['exhibitor_name'];
            self::$exhibitor_desc = $company_array['exhibitor_desc'];
            self::$exhibitor_stand = $company_array['exhibitor_stand'];
            self::$exhibitor_logo_url = wp_get_attachment_url($company_array['exhibitor_logo']);
        } else {
            self::$exhibitor_logo_url = 'https://' . do_shortcode('[trade_fair_domainadress]') . '/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/logotyp_wystawcy.png';
        }

        if ($pweGeneratorWebsite) {
            self::$exhibitor_name = 'Ptak Warsaw Expo';
        }
        // If personal exhibitor information is available, filter out the exhibitor name field from the form.
        // The company name field will be populated with $company_array['exhibitor_name']
        // if (isset($company_array['exhibitor_name'])){
        //     add_filter( 'gform_pre_render', function( $form ) use ( $company_array ) {
        //         return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
        //     });
        //     add_filter( 'gform_pre_validation', function( $form ) use ( $company_array ) {
        //         return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
        //     });
        //     add_filter( 'gform_pre_submission_filter', function( $form ) use ( $company_array ) {
        //         return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
        //     });
        //     add_filter( 'gform_admin_pre_render', function( $form ) use ( $company_array ) {
        //         return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
        //     });
        // }
        // Determine the path to the mass invite sending functionality file
        $send_file = plugins_url('other/mass_vip.php', dirname(dirname(dirname(__FILE__))));

        // Decode optional text for the page
        $generator_html_text_decoded = base64_decode($exhibitor_generator_html_text);
        $generator_html_text_decoded = urldecode($generator_html_text_decoded);
        $generator_html_text_content = wpb_js_remove_wpautop($generator_html_text_decoded, true);

        //Creating HTML output
        $output = '';
        $output .= '
        <div class="exhibitor-generator">
            <div class="exhibitor-generator__wrapper">
                <div class="exhibitor-generator__left"></div>
                <div class="exhibitor-generator__right">
                    <div class="exhibitor-generator__right-wrapper">
                        <div class="exhibitor-generator__right-title">
                            <h3>' . PWECommonFunctions::languageChecker('WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!', 'GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!') . '</h3>';
                            if (!empty(self::$exhibitor_logo_url)  && !$pweGeneratorWebsite) {
                                $output .= '
                                <img id="exhibitor_logo_img" style="max-height: 120px;" src="' . self::$exhibitor_logo_url . '">
                                <h3>' . self::$exhibitor_name . '</h3>';
                            };
                        $output .= '
                        </div>
                        <div class="exhibitor-generator__right-icons">
                            <h5>' . PWECommonFunctions::languageChecker('Identyfikator VIP uprawnia do:', 'The VIP invitation entitles you to:') . '</h5>
                            <div class="exhibitor-generator__right-icons-wrapper">
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico3.png" alt="icon3">
                                    <p>' . PWECommonFunctions::languageChecker('Fast track', 'Fast track') . '</p>
                                </div>
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico4.png" alt="icon4">
                                    <p>' . PWECommonFunctions::languageChecker('Opieki concierge`a', 'Concierge care') . '</p>
                                </div>
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico1.png" alt="icon1">
                                    <p>' . PWECommonFunctions::languageChecker('VIP ROOM', 'VIP ROOM ') . '</p>
                                </div>
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico2.png" alt="icon2">
                                    <p>' . PWECommonFunctions::languageChecker('Udział w konferencjach', 'Participation in conferences') . '</p>
                                </div>';

                                if($pweGeneratorWebsite){
                                    $output .= '
                                    <div class="exhibitor-generator__right-icon">
                                        <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico6.png" alt="icon6">
                                        <p>' . PWECommonFunctions::languageChecker('Zaproszenie na Wieczór Branżowy', 'Invitation to the Industry Evening') . '</p>
                                    </div>';
                                }
                            $output .='

                            </div>
                        </div>
                        <div class="exhibitor-generator__right-form">
                            [gravityform id="'. $generator_form_id .'" title="false" description="false" ajax="false"]
                        </div>';

                        // Add a mass invite send button if not on a personal exhibitor page
                        if((!isset($company_array['exhibitor_name'])  && self::fairStartDateCheck()) || current_user_can('administrator')){
                            $output .= '<button class="tabela-masowa btn-gold">' . PWECommonFunctions::languageChecker('Wysyłka zbiorcza', 'Collective send') . '</button>';
                        }

                        // Add optional content to the page if available
                        if (!empty($generator_html_text_content)) {
                            $output .= '<div class="exhibitor-generator__right-text">' . $generator_html_text_content . '</div>';
                        }

                    $output .= '
                    </div>
                </div>
            </div>
        </div>
        <script>
           jQuery(document).ready(function($){
                let exhibitor_name = "' . self::$exhibitor_name . '";
                let exhibitor_desc = `' . self::$exhibitor_desc . '`;
                let exhibitor_stand = "' . self::$exhibitor_stand . '";

                $(".exhibitor_logo input").val("' . self::$exhibitor_logo_url . '");
                $(".exhibitors_name input").val(exhibitor_name);
                $(".exhibitor_desc input").val(exhibitor_desc);
                $(".exhibitor_stand input").val(exhibitor_stand);

                $(`input[placeholder="FIRMA ZAPRASZAJĄCA"]`).val(exhibitor_name);

                $(`input[placeholder="FIRMA ZAPRASZAJĄCA"]`).on("input", function(){
                    if(!$(".badge_name").find("input").is(":checked")){
                        $(".exhibitors_name input").val($(this).val());
                    }
                    exhibitor_name = $(this).val();
                });

                $(".badge_name").on("change", function(){
                    if($(this).find("input").is(":checked")){
                        $(".exhibitors_name input").val("");
                    } else {
                        $(".exhibitors_name input").val(exhibitor_name);
                    }
                });
           });
        </script>
        ';
        if($pweGeneratorWebsite){
            $output .= '
            <script>
            document.addEventListener("DOMContentLoaded", function () {
                // Funkcja do pobierania parametru z URL
                function getURLParameter(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
                }

                // Pobierz wartość parametru "p"
                const parametr = getURLParameter("p");

                // Jeśli parametr istnieje, znajdź input w elemencie o klasie "parametr" i wpisz wartość
                if (parametr) {
                const inputElement = document.querySelector(".parametr input");
                if (inputElement) {
                    inputElement.value = parametr;
                }
                }
            });
            </script>
            <style>
                .exhibitor-generator-tech-support {
                    display:none !important;
                }
            </style>';
        }

        return $output;
    }
}