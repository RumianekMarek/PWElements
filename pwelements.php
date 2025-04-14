<?php

/*
 * Plugin Name: PWE Elements
 * Plugin URI: https://github.com/RumianekMarek/PWElements
 * Description: Adding a PWE elements to the website.
 * Version: 2.5.8
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
    public $PWEStore;
    public $PWEConferenceCap;

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

        // List of JavaScript files to exclude
        $excluded_js_files = [
            '/wp-content/plugins/PWElements/elements/js/exclusions.js',
            '/wp-content/plugins/PWElements/assets/three-js/three.min.js',
            '/wp-content/plugins/PWElements/assets/three-js/GLTFLoader.js',
            '/wp-content/plugins/PWElements/includes/nav-menu/assets/script.js',
        ];

        // Excluding JS files from delayed loading (delay JS)
        add_filter('rocket_delay_js_exclusions', function ($excluded_files) use ($excluded_js_files) {
            return array_merge((array) $excluded_files, $excluded_js_files);
        });

        // Excluding JS files from defer (lazy loading)
        add_filter('rocket_exclude_defer_js', function ($defer_files) use ($excluded_js_files) {
            return array_merge((array) $defer_files, $excluded_js_files);
        }, 10, 1);

        add_filter( 'the_content', array($this, 'add_date_to_post') );
    }

    public function add_date_to_post( $content ) {
        if ( is_single() && in_the_loop() && is_main_query() ) {
            $data_publikacji = get_the_date( 'j F Y' );
            $label = ( get_locale() === 'pl_PL' ) ? 'Data publikacji: ' : 'Date of publication: ';
            $content .= '<div class="pwe-post-date" style="font-style: italic; margin-top: 10px;">'. $label . esc_html( $data_publikacji ) . '</div>';
        }
        return $content;
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
            include_once plugin_dir_path(__FILE__) . 'includes/settings/general-settings.php';
            // Settings nav menu
            include_once plugin_dir_path(__FILE__) . 'includes/settings/nav-menu-settings.php';
        }

        // Helpers functions
        require_once plugin_dir_path(__FILE__) . 'pwefunctions.php';

        // Shortcodes from CAP
        require_once plugin_dir_path(__FILE__) . 'backend/shortcodes.php';

        // Variables of styles
        require_once plugin_dir_path(__FILE__) . 'pwe-style-var.php';
        $this->PWEStyleVar = new PWEStyleVar();

        require_once plugin_dir_path(__FILE__) . 'includes/nav-menu/nav-menu.php';
        $this->pweNavMenu = new pweNavMenu();

        require_once plugin_dir_path(__FILE__) . 'elements/pwelements-options.php';
        $this->PWElements = new PWElements();

        require_once plugin_dir_path(__FILE__) . 'gf-upps/area-numbers/area_numbers_gf.php';
        $this->GFAreaNumbersField = new GFAreaNumbersField();

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

        require_once plugin_dir_path(__FILE__) . 'includes/store/store.php';
        $this->PWEStore = new PWEStore();

        require_once plugin_dir_path(__FILE__) . 'includes/conference-cap/conference_cap.php';
        $this->PWEConferenceCap = new PWEConferenceCap();

        if ($_SERVER['HTTP_HOST'] === 'warsawexpo.eu' || $_SERVER['HTTP_HOST'] === 'rfl.warsawexpo.eu') {
            require_once plugin_dir_path(__FILE__) . 'includes/calendar/calendar.php';
            $this->PWECalendar = new PWECalendar();
        }

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

class CAPDatabase {

    private static function connectToDatabaseFairs() {
        // Initialize connection variables
        $cap_db = null;
        
        // Set connection data depending on the server
        if (isset($_SERVER['SERVER_ADDR'])) {
            if ($_SERVER['SERVER_ADDR'] === '94.152.207.180') {
                $database_host = 'localhost';
                $database_name = defined('PWE_DB_NAME_180') ? PWE_DB_NAME_180 : '';
                $database_user = defined('PWE_DB_USER_180') ? PWE_DB_USER_180 : '';
                $database_password = defined('PWE_DB_PASSWORD_180') ? PWE_DB_PASSWORD_180 : '';
            } else {
                $database_host = 'localhost';
                $database_name = defined('PWE_DB_NAME_93') ? PWE_DB_NAME_93 : '';
                $database_user = defined('PWE_DB_USER_93') ? PWE_DB_USER_93 : '';
                $database_password = defined('PWE_DB_PASSWORD_93') ? PWE_DB_PASSWORD_93 : '';
            }
        }

        // Check if there is complete data for connection
        if ($database_user && $database_password && $database_name && $database_host) {
            try {
                $cap_db = new wpdb($database_user, $database_password, $database_name, $database_host);
            } catch (Exception $e) {
                return false;
                if (current_user_can("administrator") && !is_admin()) {
                    echo '<script>console.error("Błąd połączenia z bazą danych: '. addslashes($e->getMessage()) .'")</script>';
                }
            }
        } else {
            return false;
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Nieprawidłowe dane połączenia z bazą danych.")</script>';
            }
        }
    
        // Check for connection errors
        if (!$cap_db->dbh || mysqli_connect_errno()) {
            return false;
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd połączenia MySQL: '. addslashes(mysqli_connect_error()) .'")</script>';
            }
        }
    
        return $cap_db;
    }
    
    public static function getDatabaseDataFairs() {
        // Database connection
        $cap_db = self::connectToDatabaseFairs();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }
    
        // Retrieving data from the database
        $results = $cap_db->get_results("SELECT * FROM fairs");
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }
    
        return $results;
    }    

}

// Global function
function pwe_fairs() {
    return CAPDatabase::getDatabaseDataFairs();
}

global $pwe_fairs;
$pwe_fairs = pwe_fairs(); 

// Inicjalizacja wtyczki jako obiektu klasy
$PWElementsPlugin = new PWElementsPlugin();