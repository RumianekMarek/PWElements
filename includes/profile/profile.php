<?php 

/**
 * Class PWEProfile
 * Extends pwe_profiles class and defines a custom Visual Composer element for vouchers.
 */
class PWEProfile extends PWECommonFunctions {

    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    public static $fair_forms;

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        self::$rnd_id = rand(10000, 99999);
        self::$fair_forms = $this->findFormsGF();
        self::$fair_colors = $this->findPalletColors();
        self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

        foreach(self::$fair_colors as $color_key => $color_value){
            if(strpos($color_key, 'main2') != false){
                self::$main2_color = $color_value;
            }
        }
        
        // Hook actions
        add_action('init', array($this, 'initVCMapPWEProfile'));
        add_shortcode('pwe_profile', array($this, 'PWEProfileOutput'));
    }

    /**
     * Initialize VC Map PWEProfile.
     */
    public function initVCMapPWEProfile() { 

        require_once plugin_dir_path(__FILE__) . 'classes/profile-all-in-one.php';
        require_once plugin_dir_path(__FILE__) . 'classes/profile-single.php';
      
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map( array(
                'name' => __( 'PWE Profile', 'pwe_profile'),
                'base' => 'pwe_profile',
                'category' => __( 'PWE Elements', 'pwe_profile'),
                'admin_enqueue_css' => plugin_dir_url(dirname(dirname(__FILE__))) . 'backend/backendstyle.css',
                'params' => array_merge(
                    array( 
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select profile type', 'pwe_profile'),
                            'param_name' => 'profile_type',
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'save_always' => true,
                            'admin_label' => true,
                            'value' => array(
                                'All in one' => 'PWEProfileAllInOne',
                                'Single' => 'PWEProfileSingle', 
                            ),
                            'std' => 'PWEProfileAllInOne',
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select text color <a href="#" onclick="yourFunction(`text_color_manual_hidden`, `text_color`)">Hex</a>', 'pwe_profile'),
                            'param_name' => 'text_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select text color for the element.', 'pwe_profile'),
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
                            'heading' => __('Write text color <a href="#" onclick="yourFunction(`text_color`, `text_color_manual_hidden`)">Pallet</a>', 'pwe_profile'),
                            'param_name' => 'text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for text color for the element.', 'pwe_profile'),
                            'value' => '',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select button color <a href="#" onclick="yourFunction(`btn_color_manual_hidden`, `btn_color`)">Hex</a>', 'pwe_profile'),
                            'param_name' => 'btn_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select button color for the element.', 'pwe_profile'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Write button color <a href="#" onclick="yourFunction(`btn_color`, `btn_color_manual_hidden`)">Pallet</a>', 'pwe_profile'),
                            'param_name' => 'btn_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button color for the element.', 'pwe_profile'),
                            'value' => '',
                            'save_always' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select button text color <a href="#" onclick="yourFunction(`btn_text_color_manual_hidden`, `btn_text_color`)">Hex</a>', 'pwe_profile'),
                            'param_name' => 'btn_text_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select button text color for the element.', 'pwe_profile'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_text_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Write button text color <a href="#" onclick="yourFunction(`btn_text_color`, `btn_text_color_manual_hidden`)">Pallet</a>', 'pwe_profile'),
                            'param_name' => 'btn_text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button text color for the element.', 'pwe_profile'),
                            'value' => '',
                            'save_always' => true
                        ),
                        ...PWEProfileAllInOne::initElements(),
                        ...PWEProfileSingle::initElements(),
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
            'PWEProfileAllInOne'     => 'classes/profile-all-in-one.php',
            'PWEProfileSingle'      => 'classes/profile-single.php',
        );
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public function PWEProfileOutput($atts, $content = null) {

        extract( shortcode_atts( array(
            'profile_type' => '',
        ), $atts ));

        if ($this->findClassElements()[$profile_type]){
            require_once plugin_dir_path(__FILE__) . $this->findClassElements()[$profile_type];
            
            if (class_exists($profile_type)) {
                $output_class = new $profile_type;
                $output = $output_class->output($atts, $content);
            } else {
                // Log if the class doesn't exist
                echo '<script>console.log("Class '. $profile_type .' does not exist")</script>';
                $output = '';
            }
        } else {
            echo '<script>console.log("File with class ' . $profile_type .' does not exist")</script>';
        }
        
        $output = do_shortcode($output);

        $profile_el_id = $profile_type == 'PWEProfileAllInOne' ? 'ProfileAllInOne' : 'ProfileSingle'. self::$rnd_id;
        $profile_el_class = $profile_type == 'PWEProfileAllInOne' ? 'profile-all-in-one' : 'profile-single-'. self::$rnd_id;

        $output_html = '<div id="'. $profile_el_id .'" class="'. $profile_el_class .'">' . $output . '</div>';

        return $output_html;
    }
}