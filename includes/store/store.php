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

        $edition_1 = [
            "mr.glasstec.pl",
            "worldofbuildexpo.com", 
            "futureenergyweekpoland.com", 
            "industrialbuildingexpo.pl", 
            "filtratecexpo.com", 
            "chemtecpoland.com", 
            "lasertechnicapoland.com", 
            "coldtechpoland.com", 
            "warsawoptiexpo.com", 
            "funeralexpo.pl", 
            "coffeeeuropeexpo.com", 
            "pharmacyexpopoland.com", 
            "warsawwindowexpo.com", 
            "glasstechpoland.com", 
            "valvespumpsexpo.com", 
            "hairbarberweekpoland.com", 
            "concreteexpo.pl", 
            "automechanicawarsaw.com", 
            "fastechexpo.com", 
            "aiindustryexpo.com", 
            "medivisionforum.com", 
            "warsawprokitchen.com", 
            "aluminiumtechexpo.com", 
            "medinnovationsexpo.com", 
            "emobilityexpo.pl", 
            "worldofhydrogenexpo.com", 
            "warsawtoys.com", 
            "biopowerexpo.com", 
            "agrofarmaexpo.com", 
            "veterinaryexpopoland.com", 
            "isoltexexpo.com", 
            "polandsustainabilityexpo.com", 
            "solidsexpopoland.com", 
            "forestechexpopoland.com", 
            "lightexpo.pl", 
            "warsawclimatech.com", 
            "decarbonisationexpo.com", 
            "globalfoodexpo.pl", 
            "photonicsexpo.pl", 
            "waterexpopoland.com", 
            "warsawplastexpo.com", 
            "grindtechexpo.com", 
            "safetyrescueexpo.com", 
            "cybersecurityexpo.pl", 
            "pneumaticswarsaw.com", 
            "labotec.pl", 
            "coiltechexpo.com", 
            "autotuningshow.com", 
            "biurotexexpo.com", 
            "cosmopharmpack.com", 
            "huntingexpo.pl", 
            "warsawfleetexpo.com", 
            "warsawshopexpo.com", 
            "hotelequipmentexpo.com", 
            "bakerytechpoland.com", 
            "postdeliverylogisticsexpo.com", 
            "warsawgardentech.com", 
            "warsawspawellnessexpo.com", 
            "electroinstalexpo.com", 
            "wiretechpoland.com", 
            "tubetechnicpoland.com", 
            "bathceramicsexpo.com", 
            "warsawbusexpo.eu", 
            "centralnetargirolnicze.com"
        ];
        
        $edition_2 = [
            "esteticaexpo.com", 
            "automaticaexpo.com", 
            "batteryforumpoland.com", 
            "floorexpo.pl", 
            "door-tec.pl", 
            "furnitechexpo.pl", 
            "furniturecontractexpo.com", 
            "electronics-show.com", 
            "forumbhp.com", 
            "weldexpopoland.com", 
            "warsawprinttech.com", 
            "heatingtechexpo.com", 
            "recyclingexpo.pl", 
            "warsawsweettech.com", 
            "wodkantech.com", 
            "polandcoatings.com", 
            "gastroquickservice.com", 
            "warsawconstructionexpo.com", 
            "warsawtoolsshow.com", 
            "targirehabilitacja.pl", 
            "boattechnica.com", 
            "automotive-expo.eu", 
            "packagingpoland.pl", 
            "labelingtechpoland.com", 
            "warsawmedicalexpo.com", 
            "warsawsecurityexpo.com", 
            "foodtechexpo.pl", 
            "facadeexpo.pl", 
            "roofexpo.pl", 
            "poultrypoland.com", 
            "bioagropolska.com", 
            "fruitpolandexpo.com", 
            "warsawmetaltech.pl", 
            "maintenancepoland.com", 
            "controldrivespoland.com", 
            "intralogisticapoland.com", 
            "roboticswarsaw.com", 
            "compositepoland.com", 
            "smarthomeexpo.pl", 
            "warsawstone.com", 
            "woodwarsawexpo.com", 
            "beerwarsawexpo.com", 
            "winewarsawexpo.com", 
            "cleantechexpo.pl", 
            "buildoutdoorexpo.com", 
            "bioexpo.pl"
        ];
        
        $edition_3 = [
            "warsawpack.pl", 
            "mttsl.pl", 
            "warsawfoodexpo.pl", 
            "dentalmedicashow.pl", 
            "beautydays.pl", 
            "boatshow.pl", 
            "warsawhome.eu", 
            "warsawhomefurniture.com", 
            "warsawhomekitchen.com", 
            "warsawhomelight.com", 
            "warsawhometextile.com", 
            "warsawhomebathroom.com", 
            "warsawbuild.eu", 
            "industryweek.pl", 
            "solarenergyexpo.com", 
            "remadays.com", 
            "franczyzaexpo.pl", 
            "etradeshow.pl", 
            "warsawgardenexpo.com", 
            "warsawgiftshow.com", 
            "eurogastro.com.pl", 
            "worldhotel.pl", 
            "warsawhvacexpo.com"
        ];
        
        $edition_b2c = [
            "campercaravanshow.com", 
            "motorcycleshow.pl", 
            "animalsdays.eu", 
            "oldtimerwarsaw.com", 
            "fiwe.pl", 
            "ttwarsaw.pl", 
            "warsawmotorshow.com"
        ];
        
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
            'trade_fair_name' => self::languageChecker(do_shortcode('[trade_fair_name]'), do_shortcode('[trade_fair_name_eng]'))
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

    public function ceilPrice($price) {
        if ($price >= 1000) {
            return ceil($price / 100) * 100;
        } else if ($price < 1000 && $price >= 100) {
            return ceil($price / 10) * 10;
        } else if ($price >= 50 && $price <= 100) {
            return ceil($price / 10) * 10;
        } else {
            return ceil($price);
        }
    }
    
    /**
     * Output method for PWEStore shortcode.
     *
     * @return string
     */ 
    public function PWEStoreOutput() {  

        $pwe_store_data = self::getDatabaseDataStore(); 
        $pwe_meta_data = self::getDatabaseMetaData();

        $categories = [];

        foreach ($pwe_store_data as $item) {
            $category = $item->prod_category;

            // Add the category to the array if it's not there yet
            if (!in_array($category, $categories)) {
                $categories[] = $category;
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

        // echo '<pre>';
        // var_dump($pwe_store_data);
        // echo '</pre>';

        $output = '
        <div id="pweStore" class="pwe-store">
            
            <div class="pwe-store__main-section">
                <div class="pwe-store__main-section-header">
                    <img src="/wp-content/plugins/PWElements/media/store/'. (self::lang_pl() ? 'header_store_pl.webp' : 'header_store_en.webp') .'" alt="Header">
                </div>
                
                <span class="pwe-store__anchor"></span>';

                $category_header_info = [
                    [
                        'category' => 'premium',
                        'title' => self::lang_pl() 
                            ? 'ZWIĘKSZ SWÓJ POTENCJAŁ NA TARGACH: USŁUGI PREMIUM!' 
                            : 'INCREASE YOUR POTENTIAL AT TRADE FAIRS: PREMIUM SERVICES!',
                        'description' => self::lang_pl() 
                            ? 'Skorzystaj z wysokiej jakości rozwiązań, aby wyróżnić się wśród wystawców i przyciągnąć uwagę odwiedzających.' 
                            : 'Take advantage of high-quality solutions to stand out among exhibitors and attract the attention of visitors.',
                        'max_width' => '700px'
                    ],
                    [
                        'category' => 'marketing',
                        'title' => self::lang_pl() 
                            ? 'ZWIĘKSZ SWOJĄ WIDOCZNOŚĆ NA TARGACH: USŁUGI MARKETINGOWE!' 
                            : 'INCREASE YOUR VISIBILITY AT TRADE FAIRS: MARKETING SERVICES!',
                        'description' => self::lang_pl() 
                            ? 'Skorzystaj z profesjonalnych strategii marketingowych, aby dotrzeć do większej liczby klientów, zwiększyć rozpoznawalność swojej marki i maksymalnie wykorzystać potencjał targów.' 
                            : 'Use professional marketing strategies to reach more customers, increase your brand recognition and maximize the potential of trade fairs.',
                        'max_width' => '1200px'
                    ],
                    [
                        'category' => 'social-media',
                        'title' => self::lang_pl() 
                            ? 'ZWIĘKSZ SWOJĄ WIDOCZNOŚĆ ONLINE: USŁUGI SOCIAL MEDIA!' 
                            : 'INCREASE YOUR ONLINE VISIBILITY: SOCIAL MEDIA SERVICES!',
                        'description' => self::lang_pl() 
                            ? 'Wykorzystaj potencjał mediów społecznościowych, aby dotrzeć do większej liczby klientów, budować zaangażowanie i skutecznie promować swoją obecność na targach.' 
                            : 'Use the potential of social media to reach more customers, build engagement and effectively promote your presence at trade shows.',
                        'max_width' => '1200px'
                    ],
                    [
                        'category' => 'packages',
                        'title' => self::lang_pl() 
                            ? 'MAKSYMALIZUJ SWOJE MOŻLIWOŚCI: PAKIETY PROMOCYJNE!' 
                            : 'MAXIMIZE YOUR POSSIBILITIES: PROMOTIONAL PACKAGES!',
                        'description' => self::lang_pl() 
                            ? 'Wybierz kompleksowe pakiety usług, które pomogą Ci skutecznie wyróżnić się na targach, zwiększyć zasięg i przyciągnąć więcej klientów.' 
                            : 'Choose comprehensive service packages that will help you effectively stand out at trade fairs, increase your reach and attract more customers.',
                        'max_width' => '1000px'
                    ]
                ];                                

                // Category map
                $category_map = [];
                foreach ($category_header_info as $item) {
                    $category_map[$item['category']] = $item;
                }

                // Generate category header
                foreach ($categories as $category) {
                    if (isset($category_map[$category])) {
                        $item_info = $category_map[$category];
                        $output .= '
                        <div class="pwe-store__main-section-text '. $category .'">
                            <h1>'. $item_info["title"] .'</h1>
                            <p style="max-width: '. $item_info["max_width"] .';">'. $item_info["description"] .'</p>
                        </div>';
                    }
                }

            $output .= '
            </div> 

            <div class="pwe-store__hide-sections pwe-store__desc">';

                foreach ($categories as $category) {
                    $output .= '
                    <!-- Desc section <------------------------------------------------------------------------------------------>
                    <div id="'. str_replace("-", "", $category) .'SectionHide" category="'. $category .'" class="pwe-store__'. $category .'-section-hide pwe-store__section-hide">
        
                        <div class="pwe-store__category-header">
                            <div class="pwe-store__category-header-arrow">
                                <div class="pwe-store__category-header-arrow-el">
                                    <span></span>
                                </div>
                            </div>
                            <div class="pwe-store__category-header-title">
                                <p class="pwe-uppercase">'. 
                                    (self::lang_pl() ? 'USŁUGI '. 
                                    str_replace(
                                        array("marketing", "packages"), 
                                        array("marketingowe", "pakiety"), 
                                        str_replace("-", " ", $category)
                                    ) : str_replace("-", " ", $category) .' SERVICES') .'
                                </p>
                            </div>
                        </div>';

                        foreach ($pwe_store_data as $product) {
                            $status = null;
                            if ($category == $product->prod_category && (self::lang_pl() ? !empty($product->prod_title_short_pl) : !empty($product->prod_title_short_en))) {
                                foreach ($store_options as $domain_options) {
                                    if ($domain_options['domain'] === $current_domain) {
                                        if (!empty($domain_options['options'])) {
                                            $options = json_decode($domain_options['options'], true);
                                
                                            if (isset($options['products'])) {
                                                foreach ($options['products'] as $key => $option) {
                                                    if ($product->prod_slug == $key) {
                                                        $sold_out = $option['sold_out'] ? "sold-out" : "";
                                                        $status_text = (self::lang_pl() ? $option['prod_image_text_pl'] : $option['prod_image_text_en']) 
                                                                       ? (self::lang_pl() ? $option['prod_image_text_pl'] : $option['prod_image_text_en']) 
                                                                       : "";
                                                        $status = !empty($status_text) ? "status" : "";
                                
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
                                $updated_price_en = self::ceilPrice($updated_price_en);

                                $updated_price_desc_pl = !empty($new_price_desc_pl) ? $new_price_desc_pl : $product->prod_price_desc_pl;
                                $updated_price_desc_en = !empty($new_price_desc_en) ? $new_price_desc_en : $product->prod_price_desc_en;

                                if ($price_margin) {
                                    $updated_price_pl = $updated_price_pl + ($updated_price_pl * ($price_margin / 100));
                                    $updated_price_en = $updated_price_en + ($updated_price_en * ($price_margin / 100));

                                    $updated_price_pl = self::ceilPrice($updated_price_pl);
                                    $updated_price_en = self::ceilPrice($updated_price_en);
                                }

                                if ($sold_out) {
                                    $output .= '
                                    <style>
                                        .pwe-store__featured-service-'. $product->prod_slug .'.sold-out .pwe-store__featured-image:before {
                                            content: "'. (self::lang_pl() ? 'WYPRZEDANE' : 'SOLD OUT') .'";
                                        }
                                    </style>';
                                } else if (!empty($status)) {
                                    $output .= '
                                    <style>
                                        .pwe-store__featured-service-'. $product->prod_slug .'.status .pwe-store__featured-image:before {
                                            content: "'. $status_text .'"; 
                                        }
                                    </style>';
                                } else if (!empty($product->prod_image_text_pl) && !empty($product->prod_image_text_en)) {
                                    $status = "status";
                                    $output .= '
                                    <style>
                                        .pwe-store__featured-service-'. $product->prod_slug .'.status .pwe-store__featured-image:before {
                                            content: "'. (self::lang_pl() ? $product->prod_image_text_pl : $product->prod_image_text_en) .'";
                                        }
                                    </style>';
                                }

                                $output .= '
                                <!-- Desc item -->
                                <div class="pwe-store__featured-service pwe-store__featured-service-'. $product->prod_slug .' pwe-store__service '. $sold_out . ' ' . $status .'" id="'. $product->prod_slug .'">
                                    <div class="pwe-store__featured-content">
                                        <div class="pwe-store__featured-image">
                                            <img  
                                                class="pwe-store__featured-single-image"
                                                src="https://cap.warsawexpo.eu/public/uploads/shop/'. ( self::lang_pl() ? $product->prod_image_pl : (!empty($product->prod_image_en) ? $product->prod_image_en : $product->prod_image_pl)) .'" 
                                                alt="'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'"
                                            >';
                                            if (!empty($product->prod_image_gallery)) {
                                                $output .= '
                                                <div class="pwe-store__featured-gallery">';
                                                    $gallery_urls = explode(',', $product->prod_image_gallery);

                                                    foreach ($gallery_urls as $url) {
                                                        $output .= '<img src="https://cap.warsawexpo.eu/public/uploads/shop/' . $product->prod_slug . '/gallery/' . $url . '" alt="Gallery image" width="200" height="300">';
                                                    }
                                                $output .= '
                                                </div>';
                                            }
                                        $output .= '
                                        </div>
                                        
                                        <div class="pwe-store__featured-details">
                                            <div class="pwe-store__featured-text-content">
                                                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? (!empty($product->prod_title_full_pl) ? $product->prod_title_full_pl : $product->prod_title_short_pl) : (!empty($product->prod_title_full_en) ? $product->prod_title_full_en : $product->prod_title_short_en) ) .'</h3>
                                                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'</span>
                                                <div class="pwe-store__featured-text">
                                                    '. ( self::lang_pl() ? $product->prod_desc_full_pl : $product->prod_desc_full_en ) .' 
                                                </div>
                                            </div>
                                            <div class="pwe-store__featured-footer">
                                                <span class="pwe-store__featured-pwe-store__price">';
                                                    if (!empty($updated_price_pl)) {
                                                        $eur_price = $updated_price_pl / $pwe_meta_data[0]->meta_data;
                                                        $eur_price = self::ceilPrice($eur_price);
                        
                                                        $output .= number_format((self::lang_pl() ? $updated_price_pl : (!empty($updated_price_en) ? $updated_price_en : $eur_price)), 0, ',', ' ') . ( self::lang_pl() ? ' zł ' : ' € ' );
                                                    } 
                                                    $output .= (self::lang_pl() ? $updated_price_desc_pl : $updated_price_desc_en) .'
                                                </span>
                                                <div class="pwe-store__featured-buttons">
                                                    <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                                    <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }   

                    $output .= '
                    </div>'; 
                }                 

            $output .= '
            </div>

            <div class="pwe-store__category">
                <div class="pwe-store__category-wrapper">
                    <div class="pwe-store__category-text"><p>'. (self::lang_pl() ? 'FILTRUJ:' : 'FILTER:') .'</p></div>
                    <div class="pwe-store__category-items">';
                        foreach ($categories as $category) {
                            $output .= '
                            <div id="'. $category .'" class="pwe-store__category-item">
                                <p class="pwe-uppercase">'. 
                                    (self::lang_pl() ? 'USŁUGI '. 
                                    str_replace(
                                        array("marketing", "packages"), 
                                        array("marketingowe", "pakiety"), 
                                        str_replace("-", " ", $category)
                                    ) : str_replace("-", " ", $category) .' SERVICES') .'
                                </p>
                            </div>';
                        }
                        $output .= '
                    </div>
                </div>
            </div>

            <div class="pwe-store__sections pwe-store__cards">';

                foreach ($categories as $category) {
                    $output .= '
                    <!-- Card section <------------------------------------------------------------------------------------------>
                    <div id="'. str_replace("-", "", $category) .'Section" category="'. $category .'" class="pwe-store__'. $category .'-section pwe-store__section"> 
                        <div class="pwe-store__services-cards">';

                        foreach ($pwe_store_data as $product) {
                            $status = null;
                            if ($category == $product->prod_category && (self::lang_pl() ? !empty($product->prod_title_short_pl) : !empty($product->prod_title_short_en))) {
                                foreach ($store_options as $domain_options) {
                                    if ($domain_options['domain'] === $current_domain) {
                                        if (!empty($domain_options['options'])) {
                                            $options = json_decode($domain_options['options'], true);
                                            
                                            if (isset($options['products'])) {
                                                foreach ($options['products'] as $key => $option) {
                                                    if ($product->prod_slug == $key) {
                                                        $sold_out = $option['sold_out'] ? "sold-out" : "";
                                                        $status_text = (self::lang_pl() ? $option['prod_image_text_pl'] : $option['prod_image_text_en']) 
                                                                       ? (self::lang_pl() ? $option['prod_image_text_pl'] : $option['prod_image_text_en']) 
                                                                       : "";
                                                        $status = !empty($status_text) ? "status" : "";
                                
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
                                $updated_price_en = self::ceilPrice($updated_price_en);

                                $updated_price_desc_pl = !empty($new_price_desc_pl) ? $new_price_desc_pl : $product->prod_price_desc_pl;
                                $updated_price_desc_en = !empty($new_price_desc_en) ? $new_price_desc_en : $product->prod_price_desc_en;

                                if ($price_margin) {
                                    $updated_price_pl = $updated_price_pl + ($updated_price_pl * ($price_margin / 100));
                                    $updated_price_en = $updated_price_en + ($updated_price_en * ($price_margin / 100));

                                    $updated_price_pl = self::ceilPrice($updated_price_pl);
                                    $updated_price_en = self::ceilPrice($updated_price_en);
                                }

                                if ($sold_out) {
                                    $output .= '
                                    <style>
                                        .pwe-store__service-card-'. $product->prod_slug .'.sold-out .pwe-store__service-image:before {
                                            content: "'. (self::lang_pl() ? 'WYPRZEDANE' : 'SOLD OUT') .'";
                                        }
                                    </style>';
                                } else if (!empty($status)) {
                                    $output .= '
                                    <style>
                                        .pwe-store__service-card-'. $product->prod_slug .'.status .pwe-store__service-image:before {
                                            content: "'. $status_text .'";
                                        }
                                    </style>';
                                } else if (!empty($product->prod_image_text_pl) && !empty($product->prod_image_text_en)) {
                                    $status = "status";
                                    $output .= '
                                    <style>
                                        .pwe-store__service-card-'. $product->prod_slug .'.status .pwe-store__service-image:before {
                                            content: "'. (self::lang_pl() ? $product->prod_image_text_pl : $product->prod_image_text_en) .'";
                                        }
                                    </style>';
                                }
                                $output .= '
                                <!-- Card item -->
                                <div class="pwe-store__service-card pwe-store__service-card-'. $product->prod_slug .' pwe-store__service '. $sold_out . ' ' . $status .'">
                                    <a class="pwe-store__service-card-wrapper" href="#" data-featured="'. $product->prod_slug .'">
                                        <div class="pwe-store__service-image">
                                            <img
                                                src="https://cap.warsawexpo.eu/public/uploads/shop/'. ( self::lang_pl() ? $product->prod_image_pl : (!empty($product->prod_image_en) ? $product->prod_image_en : $product->prod_image_pl)) .'" 
                                                alt="'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'"
                                            >
                                        </div>
                                        <div class="pwe-store__service-content">
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">'. ( self::lang_pl() ? $product->prod_title_short_pl : $product->prod_title_short_en ) .'</h4>
                                            <div class="pwe-store__service-description">'. ( self::lang_pl() ? $product->prod_desc_short_pl : $product->prod_desc_short_en ) .'</div>
                                            <div class="pwe-store__service-footer">
                                                <div class="pwe-store__price">';
                                                    if (!empty($updated_price_pl)) {
                                                        $eur_price = $updated_price_pl / $pwe_meta_data[0]->meta_data;
                                                        $eur_price = self::ceilPrice($eur_price);

                                                        $output .= number_format((self::lang_pl() ? $updated_price_pl : (!empty($updated_price_en) ? $updated_price_en : $eur_price)), 0, ',', ' ') . ( self::lang_pl() ? ' zł ' : ' € ' );
                                                    } 
                                                    $output .= (self::lang_pl() ? $updated_price_desc_pl : $updated_price_desc_en) .'
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="pwe-store__btn-container">
                                        <a href="#" class="pwe-store__more-button" data-featured="'. $product->prod_slug .'">'. (self::lang_pl() ? 'WIĘCEJ' : 'MORE') .'</a>
                                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. (self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW') .'</a>
                                    </div>
                                </div>';
                            }
                        }   

                        $output .= '
                        </div>
                    </div>';
                }

            $output .= '
            </div>';

            if ($current_domain === "warsawexpo.eu" || $current_domain === "rfl.warsawexpo.eu") {
                $output .= '
                <div class="pwe-store__fairs">
                    <div class="pwe-store__fairs-arrow-back"><span>WRÓĆ</span></div>
                    <div class="pwe-store__fairs-search">
                        <h4>Wyszukaj wydarzenie albo wybierz z listy</h4>
                        <input class="pwe-store__fairs-search-input" type="text">
                    </div>
                    <div class="pwe-store__fairs-items">';
                    $all_editions = self::fairs_array();
                    if (!empty($all_editions)) {

                        $all_fairs = array_merge($all_editions['edition_1'], $all_editions['edition_2'], $all_editions['edition_3'], $all_editions['edition_b2c']);

                        // Sorting the array based on date
                        usort($all_fairs, function ($a, $b) {
                            // If date is missing in one of the elements, this element goes to the end of the array
                            if (empty($a['date']) && !empty($b['date'])) {
                                return 1;
                            }
                            if (!empty($a['date']) && empty($b['date'])) {
                                return -1;
                            }
                    
                            // If both dates exist, we compare them
                            $dateA = isset($a['date']) ? str_replace('/', '-', $a['date']) : '';
                            $dateB = isset($b['date']) ? str_replace('/', '-', $b['date']) : '';
                            
                            // Convert date to timestamp
                            $timestampA = strtotime($dateA);
                            $timestampB = strtotime($dateB);
                    
                            return $timestampA - $timestampB;
                        });
        
                        foreach ($all_fairs as $fair) {
                            if (isset($fair['domain'], $fair['name'], $fair['desc'], $fair['date'], $fair['edition']) && 
                                !empty($fair['domain']) && $fair['domain'] !== "" && 
                                !empty($fair['name']) && $fair['name'] !== "" && 
                                !empty($fair['desc']) && $fair['desc'] !== "" && 
                                !empty($fair['date']) && $fair['date'] !== "" && 
                                !empty($fair['edition']) && $fair['edition'] !== "") {
                            
                                $output .= '
                                <div 
                                    class="pwe-store__fairs-item" 
                                    id="'. preg_replace('/\.[^.]*$/', '', $fair['domain']) .'" 
                                    data-name="'. $fair['name'] .'" 
                                    data-tooltip="'. $fair['desc'] .'" 
                                    data-date="'. $fair['date'] .'" 
                                    data-edition="'. $fair['edition'] .'" 
                                    data-domain="'. $fair['domain'] .'" 
                                    style="background-image: url(&quot;https://'. $fair['domain'] .'/doc/kafelek.jpg&quot;);">
                                </div>';
                            } else {
                                if (current_user_can('administrator')) {
                                    echo '<script>console.log("Brak danych dla: '. $fair['domain'] .'")</script>';
                                }
                            }
                        }
                        
                    } else { $output .= '<p style="position: absolute; left: 50%; transform: translate(-50%, 0); text-align: center;">Przepraszamy, lista targów jest tymczasowo niedostępna. =(</p>'; }
                    $output .= '
                    </div>
                </div>';
            }
        $output .= '
        </div>';

        // $pwe_store_data_json_encode = json_encode($pwe_store_data);
        // $pwe_store_data_options_json_encode = json_encode($store_options);
        // $output .= '
        // <script>
        //     document.addEventListener("DOMContentLoaded", function () {
        //         const storeData = ' . $pwe_store_data_json_encode . ';
        //         const storeDataOptions = ' . $pwe_store_data_options_json_encode . ';
                
        //         console.log(storeData);
        //         console.log(storeDataOptions);
        //     });
        // </script>';

        $output = do_shortcode($output);  
        
        return $output;
    }  
}