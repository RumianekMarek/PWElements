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

        $conference_modes = PWEConferenceCapFunctions::findConferenceMode();

        if (isset($conference_modes[$conference_cap_conference_mode])) {
            $mode_data = $conference_modes[$conference_cap_conference_mode];
        
            // Załaduj odpowiedni plik PHP
            require_once plugin_dir_path(__FILE__) . $mode_data['php'];
        
            // Poprawne przypisanie klasy
            $class_name = $mode_data['class'];
            if (class_exists($class_name)) {
                $mode_class = new $class_name;
            } else {
                error_log("Nie znaleziono klasy: " . $class_name);
            }
        
            // Załaduj CSS
            $css_file = plugins_url($mode_data['css'], __FILE__);
            $css_version = filemtime(plugin_dir_path(__FILE__) . $mode_data['css']);
            wp_enqueue_style($class_name . '-style', $css_file, array(), $css_version);
        }
        


       $database_data = $conf_function::getDatabaseDataConferences();

       $output = '';

       $output = '<div id="conference_buttons_container">';

            foreach ($database_data as $conference) {
                if (isset($conference->conf_slug, $conference->conf_img)) {
                    $conference_slug = $conference->conf_slug;
                    $conference_img = $conference->conf_img;
                    $conference_name = $conference->conf_name;

                    if (!empty($conference_img)) {

                        $output .= "
                            <div id='{$conference_slug}__btn'>
                                <img src='{$conference_img}' alt='{$conference_name}'>
                            </div>
                        ";

                    }else {

                        $output .= "
                            <div id='{$conference_slug}__btn'>
                                <p>{$conference_name}</p>
                            </div>
                        ";

                    }
                }
            }

        // Zamknięcie kontenera
        $output .= '</div>';

        $output .=  "<div class='conference_days_container'>";
        

        foreach ($database_data as $conference) {
            if (isset($conference->conf_slug, $conference->conf_data)) {
                $conference_slug = $conference->conf_slug;
                $conference_days = json_decode($conference->conf_data, true); 
        
                if (!empty($conference_days)) {
                    $day_counter = 1;
                    foreach ($conference_days as $day_name => $day_data) {
                        $day_id = "{$conference_slug}_day{$day_counter}";
                        $output .= "
                            <div id='{$day_id}__btn'>
                                <p>{$day_name}</p>
                            </div>
                        ";
                        $day_counter++;
                    }
                }
            }
        }


        $output .= "</div>";

        $output .= "<div class='conference_sessions_container'>";

        $conference_sessions = []; // Tablica przechowująca sesje dla każdej konferencji
        
        foreach ($database_data as $conference) {
            if (isset($conference->conf_slug, $conference->conf_data)) {
                $conference_slug = $conference->conf_slug;
                $conference_days = json_decode($conference->conf_data, true);
        
                $sessions = []; // Resetujemy sesje dla każdej konferencji
        
                if (!empty($conference_days)) {
                    foreach ($conference_days as $day_name => $day_data) {
                        foreach ($day_data as $session_key => $session_value) {
                            $sessions[$session_key] = $session_value; // Dodajemy prelekcję
                        }
                    }
                }
        
                // Przechowujemy sesje w tablicy dla danej konferencji
                $conference_sessions[$conference_slug] = $sessions;
            }
        }
        
        if ($mode_class) {
            foreach ($conference_sessions as $conference_slug => $sessions) {
                if (!empty($sessions)) {
                    $speakersDataMapping = [];
                    
                    // Upewniamy się, że $day_id dotyczy tylko tej konferencji
                    $day_id = "{$conference_slug}_day"; // Tworzymy poprawny format ID
                    
                    $output .= "<div class='mode-class-container' data-conference='{$conference_slug}' data-day='{$day_id}'>";
                    $output .= $mode_class::output($atts, $sessions, $conf_function, $speakersDataMapping, $day_id, $conference_slug);
                    $output .= "</div>";
                }
            }
        }
        
        
        $output .= "</div>"; // Zamknięcie conference_sessions_container
        
        
        

        return $output;
    }        
}