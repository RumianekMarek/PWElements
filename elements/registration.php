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
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Select form', 'pwelement'),
                'param_name' => 'registration_select',
                'save_always' => true,
                'value' => array(
                    'Dla odwiedzających' => 'visitors',
                    'Dla wystawców' => 'exhibitors',
                    'Conferencja' => 'conference',
                ),
                'std' => 'visitors',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementRegistration',
                ),
            ),
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
    public static function custom_css_1() {
        $css_output = '
            <style>
                .pwelement_' . self::$rnd_id . ' .pwe-registration-column{
                    background-color: #e8e8e8;
                    padding: 18px 36px;
                    border: 2px solid #564949;
                }
                .pwelement_' . self::$rnd_id . ' input{
                    border: 2px solid #564949 !important;
                    box-shadow: none !important;
                    line-height: 1 !important;
                }
                .pwelement_' . self::$rnd_id . ' :is(label, label span, .gform_legacy_markup_wrapper .gfield_required, .gfield_description){
                    color: black !important;
                }
                .pwelement_' . self::$rnd_id . ' input:not([type=checkbox]){
                    border-radius: 11px !important;
                }
                .pwelement_' . self::$rnd_id . ' input[type=checkbox]{
                    border-radius: 2px !important;
                }
                .pwelement_' . self::$rnd_id . ' input[type=submit]{
                    background-color: #A6CE39 !important;
                    border-width: 1px !important;
                }
                .pwelement_' .self::$rnd_id. ' .gform_fields{
                    padding-left: 0 !important;
                }
                .pwelement_' .self::$rnd_id. ' .gform-field-label {
                    display: inline !important;
                } 
                .pwelement_' .self::$rnd_id. ' .gform-field-label .show-consent,
                .pwelement_' .self::$rnd_id. ' .gform-field-label .gfield_required_asterisk {
                    display: inline !important;
                    margin-left: 0;
                    padding-left: 0;
                }
                /*ROZWIJANE ZGODY*/
                .gfield_consent_description{
                    overflow: hidden !important;
                    max-height: auto !important;
                    border: none !important;
                    display: none;
                }
                .show-consent:hover{
                    cursor: pointer;
                }
                @media (max-width:400px) {
                    .pwelement_' .self::$rnd_id. ' input[type="submit"] {
                        font-size: 12px !important;
                    }
                }
            </style>
        ';
        return $css_output;
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . ' !important';

        global $registration_button_text, $registration_form_id;

        extract( shortcode_atts( array(
            'registration_select' => '',
            'registration_title' => '',
            'registration_text' => '',
            'registration_button_text' => '',
            'registration_height_logotypes' => '',
            'registration_form_id' => '',
        ), $atts ));

        if (empty($registration_height_logotypes)) {
            $registration_height_logotypes = '50px';
        }

        if ($registration_select == "conference") {
            
        } else if ($registration_select == "exhibitors") {
            if(get_locale() == 'pl_PL') {
                $registration_title = ($registration_title == "") ? "DLA WYSTAWCÓW" : $registration_title;
                $registration_text = ($registration_text == "") ? "Zapytaj o stoisko<br>Wypełnij poniższy formularz, a my skontaktujemy się z Tobą w celu przedstawienia preferencyjnych stawek* za powierzchnię wystawienniczą i zabudowę stoiska.<br>*oferta ograniczona czasowo" : $registration_text;
                $registration_button_text = ($registration_button_text == "") ? "WYŚLIJ" : $registration_button_text;
            } else {
                $registration_title = ($registration_title == "") ? "BOOK A STAND" : $registration_title;
                $registration_text = ($registration_text == "") ? "Ask for a stand<br>Fill out the form below and we will contact you to present preferential rates *  for the exhibition space and stand construction<br>* limited time offer" : $registration_text;
                $registration_button_text = ($registration_button_text == "") ? "SEND" : $registration_button_text;
            }
        } else {
            if(get_locale() == 'pl_PL') {
                $registration_title = ($registration_title == "") ? "DLA ODWIEDZAJĄCYCH" : $registration_title;
                $registration_text = ($registration_text == "") ? "Wypełnij formularz i odbierz darmowy bilet" : $registration_text;
                $registration_button_text = ($registration_button_text == "") ? "ODBIERZ DARMOWY BILET" : $registration_button_text;
            } else {
                $registration_title = ($registration_title == "") ? "FOR VISITORS" : $registration_title;
                $registration_text = ($registration_text == "") ? "Fill out the form and receive your free ticket" : $registration_text;
                $registration_button_text = ($registration_button_text == "") ? "GET A FREE TICKET" : $registration_button_text;
            }
        }

        // Create unique id for element
        $unique_id = rand(10000, 99999);
        $element_unique_id = 'pweRegistration-' . $unique_id;

        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);
        if ($mobile != 1) {
            $output .= '<style>
                            .row-container:has(.img-container-top10) .img-container-top10 div {
                                min-height: '. $registration_height_logotypes .';
                                margin: 10px 5px !important;
                            }
                        </style>';
        }

        if ($registration_select == "conference") {
            $output .= '
            <style>

                body:has(#'. $element_unique_id .' .form-3, #'. $element_unique_id .' .form-2) :is(.custom-footer-bg, .custom-footer-images-bg){
                    display: none;
                }
                
                .pwelement:has(#'. $element_unique_id .'){
                    text-align: -webkit-center;
                }
                
                #'. $element_unique_id .':has(.form-1) {
                    background-image: url(/wp-content/plugins/PWElements/media/badge-head.png);
                    background-repeat: round;
                    height: 830px;
                    background-size: cover;
                    max-width: 545px;
                }
                #'. $element_unique_id .' input{
                    box-shadow: none;
                }

                #'. $element_unique_id .' .form-1,
                #'. $element_unique_id .' .form-1-top {
                    max-width: 490px;
                    left: 50%;
                    transform: translateX(-50%);
                }
                
                #'. $element_unique_id .' .form-1-top {
                    width: 89.3%;
                    position: absolute;
                    z-index: 7;
                    background-color: ' . self::$accent_color . ';
                    top: 150px;
                    height: 120px;
                    right: 5.7%;
                }

                #'. $element_unique_id .' .form-1 {
                    text-align: left;
                    position: relative;
                    height: 520px;
                    padding: 10px calc(50px + 1vw);
                    top: 100px;
                    z-index: 5;
                }
                
                #'. $element_unique_id .' input {
                    border-color: #c49a62 !important;
                    border-radius: 10px;
                }
                
                #'. $element_unique_id .' input:not(.checkbox) {
                    margin: 5px 0 0;
                    width: 100%;
                    padding: 10px 15px;
                }
                
                #'. $element_unique_id .' p {
                    margin-top: 0px;
                }
                
                #'. $element_unique_id .' .consent-text {
                    font-size: 11px;
                    margin-left: 5px;
                }
                
                #'. $element_unique_id .' button {
                    text-transform: uppercase;
                    margin-top: 20px;
                    font-weight: 600;
                    ' . $btn_color . '
                    color: white;
                    border: 1px solid white;
                    border-radius: 11px;
                    padding: 13px calc(10px + 1vw);
                }

                #'. $element_unique_id .' .form-1-btn{
                    width: 100%;
                    font-size: calc(10px + 0.6vw);
                }

                #'. $element_unique_id .' .form-1-image {
                    position: absolute;
                    width: calc(100px + 3vw);
                    border-radius: 15px;
                    top: 40%;
                    right: 5%;
                    z-index: 10;
                }
                
                #'. $element_unique_id .' .form-1 #registration {
                    margin-top: 36px;
                }
                
                #'. $element_unique_id .' button:hover, #'. $element_unique_id .' .exhibitor-no {
                    background: white !important;
                    color: black;
                    border-color: black;
                }
                
                #'. $element_unique_id .' .exhibitor-no:hover{
                    color: white;
                    background: black !important;
                }

                #'. $element_unique_id .':has(.form-2), #'. $element_unique_id .':has(.form-3){
                    min-height: 780px;
                    display: flex;
                    align-items: center;
                }

                #'. $element_unique_id .' .form-2 .krok span {
                    ' . $text_color . '
                }

                #'. $element_unique_id .' .form-2 .wystawca span {
                    ' . $text_color . '
                }
                
                #'. $element_unique_id .' .form-2 {
                    text-align: -webkit-right;
                    width:50%;
                }
                #'. $element_unique_id .' .form-2>div {
                    width: fit-content;
                    text-align: left;
                    margin:36px;
                }

                #'. $element_unique_id .' .form-2-right {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    gap: 30px;
                    background-image: url(doc/background.webp);
                    background-size: cover;
                    width:50%;
                    min-height: inherit;
                    padding: 36px;
                }
                
                #'. $element_unique_id .' .form-2-right img{
                    width: 250px;
                }

                #'. $element_unique_id .' .form-2-right :is(h3, h4) {
                    text-shadow: 0 0 2px black;
                    color: white !important;
                }
                
                #'. $element_unique_id .' .form-2-right :is(h3, h4) {
                    text-shadow: 0 0 2px black;
                    color: white !important;
                }

                #'. $element_unique_id .' label {
                    font-weight: 700;
                    font-size: 15px;
                }
                
                #'. $element_unique_id .' .consent-container {
                    margin-top: 5px;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
                
                #'. $element_unique_id .':has(.form-3)>div{
                    width: 33%;
                }
                #'. $element_unique_id .' .form3-half {
                    display: flex;
                    gap: 20px;
                }
                #'. $element_unique_id .' .form3-half>div{
                    flex: 1;
                }
                #'. $element_unique_id .' .form-3{
                    text-align: left;
                    padding: 25px 50px;
                    background-color: #E8E8E8;
                    align-content: center;
                    min-height: inherit;
                }
                #'. $element_unique_id .' .form-3 div:has(button){
                    text-align: center;
                }
                #'. $element_unique_id .' .form-3 span, #'. $element_unique_id .' .color-accent{
                    ' . $text_color . '
                }
                #'. $element_unique_id .' .form-3 label{
                    margin-top: 18px;
                    float: left;
                }
                #'. $element_unique_id .' .form-3-left {
                    text-align: -webkit-right;
                    padding: 36px;
                }
                #'. $element_unique_id .' .form-3-left>div {
                    text-align:left;
                    max-width: 320px;
                }
                #'. $element_unique_id .' .form-3-right:has(.img-stand){
                    padding: 36px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 27px;
                }
                #'. $element_unique_id .' .btn-stand{
                    background-color: black;
                    color:white;
                }
                #'. $element_unique_id .' .very-strong {
                    font-weight: 700;
                }

                @media (min-width:640px) and (max-width: 959px){
                    #'. $element_unique_id .':has(.form-1) {
                        background-repeat: none;
                    }
                    #'. $element_unique_id .' .form-1-top {
                        width: 488px;
                        left: 50%;
                        transform: translateX(-50.5%);
                    }
                }
                @media (max-width:799px){
                    #'. $element_unique_id .':has(.form-2) {
                        flex-direction: column;
                    }
                    #'. $element_unique_id .' :is(.form-2, .form-2-right){
                        width:100%;
                        min-height: 0;
                    }
                    #'. $element_unique_id .' .form-2{
                        text-align: -webkit-center;
                    }
                    #'. $element_unique_id .' .form-2-right {
                        align-items: center;
                    }
                } 

                @media (max-width:639px){
                    #'. $element_unique_id .' .form-1-top .h1{
                        width: calc(100px + 12vw);
                    }
                    #'. $element_unique_id .' .form-1 {
                        padding: 10px calc(30px + 1vw);
                    }
                    #'. $element_unique_id .' .form-1-btn {
                        font-size: calc(9px + 0.1vw);
                    }
                    #'. $element_unique_id .' .form-1 #registration {
                        margin-top: 3vw;
                    }
                    #'. $element_unique_id .' .form-2 .h1{
                        font-size: calc(25px + 3vw);
                    }
                } 
            </style>
            
        ';
            $output .= '
            <div id="'. $element_unique_id .'" class="pwe-registration">
                <div class="form-1-top">
                    <image class="form-1-image" src="/wp-content/plugins/PWElements/media/badge_qr.jpg">
                    <div class="form-1">
                        <h2 class="h1 text-color-jevc-color">Twój bilet<br>na targi</h2>
                        <div class="pwe-registration-form">
                            [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                        </div>
                    </div>
                </div>
            </div>
            ';
        } else {
            $output .= self::custom_css_1();
            $output .= '
            <div id="'. $element_unique_id .'" class="pwe-registration">
                <div class="pwe-registration-column">
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
            
            if (class_exists('GFAPI')) {
                function get_form_id_by_title($title) {
                    // Pobierz wszystkie formularze
                    $forms = GFAPI::get_forms();
                    foreach ($forms as $form) {
                        if ($form['title'] === $title) {
                            return $form['id'];
                        }
                    }
                    return null;
                }
                
                function custom_gform_submit_button($button, $form) {
                    global $registration_button_text, $registration_form_id;
                    $registration_form_id_nmb = get_form_id_by_title($registration_form_id);
            
                    if ($form['id'] == $registration_form_id_nmb) {
                        $button = '<input type="submit" id="gform_submit_button_'.$registration_form_id_nmb.'" class="gform_button button" value="'.$registration_button_text.'" onclick="if(window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]){return false;}  if( !jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity || jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity()){window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]=true;}  " onkeypress="if( event.keyCode == 13 ){ if(window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]){return false;} if( !jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity || jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity()){window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]=true;}  jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;).trigger(&quot;submit&quot;,[true]); }">';
                    }
                    return $button;
                }
                add_filter('gform_submit_button', 'custom_gform_submit_button', 10, 2);  
            }
        }
        
        return $output;

    }
}