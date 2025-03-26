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
                            'Mode' => '',
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
                                'admin_label' => true,
                            ),
                            array(
                                'type' => 'dropdown',
                                'heading' => __('Position', 'pwe_conference_cap'),
                                'param_name' => 'conference_cap_html_position',
                                'value' => array(
                                    __('After header', 'pwe_conference_cap') => 'after_header',
                                    __('After patrons', 'pwe_conference_cap') => 'after_patrons',
                                    __('After location', 'pwe_conference_cap') => 'after_location',
                                    __('After title', 'pwe_conference_cap') => 'after_title',
                                    __('Before day', 'pwe_conference_cap') => 'before_day',
                                    __('After day', 'pwe_conference_cap') => 'after_day',
                                ),
                                'description' => __('Choose where to insert the custom HTML.', 'pwe_conference_cap'),
                                'save_always' => true,
                                'admin_label' => true,
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
                    array(
                        'type' => 'param_group',
                        'group' => 'Manual Conferences',
                        'heading' => __('Manually Added Conferences', 'pwe_conference_cap'),
                        'param_name' => 'manual_conferences',
                        'description' => __('Add the class .konferencja and id conference_ID to the element.', 'pwe_conference_cap'),
                        'params' => array(
                            array(
                                'type' => 'attach_image',
                                'heading' => __('Conference Image', 'pwe_conference_cap'),
                                'param_name' => 'manual_conf_img',
                                'save_always' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Conference ID (Slug)', 'pwe_conference_cap'),
                                'param_name' => 'manual_conf_id',
                                'description' => __('Enter the conference slug (this should match the ID of the content section you want to toggle).', 'pwe_conference_cap'),
                                'save_always' => true,
                                'admin_label' => true,
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
        
        // Pobieramy ustawienia shortcode
        extract(shortcode_atts(array(
            'conference_cap_html' => '',
            'conference_cap_conference_mode' => '',
        ), $atts));

        $database_data = $conf_function::getDatabaseDataConferences();

        $conference_cap_html = vc_param_group_parse_atts( $conference_cap_html );

        $global_inf_conf = [];
        if (!empty($conference_cap_html)) {
            foreach ($conference_cap_html as $conf_cap_html) {
                // Pobieramy docelowy conference slug
                $target_conf_slug = $conf_cap_html['conference_cap_html_conf_slug'];
                if (empty($target_conf_slug)) {
                    continue;
                }
                // Budujemy klucz w zależności od pozycji
                if ($conf_cap_html['conference_cap_html_position'] === 'after_header' || 
                    $conf_cap_html['conference_cap_html_position'] === 'after_location' ||
                    $conf_cap_html['conference_cap_html_position'] === 'after_title' ||
                    $conf_cap_html['conference_cap_html_position'] === 'after_patrons') {
                    $key = $conf_cap_html['conference_cap_html_position'] . '_' . $target_conf_slug;
                } else {
                    $key = $conf_cap_html['conference_cap_html_position'] . 
                        (!empty($conf_cap_html['conference_cap_html_day']) ? '_' . $conf_cap_html['conference_cap_html_day'] : '');
                }
                
                // Jeśli klucz już istnieje, dołączamy nową zawartość
                if (isset($global_inf_conf[$target_conf_slug][$key])) {
                    $global_inf_conf[$target_conf_slug][$key] .= '<br>' . PWECommonFunctions::decode_clean_content($conf_cap_html['conference_cap_html_code']);
                } else {
                    $global_inf_conf[$target_conf_slug][$key] = PWECommonFunctions::decode_clean_content($conf_cap_html['conference_cap_html_code']);
                }
            }
        }
        


        $manual_conferences = array();
        if (isset($atts['manual_conferences']) && !empty($atts['manual_conferences'])) {
            $manual_conferences = vc_param_group_parse_atts($atts['manual_conferences']);
        }

        
        // Tablica na zapis danych prelegentów (bio) – identyfikator lecture-box => dane
        $speakersDataMapping = array();

        $output = '';
        
        // echo '<pre>';
        // var_dump($database_data);
        // echo '</pre>';

        $no_conference = true;

        $normalTiles = [];
        $specialTiles = [];

        // **Górna nawigacja konferencji (tylko obrazki z ID)**
        $output .= '<div id="conference-cap" class="conference_cap__main-container">';

            // Generujemy nawigację (kafelki)
            $output .= '<div class="conference_cap__conf-slug-navigation">';

                if (!empty($database_data)) {
                    $no_conference = false;
                    $conf_slugs = [];
                
                    // Grupowanie konferencji według `conf_slug`
                    foreach ($database_data as $conference) {
                        if (empty($conference->conf_data)) {
                            continue;
                        }
                
                        $confData = json_decode($conference->conf_data, true);
                        if (!is_array($confData)) {
                            continue;
                        }
                
                        $conf_slug = $conference->conf_slug;
                        if (!isset($conf_slugs[$conf_slug])) {
                            $conf_slugs[$conf_slug] = [];
                        }
                        $conf_slugs[$conf_slug][] = $confData;
                    }
                
                    foreach ($conf_slugs as $conf_slug => $conferences) {
                        // Pobieramy obraz konferencji
                        $conf_img = '';
                        foreach ($database_data as $conf) {
                            if ($conf->conf_slug === $conf_slug) {
                                $conf_img = !empty($conf->conf_img) ? esc_url($conf->conf_img) : '';
                                break;
                            }
                        }
                        if (empty($conf_img)) {
                            continue;
                        }
                        
                        // Tworzymy HTML kafelka
                        $tile = '<img src="' . $conf_img . '" alt="' . esc_attr($conf_slug) . '" id="nav_' . esc_attr($conf_slug) . '" class="conference_cap__conf-slug-img">';
                        
                        // Jeśli slug należy do specjalnych, dodajemy do specjalnych, w przeciwnym razie do normalnych
                        if (strpos($conf_slug, 'medal') !== false) {
                            $specialTiles['medal'][] = $tile;
                        } elseif (strpos($conf_slug, 'panel') !== false) {
                            $specialTiles['panel'][] = $tile;
                        } else {
                            $normalTiles[] = $tile;
                        }
                    }
                    
                    // 1. Normalne konferencje z bazy
                    foreach ($normalTiles as $tile) {
                        $output .= $tile;
                    }
                }
                // 2. Manualne konferencje (dane pobrane z VC)
                if (!empty($manual_conferences)) {
                    $no_conference = false;

                    foreach ($manual_conferences as $manual_conf) {
                        $manual_img = !empty($manual_conf['manual_conf_img']) ? wp_get_attachment_url($manual_conf['manual_conf_img']) : '';
                        $manual_id  = !empty($manual_conf['manual_conf_id']) ? $manual_conf['manual_conf_id'] : '';
                        if (!empty($manual_img) && !empty($manual_id)) {
                            $output .= '<img src="' . esc_url($manual_img) . '" alt="' . esc_attr($manual_id) . '" id="nav_' . esc_attr($manual_id) . '" class="conference_cap__conf-slug-img manual-conference">';
                        }
                    }
                }

                if (!empty($specialTiles)) {
                    // 3. Na końcu kafelki specjalne – w kolejności: "medal" i "panel"
                    if (!empty($specialTiles['medal'])) {
                        foreach ($specialTiles['medal'] as $tile) {
                            $output .= $tile;
                        }
                    }
                    if (!empty($specialTiles['panel'])) {
                        foreach ($specialTiles['panel'] as $tile) {
                            $output .= $tile;
                        }
                    }
                } 

                if($no_conference) {
                    $output .= '
                    <h2 class="conference_cap__conf-slug-title">'. PWECommonFunctions::languageChecker('Harmonogram zostanie udostępniony wkrótce', 'The schedule will be made available soon') .'</h2>';
                }

            $output .= '</div>'; // Zamknięcie `conf-tabs`

            // **Główna struktura HTML**
            $output .= '<div class="conference_cap__conf-slugs-container">';

                foreach ($conf_slugs as $conf_slug => $conferences) {
                    // Pobranie danych konferencji
                    $conf_img = '';
                    $conf_name = '';
                    $conf_location = '';
                    foreach ($database_data as $conf) {
                        if ($conf->conf_slug === $conf_slug) {
                            $conf_img = !empty($conf->conf_img) ? esc_url($conf->conf_img) : '';
                            $conf_name = !empty($conf->conf_name) ? esc_html($conf->conf_name) : '';
                            $conf_location = !empty($conf->conf_location) ? str_replace(';;' , '<br>' , esc_html($conf->conf_location)) : '';
                            $conf_style = !empty($conf->conf_style) ? $conf->conf_style : 'PWEConferenceCapFullMode';
                            break;
                        }
                    }

                    $panel = ($conf_style === 'PWEConferenceCapPanelTrendow');

                    $inf_conf = isset($global_inf_conf[$conf_slug]) ? $global_inf_conf[$conf_slug] : [];

                    if (empty($conference_cap_conference_mode)) {
                        $conference_modes = PWEConferenceCapFunctions::findConferenceMode($conf_style);
                        $new_class = $conf_style ?? 'PWEConferenceCapFullMode';
                    } else {
                        $conference_modes = PWEConferenceCapFunctions::findConferenceMode($conference_cap_conference_mode);
                        $new_class = $conference_cap_conference_mode;
                    }
                
                    require_once plugin_dir_path(__FILE__) . $conference_modes['php'];
                    $mode_class = new $new_class;

                    $css_handle = 'conference-style-' . sanitize_title($conf_style); 
            
                    // Załaduj CSS
                    $css_file = plugins_url($conference_modes['css'], __FILE__);
                    if (file_exists(plugin_dir_path(__FILE__) . $conference_modes['css'])) {
                        $css_version = filemtime(plugin_dir_path(__FILE__) . $conference_modes['css']);
                        wp_enqueue_style($css_handle, $css_file, array(), $css_version);
                    }
            
                    // **Kontener dla danej konferencji**
                    $output .= '<div id="conf_' . esc_attr($conf_slug) . '" class="conference_cap__conf-slug">';
                        // **Nagłówek konferencji**
                        $output .= '<div class="conference_cap__conf-slug-header">';
                            if (!empty($conf_img) && (get_class($mode_class) !== 'PWEConferenceCapMedalCeremony')) {
                                $output .= '
                                <img src="' . $conf_img . '" alt="' . esc_attr($conf_name) . '" class="conference_cap__conf-slug-image">
                                <div class="conference_cap__after-header-html">' . ($inf_conf['after_header_' . $conf_slug] ?? '') . '</div>';

                                // Ustalenie bazowego sluga (bez końcówki -pl lub -en)
                                $base_slug = preg_replace('/(-pl|-en)$/', '', $conf_slug);

                                // Generujemy wszystkie możliwe warianty: oryginalny, bazowy, bazowy z -pl oraz bazowy z -en
                                $variants = array_unique([
                                    $conf_slug,
                                    $base_slug,
                                    $base_slug . '-pl',
                                    $base_slug . '-en'
                                ]);

                                // Szukamy katalogu 'patroni' odpowiadającego jednemu z wariantów
                                $patroni_dir = '';
                                foreach ($variants as $slug) {
                                    $dir = ABSPATH . 'doc/konferencje/' . $slug . '/patroni';
                                    if (is_dir($dir)) {
                                        $patroni_dir = $dir;
                                        break;
                                    }
                                }

                                if (is_dir($patroni_dir)) {
                                    // Wyszukiwanie plików graficznych: jpg, jpeg, png, gif, webp (w przykładzie tylko webp)
                                    $logo_files = glob($patroni_dir . '/*.{webp}', GLOB_BRACE);
                                    if (!empty($logo_files)) {

                                        // Dodanie slidera
                                        include_once plugin_dir_path(__FILE__) . '/../../scripts/slider.php';
                                        $output .= PWESliderScripts::sliderScripts(
                                            'capconf',
                                            '#conference-cap',
                                            $opinions_dots_display = 'true',
                                            $opinions_arrows_display = false,
                                        );

                                        $output .= '
                                        <h2 class="conference_cap__conf-logotypes-title">'. PWECommonFunctions::languageChecker('Patroni Konferencji', 'Conference Patrons') .'</h2>
                                        <div class="conference_patroni_logos pwe-slides">';
                                        foreach ($logo_files as $logo_file) {
                                            // Konwersja ścieżki systemowej na URL
                                            $relative_path = str_replace(ABSPATH, '', $logo_file);
                                            $logo_url = site_url($relative_path);
                                            $output .= '<img src="' . esc_url($logo_url) . '" alt="Logo" class="conference_patroni_logo">';
                                        }
                                        $output .= '</div>';
                                    }
                                }

                                
                                $output .= '
                                <div class="conference_cap__after-patrons-html">' . ($inf_conf['after_patrons_' . $conf_slug] ?? '') . '</div>
                                <h2 class="conference_cap__conf-slug-location">' . $conf_location . '</h2>
                                <div class="conference_cap__after-location-html">' . ($inf_conf['after_location_' . $conf_slug] ?? '') . '</div>
                                <h2 class="conference_cap__conf-slug-title">' . $conf_name . '</h2>
                                <div class="conference_cap__after-title-html">' . ($inf_conf['after_title_' . $conf_slug] ?? '') . '</div>';
                            }else if(get_class($mode_class) == 'PWEConferenceCapMedalCeremony'){
                                foreach ($conferences as $confData) {
                                    foreach ($confData as $day => $sessions) {
                                        $day = str_replace(';;', '<br>', wp_kses_post($day));
                                        $output .= $mode_class::output($atts, $sessions, $conf_function, $conf_name, $day, $conf_slug, $conf_location);
                                        break 2;
                                    }
                                }
                            }else {
                                $output .= '
                                <div class="conference_cap__conf-slug-default-header" style="background-image: url(/wp-content/plugins/PWElements/media/conference-background.webp)">
                                        <div class="conference_cap__conf-slug-default-content">
                                            <h4 class="conference_cap__conf-slug-default-title">' . $conf_name . '</h4>
                                        </div>
                                </div>';
                            }
                        $output .= '</div>'; // Zamknięcie nagłówka
                
                        
                        if (get_class($mode_class) !== 'PWEConferenceCapMedalCeremony') {
                            // **Zakładki dni**
                            $output .= '<div class="conference_cap__conf-slug-navigation-days">';
                            foreach ($conferences as $confData) {
                                    $dayCounter = 1;
                                    foreach ($confData as $day => $sessions) {
                                        $short_day = 'day-' . $dayCounter++;
                                        $day = str_replace(';;', '<br>', wp_kses_post($day));
                                        $output .= '<button id="tab_' . esc_attr($conf_slug) . '_' . esc_attr($short_day) . '" class="conference_cap__conf-slug-navigation-day">' . $day . '</button>';
                                    }
                                }
                            $output .= '</div>'; // Zamknięcie kontenera zakładek dni
                        
                
                            // **Treść dla poszczególnych dni**
                            $output .= '<div class="conference_cap__conf-slug-contents">';
                                foreach ($conferences as $confData) {
                                    $dayCounter = 1;
                                    foreach ($confData as $day => $sessions) {
                                        $short_day = 'day-' . $dayCounter++;
                                        $output .= '
                                        <div id="content_' . esc_attr($conf_slug) . '_' . esc_attr($short_day) . '" class="conference_cap__conf-slug-content">
                                        <div class="conference_cap__before-day-html">' . ($inf_conf['before_day_' . esc_attr($conf_slug) . '_' . esc_attr($short_day)] ?? '') . '</div>
                                            '. $mode_class::output($atts, $sessions, $conf_function, $speakersDataMapping, $short_day, $conf_slug, $panel, $conf_location) .'
                                        <div class="conference_cap__after-day-html">' . ($inf_conf['after_day_' . esc_attr($conf_slug) . '_' . esc_attr($short_day)] ?? '') . '</div>
                                        </div>'; // Zamknięcie kontenera treści dnia
                                    }
                                }
                            $output .= '</div>'; // Zamknięcie kontenera zakładek

                            if($panel === true){
                                require_once plugin_dir_path(__FILE__) . 'assets/conference-cap-trends-panel.php';
                                $output .= PWEConferenceCapTrendsPanel::output($atts);
                            }
                        }
                    $output .= '</div>'; // Zamknięcie `conf-tab`
                }

            $output .= '</div>'; // Zamknięcie `conf-tabs`

        $output .= '</div>';

        self::addingScripts($atts, $speakersDataMapping);

        return $output;
    }        
}