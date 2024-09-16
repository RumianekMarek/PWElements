<?php
/*
 * Plugin Name: PWE Elements
 * Plugin URI: https://github.com/RumianekMarek/PWElements
 * Description: Adding a PWE elements to the website.
 * Version: 2.1.6
 * Author: Marek Rumianek
 * Author URI: github.com/RumianekMarek
 * Update URI: https://api.github.com/repos/RumianekMarek/PWElements/releases/latest
 */



// Defining path constants
// define('PWE_ELEMENTS_PATH', plugin_dir_path(__FILE__)); 
// define('PWE_ELEMENTS_URL', plugin_dir_url(__FILE__));

class PWElementsPlugin {
    public $PWElements;
    public $PWELogotypes;
    public $PWEHeader;
    public $PWECatalog;
    public $PWEDisplayInfo;
    public $PWEMediaGallery;
    // public $PWEQRActive;
    public $PWEExhibitorGenerator;

    public function __construct() {
        // Czyszczenie pamięci wp_rocket
        add_action( 'upgrader_process_complete', array( $this, 'clearWpRocketCacheOnPluginUpdate' ), 10, 2 );
        $this->initClasses();
        $this->init();
        // $this -> resendTicket();
    }

    private function initClasses() {

        // Helpers functions
        require_once plugin_dir_path(__FILE__) . 'pwefunctions.php';


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

        // require_once plugin_dir_path(__FILE__) . 'pweupdater.php';
        // $this->PWElementsUpdater = new PWElementsUpdater();

        // require_once plugin_dir_path(__FILE__) . 'qr-active/main-qr-active.php';
        // $this->PWEQRActive = new PWEQRActive();

        require_once plugin_dir_path(__FILE__) . 'includes/exhibitor-generator/exhibitor-generator.php';
        $this->PWEExhibitorGenerator = new PWEExhibitorGenerator();
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