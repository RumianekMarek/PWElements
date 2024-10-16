<?php 

/**
 * Class PWEExhibitorVisitorGenerator
 */
class PWEExhibitorVisitorGenerator extends PWEExhibitorGenerator {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    private static function generateToken() {
        $domain = $_SERVER["HTTP_HOST"];
        $secret_key = '^GY0ZlZ!xzn1eM5';
        return hash_hmac('sha256', $domain, $secret_key);
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {

        extract( shortcode_atts( array(
            'generator_form_id' => '',
            'exhibitor_generator_html_text' => '',
            'generator_catalog' => '',
        ), $atts ));

        $company_array = array();

        if(isset($_GET['katalog'])){
            if ($generator_catalog){
                $catalog_array =  self::catalog_data($_GET['katalog']);
                $company_array['exhibitor_token'] = $_GET['katalog'];
                $company_array['exhibitor_heder'] = '';
                $company_array['catalog_logo'] = $catalog_array['URL_logo_wystawcy'];
                $company_array['exhibitor_name'] = $catalog_array['Nazwa_wystawcy'];
            }
        } else if(isset($_GET['wystawca'])){
            $company_edition = vc_param_group_parse_atts( $atts['company_edition'] );
            foreach ($company_edition as $company){
                if($_GET['wystawca'] == $company['exhibitor_token']){
                    $company_array = $company;
                    break;
                }
            }
        }

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

        $send_file = plugins_url('other/mass_vip.php', dirname(dirname(dirname(__FILE__))));

        $generator_html_text_decoded = base64_decode($exhibitor_generator_html_text);
        $generator_html_text_decoded = urldecode($generator_html_text_decoded);
        $generator_html_text_content = wpb_js_remove_wpautop($generator_html_text_decoded, true);

        $output = '';
        $output .= '
        <div class="exhibitor-generator">
            <div class="exhibitor-generator__wrapper">
                <div class="exhibitor-generator__left"></div>
                <div class="exhibitor-generator__right">
                    <div class="exhibitor-generator__right-wrapper">
                        <div class="exhibitor-generator__right-title">
                            <h3>' . PWECommonFunctions::languageChecker('WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!', 'GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!') . '</h3>';
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

                        if(!isset($company_array['exhibitor_name'])){
                            $output .= '<button class="tabela-masowa btn-gold">' . PWECommonFunctions::languageChecker('Wysyłka zbiorcza', 'Collective send') . '</button>';
                        }

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