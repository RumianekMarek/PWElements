<?php

class PWELogotypes extends PWECommonFunctions {
    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        self::$rnd_id = $this->id_rnd();
        self::$fair_colors = $this->findPalletColors();
        self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

        foreach(self::$fair_colors as $color_key => $color_value){
            if(strpos($color_key, 'main2') != false){
                self::$main2_color = $color_value;
            }
        }

        require_once plugin_dir_path(__FILE__) . '/../logotypes/logotypes-additional.php';
        
        
         // Hook actions
        add_action('init', array($this, 'initVCMapLogotypes'));
        add_shortcode('pwe_logotypes', array($this, 'PWELogotypesOutput'));
    }

    /**
     * Initialize VC Map Elements.
     */
    public function initVCMapLogotypes() {
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __('PWE Logotypes', 'pwe_logotypes'),
                'base' => 'pwe_logotypes',
                'category' => __('PWE Elements', 'pwe_logotypes'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
                'admin_enqueue_js' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendscript.js',
                'params' => array_merge(
                    array(
                        // colors setup
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select text color <a href="#" onclick="yourFunction(`text_color_manual_hidden`, `text_color`)">Hex</a>', 'pwe_logotypes'),
                            'param_name' => 'text_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select text color for the element.', 'pwe_logotypes'),
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
                            'heading' => __('Write text color <a href="#" onclick="yourFunction(`text_color`, `text_color_manual_hidden`)">Pallet</a>', 'pwe_logotypes'),
                            'param_name' => 'text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for text color for the element.', 'pwe_logotypes'),
                            'value' => '',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select text shadow color <a href="#" onclick="yourFunction(`text_shadow_color_manual_hidden`, `text_shadow_color`)">Hex</a>', 'pwe_logotypes'),
                            'param_name' => 'text_shadow_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select shadow text color for the element.', 'pwe_logotypes'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'text_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Write text shadow color <a href="#" onclick="yourFunction(`text_shadow_color`, `text_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_logotypes'),
                            'param_name' => 'text_shadow_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for text shadow color for the element.', 'pwe_logotypes'),
                            'value' => '',
                            'save_always' => true,
                        ),                        
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select button color <a href="#" onclick="yourFunction(`btn_color_manual_hidden`, `btn_color`)">Hex</a>', 'pwe_logotypes'),
                            'param_name' => 'btn_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select button color for the element.', 'pwe_logotypes'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Write button color <a href="#" onclick="yourFunction(`btn_color`, `btn_color_manual_hidden`)">Pallet</a>', 'pwe_logotypes'),
                            'param_name' => 'btn_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button color for the element.', 'pwe_logotypes'),
                            'value' => '',
                            'save_always' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select button text color <a href="#" onclick="yourFunction(`btn_text_color_manual_hidden`, `btn_text_color`)">Hex</a>', 'pwe_logotypes'),
                            'param_name' => 'btn_text_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select button text color for the element.', 'pwe_logotypes'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_text_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Write button text color <a href="#" onclick="yourFunction(`btn_text_color`, `btn_text_color_manual_hidden`)">Pallet</a>', 'pwe_logotypes'),
                            'param_name' => 'btn_text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button text color for the element.', 'pwe_logotypes'),
                            'value' => '',
                            'save_always' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'heading' => __('Select button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color_manual_hidden`, `btn_shadow_color`)">Hex</a>', 'pwe_logotypes'),
                            'param_name' => 'btn_shadow_color',
                            'param_holder_class' => 'main-options',
                            'description' => __('Select button shadow color for the element.', 'pwe_logotypes'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_shadow_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Write button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color`, `btn_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_logotypes'),
                            'param_name' => 'btn_shadow_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button shadow color for the element.', 'pwe_logotypes'),
                            'value' => '',
                            'save_always' => true
                        ),    
                        array(
                            'type' => 'attach_images',
                            'group' => 'PWE Element',
                            'heading' => __('Select Images', 'pwe_logotypes'),
                            'param_name' => 'logotypes_media',
                            'description' => __('Choose images from the media library.', 'pwe_logotypes'),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => esc_html__('Logotypes catalog', 'pwe_logotypes'),
                            'param_name' => 'logotypes_catalog',
                            'description' => __('Put catalog name in /doc/ where are logotypes.', 'pwe_logotypes'),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => esc_html__('Title', 'pwe_logotypes'),
                            'param_name' => 'logotypes_title',
                            'description' => __('Set title to diplay over the gallery', 'pwe_logotypes'),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => esc_html__('Logotypes name', 'pwe_logotypes'),
                            'param_name' => 'logotypes_name',
                            'description' => __('Set custom name thumbnails', 'pwe_logotypes'),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'PWE Element',
                            'heading' => __('Turn on captions', 'pwe_header'),
                            'param_name' => 'logotypes_caption_on',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Aditional options',
                            'heading' => __('Logotypes white', 'pwe_logotypes'),
                            'param_name' => 'logotypes_slider_logo_white',
                            'description' => __('Check if you want to change the logotypes color to white. ', 'pwe_logotypes'),
                            'admin_label' => true,
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_logotypes') => 'true',),
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'Replace Strings',
                            'param_name' => 'pwe_replace',
                            'params' => array(
                                array(
                                    'type' => 'textarea',
                                    'heading' => __('Input HTML', 'pwelement'),
                                    'param_name' => 'input_replace_html',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => __('Output HTML', 'pwelement'),
                                    'param_name' => 'output_replace_html',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                            ),
                        ),
                        // Add additional options from class extends
                        ...PWElementAdditionalLogotypes::additionalArray(),
                    )
                ),
            ));
        }
    }
 

    /**
     * Output method for PWelement shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Shortcode content.
     * @return string
     */
    public function PWELogotypesOutput($atts, $content = null) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important';
        
        extract( shortcode_atts( array(
            'pwe_replace' => '',
        ), $atts ));

        $el_id = self::id_rnd();

        $output = '';
        
        // Replace strings
        $pwe_replace_urldecode = urldecode($pwe_replace);
        $pwe_replace_json = json_decode($pwe_replace_urldecode, true);
        $input_replace_array_html = array();
        $output_replace_array_html = array();
        
        if (is_array($pwe_replace_json)) {
            foreach ($pwe_replace_json as $replace_item) {
                $input_replace_array_html[] = $replace_item["input_replace_html"];
                $output_replace_array_html[] = $replace_item["output_replace_html"];
            }
        }
        
        // // Adding the result from additionalOutput to $output
        $output .= PWElementAdditionalLogotypes::additionalOutput($atts, $el_id);
        
        $output = do_shortcode($output);
        
        $file_cont = '<div class="pwelement pwelement_'. $el_id .'">' . $output . '</div>';

        if ($input_replace_array_html && $output_replace_array_html) {
            $file_cont = str_replace($input_replace_array_html, $output_replace_array_html, $file_cont);
        }

        return $file_cont;
    }
}
