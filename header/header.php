<?php

class PWEHeader {
    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        require_once plugin_dir_path(__FILE__) . '/../logotypes/logotypes-additional.php';
        require_once plugin_dir_path(__FILE__) . '/../elements/association.php';

        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        
        add_action('vc_before_init', array($this, 'inputRange'));
        add_action('vc_before_init', array($this, 'pweCheckbox'));

        add_action('init', array($this, 'initVCMapHeader'));
        add_shortcode('pwe_header', array($this, 'PWEHeaderOutput'));
    }

    /**
     * Initialize VC Map Elements.
     */
    public function initVCMapHeader() {
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __('PWE Header', 'pwe_header'),
                'base' => 'pwe_header',
                'category' => __('PWE Elements', 'pwe_header'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
                'admin_enqueue_js' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendscript.js',
                'params' => array_merge(
                    array(
                        // colors setup
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select text color <a href="#" onclick="yourFunction(`text_color_manual_hidden`, `text_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'text_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select text color for the element.', 'pwe_header'),
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
                            'group' => 'PWE Element',
                            'heading' => __('Write text color <a href="#" onclick="yourFunction(`text_color`, `text_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for text color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select text shadow color <a href="#" onclick="yourFunction(`text_shadow_color_manual_hidden`, `text_shadow_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'text_shadow_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select shadow text color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'text_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write text shadow color <a href="#" onclick="yourFunction(`text_shadow_color`, `text_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'text_shadow_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for text shadow color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true,
                        ),                        
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select button color <a href="#" onclick="yourFunction(`btn_color_manual_hidden`, `btn_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'btn_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select button color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write button color <a href="#" onclick="yourFunction(`btn_color`, `btn_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'btn_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select button text color <a href="#" onclick="yourFunction(`btn_text_color_manual_hidden`, `btn_text_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'btn_text_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select button text color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_text_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write button text color <a href="#" onclick="yourFunction(`btn_text_color`, `btn_text_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'btn_text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button text color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color_manual_hidden`, `btn_shadow_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'btn_shadow_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select button shadow color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_shadow_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color`, `btn_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'btn_shadow_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button shadow color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true
                        ),    
                        array(
                            'type' => 'checkbox',
                            'group' => 'PWE Element',
                            'heading' => __('Simple mode', 'pwe_header'),
                            'param_name' => 'pwe_header_simple_mode',
                            'admin_label' => true,
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Background position', 'pwe_header'),
                            'param_name' => 'pwe_header_bg_position',
                            'value' => array(
                              'Top' => 'top',
                              'Center' => 'center',
                              'Bottom' => 'bottom'
                            ),
                            'std' => 'center',
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'PWE Element',
                            'heading' => __('Turn on buttons', 'pwe_header'),
                            'param_name' => 'pwe_header_button_on',
                            'description' => __('Select options to display button:', 'pwe_header'),
                            'admin_label' => true,
                            'save_always' => true,
                            'value' => array(
                              __('register', 'pwe_header') => 'register',
                              __('ticket', 'pwe_header') => 'ticket',
                              __('conference', 'pwe_header') => 'conference',
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Tickets button link', 'pwe_header'),
                            'description' => __('Default (/bilety/ - PL), (/en/tickets/ - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_tickets_button_link',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Register button link', 'pwe_header'),
                            'description' => __('Default (/rejestracja/ - PL), (/en/registration/ - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_register_button_link',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Conferences button link', 'pwe_header'),
                            'description' => __('Default (/wydarzenia/ - PL), (/en/conferences/ - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_conferences_button_link',
                            'save_always' => true,
                            
                        ),
                        array(
                            'type' => 'textarea_raw_html',
                            'group' => 'PWE Element',
                            'heading' => __('Conferences custom title', 'pwe_header'),
                            'description' => __('Default (Konferencje - PL), (Conferences - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_conferences_title',
                            'param_holder_class' => 'backend-textarea-raw-html',
                            'save_always' => true,
                            'value' => base64_encode($pwe_header_conferences_title),
                        ),
                        array(
                            'type' => 'colorpicker',
                            'group' => 'PWE Element',
                            'heading' => __('Overlay color', 'pwe_header'),
                            'param_name' => 'pwe_header_overlay_color',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'input_range',
                            'group' => 'PWE Element',
                            'heading' => __('Overlay opacity', 'pwe_header'),
                            'param_name' => 'pwe_header_overlay_range',
                            'value' => '0',
                            'min' => '0',
                            'max' => '1',
                            'step' => '0.01',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'PWE Element',
                            'heading' => __('Main logo color', 'pwe_header'),
                            'param_name' => 'pwe_header_logo_color',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        array(
                            'type' => 'input_range',
                            'group' => 'PWE Element',
                            'heading' => __('Max width logo (px)', 'pwe_header'),
                            'description' => __('Default 400px', 'pwe_header'),
                            'param_name' => 'pwe_header_logo_width',
                            'value' => '400',
                            'min' => '100',
                            'max' => '600',
                            'step' => '1',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'PWE Element',
                            'heading' => __('No margin&padding main logo', 'pwe_header'),
                            'param_name' => 'pwe_header_logo_marg_pag',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'PWE Element',
                            'heading' => __('Additional buttons', 'pwe_header'),
                            'param_name' => 'pwe_header_buttons',
                            'params' => array(
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('URL', 'pwe_header'),
                                    'param_name' => 'pwe_header_button_link',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => __('Text', 'pwe_header'),
                                    'param_name' => 'pwe_header_button_text',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                            ),
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'Logotypes',
                            'heading' => __('Logotypes', 'pwe_header'),
                            'param_name' => 'pwe_header_logotypes',
                            'params' => array(
                                array(
                                'type' => 'attach_images',
                                'heading' => __('Logotypes catalog', 'pwe_header'),
                                'param_name' => 'logotypes_media',
                                'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Logotypes catalog', 'pwe_header'),
                                    'param_name' => 'logotypes_catalog',
                                    'description' => __('Put catalog name in /doc/ where are logotypes.', 'pwe_header'),
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Logotypes Title', 'pwe_header'),
                                    'param_name' => 'logotypes_title',
                                    'description' => __('Set title to diplay over the gallery', 'pwe_header'),
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'input_range',
                                    'heading' => __('Gallery width (%)', 'pwe_header'),
                                    'param_name' => 'logotypes_width',
                                    'value' => '100',
                                    'min' => '0',
                                    'max' => '100',
                                    'step' => '1',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Turn off slider', 'pwe_header'),
                                    'param_name' => 'logotypes_slider_off',
                                    'save_always' => true,
                                    'value' => array(__('True', 'pwe_header') => 'true',),
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Logotypes width (___px)', 'pwe_header'),
                                    'param_name' => 'logotypes_items_width',
                                    'save_always' => true,
                                ),
                            ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Congress widget',
                            'heading' => __('Turn off widget', 'pwe_header'),
                            'param_name' => 'pwe_congress_widget_off',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Title widget', 'pwe_header'),
                            'description' => __('Default (Konferencje - PL), (Conference - EN)', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_title',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Button text', 'pwe_header'),
                            'description' => __('Default (WEŹ UDZIAŁ - PL), (TAKE PART - EN)', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_button',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Button link', 'pwe_header'),
                            'description' => __('Default (/rejestracja/ - PL), (/en/registration/ - EN)', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_button_link',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Buttons width', 'pwe_header'),
                            'description' => __('Default 200px', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_buttons_width',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'colorpicker',
                            'group' => 'Congress widget',
                            'heading' => __('Congress accent color', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_color',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'Congress widget',
                            'heading' => __('Congress items', 'pwe_header'),
                            'param_name' => 'pwe_congress_widget_items',
                            'params' => array(
                                array(
                                    'type' => 'attach_image',
                                    'heading' => __('Congress image', 'pwe_header'),
                                    'param_name' => 'congress_item_image',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Congress link', 'pwe_header'),
                                    'description' => __('Default (/wydarzenia/ - PL), (/en/conferences/ - EN)', 'pwe_header'),
                                    'param_name' => 'congress_item_link',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Caption text', 'pwe_header'),
                                    'description' => __('Default (Dowiedz się więcej - PL), (Find out more - EN)', 'pwe_header'),
                                    'param_name' => 'congress_item_caption',
                                    'save_always' => true,
                                ),
                            ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Aditional options',
                            'heading' => __('Logotypes color', 'pwe_header'),
                            'param_name' => 'logotypes_slider_logo_color',
                            'description' => __('Check if you want to change the logotypes white to color. ', 'pwe_header'),
                            'admin_label' => true,
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),   
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Aditional options',
                            'heading' => __('Association fair logo white', 'pwe_header'),
                            'param_name' => 'association_fair_logo_white',
                            'description' => __('Check if you want to change the logotypes color to white. ', 'pwe_header'),
                            'admin_label' => true,
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        // Add additional options from class extends
                        ...PWElementAdditionalLogotypes::additionalArray(),
                        // array(
                        //     "type" => "pwe_checkbox",
                        //     'group' => 'test',
                        //     "heading" => __("Custom Checkbox", "pwe_header"),
                        //     "param_name" => "test",
                        //     "description" => __("Enable or disable feature.", "pwe_header"),
                        //     'admin_label' => true,
                        //     'save_always' => true,
                        // ),
                    )
                ),
            ));
        }
    }

    /**
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('css/style.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'css/style.css');
        wp_enqueue_style('pwelement-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts(){
        $js_file = plugins_url('js/script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'js/script.js');
        wp_enqueue_script('pwelement-js', $js_file, array('jquery'), $js_version, true);
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
     * Finding preset colors pallet.
     *
     * @return array
     */
    public function findPalletColors(){
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
            return $pl;
        } else {
            return $en;
        }
    }

    /**
     * Laguage check for text
     * 
     * @param bool $logo_color schould logo be in color.
     * @return string
     */
    public static function findBestLogo($logo_color = false){
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

            case(get_locale() == 'en_EN'):
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
    public static function findAllImages($firstPath, $image_count,  $secondPath = '/doc/galeria'){
        $firstPath = $_SERVER['DOCUMENT_ROOT'] . $firstPath;
        
        if (is_dir($firstPath) && !empty(glob($firstPath . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE))) {
            $exhibitorsImages = glob($firstPath . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
        } else {
            $secondPath = $_SERVER['DOCUMENT_ROOT'] . $secondPath;
            $exhibitorsImages = glob($secondPath . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
        }
        $count = 0;
        foreach($exhibitorsImages as $image){
            if($count >= $image_count){
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
    public static function findBestFile($file_path){
        $filePaths = array(
            '.webp',
            '.jpg',
            '.png'
        );

        foreach($filePaths as $com){
            if(file_exists(ABSPATH . $file_path . $com)){
                return $file_path . $com;
            }
        }
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
            . 'value="true" '
            . $checked
            . ' onclick="this.value = this.checked ? \'true\' : \'\';" />'
            . '</div>';
    }

    
    /**
     * Output method for PWelement shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Shortcode content.
     * @return string
     */
    public function PWEHeaderOutput($atts, $content = null) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . ' !important';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . ' !important; border-width: 0 !important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black') . '!important';
        $btn_shadow_color = '9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'white') . ' !important';
        $btn_border = '1px solid ' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black') . ' !important';
        
        if ($text_color == '' || $text_color == '#000000 !important' || $text_color == 'black !important') {
            $text_shadow = 'white !important;';
        } else {
            $text_shadow = 'black !important;';
        }

        extract( shortcode_atts( array(
            'pwe_header_button_on' => '',
            'pwe_header_simple_mode' => '',
            'pwe_header_bg_position' => '',
            'pwe_header_tickets_button_link' => '',
            'pwe_header_register_button_link' => '',
            'pwe_header_conferences_button_link' => '',
            'pwe_header_buttons' => '',
            'pwe_header_conferences_title' => '',
            'pwe_header_logotypes' => '',
            'pwe_header_overlay_color' => '',
            'pwe_header_overlay_range' => '',
            'pwe_header_logo_width' => '',
            'pwe_header_logo_color' => '',
            'pwe_header_logo_marg_pag' => '',
            'association_fair_logo_white' => '',
            'pwe_congress_widget_off' => '',
            'pwe_congress_widget_title' => '',
            'pwe_congress_widget_button' => '',
            'pwe_congress_widget_button_link' => '',
            'pwe_congress_widget_buttons_width' => '',
            'pwe_congress_widget_color' => '',
            'pwe_congress_widget_items' => '',
            // 'test' => '',
        ), $atts ));

        // var_dump($test);

        $pwe_header_logo_width = ($pwe_header_logo_width == '') ? '400px' : $pwe_header_logo_width;
        $pwe_header_logo_width = str_replace("px", "", $pwe_header_logo_width);

        $output = '
            <style>
                .row-parent:has(.pwelement_'. SharedProperties::$rnd_id.' .pwe-header) {
                    max-width: 100%;
                    padding: 0 !important;  
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                    min-height: 60vh;
                    max-width: 1200px;
                    margin: 0 auto;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-container:before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: '. $pwe_header_overlay_color .';
                    opacity: '. $pwe_header_overlay_range .';
                    z-index: 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                    max-width: 750px;
                    justify-content: space-evenly;
                    align-items: center;
                    display: flex;
                    flex-direction: column;
                    padding: 36px 18px;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-background {
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo {
                    max-width: '. $pwe_header_logo_width .'px !important;
                    width: 100%;
                    height: auto;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .header-button a {
                    padding: 0 !important;
                    height: 70px;
                    display: flex;
                    flex-flow: column;
                    align-items: center;
                    justify-content: center;
                    text-transform: uppercase;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-buttons {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 20px;
                    padding: 18px 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-btn-container {
                    width: 320px;
                    height: 75px;
                    padding: 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-btn {
                    background-color: '. $btn_color .';
                    color: '. $btn_text_color .';
                    box-shadow: '. $btn_shadow_color .';
                    border: '. $btn_border .';
                    width: 100%;
                    height: 100%;
                    transform: scale(1) !important;
                    transition: .3s ease;
                    font-size: 15px;
                    font-weight: 600;
                    padding: 6px 18px !important;
                    letter-spacing: 0.1em;
                    text-align: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-btn:hover {
                    color: #000000 !important;
                    background-color: #ffffff !important;
                    border: 1px solid #000000 !important;
                    box-shadow: 9px 9px 0px -5px '. $btn_color .';
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                    padding: 18px 0;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text :is(h1, h2), .pwe-header .pwe-logotypes-title h4 {
                    color: '. $text_color .';
                    text-shadow: 2px 2px '. $text_shadow .';
                    text-transform: uppercase;
                    text-align: center;
                    width: auto;
                }             
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-logotypes-title {
                    justify-content: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-logotypes-title h4 {
                    box-shadow: 9px 9px 0px -6px '. $text_color .';
                }   
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h1 {
                    font-size: 30px;
                } 
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h2 {
                    font-size: 36px;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-container-logotypes-gallery {
                    position: relative;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logotypes {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    max-width: 1200px;
                    width: 100%;
                    margin: 0 auto;
                    padding: 0 18px 36px;
                    gap: 18px;
                    opacity: 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-association {
                    padding: 0 18px 36px;
                    opacity: 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-header-curled-sheet {
                    z-index: 1;
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 400px;
                }

                @media (max-width: 1200px) {
                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-header-curled-sheet {
                        display: none;
                    }
                }

                @media (min-width: 300px) and (max-width: 1200px) {
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header-text h1 {
                        font-size: calc(24px + (30 - 24) * ( (100vw - 300px) / (1200 - 300) ));
                    }
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header-text h2 {
                        font-size: calc(28px + (36 - 28) * ( (100vw - 300px) / (1200 - 300) ));
                    }
                }
                
                @media (max-width: 960px) {
                    .row-parent:has(.pwelement_'.SharedProperties::$rnd_id.' .pwe-header) {
                        padding: 0 !important;
                    }
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header-logotypes .pwe-container-logotypes-gallery {
                        width: 100% !important;
                    }
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header .pwe-btn-container {
                        width: 260px;
                        height: 70px;
                    }
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header .pwe-btn {
                        font-size: 13px;
                    }
                }
            </style>';
 
            $partnerImages = glob($_SERVER['DOCUMENT_ROOT'] . '/doc/partnerzy/*.{jpeg,jpg,png,webp,JPG,PNG,JPEG,WEBP}', GLOB_BRACE);
            $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
            $base_url .= "://".$_SERVER['HTTP_HOST'];

            $trade_fair_name = (get_locale() == 'pl_PL') ? '[trade_fair_name]' : '[trade_fair_name_eng]';
            $trade_fair_desc = (get_locale() == 'pl_PL') ? '[trade_fair_desc]' : '[trade_fair_desc_eng]';
            $trade_fair_date = (get_locale() == 'pl_PL') ? '[trade_fair_date]' : '[trade_fair_date_eng]';

            if($pwe_header_logo_color != 'true') {
                if (get_locale() == 'pl_PL') {
                    $logo_url = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo.webp') ? '/doc/logo.webp' : '/doc/logo.png');
                } else {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-en.webp') || file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-en.png')) {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-en.webp') ? "/doc/logo-en.webp" : "/doc/logo-en.png";
                    } else {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo.webp') ? "/doc/logo.webp" : "/doc/logo.png";
                    }  
                }
            } else {
                if (get_locale() == 'pl_PL') {
                    $logo_url = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color.webp') ? '/doc/logo-color.webp' : '/doc/logo-color.png');
                } else {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color-en.webp') || file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color-en.png')) {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color-en.webp') ? "/doc/logo-color-en.webp" : "/doc/logo-color-en.png";
                    } else {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color.webp') ? "/doc/logo-color.webp" : "/doc/logo-color.png";
                    }
                }
            }

            $file_path_header_background = glob('doc/background.*');
            if (!empty($file_path_header_background)) {
                $file_path_header_background = $file_path_header_background[0];
                $file_url = $base_url . '/' . $file_path_header_background;
            }

            if ($pwe_header_simple_mode == 'true') {
                $output .= '
                    <style>
                        .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                            padding: 36px;
                        }
                        
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                            min-height: auto !important;
                        }
                        
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                            display: flex;
                            flex-direction: column-reverse;
                        }
                        
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h2 {
                            font-size: calc(28px + (40 - 28) * ( (100vw - 300px) / (1200 - 300) ));
                        }
                        
                        @media (min-width: 960px) {
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                                min-height: 350px !important;
                                height: 350px;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                                max-width: 1200px;
                                flex-direction: row;
                            }
                        }
                    </style>';
            }

            if ($pwe_header_logo_marg_pag == 'true') {
                $output .= '
                    <style>
                        .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                            padding: 0 18px 36px;
                        }
                        
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                            padding: 0 0 18px;
                        }
                        
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h1 {
                            margin: 0;
                        }
                    </style>';
            }

            $positions = ['top', 'center', 'bottom'];
            foreach ($positions as $position) {
                if (in_array($position, explode(',', $pwe_header_bg_position))) {
                    $output .= '
                        <style>
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-background {
                                background-position: '. $position .' !important;
                            } 
                        </style>';
                    break;
                }
            }


        $output .= '<div id="pweHeader" class="pwe-header">

            <div style="background-image: url('. $file_url .');"  class="pwe-header-container pwe-header-background">
                <div class="pwe-header-wrapper">
                    <div class="header-wrapper-column">
                        
                        <img class="pwe-header-logo" src="'. $logo_url .'" alt="logo-'. $trade_fair_name .'">

                        <div class="pwe-header-text">
                            <h1>'. $trade_fair_desc .'</h1>
                            <h2>'. $trade_fair_date .'</h2>
                        </div>';  
                        
                        if ($pwe_header_simple_mode != 'true') {

                            $output .= '<div class="pwe-header-buttons">';
                                
                                if (get_locale() == 'pl_PL') {
                                    $pwe_header_tickets_button_link = empty($pwe_header_tickets_button_link) ? "/bilety/" : $pwe_header_tickets_button_link;
                                    $pwe_header_register_button_link = empty($pwe_header_register_button_link) ? "/rejestracja/" : $pwe_header_register_button_link;
                                    $pwe_header_conferences_button_link = empty($pwe_header_conferences_button_link) ? "/wydarzenia/" : $pwe_header_conferences_button_link;
                                } else {
                                    $pwe_header_tickets_button_link = empty($pwe_header_tickets_button_link) ? "/en/tickets/" : $pwe_header_tickets_button_link;
                                    $pwe_header_register_button_link = empty($pwe_header_register_button_link) ? "/en/registration/" : $pwe_header_register_button_link;
                                    $pwe_header_conferences_button_link = empty($pwe_header_conferences_button_link) ? "/en/conferences/" : $pwe_header_conferences_button_link;
                                }
                                
                                $target_blank = (strpos($pwe_header_conferences_button_link, 'http') !== false) ? 'target="blank"' : '';

                                if (in_array('register', explode(',', $pwe_header_button_on))) {
                                    $output .='<div id="pweBtnRegistration" class="pwe-btn-container header-button">';
                                        $output .= '<a class="pwe-link pwe-btn" href="'. $pwe_header_register_button_link .'" '. 
                                                        self::languageChecker(
                                                            <<<PL
                                                            alt="link do rejestracji">Zarejestruj się<span style="display: block; font-weight: 300;">Odbierz darmowy bilet</span>
                                                            PL,
                                                            <<<EN
                                                            alt="link to registration">Register<span style="display: block; font-weight: 300;">Get a free ticket</span>
                                                            EN
                                                        )
                                                    .'</a>';   
                                        $output .='</div>';
                                }
                                if (in_array('ticket', explode(',', $pwe_header_button_on))) {
                                    $output .= '<div id="pweBtnTickets" class="pwe-btn-container header-button">';
                                        $output .= '<a class="pwe-link pwe-btn" href="'. $pwe_header_tickets_button_link .'" '. 
                                                        self::languageChecker(
                                                            <<<PL
                                                            alt="link do biletów">Kup bilet
                                                            PL,
                                                            <<<EN
                                                            alt="link to tickets">Buy a ticket
                                                            EN
                                                        )
                                                    .'</a>';
                                    $output .= '</div>';
                                }
                                if (in_array('conference', explode(',', $pwe_header_button_on))) {
                                    if (empty($pwe_header_conferences_title)) {
                                        $pwe_header_conferences_title = (get_locale() == 'pl_PL') ? 'KONFERENCJE' : 'CONFERENCES';
                                    } else {
                                        $pwe_header_conferences_title = urldecode(base64_decode($pwe_header_conferences_title));
                                    }
                                    $output .= '<div id="pweBtnConferences" class="pwe-btn-container header-button">';
                                    $output .= '<a class="pwe-link pwe-btn" href="'. $pwe_header_conferences_button_link .'" '. $target_blank .' title="'.
                                                    self::languageChecker(
                                                        <<<PL
                                                        konferencje
                                                        PL,
                                                        <<<EN
                                                        conferences
                                                        EN
                                                    ).'">'. $pwe_header_conferences_title 
                                                .'</a>';
                                    $output .= '</div>';
                                }

                                $pwe_header_buttons_urldecode = urldecode($pwe_header_buttons);
                                $pwe_header_buttons_json = json_decode($pwe_header_buttons_urldecode, true);
                                if (is_array($pwe_header_buttons_json)) {
                                    foreach ($pwe_header_buttons_json as $button) {
                                        $button_url = $button["pwe_header_button_link"];
                                        $button_text = $button["pwe_header_button_text"];

                                        $target_blank_aditional = (strpos($button_url, 'http') !== false) ? 'target="blank"' : '';
                                        if(!empty($button_url) && !empty($button_text) ) {
                                            $output .= '<div class="pwe-btn-container header-button">
                                                <a class="pwe-link pwe-btn" href="'. $button_url .'" '. $target_blank_aditional .' alt="'. $button_url .'">'. $button_text .'</a>
                                            </div>';
                                        } 
                                    }
                                }
                            
                            $output .= '</div>';
                        }

                    $output .= '</div>';

                    if ($pwe_header_simple_mode != 'true') {

                        if ($pwe_congress_widget_off != 'true') {
                            require_once plugin_dir_path(__FILE__) . '/../widgets/congress-widget.php';
                        }

                        // Accompanying Fairs
                        if ($association_fair_logo_white == 'true') {
                            $output .= '<style>
                                            .pwe-association-logotypes .as-side .pwe-as-logo,
                                            .pwe-association-logotypes .slides div {
                                                filter: brightness(0) invert(1);
                                                transition: all .3s ease;
                                            }
                                            .pwe-association-logotypes .slides .as-primary div {
                                                filter: inherit;
                                            }
                                        </style>';
                        }
                        $output .= PWElementAssociates::output($atts);
                        
                    }

                    
                    $pwe_header_logotypes_urldecode = urldecode($pwe_header_logotypes);
                    $pwe_header_logotypes_json = json_decode($pwe_header_logotypes_urldecode, true);
                    if ($pwe_header_simple_mode != 'true') {
                        if (is_array($pwe_header_logotypes_json) && !empty($pwe_header_logotypes_json)) {
                            $output .= '<div class="pwe-header-logotypes">';
                                foreach ($pwe_header_logotypes_json as $logotypes) {
                                    $logotypes_width = $logotypes["logotypes_width"];
                                    $logotypes_media = $logotypes["logotypes_media"];
                                    $logotypes_catalog = $logotypes["logotypes_catalog"];
                                    if(!empty($logotypes_catalog) || !empty($logotypes_media)) {
                                        // Adding the result from additionalOutput to $output
                                        $output .= PWElementAdditionalLogotypes::additionalOutput($atts, $logotypes);
                                    }
                                }
                            $output .= '</div>';
                        }
                    }
                    
                    if ($pwe_header_simple_mode != 'true') {
                        require_once plugin_dir_path(__FILE__) . '/../widgets/parking-widget.php';
                        
                        if (count($pwe_congress_widget_items_json) == 1 && !empty($congress_image_url)) {
                            $output .= '<div class="pwe-header-curled-sheet"><img src="/wp-content/plugins/PWElements/media/zawijas.png" alt="zawijas"></div>';
                        } 
                    }
                    
                $output .= '</div>
            </div>
            
        </div>';



        if (glob($_SERVER['DOCUMENT_ROOT'] . '/doc/header_mobile.webp', GLOB_BRACE)) {
            $output .= '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                if (window.innerWidth <= 569) {
                                    const pweHeaderBg = document.querySelector("#pweHeader .pwe-header-container");
                                    if (pweHeaderBg) {
                                        pweHeaderBg.style.backgroundImage = "url(/doc/header_mobile.webp)";
                                    }
                                }  
                            });
                        </script>';
        } 

        $output .= '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const pweLogotypesElement = document.querySelector(".pwelement_'.SharedProperties::$rnd_id.' .pwe-header-logotypes");
                            if ((pweLogotypesElement && pweLogotypesElement.children.length === 0)) {
                                pweLogotypesElement.classList.add("desktop-hidden", "tablet-hidden", "mobile-hidden");
                            }

                            // Lazy loading effect
                            if (document.querySelector(".pwe-header-logotypes")) {
                                const logotypesElements = document.querySelectorAll(".pwe-header-logotypes");
                                logotypesElements.forEach(item => {
                                    item.style.opacity = 1;
                                    item.style.transition = "opacity 0.3s ease";
                                });
                            }
                            if (document.querySelector(".pwe-association")) {
                                const associationElement = document.querySelector(".pwe-association");
                                associationElement.style.opacity = 1;
                                associationElement.style.transition = "opacity 0.3s ease";
                            }
                        });
                    </script>';
        
        $output = do_shortcode($output);
        
        $file_cont = '<div class="pwelement pwelement_'.SharedProperties::$rnd_id.'">' . $output . '</div>';

        return $file_cont;
    }
}
