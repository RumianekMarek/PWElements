<?php

class PWECalendar extends PWECommonFunctions { 

    public function __construct() {
        // Hook actions
        // add_action('wp_enqueue_scripts', array($this, 'adding_styles'));
        // add_action('wp_enqueue_scripts', array($this, 'adding_scripts'));
        
        add_action('init', array($this, 'init_vc_map_pwe_calendar'));
        add_action('wp_ajax_load_more_calendar', [$this, 'load_more_calendar']);
        add_action('wp_ajax_nopriv_load_more_calendar', [$this, 'load_more_calendar']);

        add_shortcode('pwe_calendar', array($this, 'pwe_calendar_loop_output'));
    }

    /**
    * Initialize VC Map PWECalendar.
    */
    public function init_vc_map_pwe_calendar() {

        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map( array(
                'name' => __( 'PWE Calendar', 'pwe_calendar'),
                'base' => 'pwe_calendar',
                'category' => __( 'PWE Elements', 'pwe_calendar'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __DIR__ )) . 'backend/backendstyle.css',
                'params' => array_merge(
                    array(
                        array(
                            'type' => 'textfield',
                            'heading' => __('Posts display limit', 'pwe_calendar'),
                            'param_name' => 'pwe_calendar_posts_num',
                            'param_holder_class' => 'backend-area-one-fifth-width',
                            'admin_label' => true,
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'heading' => __('Posts per page', 'pwe_calendar'),
                            'param_name' => 'pwe_calendar_posts_per_page',
                            'param_holder_class' => 'backend-area-one-fifth-width',
                            'admin_label' => true,
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('AJAX Load more', 'pwe_calendar'),
                            'param_name' => 'pwe_calendar_load_more',
                            'save_always' => true,
                            'admin_label' => true,
                            'value' => array(__('True', 'pwe_calendar') => 'true',),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('AJAX Pagination', 'pwe_calendar'),
                            'param_name' => 'pwe_calendar_pagination',
                            'save_always' => true,
                            'admin_label' => true,
                            'value' => array(__('True', 'pwe_calendar') => 'true',),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Premier edition only', 'pwe_calendar'),
                            'param_name' => 'pwe_calendar_premier_edition',
                            'save_always' => true,
                            'admin_label' => true,
                            'value' => array(__('True', 'pwe_calendar') => 'true',),
                        ),
                        array(
                            'type' => 'checkbox',
                            'heading' => __('Hide filter', 'pwe_calendar'),
                            'param_name' => 'pwe_calendar_hide_filter',
                            'save_always' => true,
                            'admin_label' => true,
                            'value' => array(__('True', 'pwe_calendar') => 'true',),
                        ),
                    ),
                ),
            ));
        }
    }

    //     /**
    //  * Adding Styles
    //  */
    // public function adding_styles(){
    //     $css_file = plugins_url('assets/style.css', __FILE__);
    //     $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/style.css');
    //     wp_enqueue_style('pwe-calendar-css', $css_file, array(), $css_version);
    // }

    // /**
    //  * Adding Scripts
    //  */
    // public function adding_scripts(){
    //     $js_file = plugins_url('assets/script.js', __FILE__);
    //     $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/script.js');
    //     wp_enqueue_script('pwe-calendar-js', $js_file, array('jquery'), $js_version, true);
    // }

    public static function get_pwe_shortcode($shortcode, $domain) {
        return shortcode_exists($shortcode) ? do_shortcode('[' . $shortcode . ' domain="' . $domain . '"]') : "";
    }

    public static function check_available_pwe_shortcode($shortcodes_active, $shortcode) {
        return $shortcodes_active && !empty($shortcode) && $shortcode !== "";
    }

    public static function format_date_range($start_date, $end_date, $locale) {
        $months = array(
            '01' => array('PL' => 'STYCZNIA', 'EN' => 'JANUARY'),
            '02' => array('PL' => 'LUTEGO', 'EN' => 'FEBRUARY'),
            '03' => array('PL' => 'MARCA', 'EN' => 'MARCH'),
            '04' => array('PL' => 'KWIETNIA', 'EN' => 'APRIL'),
            '05' => array('PL' => 'MAJA', 'EN' => 'MAY'),
            '06' => array('PL' => 'CZERWCA', 'EN' => 'JUNE'),
            '07' => array('PL' => 'LIPCA', 'EN' => 'JULY'),
            '08' => array('PL' => 'SIERPNIA', 'EN' => 'AUGUST'),
            '09' => array('PL' => 'WRZEŚNIA', 'EN' => 'SEPTEMBER'),
            '10' => array('PL' => 'PAŹDZIERNIKA', 'EN' => 'OCTOBER'),
            '11' => array('PL' => 'LISTOPADA', 'EN' => 'NOVEMBER'),
            '12' => array('PL' => 'GRUDNIA', 'EN' => 'DECEMBER'),
        );

        $start_parts = explode("-", $start_date);
        $end_parts = explode("-", $end_date);

        $start_day = intval($start_parts[0]);
        $end_day = intval($end_parts[0]);
        $start_month = $start_parts[1];
        $end_month = $end_parts[1];
        $year = $start_parts[2];

        // Wybierz nazwę miesiąca w zależności od języka
        $lang_key = ($locale == "pl_PL") ? "PL" : "EN";
        $start_month_name = isset($months[$start_month][$lang_key]) ? $months[$start_month][$lang_key] : "";
        $end_month_name = isset($months[$end_month][$lang_key]) ? $months[$end_month][$lang_key] : "";

        // Sprawdź, czy miesiące są różne
        if ($start_month === $end_month) {
            return "$start_day - $end_day $start_month_name $year";
        } else {
            return "$start_day $start_month_name - $end_day $end_month_name $year";
        }
    }

    public static function multi_translation($key) {
        $locale = get_locale();
        $translations_file = __DIR__ . '/../assets/translations.json';

        // JSON file with translation
        $translations_data = json_decode(file_get_contents($translations_file), true);

        // Is the language in translations
        if (isset($translations_data[$locale])) {
            $translations_map = $translations_data[$locale];
        } else {
            // By default use English translation if no translation for current language
            $translations_map = $translations_data['en_US'];
        }

        // Return translation based on key
        return isset($translations_map[$key]) ? $translations_map[$key] : $key;
    }

    public static function get_translated_field($fair, $field_base_name) {
        // Pobierz język w formacie np. "de", "pl"
        $locale = get_locale(); // np. "de_DE"
        $lang = strtolower(substr($locale, 0, 2)); // "de"

        // Sprawdź, czy istnieje konkretne tłumaczenie (np. fair_name_de)
        $field_with_lang = "{$field_base_name}_{$lang}";

        if (!empty($fair[$field_with_lang])) {
            return $fair[$field_with_lang];
        }

        // Fallback do angielskiego
        $fallback = "{$field_base_name}_en";
        return $fair[$fallback] ?? '';
    }

    public function pwe_calendar_loop_output($atts) {
        extract(shortcode_atts(array(
            'pwe_calendar_posts_num' => '',
            'pwe_calendar_posts_per_page' => '',
            'pwe_calendar_load_more' => '',
            'pwe_calendar_pagination' => '',
            'pwe_calendar_premier_edition' => '',
            'pwe_calendar_hide_filter' => '',
        ), $atts));

        $pwe_calendar_posts_num = !empty($pwe_calendar_posts_num) ? $pwe_calendar_posts_num : 0;

        // Creating a query for 'event' posts
        $args = array(
            'post_type' => 'event',
            'posts_per_page' => -1,
            'post_status' => 'publish',
        );

        $query = new WP_Query($args);

        if ($query->have_posts()) :

            $thumbnail_url = '';
            $lang_pl = get_locale() == "pl_PL"; 
            $shortcodes_active = empty(get_option('pwe_general_options', [])['pwe_dp_shortcodes_unactive']);
            
            $output = '
            <style>
                .pwe-calendar__wrapper {
                    max-width: 1400px;
                    margin: 0 auto;
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    gap: 24px;
                    margin-top: 36px;
                }
                .pwe-calendar__item {
                    background-color: #e9e9e9;
                    text-align: -webkit-center;
                    border-radius: 30px;
                    box-shadow: unset;
                    transition: .3s ease;
                }
                .pwe-calendar__item:hover {
                    transform: scale(1.05);
                }
                .pwe-calendar__wrapper:after {
                    content:none !important;
                }
                .pwe-calendar__link {
                    position: relative;
                    z-index: 1;
                    text-decoration: none;
                }
                .pwe-calendar__tile {
                    position: relative;
                    aspect-ratio: 1 / 1;
                    background-size: cover;
                    background-position: center;
                    border-radius: 0;
                    border-top-left-radius: 15px;
                    border-top-right-radius: 15px;
                    display: flex;
                    align-items: flex-end;
                    justify-content: center;
                }
                .pwe-calendar__short-name {
                    position: absolute;
                    top: 65%;
                    left: 50%;
                    transform: translate(-50%, -65%);
                    z-index: 1;
                    width: 300px;
                    max-width: 90%;
                }
                .pwe-calendar__short-name h4 {
                    color: white !important;
                    font-size: 17px;
                    font-weight: 600;
                    text-shadow: 0.1em 0.1em 0.2em black, 0.1em 0.1em 0.2em black, 0.1em 0.1em 0.2em black;
                    text-transform: uppercase;
                    text-align: center;
                }
                .pwe-calendar__statistics-word {
                    font-size: 13px;
                    color: grey;
                    margin: 0;
                    font-weight: 600;
                }
                .pwe-calendar_strip {
                    width: 100%;
                    display: flex;
                    align-items: center;
                    margin: 6px;
                }
                .pwe-calendar__button-check {
                    width: 40%;
                }
                .pwe-calendar__button-check p {
                    width: fit-content;
                    line-height: 1;
                    color: white;
                    font-size: 12px;
                    font-weight: 700;
                    margin: 0;
                    text-transform: uppercase;
                    background-color: grey;
                    padding: 9px;
                    border-radius: 12px;
                }
                .pwe-calendar__edition {
                    width: 60%;
                }
                .pwe-calendar__edition p {
                    margin: 0 0 0 2px;
                    line-height: 1;
                    color: white;
                    font-size: 15px;
                    font-weight: 700;
                    text-transform: uppercase;
                }
                .pwe-calendar__date {
                    padding: 6px;
                }
                .pwe-calendar__date h5 {
                    margin: 0;
                    line-height: 1.2;
                    font-weight: 700;
                    text-transform: uppercase;
                    display: flex;
                    justify-content: space-evenly;
                } 
                .pwe-calendar_statistics {
                    padding: 10px;
                }
                .pwe-calendar__statistics-item {
                    display: flex;
                    justify-content: space-between;
                }
                .pwe-calendar__statistics-name {
                    width: 76%;
                    display: flex;
                    justify-content: space-between;
                    gap: 10px;
                }
                .pwe-calendar__statistics-name p {
                    margin: 0;
                    line-height: 1;
                    text-align: start;
                }
                .pwe-calendar__statistics-icon {
                    width: 20%;
                }
                .pwe-calendar__statistics-icon img {
                    max-width: 30px;
                    vertical-align: middle;
                }
                .pwe-calendar__statistics-label {
                    width: 65%;
                    font-size: 14px;
                    margin: 0;
                    line-height: 1;
                    color: black;
                }
                .pwe-calendar__statistics-value {
                    width: 35%;
                    font-size: 14px;
                    color: grey;
                    margin: 0;
                    font-weight: 800;
                    display: flex;
                    white-space: nowrap;
                    align-items: center;
                }
                @media (min-width: 960px){
                    .row-parent:has(.pwe-calendar__item){
                        max-width: unset !important;
                    } 
                }
                @media (max-width: 1200px){
                    .pwe-calendar__wrapper {
                        grid-template-columns: repeat(3, 1fr);
                        gap: 18px;
                    }
                }
                @media (max-width: 960px){
                    .pwe-calendar__short-name h4 {
                        font-size: 14px;
                    }
                    .pwe-calendar__item:hover {
                        transform: scale(1.02);
                    }
                }
                @media (max-width: 768px) {
                    .pwe-calendar__wrapper {
                        grid-template-columns: repeat(2, 1fr);
                    }
                }
                @media (max-width: 569px) {
                    .main-container .row-parent:has(.pwe-calendar__item) {
                        padding: 10px;
                    }
                    .pwe-calendar__wrapper {
                        gap: 10px;
                    }
                    .pwe-calendar__short-name h4 {
                        font-size: 12px;
                    }
                    .pwe-calendar_strip {
                        width: 100%;
                        margin: 0;
                        height: 20%;
                    }
                    .pwe-calendar__button-check p, 
                    .pwe-calendar__edition p {
                        font-size: 10px !important;
                        padding: 4px !important;
                    }
                    .pwe-calendar_statistics {
                        display: flex;
                        flex-direction: column;
                        gap: 6px;   
                    }
                    .pwe-calendar__statistics-name {
                        flex-direction: column;
                        gap: 5px;
                    }
                }
            </style>';

            $event_posts = [];

            while ($query->have_posts()) : $query->the_post();
                $post_id = get_the_ID();
                $permalink = get_the_permalink();

                if ($post_id) {
                    $website = get_post_meta($post_id, 'web_page_link', true);
                    $host = parse_url($website, PHP_URL_HOST);
                    $domain = preg_replace('/^www\./', '', $host);
                    $categories = get_the_terms($post_id, 'event_category');
                } else {
                    $domain = '';
                }

                $current_time = strtotime("now");
                
                $pwe_db_date_start = do_shortcode('[pwe_date_start domain="' . $domain . '"]');
                $pwe_db_date_end = do_shortcode('[pwe_date_end domain="' . $domain . '"]');
                $pwe_db_date_start_available = $shortcodes_active && !empty($pwe_db_date_start) && $pwe_db_date_start !== "";
                $pwe_db_date_end_available = $shortcodes_active && !empty($pwe_db_date_end) && $pwe_db_date_end !== "";

                $start_date = $pwe_db_date_start_available ? date("d-m-Y", strtotime(str_replace("/", "-", $pwe_db_date_start))) : get_post_meta($post_id, 'fair_date_start', true);
                $end_date = $pwe_db_date_end_available ? date("d-m-Y", strtotime(str_replace("/", "-", $pwe_db_date_end))) : get_post_meta($post_id, 'fair_date_end', true);
                
                $start_date = (empty($start_date) || (!empty($end_date) && strtotime($end_date . " +20 hours") < $current_time)) ? "28-01-2050" : $start_date;
                $end_date = (empty($end_date) || (!empty($end_date) && strtotime($end_date . " +20 hours") < $current_time)) ? "30-01-2050" : $end_date;

                $shortcode_edition = self::get_pwe_shortcode("pwe_edition", $domain);
                $shortcode_edition_available = self::check_available_pwe_shortcode($shortcodes_active, $shortcode_edition);
                $edition_num = $shortcode_edition_available ? $shortcode_edition : get_post_meta($post_id, 'edition', true);

                // Add only posts with edition_num == 1 if $pwe_calendar_premier_edition is true
                if ($pwe_calendar_premier_edition == true && $edition_num == 1) {
                    $event_posts[] = [
                        'post_id' => $post_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'domain' => $domain,
                        'permalink' => $permalink,
                        'categories' => $categories,
                        'post_title' => get_the_title(),
                    ];
                } elseif ($pwe_calendar_premier_edition == false) {
                    // If $pwe_calendar_premier_edition is false, add all posts
                    $event_posts[] = [
                        'post_id' => $post_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'domain' => $domain,
                        'permalink' => $permalink,
                        'categories' => $categories,
                        'post_title' => get_the_title(),
                    ];
                }

            endwhile;

            wp_reset_postdata(); 

            $event_posts_full = $event_posts;

            // Sorting posts by date
            usort($event_posts, function($a, $b) {
                $a_date = DateTime::createFromFormat('d-m-Y', $a['start_date']);
                $b_date = DateTime::createFromFormat('d-m-Y', $b['start_date']);
                return $a_date <=> $b_date;
            });

            if (!empty($pwe_calendar_posts_num) && $pwe_calendar_posts_num > 0) {
                $event_posts = array_slice($event_posts, 0, $pwe_calendar_posts_num);
            }

            if ($pwe_calendar_hide_filter != true) {
                $output .= '
                <style>
                    .pwe-calendar__filter {
                        display: flex;
                        position: relative;
                        flex-wrap: wrap;
                        max-width: 1200px;
                        margin: 0 auto;
                    }
                    .pwe-calendar__filter div {
                        width: 50%;
                        padding: 0 5px;
                    }
                    .dont-show {
                        display: none;
                    }
                    .pwe-calendar__categories-dropdown {
                        width: 100%;
                    }
                    .pwe-calendar__filter input {
                        margin-top: 0 !important;
                    }
                    .pwe-calendar__filter input::placeholder {
                        color: white;
                    }
                    .pwe-calendar__categories-dropdown,
                    .pwe-calendar__filter input {
                        background: #1d1f24;
                        font-size: 18px;
                        width: 100%;
                        border: none;
                        color: #fff;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        padding: 0.7em 1.5em;
                        border-radius: 0.5em;
                        cursor: pointer;
                    }
                    .pwe-calendar__categories-dropdown-arrow {
                        border-left: 5px solid transparent;
                        border-right: 5px solid transparent;
                        border-top: 6px solid #fff;
                        transition: transform ease-in-out 0.3s;
                    }

                    .pwe-calendar__categories-dropdown-content {
                        margin: 5px 0px 0px 0px;
                        display: flex;
                        flex-direction: column;
                        flex-wrap: nowrap;
                        z-index: 1000;
                        overflow: hidden;
                        background: white;
                        list-style: none !important;
                        position: absolute;
                        top: 3.2em;
                        width: 49%;
                        padding: 0 !important;
                        visibility: hidden;
                        opacity: 0;
                        border-radius: 8px;
                    }
                    .pwe-calendar__categories-dropdown-content li {
                        cursor: pointer;
                        padding: 0px 0px 0px 0px;
                        color: white;
                        margin: 2px;
                        text-align: center;
                        background: #2f3238;
                        border-radius: 0.4em;
                        position: relative;
                        left: 100%;
                        transition: 0.4s;
                        transition-delay: calc(30ms * var(--delay));
                        font-size: 17px;
                    }
                    .dropdown-delay {
                        transition: 0.4s;
                        transition-delay: calc(30ms * 9);
                    }
                    .pwe-calendar__categories-dropdown-content.menu-open li {
                        left: 0;
                    }
                    .pwe-calendar__categories-dropdown-content.menu-open {
                        visibility: visible;
                        opacity: 1;
                    }
                    .pwe-calendar__categories-dropdown-arrow.arrow-rotate {
                        transform: rotate(180deg);
                    }
                    .pwe-calendar__categories-dropdown-content li:hover {
                        background: #1d1f24;
                    }
                    .pwe-calendar__categories-dropdown-content li a {
                        display: block;
                        padding: 0.7em 0.5em;
                        color: #fff;
                        margin: 0.1em 0;
                        text-decoration: none;
                    }
                    @media (max-width:800px) {
                        .pwe-calendar__categories-dropdown-content {
                            max-height: 2000px;
                            width: 100%;
                        }
                        .pwe-calendar__categories-dropdown-content li {
                            transition-delay: 0.2s;
                            transition-delay: calc(20ms * var(--delay));
                        }
                        .pwe-calendar__filter div {
                            width: 100%;
                            padding: 0;
                            margin: 5px 0;
                        }
                    }
                    .pwe-calendar__categories-dropdown-content .wszystkie { 
                        background-color: #594334;
                        font-size: 21px;
                    }
                </style>

                <div class="pwe-calendar__filter">
                    <div class="pwe-calendar__categories-dropdown dropdown">
                        <button id="dropdownBtn" class="pwe-calendar__categories-dropdown dropdown-btn" aria-label="menu button" aria-haspopup="menu" aria-expanded="false" aria-controls="dropdown-menu">
                            <span>'. self::multi_translation("select_categories") .'</span>
                            <span class="pwe-calendar__categories-dropdown-arrow arrow"></span>
                        </button>
                        <ul class="pwe-calendar__categories-dropdown-content dropdown-content" role="menu" id="dropdown-menu"></ul>
                    </div>
                    <div class="pwe-calendar__search">
                        <input type="text" id="searchInput" placeholder="'. self::multi_translation("search") .'" />
                    </div>
                </div>';
            }

            $output .= '<div class="pwe-calendar__wrapper">';

                foreach ($event_posts as $event) {
                    $post = get_post($event['post_id']);
                    setup_postdata($post);
    
                    $output .= self::render_calendar_event_card($event, $shortcodes_active, $lang_pl);
                }

                wp_reset_postdata();

            $output .= '</div>';

            // Add load more button and script if needed
            if ($pwe_calendar_load_more && !empty($pwe_calendar_posts_num) && (count($event_posts_full) > $pwe_calendar_posts_num)) {
                $output .= '
                <div class="load-more-btn-container" style="text-align: center; margin-top: 36px;">
                    <button 
                        id="loadMore" 
                        data-page="2" 
                        class="load-more" 
                        style="text-transform: uppercase; background-color: var(--main2-color); border-color: var(--main2-color); border-radius: 10px; color: white; padding: 8px 14px; transition: .3s ease; transform: scale(1);">
                        ' . ($lang_pl ? "Załaduj więcej" : "Load more") . '
                    </button>
                </div>
                
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                        let loadMoreBtn = document.getElementById("loadMore");
        
                        if (loadMoreBtn) {
                            loadMoreBtn.addEventListener("click", function () {
                                let button = this;
                                button.innerText = "'. ($lang_pl ? "Ładowanie..." : "Loading...") .'";
                                let page = button.getAttribute("data-page");
        
                                let xhr = new XMLHttpRequest();
                                xhr.open("POST", "/wp-admin/admin-ajax.php", true); // Użyj admin-ajax.php
                                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        
                                xhr.onload = function () {
                                    if (xhr.status === 200) {
                                            let response = xhr.responseText;
                                            if (response.trim()) {
                                                document.querySelector(".pwe-calendar__wrapper").insertAdjacentHTML("beforeend", response);
                                                button.setAttribute("data-page", parseInt(page) + 1);
                                                button.innerText = "'. ($lang_pl ? "Załaduj więcej" : "Load more") .'";
                                            } else {
                                                button.style.display = "none";
                                            }
                                    }
                                };
        
                                xhr.send("action=load_more_calendar&page=" + page);
                            });
                        }
                    });
                </script>';
            } else if ($pwe_calendar_pagination && !empty($pwe_calendar_posts_num) && (count($event_posts_full) > $pwe_calendar_posts_num)) {
                $output .= '
                <style>
                    .pwe-pagination-container {
                        position: relative;
                    }
                    .pwe-pagination {
                        display: flex;
                        justify-content: center;
                        gap: 6px;
                    }
                    .page-btn, .prev-btn, .next-btn {
                        background: inherit;
                        font-size: 18px;
                    }
                    .page-btn.active {
                        background: var(--main2-color);
                        color: white;
                        padding: 6px 12px;
                        border-radius: 8px;
                    }
                    .pwe-pagination-loading {
                        visibility: hidden;
                        position: absolute;
                        bottom: -8px;
                        left: 50%;
                        right: 50%;
                        transform: translate(-50%, -50%);
                        width: 200px;
                        height: 1px;
                        z-index: 9999;
                    }
                    .pwe-pagination-loading .loading-bar {
                        width: 0%;
                        height: 100%;
                        background-color: var(--main2-color); 
                        position: absolute;
                        left: 50%;
                        transform: translateX(-50%);
                    }
                </style>

                <div class="pwe-pagination-container">
                    <div id="pwePagination" class="pwe-pagination"></div>
                    <div class="pwe-pagination-loading">
                        <div class="loading-bar"></div>
                    </div>
                </div>

                <script> 
                    document.addEventListener("DOMContentLoaded", function () {
                        // Reading the "calendar-page" parameter from the URL at the beginning
                        let urlParams = new URLSearchParams(window.location.search);
                        let currentCalendarPage = parseInt(urlParams.get("calendar-page")) || 1; 

                        // Set the page if there is a "calendar-page" parameter in the URL
                        loadPosts(currentCalendarPage);

                        // Listening for changes in the URL (e.g. when the user clicks the "Back" button in browsers)
                        window.addEventListener("popstate", function() {
                            let urlParams = new URLSearchParams(window.location.search);
                            let calendarP = parseInt(urlParams.get("calendar-page")) || 1;
                            loadPosts(calendarP); // Loading the appropriate page
                        });
                        
                        // Function to load posts
                        function loadPosts(calendarP) {
                            // Get the loading bar element outside the condition so its accessible throughout the function
                            let loadingBar = document.querySelector(".pwe-pagination-loading");
                            
                            // Show loading bar before sending AJAX request
                            if (loadingBar) {
                                loadingBar.style.visibility = "visible"; // Display the loading bar
                                let loadingBarElement = loadingBar.querySelector(".loading-bar");
                                loadingBarElement.style.width = "0%"; // Reset width before starting the animation

                                // Animation of expanding the bar
                                let width = 0;
                                let interval = setInterval(function () {
                                    if (width >= 100) {
                                        clearInterval(interval);
                                    } else {
                                        width += 2; // Increase the width of the bar by 2% every 20ms
                                        loadingBarElement.style.width = width + "%";
                                    }
                                }, 20);
                            }

                            let xhr = new XMLHttpRequest();
                            xhr.open("POST", "/wp-admin/admin-ajax.php", true);
                            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    let response = xhr.responseText;
                                    if (response.trim()) {
                                        // Update posts
                                        document.querySelector(".pwe-calendar__wrapper").innerHTML = response;
                                        
                                        // Update pagination based on current page
                                        updatePagination(calendarP);

                                        // Recreate URLSearchParams after page load or URL change
                                        let urlParams = new URLSearchParams(window.location.search);

                                        if (loadingBar) {
                                            setTimeout(function () {
                                                loadingBar.style.visibility = "hidden"; 
                                            }, 300);
                                        }

                                        if (urlParams.size != 0) {
                                            smoothScrollTo(document.querySelector(".pwe-calendar"), 300);
                                            setTimeout(function () {
                                                window.scrollBy(0, -150);
                                            }, 300);
                                        }  
                                    }
                                }
                            };

                            xhr.send("action=load_more_calendar&calendar-page=" + calendarP + "&posts-per-page=" + '. $pwe_calendar_posts_per_page .');
                        }

                        // Function to update pagination buttons
                        function updatePagination(currentCalendarPage) {
                            let pagination = document.getElementById("pwePagination");
                            pagination.innerHTML = ""; // Clear existing pagination

                            let totalPages = parseInt(' . ceil(count($event_posts_full) / $pwe_calendar_posts_num) . '); // Calculate the number of pages
                            let maxPages = 5; // Maximum number of page buttons
                            let startPage = Math.max(1, currentCalendarPage - 1); // Calculate the starting page
                            let endPage = Math.min(totalPages, currentCalendarPage + 1); // Calculate the ending page
                            
                            let paginationHTML = "";

                            // Show "Previous" button
                            paginationHTML += `<button class="prev-btn" data-calendar-page=" + (currentCalendarPage - 1) + ">‹</button>`;

                            // Show first page if its not visible
                            if (startPage > 2) {
                                paginationHTML += `<button class="page-btn" data-calendar-page="1">1</button>`;
                                paginationHTML += `<span class="dots">...</span>`;
                            }

                            // Show pages between the first page and the last page
                            for (let i = startPage; i <= endPage; i++) {
                                if (i === currentCalendarPage) {
                                    paginationHTML += `<button class="page-btn active" data-calendar-page="${i}">${i}</button>`;
                                } else {
                                    paginationHTML += `<button class="page-btn" data-calendar-page="${i}">${i}</button>`;
                                }
                            }

                            // Show last page if its not visible
                            if (endPage < totalPages - 1) {
                                paginationHTML += `<span class="dots">...</span>`;
                                paginationHTML += `<button class="page-btn" data-calendar-page="${totalPages}">${totalPages}</button>`;
                            }

                            // Show "Next" button
                            paginationHTML += `<button class="next-btn" data-calendar-page=" + (currentCalendarPage + 1) + ">›</button>`;

                            pagination.innerHTML = paginationHTML;

                             // Event listener for pagination buttons
                            pagination.querySelectorAll(".page-btn").forEach(btn => {
                                btn.addEventListener("click", function () {
                                    let calendarP = parseInt(this.getAttribute("data-calendar-page"));
                                    
                                    // Otherwise, update the URL with the selected page
                                    history.replaceState(null, null, "?calendar-page=" + calendarP);

                                    // Loading posts for the selected page
                                    loadPosts(calendarP); 
                                });
                            });

                            // Event listener for previous/next buttons
                            pagination.querySelector(".prev-btn").addEventListener("click", function () {
                                if (currentCalendarPage > 1) {
                                    history.replaceState(null, null, "?calendar-page=" + (currentCalendarPage - 1));
                                    // Loading previous page
                                    loadPosts(currentCalendarPage - 1); 
                                }
                            });

                            pagination.querySelector(".next-btn").addEventListener("click", function () {
                                if (currentCalendarPage < totalPages) {
                                    history.replaceState(null, null, "?calendar-page=" + (currentCalendarPage + 1));
                                    // Loading next page
                                    loadPosts(currentCalendarPage + 1);
                                }
                            });
                        }

                        // Function to smoothly scroll to an element with a specified duration
                        function smoothScrollTo(element, duration) {
                            let startPosition = window.pageYOffset;
                            let targetPosition = element.getBoundingClientRect().top + window.pageYOffset;
                            let distance = targetPosition - startPosition;
                            let startTime = null;

                            function animation(currentTime) {
                                if (startTime === null) startTime = currentTime;
                                let timeElapsed = currentTime - startTime;
                                let run = easeInOut(timeElapsed, startPosition, distance, duration);
                                window.scrollTo(0, run);
                                if (timeElapsed < duration) requestAnimationFrame(animation);
                            }

                            function easeInOut(t, b, c, d) {
                                let ts = (t /= d / 2) < 1 ? c / 2 * t * t + b : -c / 2 * (--t * (t - 2) - 1) + b;
                                return ts;
                            }

                            requestAnimationFrame(animation);
    
                        }
                    });
                </script>';  
            }

        endif;  
        
        if ($pwe_calendar_hide_filter != true) {
            $output .= '
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    function replacePL(text) {
                        return decodeURIComponent(text.replace(/\+/g, " ")).replace(/-/g, " ");
                    }

                    const dropdownBtn = document.querySelector(".dropdown-btn");
                    const dropdownContent = document.querySelector(".dropdown-content");
                    const dropdownMenu = document.getElementById("dropdown-menu");
                    const inputSearchElement = document.getElementById("searchInput");
                    const callendarContainer = document.querySelector(".pwe-calendar__wrapper");
                    const allEvents = callendarContainer ? callendarContainer.querySelectorAll(".pwe-calendar__item") : [];

                    // Expand/close dropdown
                    dropdownBtn?.addEventListener("click", () => {
                        let isExpanded = dropdownBtn.getAttribute("aria-expanded") === "true";
                        dropdownBtn.setAttribute("aria-expanded", !isExpanded);
                        dropdownContent?.classList.toggle("menu-open", !isExpanded);
                        dropdownContent?.classList.toggle("dropdown-delay", isExpanded);
                    });

                    // Generating a list of categories
                    const categories = new Set();
                    allEvents.forEach(event => {
                        const eventCategories = event.getAttribute("search_category")?.split(/\s+/) || [];
                        eventCategories.forEach(category => {
                        if (!["pwe-calendar__item", "'. self::multi_translation("all") .'", "'. self::multi_translation("other") .'", "'. self::multi_translation("premier_editions_class") .'"].includes(category)) {
                            categories.add(category);
                        }
                        });
                    });

                    const uniqueCategories = ["'. self::multi_translation("all") .'", ...[...categories].sort(), "'. self::multi_translation("other") .'", "'. self::multi_translation("premier_editions_class") .'"];
                    uniqueCategories.forEach((cat, i) => {
                        if (cat !== "") {
                            const li = document.createElement("li");
                            li.classList.add(cat.toLowerCase().replace(/\s+/g, "-"));
                            li.innerText = replacePL(cat).toUpperCase();
                            li.style = `--delay: ${i + 1}`;
                            dropdownMenu?.appendChild(li);
                        }
                    });

                    // Changing category names: ŻYWNOŚĆ i PRZEMYSŁ
                    const zywnosc = dropdownMenu?.querySelector(".zywnosc");
                    if (zywnosc) zywnosc.innerText = "ŻYWNOŚĆ";

                    const przemysl = dropdownMenu?.querySelector(".przemysl");
                    if (przemysl) przemysl.innerText = "PRZEMYSŁ";

                    const b2cElements = dropdownMenu?.querySelectorAll("[class*=\'b2c-\']");
                    b2cElements.forEach(element => {
                        element.style.display = "none";
                    });

                    // Handling clicking on a category
                    dropdownMenu?.querySelectorAll("li").forEach(li => {
                        li.addEventListener("click", function (event) {
                            const selected = event.target.className;
                            allEvents.forEach(eventItem => {
                                const categories = eventItem.getAttribute("search_category")?.split(/\s+/) || [];
                                const editionText = eventItem.querySelector(".pwe-calendar__edition p")?.innerText.toLowerCase() || "";
                                const isPremier = editionText.includes("premierowa edycja");

                                let show = selected === "'. self::multi_translation("all") .'"
                                || categories.includes(selected)
                                || (selected === "'. self::multi_translation("premier_editions_class") .'" && isPremier)
                                || (selected === "'. self::multi_translation("other") .'" && categories.length === 0);

                                eventItem.classList.toggle("dont-show", !show);
                            });

                            dropdownBtn.innerHTML = `<span>${event.target.innerText}</span><span class="arrow"></span>`;
                            dropdownBtn.click(); // Closing dropdown
                        });
                    });

                    // Search engine support
                    inputSearchElement?.addEventListener("input", () => {
                        const query = inputSearchElement.value.toLowerCase().trim();

                        allEvents.forEach(eventItem => {
                            const fairName = eventItem.getAttribute("search_engine")?.toLowerCase().trim() || "";
                            const shortName = eventItem.querySelector(".pwe-calendar__short-name")?.innerText.toLowerCase().trim() || "";
                            const match = eventItem.classList.contains(query)
                                || fairName.includes(query)
                                || shortName.includes(query);

                            eventItem.classList.toggle("dont-show", !match);
                        });
                    });
                });
            </script>';
        }

        $output = do_shortcode($output);
        // Zwracamy HTML z dodanym wrapperem
        return '<div id="pweCalendar" class="pwe-calendar">' . $output . '</div>';
    }

    public function render_calendar_event_card($event, $shortcodes_active, $lang_pl = true) {
        $locale = get_locale();

        $post_id = $event['post_id'];
        if ($post_id) {
            $website = get_post_meta($post_id, 'web_page_link', true);
            $host = parse_url($website, PHP_URL_HOST);
            $domain = preg_replace('/^www\./', '', $host);
            $permalink = $event['permalink'];
        } else {
            $domain = '';
        }  

        // Get dates
        $start_date = $event['start_date'];
        $end_date = $event['end_date'];

        // Date formatting
        $formatted_date = self::format_date_range($start_date, $end_date, $locale);

        $date_object = DateTime::createFromFormat('d-m-Y', $start_date);

        $quarterly_date = !empty(get_post_meta($post_id, 'quarterly_date', true)) ? get_post_meta($post_id, 'quarterly_date', true) : ($lang_pl ? 'Nowa data wkrótce' : 'New date comming soon');

        if (($date_object && $date_object->format('Y') == 2050) || (strtotime($end_date . " +1 day") < time())) {
            $fair_date =  $quarterly_date;
        } else {
            $fair_date = $formatted_date;
        }

        $translates = PWECommonFunctions::get_database_translations_data($domain);

        // [pwe_short_desc_{lang}]
        $shortcode_short_desc_pl = self::get_pwe_shortcode("pwe_short_desc_pl", $domain);
        $shortcode_short_desc_pl_available = self::check_available_pwe_shortcode($shortcodes_active, $shortcode_short_desc_pl);
        $short_desc = $shortcode_short_desc_pl_available ? self::get_translated_field($translates[0], 'fair_short_desc') : get_post_meta($post_id, 'short_desc', true);

        // [pwe_visitors]
        $shortcode_visitors = self::get_pwe_shortcode("pwe_visitors", $domain);
        $shortcode_visitors_available = self::check_available_pwe_shortcode($shortcodes_active, $shortcode_visitors);
        $visitors_num = $shortcode_visitors_available ? $shortcode_visitors : get_post_meta($post_id, 'visitors', true);

        // [pwe_exhibitors]
        $shortcode_exhibitors = self::get_pwe_shortcode("pwe_exhibitors", $domain);
        $shortcode_exhibitors_available = self::check_available_pwe_shortcode($shortcodes_active, $shortcode_exhibitors);
        $exhibitors_num = $shortcode_exhibitors_available ? $shortcode_exhibitors : get_post_meta($post_id, 'exhibitors', true);

        // [pwe_countries]
        $shortcode_area = self::get_pwe_shortcode("pwe_area", $domain);
        $shortcode_area_available = self::check_available_pwe_shortcode($shortcodes_active, $shortcode_area);
        $area_num = $shortcode_area_available ? $shortcode_area : get_post_meta($post_id, 'area', true);

        // [pwe_edition]
        $shortcode_edition = self::get_pwe_shortcode("pwe_edition", $domain);
        $shortcode_edition_available = self::check_available_pwe_shortcode($shortcodes_active, $shortcode_edition);
        $edition_num = $shortcode_edition_available ? $shortcode_edition : get_post_meta($post_id, 'edition', true);
        $edition = '';
        if($edition_num == '1'){
            $edition .= self::multi_translation("premier_edition");
        } else {
            $edition .= $edition_num . self::multi_translation("edition");
        }

        $categories = $event['categories'];
        $category_classes = '';
        foreach ($categories as $category) {
                $category_classes .= ' ' . $category->slug;
        }

        $featured_image_url = get_post_meta($post_id, '_featured_image_url', true);
        $secondary_image_url = get_post_meta($post_id, '_secondary_image_url', true);

        $output = '
        <div class="pwe-calendar__item" search_engine="'. $event['post_title'] .' '. get_post_meta($post_id, 'keywords', true) .' " search_category="' . $category_classes . '">
            <a class="pwe-calendar__link" href="'. $permalink .'">
                <div class="pwe-calendar__tile" style="background-image:url(' . esc_url($secondary_image_url) . ');">';
                    if (!empty($short_desc)) {
                        $output .= '
                        <div class="pwe-calendar__short-name">
                            <h4>'. $short_desc .'</h4>
                        </div>';
                    };
                    $output .= '
                    <div class="pwe-calendar_strip">
                        <div class="pwe-calendar__button-check"><p>' . self::multi_translation("check_out") . ' ❯</p></div>
                        <div class="pwe-calendar__edition"><p>' . $edition . '</p></div>
                    </div>
                </div>
                <div class="pwe-calendar__date">
                    <h5>' . $fair_date . '</h5>
                </div>';
                if($edition == 'Premierowa edycja' || $edition == 'Premier edition'){
                    $output .= '<div class="pwe-calendar__statistics-word">' . self::multi_translation("estimates") .'</div>';
                } else {
                    $output .= '<div class="pwe-calendar__statistics-word">' . self::multi_translation("statistics") . '</div>';
                }
                $output .= '

                <div class="pwe-calendar_statistics">
                    <div class="pwe-calendar__statistics-item">
                        <div class="pwe-calendar__statistics-icon">
                            <img 
                                src="https://warsawexpo.eu/wp-content/uploads/2024/09/ikonka_odwiedzajacy.svg" 
                                alt="' . ($lang_pl ? "Ikona odwiedzający" : "Icon visitors") . '"
                            >
                        </div>
                        <div class="pwe-calendar__statistics-name">
                            <p class="pwe-calendar__statistics-label">' . self::multi_translation("visitors") . '</p>
                            <p class="pwe-calendar__statistics-value">' . $visitors_num . '</p>
                        </div>
                    </div>
                    <div class="pwe-calendar__statistics-item">
                        <div class="pwe-calendar__statistics-icon">
                            <img 
                                src="https://warsawexpo.eu/wp-content/uploads/2024/09/ikonka_wystawcy.svg" 
                                alt="' . ($lang_pl ? "Ikona wystawcy" : "Icon exhibitors") . '"
                            >
                        </div>
                        <div class="pwe-calendar__statistics-name">
                            <p class="pwe-calendar__statistics-label">' . self::multi_translation("exhibitors") . '</p>
                            <p class="pwe-calendar__statistics-value">' . $exhibitors_num . '</p>
                        </div>
                    </div>
                    <div class="pwe-calendar__statistics-item">
                        <div class="pwe-calendar__statistics-icon">
                            <img 
                                src="https://warsawexpo.eu/wp-content/uploads/2024/09/ikonka_powierzchnia.svg" 
                                alt="' . ($lang_pl ? "Ikona powierzchnia wystawiennicza" : "Icon exhibition area") . '"
                            >
                        </div>
                        <div class="pwe-calendar__statistics-name">
                            <p class="pwe-calendar__statistics-label">' . self::multi_translation("exhibition_area") . '</p>
                            <p class="pwe-calendar__statistics-value">' . $area_num . ' m<sup>2</sup></p>
                        </div>
                    </div>
                </div>
            </a>
        </div>';

        return $output;
    }

    public function load_more_calendar($pwe_calendar_pagination) {
        try {
            $page = $pwe_calendar_pagination ? (isset($_POST['calendar-page']) ? intval($_POST['calendar-page']) : 1) : (isset($_POST['page']) ? intval($_POST['page']) : 1);
            $posts_per_page = isset($_POST['posts_per_page']) ? intval($_POST['posts_per_page']) : 16;
        
            $args = array(
                'post_type' => 'event',
                'posts_per_page' => -1,  
                'paged' => $page, 
                'post_status' => 'publish',
            );
        
            $query = new WP_Query($args);
            $event_posts = [];
        
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $post_id = get_the_ID();
                    $website = get_post_meta($post_id, 'web_page_link', true);
                    $host = parse_url($website, PHP_URL_HOST);
                    $domain = preg_replace('/^www\./', '', $host);
                    $pwe_db_date_start = date("d-m-Y", strtotime(str_replace("/", "-", self::get_pwe_shortcode("pwe_date_start", $domain))));
                    $start_date = !empty($pwe_db_date_start) ? $pwe_db_date_start : "28-01-2050";
                    $end_date = get_post_meta($post_id, 'fair_date_end', true);
                    $end_date = empty($end_date) ? "30-01-2050" : $end_date;
        
                    $event_posts[] = [
                        'post_id' => $post_id,
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                        'domain' => $domain,
                        'permalink' => get_permalink(),
                        'categories' => get_the_terms($post_id, 'event_category'),
                        'post_title' => get_the_title(),
                    ];
                }
            }
        
            wp_reset_postdata();
        
            usort($event_posts, function ($a, $b) {
                $a_date = DateTime::createFromFormat('d-m-Y', $a['start_date']);
                $b_date = DateTime::createFromFormat('d-m-Y', $b['start_date']);
                return $a_date <=> $b_date;
            });
        
            $offset = ($page - 1) * $posts_per_page;
            $paged_posts = array_slice($event_posts, $offset, $posts_per_page);
        
            foreach ($paged_posts as $event) {
                echo self::render_calendar_event_card($event, true, get_locale() == "pl_PL");
            }

            // Jeśli są posty do załadowania, zmień przycisk
            if ($query->found_posts > ($page * $posts_per_page)) {
                echo '<script>document.getElementById("loadMore").style.display = "block";</script>';
            } else {
                echo '<script>document.getElementById("loadMore").style.display = "none";</script>';
            }
        } catch (Throwable $e) {
            echo '<script>console.log("AJAX ERROR: '. $e->getMessage() .');</script>';
        }
    
        wp_die();
    }
}