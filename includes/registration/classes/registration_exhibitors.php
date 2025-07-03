<?php

/**
 * Class PWERegistrationExhibitors
 * Extends PWEProfile class and defines a custom Visual Composer element.
 */
class PWERegistrationExhibitors extends PWERegistration {

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
    public static function output($atts, $registration_type, $registration_form_id) {
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white');
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$main2_color);

        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        if(get_locale() == 'pl_PL') {
            $registration_text = "Zapytaj o stoisko<br>Wypełnij poniższy formularz, a my skontaktujemy się z Tobą w celu przedstawienia preferencyjnych stawek* za powierzchnię wystawienniczą i zabudowę stoiska.<br>*oferta ograniczona czasowo";
        } else {
            $registration_text = "Ask for a stand<br>Fill out the form below and we will contact you to present preferential rates *  for the exhibition space and stand construction<br>* limited time offer";
        }

        $output = '
        <style>
            @media (min-width: 959px) {
                .wpb_column:has(#top10),
                .wpb_column:has(#pweRegistration) {
                    display: table-cell !important;
                }
            }
            .wpb_column #pweRegistration {
                margin: 0 auto;
            }
            #pweRegistration {
                max-width: 555px !important;
            }
        </style>';

        // CSS <----------------------------------------------------------------------------------------------<
        require_once plugin_dir_path(dirname( __FILE__ )) . 'assets/style.php';

        $output .= '
        <div id="pweRegistration" class="pwe-registration for-exhibitors">
            <div class="pwe-registration-column">
                <div id="pweFormContent" class="pwe-form-content">
                    <div id="main-content" class="pwe-registration-title main-heading-text">
                        <h1 class="custom-uppercase" style="font-size: 26px;"><span>'. self::languageChecker('DLA WYSTAWCÓW', 'BOOK A STAND') .'</span></h1>
                    </div>
                    <div class="pwe-registration-text">
                        <p>'.  $registration_text .'</p>
                    </div>
                </div>
                <div class="pwe-registration-form">
                    [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                </div>
            </div>
        </div>';

        return $output;
    }
}