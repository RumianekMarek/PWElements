<?php

function get_fair_data($specific_domain = null) {
    // Stores data so it doesn't need to be fetched every time
    static $cached_data = null;

    if ($cached_data === null) {
        // Get data from global variable from pwelements.php
        global $pwe_fairs;

        static $console_logged = false;

        // Check if data is already in global variable
        if (!empty($pwe_fairs) && is_array($pwe_fairs)) {
            $fairs_data = ["fairs" => []];

            foreach ($pwe_fairs as $fair) {
                if (!isset($fair->fair_domain) || empty($fair->fair_domain)) {
                    continue;
                }
    
                $domain = $fair->fair_domain;
    
                $fairs_data["fairs"][$domain] = [
                    "domain" => $domain,
                    "date_start" => $fair->fair_date_start ?? "",
                    "date_start_hour" => $fair->fair_date_start_hour ?? "",
                    "date_end" => $fair->fair_date_end ?? "",
                    "date_end_hour" => $fair->fair_date_end_hour ?? "",
                    "edition" => $fair->fair_edition ?? "",
                    "name_pl" => $fair->fair_name_pl ?? "",
                    "name_en" => $fair->fair_name_en ?? "",
                    "desc_pl" => $fair->fair_desc_pl ?? "",
                    "desc_en" => $fair->fair_desc_en ?? "",
                    "visitors" => $fair->fair_visitors ?? "",
                    "exhibitors" => $fair->fair_exhibitors ?? "",
                    "countries" => $fair->fair_countries ?? "",
                    "area" => $fair->fair_area ?? "",
                    "color_accent" => $fair->fair_color_accent ?? "",
                    "color_main2" => $fair->fair_color_main2 ?? "",
                    "hall" => $fair->fair_hall ?? "",
                    "facebook" => $fair->fair_facebook ?? "",
                    "instagram" => $fair->fair_instagram ?? "",
                    "linkedin" => $fair->fair_linkedin ?? "",
                    "youtube" => $fair->fair_youtube ?? "",
                    "badge" => $fair->badge ?? ""
                ];
            }
        } else {
            // URL to JSON file
            $json_file = 'https://mr.glasstec.pl/doc/pwe-data.json';
            
            // Getting data from JSON file
            $json_data = @file_get_contents($json_file); // Use @ to ignore PHP warnings on failure

            // Checking if data has been downloaded
            if ($json_data === false) {
                if (current_user_can("administrator") && !is_admin()) {
                    echo '<script>console.error("Failed to fetch data from JSON file: ' . $json_file . '")</script>';
                }
                return null;
            }

            // Decoding JSON data
            $fairs_data = json_decode($json_data, true);

            // Checking JSON decoding correctness
            if (json_last_error() !== JSON_ERROR_NONE) {
                if (current_user_can("administrator") && !is_admin()) {
                    echo '<script>console.error("Error decoding JSON: ' . json_last_error_msg() . '")</script>';
                }
                return null;
            }

            // Checking if the data has the correct structure
            if (!isset($fairs_data['fairs']) || !is_array($fairs_data['fairs'])) {
                if (current_user_can("administrator") && !is_admin()) {
                    echo '<script>console.error("Invalid fairs data format in JSON file.")</script>';
                }
                return null;
            }

            if (!$console_logged) {
                if (current_user_can("administrator") && !is_admin()) {
                    echo '<script>console.error("Brak danych o targach w globalnej zmiennej (dane CAP DB), dane są pobrane z pwe-data.json")</script>';
                }
                $console_logged = true;
            }
        }

        $cached_data = [];

        // Transform the data into an associative array for faster access
        foreach ($fairs_data['fairs'] as $fair) {
            if (!isset($fair['domain']) || empty($fair['domain'])) {
                continue;
            }
            $cached_data[$fair['domain']] = $fair;
        }
    }

    // Domain definition
    $current_domain = $specific_domain ?? ($_SERVER['HTTP_HOST'] ?? '');

    // Return data or null if domain does not exist in data
    return $current_domain && isset($cached_data[$current_domain]) ? $cached_data[$current_domain] : null;
}


function register_dynamic_shortcodes() {
    // List of shortcodes and their corresponding fields
    $shortcodes = [
        'pwe_name_pl' => 'name_pl',
        'pwe_name_en' => 'name_en',
        'pwe_desc_pl' => 'desc_pl',
        'pwe_desc_en' => 'desc_en',
        'pwe_date_start' => 'date_start',
        'pwe_date_start_hour' => 'date_start_hour',
        'pwe_date_end' => 'date_end',
        'pwe_date_end_hour' => 'date_end_hour',
        'pwe_edition' => 'edition',
        'pwe_visitors' => 'visitors',
        'pwe_exhibitors' => 'exhibitors',
        'pwe_countries' => 'countries',
        'pwe_area' => 'area',
        'pwe_hall' => 'hall',
        'pwe_color_accent' => 'color_accent',
        'pwe_color_main2' => 'color_main2',
        'pwe_badge' => 'badge',
        'pwe_facebook' => 'facebook',
        'pwe_instagram' => 'instagram',
        'pwe_linkedin' => 'linkedin',
        'pwe_youtube' => 'youtube'
    ];

    // Shortcode handling function
    function handle_fair_shortcode($atts, $field) {
        $atts = shortcode_atts(['domain' => null], $atts);
        $fair_data = get_fair_data($atts['domain']);
        return esc_html($fair_data[$field] ?? 'Brak danych');
    }

    // Registering shortcodes in the loop
    foreach ($shortcodes as $shortcode => $field) {
        add_shortcode($shortcode, function($atts) use ($field) {
            return handle_fair_shortcode($atts, $field);
        });
    }
}

add_action('init', 'register_dynamic_shortcodes');

// Shortcodes for Gravity forms
add_filter('gform_replace_merge_tags', 'GF_dynamic_pwe_shortcodes', 10, 7);
function GF_dynamic_pwe_shortcodes($text, $form, $entry, $url_encode, $esc_html, $nl2br, $format) {
    // Pattern for detecting merge tags with optional `domain` parameter
    $pattern = '/\{(pwe_[a-z_]+)(?:\s+domain="([^"]+)")?\}/';

    $text = preg_replace_callback($pattern, function($matches) {
        $shortcode = $matches[1]; // ex. "pwe_name_pl"
        $domain = !empty($matches[2]) ? $matches[2] : null; // ex. "domain.com"

        // Assembling a shortcode with an optional parameter
        $shortcode_str = $domain ? "[{$shortcode} domain=\"{$domain}\"]" : "[{$shortcode}]";

        return do_shortcode($shortcode_str);
    }, $text);

    return $text;
}


