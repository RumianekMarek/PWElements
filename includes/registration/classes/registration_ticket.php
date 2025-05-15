<?php

/**
 * Class PWERegistrationTicket
 * Extends PWEProfile class and defines a custom Visual Composer element.
 */
class PWERegistrationTicket extends PWERegistration {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
        add_filter('gform_pre_render', array($this, 'hideFieldsBasedOnAdminLabel'));
    }

    /**
     * Pobiera ID pola na podstawie jego Admin Label.
     *
     * @param array $form Formularz Gravity Forms jako tablica
     * @param string $admin_label Etykieta administratora pola (Admin Label)
     * @return int|null ID pola lub null, jeśli nie znaleziono
     */
    public static function getFieldIdByAdminLabel($form, $admin_label) {
        foreach ($form['fields'] as $field) {
            if (isset($field->adminLabel) && $field->adminLabel === $admin_label) {
                error_log('Found field ID ' . $field->id . ' for admin label: ' . $admin_label);
                return $field->id;
            }
        }
        error_log('No field found for admin label: ' . $admin_label);
        return null;
    }

    /**
     * Ukrywa pola w formularzu na podstawie etykiety admina.
     *
     * @param array $form Formularz Gravity Forms
     * @return array Zaktualizowany formularz
     */
    public function hideFieldsBasedOnAdminLabel($form) {
        if (is_page('rejestracja')) {
            foreach ($form['fields'] as &$field) {
                if (in_array($field->adminLabel, ['name', 'street', 'house', 'post', 'city'])) {
                    $field->visibility = 'hidden';
                }
            }
        }
        return $form;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     *
     * @param array @atts options
     */
    public static function output($atts, $registration_type, $registration_form_id) {
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white');
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$main2_color);

        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        $ticket_link = !empty($atts['ticket_link']) ? $atts['ticket_link'] : 'ticket';

        if (isset($_SERVER['argv'][0])) {
            $source_utm = $_SERVER['argv'][0];
        } else {
            $source_utm = '';
        }


        // CSS <----------------------------------------------------------------------------------------------<
        require_once plugin_dir_path(dirname( __FILE__ )) . 'assets/style.php';

        $output .= '
            <div id="pweRegistrationTicket" class="registration-ticket">
              <h1 class="registration-ticket__title">'. self::languageChecker('Opcje biletów dla odwiedzających:', 'Ticket options for visitors:') .'</h1>
              <div class="registration-ticket-container">
                <div class="registration-ticket__option registration-ticket__option--standard">
                  <div class="ticket-card__label">'. self::languageChecker('Najczęstszy wybór', 'Most common choice') .'</div>
                  <div class="ticket-card__name">'. self::languageChecker('Bilet Branżowy', 'Trade Pass') .'</div>

                  <div class="ticket-card">
                    <div class="ticket-card__price">
                      <h2 class="ticket-card__price-value">0 PLN</h2>
                      <p class="ticket-card__note">'. self::languageChecker('* po krótkiej rejestracji', '* after a short registration') .'</p>
                    </div>

                    <div class="ticket-card__details">
                      <p class="ticket-card__details-title">'. self::languageChecker('Bilet upoważnia do:', 'With this ticket, you get:') .'</p>
                      <ul class="ticket-card__benefits">
                        <li>'. self::languageChecker('<strong>wejścia na targi po rejestracji przez 3 dni</strong>', '<strong>access to the trade fair for all 3 days upon registration</strong>') .'</li>
                        <li>'. self::languageChecker('<strong>możliwość udziału w konferencjach</strong> lub warsztatach na zasadzie “wolnego słuchacza”', '<strong>the chance to join conferences</strong> or workshops as a listener') .'</li>
                        <li>'. self::languageChecker('darmowy parking', 'free parking') .'</li>
                      </ul>
                      <div class="pwe-registration-form">
                        [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                      </div>
                    </div>
                  </div>
                </div>

                <div class="registration-ticket__option registration-ticket__option--business">
                  <img src="/wp-content/plugins/PWElements/media/fast-track.webp">
                  <div class="ticket-card__name">'. self::languageChecker('Business Priority Pass', 'Business Priority Pass') .'</div>
                  <div class="ticket-card">
                    <div class="ticket-card__price">
                      <h2 class="ticket-card__price-value">249 PLN</h2>
                      <p class="ticket-card__note">'. self::languageChecker('lub poproś o zaproszenie wystawcę', 'or request an invitation from an exhibitor') .'</p>
                      <a class="exhibitor-catalog" href="'. self::languageChecker('/katalog-wystawcow', '/en/exhibitors-catalog/') .'">'. self::languageChecker('katalog wystawców', 'exhibitor catalog') .'</a>
                    </div>

                    <div class="ticket-card__details">
                      <h2 class="ticket-card__details-title">'. self::languageChecker('Bilet upoważnia do:', 'With this ticket, you get:') .'</h2>
                      <ul class="ticket-card__benefits">
                        <li>'. self::languageChecker('<strong>fast track</strong> - szybkie wejście na targi dedykowaną bramką przez 3 dni', '<strong>fast track access</strong> – skip the line and enter the trade fair through a dedicated priority gate for all 3 days') .'</li>
                        <li>'. self::languageChecker('<strong>imienny pakiet</strong> - targowy przesyłany kurierem przed wydarzeniem', '<strong>Personalized trade fair package</strong> - delivered by courier to your address before the event') .'</li>
                        <li>'. self::languageChecker('<strong>welcome pack</strong> - przygotowany specjalnie przez wystawców', '<strong>welcome pack</strong> - a special set of materials and gifts prepared by exhibitors') .'</li>
                        <li>'. self::languageChecker('obsługa concierge', 'Concierge service') .'</li>
                        <li>'. self::languageChecker('możliwość udziału w konferencjach i  warsztatach', 'Access to conferences and workshops') .'</li>
                        <li>'. self::languageChecker('darmowy parking', 'Free parking') .'</li>
                      </ul>
                      <div class="ticket-card__details_button">
                        <a href="'.$ticket_link.'" class="ticket-card__cta">
                          '. self::languageChecker('Kup bilet', 'Buy a ticket') .'
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            ';


        return $output;
    }
}