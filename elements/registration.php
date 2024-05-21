<?php 

/**
 * Class PWElementRegistration
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementRegistration extends PWElements {

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
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title form', 'pwelement'),
                'param_name' => 'registration_title',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementRegistration',
                ),
            ),
            array(
                'type' => 'textarea',
                'group' => 'PWE Element',
                'heading' => __('Custom text form', 'pwelement'),
                'param_name' => 'registration_text',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementRegistration',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom button text form', 'pwelement'),
                'param_name' => 'registration_button_text',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementRegistration',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Height logotypes', 'pwelement'),
                'description' => __('Default 50px', 'pwelement'),
                'param_name' => 'registration_height_logotypes',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementRegistration',
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Form id', 'pwelement'),
                'param_name' => 'registration_form_id',
                'save_always' => true,
                'value' => array_merge(
                  array('Wybierz' => ''),
                  self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementRegistration',
                ),
            ),
        );
        return $element_output;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . ' !important';

        extract( shortcode_atts( array(
            'registration_title' => '',
            'registration_text' => '',
            'registration_button_text' => '',
            'registration_height_logotypes' => '',
            'registration_form_id' => '',
        ), $atts ));

        if (empty($registration_height_logotypes)) {
            $registration_height_logotypes = '50px';
        }

        if(get_locale() == 'pl_PL') {
            $registration_title = ($registration_title == "") ? "DLA ODWIEDZAJĄCYCH" : $registration_title;
            $registration_text = ($registration_text == "") ? "Wypełnij formularz i odbierz darmowy bilet" : $registration_text;
            $registration_button_text = ($registration_button_text == "") ? "ODBIERZ DARMOWY BILET" : $registration_button_text;
        } else {
            $registration_title = ($registration_title == "") ? "FOR VISITORS" : $registration_title;
            $registration_text = ($registration_text == "") ? "Fill out the form and receive your free ticket" : $registration_text;
            $registration_button_text = ($registration_button_text == "") ? "GET A FREE TICKET" : $registration_button_text;
        }

        // Create unique id for element
        $unique_id = rand(10000, 99999);
        $element_unique_id = 'pweRegistration-' . $unique_id;
        
        $output = '
        <style> 
            .pwelement_'. self::$rnd_id .' .gform_wrapper input[type="submit"] {
                opacity: 0;
            }
            .pwelement_'. self::$rnd_id .' .gform_wrapper :is(label, .gfield_description),
            .pwelement_'. self::$rnd_id .' .gform_legacy_markup_wrapper .gfield_required, 
            .pwelement_'. self::$rnd_id .' .show-consent {
                color: '. $text_color .';
            }
            .pwelement_'. self::$rnd_id .' .pwe-registration .gform-body ul,
            .uncell:has(.img-container-top10) {
                padding: 0 !important;
            }
            .pwelement_'. self::$rnd_id .' .pwe-registration-column {
                padding: 36px;
                height: 100%;
            }
            .row-container:has(.img-container-top10) #top10 {
                padding: 36px;
                box-shadow: 9px 9px 0px -5px black;
                border: 2px solid;
                height: 100%;
            }
            .pwelement_'. self::$rnd_id .':has(.pwe-registration),
            .pwelement_'. self::$rnd_id .' .pwe-registration,
            .row-container:has(.img-container-top10) .uncol,
            .row-container:has(.img-container-top10) .uncell,
            .row-container:has(.img-container-top10) .uncont {
                height: 100%;
            }
            .pwelement_'. self::$rnd_id .' .pwe-registration-title h4, 
            .pwelement_'. self::$rnd_id .' .pwe-registration-text p {
                color: '. $text_color .';
            }
            .pwelement_'. self::$rnd_id .' .pwe-registration-title h4 {
                margin-top: 0 !important;
                box-shadow: 9px 9px 0px -6px '. $text_color .';
            }
            @media (max-width: 450px) {
                .pwelement_'. self::$rnd_id .' input[type="submit"] {
                    padding: 12px 20px !important;
                    font-size: 3.3vw !important;
                }
            }
        </style>';

        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);
        if ($mobile != 1) {
            $output .= '<style>
                            .row-container:has(.img-container-top10) .img-container-top10 div {
                                min-height: '. $registration_height_logotypes .';
                                margin: 10px 5px !important;
                            }
                        </style>';
        }

        $output .= '
        <div id="'. $element_unique_id .'" class="pwe-registration">
            <div class="pwe-registration-column style-accent-bg shadow-black">
                <div id="pweFormContent" class="pwe-form-content">
                    <div class="pwe-registration-title main-heading-text">
                        <h4 class="custom-uppercase"><span>'. $registration_title .'</span></h4>
                    </div>  
                    <div class="pwe-registration-text">';
                        $registration_text = str_replace(array('`{`', '`}`'), array('[', ']'), $registration_text);
                        $output .= '<p>'. wpb_js_remove_wpautop($registration_text, true) .'</p>
                    </div>
                </div>
                <div class="pwe-registration-form">
                    [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                </div>
            </div>
        </div>';          

        $output .= "
            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    const pweElement = document.querySelector('.pwelement_". self::$rnd_id ."');
                    let pweFormButton = pweElement.querySelector('.gform_wrapper input[type=\'submit\']');
                    if (pweFormButton) {
                        pweFormButton.style.opacity = 1;
                        pweFormButton.style.transition = 'opacity 0.3s ease';
                        pweFormButton.value = '". $registration_button_text ."';
                    }
                });
            </script>";

        return $output;

    }
}

?>
