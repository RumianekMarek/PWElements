<?php

class PWEDisplayInfo {
    public static $rnd_id;
    // public static $fair_colors;
    // public static $accent_color;
    // public static $main2_color;

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        self::$rnd_id = rand(10000, 99999);
        // self::$fair_colors = $this->findPalletColors();
        // self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

        // foreach(self::$fair_colors as $color_key => $color_value){
        //     if(strpos($color_key, 'main2') != false){
        //         self::$main2_color = $color_value;
        //     }
        // }

        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        
        add_action('init', array($this, 'initVCMapPWEDisplayInfo'));
        add_shortcode('pwe_display_info', array($this, 'PWEDisplayInfoOutput'));
    }

    /**
     * Initialize VC Map PWEDisplayInfo.
     */
    public function initVCMapPWEDisplayInfo() {

        require_once plugin_dir_path(__FILE__) . 'display-info-box.php';
        require_once plugin_dir_path(__FILE__) . 'display-info-speakers.php';

        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map( array(
                'name' => __( 'PWE Display info', 'pwe_display_info'),
                'base' => 'pwe_display_info',
                'category' => __( 'PWE Elements', 'pwe_display_info'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
                'params' => array_merge(
                    array(
                        array(
                            'type' => 'dropdown',
                            'group' => 'main',
                            'heading' => __( 'Display info format', 'pwe_display_info'),
                            'param_name' => 'display_info_format',
                            'description' => __( 'Select format.', 'pwe_display_info'),
                            'param_holder_class' => 'backend-textfield',
                            'value' => array(
                                'Display info box' => 'PWEDisplayInfoBox',
                                'Display info speakers' => 'PWEDisplayInfoSpeakers',
                            ),
                            'save_always' => true,
                            'admin_label' => true
                        ),
                        ...PWEDisplayInfoBox::initElements(),
                        ...PWEDisplayInfoSpeakers::initElements(),
                    ),
                ),
            ));
        }
    }

    /**
     * Get available elements for the dropdown.
     *
     * @return array
     */
    private function getAvailableElements() {
        // Creating an instance of elements to choose from
        return array(
            'Info Box'         => 'PWEDisplayInfoBox',
            'Info Speakers'    => 'PWEDisplayInfoSpeakers',

        );
    }

    /**
     * Check class for file if exists.
     *
     * @return array
     */
    private function findClassElements() {
        // Array off class placement
        return array(
            'PWEDisplayInfoBox'         => 'display-info-box.php',
            'PWEDisplayInfoSpeakers'    => 'display-info-speakers.php',
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
        $css_file = plugins_url('display-info.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'display-info.css');
        wp_enqueue_style('pwe-display-info-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts($atts){
        $js_file = plugins_url('display-info.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'display-info.js');
        wp_enqueue_script('pwe-display-info-js', $js_file, array('jquery'), $js_version, true);
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
     * Output method for pwe_display_info shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Shortcode content.
     * @return string
     */
    public function PWEDisplayInfoOutput($atts, $content = null) {

        // pwe_display_info output
        extract( shortcode_atts( array(
            'display_info_format' => '',
        ), $atts ));

        if ($this->findClassElements()[$display_info_format]){
            require_once plugin_dir_path(__FILE__) . $this->findClassElements()[$display_info_format];
            
            if (class_exists($display_info_format)) {
                $output_class = new $display_info_format;
                $output = $output_class->output($atts, $content);
            } else {
                // Log if the class doesn't exist
                echo '<script>console.log("Class '. $display_info_format .' does not exist")</script>';
                $output = '';
            }
        } else {
            echo '<script>console.log("File with class ' . $display_info_format .' does not exist")</script>';
        }
        
        $output = do_shortcode($output);

        $display_info_word = $display_info_format == 'PWEDisplayInfoBox' ? 'box' : 'speaker';

        $output_html = '<div id="info-'. $display_info_word . '-' . self::$rnd_id . '" class="info-'. $display_info_word .'">' . $output . '</div>';

        return $output_html;
    }
}