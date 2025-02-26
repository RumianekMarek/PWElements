<?php

/**
 * Class PWElementStepTwoExhibitor
 * Extends PWElements class and defines a pwe Visual Composer element for x-steps-form.
 */
class PWElementStepTwoExhibitor extends PWElements {

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
                'param_name' => 'registration_form_step2_exhibitor',
                'save_always' => true,
                'value' => array_merge(
                    array('Wybierz' => ''),
                    self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementStepTwoExhibitor',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Update entries one form', 'pwelement'),
                'param_name' => 'registration_form_step2_exhibitor_update_entries',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementStepTwoExhibitor',
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Registration form www2', 'pwelement'),
                'param_name' => 'registration_form_step2_exhibitor_www2',
                'save_always' => true,
                'value' => array_merge(
                    array('Wybierz dodatkowy formularz' => ''),
                    self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'registration_form_step2_exhibitor_update_entries',
                    'value' => 'true',
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

        extract( shortcode_atts( array(
            'registration_form_step2_exhibitor' => '',
            'registration_form_step2_exhibitor_update_entries' => '',
            'registration_form_step2_exhibitor_www2' => '',
        ), $atts ));

        $confirmation_button_text = (get_locale() == 'pl_PL') ? "Wygeneruj ofertę" : "Generate an offer" ;
        $main_page_text_btn = (get_locale() == 'pl_PL') ? "Powrót do strony głównej" : "Back to main page" ;

        $file_url = plugins_url('elements/fetch.php', dirname(__FILE__));

        /* Update text tranform */
        $lang = get_locale();


        $directUrl = $_SESSION['pwe_exhibitor_entry']['current_url'];
        if($directUrl =="/en/step2/" || $directUrl =="/krok2/"){
            $form_to_update = $registration_form_step2_exhibitor_www2;
        } else {
            $form_to_update = $registration_form_step2_exhibitor;
        }
        $translations = [
            'pl' => [
                'name' => 'Imię i Nazwisko',
                'area' => 'Wybierz powierzchnię wystawienniczą',
                'company' => 'Firma',
                'confirm_text' => 'Dziękujemy za uzupełnienie danych. Do usłyszenia już wkrótce. Zespół Ptak Warsaw Expo',
                'error' => 'Wszystkie pola są wymagane!',
            ],
            'en' => [
                'name' => 'Name',
                'area' => 'Select exhibition area',
                'company' => 'Company',
                'confirm_text' => 'Thank you for completing the data. We look forward to hearing from you soon. Ptak Warsaw Expo Team',
                'error' => 'All fields are required!',
            ]
        ];

        $t = (strpos($lang, 'en') !== false) ? $translations['en'] : $translations['pl'];

        $output = '
            <style>
                .row-parent:has(.pwelement_'. self::$rnd_id .' #pweForm){
                    max-width: 100%;
                    padding: 0 !important;
                }
                .wpb_column:has(.pwelement_'. self::$rnd_id .' #pweForm) {
                    max-width: 100%;
                }
                .pwelement_'. self::$rnd_id .' #pweForm {
                    display: flex;
                    gap: 20px;
                }
                .pwelement_'. self::$rnd_id .' #pweForm>div{
                    align-content: center;
                    min-height: 643px;
                    width: 33%;
                    flex: 1;
                }
                .pwelement_'. self::$rnd_id .' .form {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: left;
                    padding: 36px;
                    background-color: #E8E8E8;
                    min-height: inherit;
                }
                .pwelement_'. self::$rnd_id .' .form h3{
                    color: '. self::$accent_color .';
                }
                .pwelement_'. self::$rnd_id .' .form form {
                    margin-top: 18px;
                }
                .pwelement_'. self::$rnd_id .' .form .gform_wrapper {
                    width: 100%
                }
                .pwelement_'. self::$rnd_id .' .form .gform_fields {
                    display: flex;
                    flex-direction: column;
                    gap: 18px;
                }
                .pwelement_'. self::$rnd_id .' .form form label{
                    text-align: left;
                    font-weight: 700;
                }
                .pwelement_'. self::$rnd_id .' .gform_wrapper :is(label, .gfield_description) {
                    color: black;
                }
                .pwelement_'. self::$rnd_id .' .form form :is(input:not([type="checkbox"]), textarea) {
                    margin-bottom: 18px;
                    width: 100%;
                    border-radius: 10px;
                    box-shadow: none !important;
                }
                .pwelement_'. self::$rnd_id .' form :is(input, textarea){
                    border: 1px solid;
                    border-color: black !important;
                }
                .pwelement_'. self::$rnd_id .' form .gfield_required_asterisk{
                    display: none !important;
                }
                .pwelement_'. self::$rnd_id .' .gform_required_legend {
                    display: none !important;
                }
                .pwelement_'. self::$rnd_id .' .gform_footer {
                    display: block !important;
                    text-align: center;
                    visibility: hidden !important;
                    width: 0;
                    height: 0;
                    padding: 0;
                    margin: 0;
                }
                .pwelement_'. self::$rnd_id .' input[type=submit] {
                    background-color: '. $btn_color .' !important;
                    border: 2px solid '. $btn_color .' !important;
                    color: '. $btn_text_color .';
                    border-radius: 10px !important;
                    font-size: 1em;
                    margin: 18px auto 0;
                    align-self: center;
                    box-shadow: none !important;
                    font-size: 12px;
                    white-space: pre-wrap;
                }
                .pwelement_'. self::$rnd_id .' input[type=submit]:hover {
                    background-color: white !important;
                    color: '. $btn_color .' !important;
                    border: 2px solid '. $btn_color .' !important;
                }
                .pwelement_'. self::$rnd_id .' .form-left {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    text-align: -webkit-right;
                    padding: 36px;
                }
                .pwelement_'. self::$rnd_id .' .form-left > div {
                    text-align:left;
                    max-width: 450px;
                }
                .pwelement_'. self::$rnd_id .' .form-left span{
                    color: ' . $btn_color . ';
                }
                .pwelement_'. self::$rnd_id .' .form-right{
                    padding: 36px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                    gap: 27px;
                    text-align: center;
                }
                .pwelement_'. self::$rnd_id .' .form-right .pwe-link{
                    color: white;
                    background-color: black;
                    border: 1px solid black;
                }
                .pwelement_'. self::$rnd_id .' .form-right .pwe-link:hover{
                    color: black;
                    background-color: white;
                }
                .pwelement_'. self::$rnd_id .' #pweForm:has(.gform_confirmation_wrapper) .display-before-submit {
                    display: none;
                }
                .pwelement_'. self::$rnd_id .' .display-after-submit{
                    display: none;
                }
                .pwelement_'. self::$rnd_id .' #pweForm:has(.gform_confirmation_wrapper) .display-after-submit{
                    display: block !important;
                }
                .pwelement_'. self::$rnd_id .' #pweForm .gform_confirmation_message {
                    font-size: 20px;
                    font-weight: 600;
                    text-align: center;
                }

                .pwelement_'. self::$rnd_id .' .pwe_reg_exhibitor {
                    margin-top: 18px;
                    color: white;
                    background-color: '. $btn_color .' !important;
                    border: 2px solid '. $btn_color .' !important;
                    border-radius: 10px !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe_reg_exhibitor:hover{
                    color: black;
                    background-color: white !important;
                    border: 2px solid '. $btn_color .' !important;
                }
                .pwelement_47852 .gfield_checkbox {
                    display: grid !important;
                    grid-template-columns: 1fr 1fr;
                    gap: 5px;
                }
                .pwelement_'. self::$rnd_id .' .gfield_checkbox .gchoice {
                    min-width:120px;
                }
                .pwelement_'. self::$rnd_id .' .gfield_checkbox input[type="checkbox"]  {
                    width: 16px !important;
                    height: 16px !important;
                    border-radius: 50% !important;
                }
                .pwelement_'. self::$rnd_id .' .gfield_checkbox label {
                    font-weight: 500 !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-submitting-buttons .pwe-btn {
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

                /* Range container */

                .pwelement_'. self::$rnd_id .' .range_container {
                    margin-top:9px;
                    background: white;
                    border: 1px solid black;
                    border-radius: 10px;
                    padding: 10px 15px !important;
                }
                .pwelement_'. self::$rnd_id .' .range_container input {
                    margin: 0px !important;
                }
                .pwelement_'.self::$rnd_id.' .error-border {
                    border: 2px solid red !important;
                }
                .pwelement_'.self::$rnd_id.' .status-message.error {
                    border: 3px solid red;
                    padding: 9px 10px;
                    border-radius: 10px;
                    text-align: center;
                    background: white;
                    font-weight: 600;
                }

                @media (min-width:650px) and (max-width:1080px){
                    .pwelement_'. self::$rnd_id .' .form-right {
                        display:none;
                    }
                }
                @media (max-width:650px){
                    .pwelement_'. self::$rnd_id .' #pweForm {
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' #pweForm>div{
                        width: unset;
                        min-height: unset;
                    }
                    .pwelement_'. self::$rnd_id .' :is(h2,h3,h4,h5,p){
                        margin-top: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' #pweForm .form-right .pwe-btn{
                        transform-origin: center;
                    }
                }
            </style>


            <div id="pweForm">
                <div class="form-left">
                    <div>'.
                        self::languageChecker(
                            <<<PL
                                <h2 class="text-color-jevc-color">Dziękujemy za rejestrację chęci udziału Państwa firmy na targach <span>[trade_fair_name]!</span></h2>
                                <p>Wkrótce nasz przedstawiciel skontaktuje się z Państwem, aby przedstawić ofertę wystawienniczą oraz korzyści płynące z udziału w targach.</p>
                            PL,
                            <<<EN
                                <h2 class="text-color-jevc-color">Thank you for registering your company's desire to participate in the trade fair <span>[trade_fair_name]!</span></h2>
                                <p>Our representative will be in touch with you shortly to present our exhibition offer and the benefits of participating in the fair.</p>
                            EN
                        )
                    .'
                    </div>
                </div>';

                $output .= '
                <div class="form">
                    <div class="display-before-submit">'.
                        self::languageChecker(
                            <<<PL
                                <h3>Prosimy o podanie dodatkowych szczegółów</span></h3>
                                <p>Pomoże nam to w dobraniu odpowiednich warunków i usprawnieniu komunikacji.</p>
                            PL,
                            <<<EN
                                <h3>Please provide additional details</span></h3>
                                <p>This will help us to choose the right conditions and improve communication.</p>
                            EN
                        )
                    .'</div>';

                    if(!$registration_form_step2_exhibitor_update_entries){
                        $output .= '[gravityform id="'. $registration_form_step2_exhibitor .'" title="false" description="false" ajax="false"]';
                    } else {
                        $output .= '
                        <div class="gf_browser_chrome gform_wrapper gravity-theme gform-theme--no-framework">
                            <form id="addressUpdateForm">
                                <div class="gform-body gform_body">
                                    <div class="gform_fields">
                                        <div class="gfield gfield--width-full">
                                            <label style="padding:0;" class="gfield_label gform-field-label">' . $t['name'] . '</label>
                                            <input type="text" id="name" placeholder="' . $t['name'] . '" required/>
                                        </div>
                                        <div class="gfield gfield--width-full">
                                            <label style="padding:0;" class="gfield_label gform-field-label">' . $t['area'] . ' <strong>(<span id="areaValue">125</span>m<sup>2</sup>)</strong></label>
                                            <div class="range_container">
                                                <input type="range" id="areaSlider" min="10" max="250" value="125" step="1">
                                            </div>
                                            <input type="text" id="area" name="area" hidden required/>
                                        </div>
                                        <div class="gfield gfield--width-full">
                                            <label style="padding:0;" class="gfield_label gform-field-label">' . $t['company'] . '</label>
                                            <input type="text" id="company" placeholder="' . $t['company'] . '" required/>
                                        </div>
                                        <div id="statusMessage" class="status-message"></div>
                                    </div>
                                </div>
                            </form>
                        </div>';
                    }

                    $output .= '
                    <input type="submit" id="pweConfirmation" class="display-before-submit" value="'. $confirmation_button_text .'" onclick="updateGravityForm()">
                    <div class="pwe-submitting-buttons display-after-submit">
                        <a href="'.
                        self::languageChecker(
                            <<<PL
                               /
                            PL,
                            <<<EN
                                /en/
                            EN
                        )
                    .'"><button class="btn pwe-btn pwe_reg_exhibitor">'. $main_page_text_btn .'</button></a>
                    </div>';
                $output .= '
                </div>';

                $output .= '
                <div class="form-right">
                    <img class="img-stand" src="/wp-content/plugins/PWElements/media/zabudowa.webp" alt="zdjęcie przykładowej zabudowy"/>
                    <h5>'.
                        self::languageChecker(
                            <<<PL
                                Dedykowana Zabudowa Targowa
                            PL,
                            <<<EN
                                Dedicated Market Place
                            EN
                        )
                    .'</h5>
                        <a class="pwe-link btn pwe-btn btn-stand" target="_blank" '.
                            self::languageChecker(
                                <<<PL
                                    href="https://warsawexpo.eu/zabudowa-targowa">Sprawdź ofertę zabudowy
                                PL,
                                <<<EN
                                    href="https://warsawexpo.eu/en/exhibition-stands">See the offer
                                EN
                            )
                        .'</a>
                </div>
            </div>
        ';

        if(!$registration_form_step2_exhibitor_update_entries){
            $output .= '
            <script>
                jQuery(document).ready(function($){
                    let userArea = localStorage.getItem("user_area");
                    if (userArea && userArea.trim() !== "") {
                        $(".con-area").hide();
                    }

                    $(".pwelement_'. self::$rnd_id .' #pweConfirmation").on("click", function() {
                        let userEmail = localStorage.getItem("user_email");
                        let userTel = localStorage.getItem("user_tel");
                        let userDirection = localStorage.getItem("user_direction");

                        if (userEmail) {
                            $(".pwelement_'. self::$rnd_id .' .ginput_container_email").find("input").val(localStorage.getItem("user_email"));
                        }
                        if (userTel) {
                            $(".pwelement_'. self::$rnd_id .' .ginput_container_phone").find("input").val(localStorage.getItem("user_tel"));
                        }
                        if (userArea) {
                            $(".pwelement_'. self::$rnd_id .' .input-area").find("input").val(userArea);
                        }

                        $(".pwelement_'. self::$rnd_id .' .gfield--type-consent").find("input").click();
                        $(".pwelement_'. self::$rnd_id .' form").submit();
                    });
                });
            </script>';
        } else {
            $output .= '
            <script>

                document.addEventListener("DOMContentLoaded", function() {
                    let slider = document.getElementById("areaSlider");
                    let areaValue = document.getElementById("areaValue");
                    let hiddenInput = document.getElementById("area");

                    function updateLabel() {
                        let value = slider.value;
                        areaValue.textContent = value;
                        hiddenInput.value = value;
                    }

                    slider.addEventListener("input", updateLabel);
                    updateLabel();
                });
                function updateGravityForm() {
                    const fields = ["name", "area", "company"];
                    let hasError = false;
                    let firstErrorField = null;

                    fields.forEach(id => {
                        const field = document.getElementById(id);
                        if (!field.value.trim()) {
                            field.classList.add("error-border");
                            if (!firstErrorField) {
                                firstErrorField = field;
                            }
                            hasError = true;
                        } else {
                            field.classList.remove("error-border");
                        }
                    });

                    if (hasError) {
                        document.getElementById("statusMessage").innerText = "'.$t['error'].'";
                        document.getElementById("statusMessage").classList.add("error");
                        firstErrorField.focus();
                        return;
                    }

                    const name = document.getElementById("name").value.trim();
                    const area = document.getElementById("area").value.trim();
                    const company = document.getElementById("company").value.trim();
                    const statusMessage = document.getElementById("statusMessage");
                    const formName = "'.$form_to_update.'";
                    const direction = "exhibitor";

                    if (!name || !area || !company) {
                        statusMessage.innerText = "' . $t['error'] . '";
                        statusMessage.classList.add("error");
                        return;
                    }

                    const formData = { name, area, company, formName, direction };

                    fetch("'.$file_url.'", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Authorization": "qg58yn58q3yn5v"
                        },
                        body: JSON.stringify(formData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.message === "Dane zaktualizowane" || data.message === "Data has been updated!") {
                            document.getElementById("addressUpdateForm").classList.add("hidden"); // Ukrycie formularza

                            const confirmationWrapper = document.createElement("div");
                            confirmationWrapper.classList.add("gform_confirmation_wrapper");
                            statusMessage.appendChild(confirmationWrapper);

                            const messageContainer = document.querySelector("#pweForm .form");

                            const message = document.createElement("div");
                            message.classList.add("gform_confirmation_message");
                            message.innerText = "' . $t['confirm_text'] . '";


                            messageContainer.insertBefore(message, messageContainer.firstChild);
                        } else {
                            statusMessage.innerText = "Wystąpił błąd: " + data.message;
                            statusMessage.classList.add("error");
                        }
                    })
                    .catch(error => {
                        console.error("Błąd:", error);
                        statusMessage.innerText = "Wystąpił problem z aktualizacją.";
                        statusMessage.classList.add("error");
                    });
                }
            </script>';
        }

        return $output;
    }
}