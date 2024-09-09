<?php
/*
 * Plugin Name: PWE Elements
 * Plugin URI:
 * Description: Adding a new element to the website PRO.
 * Version: 2.1.0
 * Author: Marek Rumianek
 * Author URI: github.com/RumianekMarek
 */

class PWElementsPlugin {
    public $PWElements;
    public $PWELogotypes;
    public $PWEHeader;
    public $PWECatalog;
    public $PWEDisplayInfo;
    public $PWEMediaGallery;
    // public $PWEQRActive;

    public function __construct() {
        // Czyszczenie pamięci wp_rocket
        add_action( 'upgrader_process_complete', array( $this, 'clearWpRocketCacheOnPluginUpdate' ), 10, 2 );
        $this->initClasses();
        $this->init();
        // $this -> resendTicket();

    }
// public function resendTicket() {
//     // Dodajemy walidację dla pola e-mail
//     add_filter('gform_field_validation', function($result, $value, $form, $field) {
//         // Określone ścieżki, na których ma działać walidacja
//         $allowed_paths = array('/', '/rejestracja/', '/en/', '/en/registration/');

//         // Sprawdzenie, czy bieżąca strona jest jedną z dozwolonych ścieżek i czy pole to email
//         if (in_array($_SERVER['REQUEST_URI'], $allowed_paths) && $field->type === 'email' && defined('ICL_LANGUAGE_CODE')) {

//             // Pobieramy wartość e-mail i normalizujemy
//             $email = trim(strtolower($value));

//             // Pobieranie wpisów z formularza na podstawie adresu e-mail
//             $entries = GFAPI::get_entries($form['id'], array('field_filters' => array(
//                 array(
//                     'key'   => $field->id,
//                     'value' => $email
//                 )
//             )));

//             if (!empty($entries)) {
//                 // Zakodowanie ID formularza i pierwszego wpisu (przyjmujemy pierwszy wpis z wyniku)
//                 $entry_id = $entries[0]['id'];
//                 $form_id = $form['id'];

//                 // Szyfrowanie danych formularza i wpisu (base64)
//                 $data_to_encrypt = base64_encode($form_id . ',' . $entry_id);

//                 // Sprawdzanie języka i generowanie odpowiedniego linku oraz komunikatu
//                 if (ICL_LANGUAGE_CODE === 'pl') {
//                     // Link dla polskiego
//                     $resend_link = '<a href="/resend/?data=' . urlencode($data_to_encrypt) . '" style="border: 2px solid black; padding: 0px 0px; display: block; max-width: 110px; text-align: center; margin: 5px auto; border-radius: 5px;">Odzyskaj bilet</a>';
//                     $result['message'] = '<p style="font-size: 11px; margin-top: 5px;">Wygląda na to, że Twój adres e-mail został już użyty. ' . $resend_link . '</p>';
//                 } elseif (ICL_LANGUAGE_CODE === 'en') {
//                     // Link dla angielskiego
//                     $resend_link = '<a href="/en/resend/?data=' . urlencode($data_to_encrypt) . '" style="border: 2px solid black; padding: 0px 0px; display: block; max-width: 110px; text-align: center; margin: 5px auto; border-radius: 5px;">Resend Ticket</a>';
//                     $result['message'] = '<p style="font-size: 11px; margin-top: 5px;">It looks like your email address has already been used. ' . $resend_link . '</p>';
//                 }
//                 // Ustawiamy wynik walidacji na fałszywy tylko dla pola e-mail
//                 $result['is_valid'] = false;
//             }
//         }
//         return $result; // Zwracamy oryginalny wynik walidacji, co pozwala na walidację innych pól
//     }, 10, 4);

//     // Dodajemy filtr zmieniający komunikat o błędzie przy wysyłaniu formularza
//     add_filter('gform_validation_message', function($message, $form) {
//         // Sprawdzanie języka strony
//         if (defined('ICL_LANGUAGE_CODE')) {
//             if (ICL_LANGUAGE_CODE === 'pl') {
//                 // Zmiana komunikatu błędu dla wersji polskiej
//                 return "<div class='validation_error'>Znaleziono błędy w formularzu. Proszę sprawdzić poniższe pola.</div>";
//             } elseif (ICL_LANGUAGE_CODE === 'en') {
//                 // Zmiana komunikatu błędu dla wersji angielskiej
//                 return "<div class='validation_error'>Errors were found in the form. Please check the fields below.</div>";
//             }
//         }
//         return $message; // Zwracamy oryginalny komunikat, jeśli język nie jest obsługiwany
//     }, 10, 2);
// }

    private function initClasses() {
        require_once plugin_dir_path(__FILE__) . 'elements/pwelements-options.php';
        $this->PWElements = new PWElements();

        require_once plugin_dir_path(__FILE__) . 'logotypes/logotypes.php';
        $this->PWELogotypes = new PWELogotypes();

        require_once plugin_dir_path(__FILE__) . 'header/header.php';
        $this->PWEHeader = new PWEHeader();

        require_once plugin_dir_path(__FILE__) . 'katalog-wystawcow/main-katalog-wystawcow.php';
        $this->PWECatalog = new PWECatalog();

        require_once plugin_dir_path(__FILE__) . 'display-info/main-display-info.php';
        $this->PWEDisplayInfo = new PWEDisplayInfo();

        require_once plugin_dir_path(__FILE__) . 'media-gallery/media-gallery.php';
        $this->PWEMediaGallery = new PWEMediaGallery();

        require_once plugin_dir_path(__FILE__) . 'gf-upps/area-numbers/area_numbers_gf.php';
        $this->GFAreaNumbersField = new GFAreaNumbersField();

        // require_once plugin_dir_path(__FILE__) . 'qr-active/main-qr-active.php';
        // $this->PWEQRActive = new PWEQRActive();
    }

    // Czyszczenie pamięci wp_rocket
    public function clearWpRocketCacheOnPluginUpdate( $upgrader_object, $options ) {
        $plugin = isset( $options['plugin'] ) ? $options['plugin'] : '';
        // Sprawdź, czy zaktualizowana wtyczka to twoja wtyczka
        if ( 'PWElements/pwelements.php' === $plugin ) {
            // Sprawdź, czy WP Rocket jest aktywny
            if ( function_exists( 'rocket_clean_domain' ) ) {
                // Wywołaj funkcję czyszczenia pamięci podręcznej WP Rocket
                rocket_clean_domain();
            }
        }
    }

    private function init() {
        // Adres autoupdate
        include( plugin_dir_path( __FILE__ ) . 'plugin-update-checker/plugin-update-checker.php');

        $myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
            'https://github.com/RumianekMarek/PWElements',
            __FILE__,
            'PWElements'
        );

        $myUpdateChecker->getVcsApi()->enableReleaseAssets();
    }
}

// Inicjalizacja wtyczki jako obiektu klasy
$PWElementsPlugin = new PWElementsPlugin();