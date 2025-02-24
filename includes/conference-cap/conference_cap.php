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
    //     // // $pweComonFunction = new PWECommonFunctions;
    //     // self::$rnd_id = rand(10000, 99999);
    //     // self::$fair_colors = $pweComonFunction->findPalletColors();
    //     // self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

    //     // foreach(self::$fair_colors as $color_key => $color_value){
    //     //     if(strpos($color_key, 'main2') != false){
    //     //         self::$main2_color = $color_value;
    //     //     }
    //     // }
        add_action('init', array($this, 'initElements'));
        add_shortcode('pwe_conference_cap', array($this, 'PWEConferenceCapOutput'));

        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
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
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'group' => 'PWE Element',
                        'heading' => __('Tytuł elementu', 'pwe_conference_cap'),
                        'param_name' => 'conference_cap_title',
                        'save_always'=> true,
                        'std' => __('Dane Konferencji', 'pwe_conference_cap'),
                        'dependency' => array(
                        'element' => 'pwe_conference_cap',
                        'value' => 'PWEConferenceCap',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'group' => 'PWE Element',
                        'heading' => __('Custom style', 'pwe_conference_cap'),
                        'param_name' => 'conference_cap_style',
                        'save_always'=> true,
                        'dependency' => array(
                        'element' => 'pwe_conference_cap',
                        'value' => 'PWEConferenceCap',
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

        /**
     * Adding Scripts
     */
    public function addingScripts($atts){
        $data = array(
            'data'   => $speakersDataMapping,
            'locale' => $locale,
        );

        $js_file = plugins_url('assets/conference-cap-script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/conference-cap-script.js');
        wp_enqueue_script('pwe-conference-cap-js', $js_file, array('jquery'), $js_version, true);
        wp_localize_script('pwe-conference-cap-js', 'speakersData', $data);
    
        $locale = get_locale();
        
    }
    
    

    public static function PWEConferenceCapOutput($atts) {
        require_once plugin_dir_path(__FILE__) . 'classes/conference-cap-functions.php';
        $conf_function = new PWEConferenceCapFunctions;

        $mode_class = null;

        // Pobieramy ustawienia shortcode
        extract(shortcode_atts(array(
            'conference_cap_title' => '',
            'conference_cap_style' => '',
            'conference_cap_html' => '',
            'conference_cap_conference_mode' => '',
        ), $atts));

        if($conference_cap_conference_mode == 'PWEConferenceCapFullMode'){

            require_once plugin_dir_path(__FILE__) . 'classes/conference-cap-full-mode/conference-cap-full-mode.php';
            $mode_class = new PWEConferenceCapFullMode;

        }else if($conference_cap_conference_mode == 'PWEConferenceCapSimpleMode'){

            require_once plugin_dir_path(__FILE__) . 'classes/conference-cap-full-mode/conference-cap-full-mode.php';
            $mode_class = new PWEConferenceCapSimpleMode;

        }

        $conference_cap_html = vc_param_group_parse_atts( $conference_cap_html );

        $database_data = $conf_function::getDatabaseDataConferences();
        // var_dump($database_data);
        
        // Zmienna na dynamiczne reguły CSS do pokazywania właściwej treści
        $dynamic_css = "";
        
        // Tablica na zapis danych prelegentów (bio) – identyfikator lecture-box => dane
        $speakersDataMapping = array();

        $output = '';

        // Rozpoczynamy budowę wyjścia HTML – dodajemy styl (CSS)
        $output .= '
            <style>

            /* Domyślnie ukrywamy wszystkie zakładki `conf_slug` */
                .conference_cap__conf-tab-content {
                    display: none;
                }

                /* Pokazujemy tylko aktywne `conf_slug` */
                .conference_cap__conf-tab-radio:checked ~ .conference_cap__conf-tabs-contents .conference_cap__conf-tab-content {
                    display: block;
                }

                /* Ukrywamy domyślnie wszystkie zakładki dni */
                .conference_cap__tab-content {
                    display: none;
                }

                /* Pokazujemy tylko aktywny dzień */
                .conference_cap__tab-radio:checked ~ .conference_cap__tabs-contents .conference_cap__tab-content {
                    display: block;
                }
                .conference_cap__conf-tab-radio, .conference_cap__tab-radio {
                    display: none !important;
                }
                .conference_cap__tabs-labels {
                    display: flex;
                    flex-wrap: nowrap;
                    margin: 10px;
                    justify-content: center;
                }
                .conference_cap__tab-label {
                    padding: 10px 20px;
                    background: #eee;
                    cursor: pointer;
                    margin: 4px;
                }
                .conference_cap__tab-radio:checked + .conference_cap__tab-label {
                    background: #ddd;
                    font-weight: bold;
                }
                .conference_cap__tab-content {
                    display: none;
                    padding: 15px;
                    border-top: 1px solid #ddd;
                }

                .conference_cap__conf-tabs-labels {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 24px;
                    padding: 28px 18px;
                }

                .conference_cap__conf-tabs-labels img{
                    border-radius: 8px;
                    width: 100%;
                    object-fit: cover;
                    aspect-ratio: 1/1;
                    max-width: 220px;
                    }

                .conference_cap__conf-title {
                    text-align: center;
                    margin: 36px auto;
                }

                /* ---- lecture-box ---- */
                .conference_cap__lecture-box {
                    display: flex;
                    text-align: left;
                    gap: 18px;
                    margin-top: 36px;
                    padding: 10px;
                }
                .conference_cap__lecture-speaker {
                    width: 200px;
                    min-width: 200px;
                    display: flex;
                    flex-direction: column;
                    text-align: center;
                }
                .conference_cap__lecture-speaker-item {
                    margin-bottom: 10px;
                }
                .conference_cap__lecture-box-info {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    gap: 18px;
                }
                .conference_cap__lecture-time, .conference_cap__lecture-name, .conference_cap__lecture-title, .conference_cap__lecture-desc p {
                    margin: 0;
                }
                .conference_cap__lecture-speaker-img img {
                    border-radius: 50%;
                    max-width: 80%;
                    background: white;
                    border: 2px solid gray;
                    aspect-ratio: 1 / 1;
                    object-fit: cover;
                }
                .conference_cap__lecture-speaker-btn {
                    margin: 10px auto !important;
                    color: white;
                    background-color: var(--accent-color);
                    border: 1px solid var(--accent-color);
                    padding: 6px 16px;
                    font-weight: 600;
                    width: 80px;
                    border-radius: 10px;
                    transition: .3s ease;
                }
                .conference_cap__lecture-speaker-btn:hover {
                    color: white;
                    background-color: color-mix(in srgb, var(--accent-color), black 20%);
                    border: 1px solid color-mix(in srgb, var(--accent-color), black 20%);
                }       
                /* Style modala */
                .custom-modal-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0,0,0,0.5);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 10000;
                }
                .custom-modal {
                    background: #fefefe;
                    padding: 20px;
                    border-radius: 8px;
                    position: relative;
                    max-width: 800px;
                    width: 90%;
                    max-height: 90%;
                    overflow-y: auto;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                    border: 1px solid #888;
                    transition: transform 0.3s;
                    transform: scale(0);
                }
                .custom-modal-close {
                    position: absolute;
                    right: 18px;
                    top: -6px;
                    color: #000;
                    background: transparent;
                    float: right;
                    font-size: 50px;
                    font-weight: bold;
                    transition: transform 0.3s;
                    font-family: monospace;
                }
                .custom-modal-content {
                    display: flex;
                    flex-direction: column;
                    align-items: stretch;
                }
                .custom-modal-content img {
                    max-width: 150px;
                    border-radius: 8px;
                    margin-bottom: 10px;
                }
                .custom-modal-content h2 {
                    margin: 10px 0 10px;
                    font-size: 1.5em;
                }
                .custom-modal-content p {
                    margin: 0;
                }
                .custom-modal.visible {
                    transform: scale(1);
                }
            </style>
        ';
        
        if (!empty($conference_cap_title)) {
            $output .= '<h2>' . esc_html($conference_cap_title) . '</h2>';
        }
        
        $output .= '<div class="pwe-conference-cap-element" style="' . esc_attr($conference_cap_style) . '">';
        
        if (!empty($database_data)) {
            $conf_slug_index = 0;
            $conf_slugs = [];
            $dynamic_css = '';
            $conf_slug_radio_inputs = '';
            $conf_slug_tab_headers = '';
            $conf_slug_tab_contents = '';
        
            
            // **Zbiór `conf_slug` i grupowanie konferencji wg nich**
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


            // **Generowanie zakładek `conf_slug`**
            foreach ($conf_slugs as $conf_slug => $conferences) {
                $inf_conf = [];

                foreach($conference_cap_html as $conf_cap_html){
                    if(in_array($conf_slug, $conf_cap_html)){
                        $inf_conf[$conf_cap_html['conference_cap_html_position'] . '_' . $conf_cap_html['conference_cap_html_day']] = PWECommonFunctions::decode_clean_content($conf_cap_html['conference_cap_html_code']);
                    }
                }

                $conf_slug_index++;
                $checked = ($conf_slug_index === 1) ? ' checked' : '';
        
                // Zakładki dla `conf_slug`
                $conf_slug_radio_inputs .= '<input type="radio" name="conference_cap_conf_tabs" id="conference_cap_conf_tab_' . $conf_slug_index . '" class="conference_cap__conf-tab-radio"' . $checked . '>';
                // Pobieranie obrazu dla danego conf_slug
                $image_src = '';
                foreach ($database_data as $conf) { // database_data zawiera dane z bazy
                    if ($conf->conf_slug === $conf_slug) {
                        $image_src = !empty($conf->conf_img) ? esc_url($conf->conf_img) : '';
                        break;
                    }
                }

                // Tworzenie etykiety zakładki - najpierw obraz, jeśli istnieje, inaczej tekst
                $conf_slug_tab_headers .= '<label for="conference_cap_conf_tab_' . $conf_slug_index . '" class="conference_cap__conf-tab-label">';

                if (!empty($image_src)) {
                    $conf_slug_tab_headers .= '<img src="' . $image_src . '" alt="' . esc_attr($conf_slug) . '" class="conference_cap__conf-tab-image">';
                } else {
                    $conf_slug_tab_headers .= esc_html($conf_slug);
                }

                $conf_slug_tab_headers .= '</label>';

        
                $conf_slug_content = '<div class="conference_cap__conf-tab-content" id="content_conference_cap_conf_tab_' . $conf_slug_index . '">';

                // Pobieranie obrazu i nazwy konferencji dla `conf_slug`
                $conf_img = '';
                $conf_name = '';

                foreach ($database_data as $conf) {
                    if ($conf->conf_slug === $conf_slug) {
                        $conf_img = !empty($conf->conf_img) ? esc_url($conf->conf_img) : '';
                        $conf_name = !empty($conf->conf_name) ? esc_html($conf->conf_name) : '';
                        break;
                    }
                }

                // **Dodanie nagłówka konferencji nad zakładkami dni - tylko jeśli istnieją dane**
                if (!empty($conf_img) || !empty($conf_name)) {
                    $conf_slug_content .= '<div class="conference_cap__conf-header">';
                    if (!empty($conf_img)) {
                        $conf_slug_content .= '<img src="' . $conf_img . '" alt="' . esc_attr($conf_name) . '" class="conference_cap__conf-header-img">';
                    }

                    $conf_slug_content .= $inf_conf['before_title_'] ?? '';

                    if (!empty($conf_name)) {
                        $conf_slug_content .= '<h2 class="conference_cap__conf-title">' . $conf_name . '</h2>';
                    }

                    $conf_slug_content .= $inf_conf['after_title_'] ?? '';

                    $conf_slug_content .= '</div>'; // Koniec nagłówka konferencji
                }

        
                // **Tworzenie zakładek dni dla `conf_slug`**
                $tab_index = 0;
                $radio_inputs = '';
                $tab_headers = '';
                $tab_contents = '';
                foreach ($conferences as $confData) {
                    
                    foreach ($confData as $day => $sessions) {
                        $data_check = explode(' ', $day);
                        $tab_index++;
                        $day_checked = ($tab_index === 1) ? ' checked' : '';
        
                        // **Unikalne ID dla każdego dnia w danym `conf_slug`**
                        $radio_inputs .= '<input type="radio" name="conference_cap_tabs_' . $conf_slug_index . '" id="conference_cap_tab_' . $conf_slug_index . '_' . $tab_index . '" class="conference_cap__tab-radio"' . $day_checked . '>';
                        $tab_headers .= '<label for="conference_cap_tab_' . $conf_slug_index . '_' . $tab_index . '" class="conference_cap__tab-label">' . esc_html($day) . '</label>';
        
                        $content = '<div class="conference_cap__tab-content" id="content_conference_cap_tab_' . $conf_slug_index . '_' . $tab_index . '">';

                        $content .= $inf_conf['before_day_' . $data_check[1]] ?? '';

                        if (!empty($sessions)) {
                            
                            $content .= $mode_class::output($atts, $sessions, $conf_function, $speakersDataMapping);

                            

                        } else {
                            $content .= '<p>Brak danych do wyświetlenia.</p>';
                        }

                        $content .= $inf_conf['after_day_' . $data_check[1]] ?? '';

                        $content .= '</div>';
        
                        $tab_contents .= $content;
        
                        // **Dynamiczny CSS do przełączania dni w danym `conf_slug`**
                        $dynamic_css .= "
                            #content_conference_cap_tab_{$conf_slug_index}_{$tab_index} {
                                display: none;
                            }
                            #conference_cap_tab_{$conf_slug_index}_{$tab_index}:checked ~ .conference_cap__tabs-contents #content_conference_cap_tab_{$conf_slug_index}_{$tab_index} {
                                display: block;
                            }
                        ";
                    }
                }
        
                // **Struktura zakładek dni**
                $conf_slug_content .= '<div class="conference_cap__tabs">' . $radio_inputs . '<div class="conference_cap__tabs-labels">' . $tab_headers . '</div><div class="conference_cap__tabs-contents">' . $tab_contents . '</div></div>';
                $conf_slug_content .= '</div>';
        
                $conf_slug_tab_contents .= $conf_slug_content;
        
                // **Dynamiczny CSS do przełączania `conf_slug`**
                $dynamic_css .= "
                    #content_conference_cap_conf_tab_{$conf_slug_index} {
                        display: none;
                    }
                    #conference_cap_conf_tab_{$conf_slug_index}:checked ~ .conference_cap__conf-tabs-contents #content_conference_cap_conf_tab_{$conf_slug_index} {
                        display: block;
                    }
                ";
            }
        
            // **Główna struktura HTML**
            $output .= '<div class="conference_cap__conf-tabs">' . $conf_slug_radio_inputs . '<div class="conference_cap__conf-tabs-labels">' . $conf_slug_tab_headers . '</div><div class="conference_cap__conf-tabs-contents">' . $conf_slug_tab_contents . '</div></div>';
            $output .= '<style>' . $dynamic_css . '</style>';
        } else {
            $output .= '<p>Brak danych do wyświetlenia.</p>';
        }
        
    
        $output .= '</div>';
    
        $globalSpeakersData = json_encode($speakersDataMapping);
    //     $output .= '<script>
    //         window.speakersData = ' . $globalSpeakersData . ' || {};
    //         jQuery(document).ready(function($){
            
    //             $(".conference_cap__lecture-speaker-btn").each(function() {
    //                 $(this).on("click", function(){
    //                     const lectureId = $(this).closest(".conference_cap__lecture-box").attr("id");
    //                     if (!lectureId || !window.speakersData[lectureId]) return;
    //                     openSpeakersModal(window.speakersData[lectureId]);
    //                 });
    //             });

    //             function disableScroll() {
    //                 $("body").css("overflow", "hidden");
    //                 $("html").css("overflow", "hidden");
    //             }

    //             function enableScroll() {
    //                 $("body").css("overflow", "");
    //                 $("html").css("overflow", "");
    //             }
    
    //             function openSpeakersModal(speakers) {
    //                                     console.log(speakers);
    //                 var overlay = $("<div>").addClass("custom-modal-overlay");
    
    //                 var modal = $("<div>").addClass("custom-modal visible");
    
    //                 var modalContent = "";
    //                 $(speakers).each(function(index, speaker) {
    //                 console.log(speaker);
    //                     modalContent += `<div class="modal-speaker">
    //                         ${ speaker.url ? `<img src="${speaker.url}" alt="${speaker.name}">` : "" }
    //                         <h2>${speaker.name}</h2>
    //                         <p>${speaker.bio}</p>
    //                     </div>`;
    //                     if(index < speakers.length - 1) {
    //                         modalContent += "<hr>";
    //                     }
    //                 });
    
    //                 modal.html(`<button class="custom-modal-close">&times;</button>
    //                     <div class="custom-modal-content">${modalContent}</div>`);
    //                 overlay.append(modal);
    //                 $("body").append(overlay);

    //                 disableScroll();
    
    //                 $(".custom-modal-close").on("click", function() {
    //                     overlay.remove();
    //                     enableScroll();
    //                 });
    
 

    //                 overlay.on("click", function(e) {
    //                     if(e.target === overlay[0]) {
    //                         overlay.remove();
    //                         enableScroll();
    //                     }
    //                 });
                    
    //             }
    // });
    //     </script>';
    
        return $output;
    }        
}