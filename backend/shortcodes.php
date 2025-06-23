<?php

function get_fair_data($specific_domain = null) {
    // Stores data so it doesn't need to be fetched every time
    static $cached_data = null;

    if ($cached_data === null) {
        // Get data from pwefunctions.php
        $pwe_fairs = PWECommonFunctions::get_database_fairs_data();

        static $console_logged = false;

        // Check if data is already in global variable
        if (!empty($pwe_fairs) && is_array($pwe_fairs)) {
            global $fairs_data;
            $fairs_data = ["fairs" => []];

            foreach ($pwe_fairs as $fair) {
                if (!isset($fair->fair_domain) || empty($fair->fair_domain)) {
                    continue;
                }
    
                $domain = $fair->fair_domain;
    
                $fairs_data["fairs"][$domain] = PWECommonFunctions::generate_fair_data($fair);
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

            global $fairs_data;
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
        'pwe_short_desc_pl' => 'short_desc_pl',
        'pwe_short_desc_en' => 'short_desc_en',
        'pwe_full_desc_pl' => 'full_desc_pl',
        'pwe_full_desc_en' => 'full_desc_en',
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
        'pwe_youtube' => 'youtube',
        'pwe_catalog' => 'catalog',
        'pwe_group' => 'group' 
    ];

    // Shortcode handling function
    function handle_fair_shortcode($atts, $field) {
        $atts = shortcode_atts(['domain' => null], $atts);
        $fair_data = get_fair_data($atts['domain']);
        return esc_html($fair_data[$field] ?? '');
    }

    // Registering shortcodes in the loop
    foreach ($shortcodes as $shortcode => $field) {
        add_shortcode($shortcode, function($atts) use ($field) {
            return handle_fair_shortcode($atts, $field);
        });
    }
}

add_action('init', 'register_dynamic_shortcodes');