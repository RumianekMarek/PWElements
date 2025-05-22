<?php

class PWECommonFunctions {

    /**
     * Random number
     */
    public static function id_rnd() {
        $id_rnd = rand(10000, 99999);
        return $id_rnd;
    }

    private static function resolveServerAddrFallback() {
        $host = php_uname('n');
            switch ($host) {
            case 'dedyk180.cyber-folks.pl':
                return '94.152.207.180';
            case 'dedyk93.cyber-folks.pl':
                return '94.152.206.93';
            case 'dedyk239.cyber-folks.pl':
                return '91.225.28.47';
            default:
                return '94.152.207.180';
        }
    }

    /**
     * Connecting to CAP database
     */
    public static function connect_database() {
        // Initialize connection variables
        $cap_db = null;

        if (!isset($_SERVER['SERVER_ADDR'])) {
            $_SERVER['SERVER_ADDR'] = self::resolveServerAddrFallback();
        }
        
        // Set connection data depending on the server
        switch ($_SERVER['SERVER_ADDR']) {
            case '94.152.207.180':
                $database_host = 'localhost';
                $database_name = defined('PWE_DB_NAME_180') ? PWE_DB_NAME_180 : '';
                $database_user = defined('PWE_DB_USER_180') ? PWE_DB_USER_180 : '';
                $database_password = defined('PWE_DB_PASSWORD_180') ? PWE_DB_PASSWORD_180 : '';
                break;

            case '94.152.206.93':
                $database_host = 'localhost';
                $database_name = defined('PWE_DB_NAME_93') ? PWE_DB_NAME_93 : '';
                $database_user = defined('PWE_DB_USER_93') ? PWE_DB_USER_93 : '';
                $database_password = defined('PWE_DB_PASSWORD_93') ? PWE_DB_PASSWORD_93 : '';
                break;

            default:
                $database_host = 'dedyk180.cyber-folks.pl';
                $database_name = defined('PWE_DB_NAME_180') ? PWE_DB_NAME_180 : '';
                $database_user = defined('PWE_DB_USER_180') ? PWE_DB_USER_180 : '';
                $database_password = defined('PWE_DB_PASSWORD_180') ? PWE_DB_PASSWORD_180 : '';
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

    /**
     * Get data from CAP databases  
     */
    public static function get_database_fairs_data() {
        // Database connection
        $cap_db = self::connect_database();
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

    public static function get_database_store_data() {
        // Database connection
        $cap_db = self::connect_database();
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

    public static function get_database_store_packages_data() {
        // Database connection
        $cap_db = self::connect_database();
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

    public static function get_database_meta_data() {
        // Database connection
        $cap_db = self::connect_database();
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

    public static function get_database_groups_contacts_data() {
        // Database connection
        $cap_db = self::connect_database();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }
    
        // Retrieving data from the database 
        $results = $cap_db->get_results("SELECT * FROM groups");
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }
    
        return $results;
    }

    public static function get_database_groups_data() {
        // Database connection
        $cap_db = self::connect_database();
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

    public static function get_database_logotypes_data() {
        // Database connection
        $cap_db = self::connect_database();
        // If connection failed, return empty array
        if (!$cap_db) {
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
            return [];
        }
    
        // Get current domain
        $current_domain = $_SERVER['HTTP_HOST'];
    
        // SQL query to fetch logos with the matching fair_id and fair_domain
        $query = "
            SELECT logos.*, 
                meta_data.meta_data AS meta_data 
            FROM logos
            INNER JOIN fairs ON logos.fair_id = fairs.id
            LEFT JOIN meta_data ON meta_data.slug = 'patrons' 
                                AND JSON_UNQUOTE(JSON_EXTRACT(meta_data.meta_data, '$.slug')) = logos.logos_type
            WHERE fairs.fair_domain = %s
        ";
    
        // Retrieve data from the database
        $results = $cap_db->get_results($cap_db->prepare($query, $current_domain));
    
        // SQL error checking
        if ($cap_db->last_error) {
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: ' . addslashes($cap_db->last_error) . '")</script>';
            }
            return [];
        }
    
        return $results;
    } 

    public static function get_database_conferences_data() {
        // Database connection
        $cap_db = self::connect_database();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }

        $domain = $_SERVER['HTTP_HOST'];

        // Pobieramy dane bez względu na język
        $results = $cap_db->get_results(
            $cap_db->prepare(
                "SELECT * FROM conferences WHERE conf_site_link LIKE %s",
                '%' . $domain . '%'
            )
        );
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }

        foreach ($results as &$row) {
            if (!empty($row->conf_data)) {
                $decoded = html_entity_decode($row->conf_data);
        
                // Czyścimy WSZYSTKIE wystąpienia font-family z atrybutów style (w tym wieloliniowe!)
                $decoded = preg_replace_callback('/style="([^"]+)"/is', function ($match) {
                    $style = $match[1];
                    $style = preg_replace('/font-family\s*:\s*[^;"]+("[^"]+"[, ]*)*[^;"]*;?/i', '', $style);
                    $style = trim(preg_replace('/\s*;\s*/', '; ', $style), '; ');
                    return $style ? 'style="' . $style . '"' : '';
                }, $decoded);
        
                // Sprawdzamy poprawność JSON
                $test = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $row->conf_data = $decoded;
                } else {
                    error_log("❌ Błąd JSON w conf_data: " . json_last_error_msg());
                }
            }
        }
            
        return $results;
    }
    
    

    /**
     * Colors (accent or main2)
     */
    public static function pwe_color($color) {
        $fair_colors = self::findPalletColorsStatic();
        $result_color = null;
    
        // Handling color 'accent' 
        if (strtolower($color) === 'accent' && isset($fair_colors['Accent'])) {
            $result_color = $fair_colors['Accent'];
        }
    
        // Handling color 'main2'
        if (strtolower($color) === 'main2') {
            foreach ($fair_colors as $color_key => $color_value) {
                if (strpos(strtolower($color_key), 'main2') !== false) {
                    $result_color = $color_value;
                    break;
                }
            }
        }
    
        return $result_color;
    }

    public static function generate_fair_data($fair) {
        return [
            "domain" => $fair->fair_domain,
            "date_start" => $fair->fair_date_start ?? "",
            "date_start_hour" => $fair->fair_date_start_hour ?? "",
            "date_end" => $fair->fair_date_end ?? "",
            "date_end_hour" => $fair->fair_date_end_hour ?? "",
            "edition" => $fair->fair_edition ?? "",
            "name_pl" => $fair->fair_name_pl ?? "",
            "name_en" => $fair->fair_name_en ?? "",
            "desc_pl" => $fair->fair_desc_pl ?? "",
            "desc_en" => $fair->fair_desc_en ?? "",
            "short_desc_pl" => $fair->fair_short_desc_pl ?? "",
            "short_desc_en" => $fair->fair_short_desc_en ?? "",
            "full_desc_pl" => $fair->fair_full_desc_pl ?? "",
            "full_desc_en" => $fair->fair_full_desc_en ?? "",
            "visitors" => $fair->fair_visitors ?? "",
            "exhibitors" => $fair->fair_exhibitors ?? "",
            "countries" => $fair->fair_countries ?? "",
            "area" => $fair->fair_area ?? "",
            "color_accent" => $fair->fair_color_accent ?? "",
            "color_main2" => $fair->fair_color_main2 ?? "",
            "hall" => $fair->fair_hall ?? "",
            "facebook" => $fair->fair_facebook ?? "",
            "instagram" => $fair->fair_instagram ?? "",
            "linkedin" => $fair->fair_linkedin ?? "",
            "youtube" => $fair->fair_youtube ?? "",
            "badge" => $fair->fair_badge ?? "",
            "catalog" => $fair->fair_kw ?? "",
            "shop" => $fair->fair_shop ?? ""
        ];
    }

    /**
     * JSON all trade fairs
     */
    public static function json_fairs() {
        $pwe_fairs = self::get_database_fairs_data();

        static $console_logged = false;

        if (!empty($pwe_fairs)) {
            $fairs_data = ["fairs" => []];

            foreach ($pwe_fairs as $fair) {
                if (!isset($fair->fair_domain) || empty($fair->fair_domain)) {
                    continue;
                }
    
                $domain = $fair->fair_domain;
    
                $fairs_data["fairs"][$domain] = self::generate_fair_data($fair);
            }
        } else {
            $json_file = 'https://mr.glasstec.pl/doc/pwe-data.json';
            $json_data = @file_get_contents($json_file);
            $fairs_data = json_decode($json_data, true);

            if (!$console_logged) {
                if (current_user_can("administrator") && !is_admin()) {
                    echo '<script>console.error("Dane CAP są pobrane z pliku backupowego!!!")</script>';
                }
                $console_logged = true;
            }

        }

        return $fairs_data['fairs'];  
    }
    
    /**
     * Function to transform the date
     */
    public static function transform_dates($start_date, $end_date) {
        // Convert date strings to DateTime objects
        $start_date_obj = DateTime::createFromFormat("Y/m/d H:i", $start_date);
        $end_date_obj = DateTime::createFromFormat("Y/m/d H:i", $end_date);
    
        // Check if the conversion was correct
        if ($start_date_obj && $end_date_obj) {
            // Get the day, month and year from DateTime objects
            $start_day = $start_date_obj->format("d");
            $end_day = $end_date_obj->format("d");
            $start_month = $start_date_obj->format("m");
            $end_month = $end_date_obj->format("m");
            $year = $start_date_obj->format("Y");
    
            // Check if months are the same
            if ($start_month === $end_month) {
                $formatted_date = "{$start_day}-{$end_day}|{$start_month}|{$year}";
            } else {
                $formatted_date = "{$start_day}|{$start_month}-{$end_day}|{$end_month}|{$year}";
            }
    
            return $formatted_date;
        } else {
            return "Invalid dates";
        }
    }
    

    /**
     * Decoding Base64
     * Decoding URL
     * Remowe wpautop
     */
    public static function decode_clean_content($encoded_content) {
        $decoded_content = wpb_js_remove_wpautop(urldecode(base64_decode($encoded_content)), true);
        return $decoded_content;
    }

    /**
     * Decodes URL-encoded string
     * Decodes a JSON string
     */
    public static function json_decode($encoded_variable) {
        $encoded_variable_urldecode = urldecode($encoded_variable);
        $encoded_variable_json = json_decode($encoded_variable_urldecode, true);
        return $encoded_variable_json;
    }

    /**
     * Adding colors
     */
    public static function findColor($primary, $secondary, $default = '') {
        if($primary != '') {
            return $primary;
        } elseif ($secondary != '') {
            return $secondary;
        } else {
            return $default;
        }
    }

    /**
     * Finding preset colors pallet.
     *
     * @return array
     */
    public static function findPalletColorsStatic() {
        $uncode_options = get_option('uncode');
        $accent_uncode_color = $uncode_options["_uncode_accent_color"];
        $custom_element_colors = array();

        if (isset($uncode_options["_uncode_custom_colors_list"]) && is_array($uncode_options["_uncode_custom_colors_list"])) {
            $custom_colors_list = $uncode_options["_uncode_custom_colors_list"];
      
            foreach ($custom_colors_list as $color) {
                $title = $color['title'];
                $color_value = $color["_uncode_custom_color"];
                $color_id = $color["_uncode_custom_color_unique_id"];

                if ($accent_uncode_color != $color_id) {
                    $custom_element_colors[$title] = $color_value;
                } else {
                    $accent_color_value = $color_value;
                    $custom_element_colors = array_merge(array('Accent' => $accent_color_value), $custom_element_colors);
                }
            }
            $custom_element_colors = array_merge(array('Default' => ''), $custom_element_colors);
        }
        return $custom_element_colors;
    }

    /**
     * Finding preset colors pallet.
     *
     * @return array
     */
    public function findPalletColors() {
        $uncode_options = get_option('uncode');
        $accent_uncode_color = $uncode_options["_uncode_accent_color"];
        $custom_element_colors = array();

        if (isset($uncode_options["_uncode_custom_colors_list"]) && is_array($uncode_options["_uncode_custom_colors_list"])) {
            $custom_colors_list = $uncode_options["_uncode_custom_colors_list"];
      
            foreach ($custom_colors_list as $color) {
                $title = $color['title'];
                $color_value = $color["_uncode_custom_color"];
                $color_id = $color["_uncode_custom_color_unique_id"];

                if ($accent_uncode_color != $color_id) {
                    $custom_element_colors[$title] = $color_value;
                } else {
                    $accent_color_value = $color_value;
                    $custom_element_colors = array_merge(array('Accent' => $accent_color_value), $custom_element_colors);
                }
            }
            $custom_element_colors = array_merge(array('Default' => ''), $custom_element_colors);
        }
        return $custom_element_colors;
    }

    /**
     * Checking if the location is PL
     * 
     * @return bool
     */
    public static function lang_pl() {
        return get_locale() == 'pl_PL';
    }

    /**
     * Laguage check for text
     * 
     * @param string $pl text in Polish.
     * @param string $pl text in English.
     * @return string 
     */
    public static function languageChecker($pl, $en = '') {
        return get_locale() == 'pl_PL' ? $pl : $en;
    }

    /**
     * Multi translation for text
     * 
     * @param string [0] index - text in Polish.
     * @param string [1] index - text in English.
     * @param string [2] index - text in Germany.
     * @return string 
     */
    public static function multi_translation(...$translations) {
        $locale = get_locale();
        
        // Mapping languages ​​to appropriate indexes in the array
        $languages = [
            'pl_PL' => 0, // Polish
            'en_US' => 1, // English
            'de_DE' => 2, // German
            // 'es_ES' => 3, // Spanish
        ];
        
        return isset($languages[$locale]) ? $translations[$languages[$locale]] : $translations[1];;
    }

     /**
     * Function to change color brightness (taking color in hex format)
     *
     * @return array
     */
    public static function adjustBrightness($hex, $steps) {
        // Convert hex to RGB
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Shift RGB values
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));

