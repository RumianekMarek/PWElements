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

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {

        extract( shortcode_atts( array(
            'exhibitor_generator_form_id' => '',
            'exhibitor_generator_html_text' => '',
        ), $atts ));

        $generator_html_text_decoded = base64_decode($exhibitor_generator_html_text);
        $generator_html_text_decoded = urldecode($generator_html_text_decoded);
        $generator_html_text_content = wpb_js_remove_wpautop($generator_html_text_decoded, true);

        $output = '';
        $output .= '
        <div class="exhibitor-generator">
            <div class="exhibitor-generator__wrapper">
                <div class="exhibitor-generator__left">
                    <div class="exhibitor-generator__left-wrapper">
                        <h3>' . self::languageChecker('WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!', 'GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!') . '</h3>
                    </div>
                </div>
                <div class="exhibitor-generator__right">
                    <div class="exhibitor-generator__right-wrapper">
                        <div class="exhibitor-generator__right-title">
                            <h3>' . self::languageChecker('WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!', 'GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!') . '</h3>
                        </div>
                        <div class="exhibitor-generator__right-icons">
                            <h5>' . self::languageChecker('Identyfikator VIP uprawnia do:', 'The VIP invitation entitles you to:') . '</h5>
                            <div class="exhibitor-generator__right-icons-wrapper">
                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico1.png" alt="icon1">
                                    <p>' . self::languageChecker('Bezpłatnego skorzystania ze strefy VIP ROOM', 'Free use of the VIP ROOM zone') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico3.png" alt="icon3">
                                    <p>' . self::languageChecker('Fast track', 'Fast track') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico4.png" alt="icon4">
                                    <p>' . self::languageChecker('Opieki concierge`a', 'Concierge care') . '</p>
                                </div>

                                <div class="exhibitor-generator__right-icon">
                                    <img src="/wp-content/plugins/PWElements/includes/exhibitor-generator/assets/media/ico2.png" alt="icon2">
                                    <p>' . self::languageChecker('Uczestnictwa<br>we wszystkich konferencjach branżowych', 'Participation<br>in all industry conferences') . '</p>
                                </div>
                            </div>
                        </div>
                        <div class="exhibitor-generator__right-form">
                            [gravityform id="'. $exhibitor_generator_form_id .'" title="false" description="false" ajax="false"]
                        </div>';
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