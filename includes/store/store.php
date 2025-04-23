<?php

class PWEStore extends PWECommonFunctions {

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        
        add_action('init', array($this, 'initVCMapPWEStore'));
        add_shortcode('pwe_store', array($this, 'PWEStoreOutput'));
    }

    /**
     * Initialize VC Map Elements.
     */
    public function initVCMapPWEStore() {
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __('PWE Store', 'pwe_store'),
                'base' => 'pwe_store',
                'category' => __('PWE Elements', 'pwe_store'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __DIR__ )) . 'backend/backendstyle.css',
                'admin_enqueue_js' => plugin_dir_url(dirname( __DIR__ )) . 'backend/backendscript.js',
            ));
        }
    }

    public function fairs_array() { 
        $pwe_groups_data = self::getDatabaseDataGroups(); 

        $edition_1 = [];
        $edition_2 = [];
        $edition_3 = [];
        $edition_b2c = [];

        foreach ($pwe_groups_data as $group) {
            if ($group->fair_group == "gr1") {
                $edition_1[] = $group->fair_domain;
            }
            if ($group->fair_group == "gr2") {
                $edition_2[] = $group->fair_domain;
            }
            if ($group->fair_group == "gr3") {
                $edition_3[] = $group->fair_domain;
            }
            if ($group->fair_group == "b2c") {
                $edition_b2c[] = $group->fair_domain;
            }
        }
        
        $editions = [
            "1"   => $edition_1,
            "2"   => $edition_2,
            "3"   => $edition_3,
            "b2c" => $edition_b2c
        ];
        
        $formatted_editions = [];
         
        foreach ($editions as $edition_key => $domains) {
            foreach ($domains as $domain) {
                $formatted_editions["edition_" . $edition_key][] = [
                    "domain"  => $domain,
                    "name"    => do_shortcode("[pwe_name_pl domain=\"$domain\"]"),
                    "desc"    => do_shortcode("[pwe_desc_pl domain=\"$domain\"]"),
                    "date"    => do_shortcode("[pwe_date_start domain=\"$domain\"]"),
                    "edition" => $edition_key
                ];
            }
        }

        return $formatted_editions;
    }

    /**
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('assets/style.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/style.css');
        wp_enqueue_style('pwe-store-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts(){
        $store_js_array = array(
            'trade_fair_name' => self::languageChecker(do_shortcode('[trade_fair_name]'), do_shortcode('[trade_fair_name_eng]')),
            'trade_fair_groups' => self::getDatabaseDataGroups()
        );

        $js_file = plugins_url('assets/script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/script.js');
        wp_enqueue_script('pwe-store-js', $js_file, array('jquery'), $js_version, true);
        wp_localize_script( 'pwe-store-js', 'store_js', $store_js_array );
    }

    public function connectToDatabase() {
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

    public function getDatabaseDataGroups() {
        // Database connection
        $cap_db = self::connectToDatabase();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }
    
        // Retrieving data from the database
        $results = $cap_db->get_results("SELECT fair_domain, fair_group FROM fairs");
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }
    
        return $results;
    } 
    
    public function getDatabaseDataStore() {
        // Database connection
        $cap_db = self::connectToDatabase();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }
    
        // Retrieving data from the database
        $results = $cap_db->get_results("SELECT * FROM shop");
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }
    
        return $results;
    } 

    public function getDatabaseDataStorePackages() {
        // Database connection
        $cap_db = self::connectToDatabase();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }
    
        // Retrieving data from the database
        $results = $cap_db->get_results("SELECT * FROM shop_packs");
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }
    
        return $results;
    } 

    public function getDatabaseMetaData() {
        // Database connection
        $cap_db = self::connectToDatabase();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }
    
        // Retrieving data from the database
        $results = $cap_db->get_results("SELECT * FROM meta_data");
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }
    
        return $results;
    } 

    public function price($product, $store_options, $pwe_meta_data, $category, $current_domain, $num_only = false) {
        if ($category == $product->prod_category && (self::lang_pl() ? !empty($product->prod_title_short_pl) : !empty($product->prod_title_short_en))) {
            foreach ($store_options as $domain_options) {
                if ($domain_options['domain'] === $current_domain) {
                    if (!empty($domain_options['options'])) {
                        $options = json_decode($domain_options['options'], true);
            
                        if (isset($options['products'])) {
                            foreach ($options['products'] as $key => $option) {
                                if ($product->prod_slug == $key) {
                                    // Prices
                                    $new_price_pl = $option['prod_price_pl'] ? $option['prod_price_pl'] : "";
                                    $new_price_en = $option['prod_price_en'] ? $option['prod_price_en'] : "";
            
                                    // Prices descriptions
                                    $new_price_desc_pl = $option['prod_price_desc_pl'] ? $option['prod_price_desc_pl'] : "";
                                    $new_price_desc_en = $option['prod_price_desc_en'] ? $option['prod_price_desc_en'] : "";
                                }
                            }
                        }

                        if (isset($options['options']['margin'])) {
                            $price_margin = ($options['options']['margin']);
                        }
                    }
        
                    break;
                }
            }
            
            $updated_price_pl = !empty($new_price_pl) ? $new_price_pl : $product->prod_price_pl;
            if (!empty($new_price_en)) {
                $updated_price_en = $new_price_en;
            } elseif (!empty($new_price_pl)) {
                $updated_price_en = $new_price_pl / $pwe_meta_data[0]->meta_data;
            } elseif (!empty($product->prod_price_en)) {
                $updated_price_en = $product->prod_price_en;
            } else {
                $updated_price_en = $product->prod_price_pl / $pwe_meta_data[0]->meta_data;
            }
            $updated_price_en = self::roundPrice($updated_price_en);

            $updated_price_desc_pl = !empty($new_price_desc_pl) ? $new_price_desc_pl : $product->prod_price_desc_pl;
            $updated_price_desc_en = !empty($new_price_desc_en) ? $new_price_desc_en : $product->prod_price_desc_en;

            $final_price_desc = self::lang_pl() ? $updated_price_desc_pl : $updated_price_desc_en;

            if ($price_margin) {
                $updated_price_pl = $updated_price_pl + ($updated_price_pl * ($price_margin / 100));
                $updated_price_en = $updated_price_en + ($updated_price_en * ($price_margin / 100));

                $updated_price_pl = self::roundPrice($updated_price_pl);
                $updated_price_en = self::roundPrice($updated_price_en);
            }

            if (!empty($updated_price_pl)) {
                $eur_price = $updated_price_pl / $pwe_meta_data[0]->meta_data;
                $eur_price = self::roundPrice($eur_price);

                $final_price = number_format((self::lang_pl() ? $updated_price_pl : (!empty($updated_price_en) ? $updated_price_en : $eur_price)), 0, ',', ' ') . ( self::lang_pl() ? ' zł ' : ' € ' );
            }
            
            $product_price = $final_price . ($num_only == true ? '' : $final_price_desc);
            $product_price = $num_only == true ? preg_replace('/[^0-9\.]/', '', $product_price) : $product_price;
            
            return $product_price;
        }
    }

    public function roundPrice($price) {
        if ($price >= 1000) {
            return round($price, -2);
        } else if ($price < 1000 && $price >= 100) {
            return round($price, -1);
        } else if ($price >= 50 && $price < 100) {
            return round($price, -1);
        } else {
            return round($price);
        }
    }
    
    /**
     * Output method for PWEStore shortcode.
     *
     * @return string
     */ 
    public function PWEStoreOutput() {  
        $pwe_store_data = self::getDatabaseDataStore(); 
        $pwe_store_packages_data = self::getDatabaseDataStorePackages();
        $pwe_meta_data = self::getDatabaseMetaData();   

        $categories = [];
        foreach ($pwe_store_data as $item) {
            $category = $item->prod_category;

            // Add the category to the array if it's not there yet
            if (!in_array($category, $categories)) {
                $categories[] = $category;
            }
        }

        $packages_categories = [];
        foreach ($pwe_store_packages_data as $item) {
            $packages_category = $item->packs_category;

            // Add the category to the array if it's not there yet
            if (!in_array($packages_category, $packages_categories)) {
                $packages_categories[] = $packages_category;
            }
        }

        $fairs_json = PWECommonFunctions::json_fairs();
        $store_options = [];
        foreach ($fairs_json as $fair) {
            $store_options[] = array(
                "domain" => $fair["domain"],
                "options" => $fair["shop"]
            );
        }

        // Get current domain
        $current_domain = do_shortcode('[trade_fair_domainadress]');

        $output = '
        <div id="pweStore" class="pwe-store">';
            
            require_once plugin_dir_path(__FILE__) . 'parts/store_header.php';

            require_once plugin_dir_path(__FILE__) . 'parts/store_product_details.php';

            require_once plugin_dir_path(__FILE__) . 'parts/store_cat_filter.php';

            require_once plugin_dir_path(__FILE__) . 'parts/store_product_card.php';

            require_once plugin_dir_path(__FILE__) . 'parts/store_fairs.php';

        $output .= '
        </div>
        
        <!-- Modal -->
        <div id="pweStoreModal" class="pwe-store__modal" style="display: none;">
            <div class="pwe-store__modal-content">
                <span class="pwe-store__modal-close-btn">&times;</span>
                <div class="pwe-store__modal-content-placeholder">
                    <!-- Tutaj dynamicznie wstawimy selectItem -->
                </div>
            </div>
        </div>';

        // if (current_user_can( "administrator" )) {
        //     $pwe_groups_data_json_encode = json_encode($pwe_groups_data);
        //     $pwe_store_data_json_encode = json_encode($pwe_store_data);
        //     $pwe_store_data_options_json_encode = json_encode($store_options);
        //     $pwe_store_packages_data_json_encode = json_encode($pwe_store_packages_data);
        //     $output .= '
        //     <script>
        //         document.addEventListener("DOMContentLoaded", function () {
        //             const pweGroups = ' . $pwe_groups_data_json_encode . ';
        //             const storeData = ' . $pwe_store_data_json_encode . ';
        //             const storeDataOptions = ' . $pwe_store_data_options_json_encode . ';
        //             const storePackagesData = ' . $pwe_store_packages_data_json_encode . ';
                    
        //             console.log(pweGroups);
        //             console.log(storeData);
        //             console.log(storeDataOptions);
        //             console.log(storePackagesData);
        //         });
        //     </script>';
        // }

        $output = do_shortcode($output);  
        
        return $output;
    }  
}