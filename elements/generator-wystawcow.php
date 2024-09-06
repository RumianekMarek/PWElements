<?php

/**
 * Class PWElementGenerator
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementGenerator extends PWElements {

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
                'heading' => __('Worker form (left)', 'pwelement'),
                'param_name' => 'worker_form_id',
                'save_always' => true,
                'value' => array_merge(
                  array('Wybierz' => ''),
                  self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementGenerator',
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Guest form (right)', 'pwelement'),
                'param_name' => 'guest_form_id',
                'save_always' => true,
                'value' => array_merge(
                  array('Wybierz' => ''),
                  self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementGenerator',
                ),
            ),
            // array(
            //     'type' => 'checkbox',
            //     'group' => 'PWE Element',
            //     'heading' => __('Ticketed fairs', 'pwelement'),
            //     'param_name' => 'generator_tickets',
            //     'param_holder_class' => 'backend-basic-checkbox backend-area-one-fourth-width',
            //     'description' => __('Footer text for ticketed fairs'),
            //     'save_always' => true,
            //     'admin_label' => true,
            //     'dependency' => array(
            //         'element' => 'pwe_element',
            //         'value' => 'PWElementGenerator',
            //     ),
            // ),
            array(
                'type' => 'textarea_raw_html',
                'group' => 'PWE Element',
                'heading' => __('Footer HTML Text', 'pwelement'),
                'param_name' => 'generator_html_text',
                'param_holder_class' => 'backend-textarea-raw-html',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementGenerator',
                ),
            ),
        );
        return $element_output;
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
            'worker_form_id' => '',
            'guest_form_id' => '',
            // 'generator_tickets' => '',
            'generator_html_text' => ''
        ), $atts ));

        $send_file = plugins_url('other/mass_vip.php', dirname(__FILE__));
        
        $worker_entries = GFAPI::get_entries($worker_form_id);
        $guest_entries = GFAPI::get_entries($guest_form_id);
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $registration_count = 0;
        foreach ($worker_entries as $entry) {
            $entry_ip = rgar($entry, 'ip');
            if ($entry_ip === $ip_address) {
                $registration_count++;
            }
        }
        foreach ($guest_entries as $entry) {
            $entry_ip = rgar($entry, 'ip');
            if ($entry_ip === $ip_address) {
                $registration_count++;
            }
        }

        $generator_html_text_decoded = base64_decode($generator_html_text);
        $generator_html_text_decoded = urldecode($generator_html_text_decoded);
        $generator_html_text_content = wpb_js_remove_wpautop($generator_html_text_decoded, true);

       

        // if ($generator_tickets == true) {
        //     if (get_locale() == 'pl_PL') {
        //         $generator_html_text_content = (empty($generator_html_text_content)) ? 'Darmowa rejestracja upoważnia do wejścia w dniu <strong class="gen-date">[trade_fair_branzowy]</strong>.' : $generator_html_text_content;
        //     } else {
        //         $generator_html_text_content = (empty($generator_html_text_content)) ? 'Free registration etitle you to enter only on <strong class="gen-date">[trade_fair_branzowy_eng]</strong>.' : $generator_html_text_content;
        //     }
        // } else {
        //     if (get_locale() == 'pl_PL') {
        //         $generator_html_text_content = (empty($generator_html_text_content)) ? 'Ze względów organizacyjnych ilość zaproszeń jest ograniczona. Rejestracja dostępna tylko do 30 dni przed targami.' : $generator_html_text_content;
        //     } else {
        //         $generator_html_text_content = (empty($generator_html_text_content)) ? 'For organizational reasons, the number of invitations is limited. Registration is only available up to 30 days before the fair.' : $generator_html_text_content;
        //     }
        // }


        $output = '
        <style>
            #page-header{
                display: none !important;
            }
            .pwe-generator-wystawcow .gform_validation_errors {
                display: none;
            }
            .pwe-generator-wystawcow .gform_legacy_markup_wrapper li.gfield.gfield_error {
                border-top: none;
                border-bottom: none;
                padding-bottom: 0;
                padding-top: 0;
                margin-top: 12px !important;
            }
            .pwe-generator-wystawcow .heading-text {
                text-align: center;
                padding: 18px 0;
            }
            .pwe-generator-wystawcow .heading-text h3 {
                margin: 0 auto;
                color: #000000 !important;
            }
            .pwe-generator-wystawcow .heading-text a {
                text-decoration: underline;
                color: black !important;
            }
            .pwe-generator-wystawcow {
                padding: 18px 0 36px;
            }
            .pwe-generator-wystawcow h2 {
                font-size: 28px !important;
                width: auto !important;
                padding: 0 10px;
            }
            .pwe-generator-wystawcow .gform_legacy_markup_wrapper .gform_footer {
                padding: 0 !important;
            }
            .pwe-generator-wystawcow .gform_legacy_markup_wrapper .gform_footer input[type=submit] {
                width: auto !important;
            }
            .pwe-generator-wystawcow .gform_footer {
                display: flex;
                justify-content: center;
            }
            .pwe-generator-wystawcow input[type="text"], input[type="submit"], input[type="email"] {
                box-shadow: none !important;
            }
            .pwe-generator-wystawcow input[type="submit"] {
                border-radius: 5px;
                margin: 0 auto 15px;
                width: 150px;
            }
            .pwe-generator-wystawcow input[type="file"] {
                width: 83px !important;
                padding: 2px 0px 2px 2px !important;
            }
            .pwe-generator-wystawcow .gform-body input[type="text"],
            .pwe-generator-wystawcow .gform-body input[type="email"] {
                padding-left: 45px !important;
                background-color: #D2D2D2 !important;
                border-radius: 5px !important;
                border: none !important;
                font-weight: 700;
                color: #555555;
            }
            .pwe-generator-wystawcow .ginput_container {
                position: relative;
            }
            .pwe-generator-wystawcow .gfield img {
                position: absolute;
                left: 7px;
                top: 9px;
                height: 24px;
            }
            .pwe-generator-wystawcow .gfield_validation_message,
            .pwe-generator-wystawcow .gform_submission_error {
                font-size: 10px !important;
                padding: 2px 2px 2px 6px !important;
                margin-top: 2px !important;
            }
            .pwe-generator-wystawcow .gform_submission_error {
                margin: 0 auto;
            }
            .pwe-generator-wystawcow .gform_validation_errors {
                padding: 0 !important;
            }
            .pwe-generator-wystawcow .container-forms h2,
            .pwe-generator-wystawcow .container-forms button {
                font-weight: 800;
            }
            .pwe-generator-wystawcow .gform-body {
                padding: 18px 18px 0 18px;
                max-width: 550px;
                margin: 0 auto;
            }
            .pwe-generator-wystawcow .table {
                display: table;
                width: 100%;
                height: 100%;
            }
            .pwe-generator-wystawcow .table-cell {
                display: table-cell;
                vertical-align: middle;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                -webkit-transition: all 0.5s;
                transition: all 0.5s;
            }
            .pwe-generator-wystawcow .container {
                border-radius: 25px;
                position: relative;
                max-width: 1200px;
                margin: 30px auto 0;
                height: 780px;
                top: 50%;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                -webkit-transition: all 0.5s;
                transition: all 0.5s;
            }
            .pwe-generator-wystawcow .container .container-forms {
                position: relative;
            }
            .pwe-generator-wystawcow .container .btn-exh {
                cursor: pointer;
                text-align: center;
                margin: 0 auto;
                border-radius: 15px;
                width: 164px;
                font-size: 24px;
                margin: 12px 0;
                padding: 5px 0;
                opacity: 1;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                -webkit-transition: all 0.5s;
                transition: all 0.5s;
            }
            .pwe-generator-wystawcow .container .btn-exh:hover {
                opacity: 0.7;
            }
            .pwe-generator-wystawcow .container .container-forms .container-info {
                display: flex;
                justify-content: space-between;
                text-align: left;
                width: 100%;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                -webkit-transition: all 0.5s;
                transition: all 0.5s;
            }
            .pwe-generator-wystawcow .container .container-forms .container-info .info-item {
                text-align: center;
                width: 678px;
                height: 780px;
                display: inline-block;
                vertical-align: top;
                color: #fff;
                opacity: 1;
                -moz-transition: all 0.3s;
                -o-transition: all 0.3s;
                -webkit-transition: all 0.3s;
                transition: all 0.3s;
                background: #EBEBEB;
            }
            .pwe-generator-wystawcow .info-item-left {
                border-radius: 0 0 0 20px;
            }
            .pwe-generator-wystawcow .info-item-left h2 {
                color: #b79663;
            }
            .pwe-generator-wystawcow .info-item-left .gform_footer input[type="submit"] {
                background-color: #b79663 !important;
            }
            .pwe-generator-wystawcow .info-item-right {
                position: absolute;
                right: 0;
                border-radius: 0 0 20px 0;
            }
            .pwe-generator-wystawcow .info-item-right .gform_footer input[type="submit"],
            .btn-gold {
                background: #b79663 !important;
            }
            .pwe-generator-wystawcow .info-item-right h2 {
                color: #b79663;
            }
            .pwe-generator-wystawcow .container-info .info-item button,
            .pwe-generator-wystawcow .gform_footer input[type="submit"],
            .btn-gold{
                text-transform: uppercase;
                margin: 0 !important;
                color: white !important;
                font-weight: 600;
                font-size: 16px !important;
                border-radius: 16px !important;
                padding: 15px 25px;
                width: 200px;
                box-shadow: none !important;
                cursor: pointer;
                border: none;
            }
            .pwe-generator-wystawcow .container-info .none {
                width: 0px !important;
                overflow: hidden;
            }
            .pwe-generator-wystawcow .form-item img {
                opacity: 0.5;
                position: absolute;
                width: 100%;
                z-index: 0;
                left: 10px;
                top: 25%;
            }
            .pwe-generator-wystawcow .form-item h2,
            .pwe-generator-wystawcow .form-item h3,
            .pwe-generator-wystawcow .form-item button {
                z-index: 100;
                position: relative;
            }
            .pwe-generator-wystawcow .form-item h3 {
                font-weight: 400;
                font-size: 18px;
            }
            .pwe-generator-wystawcow .form-item-element-left,
            .pwe-generator-wystawcow .form-item-element-right {
                background-position: center;
                background-size: cover;
                background-repeat: no-repeat;
            }
            .pwe-generator-wystawcow .form-item-element-left {
                background-image: url(/wp-content/plugins/PWElements/media/generator-wystawcow/badgevip.jpg);
                border-radius: 20px 0 0 20px;
            }
            .pwe-generator-wystawcow .form-item-element-right {
                background-image: url(/wp-content/plugins/PWElements/media/generator-wystawcow/gen-bg.jpg);
                border-radius: 0 20px 20px 0;
            }
            .pwe-generator-wystawcow .form-item-element-right h2 {
                color: black;
            }
            .pwe-generator-wystawcow .container .container-forms .container-info .info-item .btn-exh {
                background-color: transparent;
                border: 1px solid #fff;
            }
            .pwe-generator-wystawcow .container .container-forms .container-info .info-item .table-cell {
                padding-right: 0;
            }
            .pwe-generator-wystawcow .container .container-form {
                overflow: hidden;
                position: absolute;
                left: 0px;
                top: 0px;
                width: 450px;
                height: 780px;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                -webkit-transition: all 0.5s;
                transition: all 0.5s;
            }
            .pwe-generator-wystawcow .container .form-item {
                padding: 25px;
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                opacity: 1;
                -moz-transition: all 0.5s;
                -o-transition: all 0.5s;
                -webkit-transition: all 0.5s;
                transition: all 0.5s;
                color: white !important;
                text-align: center;
            }
            .pwe-generator-wystawcow .container .form-item.sign-up {
                position: absolute;
                opacity: 0;
            }
            .pwe-generator-wystawcow .container.log-in .container-form {
                left: 678px;
            }
            .pwe-generator-wystawcow .container.log-in .container-form .form-item.sign-up {
                left: 0;
                opacity: 1;
            }
            .pwe-generator-wystawcow .container.log-in .container-form .form-item.log-in {
                left: -100%;
            }
            .pwe-generator-wystawcow .forms-container-info__btn {
                margin-top: 50px !important;
                background-color: transparent;
                color: black;
                border: 2px solid black;
            }
            .pwe-generator-wystawcow .guest-info {
                width: 70% !important;
                color: #000000 !important;
            }
            .pwe-generator-wystawcow .guest-info h5 {
                width: auto !important;
                color: black !important;
            }
            .pwe-generator-wystawcow .custom-tech-support-text {
                padding-top: 36px !important;
            }
            .pwe-generator-wystawcow input{
                background-repeat: no-repeat;
                background-size: 30px;
                background-position: 5px;
            }
            .pwe-generator-wystawcow :is(
            input[placeholder="IMIĘ I NAZWISKO (PRACOWNIKA)"],
            input[placeholder="IMIĘ I NAZWISKO (GOŚCIA)"],
            input[placeholder="NAME AND SURNAME (GUEST)"],
            input[placeholder="NAME AND SURNAME (EMPLOYEE)"],
            input[placeholder="NAME AND SURNAME"]) {
                background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/name.png");
            }
            .pwe-generator-wystawcow input[placeholder="FIRMA ZAPRASZAJĄCA"],
            .pwe-generator-wystawcow input[placeholder="FIRMA"],
            .pwe-generator-wystawcow input[placeholder="INVITING COMPANY"],
            .pwe-generator-wystawcow input[placeholder="COMPANY"] {
                background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/box.png");
            }
            .pwe-generator-wystawcow input[placeholder="E-MAIL OSOBY ZAPRASZANEJ"],
            .pwe-generator-wystawcow input[placeholder="E-MAIL OF THE INVITED PERSON"],
            .pwe-generator-wystawcow input[placeholder="E-MAIL"] {
                background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/email.png");
            }
            .pwe-generator-wystawcow input:-webkit-autofill,
            .pwe-generator-wystawcow input:-webkit-autofill:hover,
            .pwe-generator-wystawcow input:-webkit-autofill:focus {
                -webkit-text-fill-color: #555555 !important;
                -webkit-box-shadow: 0 0 0px 40rem #D2D2D2 inset !important;
                transition: background-color 5000s ease-in-out 0s;
            }
            .pwe-generator-wystawcow .gform_confirmation_message {
                color: black !important;
            }
            .pwe-generator-wystawcow .container .gen-btn-img {
                position: absolute !important;
                top: 0 !important;
                right: 0 !important;
                height: 350px;
                width: 350px;
                padding: 0;
                margin: 0 !important;
                border-radius: 0;
                background-size: contain;
                background-repeat: no-repeat;
            }
            .pwe-generator-wystawcow .gen-btn-img .btn-exh {
                position: absolute;
                top: 60px;
                right: 20px;
                height: 45px;
                width: 140px !important;
                border: 0 !important;
            }
            .pwe-generator-wystawcow .gen-mobile {
                display: none;
            }
            .pwe-generator-wystawcow .guest-info-icons {
                display: flex;
                justify-content: center;
                gap: 5px;
                padding: 0 8px
            }
            .pwe-generator-wystawcow .guest-info-icon-block {
                max-width: 110px;
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 8px;
                padding-top: 36px;
            }
            .pwe-generator-wystawcow .guest-info-icon-block img {
                height: 50px;
                object-fit: contain;
            }
            .pwe-generator-wystawcow .guest-info-icon-block p,
            .pwe-generator-wystawcow .gen-text {
                padding: 0;
                margin: 0;
                font-size: 14px;
                font-weight: 500;
                line-height: inherit;
            }
            .pwe-generator-wystawcow .gen-text {
                padding: 18px;
                font-size: 16px;
            }
            .pwe-generator-wystawcow .gen-text p {
                margin: 0 !important;
            }
            .pwe-generator-wystawcow .gen-text .gen-date {
                white-space: nowrap;
            }

            /* Modal */
            @media (max-width: 961px){
                .tabela-masowa{
                    display:none;
                }
            }
            .modal__elements {
                z-index: 9999;
                background-color: #fff;
                padding: 1rem;
                box-shadow: 9px 9px 0px -5px black;
                border: 2px solid black;
                border-radius: 0;
                max-width: 80%;
                max-height: 80%;
                overflow: auto;
                position: fixed;
                top: 100px;
                height: auto;
                min-width: 900px;
                text-align: -webkit-center;
            }

            .tabela-masowa{
                width:unset !important;
            }

            .modal__elements input{
                text-align: center;
                width:80%;
            }

            .modal__elements table{
                text-align: center;
                width:90%;
            }

            .modal__elements p{
                text-align: center;
                margin: 0;
            }
            .modal__elements table th{
                width:50%;
            }
            .modal__elements table td{
                background-repeat: no-repeat;
                background-position: center;
                text-align: center;
                padding: 0;
            }
            .modal__elements .mass-send-name:empty{
                background-image: url(/wp-content/plugins/PWElements/media/generator-wystawcow/generator-imiona.webp);
            }
            .modal__elements .mass-send-email:empty{
                background-image: url(/wp-content/plugins/PWElements/media/generator-wystawcow/geneartor-emaile.webp);
            }
            .modal__elements tr table{
                text-align: center;
                width:100%;
                margin-top: 0;
            }
            .modal__elements table input{
                margin-top: 0 !imprtant;
            }
            .modal__elements .error-color{
                color: red;
            }
            .modal__elements .btn-close{
                background-color: #b79663;
                padding: 0px 13px 5px 14px;
                border-radius: 50%;
                font-weight: 700;
                color: white;
                font-size: 30px;
                position: absolute;
                right: 10px;
                cursor: pointer;
            }
            .modal__elements label{
                font-weight: 600;
                font-size: 18px;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .modal__elements .zastepczy{
                color: #ccc;
                font-style: italic; 
            }
            td:empty{
                line-height: 6;
            }
            .wyslij.btn-gold{
                margin:18px !important;
            }
            @media (max-width:1200px) {
                .pwe-generator-wystawcow .container {
                    max-width: 900px !important;
                }
                .pwe-generator-wystawcow .container .container-forms .container-info .info-item {
                    width: 600px;
                }
                .pwe-generator-wystawcow .container .container-form {
                    width: 300px;
                }
                .pwe-generator-wystawcow .container.log-in .container-form {
                    left: 600px;
                }
                .pwe-generator-wystawcow .container .container-forms .container-info .info-item .table-cell {
                    padding-right: 0px !important;
                }
                .pwe-generator-wystawcow .container .gen-btn-img {
                    height: 300px;
                    width: 300px;
                }
                .pwe-generator-wystawcow .forms-container-form__right h2 {
                    font-size: 26px;
                }
                .pwe-generator-wystawcow .forms-container-form__right h5 {
                    font-size: 14px;
                }
            }
            @media (max-width:960px) {
                .pwe-generator-wystawcow .container {
                    max-width: none !important;
                    margin: 15px auto 0;
                    height: 950px;
                }
                .pwe-generator-wystawcow .container .container-form {
                    width: 100%;
                    height: 250px;
                }
                .pwe-generator-wystawcow .container .container-forms .container-info .info-item {
                    position: absolute;
                    top: 250px;
                    width: 100%;
                    height: 740px;
                    border-radius: 0 0 18px 18px !important;
                }
                .pwe-generator-wystawcow .container .container-form {
                    width: 100%;
                    border-radius: 18px 18px 0 0 !important;
                }
                .pwe-generator-wystawcow .container.log-in .container-form {
                    left: 0px;
                }
                .row-container:has(.pwe-generator-wystawcow) .row-parent {
                    padding: 18px !important;
                }
                .pwe-generator-wystawcow .info-item-left,
                .pwe-generator-wystawcow .container,
                .pwe-generator-wystawcow .info-item-right,
                .pwe-generator-wystawcow .form-item-element-left,
                .pwe-generator-wystawcow .form-item-element-right {
                    border-radius: 0px !important;
                }
                .pwe-generator-wystawcow .forms-container-info__btn {
                    margin-top:10px !important;
                }
                .pwe-generator-wystawcow .container .container-forms .container-info .info-item:nth-child(2) .table-cell {
                    padding-left: 0px !important;
                    padding-right: 0;
                }
                .pwe-generator-wystawcow .gform-body {
                    padding: 4px 16px 0 16px;
                }
                .pwe-generator-wystawcow .gform_footer input[type=submit] {
                    font-size: 16px !important;
                }
                .pwe-generator-wystawcow .custom-tech-support-text {
                    margin: 36px 0 !important;
                }
                .pwe-generator-wystawcow .form-item-element-left {
                    background-image: url(/wp-content/plugins/PWElements/media/generator-wystawcow/gen-bg.jpg);
                }
                .pwe-generator-wystawcow .guest-info {
                    width: 100% !important;
                }
                .pwe-generator-wystawcow .gen-mobile {
                    display: block;
                }
                .pwe-generator-wystawcow .container .gen-btn-img {
                    display: none;
                    height: 280px;
                    width: 280px;
                }
                .pwe-generator-wystawcow .gen-btn-img .btn-exh {
                    top: 75px;
                    right: 12px;
                    height: 40px;
                    width: 120px !important;
                }
            }
            @media (max-width:640px) {
                .pwe-generator-wystawcow h2 {
                    font-size: 22px !important;
                }
                .pwe-generator-wystawcow .gform_fields {
                    padding: 0 !important;
                }
                .pwe-generator-wystawcow .guest-info-icon-block {
                    padding-top: 18px;
                }
                .pwe-generator-wystawcow .guest-info-icon-block p,
                .pwe-generator-wystawcow .gen-text {
                    font-size: 12px;
                }
            }
            @media (max-width:400px) {
                .pwe-generator-wystawcow .ginput_container .gform-body input[type="text"],
                .pwe-generator-wystawcow .ginput_container .gform-body input[type="email"] {
                    font-size: 12px !important;
                }
                .pwe-generator-wystawcow .heading-text h3 {
                    font-size: 18px;
                }
                .pwe-generator-wystawcow .guest-info-icon-block {
                    max-width: 90px;
                }
            }
        </style>

            <div id="pweGeneratorWystawcow" class="pwe-generator-wystawcow">

                <div class="container">
                    <div class="container-forms">
                        <div class="container-info">
                            <div class="info-item info-item-left none">
                                <div class="table">
                                    <div class="table-cell">
                                        <div class="forms-container-form__left active">
                                            <h2>'.
                                                self::languageChecker(
                                                    <<<PL
                                                        WYGENERUJ<br>IDENTYFIKATOR DLA<br>SIEBIE I OBSŁUGI STOISKA
                                                    PL,
                                                    <<<EN
                                                        GENERATE<br>AN ID FOR YOURSELF<br>AND YOUR COWORKERS
                                                    EN
                                                )
                                            .'</h2>
                                            [gravityform id="'. $worker_form_id .'" title="false" description="false" ajax="false"]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="info-item info-item-right">
                            <div class="table">
                                <div class="table-cell">
                                        <div class="guest-info">
                                            <div class="forms-container-form__right">
                                                <h2>'.
                                                    self::languageChecker(
                                                        <<<PL
                                                            WYGENERUJ</br>IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!
                                                        PL,
                                                        <<<EN
                                                            GENERATE</br>A VIP INVITATION</br>FOR YOUR GUESTS!
                                                        EN
                                                    )
                                                .'</h2>
                                                <h5>'.
                                                    self::languageChecker(
                                                        <<<PL
                                                            Identyfikator VIP uprawnia do:
                                                        PL,
                                                        <<<EN
                                                            The VIP invitation entitles you to:
                                                        EN
                                                    )
                                                .'</h5>
                                                <div class="guest-info-icons">

                                                    <div class="guest-info-icon-block">
                                                        <img src="/wp-content/plugins/PWElements/media/generator-wystawcow/ico1.png" alt="icon1">
                                                        <p>'.
                                                        self::languageChecker(
                                                            <<<PL
                                                                Bezpłatnego skorzystania ze strefy VIP ROOM
                                                            PL,
                                                            <<<EN
                                                                Free use of the VIP ROOM zone
                                                            EN
                                                        )
                                                        .'</p>
                                                    </div>

                                                    <div class="guest-info-icon-block">
                                                        <img src="/wp-content/plugins/PWElements/media/generator-wystawcow/ico3.png" alt="icon3">
                                                        <p>'.
                                                        self::languageChecker(
                                                            <<<PL
                                                                Fast track
                                                            PL,
                                                            <<<EN
                                                                Fast track
                                                            EN
                                                        )
                                                        .'</p>
                                                    </div>

                                                    <div class="guest-info-icon-block">
                                                        <img src="/wp-content/plugins/PWElements/media/generator-wystawcow/ico4.png" alt="icon4">
                                                        <p>'.
                                                        self::languageChecker(
                                                            <<<PL
                                                                Opieki concierge`a
                                                            PL,
                                                            <<<EN
                                                                Concierge care
                                                            EN
                                                        )
                                                        .'</p>
                                                    </div>

                                                    <div class="guest-info-icon-block">
                                                        <img src="/wp-content/plugins/PWElements/media/generator-wystawcow/ico2.png" alt="icon2">
                                                        <p>'.
                                                        self::languageChecker(
                                                            <<<PL
                                                                Uczestnictwa<br>we wszystkich konferencjach branżowych
                                                            PL,
                                                            <<<EN
                                                                Participation<br>in all industry conferences
                                                            EN
                                                        )
                                                        .'</p>
                                                    </div>

                                                </div>

                                                [gravityform id="'. $guest_form_id .'" title="false" description="false" ajax="false"]
                                                <button class="btn tabela-masowa btn-gold">'.
                                            self::languageChecker(
                                                <<<PL
                                                Wysyłka zbiorcza
                                                PL,
                                                <<<EN
                                                Collective send
                                                EN
                                            )
                                        .'</button>           
                                                <!-- <div class="gen-text">'. $generator_html_text_content .'</div> -->
                                            </div>
                                            <div class="gen-btn-img" style="background-image: url('.
                                                self::languageChecker(
                                                    <<<PL
                                                        /wp-content/plugins/PWElements/media/generator-wystawcow/gen-pl.png
                                                    PL,
                                                    <<<EN
                                                        /wp-content/plugins/PWElements/media/generator-wystawcow/gen-en.png
                                                    EN
                                                )
                                            .');">
                                                <div class="forms-container-info__btn btn-exh"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="container-form">
                            <div class="form-item form-item-element-left log-in">
                                <div class="table">
                                    <div class="table-cell">
                                        <div class="gen-mobile">
                                            <h2>'.
                                            self::languageChecker(
                                                <<<PL
                                                    WYGENERUJ<br>IDENTYFIKATOR DLA<br>SIEBIE I OBSŁUGI STOISKA
                                                PL,
                                                <<<EN
                                                    GENERATE<br>AN ID FOR YOURSELF<br>AND YOUR COWORKERS
                                                EN
                                            )
                                            .'</h2>
                                            <button class="forms-container-info__btn btn-exh">'.
                                                self::languageChecker(
                                                    <<<PL
                                                        KLIKNIJ
                                                    PL,
                                                    <<<EN
                                                        CHANGE
                                                    EN
                                                )
                                            .'</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item form-item-element-right sign-up">
                                <div class="table">
                                    <div class="table-cell">
                                        <h2>'.
                                            self::languageChecker(
                                                <<<PL
                                                    WYGENERUJ<br>IDENTYFIKATOR VIP<br>DLA SWOICH GOŚCI!
                                                PL,
                                                <<<EN
                                                    GENERATE<br>A VIP INVITATION<br>FOR YOUR GUESTS!
                                                EN
                                            )
                                        .'</h2>
                                        <button class="forms-container-info__btn btn-exh">'.
                                            self::languageChecker(
                                                <<<PL
                                                KLIKNIJ
                                                PL,
                                                <<<EN
                                                CHANGE
                                                EN
                                            )
                                        .'</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="heading-text custom-tech-support-text">
                    <h3>'.
                        self::languageChecker(
                            <<<PL
                                Potrzebujesz pomocy?<br>
                                Skontaktuj się z nami - <a href="mailto:info@warsawexpo.eu">info@warsawexpo.eu</a>
                            PL,
                            <<<EN
                                Need help?<br>
                                Contact us - <a href="mailto:info@warsawexpo.eu">info@warsawexpo.eu</a>
                            EN
                        )
                    .'</h3>
                    
                </div>
            </div>

            <script type="text/javascript">
                jQuery(document).ready(function($){

                    $(".tabela-masowa").on("click",function(){
                        const tableCont = [];

                        $("footer").hide();

                        let modalBox = "";
                        const $modal = $("<div></div>")
                            .addClass("modal")
                            .attr("id", "my-modal");

                        modalBox = `<div class="modal__elements">
                                        <span class="btn-close">x</span>
                                        <p style="max-width:90%;">'.
                                            self::languageChecker(
                                                <<<PL
                                                Uzupełnij poniżej nazwę firmy zapraszającej oraz dane osób, które powinny otrzymać zaproszenia VIP GOLD. Dane wklej pod nagłówkami poniższej tabeli. Przed wysyłką zweryfikuj zgodność danych.
                                                PL,
                                                <<<EN
                                                Fill in below the name of the inviting company and the details of the people who should receive VIP GOLD invitations. Verify the accuracy of the data before sending.
                                                EN
                                            )
                                        .'</p>
                                        <input class="company" placeholder="'.
                                            self::languageChecker(
                                                <<<PL
                                                Firma Zapraszająca (wpisz nazwę swojej firmy)
                                                PL,
                                                <<<EN
                                                Inviting Company (your company's name)
                                                EN
                                            )
                                        .'"></input>
                                        <table id="mass-table">
                                            <tr>
                                                <th>'.
                                            self::languageChecker(
                                                <<<PL
                                                IMIĘ I NAZWISKO (GOŚCIA)
                                                PL,
                                                <<<EN
                                                Name of the invited person
                                                EN
                                            )
                                        .'</th>
                                                <th>'.
                                            self::languageChecker(
                                                <<<PL
                                                E-MAIL OSOBY ZAPRASZANEJ
                                                PL,
                                                <<<EN
                                                E-mail of the invited person
                                                EN
                                            )
                                        .'</th>
                                            </tr>
                                            <tr>
                                                <td class="mass-send-name" contenteditable="true"></td>
                                                <td class="mass-send-email" contenteditable="true"></td>
                                            </tr>
                                        </table>
                                        <button class="wyslij btn-gold">'.
                                            self::languageChecker(
                                                <<<PL
                                                Wyślij
                                                PL,
                                                <<<EN
                                                Send
                                                EN
                                            )
                                        .'</button>
                                    </div>`;

                        $modal.html(modalBox);

                        $(".page-wrapper").prepend($modal);

                        $modal.css("display", "flex");
                        const $closeBtn = $modal.find(".btn-close");

                        $closeBtn.on("click", function () {
                            $modal.hide();
                            $("footer").show();
                        });

                        $modal.on("click", function (event) {
                            if ($(event.target)[0] === $modal[0]) {
                                $modal.hide();
                                $("footer").show();
                            }
                        });
                        
                        $("#mass-table, .company").on("click", function(){
                            if($(this).next().hasClass("company-error")){
                                $(this).next().remove();
                            }
                        });

                        $(".wyslij").on("click",function(){
                            pageLang = "' .get_locale(). '" == "pl_PL" ? "pl" : "en";

                            content_name = $("#mass-table").find(".mass-send-name").text().split("\n");
                            content_email = $("#mass-table").find(".mass-send-email").text().split("\n");
                            
                            const cNames = content_name.filter(target => (target !== "" && target !== "\t")).map(target => target.replace(/\t\t/g, "")); 
                            const cEmail = content_email.filter(target => (target !== "" && target !== "\t")).map(target => target.replace(/\t\t/g, "")); 

                            for (let i = 0; i < cEmail.length; i++) {
                                if(cEmail[i] != ""){
                                    pair = {"name": cNames[i], "email": cEmail[i]};
                                    tableCont.push(pair);
                                }
                            }
                                
                            if ($("#mass-table").find("td").filter(function(){ return $(this).html() != "" }).length < 2 && !$("#mass-table").next().hasClass("company-error")){
                                $("#mass-table").after(`<p class="company-error error-color" >'.
                                            self::languageChecker(
                                                <<<PL
                                                Wprowadź dane
                                                PL,
                                                <<<EN
                                                Insert data
                                                EN
                                            )
                                        .'</p>`);
                            }

                            if ($(".company").val() == ""){
                                if (!$(".company").next().hasClass("company-error")){
                                    $(".company").after(`<p class="company-error error-color" >'.
                                            self::languageChecker(
                                                <<<PL
                                                Nazwa firmy jest wymagana
                                                PL,
                                                <<<EN
                                                Company Name is required
                                                EN
                                            )
                                        .'</p>`);
                                }
                            } else if (tableCont.length > 1 ){
                                $(this).after("<div id=spinner class=spinner></div>");
                                $.post("' . $send_file . '", {
                                    token: "' . self::generateToken() .'",
                                    lang: pageLang,
                                    company: $(".company").val(),
                                    data: tableCont
                                }, function(response) {

                                    const mass_tr = $(".mass-send-email tr td");

                                    resdata = JSON.parse(response);
                                    resdata.forEach(function (value, index){
                                        if(value === true){
                                            $(mass_tr[index]).text($(mass_tr[index]).text() + "  send").css("color", "green");
                                        } else {
                                            $(mass_tr[index]).text($(mass_tr[index]).text() + "  error").css("color", "red");
                                        }
                                    });
                                    
                                    $("#spinner").remove();
                                    tableCont.splice(0, tableCont.length);
                                    $("#dataContainer").empty();
                                });
                            } else {

                            }
                        });
                    });
                });

                var btnExhElements = document.querySelectorAll(".btn-exh");
                btnExhElements.forEach(function(btnExhElement) {
                    btnExhElement.addEventListener("click", function() {
                        var containerElements = document.querySelectorAll(".container");
                        var infoItemElements = document.querySelectorAll(".info-item");

                        containerElements.forEach(function(containerElement) {
                            containerElement.classList.toggle("log-in");
                        });

                        infoItemElements.forEach(function(infoItemElement) {
                            infoItemElement.classList.toggle("none");
                        });
                    });
                })

            </script>';

            $output .= "
            <script>
                var registrationCount = '" . $registration_count . "';

                if (document.querySelector('html').lang === 'pl-PL') {
                    const companyNameInput = document.querySelector('.forms-container-form__left input[placeholder=\'FIRMA ZAPRASZAJĄCA\']');
                    const companyEmailInput = document.querySelector('.forms-container-form__left input[placeholder=\'E-MAIL OSOBY ZAPRASZANEJ\']');
                    if (companyNameInput && companyEmailInput) {
                        companyNameInput.placeholder = 'FIRMA';
                        companyEmailInput.placeholder = 'E-MAIL';
                    }
                } else {
                    const companyNameInputEn = document.querySelector('.forms-container-form__left input[placeholder=\'INVITING COMPANY\']');
                    const companyEmailInputEn = document.querySelector('.forms-container-form__left input[placeholder=\'E-MAIL OF THE INVITED PERSON\']');
                    if (companyNameInputEn && companyEmailInputEn) {
                        companyNameInputEn.placeholder = 'COMPANY';
                        companyEmailInputEn.placeholder = 'E-MAIL';
                    }
                }
            </script>";

        return $output;

    }
}