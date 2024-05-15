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
    public static function x_form_check($x_form_id) {

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
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $confirmation_url = ($atts['confirmation_url']) ? $atts['confirmation_url'] : '/potwierdzenie-rejestracji';
        $x_form_id = self::findFormsID($atts['x_form_name']);
        var_dump($_POST);

        $output = '
                <style>
                    #xForm {
                        background-image: url(/wp-content/plugins/PWElements/media/badgemockup.jpg);
                        height: 790px;
                        background-size: cover;

                        img, div.form-1{
                            width: 430px;
                            position: absolute;
                            left: 50%;
                            transform: translateX(-50%);
                        }
                        .form-1 {
                            height:550px;
                            padding:10px 75px;
                            background-color: lightgray;
                            top: 217px;

                            input:not(.checkbox){
                                margin: 9px 0 0;
                                width:100%;
                            }
                        }
                        .form-1-image {
                            top: 160px;
                            z-index: 10;
                        }
                        #registration{
                            margin-top:36px;
                        }
                        label{
                            font-weight: 700;
                            font-size: 15px;
                        }
                        .consent-container {
                            display: flex;
                            flex-direction: row;
                            align-items: center;
                        }
                        .form3-half {
                            display: flex;
                            gap: 10px;
                        }
                    }
                </style>
                <div id="xForm">
            ';

        if (isset($_POST['step-1-submit'])) {
            $_SESSION['step'] = 'step-1-submit';

            self::x_form_check($x_form_id);

            $output .= '
                <div class="form-2">
                    <h5> Krok 2 z 3</h5>
                    <h2 class="h1 text-color-jevc-color">Twój bilet został<br>wygenerowany<br>pomyślnie!</h2>
                    <p>Otrzymasz go na wskazany adres e-mail.<br>Może to potrwać kilka minut.</p>
                    <h3>Czy chcesz zostać<br>wystawcą<br>targów Recycling Tech?
                    <form id="exhibitor-question" method="post" action="">
                        <button class="btn exhibitor-yes" name="exhibitor-yes">Tak, jestem zainteresowany</button>
                        <button class="btn exhibitor-no" name="exhibitor-no">Nie dziękuję</button>
                    </form>
                </div></div>
            ';
            
            return $output;
        }

        if (isset($_POST['exhibitor-no'])){

            $output .= '

                <div class="form-3">
                    <h3>Podaj adres, na który mamy wysłać<br>darmowy pakiet powitalny VIP</h3>
                    <p>Otrzymasz bezpłatny spersonalizowany identyfikator wraz z planem/harmonogramem targów oraz kartę parkingową.</p>
                    <form id="form3" action="" method="post">
                        <div class="form3-half">
                            <input type="text" class="imie" name="imie" placeholder="Imię">
                            <input type="text" class="nazwisko" name="nazwisko" placeholder="Nazwisko">
                        </div>
                        <input type="text" class="ulica" name="ulica">
                        <div class="form3-half">
                            <input type="text" class="budynek" name="budynek" placeholder="Numer budynku">
                            <input type="text" class="mieszkanie" name="mieszkanie" placeholder="Numer mieszkania">
                        </div>
                        <div class="form3-half">
                            <input type="text" class="kod_pocztowy" name="kod_pocztowy" placeholder="Kod pocztowy">
                            <input type="text" class="miasto" name="miasto" placeholder="Miasto">
                        </div>
                        <button name="form3" class="btn">Wyslij</button>
                    </form>
                </div></div>

            ';

            return $output;
        }

        if (isset($_POST['form3'])){
            $entry = GFAPI::get_entry($_SESSION['entry_id']);

            $entry[4] = $_POST['imie'] . ' ' . $_POST['nazwisko'];
            $entry[5] = $_POST['ulica'] . ' ' . $_POST['budynek'] . ' / ' . $_POST['mieszkanie'] . ';' . $_POST['kod_pocztowy'] . ' ' . $_POST['miasto'];

            $updated = GFAPI::update_entry($entry);
        }

        $output .= '
            <image class="form-1-image" src="/wp-content/plugins/PWElements/media/badge_head.png">
            <div class="form-1">
                <h2 class="h1 text-color-jevc-color">Twój bilet<br>na targi</h2>
                <form id="registration" method="post" action="' . $confirmation_url . '">
                    <label>Email</label>
                    <input type="email" class="email" name="email" placeholder="Email" required>
                    <p class="mail-error">&nbsp;</p>
                    <label>Numer telefonu</label>
                    <input type="tel" class="phone" name="phone" placeholder="Numer telefonu" required>
                    <p class="tel-error">&nbsp;</p>
                    <div class="consent-container">
                        <input class="checkbox" type="checkbox" class="consent" name="consent" required>
                        <span class="consent-text">
                            Zgoda na przetwarzanie przez PTAK WARSAW EXPO sp. z o.o. moich danych osobowych w celach marketingowych i wysyłki wiadomości.
                        </span>
                    </div>
                    <button name="step-1-submit" class="btn">Wyślij darmowy bilet</button>
                </form>
            </div></div>
        ';

        $js_file = plugins_url('js/form-checker.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'js/form-checker.js');
        wp_enqueue_script('form-checker-js', $js_file, array('jquery'), $js_version, true);

        return $output;
    }
}