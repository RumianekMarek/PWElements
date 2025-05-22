<?php

/**
 * Class PWERegistrationVisitors
 * Extends PWEProfile class and defines a custom Visual Composer element.
 */
class PWERegistrationVisitors extends PWERegistration {

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


        if (isset($_SERVER['argv'][0])) {
            $source_utm = $_SERVER['argv'][0];
        } else {
            $source_utm = '';
        }

        if (strpos($source_utm, 'utm_source=premium') !== false || strpos($source_utm, 'utm_source=platyna') !== false) {
            $badgevipmockup = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/badge-mockup.webp') ? '/doc/badge-mockup.webp' : '');
        } else {
            if (get_locale() == 'pl_PL') {
                $badgevipmockup = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/badgevipmockup.webp') ? '/doc/badgevipmockup.webp' : '');
            } else {
                $badgevipmockup = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/badgevipmockup-en.webp') ? '/doc/badgevipmockup-en.webp' : '/doc/badgevipmockup.webp');
            }
        }

        // CSS <----------------------------------------------------------------------------------------------<
        require_once plugin_dir_path(dirname( __FILE__ )) . 'assets/style.php';

        if (strpos($source_utm, 'utm_source=byli') !== false || strpos($source_utm, 'utm_source=premium') !== false || strpos($source_utm, 'utm_source=platyna') !== false) {
            $output .= '
            <div id="pweRegistration" class="pwe-registration vip">
                <div class="pwe-reg-column pwe-mockup-column">
                    <img src="'. $badgevipmockup .'">
                </div>
                <div class="pwe-reg-column pwe-registration-column">
                    <div class="pwe-registration-step-text">
                        <p>'. self::languageChecker('Krok 1 z 2', 'Step 1 of 2') .'</p>
                    </div>
                    <div class="pwe-registration-title">
                        <h4>'. self::languageChecker('Twój bilet na targi', 'Your ticket to the trade fair') .'</h4>
                    </div>
                    <div class="pwe-registration-form">
                        [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                    </div>
                </div>
            </div>';
        } else {
            $output .= '
            <div id="pweRegistration" class="pwe-registration">
                <div class="pwe-registration-column">
                    <div id="pweForm">
                        <img class="form-badge-top" src="/wp-content/plugins/PWElements/media/badge_top.png">
                        <div class="form-container pwe-registration">
                            <div class="form-badge-header">
                                <h2 class="form-header-title">'. self::languageChecker('Twój bilet<br>na targi', 'Your ticket<br>to the fair') .'</h2>
                                <a href="https://warsawexpo.eu/" target="_blank"><img class="form-header-image-qr" src="/wp-content/plugins/PWElements/media/logo_pwe_black.webp"></a>
                            </div>
                            <img class="form-badge-left" src="/wp-content/plugins/PWElements/media/badge_left.png">
                            <img class="form-badge-bottom" src="/wp-content/plugins/PWElements/media/badge_bottom.png">
                            <img class="form-badge-right" src="/wp-content/plugins/PWElements/media/badge_right.png">
                            <a href="https://warsawexpo.eu/" target="_blank"><img class="form-image-qr" src="/wp-content/plugins/PWElements/media/logo_pwe_black.webp"></a>
                            <div class="form">
                                <h2 class="form-title">'. self::languageChecker('Twój bilet<br>na targi', 'Your ticket<br>to the fair') .'</h2>
                                <div class="pwe-registration-form">
                                    [gravityform id="'. $registration_form_id .'" title="false" description="false" ajax="false"]
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>';
        }

        return $output;
    }
}