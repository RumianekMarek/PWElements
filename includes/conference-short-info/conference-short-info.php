<?php

/**
 * PWEConferenceShortInfo Class
 *
 * This class handles the exhibitor generator functionality for the PWE plugin.
 * It manages forms, color schemes, shortcode generation, and integrates with external
 * classes to generate exhibitor guest and staff data.
 */

class PWEConferenceShortInfo {

    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    public static $local_lang_pl;
    private $atts;

    public function __construct() {
        $pweComonFunction = new PWECommonFunctions;
        self::$rnd_id = rand(10000, 99999);
        self::$fair_colors = $pweComonFunction->findPalletColors();
        self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';
        self::$local_lang_pl = (get_locale() == 'pl_PL');

        foreach(self::$fair_colors as $color_key => $color_value){
            if(strpos($color_key, 'main2') !== false){
                self::$main2_color = $color_value;
            }
        }

        add_action('init', array($this, 'initVCMapPWEConferenceShortInfo'));
        add_shortcode('pwe_conference_short_info', array($this, 'PWEConferenceShortInfoOutput'));
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
    }

    private function getConferenceRendererClass() {
        require_once plugin_dir_path(__FILE__) . 'classes/conference-short-info-default.php';
        return 'PWEConferenceShortInfoDefault';
    }

    public function initVCMapPWEConferenceShortInfo() {
        if (class_exists('Vc_Manager')) {
            $renderer_class = $this->getConferenceRendererClass();

            $params = method_exists($renderer_class, 'initElements') 
                ? $renderer_class::initElements() 
                : [];

            vc_map(array(
                'name' => __('PWE Conference Short Info', 'pwe_conference_short_info'),
                'base' => 'pwe_conference_short_info',
                'category' => __('PWE Elements', 'pwe_conference_short_info'),
                'admin_enqueue_css' => plugin_dir_url(dirname(__DIR__)) . 'backend/backendstyle.css',
                'class' => 'costam',
                'params' => $params,
            ));
        }
    }

    public function addingStyles() {
        $css_path = plugin_dir_path(__FILE__) . 'assets/conference-short-info-style.css';
        $css_url = plugins_url('assets/style.css', __FILE__);
        $css_version = file_exists($css_path) ? filemtime($css_path) : false;

        if ($css_version) {
            wp_enqueue_style('pwe-conference-short-info-css', $css_url, array(), $css_version);
        }
    }

    public function addingScripts($atts) {
        $js_path = plugin_dir_path(__FILE__) . 'assets/conference-short-info-script.js';
        $js_url = plugins_url('assets/script.js', __FILE__);
        $js_version = file_exists($js_path) ? filemtime($js_path) : false;

        if ($js_version) {
            wp_enqueue_script('pwe-conference-short-info-js', $js_url, array('jquery'), $js_version, true);
        }
    }

    public function PWEConferenceShortInfoOutput($atts) {
        global $local_lang_pl;
        $local_lang_pl = self::$local_lang_pl;

        $rnd_class = 'conference-short-info-' . esc_attr(self::$rnd_id);

        $this->addingScripts($atts);

        $renderer_class = $this->getConferenceRendererClass();
        $all_conferences = PWECommonFunctions::get_database_conferences_data();
        $fairs_data_adds = PWECommonFunctions::get_database_fairs_data_adds();
        $selected_lang = self::$local_lang_pl ? 'pl' : 'en';

        $first_fair = $fairs_data_adds[0] ?? null;

        $name = $first_fair ? ($first_fair->{'konf_name'} ?? '') : '';
        $title = $first_fair ? ($first_fair->{'konf_title_' . $selected_lang} ?? '') : '';
        $desc  = $first_fair ? ($first_fair->{'konf_desc_' . $selected_lang} ?? '') : '';

        if (method_exists($renderer_class, 'output')) {
            $content = $renderer_class::output($atts, $all_conferences, $rnd_class, $name, $title, $desc);

            
            if (trim($content) === '') {
                return ''; // nic nie wyświetlaj, jeśli pusty wynik
            }

            return '<div id="PWEConferenceShortInfo" class="' . $rnd_class . '">' . $content . '</div>';
        }

        return '<!-- Renderer not found -->';
    }

}
