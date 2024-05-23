<?php
/*
 * Plugin Name: PWE Elements
 * Plugin URI:
 * Description: Adding a new element to the website PRO.
 * Version: 1.6.4
 * Author: Marek Rumianek
 * Author URI: github.com/RumianekMarek
 */

class PWElementsPlugin {
    public function __construct() {
        // Czyszczenie pamięci wp_rocket
        add_action( 'upgrader_process_complete', array( $this, 'clearWpRocketCacheOnPluginUpdate' ), 10, 2 );
        $this->initClasses();
        $this->init();
    }

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

        // require_once plugin_dir_path(__FILE__) . 'gf-upps/area-numbers/area_numbers_gf.php';
        // $this->GFAreaNumbersField = new GFAreaNumbersField();
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