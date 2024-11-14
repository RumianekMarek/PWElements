<?php

/*
 * Plugin Name: PWE Elements
 * Plugin URI: https://github.com/RumianekMarek/PWElements
 * Description: Adding a PWE elements to the website.
 * Version: 2.3.5
 * Author: Marek Rumianek
 * Author URI: github.com/RumianekMarek
 * Update URI: https://api.github.com/repos/RumianekMarek/PWElements/releases/latest
 */



class PWElementsPlugin {
    public $PWElements;
    public $PWELogotypes;
    public $PWEHeader;
    public $PWECatalog;
    public $PWEDisplayInfo;
    public $PWEMediaGallery;
    // public $PWEQRActive;
    public $GFAreaNumbersField;
    public $PWECatalog1;
    public $PWEExhibitorGenerator;
    public $PWEProfile;

    public function __construct() {
        // Czyszczenie pamięci wp_rocket
        add_action( 'upgrader_process_complete', array( $this, 'clearWpRocketCacheOnPluginUpdate' ), 10, 2 );
        $this->initClasses();
        $this->init();
        // $this -> resendTicket();
        add_filter('rocket_exclude_defer_js', array( $this, 'pwe_exclude_js_from_defer' ), 10, 2);
    }

    private function initClasses() {

        // Helpers functions
        require_once plugin_dir_path(__FILE__) . 'pwefunctions.php';

        require_once plugin_dir_path(__FILE__) . 'elements/pwelements-options.php';
        $this->PWElements = new PWElements();

        // require_once plugin_dir_path(__FILE__) . 'logotypes/logotypes.php';
        // $this->PWELogotypes = new PWELogotypes();

        // require_once plugin_dir_path(__FILE__) . 'header/header.php';
        // $this->PWEHeader = new PWEHeader();

        require_once plugin_dir_path(__FILE__) . 'katalog-wystawcow/main-katalog-wystawcow.php';
        $this->PWECatalog = new PWECatalog();

        // require_once plugin_dir_path(__FILE__) . 'display-info/main-display-info.php';
        // $this->PWEDisplayInfo = new PWEDisplayInfo();

        // require_once plugin_dir_path(__FILE__) . 'media-gallery/media-gallery.php';
        // $this->PWEMediaGallery = new PWEMediaGallery();

        require_once plugin_dir_path(__FILE__) . 'gf-upps/area-numbers/area_numbers_gf.php';
        $this->GFAreaNumbersField = new GFAreaNumbersField();

        // require_once plugin_dir_path(__FILE__) . 'qr-active/main-qr-active.php';
        // $this->PWEQRActive = new PWEQRActive();

        // require_once plugin_dir_path(__FILE__) . 'includes/katalog-wystawcow/main-katalog-wystawcow.php';
        // $this->PWECatalog = new PWECatalog();

        require_once plugin_dir_path(__FILE__) . 'includes/exhibitor-generator/exhibitor-generator.php';
        $this->PWEExhibitorGenerator = new PWEExhibitorGenerator();

        require_once plugin_dir_path(__FILE__) . 'includes/profile/profile.php';
        $this->PWEProfile = new PWEProfile();

        require_once plugin_dir_path(__FILE__) . 'includes/header/header.php';
        $this->PWEHeader = new PWEHeader();

        require_once plugin_dir_path(__FILE__) . 'includes/logotypes/logotypes.php';
        $this->PWELogotypes = new PWELogotypes();

        require_once plugin_dir_path(__FILE__) . 'includes/display-info/display-info.php';
        $this->PWEDisplayInfo = new PWEDisplayInfo();

        require_once plugin_dir_path(__FILE__) . 'includes/media-gallery/media-gallery.php';
        $this->PWEMediaGallery = new PWEMediaGallery();
    }

    function pwe_exclude_js_from_defer($excluded_files) {
        $excluded_files[] = '/wp-content/plugins/PWElements/assets/three-js/three.min.js';
        $excluded_files[] = '/wp-content/plugins/PWElements/assets/three-js/GLTFLoader.js';
        return $excluded_files;
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

    private function getGithubKey() {
        global $wpdb;
    
        $table_name = $wpdb->prefix . 'custom_klavio_setup';
        if ($wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $table_name)) != $table_name) {
            return null;
        }

        $github_pre = $wpdb->prepare("SELECT klavio_list_id FROM $table_name WHERE klavio_list_name = %s", 'github_secret');
        $github_result = $wpdb->get_results($github_pre);
        
        if (!empty($github_result)) {
            return $github_result[0]->klavio_list_id;
        } else {
            return null;
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

        if (self::getGithubKey()){
            $myUpdateChecker->setAuthentication(self::getGithubKey());
        }
        $myUpdateChecker->getVcsApi()->enableReleaseAssets();
    }
}

// Inicjalizacja wtyczki jako obiektu klasy
$PWElementsPlugin = new PWElementsPlugin();