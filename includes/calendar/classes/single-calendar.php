<?php
get_header();
add_filter('the_content', 'wpautop'); 

$months_en = array(
    'stycznia' => 'january',
    'lutego' => 'february',
    'marca' => 'march',
    'kwietnia' => 'april',
    'maja' => 'may',
    'czerwca' => 'june',
    'lipca' => 'july',
    'sierpnia' => 'august',
    'września' => 'september',
    'października' => 'october',
    'listopada' => 'november',
    'grudnia' => 'december',
);

function adjustBrightness($hex, $steps) {
    // Convert hex to RGB
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    // Shift RGB values
    $r = max(0, min(255, $r + $steps));
    $g = max(0, min(255, $g + $steps));
    $b = max(0, min(255, $b + $steps));

    // Convert RGB back to hex
    return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
            . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
            . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
}

$post_id = get_the_ID();
$site_url = get_post_meta($post_id, 'web_page_link', true);

$host = parse_url($site_url, PHP_URL_HOST);
$domain = preg_replace('/^www\./', '', $host);

$lang_pl = get_locale() == "pl_PL";

$api_url = 'https://'. $domain .'/wp-content/plugins/custom-element/other/pwe_api.php';
$secretKey = defined('PWE_API_KEY_1') ? PWE_API_KEY_1 : '';
$token = hash_hmac('sha256', parse_url($api_url, PHP_URL_HOST), $secretKey);

$api_options = [
    'http' => [
        'header' => "Authorization: $token\r\n",
        'method' => 'GET',
    ]
];

$api_context = stream_context_create($api_options);
$api_response = file_get_contents($api_url, false, $api_context);
$api_media = json_decode($api_response, true);

$output = '';

$main_logo = 'https://'. $domain .'/doc/logo.webp'; 
$header_bg = 'https://'. $domain .'/doc/background.webp';
if (!empty($api_media["doc"])) {
    // Logo search
    foreach ($api_media["doc"] as $file) {
        if (!$lang_pl && strpos($file['path'], 'logo-calendar-pwe-en.webp') !== false) {
            $main_logo = $file['path'];
            break;
        } elseif (strpos($file['path'], 'logo-calendar-pwe.webp') !== false) {
            $main_logo = $file['path'];
        }
    }

    // Background search
    foreach ($api_media["doc"] as $file) {
        if (strpos($file['path'], 'background.webp') !== false) {
            $header_bg = $file['path'];
        }
    }  
}
$main_logo = !empty(get_post_meta($post_id, '_logo_image', true)) ? get_post_meta($post_id, '_logo_image', true) : $main_logo;
$header_bg = !empty(get_post_meta($post_id, '_header_image', true)) ? get_post_meta($post_id, '_header_image', true) : $header_bg;

// Get localize
$locale = get_locale();

$shortcodes_active = empty(get_option('pwe_general_options', [])['pwe_dp_shortcodes_unactive']);

if (!function_exists('get_pwe_shortcode')) {
    function get_pwe_shortcode($shortcode, $domain) {
        return shortcode_exists($shortcode) ? do_shortcode('[' . $shortcode . ' domain="' . $domain . '"]') : "";
    }
}

if (!function_exists('check_available_pwe_shortcode')) {
    function check_available_pwe_shortcode($shortcodes_active, $shortcode) {
        return $shortcodes_active && !empty($shortcode) && $shortcode !== "Brak danych";
    }
}

$pwe_db_date_start = do_shortcode('[pwe_date_start domain="' . $domain . '"]');
$pwe_db_date_end = do_shortcode('[pwe_date_end domain="' . $domain . '"]');
$pwe_db_date_start_available = $shortcodes_active && !empty($pwe_db_date_start) && $pwe_db_date_start !== "";
$pwe_db_date_end_available = $shortcodes_active && !empty($pwe_db_date_end) && $pwe_db_date_end !== "";

$start_date = $pwe_db_date_start_available ? date("d-m-Y", strtotime(str_replace("/", "-", $pwe_db_date_start))) : get_post_meta($post_id, 'fair_date_start', true);
$start_date = empty($start_date) ? "28-01-2050" : $start_date;
$end_date = $pwe_db_date_end_available ? date("d-m-Y", strtotime(str_replace("/", "-", $pwe_db_date_end))) : get_post_meta($post_id, 'fair_date_end', true);
$end_date = empty($end_date) ? "30-01-2050" : $end_date;

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

// Date formatting function
if (!function_exists('format_date_range')) {
    function format_date_range($start_date, $end_date, $months, $locale) {
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
}

// Date formatting
$formatted_date = format_date_range($start_date, $end_date, $months, $locale);

$date_object = DateTime::createFromFormat('d-m-Y', $start_date);

$quarterly_date = !empty(get_post_meta($post_id, 'quarterly_date', true)) ? get_post_meta($post_id, 'quarterly_date', true) : ($lang_pl ? 'Nowa data wkrótce' : 'New date comming soon');

if (($date_object && $date_object->format('Y') == 2050) || (strtotime($end_date . " +1 day") < time())) {
    $fair_date =  $quarterly_date;
} else {
    $fair_date = $formatted_date;
}

$title = the_title('', '', false);
$title = str_replace(' ', '-', $title);

$organizer = (strpos(strtolower(get_post_meta($post_id, 'organizer_name', true)), 'ptak') !== false) ? 'ptak' : get_post_meta($post_id, 'organizer_name', true);

if (substr($site_url, -4) === '/en/') {
    $site_url = substr($site_url, 0, -4) . '/';
}


// [pwe_desc_pl]
$shortcode_desc_pl = get_pwe_shortcode("pwe_desc_pl", $domain);
$shortcode_desc_pl_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_desc_pl);
$desc_pl = $shortcode_desc_pl_available ? $shortcode_desc_pl : get_post_meta($post_id, 'desc', true);

// [pwe_desc_en]
$shortcode_desc_en = get_pwe_shortcode("pwe_desc_en", $domain);
$shortcode_desc_en_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_desc_en);
$desc_en = $shortcode_desc_en_available ? $shortcode_desc_en : get_post_meta($post_id, 'desc', true);

