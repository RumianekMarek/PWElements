<?php

/**
 * PWEConferenceShortInfo Class
 *
 * This class handles the exhibitor generator functionality for the PWE plugin.
 * It manages forms, color schemes, shortcode generation, and integrates with external
 * classes to generate exhibitor guest and staff data.
 */

require_once plugin_dir_path(__FILE__) . 'classes/conference-short-info-functions.php';

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

    use PWEConferenceShortInfoFunctions;

    public function initVCMapPWEConferenceShortInfo() {
        if (class_exists('Vc_Manager')) {
            $renderer_class = $this->getConferenceRendererClass($domain, $fair_group);

            $params = method_exists($renderer_class, 'initElements') 
                ? $renderer_class::initElements() 
                : [];

            vc_map(array(
                'name' => __('PWE Conference Short Info', 'pwe_conference_short_info'),
                'base' => 'pwe_conference_short_info',
                'category' => __('PWE Elements', 'pwe_conference_short_info'),
                'admin_enqueue_css' => plugin_dir_url(dirname(__DIR__)) . 'backend/backendstyle.css',
                'params' => $params,
            ));
        }
    }

    public function addingStyles() {
        $css_path = plugin_dir_path(__FILE__) . 'assets/conference-short-info-style.css';
        $css_url = plugins_url('assets/conference-short-info-style.css', __FILE__);
        $css_version = file_exists($css_path) ? filemtime($css_path) : false;

        if ($css_version) {
            wp_enqueue_style('pwe-conference-short-info-css', $css_url, array(), $css_version);
        }
    }

    // public function addingScripts($atts) {
    //     $js_path = plugin_dir_path(__FILE__) . 'assets/conference-short-info-script.js';
    //     $js_url = plugins_url('assets/script.js', __FILE__);
    //     $js_version = file_exists($js_path) ? filemtime($js_path) : false;

    //     if ($js_version) {
    //         wp_enqueue_script('pwe-conference-short-info-js', $js_url, array('jquery'), $js_version, true);
    //     }
    // }

    public function PWEConferenceShortInfoOutput($atts) {
        global $local_lang_pl;
        $local_lang_pl = self::$local_lang_pl;

        $rnd_class = 'conference-short-info-' . esc_attr(self::$rnd_id);

        $domain     = parse_url(site_url(), PHP_URL_HOST);
        $fair_data  = PWECommonFunctions::get_database_fairs_data($domain);
        $fair_group = strtolower($fair_data[0]->fair_group ?? 'fallback');

        // 1) Zbierz konferencje + dni targowe
        $all_conferences = PWECommonFunctions::get_database_conferences_data();
        $fair_days       = self::getFairDaysFromShortcodes();
        $lang            = (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'en') ? 'EN' : 'PL';

        // 2) Czy jest jakikolwiek organizer? (Twój warunek)
        $no_organizer = true;
        foreach ($all_conferences as $conf) {
            if (self::getConferenceOrganizer($conf->id, $conf->conf_slug, $lang)) { $no_organizer = false; break; }
        }

        // 3) Decyzja: schedule vs zwykła
        $has_schedule = self::hasValidConferences($all_conferences, $fair_days);
        $has_any_conference = !empty($all_conferences);

        if ($fair_group === 'gr3') {
            // DLA GR3: jeśli jest jakakolwiek konferencja -> schedule
            $use_schedule = $has_any_conference;
        } else {
            // DLA POZOSTAŁYCH: jak dotychczas (wymagany organizer i dopasowanie do dni targowych)
            $use_schedule = ($has_schedule && !$no_organizer);
        }

        $renderer_class = $use_schedule
            ? $this->getConferenceRendererClassSchedule($domain, $fair_group)
            : $this->getConferenceRendererClass($domain, $fair_group);

        // 4) Dane nagłówka / opisu jak u Ciebie
        $fairs_data_adds = PWECommonFunctions::get_database_fairs_data_adds();
        $selected_lang   = self::$local_lang_pl ? 'pl' : 'en';

        $first_fair_adds = $fairs_data_adds[0] ?? null;
        $name  = $first_fair_adds ? ($first_fair_adds->{'konf_name'} ?? '') : '';
        $title = $first_fair_adds ? ($first_fair_adds->{'konf_title_' . $selected_lang} ?? '') : '';
        $desc  = $first_fair_adds ? ($first_fair_adds->{'konf_desc_' . $selected_lang} ?? '') : '';

        if (method_exists($renderer_class, 'output')) {
            $content = $renderer_class::output($atts, $all_conferences, $rnd_class, $name, $title, $desc);
            if (trim($content) === '') return '';
            return '<div id="PWEConferenceShortInfo" class="' . esc_attr($rnd_class) . '">' . $content . '</div>';
        }
        return '<!-- Renderer not found: ' . esc_html($renderer_class) . ' -->';
    }
}
