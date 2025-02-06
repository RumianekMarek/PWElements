<?php

/*
 * Plugin Name: PWE Elements
 * Plugin URI: https://github.com/RumianekMarek/PWElements
 * Description: Adding a PWE elements to the website.
 * Version: 2.4.9.1
 * Author: Marek Rumianek
 * Author URI: github.com/RumianekMarek
 * Update URI: https://api.github.com/repos/RumianekMarek/PWElements/releases/latest
 */



class PWElementsPlugin {
    public $PWEStyleVar;
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
        // Clearing wp_rocket cache
        add_action( 'upgrader_process_complete', array( $this, 'clearWpRocketCacheOnPluginUpdate' ), 10, 2 );

        // Initialize classes
        $this->initClasses();
        $this->init();

        // Send CSS variables to <head>
        add_action('wp_head', array($this->PWEStyleVar, 'pwe_enqueue_style_var'), 1);

        // Add main CSS to wp_enqueue_scripts
        add_action('wp_enqueue_scripts', array($this, 'pwe_enqueue_styles'));

        // $this -> resendTicket();

        // Exclude JS from lazy loading in WP Rocket
        add_filter('rocket_exclude_defer_js', array( $this, 'pwe_exclude_js_from_defer' ), 10, 2);
    }

    public function pwe_enqueue_styles() {
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'pwe-style.css');
        wp_enqueue_style(
            'pwe-main-styles',
            plugin_dir_url(__FILE__) . 'pwe-style.css',
            array(),
            $css_version,
            'all'
        );
    }

    private function initClasses() {

        if (is_admin()) {
            // Admin menu
            include_once plugin_dir_path(__FILE__) . 'includes/settings/admin-menu.php';
            // Settings nav menu
            include_once plugin_dir_path(__FILE__) . 'includes/settings/nav-menu-settings.php';
        }

        // Helpers functions
        require_once plugin_dir_path(__FILE__) . 'pwefunctions.php';

        // Variables of styles
        require_once plugin_dir_path(__FILE__) . 'pwe-style-var.php';
        $this->PWEStyleVar = new PWEStyleVar();

        require_once plugin_dir_path(__FILE__) . 'includes/nav-menu/nav-menu.php';
        $this->pweNavMenu = new pweNavMenu();

        require_once plugin_dir_path(__FILE__) . 'elements/pwelements-options.php';
        $this->PWElements = new PWElements();

        require_once plugin_dir_path(__FILE__) . 'gf-upps/area-numbers/area_numbers_gf.php';
        $this->GFAreaNumbersField = new GFAreaNumbersField();

        // require_once plugin_dir_path(__FILE__) . 'qr-active/main-qr-active.php';
        // $this->PWEQRActive = new PWEQRActive();

        require_once plugin_dir_path(__FILE__) . 'includes/katalog-wystawcow/main-katalog-wystawcow.php';
        $this->PWECatalog = new PWECatalog();

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

        require_once plugin_dir_path(__FILE__) . 'includes/registration/registration.php';
        $this->PWERegistration = new PWERegistration();

        require_once plugin_dir_path(__FILE__) . 'includes/map/map.php';
        $this->PWEMap = new PWEMap();

        require_once plugin_dir_path(__FILE__) . 'backend/shortcodes.php';
    }

    function pwe_exclude_js_from_defer($excluded_files) {
        $excluded_files[] = '/wp-content/plugins/PWElements/elements/js/exclusions.js';
        $excluded_files[] = '/wp-content/plugins/PWElements/assets/three-js/three.min.js';
        $excluded_files[] = '/wp-content/plugins/PWElements/assets/three-js/GLTFLoader.js';
        $excluded_files[] = '/wp-content/plugins/PWElements/includes/nav-menu/assets/script.js';
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