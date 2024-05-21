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

                .pwelement_'. self::$rnd_id .' .gform_validation_errors {
                    display: none;
                }
                .pwelement_'. self::$rnd_id .' .gform_legacy_markup_wrapper li.gfield.gfield_error {
                    border-top: none;
                    border-bottom: none;
                    padding-bottom: 0;
                    padding-top: 0;
                }
                .pwelement_'. self::$rnd_id .' .heading-text :is(h3, a){
                    color: '. $text_color .';
                }
                .pwelement_'. self::$rnd_id .' .heading-text {
                    text-align: center;
                    padding: 18px 0;
                }
                .pwelement_'. self::$rnd_id .' .heading-text h3 {
                    margin: 0 auto;
                    color: #000000 !important;
                }
                .pwelement_'. self::$rnd_id .' .heading-text a {
                    text-decoration: underline;
                    color: black !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-generator-wystawcow {
                    padding: 18px 0 36px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-generator-wystawcow h2 {
                    font-size: 28px !important;
                    width: auto !important;
                }
                .pwelement_'. self::$rnd_id .' .gform_legacy_markup_wrapper .gform_footer input[type=submit] {
                    width: auto !important;
                }
                .pwelement_'. self::$rnd_id .' .gform_footer {
                    display: flex;
                    justify-content: center;
                }
                .pwelement_'. self::$rnd_id .' input[type="text"], input[type="submit"], input[type="email"] {
                    box-shadow: none !important;
                }
                .pwelement_'. self::$rnd_id .' input[type="submit"] {
                    border-radius: 5px;
                    margin: 0 auto 15px;
                    width: 150px;
                }
                .pwelement_'. self::$rnd_id .' input[type="file"] {
                    width: 83px !important;
                    padding: 2px 0px 2px 2px !important;
                }
                .pwelement_'. self::$rnd_id .' .gform-body input[type="text"],
                .pwelement_'. self::$rnd_id .' .gform-body input[type="email"] {
                    padding-left: 45px !important;
                    background-color: #D2D2D2 !important;
                    border-radius: 5px !important;
                    border: none !important;
                    font-weight: 700;
                    color: #555555;
                }
                .pwelement_'. self::$rnd_id .' .ginput_container {
                    position: relative;
                }
                .pwelement_'. self::$rnd_id .' .gfield img {
                    position: absolute;
                    left: 7px;
                    top: 9px;
                    height: 24px;
                }
                .pwelement_'. self::$rnd_id .' .gfield_validation_message, 
                .pwelement_'. self::$rnd_id .' .gform_submission_error {
                    font-size: 12px !important;
                    padding: 4px 4px 4px 12px !important;
                    margin-top: 2px !important;
                }
                .pwelement_'. self::$rnd_id .' .gform_submission_error {
                    margin: 0 auto;
                }
                .pwelement_'. self::$rnd_id .' .gform_validation_errors {
                    padding: 0 !important;
                }
                .pwelement_'. self::$rnd_id .' .container-forms h2, 
                .pwelement_'. self::$rnd_id .' .container-forms button {
                    font-weight: 800;
                }
                .pwelement_'. self::$rnd_id .' .gform-body {
                    padding: 25px 25px 0 25px;
                    max-width: 550px;
                    margin: 0 auto;
                }
                .pwelement_'. self::$rnd_id .' .table {
                    display: table;
                    width: 100%;
                    height: 100%;
                }
                .pwelement_'. self::$rnd_id .' .table-cell {
                    display: table-cell;
                    vertical-align: middle;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .pwelement_'. self::$rnd_id .' .container {
                    border-radius: 25px;
                    position: relative;
                    /* min-width: 800px; */
                    max-width: 1200px;
                    margin: 30px auto 0;
                    height: 700px;
                    top: 50%;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .pwelement_'. self::$rnd_id .' .container .container-forms {
                    position: relative;
                }
                .pwelement_'. self::$rnd_id .' .container .btn-exh {
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
                .pwelement_'. self::$rnd_id .' .container .btn-exh:hover {
                    opacity: 0.7;
                }
                .pwelement_'. self::$rnd_id .' .container .container-forms .container-info {
                    display: flex;
                    justify-content: space-between;
                    text-align: left;
                    width: 100%;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .pwelement_'. self::$rnd_id .' .container .container-forms .container-info .info-item {
                    text-align: center;
                    width: 800px;
                    height: 700px;
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
                .pwelement_'. self::$rnd_id .' .info-item-left {
                    border-radius: 20px 0 0 20px;
                }
                .pwelement_'. self::$rnd_id .' .info-item-left h2 {
                    color: '. self::$accent_color .';
                }
                .pwelement_'. self::$rnd_id .' .info-item-left .gform_footer input[type="submit"] {
                    background-color: '. self::$accent_color .' !important;
                }
                .pwelement_'. self::$rnd_id .' .info-item-right {
                    position: absolute;
                    right: 0;
                    border-radius: 0 20px 20px 0;
                }
                .pwelement_'. self::$rnd_id .' .info-item-right .gform_footer input[type="submit"] {
                    background: '. self::$accent_color .' !important;
                }
                .pwelement_'. self::$rnd_id .' .info-item-right h2 {
                    color: '. self::$accent_color .';
                }
                .pwelement_'. self::$rnd_id .' .container-info .info-item button, 
                .pwelement_'. self::$rnd_id .' .gform_footer input[type="submit"] {
                    margin: 0 !important;
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
                .pwelement_'. self::$rnd_id .' .container-info .none {
                    width: 0px !important;
                    overflow: hidden;
                }
                .pwelement_'. self::$rnd_id .' .form-item img {
                    opacity: 0.4;
                    position: absolute;
                    width: 100%;
                    z-index: 0;
                    left: 0;
                    top: 25%;
                }
                .pwelement_'. self::$rnd_id .' .form-item h2, 
                .pwelement_'. self::$rnd_id .' .form-item h3, 
                .pwelement_'. self::$rnd_id .' .form-item button {
                    z-index: 100;
                    position: relative;
                    color: white !important;
                }
                .pwelement_'. self::$rnd_id .' .form-item h3 {
                    font-weight: 400;
                    font-size: 18px;
                }
                .pwelement_'. self::$rnd_id .' .form-item-element-left {
                    background-color: '. self::$accent_color .' !important;
                    border-radius: 20px 0 0 20px;
                }
                .pwelement_'. self::$rnd_id .' .form-item-element-right {
                    background: '. self::$accent_color .' !important;
                    border-radius: 0 20px 20px 0;
                }
                .pwelement_'. self::$rnd_id .' .container .container-forms .container-info .info-item .btn-exh {
                    background-color: transparent;
                    border: 1px solid #fff;
                }
                .pwelement_'. self::$rnd_id .' .container .container-forms .container-info .info-item .table-cell {
                    padding-right: 0;
                }
                .pwelement_'. self::$rnd_id .' .container .container-forms .container-info .info-item:nth-child(2) .table-cell {
                    padding-left: 70px;
                    padding-right: 0;
                }
                .pwelement_'. self::$rnd_id .' .container .container-form {
                    overflow: hidden;
                    position: absolute;
                    left: 0px;
                    top: 0px;
                    width: 400px;
                    height: 700px;
                    -moz-transition: all 0.5s;
                    -o-transition: all 0.5s;
                    -webkit-transition: all 0.5s;
                    transition: all 0.5s;
                }
                .pwelement_'. self::$rnd_id .' .container .form-item {
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
                .pwelement_'. self::$rnd_id .' .container .form-item.sign-up {
                    position: absolute;
                    opacity: 0;
                }
                .pwelement_'. self::$rnd_id .' .container.log-in .container-form {
                    left: 800px;
                }
                .pwelement_'. self::$rnd_id .' .container.log-in .container-form .form-item.sign-up {
                    left: 0;
                    opacity: 1;
                }
                .pwelement_'. self::$rnd_id .' .container.log-in .container-form .form-item.log-in {
                    left: -100%;
                }
                .pwelement_'. self::$rnd_id .' .forms-container-info__btn {
                    margin-top: 50px !important;
                    background-color: transparent;
                    border: 2px solid white;
                }
                .pwelement_'. self::$rnd_id .' .guest-info {
                    width: 80% !important;
                    margin: 0 auto;
                    color: #000000 !important;
                }
                .pwelement_'. self::$rnd_id .' .custom-tech-support-text {
                    padding-top: 36px !important;
                }
                .pwelement_'. self::$rnd_id .' input{
                    background-repeat: no-repeat;
                    background-size: 30px;
                    background-position: 5px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-generator-wystawcow :is(
                input[placeholder="IMIĘ I NAZWISKO (PRACOWNIKA)"], 
                input[placeholder="IMIĘ I NAZWISKO (GOŚCIA)"], 
                input[placeholder="NAME AND SURNAME (GUEST)"], 
                input[placeholder="NAME AND SURNAME (EMPLOYEE)"], 
                input[placeholder="NAME AND SURNAME"]) {
                    background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/name.png");
                }
                .pwelement_'. self::$rnd_id .' input[placeholder="FIRMA ZAPRASZAJĄCA"], 
                .pwelement_'. self::$rnd_id .' input[placeholder="FIRMA"], 
                .pwelement_'. self::$rnd_id .' input[placeholder="INVITING COMPANY"], 
                .pwelement_'. self::$rnd_id .' input[placeholder="COMPANY"] {
                    background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/box.png");
                }
                .pwelement_'. self::$rnd_id .' input[placeholder="E-MAIL OSOBY ZAPRASZANEJ"],
                .pwelement_'. self::$rnd_id .' input[placeholder="E-MAIL OF THE INVITED PERSON"],
                .pwelement_'. self::$rnd_id .' input[placeholder="E-MAIL"] {
                    background-image: url("/wp-content/plugins/PWElements/media/generator-wystawcow/email.png");
                }
                .pwelement_'. self::$rnd_id .' input:-webkit-autofill,
                .pwelement_'. self::$rnd_id .' input:-webkit-autofill:hover,
                .pwelement_'. self::$rnd_id .' input:-webkit-autofill:focus {
                    -webkit-text-fill-color: #555555 !important;
                    -webkit-box-shadow: 0 0 0px 40rem #D2D2D2 inset !important;
                    transition: background-color 5000s ease-in-out 0s;
                }
                .pwelement_'. self::$rnd_id .' .gform_confirmation_message {
                    color: black !important;
                }
            

                @media (max-width:1200px) {
                    .pwelement_'. self::$rnd_id .' .container {
                        max-width: 900px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .container .container-forms .container-info .info-item {
                        width: 600px;
                    }
                    .pwelement_'. self::$rnd_id .' .container .container-form {
                        width: 300px;
                    }
                    .pwelement_'. self::$rnd_id .' .container.log-in .container-form {
                        left: 600px;
                    }
                    .pwelement_'. self::$rnd_id .' .row-container:has(.gform_wrapper, .custom-container-grupy) .wpb_column,
                    .pwelement_'. self::$rnd_id .' .row-container:has(.drive, .area) .wpb_column {
                        max-width: 100% !important;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-generator-wystawcow .container .container-forms .container-info .info-item .table-cell {
                        padding-right: 0px !important;
                    }
                }
                @media (max-width:960px) {
                    .pwelement_'. self::$rnd_id .' .container {
                        max-width: none !important;
                        margin: 15px auto 0;
                        height: 1080px;
                    }
                    .pwelement_'. self::$rnd_id .' .container .container-form {
                        width: 100%;
                        height: 380px;
                    }
                    .pwelement_'. self::$rnd_id .' .container .container-forms .container-info .info-item {
                        position: absolute;
                        top: 350px;
                        width: 100%;
                        height: 780px;
                        padding-top: 40px;
                    }
                    .pwelement_'. self::$rnd_id .' .container .container-form {
                        width: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .container.log-in .container-form {
                        left: 0px;
                    }
                    .pwelement_'. self::$rnd_id .' .row-container:has(.gform_wrapper, .custom-container-grupy) .row-parent {
                        padding: 0px 0px 0px 0px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .info-item-left, 
                    .pwelement_'. self::$rnd_id .' .container, 
                    .pwelement_'. self::$rnd_id .' .info-item-right, 
                    .pwelement_'. self::$rnd_id .' .form-item-element-left, 
                    .pwelement_'. self::$rnd_id .' .form-item-element-right {
                        border-radius: 0px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .forms-container-info__btn {
                        margin-top:10px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .container .container-forms .container-info .info-item:nth-child(2) .table-cell {
                        padding-left: 0px !important; 
                        padding-right: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .gform-body {
                        padding: 16px 16px 0 16px;
                    }
                    .pwelement_'. self::$rnd_id .' .gform_footer input[type=submit] {
                        font-size: 16px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .custom-tech-support-text {
                        margin: 36px 0 !important;
                    }  
                }
                @media (max-width:400px) {
                    .pwelement_'. self::$rnd_id .' .pwe-generator-wystawcow h2 {
                        font-size: 18px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .ginput_container .gform-body input[type="text"],
                    .pwelement_'. self::$rnd_id .' .ginput_container .gform-body input[type="email"] {
                        font-size: 12px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .heading-text h3 {
                        font-size: 18px;
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
                                            <div class="forms-container-form__right"><h2>WYGENERUJ IDENTYFIKATOR VIP</br>DLA SWOICH GOŚCI!</h2>'; 
                                        } else { 
                                            $output .= 'Visitors are entitled to enter the fairgrounds<br> from 10:00</h4>
                                            <div class="forms-container-form__right"><h2>GENERATE A VIP INVITATION</br>FOR YOUR GUESTS!</h2>'; 
                                        } $output .= '
                                        [gravityform id="'. $guest_form_id .'" title="false" description="false" ajax="false"]';
                                        if(get_locale() == 'pl_PL'){ 
                                            $output .= '<p style="color: black;">
                                                            <span><b>Identyfikator VIP uprawnia do:</b></span><br>
                                                            * Bezpłatnego skorzystania ze strefy VIP ROOM<br>
                                                            * Uczestnictwa we wszystkich konferencjach branżowych<br>
                                                            * Dedykowanej kolejki
                                                        </p>'; 
                                        } else { 
                                            $output .= '<p style="color: black;">
                                                            <span><b>VIP ID entitles you to:</b></span><br>
                                                            * Free use of the VIP ROOM zone<br>
                                                            * Participation in all industry conferences<br>
                                                            * Dedicated queue
                                                        </p>'; 
                                        } $output .= '
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="container-form">
                            <div class="form-item form-item-element-left log-in">
                                <div class="table">
                                    <div class="table-cell">';
                                        if(get_locale() == 'pl_PL'){
                                            if($new_content){
                                                $output .= '<h2>WYGENERUJ IDENTYFIKATOR DLA SIEBIE I OBSŁUGI STOISKA</h2>';
                                            } else {
                                                $output .= '<h2>WYGENERUJ IDENTYFIKATOR DLA SIEBIE I SWOICH PRACOWNIKÓW</h2>
                                                <h3>JEŚLI CHCESZ ZAPROSIĆ NA WYDARZENIE SWOICH WSPÓŁPRACOWNIKÓW, WYPEŁNIJ FORMULARZ</h3>';
                                            }
                                        } else $output .= '<h2>GENERATE AN ID FOR YOURSELF AND YOUR COWORKERS</h2>';
                                        $output .= '<button class="forms-container-info__btn btn-exh">';
                                        $output .= (get_locale() == 'pl_PL') ? 'KLIKNIJ' : 'CHANGE';
                                        $output .= '</button>
                                        <img src="/wp-content/plugins/PWElements/media/generator-wystawcow/bg.png"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-item form-item-element-right sign-up">
                                <div class="table">
                                    <div class="table-cell">';
                                        $output .= (get_locale() == 'pl_PL') ? '<h2>WYGENERUJ IDENTYFIKATOR VIP DLA SWOICH GOŚCI!</h2>' : '<h2>GENERATE A VIP INVITATION FOR YOUR GUESTS!</h2>';
                                        if(get_locale() == 'pl_PL'){
                                            $output .= (!$new_content) ? '<h3>JEŚLI CHCESZ ZAPROSIĆ NA WYDARZENIE SWOICH NAJWAŻNIEJSZYCH GOŚCI, KLIENTÓW LUB KONTRACHENTÓW, WYPEŁNIJ FORMULARZ</h3>' : '';
                                        }
                                        $output .= '<button class="forms-container-info__btn btn-exh">';
                                        $output .= (get_locale() == 'pl_PL') ? 'KLIKNIJ' : 'CHANGE';
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
