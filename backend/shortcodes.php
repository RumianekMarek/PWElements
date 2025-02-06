<?php

function get_fair_data($specific_domain = null) {
    // URL to JSON file
    $json_file = 'https://mr.glasstec.pl/doc/pwe-data.json';

    // Getting data from JSON file
    $json_data = @file_get_contents($json_file); // Użycie @, aby zignorować ostrzeżenia PHP w razie błędów

    // Checking if data has been downloaded
    if ($json_data === false) {
        error_log('Nie udało się pobrać danych z pliku JSON: ' . $json_file);
        return null;
    }

    // Decoding JSON data
    $fairs_data = json_decode($json_data, true);

    // Checking JSON decoding correctness
    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Błąd podczas dekodowania JSON: ' . json_last_error_msg());
        return null;
    }

    // Specify the domain to search for
    $current_domain = $specific_domain ?? $_SERVER['HTTP_HOST'];

    // Searching for data for a given domain
    foreach ($fairs_data['fairs'] as $fair) {
        if ($fair['domain'] === $current_domain) {
            return $fair;
        }
    }

    return null;
}


function register_dynamic_shortcodes() {
    // Define shortcode function for each field
    function handle_fair_shortcode($atts, $field) {
        // Extract domain if provided
        $atts = shortcode_atts(['domain' => null], $atts);
        $fair_data = get_fair_data($atts['domain']);
        return esc_html($fair_data[$field] ?? 'Brak danych');
    }

    // Register each shortcode
    add_shortcode('pwe_name_pl', function($atts) {
        return handle_fair_shortcode($atts, 'name_pl');
    });

    add_shortcode('pwe_name_en', function($atts) {
        return handle_fair_shortcode($atts, 'name_en');
    });

    add_shortcode('pwe_date_start', function($atts) {
        return handle_fair_shortcode($atts, 'date_start');
    });

    add_shortcode('date_end', function($atts) {
        return handle_fair_shortcode($atts, 'date_end');
    });

    add_shortcode('pwe_edition', function($atts) {
        return handle_fair_shortcode($atts, 'edition');
    });

    add_shortcode('pwe_visitors', function($atts) {
        return handle_fair_shortcode($atts, 'visitors');
    });

    add_shortcode('pwe_exhibitors', function($atts) {
        return handle_fair_shortcode($atts, 'exhibitors');
    });

    add_shortcode('pwe_countries', function($atts) {
        return handle_fair_shortcode($atts, 'countries');
    });

    add_shortcode('pwe_area', function($atts) {
        return handle_fair_shortcode($atts, 'area');
    });

    add_shortcode('pwe_color_accent', function($atts) {
        return handle_fair_shortcode($atts, 'color_accent');
    });

    add_shortcode('pwe_color_main2', function($atts) {
        return handle_fair_shortcode($atts, 'color_main2');
    });

}

add_action('init', 'register_dynamic_shortcodes');
