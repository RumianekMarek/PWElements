<?php

class PWECatalog {
    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        self::$rnd_id = rand(10000, 99999);
        self::$fair_colors = $this->findPalletColors();
        // self::$fair_forms = $this->findFormsGF();
        self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

        foreach(self::$fair_colors as $color_key => $color_value){
            if(strpos($color_key, 'main2') != false){
                self::$main2_color = $color_value;
            }
        }

        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        
        add_action('init', array($this, 'initVCMapPWECatalog'));
        add_shortcode('pwe_katalog', array($this, 'PWECatalogOutput'));
    }

    /**
     * Initialize VC Map PWECatalog.
     */
    public function initVCMapPWECatalog() {
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map( array(
                'name' => __( 'PWE Katalog wystawców', 'pwe_katalog'),
                'base' => 'pwe_katalog',
                'category' => __( 'PWE Elements', 'pwe_katalog'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
                //Add all vc_map PWECatalog files
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Enter ID', 'pwe_katalog'),
                        'param_name' => 'identification',
                        'description' => __( 'Enter trade fair ID number.', 'pwe_katalog'),
                        'param_holder_class' => 'backend-textfield',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Enter Archive Year <br>or Title in "..." ', 'pwe_katalog'),
                        'param_name' => 'katalog_year',
                        'description' => __( 'Enter year for display in catalog title or us "" to change full title.', 'pwe_katalog'),
                        'param_holder_class' => 'backend-textfield',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __( 'Catalog format', 'pwe_katalog'),
                        'param_name' => 'format',
                        'description' => __( 'Select catalog format.', 'pwe_katalog'),
                        'param_holder_class' => 'backend-textfield',
                        'value' => array(
                        'Select' => '',
                        'Full' => 'PWECatalogFull',
                        'Top21' => 'PWECatalog21',
                        'Top10' => 'PWECatalog10',
                        'Recently7' => 'PWECatalog7'
                        ),
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Logos changer', 'pwe_katalog'),
                        'param_name' => 'file_changer',
                        'description' => __( 'Changer for logos divided by ";" try to put names <br> change places "name<=>name or position";<br> move to position "name=>>name or position";', 'pwe_katalog'),
                        'save_always' => true,
                        'dependency' => array(
                        'element' => 'format',
                        'value' => array('','PWECatalogFull', 'PWECatalog21', 'PWECatalog10'),
                        ),
                    ),
                    // colors setup
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select text color <a href="#" onclick="yourFunction(`text_color_manual_hidden`, `text_color`)">Hex</a>', 'pwe_katalog'),
                        'param_name' => 'text_color',
                        'param_holder_class' => 'main-options',
                        'description' => __('Select text color for the element.', 'pwe_katalog'),
                        'value' => $this->findPalletColors(),
                        'dependency' => array(
                            'element' => 'text_color_manual_hidden',
                            'value' => array(''),
                            'callback' => "hideEmptyElem",
                        ),
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Write text color <a href="#" onclick="yourFunction(`text_color`, `text_color_manual_hidden`)">Pallet</a>', 'pwe_katalog'),
                        'param_name' => 'text_color_manual_hidden',
                        'param_holder_class' => 'main-options pwe_dependent-hidden',
                        'description' => __('Write hex number for text color for the element.', 'pwe_katalog'),
                        'value' => '',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select text shadow color <a href="#" onclick="yourFunction(`text_shadow_color_manual_hidden`, `text_shadow_color`)">Hex</a>', 'pwe_katalog'),
                        'param_name' => 'text_shadow_color',
                        'param_holder_class' => 'main-options',
                        'description' => __('Select shadow text color for the element.', 'pwe_katalog'),
                        'value' => $this->findPalletColors(),
                        'dependency' => array(
                            'element' => 'text_shadow_color_manual_hidden',
                            'value' => array(''),
                        ),
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Write text shadow color <a href="#" onclick="yourFunction(`text_shadow_color`, `text_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_katalog'),
                        'param_name' => 'text_shadow_color_manual_hidden',
                        'param_holder_class' => 'main-options pwe_dependent-hidden',
                        'description' => __('Write hex number for text shadow color for the element.', 'pwe_katalog'),
                        'value' => '',
                        'save_always' => true,
                    ),                        
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select button color <a href="#" onclick="yourFunction(`btn_color_manual_hidden`, `btn_color`)">Hex</a>', 'pwe_katalog'),
                        'param_name' => 'btn_color',
                        'param_holder_class' => 'main-options',
                        'description' => __('Select button color for the element.', 'pwe_katalog'),
                        'value' => $this->findPalletColors(),
                        'dependency' => array(
                            'element' => 'btn_color_manual_hidden',
                            'value' => array(''),
                        ),
                        'save_always' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Write button color <a href="#" onclick="yourFunction(`btn_color`, `btn_color_manual_hidden`)">Pallet</a>', 'pwe_katalog'),
                        'param_name' => 'btn_color_manual_hidden',
                        'param_holder_class' => 'main-options pwe_dependent-hidden',
                        'description' => __('Write hex number for button color for the element.', 'pwe_katalog'),
                        'value' => '',
                        'save_always' => true
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select button text color <a href="#" onclick="yourFunction(`btn_text_color_manual_hidden`, `btn_text_color`)">Hex</a>', 'pwe_katalog'),
                        'param_name' => 'btn_text_color',
                        'param_holder_class' => 'main-options',
                        'description' => __('Select button text color for the element.', 'pwe_katalog'),
                        'value' => $this->findPalletColors(),
                        'dependency' => array(
                            'element' => 'btn_text_color_manual_hidden',
                            'value' => array(''),
                        ),
                        'save_always' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Write button text color <a href="#" onclick="yourFunction(`btn_text_color`, `btn_text_color_manual_hidden`)">Pallet</a>', 'pwelement'),
                        'param_name' => 'btn_text_color_manual_hidden',
                        'param_holder_class' => 'main-options pwe_dependent-hidden',
                        'description' => __('Write hex number for button text color for the element.', 'pwelement'),
                        'value' => '',
                        'save_always' => true
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Select button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color_manual_hidden`, `btn_shadow_color`)">Hex</a>', 'pwelement'),
                        'param_name' => 'btn_shadow_color',
                        'param_holder_class' => 'main-options',
                        'description' => __('Select button shadow color for the element.', 'pwelement'),
                        'value' => $this->findPalletColors(),
                        'dependency' => array(
                            'element' => 'btn_shadow_color_manual_hidden',
                            'value' => array(''),
                        ),
                        'save_always' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Write button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color`, `btn_shadow_color_manual_hidden`)">Pallet</a>', 'pwelement'),
                        'param_name' => 'btn_shadow_color_manual_hidden',
                        'param_holder_class' => 'main-options pwe_dependent-hidden',
                        'description' => __('Write hex number for button shadow color for the element.', 'pwelement'),
                        'value' => '',
                        'save_always' => true
                    ),
                    // color END
                    array(
                        'type' => 'textfield',
                        'heading' => __( 'Export link', 'pwe_katalog'),
                        'param_name' => 'export_link',
                        'description' => __( 'Export link', 'pwe_katalog'),
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    // array(
                    //     'type' => 'checkbox',
                    //     'heading' => __('Hide details', 'pwe_katalog'),
                    //     'param_name' => 'details',
                    //     'description' => __('Check to use to hide details. ONLY full catalog.', 'pwe_katalog'),
                    //     'param_holder_class' => 'backend-basic-checkbox',
                    //     'admin_label' => true,
                    //     'value' => array(__('True', 'pwe_katalog') => 'true',),
                    // ),
                    // array(
                    //     'type' => 'checkbox',
                    //     'heading' => __('Hide stand', 'pwe_katalog'),
                    //     'param_name' => 'stand',
                    //     'description' => __('Check to use to hide stand. ONLY full catalog.', 'pwe_katalog'),
                    //     'param_holder_class' => 'backend-basic-checkbox',
                    //     'admin_label' => true,
                    //     'value' => array(__('True', 'pwe_katalog') => 'true',),
                    // ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Registration', 'pwe_katalog'),
                        'param_name' => 'ticket',
                        'description' => __('Default height logotypes 110px. ONLY top10.', 'pwe_katalog'),
                        'param_holder_class' => 'backend-basic-checkbox',
                        'admin_label' => true,
                        'value' => array(__('True', 'pwe_katalog') => 'true',),
                        'dependency' => array(
                        'element' => 'format',
                        'value' => array('top10')
                        ),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Slider desktop', 'pwe_katalog'),
                        'param_name' => 'slider_desktop',
                        'description' => __('Check if you want to display in slider on desktop.', 'pwe_katalog'),
                        'param_holder_class' => 'backend-basic-checkbox',
                        'admin_label' => true,
                        'save_always' => true,
                        'value' => array(__('True', 'pwe_katalog') => 'true',),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Grid mobile', 'pwe_katalog'),
                        'param_name' => 'grid_mobile',
                        'description' => __('Check if you want to display in grid on mobile.', 'pwe_katalog'),
                        'param_holder_class' => 'backend-basic-checkbox',
                        'admin_label' => true,
                        'save_always' => true,
                        'value' => array(__('True', 'pwe_katalog') => 'true',),
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Turn off dots', 'pwe_katalog'),
                        'param_name' => 'slider_dots_off',
                        'description' => __('Check if you want to turn off dots.', 'pwe_katalog'),
                        'admin_label' => true,
                        'save_always' => true,
                        'value' => array(__('True', 'pwe_katalog') => 'true',),
                    ), 
                ),
            ));
        }
    }

    /**
     * Check class for file if exists.
     *
     * @return array
     */
    private function findClassElements() {
        // Array off class placement
        return array(
            'PWECatalogFull'   => 'catalog_full.php',
            'PWECatalog21'     => 'catalog_21.php',
            'PWECatalog10'     => 'catalog_10.php',
            'PWECatalog7'      => 'catalog_7.php',
        );
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
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('katalog.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'katalog.css');
        wp_enqueue_style('pwe-katalog-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts($atts){
        $js_file = plugins_url('katalog.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'katalog.js');
        wp_enqueue_script('pwe-katalog-js', $js_file, array('jquery'), $js_version, true);
    }

    /**
     * Finding preset colors pallet.
     *
     * @return array
     */
    public static function findPalletColors(){
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
     * Laguage check for text
     * 
     * @param string $pl text in Polish.
     * @param string $pl text in English.
     * @return string 
     */
    public static function languageChecker($pl, $en = ''){
        if(get_locale() == 'pl_PL'){ 
            return do_shortcode($pl);
        } else {
            return do_shortcode($en);
        }
    }

        /**
     * Adding Styles
     */
    public static function findColor($primary, $secondary, $default = ''){
        if($primary != ''){
            return $primary;
        } elseif ($secondary != ''){
            return $secondary;
        } else {
            return $default;
        }
    }

    /**
     * Get logos for catalog
     * 
     * @param string $katalog_id fair id for api.
     * @param string $katalog_format format of display.
     * @return array
     */
    public static function logosChecker($katalog_id, $PWECatalogFull = 'PWECatalogFull'){
        $today = new DateTime();
        $formattedDate = $today->format('Y-m-d');
        $token = md5("#22targiexpo22@@@#".$formattedDate);
        $canUrl = 'https://export.www2.pwe-expoplanner.com/mapa.php?token='.$token.'&id_targow='.$katalog_id;
        
        if ( current_user_can( 'administrator' ) ) {
            echo '<script>console.log("'.$canUrl.'")</script>';
        }

        $json = file_get_contents($canUrl);
        $data = json_decode($json, true);

        $basic_wystawcy = reset($data)['Wystawcy'];
        $logos_array = array();

        if($basic_wystawcy != '') {
            $basic_wystawcy = array_reduce($basic_wystawcy, function($acc, $curr) {
                $name = $curr['Nazwa_wystawcy'];
                $existingIndex = array_search($name, array_column($acc, 'Nazwa_wystawcy'));
                if ($existingIndex === false) {
                    $acc[] = $curr;
                } else {
                    if($acc[$existingIndex]["Data_sprzedazy"] !== null && $curr["Data_sprzedazy"] !== null && strtotime($acc[$existingIndex]["Data_sprzedazy"]) < strtotime($curr["Data_sprzedazy"])){
                        $acc[$existingIndex] = $curr;
                    }
                }
                return $acc;
            }, []);            
        } else {
            $basic_wystawcy = [];
        }

        switch($PWECatalogFull) {
            case 'PWECatalogFull':
                $logos_array = $basic_wystawcy;
                echo '<script>console.log("exhibitors count -> '.count($logos_array).'")</script>';
                wp_localize_script('pwe-katalog-js', 'katalog_data', $logos_array);
                break;
            case 'PWECatalog21' :
                $i = 0;
                foreach($basic_wystawcy as $wystawca){
                    if($wystawca['URL_logo_wystawcy']){
                        $logos_array[] = $wystawca;
                        $i++;
                        if($i >=21){
                            break;
                        }
                    }
                }
                break;
            case 'PWECatalog10' :
                $i = 0;
                foreach($basic_wystawcy as $wystawca){
                    if($wystawca['URL_logo_wystawcy']){
                        $logos_array[] = $wystawca;
                        $i++;
                        if($i >=10){
                            break;
                        }
                    }
                }
                break;
            case 'PWECatalog7' :
                $i = 0;
                function compareDates($a, $b) {
                    $dateA = new DateTime($a['Data_sprzedazy']);
                    $dateB = new DateTime($b['Data_sprzedazy']);

                    if ($dateA == $dateB) {
                        return 0;
                    }
                    return ($dateA < $dateB) ? -1 : 1;
                }
                usort($basic_wystawcy, 'compareDates');

                foreach($basic_wystawcy as $wystawca){
                        $logos_array[] = $wystawca;
                        $i++;
                    if($i >=7){
                        break;
                    }
                }
                break;
        }
        return $logos_array;
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
     * Check Title for Exhibitors Catalog
     */
    // public static function initElements() {
    // }
    public static function checkTitle($title, $format) {
        
        if (substr($title, 0, 2) === "``") {
            $exhibitors_title = substr($title, 2, -2);
        } elseif($format == 'PWECatalogFull'){
            $exhibitors_title = self::languageChecker(
                <<<PL
                    Katalog wystawców 
                PL,
                <<<EN
                    Exhibitor Catalog 
                EN
            ) . $title;
        } elseif ($format == 'PWECatalog21' || $format == 'PWECatalog10'){
            $exhibitors_title = self::languageChecker(
                <<<PL
                    Wystawcy 
                PL,
                <<<EN
                    Exhibitors 
                EN
            ) . (($title) ? $title : do_shortcode('[trade_fair_catalog_year]'));
        } elseif ($format == 'PWECatalog7'){
            $exhibitors_title = self::languageChecker(
                <<<PL
                    Nowi wystawcy na targach 
                PL,
                <<<EN
                    New exhibitors at the fair 
                EN
            ) . $title;
        }
        return $exhibitors_title;
    }

    /**
     * Output method for pwe_katalog shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Shortcode content.
     * @return string
     */
    public function PWECatalogOutput($atts, $content = null) {
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . '!important';
        $btn_shadow_color = self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black') . '!important';
        $btn_border = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . '!important';

        // pwe_katalog output
        extract( shortcode_atts( array(
            'format' => '',
        ), $atts ));

        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        if ($format == 'PWECatalogFull'){
            $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important';
            $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'black') . '!important';
        } else {
            $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important';
            $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important';
        }

        $slider_path = dirname(plugin_dir_path(__FILE__)) . '/scripts/slider.php';
        
        if (file_exists($slider_path)){
            include_once $slider_path;
        }        

        if (!empty($atts['identification'])) {
            $identification = $atts['identification']; 
        } else {
            $identification = do_shortcode('[trade_fair_catalog]');
        }
        
        if ($this->findClassElements()[$format]){
            require_once plugin_dir_path(__FILE__) . $this->findClassElements()[$format];
            
            if (class_exists($format) && $identification) {
                $output_class = new $format;
                $output = $output_class->output($atts, $identification, $content);
            } else {
                // Log if the class doesn't exist
                echo '<script>console.log("Class '. $format .' or ID , does not exist")</script>';
                $output = '';
            }
        } else {
            echo '<script>console.log("Select a Catalog Format")</script>';
        }

        $output_html = '';

        $exhibitors_top10 = ($identification) ? self::logosChecker($identification, "PWECatalog10") : 0;
        if ((empty($identification) || count($exhibitors_top10) < 10) && $format == 'PWECatalog10') {
            if (isset($_SERVER['argv'][0])) {
                $source_utm = $_SERVER['argv'][0];
            } else {
                $source_utm = ''; 
            }

            $current_page = $_SERVER['REQUEST_URI'];

            if (strpos($source_utm, 'utm_source=byli') !== false || strpos($source_utm, 'utm_source=premium') !== false) {
                $output_html .= '
                <style>
                    .row-container:has(.pwe-registration) .wpb_column:has(#katalog-'. self::$rnd_id .') {
                        position: relative;
                        background-image: url(/doc/header_mobile.webp);
                        background-repeat: no-repeat;
                        background-position: center;
                        background-size: cover;
                        padding: 0;
                    } 
                    .row-container:has(.pwe-registration) .wpb_column:has(#katalog-'. self::$rnd_id .'):before {
                        content: "";
                        position: absolute;
                        top: 60%;
                        right: 0;
                        bottom: 0;
                        left: 0;
                        margin: auto;
                        max-width: 300px;
                        height: auto;
                        background-image: url(/doc/logo.webp);
                        background-repeat: no-repeat;
                        background-size: contain;
                        transform: translateY(-60%);
                    }
                </style>';
            } else if (strpos($current_page, 'zostan-wystawca') || strpos($current_page, 'become-an-exhibitor')) {
                $output_html .= '
                <style>
                    .row-container:has(.pwe-registration) .wpb_column:has(#katalog-'. self::$rnd_id .'),
                    .row-container:has(.pwe-registration) .wpb_column:has(#katalog-'. self::$rnd_id .') * {
                        width: 100%;
                        height: 100%;
                    }
                    #katalog-'. self::$rnd_id .' {
                        position: relative;
                        background-image: url(/doc/header_mobile.webp);
                        background-repeat: no-repeat;
                        background-position: center;
                        background-size: cover;
                        padding: 0;
                    } 
                    #katalog-'. self::$rnd_id .':before {
                        content: "";
                        position: absolute;
                        top: 60%;
                        right: 0;
                        bottom: 0;
                        left: 0;
                        margin: auto;
                        max-width: 300px;
                        height: auto;
                        background-image: url(/doc/logo.webp);
                        background-repeat: no-repeat;
                        background-size: contain;
                        transform: translateY(-60%);
                    }
                </style>';
            } 
        }

        $output_html .= '
            <style>
                #katalog-'. self::$rnd_id .' .pwe-text-color {
                    text-align: center;
                    color:' . $text_color . ';
                }
                #katalog-'. self::$rnd_id .' .custom-link {
                    color: '. $btn_text_color .';
                    background-color: '. $btn_color .';
                    border: 1px solid '. $btn_border .';
                }
                #katalog-'. self::$rnd_id .' .custom-link:hover {
                    color: '. $btn_text_color .';
                    background-color: '. $darker_btn_color .'!important;
                    border: 1px solid '. $darker_btn_color .'!important;
                }
            </style>

            <div id="katalog-' . self::$rnd_id . '" class="exhibitors-catalog">' . $output . '</div>';

        return $output_html;
    }
}