<?php

function register_dynamic_shortcodes() {
    // Path to JSON file
    $json_file = get_template_directory() . 'data.json';
    
    // Check if file exists
    if (!file_exists($json_file)) {
        error_log('Plik JSON nie został znaleziony: ' . $json_file);
        return;
    }

    // Loading and decoding JSON
    $json_data = file_get_contents($json_file);
    $fairs_data = json_decode($json_data, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        error_log('Błąd podczas odczytu pliku JSON: ' . json_last_error_msg());
        return;
    }

    // Get current domain
    $current_domain = $_SERVER['HTTP_HOST'];

    // Finding data for the current domain
    $fair_data = null;
    foreach ($fairs_data['fairs'] as $fair) {
        if ($fair['domain'] === $current_domain) {
            $fair_data = $fair;
            break;
        }
    }

    // If data for domain not found, exit
    if (!$fair_data) {
        return;
    }

    error_log(print_r(get_fair_data(), true));

    // Creating shortcodes
    // Shortcode [pwe_visitors]
    add_shortcode('pwe_visitors', function() {
        $fair_data = get_fair_data();
        return esc_html($fair_data['visitors'] ?? 'Brak danych');
    });

    // Shortcode [pwe_exhibitors]
    add_shortcode('pwe_exhibitors', function() {
        $fair_data = get_fair_data();
        return esc_html($fair_data['exhibitors'] ?? 'Brak danych');
    });

    // Shortcode [pwe_area]
    add_shortcode('pwe_area', function() {
        $fair_data = get_fair_data();
        return esc_html($fair_data['area'] ?? 'Brak danych');
    });
}
add_action('init', 'register_dynamic_shortcodes');
