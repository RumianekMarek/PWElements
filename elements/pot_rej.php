<?php

/**
 * Class PWElementPotwierdzenieRejestracji
 * Extends PWElements class and defines a pwe Visual Composer element for x-steps-form.
 */
class PWElementPotwierdzenieRejestracji extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }    

    // /**
    //  * Static method to initialize Visual Composer elements.
    //  * Returns an array of parameters for the Visual Composer element.
    //  */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Registration form', 'pwelement'),
                'param_name' => 'reg_form_name_pr',
                'save_always' => true,
                'value' => array_merge(
                    array('Wybierz' => ''),
                    self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementPotwierdzenieRejestracji',
                ),
            ),
        );
        return $element_output;
    }

     /**
     * Static method to display seccond step form (step2).
     * Returns the HTML output as a string.
     */
    public static function output($atts, $content = ''){
                
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black');
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white');
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color);
        $btn_shadow_color = self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black');
        $btn_border = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color);

        $main_page_text_btn = (get_locale() == 'pl_PL') ? "Powrót do strony głównej" : "Back to main page" ;
        $confirmation_page_text_btn = (get_locale() == 'pl_PL') ? "Zamawiam Bezpłatny identyfikator" : "Order your Free ID" ;

        $output .= '
            <style>
                .pwelement_' . self::$rnd_id . ' #xForm{
                    display: flex;
                    gap: 20px;
                }

                .pwelement_' . self::$rnd_id . ' #xForm>div{
                    align-content: center;
                    min-height: 643px;
                    width: 33%;
                }

                .pwelement_' . self::$rnd_id . ' .very-strong{
                    font-weight:700;
                }
                .pwelement_' . self::$rnd_id . ' .form-3-left {
                    margin-left: 36px;
                    padding: 36px;
                }
                .pwelement_' . self::$rnd_id . ' .form-3{
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    text-align: left;
                    padding: 25px 50px;
                    background-color: #E8E8E8;
                    min-height: inherit;
                }
                .pwelement_' . self::$rnd_id . ' .form-3-right{
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 27px;
                }
                .pwelement_' . self::$rnd_id . ' .golden-text{
                    color: #c49a62 !important;
                }
                .pwelement_' . self::$rnd_id . ' .form-3 form{
                    margin-top: 18px;
                }

                .pwelement_' . self::$rnd_id . ' .form-3 form .form3-half{
                    display:flex;
                    gap:9px;
                }
                .pwelement_' . self::$rnd_id . ' .form-3 form .form3-half>div{
                    width: 100%;
                }

                .pwelement_' . self::$rnd_id . ' form{
                    margin-top:36px;
                }
                .pwelement_' . self::$rnd_id . ' form .gform_fields{
                    row-gap: 18px !important;
                }
                .pwelement_' . self::$rnd_id . ' form label{
                    margin-left: 5px;
                    text-align: left;
                    font-weight: 700 !important;
                }
                .pwelement_' . self::$rnd_id . ' form .gfield_required{
                    display: none !important;
                }
                .pwelement_' . self::$rnd_id . ' form .gform_footer{
                    visibility: hidden;
                    height:0;
                    margin: 0;
                    padding: 0; 
                }
                .pwelement_' . self::$rnd_id . ' label{
                    padding-left: 10px;
                }
                .pwelement_'. self::$rnd_id .' .gform_wrapper :is(label, .gfield_description) {
                    color: black;
                }
                .pwelement_' . self::$rnd_id . ' form :is(input, textarea){
                    margin-bottom: 18px;
                    width: 100%;
                    border-radius: 11px !important;
                    border-color: black !important;
                    box-shadow: none !important;
                }
                .pwelement_' . self::$rnd_id . ' .pwe_reg_visitor{
                    background-color: '. $btn_color .' !important;
                    border: 2px solid '. $btn_color .' !important;
                    color: '. $btn_text_color .';
                    margin-top: 36px;
                    border-radius: 10px !important;
                }
                .pwelement_' . self::$rnd_id . ' .pwe_reg_visitor:hover{
                    color: '. $btn_color .' !important;
                    background-color: white !important;
                    border: 2px solid '. $btn_color .' !important;
                }


                .pwelement_' . self::$rnd_id . ' .form-3 form div:has(button){
                    margin-top:18px;
                    text-align: center;
                    width: 100%;
                }

                .pwelement_' . self::$rnd_id . ' .form-3 form button{
                    color: white;
                    background-color:' . $text_color . ';
                    border: 1px solid ' . $text_color . ';
                    border-radius: 11px;
                    text-wrap: balance;
                }

                .pwelement_' . self::$rnd_id . ' .form-3 form button:hover{
                    color: black;
                    background-color: white;
                    border: 1px solid ' . $text_color . ';
                }

                .pwelement_' . self::$rnd_id . ' .form-3-right .pwe-link{
                    color: white;
                    background-color: black;
                    border: 1px solid black;
                }

                .pwelement_' . self::$rnd_id . ' .form-3-right .pwe-link:hover{
                    color: black;
                    background-color: white;
                }

                .pwelement_' . self::$rnd_id . ' .pwe-submitting-buttons{
                    text-align: center;
                }

                .pwelement_' . self::$rnd_id . ' #xForm:has(.gform_confirmation_wrapper) .display-befor-subbmit{
                    display: none;
                }

                .pwelement_' . self::$rnd_id . ' .display-after-subbmit{
                    display: none;
                }

                .pwelement_' . self::$rnd_id . ' #xForm:has(.gform_confirmation_wrapper) .display-after-subbmit{
                    display: block !important;
                }
                .pwelement_' . self::$rnd_id . ' .pwe-submitting-buttons .pwe-btn {
                    transform: scale(1) !important;
                }
                .pwelement_'. self::$rnd_id .' .gform_wrapper :is(label, .gfield_description, legend), 
                .pwelement_'. self::$rnd_id .' p {
                    color: '. $text_color .' !important;   
                }
                .pwelement_'. self::$rnd_id .' .gform_wrapper :is(label, legend) {
                    font-size: 14px !important;
                    font-weight: 700;   
                }
                .pwelement_'. self::$rnd_id .' .gform_confirmation_message {
                    font-size: 20px;
                    font-weight: 600;
                    text-align: center;
                }
                @media (min-width:570px) and (max-width:959px){
                    .vc_row .full-width:has(.pwelement_' . self::$rnd_id . ') {
                        padding: 0 !important;
                    }
                    .vc_row .full-width:has(.pwelement_' . self::$rnd_id . ') .wpb_column {
                        max-width: unset !important;
                    }
                    .pwelement_' . self::$rnd_id . ' #xForm {
                        gap: 0;
                    }
                    .pwelement_' . self::$rnd_id . ' .form-3 {
                        padding: 18px; 
                    }
                    .pwelement_' . self::$rnd_id . ' .form-3-right {
                        display:none;
                    }
                    .pwelement_' . self::$rnd_id . ' #xForm>div{
                        width: 50%;
                    }
                    .pwelement_' . self::$rnd_id . ' .form-3-left {
                        margin-left: 0;
                    }
                }
                @media (max-width:569px){
                    .vc_row .full-width:has(.pwelement_' . self::$rnd_id . '){
                        padding: 0 !important;
                    }
                    .pwelement_' . self::$rnd_id . ' #xForm {
                        flex-direction: column;
                    }
                    .pwelement_' . self::$rnd_id . ' #xForm>div{
                        width: unset;
                        min-height: unset;
                    }
                    .pwelement_' . self::$rnd_id . ' :is(h2,h3,h4,h5,p){
                        margin-top: 18px;
                    }
                    .pwelement_' . self::$rnd_id . ' .form-3 form button {
                        transform: scale(1);
                    }
                }

            </style>

            <div id="xForm">
                <div class="form-3-left">
                    <div>'. 
                        self::languageChecker(
                            <<<PL
                                <h2 class="text-color-jevc-color display-befor-subbmit">Dziękujemy za rejestrację na <br><span class="very-strong">[trade_fair_name]!</span></h2>
                                <h2 class="text-color-jevc-color display-after-subbmit">Dziękujemy za zamówienie pakietu VIP<br><span class="very-strong">[trade_fair_name]!</span></h2>

                                <p class="">Cieszymy się, że dołączasz do naszego wydarzenia, pełnego nowości rynkowych i inspiracji do zastosowania w Twojej firmie.</p><br>

                                <p class="display-befor-subbmit"><span class="very-strong">Zachęcamy do wypełnienia</span> ostatniego formularza, dzięki temu będziemy mogli przygotować dla Was <span class="very-strong">wyjątkowy pakiet powitalny VIP</span>, który usprawni Państwa pobyt na targach.</p>
                                <p class="display-after-subbmit">Twój <span class="very-strong"> wyjątkowy pakiet powitalny VIP</span>  : spersonalizowany identyfikator wraz z planem/harmonogramem targów oraz kartę parkingowa, otrzymasz na podany w formularzu adres za pośrednictwem poczty polskiej na około tydzień przed targami.</p>
                            PL,
                            <<<EN
                                <h2 class="text-color-jevc-color display-befor-subbmit">Thank you for registering at <br><span class="very-strong">[trade_fair_name_eng]!</span></h2>
                                <h2 class="text-color-jevc-color display-after-subbmit">Thank you for ordering VIP welcome package <br><span class="very-strong">[trade_fair_name_eng]!</span></h2>

                                <p class="">We are delighted that you are joining our event, full of market news and inspiration for use in your business.</p><br>

                                <p class="display-befor-subbmit"><span class="very-strong">We encourage you to fill in</span> the last form, thanks to which we will be able to prepare for you a <span class="very-strong">exclusive VIP welcome package</span> that will enhance your stay at the fair.</p>
                                <p class="display-after-subbmit">Your <span class="very-strong">exclusive VIP welcome package</span>  which includes a personalized badge with the trade fair plan/schedule and a parking card, will be sent to the address provided in the form via postal service approximately one week before the trade fair.</p>
                            EN
                        )
                    .'
                    </div>
                </div>
                <div class="form-3">
                    '. 
                        self::languageChecker(
                            <<<PL
                                <h3 class="display-befor-subbmit">Podaj adres, na który mamy wysłać <span class="golden-text">darmowy pakiet powitalny VIP</span></h3>
                                <p class="display-befor-subbmit">Otrzymasz bezpłatny spersonalizowany identyfikator wraz z planem/harmonogramem targów oraz kartę parkingową.</p>
                            PL,
                            <<<EN
                                <h3 class="display-befor-subbmit">Enter the address where we should send the <span class="golden-text">free VIP welcome pack</span></h3>
                                <p class="display-befor-subbmit">You will receive a complimentary personalised badge along with the exhibition schedule/schedule and a parking pass.</p>
                            EN
                        )
                    .'
                    <div class="pwe-gravity-form">
                        [gravityform id="'. $atts['reg_form_name_pr'] .'" title="false" description="false" ajax="false"]               
                    </div>
                    <div class="pwe-submitting-buttons display-befor-subbmit">
                        <button class="btn pwe-btn pwe_reg_visitor">'. $confirmation_page_text_btn .'</button>
                    </div>
                    <div class="pwe-submitting-buttons display-after-subbmit">
                        <a href="'. 
                        self::languageChecker(
                            <<<PL
                               /
                            PL,
                            <<<EN
                                /en/
                            EN
                        )
                    .'"><button class="btn pwe-btn pwe_reg_visitor">'. $main_page_text_btn .'</button></a>
                    </div>
                </div>
                <div class="form-3-right">
                    <img src="/doc/badge-mockup.webp">
                </div>
            </div>
            <script>
            jQuery(document).ready(function($){
                $(".pwelement_' . self::$rnd_id . ' .pwe_reg_visitor").on("click", function(event){
                    var userEmail = localStorage.getItem("user_email");
                    var userTel = localStorage.getItem("user_tel");
                    var userDirection = localStorage.getItem("user_direction");

                    if (userEmail) {
                        $(".pwelement_'. self::$rnd_id .' .ginput_container_email").find("input").val(userEmail);
                    }
                    if (userTel) {
                        $(".pwelement_'. self::$rnd_id .' .ginput_container_phone").find("input").val(userTel);
                    }
                    if (userDirection) {
                        $(".pwelement_'. self::$rnd_id .' input[placeholder=\"Kongres\"]").val(userDirection);
                    }
                    
                    $(".pwelement_'. self::$rnd_id .' .gfield--type-consent").find("input").click();
                    $(".pwelement_'. self::$rnd_id .' form").submit();
                });
            });
            </script>
        ';  

        return $output;
    }
}