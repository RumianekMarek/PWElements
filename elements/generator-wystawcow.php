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
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => esc_html__('Worker form id', 'pwelement'),
                'param_name' => 'worker_form_id',
                'description' => __('Worker form id for generator exhibitors', 'pwelement'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementGenerator',
                ),
              ),
              array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => esc_html__('Guest form id', 'pwelement'),
                'param_name' => 'guest_form_id',
                'description' => __('Guest form id for generator exhibitors', 'pwelement'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementGenerator',
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
            'worker_form_id' => '',
            'guest_form_id' => '',
        ), $atts ));

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
        
        $new_content_check = do_shortcode('[trade_fair_date]') . " " .  do_shortcode('[trade_fair_domainadress]');
        $new_content_array = ['fruitpolandexpo.com', 'roofexpo.pl', '2024', '2025', '2026', '2027', 'nowa', 'new'];
        $new_content = false;
        foreach($new_content_array as $key){
            if(strpos($new_content_check , $key) !== false){
                $new_content = true;
                break;
            } 
        }

        $output = '
        <style>
            .pwelement_' . self::$rnd_id . ' {
                .heading-text :is(h3, a){
                    color: '. $text_color .';
                }
                .heading-text a{
                    text-decoration: underline;
                    color: black !important;
                }
                .pwe-generator-wystawcow {
                    padding: 18px 0 36px;
                }
                .pwe-generator-wystawcow h2 {
                    font-size: 28px !important;
                    width: auto !important;
                }
                .gform_legacy_markup_wrapper .gform_footer input[type=submit] {
                    width: auto !important;
                }
                .gform_footer {
                    display: flex;
                    justify-content: center;
                }
                input[type="text"], input[type="submit"], input[type="email"] {
                    box-shadow: none !important;
                }
                input[type="submit"] {
                    border-radius: 5px;
                    margin: 0 auto 15px;
                    width: 150px;
                }
                input[type="file"] {
                    width: 83px !important;
                    padding: 2px 0px 2px 2px !important;
                }
                .gform-body input[type="text"],
                .gform-body input[type="email"] {
                    padding-left: 45px !important;
                    background-color: #D2D2D2 !important;
                    border-radius: 5px !important;
                    border: none !important;
                    font-weight: 700;
                    color: #555555;
                }
                .ginput_container {
                    position: relative;
                }
                .gfield img {
                    position: absolute;
                    left: 7px;
                    top: 9px;
                    height: 24px;
                }
                .gfield_validation_message, 
                .gform_submission_error {
                    font-size: 12px !important;
                    padding: 4px 4px 4px 12px !important;
                    margin-top: 2px !important;
                }
                .gform_submission_error {
                    margin: 0 auto;
                }
                .gform_validation_errors {
                    padding: 0 !important;
                }
                .container-forms h2, 
                .container-forms button {
                    font-weight: 800;
                }
                .gform-body {
                    padding: 25px 25px 0 25px;
                    max-width: 550px;
                    margin: 0 auto;
                }
                .table {
                    display: table;
                    width: 100%;
                    height: 100%;
                }
                .table-cell {
                    display: table-cell;
                    vertical-align: middle;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .container {
                    border-radius: 25px;
                    position: relative;
                    /* min-width: 800px; */
                    max-width: 1200px;
                    margin: 30px auto 0;
                    height: 680px;
                    top: 50%;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .container .container-forms {
                    position: relative;
                }
                .container .btn-exh {
                    cursor: pointer;
                    text-align: center;
                    margin: 0 auto;
                    border-radius: 15px;
                    width: 164px;
                    font-size: 24px;
                    margin: 12px 0;
                    padding: 5px 0;
                    color: #fff;
                    opacity: 1;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .container .btn-exh:hover {
                    opacity: 0.7;
                }
                .container .container-forms .container-info {
                    display: flex;
                    justify-content: space-between;
                    text-align: left;
                    width: 100%;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .container .container-forms .container-info .info-item {
                    text-align: center;
                    width: 800px;
                    height: 680px;
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
                .info-item-left {
                    border-radius: 20px 0 0 20px;
                }
                .info-item-left h2 {
                    color: '. self::$accent_color .';
                }
                .info-item-left .gform_footer input[type="submit"] {
                    background-color: '. self::$accent_color .' !important;
                }
                .info-item-right {
                    position: absolute;
                    right: 0;
                    border-radius: 0 20px 20px 0;
                }
                .info-item-right .gform_footer input[type="submit"] {
                    background: '. self::$accent_color .' !important;
                }
                .info-item-right h2 {
                    color: '. self::$accent_color .';
                }
                .container-info .info-item button, 
                .gform_footer input[type="submit"] {
                    margin-top: 25px !important;
                    color: white !important;
                    font-weight: 800;
                    font-size: 24px !important;
                    border-radius: 15px !important;
                    padding: 15px 25px;
                    width: 200px;
                    box-shadow: none !important;
                    cursor: pointer;
                    border: none;
                }
                .container-info .none {
                    width: 0px !important;
                    overflow: hidden;
                }
                .form-item img {
                    opacity: 0.4;
                    position: absolute;
                    width: 100%;
                    z-index: 0;
                    left: 0;
                    top: 25%;
                }
                .form-item h2, 
                .form-item h3, 
                .form-item button {
                    z-index: 100;
                    position: relative;
                    color: white !important;
                }
                .form-item h3 {
                    font-weight: 400;
                    font-size: 18px;
                }
                .form-item-element-left {
                    background-color: '. self::$accent_color .' !important;
                    border-radius: 20px 0 0 20px;
                }
                .form-item-element-right {
                    background: '. self::$accent_color .' !important;
                    border-radius: 0 20px 20px 0;
                }
                .container .container-forms .container-info .info-item .btn-exh {
                    background-color: transparent;
                    border: 1px solid #fff;
                }
                .container .container-forms .container-info .info-item .table-cell {
                    padding-right: 0;
                }
                .container .container-forms .container-info .info-item:nth-child(2) .table-cell {
                    padding-left: 70px;
                    padding-right: 0;
                }
                .container .container-form {
                    overflow: hidden;
                    position: absolute;
                    left: 0px;
                    top: 0px;
                    width: 400px;
                    height: 680px;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .container .form-item {
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
                .container .form-item.sign-up {
                    position: absolute;
                    opacity: 0;
                }
                .container.log-in .container-form {
                    left: 800px;
                }
                .container.log-in .container-form .form-item.sign-up {
                    left: 0;
                    opacity: 1;
                }
                .container.log-in .container-form .form-item.log-in {
                    left: -100%;
                }
                .forms-container-info__btn {
                    margin-top: 50px !important;
                    background-color: transparent;
                    border: 2px solid white;
                }
                .heading-text {
                    text-align: center;
                    padding: 18px 0;
                }
                .heading-text h3 {
                    margin: 0 auto;
                    color: #000000 !important;
                }
                .guest-info {
                    width: 80% !important;
                    margin: 0 auto;
                    color: #000000 !important;
                }
                .custom-tech-support-text {
                    padding-top: 36px !important;
                }
                input{
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
                input[placeholder="FIRMA ZAPRASZAJĄCA"], 
                input[placeholder="FIRMA"], 
                input[placeholder="INVITING COMPANY"], 
                input[placeholder="COMPANY"] {
                    background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/box.png");
                }
                input[placeholder="E-MAIL OSOBY ZAPRASZANEJ"],
                input[placeholder="E-MAIL OF THE INVITED PERSON"],
                input[placeholder="E-MAIL"] {
                    background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/email.png");
                }
                input:-webkit-autofill,
                input:-webkit-autofill:hover,
                input:-webkit-autofill:focus {
                    -webkit-text-fill-color: #555555 !important;
                    -webkit-box-shadow: 0 0 0px 40rem #D2D2D2 inset !important;
                    transition: background-color 5000s ease-in-out 0s;
                }
                .gform_confirmation_message {
                    color: black !important;
                }
            }

                @media (max-width:1200px) {
                    .pwelement_' . self::$rnd_id . ' {
                        .container {
                            max-width: 900px !important;
                        }
                        .container .container-forms .container-info .info-item {
                            width: 600px;
                        }
                        .container .container-form {
                            width: 300px;
                        }
                        .container.log-in .container-form {
                            left: 600px;
                        }
                        .row-container:has(.gform_wrapper, .custom-container-grupy) .wpb_column,
                        .row-container:has(.drive, .area) .wpb_column {
                            max-width: 100% !important;
                        }
                        .pwe-generator-wystawcow .container .container-forms .container-info .info-item .table-cell {
                            padding-right: 0px !important;
                        }
                    }
                }
                @media (max-width:960px) {
                    .pwelement_' . self::$rnd_id . ' {
                        .container {
                            max-width: none !important;
                            margin: 15px auto 0;
                            height: 1080px;
                        }
                        .container .container-form {
                            width: 100%;
                            height: 380px;
        
                        }
                        .container .container-forms .container-info .info-item {
                            position: absolute;
                            top: 350px;
                            width: 100%;
                            height: 730px;
                            padding-top: 40px;
                        }
                        .container .container-form {
                            width: 100%;
                        }
                        .container.log-in .container-form {
                            left: 0px;
                        }
                        .row-container:has(.gform_wrapper, .custom-container-grupy) .row-parent {
                            padding: 0px 0px 0px 0px !important;
                        }
                        .info-item-left, 
                        .container, 
                        .info-item-right, 
                        .form-item-element-left, 
                        .form-item-element-right {
                            border-radius: 0px !important;
                        }
                        .forms-container-info__btn {
                            margin-top:10px !important;
                        }
                        .container .container-forms .container-info .info-item:nth-child(2) .table-cell {
                            padding-left: 0px !important; 
                            padding-right: 0;
                        }
                    }
                }
                @media (max-width:400px) {
                    .pwelement_' . self::$rnd_id . ' {
                        .pwe-generator-wystawcow h2 {
                            font-size: 24px !important;
                        }
                        .heading-text h3 {
                            font-size: 18px;
                        }
                    }
                }
            }

        </style>

            <div id="pweGeneratorWystawcow" class="pwe-generator-wystawcow">
                <div class="heading-text register-count">
                    <h3>';
                        if(get_locale() == 'pl_PL'){ 
                            $output .= 'Wykorzystano '. $registration_count .' z limitu 100 zaproszeń'; 
                        } else { 
                            $output .= 'Already used '. $registration_count .' from a total of 100 invitations'; 
                        } $output .= '  
                    </h3>
                </div>
                <div class="heading-text">
                    <h3>';
                        if(get_locale() == 'pl_PL'){ 
                            $output .= 'Jeśli potrzebujesz więcej zaproszeń skontaktuj się z nami!<br>
                            Obsługa Wystawców: <a href="tel:+48501239338">+48 501 239 338</a>'; 
                        } else { 
                            $output .= 'Contact us for more invites<br>
                            Exhibitors support: <a href="tel:+48501239338">+48 501 239 338</a>'; 
                        } $output .= '
                    </h3>
                </div>
                <div class="container">
                    <div class="container-forms">
                        <div class="container-info">
                            <div class="info-item info-item-left none">
                                <div class="table">
                                    <div class="table-cell">
                                        <div class="forms-container-form__left active">
                                            <h2>';
                                            if(get_locale() == 'pl_PL'){ 
                                                if($new_content){
                                                    $output .= 'WYGENERUJ IDENTYFIKATOR <br> DLA SIEBIE I OBSŁUGI STOISKA';
                                                } else {
                                                    $output .= 'WYGENERUJ IDENTYFIKATOR DLA SIEBIE I SWOICH PRACOWNIKÓW!';
                                                }
                                            } else { 
                                                $output .= 'GENERATE AN ID FOR YOURSELF <br> AND YOUR COWORKERS'; 
                                            } $output .= '               
                                            </h2>
                                        [gravityform id="'. $worker_form_id .'" title="false" description="false" ajax="false"]
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <div class="info-item info-item-right">
                            <div class="table">
                                <div class="table-cell">
                                    <h4 class="guest-info">';
                                        if(get_locale() == 'pl_PL'){ 
                                            $output .= 'Goście upoważnieni są do wejścia na teren targów<br> od godziny 10:00</h4>
                                            <div class="forms-container-form__right"><h2>WYGENERUJ IDENTYFIKATOR</br>DLA SWOICH GOŚCI!</h2>'; 
                                        } else { 
                                            $output .= 'Visitors are entitled to enter the fairgrounds<br> from 10:00</h4>
                                            <div class="forms-container-form__right"><h2>GENERATE AN INVITE FOR YOUR GUESTS!</h2>'; 
                                        } $output .= '
                                        [gravityform id="'. $guest_form_id .'" title="false" description="false" ajax="false"]
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="container-form">
                            <div class="form-item form-item-element-left log-in">
                                <div class="table">
                                    <div class="table-cell">
                                        <h2>';
                                        if(get_locale() == 'pl_PL'){
                                            if($new_content){
                                                $output .= 'WYGENERUJ IDENTYFIKATOR DLA SIEBIE I OBSŁUGI STOISKA</h2>';
                                            } else {
                                                $output .= 'WYGENERUJ IDENTYFIKATOR DLA SIEBIE I SWOICH PRACOWNIKÓW</h2>
                                                <h3>JEŚLI CHCESZ ZAPROSIĆ NA WYDARZENIE SWOICH WSPÓŁPRACOWNIKÓW, WYPEŁNIJ FORMULARZ</h3>';
                                            }
                                        } else $output .= 'GENERATE AN ID FOR YOURSELF AND YOUR COWORKERS';
                                        $output .= '<button class="forms-container-info__btn btn-exh">';
                                        $output .= ($locale == 'pl_PL') ? 'KLIKNIJ' : 'CHANGE';
                                        $output .= '</button>
                                        <img src="/wp-content/plugins/PWElements/media/generator-wystawcow/bg.png"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item form-item-element-right sign-up">
                                <div class="table">
                                    <div class="table-cell">';
                                        $output .= (get_locale() == 'pl_PL') ? '<h2>WYGENERUJ IDENTYFIKATOR DLA SWOICH GOŚCI</h2>' : '<h2>GENERATE AN INVITE FOR YOUR GUESTS!</h2>';
                                        if($locale == 'pl_PL'){
                                            $output .= (!$new_content) ? '<h3>JEŚLI CHCESZ ZAPROSIĆ NA WYDARZENIE SWOICH NAJWAŻNIEJSZYCH GOŚCI, KLIENTÓW LUB KONTRACHENTÓW, WYPEŁNIJ FORMULARZ</h3>' : '';
                                        }
                                        $output .= '<button class="forms-container-info__btn btn-exh">';
                                        $output .= ($locale == 'pl_PL') ? 'KLIKNIJ' : 'CHANGE';
                                        $output .= '</button>
                                        <img src="/wp-content/plugins/PWElements/media/generator-wystawcow/bg.png" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="heading-text custom-tech-support-text">
                    <h3>';
                        if(get_locale() == 'pl_PL'){
                            $output .= 'Potrzebujesz pomocy?<br>
                            Skontaktuj się z nami - <a href="mailto:info@warsawexpo.eu">info@warsawexpo.eu</a>'; 
                        } else { 
                            $output .= 'Need help?<br>
                            Contact us - <a href="mailto:info@warsawexpo.eu">info@warsawexpo.eu</a>'; 
                        } $output .= '
                    </h3>
                </div>
            </div>

            <script type="text/javascript"> 
                var btnExhElements = document.querySelectorAll(".form-item .btn-exh");
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

?>
