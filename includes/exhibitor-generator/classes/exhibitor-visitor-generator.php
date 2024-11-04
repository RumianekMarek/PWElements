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

        // Check if ?katalog = * exists in the URL
        if(isset($_GET['katalog'])){
            // Verify if the exhibitor catalog is connected to the site
            if ($generator_catalog){
                // Generate personal exhibitor information based on the catalog number
                $catalog_array =  self::catalog_data($_GET['katalog']);
                $company_array['exhibitor_token'] = $_GET['katalog'];
                $company_array['exhibitor_heder'] = '';
                $company_array['catalog_logo'] = $catalog_array['URL_logo_wystawcy'];
                $company_array['exhibitor_name'] = $catalog_array['Nazwa_wystawcy'];
            }
        // Check if ?wystawca=* exists in the URL
        } else if(isset($_GET['wystawca'])){
            // Generate personal exhibitor information based on PWElement config name
            $company_edition = vc_param_group_parse_atts( $atts['company_edition'] );
            foreach ($company_edition as $company){
                if($_GET['wystawca'] == $company['exhibitor_token']){
                    $company_array = $company;
                    break;
                }
            }
        }

        // If personal exhibitor information is available, filter out the exhibitor name field from the form.
        // The company name field will be populated with $company_array['exhibitor_name']
        if (isset($company_array['exhibitor_name'])){
            add_filter( 'gform_pre_render', function( $form ) use ( $company_array ) {
                return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
            });
            add_filter( 'gform_pre_validation', function( $form ) use ( $company_array ) {
                return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
            });
            add_filter( 'gform_pre_submission_filter', function( $form ) use ( $company_array ) {
                return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
            });
            add_filter( 'gform_admin_pre_render', function( $form ) use ( $company_array ) {
                return self::hide_field_by_label( $form, $company_array['exhibitor_name'] );
            });
        }
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
                            // Display personal exhibitor logo if available, otherwise use catalog logo
                            if(isset($company_array['exhibitor_logo'])){
                                $output .= '<img style="max-height: 120px;" src="' . wp_get_attachment_url($company_array['exhibitor_logo']) . '">';
                            } else if(isset($company_array['catalog_logo'])){
                                $output .= '<img style="max-height: 80px;" src="' . $company_array['catalog_logo'] . '">';
                            }
                        $output .= '
                        </div>
                        <div class="exhibitor-generator__right-icons">
                            <h5>' . PWECommonFunctions::languageChecker('Identyfikator VIP uprawnia do:', 'The VIP invitation entitles you to:') . '</h5>
                            <div class="exhibitor-generator__right-icons-wrapper">
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico1.png" alt="icon1">
                                    <p>' . PWECommonFunctions::languageChecker('Bezpłatnego skorzystania ze strefy VIP ROOM', 'Free use of the VIP ROOM zone') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico3.png" alt="icon3">
                                    <p>' . PWECommonFunctions::languageChecker('Fast track', 'Fast track') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico4.png" alt="icon4">
                                    <p>' . PWECommonFunctions::languageChecker('Opieki concierge`a', 'Concierge care') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico2.png" alt="icon2">
                                    <p>' . PWECommonFunctions::languageChecker('Uczestnictwa<br>we wszystkich konferencjach branżowych', 'Participation<br>in all industry conferences') . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="exhibitor-generator__right-form">
                            [gravityform id="'. $generator_form_id .'" title="false" description="false" ajax="false"]
                        </div>';

                        // Add a mass invite send button if not on a personal exhibitor page
                        if(!isset($company_array['exhibitor_name'])  && self::fairStartDateCheck()){
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
        ';

        return $output; 
    }
}