<?php 
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

/**
 * Class PWElementXForm
 * Extends PWElements class and defines a pwe Visual Composer element for x-steps-form.
 */
class PWElementXForm extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }    
    
    /**
     * Adding Scripts
     */
    public function addingScripts(){

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
                'heading' => __('Form id', 'pwelement'),
                'param_name' => 'x_form_name',
                'save_always' => true,
                'value' => array(
                    'rejestracja' => 'register',
                    'krok2' => 'step2',
                    'potwierdzenie' => 'potwierdzenie'
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementXForm',
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Form id', 'pwelement'),
                'param_name' => 'x_form_name',
                'save_always' => true,
                'value' => array_merge(
                  array('Wybierz' => ''),
                  self::$fair_forms,
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementXForm',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Potwierdzenie rejestracji', 'pwelement'),
                'param_name' => 'confirmation_url',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementXForm',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Osoba odpowiedzialna za wystawców', 'pwelement'),
                'param_name' => 'exhibitor_email',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementXForm',
                ),
            ),
        );
        return $element_output;
    }

    /**
     * Sprawdza poprawność adresu e-mail.
     *
     * @param string $email Adres e-mail do sprawdzenia.
     * @return bool Zwraca true, jeśli adres e-mail jest poprawny, w przeciwnym razie false.
     */
    private static function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * Sprawdza poprawność numeru telefonu.
     *
     * @param string $phone Numer telefonu do sprawdzenia.
     * @return bool Zwraca true, jeśli numer telefonu jest poprawny, w przeciwnym razie false.
     */
    private static function isValidPhone($phone) {
        if (preg_match('/^[0-9\s\+\(\)]+$/', $phone)) {
            $cleanedPhone = preg_replace('/[^0-9]/', '', $phone);
            return strlen($cleanedPhone) >= 9 && strlen($cleanedPhone) <= 11;
        }
        return false;
    }
    
    /**
     * Static method to generate the HTML for Email.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function x_form_send($x_form_id) {
        
        if (!$_SESSION['email_send']){
            $inside_id_data = array(
                'form_id' => $x_form_id,
                '1' => sanitize_text_field($_POST['email']),
                '3' => $_POST['phone'],
            );
            $entry_id = GFAPI::add_entry($inside_id_data);
            $_SESSION['entry_id'] = $entry_id;

            for ($i=0; $i<=300;$i++){
                if(gform_get_meta($entry_id , 'qr-code_feed_' . $i . '_url') != ''){
                    $meta_key = 'qr-code_feed_' . $i . '_url';
                    break;
                }
            }            

            $qr_code_url = gform_get_meta($entry_id, $meta_key);

            $entry = GFAPI::get_entry($entry_id);
            $entry[6] = $qr_code_url;
            $updated = GFAPI::update_entry($entry);
            
            $sent = wp_mail(
                sanitize_text_field($_POST['email']),
                'Wejściówka na ' . do_shortcode("[trade_fair_name]"),
                do_shortcode(self::Email_1($qr_code_url)),
                array('Content-Type: text/html; charset=UTF-8', 'From ' . do_shortcode("[trade_fair_rejestracja]"))
            );
            $_SESSION['email_send'] = true;
        } 
    }

    /**
     * Static method to generate the HTML for Email.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function Email_1($qr_code_url) {

        $email_output = '
            <!DOCTYPE html>
            <html lang="en">
            <head>
            <meta charset="UTF-8" />
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
            <title>Potwierdzenie rejestracji</title>
            </head>

            <body> 
            <style>
                body{
                    text-align: justify; 
                    max-width: 600px; 
                    margin: 0 auto; 
                    font-family: "Open Sans", "Montserrat", sans-serif;
            </style>
            <div>
                <img style="width:600px;" src="https://[trade_fair_domainadress]/doc/header.jpg" alt="[trade_fair_name]" />
            </div>
            <div style="padding: 0 5px">
                <h3 style="font-size: 20px; margin: 20px 0 10px">
                Witaj, {Imię i nazwisko:1},
                </h3>
                <p style="font-size: 14px; margin: 0 0 10px">
                Dziękujemy za rejestrację na [trade_fair_name] w Ptak Warsaw Expo.
                Wszystkie szczegóły dotyczące wystawy znajdą Państwo na naszej stronie
                internetowej
                <a target="_blank" href="https://[trade_fair_domainadress]/">[trade_fair_domainadress]</a>.
                </p>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td>
                    <table cellpadding="10" cellspacing="0" border="0" width="100%">
                        <tr align="center">
                        <td valign="center" style="display: inline-block; width: 100%; max-width: 200px;">
                            <img src="' . $qr_code_url . '">
                        </td>
                        <td valign="center" align="center" style="display: inline-block; width: 100%; max-width: 300px;">
                            <p style="font-size: 14px; margin: 0 0 10px">
                            To jest twój kod QR, który upoważnia do bezpłatnego wejścia na teren
                            wystawy. Prosimy zabrać go ze sobą.
                            </p>
                            <p style="font-size: 14px; margin: 0 0 10px">
                            Jeżeli nie widzisz kodu QR, wyłącz opcję blokowania obrazków dla
                            tego maila.
                            </p>
                        </td>
                        </tr>
                    </table>
                    </td>
                </tr>
                </table>
                <p style="font-size: 14px; margin: 10px 0">
                Targi [trade_fair_name] odbędą się w terminie [trade_fair_date]. Zapisz tę
                datę w kalendarzu, aby o niej nie zapomnieć.
                </p>
                <div align="center" style="margin: 20px 0" class="socials">
                <a target="_blank" style="display: inline-block; width: 50px; margin: 0 15px; padding: 5px"
                    href="[trade_fair_facebook]" class="btn__fb">
                    <img style="width: 100%; height: auto" src="https://warsawexpo.eu/docs/facebookIcon.png" alt="fb__icon" />
                </a>
                <a target="_blank" style="display: inline-block; width: 50px; margin: 0 15px; padding: 5px"
                    href="[trade_fair_instagram]" class="btn__fb">
                    <img style="width: 100%; height: auto" src="https://warsawexpo.eu/docs/instagramicon.png" alt="insta__icon" />
                </a>
                </div>
                <p style="font-size: 14px; margin: 30px 0 0" class="greeting">
                Pozdrawiamy, Zespół [trade_fair_name]
                </p>
                <sub style="font-size: 12px; margin: 0">Wiadomość wygenerowana automatycznie, prosimy na nią nie odpowiadać.</sub>
            </div>
            <div style="margin: 20px 0 10px">
                <img style="display: block; max-width: 100%; height: auto; margin: 0"
                src="https://warsawexpo.eu/assets/mail/footer.jpg" alt="email_footer" />
                <p align="center" style="
                    padding: 16px;
                    background-color: #000;
                    color: #fff;
                    margin: 0;
                    line-height: 1;
                    ">
                © [trade_fair_actualyear] Ptak Warsaw Expo
                <span style="display: block; margin-top: 4px">Wszystkie prawa zastrzeżone</span>
                </p>
            </div>
            <p style="margin-top: 10px; padding: 0 5px; font-size: 12px" class="footer__rodo">
                Administratorem Pani/Pana danych osobowych jest spółka PTAK WARSAW EXPO
                sp. z o.o. z siedzibą w Nadarzynie (kod pocztowy: 05-830), przy Al.
                Katowickiej 62, wpisaną do rejestru przedsiębiorców Krajowego Rejestru
                Sądowego pod numerem KRS 0000671001, NIP 532544579. Dane osobowe będą
                przetwarzane zgodnie z Rozporządzeniem Parlamentu Europejskiego i Rady
                (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych
                w związku z przetwarzaniem danych osobowych i w sprawie swobodnego
                przepływu takich danych oraz uchylenia dyrektywy 95/46/WE (RODO), na
                podstawie art. 6 ust. 1 lit. a lub b ww. Rozporządzenia w celach
                wskazanych w treści ww. zgód. Dane będą przetwarzane do czasu wycofania
                zgody i będą podlegały okresowemu przeglądowi co 2 lata. Pani/a dane
                osobowe mogą być przekazane osobom trzecim, które przetwarzają dane
                osobowe w imieniu PTAK WARSAW EXPO sp. z o.o. na podstawie umów
                powierzenia tj. usługi IT, podmioty świadczące usługi marketingowe,
                podmioty przetwarzające dane w celu dochodzenia roszczeń i windykacji lub
                innych. Ma Pan/i możliwość dostępu do swoich danych, w celu ich
                sprostowania i usunięcia, przeniesienia danych oraz żądania ograniczenia
                ich przetwarzania ze względu na swoją szczególną sytuację, wniesienia
                sprzeciwu oraz wycofania udzielonej zgody w każdym momencie, przy czym,
                cofnięcie uprzednio wyrażonej zgody nie wpłynie na legalność przetwarzania
                przed jej wycofaniem, a także wniesienia skargi do organu nadzorczego -
                Prezesa Urzędu Ochrony Danych Osobowych. Dane nie będą przekazywane do
                państw trzecich oraz nie podlegają profilowaniu tj. automatycznemu
                podejmowaniu decyzji. Kontakt z administratorem możliwy jest pod adresem
                e-mail: rodo@warsawexpo.eu.
            </p>
            </body>

            </html>
        ';
        
        return $email_output;
    }

    /**
     * Static method to send request to become exhibitor.
     * This method registering crone action. 
     * 
     * @param string @entry_id entry id to send
     */
    public static function exhibitor_registering($entry_id, $exhibitor, $update = ''){

        $entry = GFAPI::get_entry($entry_id);

        $email_output = '';
        foreach($entry as $id => $key){
            if(is_numeric($id) && $key != '' && strpos($key, '/wp-content/uploads/') !== false){
                $email_output .= '<p>' . $key . '</p>';
            }
        }
        
        $email_title = ($update == '') ? do_shortcode("[trade_fair_name]") . ' - osoba zgłosiła chęć na zostanie wystawcą ' : $entry['1'] . ' - dodatkowe informacje wystawcy' ;

        $sent = wp_mail(
            $exhibitor,
            $email_title,
            $email_output,
            array('Content-Type: text/html; charset=UTF-8', do_shortcode("[trade_fair_rejestracja]"))
        );
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . '!important;';
        $btn_color = 'background-color:' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . '!important;';
        $confirmation_url = ($atts['confirmation_url'] != '') ? $atts['confirmation_url'] : '/potwierdzenie-rejestracji';
        $x_form_id = self::findFormsID($atts['x_form_name']);
        $exhibitor = ($atts['exhibitor_email'] != '') ? $atts['exhibitor_email'] : "marek.rumianek@warsawexpo.eu";

        $output = '
            <style>

                body:has(#xForm .form-3, #xForm .form-2) :is(.custom-footer-bg, .custom-footer-images-bg){
                    display: none;
                }
                
                .pwelement:has(#xForm){
                    text-align: -webkit-center;
                }

                
                #xForm:has(.form-1) {
                    background-image: url(/wp-content/plugins/PWElements/media/badge-head.png);
                    background-repeat: round;
                    height: 830px;
                    background-size: cover;
                    max-width: 545px;
                }
                #xForm input{
                    box-shadow: none;
                }

                #xForm:is(.form-1, .form-1-top) {
                    width: 430px;
                    left: 50%;
                    transform: translateX(-50%);
                }
                
                #xForm .form-1-top {
                    width: 89.3%;
                    position: absolute;
                    z-index: 7;
                    background-color: ' . self::$accent_color . ';
                    top: 150px;
                    height: 120px;
                    right: 5.7%;
                }

                #xForm .form-1 {
                    text-align: left;
                    position: relative;
                    height: 520px;
                    padding: 10px calc(50px + 1vw);
                    top: 100px;
                    z-index: 5;
                }
                
                #xForm input {
                    border-color: #c49a62 !important;
                    border-radius: 10px;
                }
                
                #xForm input:not(.checkbox) {
                    margin: 5px 0 0;
                    width: 100%;
                    padding: 10px 15px;
                }
                
                #xForm p {
                    margin-top: 0px;
                }
                
                #xForm .consent-text {
                    font-size: 11px;
                    margin-left: 5px;
                }
                
                #xForm button {
                    text-transform: uppercase;
                    margin-top: 20px;
                    font-weight: 600;
                    ' . $btn_color . '
                    color: white;
                    border: 1px solid white;
                    border-radius: 11px;
                    padding: 13px calc(10px + 1vw);
                }

                #xForm .form-1-btn{
                    width: 100%;
                    font-size: calc(10px + 0.4vw);
                }

                #xForm .form-1-image {
                    position: absolute;
                    width: calc(100px + 3vw);
                    border-radius: 15px;
                    top: 40%;
                    right: 5%;
                    z-index: 10;
                }
                
                #xForm .form-1 #registration {
                    margin-top: 36px;
                }
                
                #xForm button:hover, #xForm .exhibitor-no {
                    background: white !important;
                    color: black;
                    border-color: black;
                }
                
                #xForm .exhibitor-no:hover{
                    color: white;
                    background: black !important;
                }

                #xForm:has(.form-2), #xForm:has(.form-3){
                    min-height: 780px;
                    display: flex;
                    align-items: center;
                }

                #xForm .form-2 .krok span {
                    ' . $text_color . '
                }

                #xForm .form-2 .wystawca span {
                    ' . $text_color . '
                }
                
                #xForm .form-2 {
                    text-align: -webkit-right;
                    width:50%;
                }
                #xForm .form-2>div {
                    width: fit-content;
                    text-align: left;
                    margin:36px;
                }

                #xForm .form-2-right {
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
                
                #xForm .form-2-right img{
                    width: 250px;
                }

                #xForm .form-2-right :is(h3, h4) {
                    text-shadow: 0 0 2px black;
                    color: white !important;
                }
                
                #xForm .form-2-right :is(h3, h4) {
                    text-shadow: 0 0 2px black;
                    color: white !important;
                }

                #xForm label {
                    font-weight: 700;
                    font-size: 15px;
                }
                
                #xForm .consent-container {
                    margin-top: 5px;
                    display: flex;
                    flex-direction: row;
                    align-items: center;
                }
                
                #xForm:has(.form-3)>div{
                    width: 33%;
                }
                #xForm .form3-half {
                    display: flex;
                    gap: 20px;
                }
                #xForm .form3-half>div{
                    flex: 1;
                }
                #xForm .form-3{
                    text-align: left;
                    padding: 25px 50px;
                    background-color: #E8E8E8;
                    align-content: center;
                    min-height: inherit;
                }
                #xForm .form-3 div:has(button){
                    text-align: center;
                }
                #xForm .form-3 span, #xForm .color-accent{
                    ' . $text_color . '
                }
                #xForm .form-3 label{
                    margin-top: 18px;
                    float: left;
                }
                #xForm .form-3-left {
                    text-align: -webkit-right;
                    padding: 36px;
                }
                #xForm .form-3-left>div {
                    text-align:left;
                    max-width: 320px;
                }
                #xForm .form-3-right:has(.img-stand){
                    padding: 36px;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    gap: 27px;
                }
                #xForm .btn-stand{
                    background-color: black;
                    color:white;
                }
                #xForm .very-strong {
                    font-weight: 700;
                }

                @media (min-width:640px) and (max-width: 959px){
                    #xForm:has(.form-1) {
                        background-repeat: none;
                    }
                    #xForm .form-1-top {
                        width: 488px;
                        left: 50%;
                        transform: translateX(-50.5%);
                    }
                }
                @media (max-width:799px){
                    #xForm:has(.form-2) {
                        flex-direction: column;
                    }
                    #xForm :is(.form-2, .form-2-right){
                        width:100%;
                        min-height: 0;
                    }
                    #xForm .form-2{
                        text-align: -webkit-center;
                    }
                    #xForm .form-2-right {
                        align-items: center;
                    }
                } 

                @media (max-width:639px){
                    #xForm .form-1-top .h1{
                        width: calc(100px + 12vw);
                    }
                    #xForm .form-1 {
                        padding: 10px calc(30px + 1vw);
                    }
                    #xForm .form-1-btn {
                        font-size: calc(9px + 0.1vw);
                    }
                    #xForm .form-1 #registration {
                        margin-top: 3vw;
                    }
                    #xForm .form-2 .h1{
                        font-size: calc(25px + 3vw);
                    }
                } 
            </style>
            <div id="xForm">
        ';

        if (isset($_POST['email']) && isset($_POST['phone'])) {

            $_SESSION['step'] = 'step-1-submit';

            self::x_form_send($x_form_id);

            $output .= '
                <div class="form-2">
                    <div>
                        <h5 class="krok"> Krok <span>2 z 3<span></h5>
                        <h2 class="h1 text-color-jevc-color">Twój bilet został<br>wygenerowany<br>pomyślnie!</h2>
                        <p>Otrzymasz go na wskazany adres e-mail.<br>Może to potrwać kilka minut.</p>
                        <h3 class="wystawca">Czy chcesz zostać <span class="text-">wystawcą</span><br>targów Recycling Tech?</h3>
                        <form id="exhibitor-question" method="post" action="">
                            <button class="btn exhibitor-yes" name="exhibitor-yes">Tak, jestem zainteresowany</button>
                            <button class="btn exhibitor-no" name="exhibitor-no">Nie dziękuję</button>
                        </form>
                    </div>
                </div>
                <div class="form-2-right">
                    <h3>Nadchodząca edycja:</h3>
                    <img src="/doc/logo.webp">
                    <h4 class="h1">[trade_fair_date]</h4>
                    <h4>w Ptak Warsaw Expo</h4>
                </div>
            </div>
            ';
            
            return $output;
        }

        if (isset($_POST['exhibitor-no'])){

            $output .= '
                <div class="form-3-left">
                    <div>
                        <h5 class="krok"> Krok <span class="color-accent">3 z 3<span></h5>
                        <h2 class="h1 text-color-jevc-color">Dziękujemy za rejestrację
                        na <br>[trade_fair_name]!</h2>
                        <p>Cieszymy się, że dołączasz do naszego wydarzenia, pełnego nowości rynkowych i inspiracji do zastosowania w Twojej firmie.</p><br>
                        <p><span class="very-strong">Zachęcamy do wypełnienia</span> ostatniego formularza, dzięki temu będziemy mogli przygotować dla Was <span class="very-strong">wyjątkowy pakiet powitalny VIP</span>, który usprawni Państwapobyt na targach.</p>
                    </div>
                </div>
                <div class="form-3">
                    <h3>Podaj adres, na który mamy wysłać <span>darmowy pakiet powitalny VIP</span></h3>
                    <p>Otrzymasz bezpłatny spersonalizowany identyfikator wraz z planem/harmonogramem targów oraz kartę parkingową.</p>
                    <form id="form3" action="" method="post">
                        <div class="form3-half">
                            <div>
                                <label>Imię</label>
                                <input type="text" class="imie" name="imie" placeholder="Imię" required>
                            </div>
                            <div>
                                <label>Nazwisko</label>
                                <input type="text" class="nazwisko" name="nazwisko" placeholder="Nazwisko" required>
                            </div>
                        </div>
                        <label>Ulica</label>
                        <input type="text" class="ulica" name="ulica" placeholder="Ulica" required>
                        <div class="form3-half">
                            <div>
                                <label>Numer Budynku</label>
                                <input type="text" class="budynek" name="budynek" placeholder="Numer budynku" required>
                            </div>
                            <div>
                                <label>Numer Mieszkania</label>
                                <input type="text" class="mieszkanie" name="mieszkanie" placeholder="Numer mieszkania" required>
                            </div>
                        </div>
                        <div class="form3-half">
                            <div>
                                <label>Kod Pocztowy</label>
                                <input type="text" class="kod_pocztowy" name="kod_pocztowy" placeholder="Kod pocztowy" required>
                            </div>
                            <div>
                                <label>Miasto</label>
                                <input type="text" class="miasto" name="miasto" placeholder="Miasto" required>
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="form3">Zamawiam bezpłatny identyfikator</button>
                        </div>
                    </form>
                </div>
                <div class="form-3-right">
                    <img src="/wp-content/plugins/PWElements/media/mapka-wawa.png">
                </div>
            </div>

            ';

            return $output;
        }

        if (isset($_POST['form3'])){
            if($_SESSION['entry_id']){
                $entry = GFAPI::get_entry($_SESSION['entry_id']);

                $entry[4] = $_POST['imie'] . ' ' . $_POST['nazwisko'];
                $entry[5] = $_POST['ulica'] . ' ' . $_POST['budynek'] . ' / ' . $_POST['mieszkanie'] . ';' . $_POST['kod_pocztowy'] . ' ' . $_POST['miasto'];

                if (isset($_POST['dane'])){
                    $entry[5] = '';
                    $entry[7] = $_POST['dane'];
                    $updated = GFAPI::update_entry($entry);
                    self::exhibitor_registering($_SESSION['entry_id'], $exhibitor, 'update');
                } else {
                    $updated = GFAPI::update_entry($entry);
                }

                
            }
            
            $output .= '
                <div class="form-3-left">
                    <div>
                        <h2 class="h1 text-color-jevc-color">Dziękujemy za rejestrację na <span class"color-accent">[trade_fair_name]!</span></h2>
                        <p>Cieszymy się, że dołączasz do naszego wydarzenia, pełnego nowości rynkowych i inspiracji do zastosowania w Twojej firmie.</p><br>
                    </div>
                </div>
                <div class="form-3">
                    <p>Dziękujemy za skontaktowanie się z nami, odezwiemy się do Ciebie wkrótce.</p>
                </div>
                <div class="form-3-right">
                    <img src="/wp-content/plugins/PWElements/media/mapka-wawa.png">
                </div>
            </div>
            ';

            return $output;
        }

        if (isset($_POST['exhibitor-yes'])){
            self::exhibitor_registering($_SESSION['entry_id'], $exhibitor);
            
            $output .= '
                <div class="form-3-left">
                    <div>
                        <h2 class="text-color-jevc-color">Dziękujemy za rejestrację chęci udziału Państwa firmy na targach <span class="color-accent">[trade_fair_name]!</span></h2>
                        <p style="margin-top:36px;">Wkrótce nasz przedstawiciel skontaktuje się z Państwem, aby przedstawić ofertę wystawienniczą oraz korzyści płynące z udziału w targach.</p>
                    </div>
                </div>
                <div class="form-3">
                    <h3>Prosimy o podanie dodatkowych szczegółów</span></h3>
                    <p style="margin-top:36px;">Pomoże nam to w dobraniu odpowiednich warunków i usprawnieniu komunikacji.</p>
                    <form id="form3" action="" method="post">
                        <div>
                            <label>Imię</label>
                            <input type="text" class="imie" name="imie" placeholder="Imię i nazwisko osoby do kontaktu" required>

                            <label>Firma</label>
                            <input type="text" class="dane" name="dane" placeholder="NIP / Srona internetowa / Zakres / Metraż" required>
                            <div>
                                <button type="submit" name="form3">Zatwierdź</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="form-3-right">
                    <img class="img-stand" src="/wp-content/plugins/PWElements/media/zabudowa.webp" alt="zdjęcie przykładowej zabudowy"/>
                    <h5>Dedykowana Zabudowa Targowa</h5>
                    <a class="pwe-link btn pwe-btn btn-stand" target="_blank"'. 
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

            return $output;
        }
        
        if(!$atts['potwierdzenie']){
            session_unset();

            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            $output .= '
                <div class="form-1-top">
                    <image class="form-1-image" src="/wp-content/plugins/PWElements/media/badge_qr.jpg">
                    <div class="form-1">
                        <h2 class="h1 text-color-jevc-color">Twój bilet<br>na targi</h2>
                        <form id="registration" number="' . $x_form_id . '" method="post" action="' . $confirmation_url . '">
                            <input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">
                            <label>Email</label>
                            <input type="email" class="email" name="email" placeholder="Email" requiredd>
                            <p align="center" class="mail-error">&nbsp;</p>
                            <label>Numer telefonu</label>
                            <input type="tel" class="phone" name="phone" placeholder="Numer telefonu" requiredd>
                            <p align="center" class="tel-error">&nbsp;</p>
                            <div class="consent-container">
                                <input class="checkbox" type="checkbox" class="consent" name="consent" requiredd>
                                <span class="consent-text">
                                    Zgoda na przetwarzanie przez PTAK WARSAW EXPO sp. z o.o. moich danych osobowych w celach marketingowych i wysyłki wiadomości.
                                </span>
                            </div>
                            <p align="center" class="cons-error">&nbsp;</p>
                            <button class="form-1-btn" type="submit" name="step-1-submit">Wyślij darmowy bilet</button>
                        </form>
                    </div>
                </div></div>
            ';
            $inner_array = array (
                'form_id' => $x_form_id,
            );

            $js_file = plugins_url('js/form-checker.js', __FILE__);
            $js_version = filemtime(plugin_dir_path(__FILE__) . 'js/form-checker.js');
            wp_enqueue_script('form-checker-js', $js_file, array('jquery'), $js_version, true);
            wp_localize_script('form-checker-js', 'inner', $inner_array );

            return $output;
        }
    }
}