        // Convert RGB back to hex
        return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
                . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
                . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }

    /**
     * Finding all GF forms
     *
     * @return array
     */
    public function findFormsGF($mode = ''){
        $pwe_forms_array = array();
        if (is_admin()) {
            if (method_exists('GFAPI', 'get_forms')) {
                $pwe_forms = GFAPI::get_forms();
                if($mode == 'id'){
                    foreach ($pwe_forms as $form) {
                        $pwe_forms_array[$form['title']] = $form['id'];
                    }
                } else {
                    foreach ($pwe_forms as $form) {
                        $pwe_forms_array[$form['id']] = $form['title'];
                    }
                }
            }
        }
        return $pwe_forms_array;
    }  

    /**
     * Finding all target form id
     *
     * @param string $form_name 
     * @return string
     */
    public static function findFormsID($form_name) {
        $pwe_form_id = '';
        if (method_exists('GFAPI', 'get_forms')) {
            $pwe_forms = GFAPI::get_forms();
            foreach ($pwe_forms as $form) {
                if ($form['title'] === $form_name) {
                    $pwe_form_id = $form['id'];
                    break;
                }
            }
        }
        return $pwe_form_id;
    }

    /**
     * Mobile displayer check
     * 
     * @return bool
     */
    public static function checkForMobile(){
        return (preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']));
    }

    /**
     * Laguage check for text
     * 
     * @param bool $logo_color schould logo be in color.
     * @return string
     */
    public static function findBestLogo($logo_color = false) {
        $filePaths = array(
            '/doc/logo-color-en.webp',
            '/doc/logo-color-en.png',
            '/doc/logo-color.webp',
            '/doc/logo-color.png',
            '/doc/logo-en.webp',
            '/doc/logo-en.png',
            '/doc/logo.webp',
            '/doc/logo.png'
        );

        switch (true){
            case(get_locale() == 'pl_PL'):
                if($logo_color){
                    foreach ($filePaths as $path) {    
                        if (strpos($path, '-en.') === false && file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                } else {
                    foreach ($filePaths as $path) {
                        if ( strpos($path, 'color') === false && strpos($path, '-en.') === false && file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                }
                break;

            case(get_locale() == 'en_US'):
                if($logo_color){
                    foreach ($filePaths as $path) {
                        if (file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                } else {
                    foreach ($filePaths as $path) {
                        if (strpos($path, 'color') === false && file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                }
                break;
        }
    }

    /**
     * Finding URL of all images based on katalog
     */
    public static function findAllImages($firstPath, $image_count = false, $secondPath = '/doc/galeria') {
        $firstPath = $_SERVER['DOCUMENT_ROOT'] . $firstPath;
        
        if (is_dir($firstPath) && !empty(glob($firstPath . '/*.{jpeg,jpg,png,webp,svg,JPEG,JPG,PNG,WEBP}', GLOB_BRACE))) {
            $exhibitorsImages = glob($firstPath . '/*.{jpeg,jpg,png,webp,svg,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
        } else {
            $secondPath = $_SERVER['DOCUMENT_ROOT'] . $secondPath;
            $exhibitorsImages = glob($secondPath . '/*.{jpeg,jpg,png,webp,svg,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
        }
        $count = 0;
        foreach($exhibitorsImages as $image){
            if($image_count != false && $count >= $image_count){
                break;
            } else {
                $exhibitors_path[] = substr($image, strpos($image, '/doc/'));
                $count++;
            }
        }

        return $exhibitors_path;
    }

    /**
     * Laguage check for text
     * 
     * @param bool $logo_color schould logo be in color.
     * @return string
     */
    public static function findBestFile($file_path) {
        $filePaths = array(
            '.webp',
            '.jpg',
            '.png'
        );

        foreach($filePaths as $com){
            if(file_exists(ABSPATH . $file_path . $com)) {
                return $file_path . $com;
            }
        }
    }

    /**
     * Trade fair date existance check
     * 
     * @return bool
     */
    public static function isTradeDateExist() {

        $seasons = ["nowa data", "wiosna", "lato", "jesień", "zima", "new date", "spring", "summer", "autumn", "winter"];
        $trade_date_lower = strtolower(do_shortcode('[trade_fair_date]'));

        // Przeszukiwanie tablicy w poszukiwaniu pasującego sezonu
        foreach ($seasons as $season) {
            if (strpos($trade_date_lower, strtolower($season)) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Adding element input[type="range"]
     */
    public static function inputRange() {
        if ( function_exists( 'vc_add_shortcode_param' ) ) {
            vc_add_shortcode_param( 'input_range', array('PWEHeader', 'input_range_field_html') );
        }
    }
    public static function input_range_field_html( $settings, $value ) {
        $id = uniqid('range_');
        return '<div class="pwe-input-range">'
            . '<input type="range" '
            . 'id="' . esc_attr( $id ) . '" '
            . 'name="' . esc_attr( $settings['param_name'] ) . '" '
            . 'class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" '
            . 'value="' . esc_attr( $value ) . '" '
            . 'min="' . esc_attr( $settings['min'] ) . '" '
            . 'max="' . esc_attr( $settings['max'] ) . '" '
            . 'step="' . esc_attr( $settings['step'] ) . '" '
            . 'oninput="document.getElementById(\'value_' . esc_attr( $id ) . '\').innerHTML = this.value" '
            . '/>'
            . '<span id="value_' . esc_attr( $id ) . '">' . esc_attr( $value ) . '</span>'
            . '</div>';
    }

    /**
     * Adding custom checkbox element
     */
    function pweCheckbox() {
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('pwe_checkbox', array('PWEHeader', 'pwe_checkbox_html'));
        }
    }
    /**
     * Generate HTML for custom checkbox
     */
    public static function pwe_checkbox_html($settings, $value) {
        $checked = $value === 'true' ? 'checked' : '';
        $id = uniqid('pwe_checkbox_');

        return '<div class="pwe-checkbox">'
            . '<input type="checkbox" '
            . 'id="' . esc_attr($id) . '" '
            . 'name="' . esc_attr($settings['param_name']) . '" '
            . 'class="wpb_vc_param_value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" '
            . 'value="'.$value.'" '
            . $checked
            . ' onclick="this.value = this.checked ? \'true\' : \'\';" />'
            . '</div>';
    }

}