// [pwe_full_desc_pl]
$shortcode_full_desc_pl = get_pwe_shortcode("pwe_full_desc_pl", $domain);
$shortcode_full_desc_pl_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_full_desc_pl);
$full_desc_pl = $shortcode_full_desc_pl_available ? $fairs_data['fairs'][$domain]['full_desc_pl'] : get_the_content();

// [pwe_full_desc_en]
$shortcode_full_desc_en = get_pwe_shortcode("pwe_full_desc_en", $domain);
$shortcode_full_desc_en_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_full_desc_en);
$full_desc_en = $shortcode_full_desc_en_available ? $fairs_data['fairs'][$domain]['full_desc_en'] : get_the_content();

// [pwe_color_accent]
$shortcode_accent_color = get_pwe_shortcode("pwe_color_accent", $domain);
$shortcode_accent_color_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_accent_color);
$accent_color = $shortcode_accent_color_available ? $shortcode_accent_color : get_post_meta($post_id, 'main_color', true);

$lighter_accent_color = adjustBrightness($accent_color, 50);
$light_accent_color = adjustBrightness($accent_color, 70);

// [pwe_color_main2]
$shortcode_main2_color = get_pwe_shortcode("pwe_color_main2", $domain);
$shortcode_main2_color_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_main2_color);
$main2_color = $shortcode_main2_color_available ? $shortcode_main2_color : get_post_meta($post_id, 'main2_color', true);

$dark_main2_color = adjustBrightness($main2_color, -30);

// [pwe_visitors]
$shortcode_visitors = get_pwe_shortcode("pwe_visitors", $domain);
$shortcode_visitors_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_visitors);
$visitors_num = $shortcode_visitors_available ? $shortcode_visitors : get_post_meta($post_id, 'visitors', true);

// [pwe_exhibitors]
$shortcode_exhibitors = get_pwe_shortcode("pwe_exhibitors", $domain);
$shortcode_exhibitors_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_exhibitors);
$exhibitors_num = $shortcode_exhibitors_available ? $shortcode_exhibitors : get_post_meta($post_id, 'exhibitors', true);

// [pwe_countries]
$shortcode_countries = get_pwe_shortcode("pwe_countries", $domain);
$shortcode_countries_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_countries);
$countries_num = ($shortcode_countries_available || $shortcode_countries !== "0") ? $shortcode_countries : get_post_meta($post_id, 'countries', true);

// [pwe_edition]
$shortcode_edition = get_pwe_shortcode("pwe_edition", $domain);
$shortcode_edition_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_edition);

if ($shortcode_edition_available) {
    if($shortcode_edition == '1'){
        $edition .= ($lang_pl ? "Premierowa edycja" : "Premier edition");
    } else {
        $edition .= $shortcode_edition . ($lang_pl ? ". edycja" : ". edition"); 
    }
}

wp_enqueue_style('slick-slider-css', site_url('/wp-content/plugins/PWElements/assets/slick-slider/slick.css'));
wp_enqueue_style('slick-slider-theme-css', site_url('/wp-content/plugins/PWElements/assets/slick-slider/slick-theme.css'));
wp_enqueue_script('slick-slider-js', site_url('/wp-content/plugins/PWElements/assets/slick-slider/slick.min.js'), array('jquery'), null, true);

