<?php 

/**
 * Class PWEConferenceCap
 */
class PWEConferenceCap {

    public static $exhibitor_logo_url;
    public static $exhibitor_name;
    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    public static $fair_forms;
    private $atts;

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {

        add_action('init', array($this, 'initElements'));
        add_shortcode('pwe_conference_cap', array($this, 'PWEConferenceCapOutput'));

        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        
    }


    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public function initElements() {
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __( 'PWE Conference CAP', 'pwe_exhibitor_generator'),
                'base' => 'pwe_conference_cap',
                'category' => __( 'PWE Elements', 'pwe_exhibitor_generator'),
                'admin_enqueue_css' => plugin_dir_url(dirname(__DIR__)) . 'backend/backendstyle.css',
                'class' => 'costam',
                'params' => array( 
                    array(
                        'type' => 'dropdown',
                        'group' => 'PWE Element',
                        'heading' => __('Select conference mode', 'pwe_conference_cap'),
                        'param_name' => 'conference_cap_conference_mode',
                        'save_always' => true,
                        'value' => array(
                            'Full Mode' => 'PWEConferenceCapFullMode',
                            'Simple Mode' => 'PWEConferenceCapSimpleMode',
                            'Medal Ceremony' => 'PWEConferenceCapMedalCeremony',
                        ),
                    ),
                    array(
                        'type' => 'param_group',
                        'group' => 'PWE Element',
                        'heading' => __('Custom Html', 'pwe_conference_cap'),
                        'param_name' => 'conference_cap_html',
                        'dependency' => array(
                            'element' => 'pwe_conference_cap',
                            'value' => 'PWEConferenceCap',
                        ),
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => __('Conference slug', 'pwe_conference_cap'),
                                'param_name' => 'conference_cap_html_conf_slug',
                                'save_always' => true,
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Position', 'pwe_conference_cap'),
                                'param_name' => 'conference_cap_html_position',
                                'value' => array(
                                    __('Before title', 'pwe_conference_cap') => 'before_title',
                                    __('After title', 'pwe_conference_cap') => 'after_title',
                                    __('Before day', 'pwe_conference_cap') => 'before_day',
                                    __('After day', 'pwe_conference_cap') => 'after_day',
                                ),
                                'description' => __('Choose where to insert the custom HTML.', 'pwe_conference_cap'),
                                'save_always' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Conference day', 'pwe_conference_cap'),
                                'param_name' => 'conference_cap_html_day',
                                'save_always' => true,
                            ),
                            array(
                                'type' => 'textarea_raw_html',
                                'heading' => __('Custom html', 'pwe_conference_cap'),
                                'param_name' => 'conference_cap_html_code',
                                'save_always' => true,
                            ),
                        ),
                    ), 
                )
            ));        
        }
    }


    public function addingStyles(){
        $css_file = plugins_url('assets/conference-cap-style.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/conference-cap-style.css');
        wp_enqueue_style('pwe-conference-cap-css', $css_file, array(), $css_version);
    }

        /**
     * Adding Scripts
     */
    public static function addingScripts($atts , $speakersDataMapping){
        $data = array(
            'data'   => $speakersDataMapping,
        );

        $js_file = plugins_url('assets/conference-cap-script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/conference-cap-script.js');
        wp_enqueue_script('pwe-conference-cap-js', $js_file, array('jquery'), $js_version, true);
        wp_localize_script('pwe-conference-cap-js', 'speakersData', $data);
        
    }
    
    

    public static function PWEConferenceCapOutput($atts) {

        require_once plugin_dir_path(__FILE__) . 'classes/conference-cap-functions.php';
        $conf_function = new PWEConferenceCapFunctions;

        extract(shortcode_atts(array(
            'conference_cap_html' => '',
            'conference_cap_conference_mode' => '',
        ), $atts));

        $mode_class = null;

        if($conference_cap_conference_mode == 'PWEConferenceCapFullMode'){

            require_once plugin_dir_path(__FILE__) . 'classes/conference-cap-full-mode/conference-cap-full-mode.php';
            $mode_class = new PWEConferenceCapFullMode;

            $css_file = plugins_url('classes/conference-cap-full-mode/conference-cap-full-mode-style.css', __FILE__);
            $css_version = filemtime(plugin_dir_path(__FILE__) . 'classes/conference-cap-full-mode/conference-cap-full-mode-style.css');
            wp_enqueue_style('conference-cap-full-mode-style', $css_file, array(), $css_version);

        }else if($conference_cap_conference_mode == 'PWEConferenceCapSimpleMode'){

            require_once plugin_dir_path(__FILE__) . 'classes/conference-cap-simple-mode/conference-cap-simple-mode.php';
            $mode_class = new PWEConferenceCapSimpleMode;

            $css_file = plugins_url('classes/conference-cap-simple-mode/conference-cap-simple-mode-style.css', __FILE__);
            $css_version = filemtime(plugin_dir_path(__FILE__) . 'classes/conference-cap-simple-mode/conference-cap-simple-mode-style.css');
            wp_enqueue_style('conference-cap-simple-mode-style', $css_file, array(), $css_version);

        }else if($conference_cap_conference_mode == 'PWEConferenceCapMedalCeremony'){

            require_once plugin_dir_path(__FILE__) . 'classes/conference-cap-medal-ceremony/conference-cap-medal-ceremony.php';
            $mode_class = new PWEConferenceCapMedalCeremony;

            $css_file = plugins_url('classes/conference-cap-medal-ceremony/conference-cap-medal-ceremony-style.css', __FILE__);
            $css_version = filemtime(plugin_dir_path(__FILE__) . 'classes/conference-cap-medal-ceremony/conference-cap-medal-ceremony-style.css');
            wp_enqueue_style('conference-cap-medal-ceremony-style', $css_file, array(), $css_version);

        }


       $database_data = $conf_function::getDatabaseDataConferences();

       var_dump($database_data);


        return $output;
    }        
}