$output .= '
<style>
    .color-accent {
        color: '. $accent_color .';
    }
    .color-main2 {
        color: '. $main2_color .';
    }
    .single-event__wrapper {
        display: flex;
        flex-direction: column;
        padding: 36px 18px;
    }
    .single-event__btn-container a {
        transition: .3s ease;
        box-shadow: 0px 0px 10px #7f7f7f !important;
    }
    .single-event__btn-container a:hover {
        transform: scale(0.98);
    }
    @media (max-width: 960px){
        .single-event__wrapper {
            padding: 0 0 18px;
        }
        .mobile-hidden {
            display: none;
        }
    }



    /* Header section <----------------------------> */
    .single-event__container-header {
        position: relative;
        background-image: url('. $header_bg .');
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-radius: 18px;
        min-height: 300px;
    }
    .single-event__header-bottom {
        display: flex;
        justify-content: space-between;
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
    }
    .single-event__header-edition {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        text-transform: uppercase;
        width: 100%;
        background: #00000070;
        margin-right: -18px;
        border-radius: 0 0 0 18px;
    }
    .single-event__header-edition span {
        color: white;
        font-size: 20px;
        margin-right: 18px;
        font-weight: 700;
    }
    .single-event__header-buttons {
        display: flex;
        padding: 0 18px 0;
        background: white;
        border-radius: 18px 0 0 0;
        gap: 18px;
        box-shadow: inset -3px -3px 5px 0px #ffffff, 3px 3px 5px 0px #ffffff, 3px 3px 5px 0px #ffffff, inset 3px 3px 5px 0px #cfcfcf;
    }
    .single-event__btn-container {
        min-width: 300px; 
        margin-top: 14px;   
    }
    .single-event__btn-container a {
        display: flex;
        justify-content: center;
        background: '. $main2_color .';
        color: white;
        border-radius: 36px;
        padding: 14px 36px;
        font-size: 16px;
        font-weight: 600;
    }
    .single-event__btn-container a.single-event__btn-dark {
        background: '. $dark_main2_color .';
    }
    .single-event__btn-container a:hover {
        background: '. $accent_color .';
    }
    .single-event__header-logotype {
        position: absolute;
        top: 45%;
        left: 36px;
        transform: translate(0, -55%);
        max-width: 300px;
    }
    .single-event__header-logotype img {
        width: 100%;
        max-height: 200px;
    }

    @media (max-width: 960px){
        .single-event__container-header {
            border-radius: 0;
        }
        .single-event__header-logotype {
            top: 40%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .single-event__header-bottom {
            bottom: 18px;
        }
        .single-event__header-edition {
            padding: 6px;
            border-radius: 0;
        }
    }


    /* Description section mobile <----------------------------> */
    .single-event__container-desc.mobile {
        display: none;
    }
    .single-event__header-buttons.mobile {
        display: none;
    }
    @media (max-width: 960px) {
        .single-event__container-desc.mobile {
            display: flex;
            padding: 18px;
            margin-top: -18px;
            background: white;
            border-radius: 18px 18px 0 0;
            z-index: 2;
        }
        .single-event__header-buttons.mobile {
            margin-top: 18px;
        }
        .single-event__header-buttons.desktop {
            display: none;
        }
        .single-event__header-buttons.mobile {
            display: flex;
            flex-wrap: wrap;
            box-shadow: unset;
            justify-content: center;
        }
    }
    @media (max-width: 450px) {
        .single-event__container-desc.mobile .single-event__date,
        .single-event__container-desc.mobile .single-event__main-title {
            text-align: center;
        }
    }


    /* Description section <----------------------------> */
    .single-event__container-desc {
        display: flex;
        gap: 20px;
        padding-top: 18px;
    }
    .single-event__desc-column.title {
        width: 45%;
    }
    .single-event__desc-column.description {
        width: 55%;
    }
    .single-event__desc-column.description .row-parent {
        padding: 0 !important;
    }
    .single-event__desc-column.description strong {
        color: '. $accent_color .' !important;
        font-weight: 700 !important;
    }
    .single-event__desc-column p {
        margin: 0;
    }
    .single-event__date {
        font-size: 20px !important;
        text-transform: lowercase;
        margin: 0 0 10px 0;
        font-weight: 700;
    }
    .single-event__main-title {
        font-size: 30px !important;
        margin: 0;
        text-transform: unset !important;
    }
    .single-event__btn-container.webpage span {
        margin-left: 10px;
        font-size: 40px;
        font-weight: 300;
        height: 15px;
        width: 15px;
        display: flex;
        justify-content: center;
        align-items: center;
        transition: .3s ease;
    }
    .single-event__btn-container.webpage:hover span {
        transform: translateX(10px);
    }
    .single-event__container-desc .single-event__btn-container a {
        margin-top: 26px;
        max-width: 300px !important;
    }
    @media (max-width: 960px){
        .single-event__container-desc.desktop {
            flex-direction: column;
            padding: 18px;
        }
        .single-event__container-desc {
            margin-top: 0;
            flex-wrap: wrap;
        }
        .single-event__desc-column {
            width: 100% !important;
        }
        .single-event__date {
            font-size: 26px !important;
        }
        .single-event__main-title {
            font-size: 30px !important;
        }
        .single-event__btn-container a {
            margin: 0 auto !important;
        }
        .single-event__container-desc.mobile .single-event__btn-container {
            margin-top: 0;
        }
    }
    /* <----------------------------> */




    /* Partners logotypes <----------------------------> */
    .single-event__container-partners {
        display: flex;
        padding-top: 18px;
    }
    .single-event__partners-title {
        display: flex;
        align-items: center;
        min-width: 320px;
    }
    .single-event__partners-title h4 {
        font-size: 24px !important;
        text-transform: uppercase;
        margin: 0;
    }
    .single-event__partners-logotypes {
        width: 100%;
        overflow: hidden;
        display: flex;
    }
    .single-event__partners-logo {
        margin: 10px;
    }
    .single-event__container-partners img {
        aspect-ratio: 4 / 2;
        object-fit: contain;
    }  
    @media (max-width: 960px){
        .single-event__container-partners {
            box-shadow: 0px 0px 10px #d2d2d2 !important;
            padding: 18px;
            margin: 10px 0;
        }
    }  
    @media (max-width: 650px){
        .single-event__container-partners {
            flex-direction: column;
        }
        .single-event__partners-title {
            margin: 0 auto;
            justify-content: center;
        }
        .single-event__partners-title h4 {
            font-size: 24px !important;
        }
    }
    /* <----------------------------> */


    /* Tiles section <----------------------------> */
    .single-event__container-tiles {
        display: flex;
        height: 400px;
        gap: 20px;
        padding-top: 36px;
    }
    .single-event__tiles-item {
        box-shadow: 0px 0px 7px #929292 !important;
    }
    .single-event__tiles-left-container {
        width: 45%;
        height: 100%;
        position: relative;
        background-image: url(https://'. $domain .'/doc/photo-calendar.webp);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        border-radius: 18px;
        transition: .3s ease;
    }
    .single-event__tiles-left-container a {
        display: flex;
        width: 100%;
        height: 100%;
    }
    .single-event__tiles-right-container {
        display: flex;
        flex-direction: column-reverse;
        width: 55%;
        height: 100%;
        gap: 20px;
    }
    .single-event__tiles-right-top {
        height: 50%;
        position: relative;
        border-radius: 18px;
        transition: .3s ease;
        background: '. $lighter_accent_color .';
    }
    .single-event__tiles-right-top:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background-image: url(https://warsawexpo.eu/wp-content/uploads/2023/03/map_single_event_transparent.webp);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        z-index: 1;
    }
    /* <----------------------------> */

    /* Tiles section (numbers) */
    .single-event__statistics-wrapper {
        position: relative;
        display: flex;
        justify-content: center;
        float: right;
        align-items: center;
        width: 100%;
        height: 100%;
        gap: 36px;
        z-index: 2;
        gap: 30px;
    }
    .single-event__statistics-numbers {
        display: flex;
        flex-direction: column;
        margin: 0;
        text-shadow: 1px 1px 24px black;
    }
    .single-event__statistics-number {
        font-size: 42px;
        font-weight: 700;
        color: white;
        text-align: center;
    }
    .single-event__statistics-name {
        color: white;
        font-family: system-ui !important;
        text-shadow: 1px 1px 24px black;
    }
    /* <----------------------------> */

    /* Tiles section (conference) */
    .single-event__tiles-right-bottom {
        height: 50%;
        display: flex;
        gap: 20px;
    }
    .single-event__tiles-right-bottom-attractions {
        background-image: url(https://'. $domain .'/doc/attractions.webp);
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100%;
        height: 100%;
        position: relative;
        border-radius: 18px;
        transition: .3s ease;
    }
    .single-event__tiles-right-bottom-attractions a {
        display: flex;
        width: 100%;
        height: 100%;
    }
    .single-event__tiles-right-bottom-left {
        width: ' . (empty($api_media["konferencje"]) ? "100%" : "50%") . ';
        height: 100%;
        position: relative;
        border-radius: 18px;
        transition: .3s ease;
        background: '. $accent_color .';
    }
    .single-event__tiles-right-bottom-left a {
        display: flex;
        justify-content: center;
        width: 100%;
        height: 100%;
    }
    .single-event__tiles-right-bottom-left img {
        object-fit: contain;
        padding: 24px;
        max-width: 260px;
        width: 100%;
    }
    .single-event__tiles-right-bottom-right {
        width: 50%;
        height: 100%;
        position: relative;
        border-radius: 18px;
        transition: .3s ease;
        background: white;
    }
    .single-event__conference-logotype {
        display: flex;   
    }
    .single-event__tiles-hover:hover {
        transform: scale(0.98);
    }
    .single-event__container-tiles .single-event__caption {
        position: absolute;
        left: 0;
        bottom: 0;
        background: white;
        padding: 14px 20px;
        font-size: 18px;
        font-weight: 600;
        border-radius: 0 18px 0 0;
        z-index: 2;
        left: 0 !important;
        bottom: 0 !important;
        box-shadow: inset 2px -2px 3px 0px #ffffff, 
                    -1px 7px 1px #ffffff, 
                    -7px 7px 5px #ffffff, 
                    -7px 1px 1px #ffffff, 
                    inset -2px 2px 5px 0px #cfcfcf;
    }
    .single-event__container-tiles a {
        color: black !important;
    }
    
    @media (max-width: 960px){
        .single-event__container-tiles {
            flex-direction: column;
            height: auto;
            padding: 18px 18px 0;
        }
        .single-event__tiles-left-container {
            width: 100%;
            height: 300px;
        }
        .single-event__tiles-right-container {
            width: 100%;
            min-height: 300px;
        }
        .single-event__tiles-right-top {
            height: 33%;
            min-height: 150px;
        }
        .single-event__statistics-wrapper {
            min-height: 150px;
        }
        .single-event__statistics-number {
            font-size: 30px;
        }
        .single-event__statistics-name {
            font-size: 14px;
        }
        .single-event__container-tiles .single-event__caption {
            padding: 10px;
            font-size: 14px;
        }
        .single-event__tiles-right-bottom {
            height: 66%;
            display: flex;
            flex-direction: column;
        }
        .single-event__tiles-right-bottom-left {
            width: 100%;
            min-height: 150px;
        }
        .single-event__tiles-right-bottom-left img {
            max-width: 300px;
        }
        .single-event__tiles-right-bottom-right,
        .single-event__tiles-right-bottom-attractions {
            width: 100%;
            min-height: 150px;
        }
        .single-event__conference-logotype {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .single-event__container-tiles .single-event__organizer .single-event__caption {
            background: unset;
            border: none;
            text-align: center;
            bottom: 0 !important;
            left: 0 !important;
        }
        .single-event__conferences-logo {
            padding: 24px 10px;
        }
    }
    @media (max-width: 400px) {
        .single-event__statistics-name {
            font-size: 12px;
        }
    }
    /* <----------------------------> */

    /* Events logotypes <----------------------------> */
    .single-event__events-logotypes {
        margin-top: 18px;
    }
    .single-event__events-logo {
        margin: 10px;
        padding: 10px;
        box-shadow: 1px 1px 10px #bababa !important;
        border-radius: 18px;
        display: flex !important;
        flex-direction: column;
        justify-content: center;
    }
    .single-event__events-title h4 {
        font-size: 30px;
    }
    .single-event__events-logo-title {
        margin-top: 10px;
        text-align: center;
        font-size: 14px;
        font-weight: 600;
    }
    @media (max-width: 960px){
        .single-event__container-events {
            padding: 0 18px;
        }
    }
    @media (max-width: 650px){
        .single-event__events-title h4 {
            font-size: 24px !important;
        }
    }
    /* <----------------------------> */

    /* Conferences logotypes <----------------------------> */
    .single-event__conferences-logotypes {
        margin: 0 auto;
        max-width: 200px;
    }
    .single-event__conferences-logo {
        padding: 24px;
    }
    .single-event__conferences-logo img {
        object-fit: contain;
        border-radius: 10px;
    }
    @media (max-width: 650px){
        .single-event__events-logo-title {
            font-size: 14px;
        }
    }


    /* Footer section <----------------------------> */
    .single-event__container-footer {
        display: flex;
        justify-content: space-evenly;
        padding: 18px;
        background-color: rgba(33, 0, 0, 0.05);
        border-radius: 18px;
        margin-top: 18px;
        gap: 10px;
    }
    .single-event__footer-ptak-logo {
        display: flex;
        justify-content: center;
        width: 33%;
    }
    .single-event__footer-content {
        width: 66%;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }
    .single-event__footer-ptak-adress, 
    .single-event__footer-ptak-contact {
        display: flex;
        align-items: center;
    }
    .single-event__footer-ptak-logo img {
        width: 100px;
        object-fit: contain;
    }
    .single-event__footer-ptak-adress div, 
    .single-event__footer-ptak-contact div {
        display: flex;
        flex-direction: column;
    }
    .single-event__footer-ptak-adress p, 
    .single-event__footer-ptak-contact p {
        margin: 0;
    }
    @media (max-width: 960px) {
        .single-event__container-footer {
            margin: 18px 18px 0;
            padding: 8px;
        }
    }
    @media (max-width: 569px){
        .single-event__footer-content {
            flex-direction: column;
        }
    }
</style>';

$first_date = explode('-', $start_date);
$second_date = explode('-', $end_date);

$schame_date_start = $first_date[2]. '-' .$first_date[1]. '-' . $first_date[0];
$schame_date_end = $second_date[2]. '-' .$second_date[1]. '-' . $second_date[0];

while (have_posts()):
    the_post();

    $output .= '
    <div data-parent="true" class="vc_row limit-width row-container boomapps_vcrow '. $title .'" data-section="21" itemscope itemtype="http://schema.org/Event">
        <div class="single-event" data-imgready="true">
            <div class="single-event__wrapper">';

                // Header section
                $output .= '
                <div class="single-event__container-header">
                    <div class="single-event__header-logotype">
                        <img src="'. $main_logo .'" alt="Trade Fair Logo"/>
                    </div>
                    <div class="single-event__header-bottom">
                        <div class="single-event__header-edition">
                            <span>'. $edition .'</span>
                        </div>
                        <div class="single-event__header-buttons desktop">';
                            if(!empty(get_post_meta($post_id, 'buy_ticket_link', true))) {
                                $output .= '
                                <span class="single-event__btn-container">
                                    <a 
                                        target="_blank" 
                                        rel="noopener" 
                                        href="'. get_post_meta($post_id, 'buy_ticket_link', true) .'" 
                                        class="single-event__btn" 
                                        data-title="'. ($lang_pl ? "Kup bilet" : "Buy ticket") .'" 
                                        title="'. ($lang_pl ? "Kup bilet" : "Buy ticket") .'">
                                        '. ($lang_pl ? "Kup bilet" : "Buy ticket") .'
                                    </a>
                                </span>';
                            } else if(!empty(get_post_meta($post_id, 'visitor_registration_link', true))) {
                                $output .= '
                                <span 
                                    itemprop="offers" 
                                    itemscope 
                                    itemtype="http://schema.org/Offer" 
                                    class="single-event__btn-container">
                                    <a 
                                        itemprop="url" 
                                        target="_blank" 
                                        rel="noopener" 
                                        href="'. get_post_meta($post_id, 'visitor_registration_link', true) .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" 
                                        class="single-event__btn" 
                                        data-title="'. ($lang_pl ? "Odbierz zaproszenie" : "Collect your invitation") .'" 
                                        title="'. ($lang_pl ? "Odbierz zaproszenie" : "Collect your invitation") .'">
                                        '. ($lang_pl ? "Odbierz zaproszenie" : "Collect your invitation") .'
                                    </a>
                                </span>';
                            }
                            if(!empty(get_post_meta($post_id, 'exhibitor_registration_link', true))) {
                                $output .= '
                                <span class="single-event__btn-container single-event-btn">
                                    <a 
                                        target="_blank" 
                                        rel="noopener" 
                                        href="'. get_post_meta($post_id, 'exhibitor_registration_link', true) .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" 
                                        class="single-event__btn single-event__btn-dark" 
                                        data-title="'. ($lang_pl ? "Zostań wystawcą" : "Become an exhibitor") .'" 
                                        title="'. ($lang_pl ? "Zostań wystawcą" : "Become an exhibitor") .'">
                                        '. ($lang_pl ? "Zostań wystawcą" : "Become an exhibitor") .'
                                    </a>
                                </span>';
                            }
                            $output .= '
                        </div>
                    </div>    
                </div>';

                // Description section mobile
                $output .= '
                <div class="single-event__container-desc mobile">
                    <div class="single-event__desc-column title">
                        <time itemprop="startDate" datetime="'. $schame_date_start .'"></time>
                        <time itemprop="endDate" datetime="'. $schame_date_end .'"></time>
                        <h2 class="single-event__date color-accent">'. $fair_date .'</h2>
                        <h1 class="single-event__main-title" itemprop="name" style="text-transform:uppercase;">'. ($lang_pl ? $desc_pl : $desc_en) .'</h1>';
                        $output .= '
                        <div class="single-event__header-buttons mobile">';
                            if(!empty(get_post_meta($post_id, 'buy_ticket_link', true))) {
                                $output .= '
                                <span class="single-event__btn-container">
                                    <a 
                                        target="_blank" 
                                        rel="noopener" 
                                        href="'. get_post_meta($post_id, 'buy_ticket_link', true) .'" 
                                        class="single-event__btn" 
                                        data-title="'. ($lang_pl ? "Kup bilet" : "Buy ticket") .'" 
                                        title="'. ($lang_pl ? "Kup bilet" : "Buy ticket") .'">
                                        '. ($lang_pl ? "Kup bilet" : "Buy ticket") .'
                                    </a>
                                </span>';
                            } else if(!empty(get_post_meta($post_id, 'visitor_registration_link', true))) {
                                $output .= '
                                <span 
                                    itemprop="offers" 
                                    itemscope 
                                    itemtype="http://schema.org/Offer" 
                                    class="single-event__btn-container">
                                    <a 
                                        itemprop="url" 
                                        target="_blank" 
                                        rel="noopener" 
                                        href="'. get_post_meta($post_id, 'visitor_registration_link', true) .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" 
                                        class="single-event__btn" 
                                        data-title="'. ($lang_pl ? "Odbierz zaproszenie" : "Collect your invitation") .'" 
                                        title="'. ($lang_pl ? "Odbierz zaproszenie" : "Collect your invitation") .'">
                                        '. ($lang_pl ? "Odbierz zaproszenie" : "Collect your invitation") .'
                                    </a>
                                </span>';
                            }
                            if(!empty(get_post_meta($post_id, 'exhibitor_registration_link', true))) {
                                $output .= '
                                <span class="single-event__btn-container single-event-btn">
                                    <a 
                                        target="_blank" 
                                        rel="noopener" 
                                        href="'. get_post_meta($post_id, 'exhibitor_registration_link', true) .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" 
                                        class="single-event__btn single-event__btn-dark" 
                                        data-title="'. ($lang_pl ? "Zostań wystawcą" : "Become an exhibitor") .'" 
                                        title="'. ($lang_pl ? "Zostań wystawcą" : "Become an exhibitor") .'">
                                        '. ($lang_pl ? "Zostań wystawcą" : "Become an exhibitor") .'
                                    </a>
                                </span>';
                            }
                            $output .= '
                        </div>
                    </div>
                </div>'; 

                // Partners section
                if (!empty($api_media["partnerzy"])) {
                    $output .= '
                    <div class="single-event__container-partners">
                        <div class="single-event__partners-title">
                            <h4>'. ($lang_pl ? "Patroni i Partnerzy" : "Patrons and Partners") .'</h4>
                        </div>
                        <div class="single-event__partners-logotypes single-event__logotypes-slider">';
                            foreach ($api_media["partnerzy"] as $logo) {
                                $output .= '
                                <div class="single-event__partners-logo">
                                    <img src="'. $logo["path"] .'" alt="Partner\'s logo"/>
                                </div>'; 
                            } 
                        $output .= '
                        </div>
                    </div>';
                } else if (!empty(get_post_meta($post_id, 'partners_gallery', true))) {
                    $seperated_logotypes = get_post_meta($post_id, 'partners_gallery', true);
                    
                    $output .= '
                    <div class="single-event__container-partners">
                        <div class="single-event__partners-title">
                            <h4>'. ($lang_pl ? "Patroni i Partnerzy" : "Patrons and Partners") .'</h4>
                        </div>
                        <div class="single-event__partners-logotypes single-event__logotypes-slider">';
                            foreach ($seperated_logotypes as $logo) {
                                $url = trim($logo);
                                $output .= '
                                <div class="single-event__partners-logo">
                                    <img src="'. $url .'" alt="Partner\'s logo"/>
                                </div>';
                            }
                        $output .= '
                        </div>
                    </div>';
                }

                // Description section 
                $output .= '
                <div class="single-event__container-desc desktop">
                    <div class="single-event__desc-column title">
                        <time itemprop="startDate" datetime="'. $schame_date_start .'"></time>
                        <time itemprop="endDate" datetime="'. $schame_date_end .'"></time>
                        <h2 class="single-event__date color-accent mobile-hidden">'. $fair_date .'</h2>
                        <h1 class="single-event__main-title mobile-hidden" itemprop="name" style="text-transform:uppercase;">'. ($lang_pl ? $desc_pl : $desc_en) .'</h1>';
                        if(!empty(get_post_meta($post_id, 'web_page_link', true))) {
                            $output .= '
                            <span class="single-event__btn-container webpage">
                                <a 
                                    target="_blank" 
                                    rel="noopener" 
                                    itemprop="url" 
                                    href="'. get_post_meta($post_id, 'web_page_link', true) .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" 
                                    class="single-event__btn" 
                                    data-title="'. ($lang_pl ? "Strona internetowa" : "Website") .'" 
                                    title="'. ($lang_pl ? "Strona internetowa" : "Website") .'">
                                    '. ($lang_pl ? "Strona internetowa" : "Website") .' <span class="btn-angle-right">&#8250;</span>
                                </a>
                            </span>';
                        }
                    $output .= '
                    </div>
                    <div class="single-event__desc-column description" itemprop="description">'.  ($lang_pl ? $full_desc_pl : $full_desc_en) .'</div>
                </div>'; 

                // Tiles section
                if ($organizer == "ptak") {
                    $output .= '
                    <div class="single-event__container-tiles">
                        <div class="single-event__tiles-left-container single-event__tiles-item single-event__tiles-hover">
                            <a href="https://'. $domain . ($lang_pl ? "/" : "/en/") .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" target="_blank">
                                <span class="single-event__caption">'. ($lang_pl ? "Poznaj targi" : "Discover the trade fair") .'</span>   
                            </a>
                        </div>
                        <div class="single-event__tiles-right-container">

                            <div class="single-event__tiles-right-top single-event__statistics single-event__tiles-item single-event__tiles-hover">
                                <div class="single-event__statistics-wrapper">';
                                    if ($visitors_num !== "" && $visitors_num !== "0") {
                                        $output .= '
                                        <div class="single-event__statistics-numbers visitors">
                                            <span class="single-event__statistics-number countup" data-count="'. $visitors_num .'">0</span>
                                            <span class="single-event__statistics-name">'. ($lang_pl ? "ODWIEDZAJĄCYCH" : "VISITORS") .'</span>
                                        </div>';
                                    }
                                    if ($exhibitors_num !== "" && $exhibitors_num !== "0") {
                                        $output .= '
                                        <div class="single-event__statistics-numbers exhibitors">
                                            <span class="single-event__statistics-number countup" data-count="'. $exhibitors_num .'">0</span>
                                            <span class="single-event__statistics-name">'. ($lang_pl ? "WYSTAWCÓW" : "EXHIBITORS") .'</span>
                                        </div>';
                                    }
                                    if ($countries_num !== "" && $countries_num !== "0") {
                                        $output .= '
                                        <div class="single-event__statistics-numbers countries">
                                            <span class="single-event__statistics-number countup" data-count="'. $countries_num .'"></span>
                                            <span class="single-event__statistics-name">'. ($lang_pl ? "KRAJÓW" : "COUNTRIES") .'</span>
                                        </div>';
                                    }
                                $output .= '    
                                </div>
                                <span class="single-event__caption">'. ($shortcode_edition == '1' ? ($lang_pl ? "Estymacje" : "Estimates") : ($lang_pl ? "Statystyki" : "Statistics")) .'</span>  
                            </div>

                            <div class="single-event__tiles-right-bottom">';

                                if (!empty(get_post_meta($post_id, 'buy_ticket_link', true))) {
                                    $output .= '
                                    <div class="single-event__tiles-right-bottom-attractions single-event__tiles-item single-event__tiles-hover">
                                        <a href="https://'. $domain . ($lang_pl ? "/atrakcje/" : "/en/attractions/") .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" target="_blank">
                                            <span class="single-event__caption">'. ($lang_pl ? "Atrakcje" : "Attractions") .'</span>   
                                        </a>
                                    </div>';
                                } else {
                                    $output .= '
                                    <div class="single-event__tiles-right-bottom-left single-event__conference single-event__tiles-item single-event__tiles-hover">
                                        <a href="https://'. $domain . ($lang_pl ? "/wydarzenia/" : "/en/conferences/") .'?utm_source=warsawexpo&utm_medium=kalendarz&utm_campaign=refferal" target="_blank">
                                            <div class="single-event__conference-logotype">
                                                <img src="https://'. $domain .'/doc/kongres.webp"/ alt="Congress Logo">
                                            </div>
                                            <span class="single-event__caption">'. ($lang_pl ? "Konferencja" : "Conference") .'</span>  
                                        </a>
                                    </div>';

                                    if (!empty($api_media["konferencje"])) {
                                        $output .= '
                                        <div class="single-event__tiles-right-bottom-right single-event__organizer single-event__tiles-item single-event__tiles-hover">
                                            <div class="single-event__conferences-logotypes single-event__logotypes-slider">';
                                                foreach ($api_media["konferencje"] as $logo) {
                                                    // Get filename without extension
                                                    $filename_conferences = $logo["title"];

                                                    // Matching name in format "Partner Targów - Partner of the Fair"
                                                    if (preg_match('/^(.*) - (.*)$/', $filename_conferences, $matches)) {
                                                        // Polish name before " - "
                                                        $title_pl = trim($matches[1]); 
                                                        // English name after " - "
                                                        $title_en = trim($matches[2]); 
                                                    } else {
                                                        // If no match found, use full name
                                                        $title_pl = $filename_conferences; 
                                                        $title_en = $filename_conferences;
                                                    }

                                                    $output .= '
                                                    <div class="single-event__conferences-logo">
                                                        <img src="'. $logo["path"] .'" alt="'. ($lang_pl ? $title_pl : $title_en) .'"/>
                                                    </div>'; 
                                                } 
                                            $output .= '
                                            </div>
                                            <span class="single-event__caption"></span>  
                                        </div>';
                                    }
                                }     
                                $output .= '
                            </div>

                        </div> 
                    </div>';
                }

                // Events section
                if (!empty($api_media["wydarzenia"])) {

                    $api_media_events = $api_media["wydarzenia"];
                    $api_media_doc = $api_media["doc"];

                    // Check if the "Europa EN" folder exists by searching for its path
                    $europa_en_exists = false;
                    foreach ($api_media_doc as $item) {
                        if (strpos($item["path"], "/Logotypy/Europa EN/") !== false) {
                            $europa_en_exists = true;
                            break;
                        }
                    }

                    if ($europa_en_exists) {
                        // If "Europa EN" exists, filter logos from that folder
                        $europa_en_logotypes = array_filter($api_media_doc, function($item) {
                            return strpos($item["path"], "/Logotypy/Europa EN/") !== false;
                        });
                    } else {
                        // If "Europa EN" doesn't exist, fetch all logotypes from $api_media["wydarzenia"]
                        $europa_en_logotypes = array_filter($api_media_events, function($item) {
                            return strpos($item["path"], "Logotypy") !== false;
                        });
                    }

                    if (!$lang_pl && ($domain == 'targirehabilitacja.pl' || $domain == 'centralnetargirolnicze.com')) {
                        $events_logotypes = $europa_en_logotypes;
                    } else {
                        $events_logotypes = $api_media_events;
                    }

                    function format_title($title) {
                        return preg_replace('/\((.*?)\)/', '<br><span style="color: #888;">($1)</span>', $title);
                    }

                    $output .= '
                    <div class="single-event__container-events">
                        <div class="single-event__events-title">
                            <h4>'. ($lang_pl ? "Najważniejsze Wydarzenia Branżowe w Europie" : "The Most Important Industry Events in Europe") .'</h4>
                        </div>
                        <div class="single-event__events-logotypes single-event__logotypes-slider">';
                            $non_warsaw = [];
                            $warsaw_logos = [];
                            
                            // Division of logos into two groups
                            foreach ($events_logotypes as $logo) {
                                // Get file name without extension
                                $filename_events = basename($logo["path"], ".webp");
                                
                                // Check if name contains "warsaw" or "warsawa" (case-insensitive)
                                if (stripos($filename_events, "warsaw") !== false || stripos($filename_events, "warsawa") !== false) {
                                    $warsaw_logos[] = $logo;
                                } else {
                                    $non_warsaw[] = $logo;
                                }
                            }
                            
                            // Merge the boards – the ones with warsaw at the end
                            $sorted_logos = array_merge($non_warsaw, $warsaw_logos);
                            
                            foreach ($sorted_logos as $logo) {
                                // Get file name without extension
                                $filename_events = basename($logo["path"], ".webp");
                            
                                // Matching name in format "Europe/IPM (Essen, Germany) - IPM (Essen, Germany)"
                                if (preg_match('/^(.*) - (.*)$/', $filename_events, $matches)) {
                                    // Polish name before " - "
                                    $title_pl = trim($matches[1]); 
                                    // English name after " - "
                                    $title_en = trim($matches[2]); 
                                } else {
                                    // If no match, use full name
                                    $title_pl = $filename_events; 
                                    $title_en = $filename_events;
                                }
                            
                                $formatted_title_pl = format_title($title_pl ?? '');
                                $formatted_title_en = format_title($title_en ?? '');
                                                                                        
                                $output .= '
                                <div class="single-event__events-logo">
                                    <img src="'. $logo["path"] .'" alt="'. ($lang_pl ? $title_pl : $title_en) .'"/>
                                    <div class="single-event__events-logo-title"><span>'. ($lang_pl ? $formatted_title_pl : $formatted_title_en) .'</span></div>
                                </div>'; 
                            }
                        $output .= '
                        </div>
                    </div>';
                }

                // Footer section
                $output .= '
                <div class="single-event__container-footer" itemprop="location" itemscope itemtype="https://schema.org/Place">
                    <div class="single-event__footer-ptak-logo">
                        <meta itemprop="name" content="Ptak Warsaw Expo">
                        <meta itemprop="telephone" content="'. get_post_meta($post_id, 'organizer_phone', true) .'">
                        <img class="wp-image-95078 ptak-logo-item" src="https://warsawexpo.eu/wp-content/plugins/PWElements/media/logo_pwe_black.png" width="155" height="135" alt="logo ptak">
                    </div>
                    <div class="single-event__footer-content">
                        <div class="single-event__footer-ptak-adress" itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
                            <div>';
                            if ($organizer == "ptak") {
                                $output .= '
                                <p><span itemprop="streetAddress">Al. Katowicka 62</span></p>
                                <p><span itemprop="postalCode">05-830</span><span itemprop="addressLocality"> Nadarzyn, '. ($lang_pl ? "Polska" : "Poland") .'</span></p>';
                            } else if ($organizer == "Trends Expo") {
                                $output .= '
                                <p><span itemprop="streetAddress">ul. Tuszyńska 72/74</span></p>
                                <p><span itemprop="postalCode">95-030</span><span itemprop="addressLocality"> Rzgów k. Łodzi, '. ($lang_pl ? "Polska" : "Poland") .'</span></p>';
                            }
                            $output .= '
                            </div>
                        </div>
                        <div class="single-event__footer-ptak-contact" itemscope itemtype="https://schema.org/Organization">
                            <meta itemprop="name" content="Ptak Warsaw Expo">
                            <meta itemprop="description" content="Największe centrum targowo-kongresowe oraz lider organizacji targów w Europie Środkowej.">
                            <meta itemprop="url" content="https://warsawexpo.eu">
                            <div>';
                            if(!empty(get_post_meta($post_id, 'organizer_phone', true))) {
                                $output .= '
                                <p>
                                    <a class="color-accent"  href="tel:'. get_post_meta($post_id, 'organizer_phone', true) .'">
                                        <span itemprop="telephone">'. get_post_meta($post_id, 'organizer_phone', true) .'</span>
                                    </a>
                                </p>';
                            }
                            if(!empty(get_post_meta($post_id, 'organizer_email', true))) {
                                $output .= '
                                <p>
                                    <a class="color-accent" href="mailto:'. get_post_meta($post_id, 'organizer_email', true) .'">
                                        <span  itemprop="email">'. get_post_meta($post_id, 'organizer_email', true) .'</span>
                                    </a>
                                </p>';
                            }
                            $output .= '
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <script>
        jQuery(function ($) {
            const slickSliders = $(".single-event__logotypes-slider");

            function initializeSlick(slider) {
                const totalSlides = $(slider).children().length;
                const currentSlidesToShow = getInitialSlidesToShow($(slider));

                // Check if the slider is already initialized, if so reset it
                if ($(slider).hasClass("slick-initialized")) {
                    $(slider).slick("unslick");
                }

                // Initialize Slick Slider for a given element
                $(slider).slick({
                    infinite: true,
                    slidesToShow: currentSlidesToShow,
                    slidesToScroll: 1,
                    arrows: false,
                    autoplay: true,
                    autoplaySpeed: 3000,
                    dots: false,
                    cssEase: "linear",
                    swipeToSlide: true,
                }).on("init reInit afterChange", function (event, slick, currentSlide) {
                    updateCaption(this);
                });

                // Set the first caption after initialization
                $(slider).on("init", function () {
                    updateCaption(this);
                });
            }

            function getInitialSlidesToShow(slider) {
                const elementWidth = $(slider).width();
                if ($(slider).hasClass("single-event__conferences-logotypes")) {
                    return 1;
                } else {
                    return elementWidth < 480 ? 2 :
                        elementWidth < 768 ? 3 :
                        elementWidth < 960 ? 4 : 5;
                }
            }

            function updateSlickSettings(slider) {
                initializeSlick(slider);
            }

            function updateCaption(slider) {
                const currentSlide = $(slider).find(".slick-current img");
                const captionText = currentSlide.attr("alt") || "";
                $(slider).closest(".single-event__tiles-right-bottom-right").find(".single-event__caption").text(captionText);
            }

            // Initialize each slider separately
            slickSliders.each(function () {
                const slider = this;
                updateSlickSettings(slider);

                // Size observer for each slider
                const resizeObserver = new ResizeObserver(() => {
                    updateSlickSettings(slider);
                });

                resizeObserver.observe(slider);
            });

            // Function to set equal height
            function setEqualHeight() {
                let maxHeight = 0;

                // Reset the heights before calculations
                $(".single-event__events-logo").css("height", "auto");

                // Calculate the maximum height
                $(".single-event__events-logo").each(function() {
                    const thisHeight = $(this).outerHeight();
                    if (thisHeight > maxHeight) {
                        maxHeight = thisHeight;
                    }
                });

                // Set the same height for all
                $(".single-event__events-logo").css("minHeight", maxHeight);
            }

            // Call the function after loading the slider
            $(".single-event__events-logotypes").on("init", function() {
                setEqualHeight();
            });

            // Call the function when changing the slide
            $(".single-event__events-logotypes").on("afterChange", function() {
                setEqualHeight();
            });

            // Call the function at the beginning
            setEqualHeight();

            function animateCount(element) {
                const targetValue = parseInt(element.getAttribute("data-count"), 10); 
                const duration = 3000; 

                const startTime = performance.now();
                const update = (currentTime) => {
                    const elapsedTime = currentTime - startTime;
                    const progress = Math.min(elapsedTime / duration, 1); 
                    const currentValue = Math.floor(progress * targetValue);

                    element.textContent = currentValue;

                    if (progress < 1) {
                        requestAnimationFrame(update);
                    }
                };
                requestAnimationFrame(update);
            }

            const countUpElements = document.querySelectorAll(".countup");

            const observer = new IntersectionObserver(
                (entries, observerInstance) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const target = entry.target;

                            if (target.classList.contains("countup")) {
                                animateCount(target);
                            } else if (!target.dataset.animated) {
                                animateBars(target);
                                target.dataset.animated = true;
                            }

                            observerInstance.unobserve(target);
                        }
                    });
                },
                {
                    threshold: 0.1
                }
            );

            countUpElements.forEach(element => observer.observe(element));

        });
    </script>';

endwhile;

echo do_shortcode($output);

get_footer();  // Pobierz stopkę strony
?>
