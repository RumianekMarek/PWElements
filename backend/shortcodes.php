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


// function get_fair_data($specific_domain = null) {
//     // Stores data so it doesn't need to be fetched every time
//     static $cached_data = null;

//     if ($cached_data === null) {
//         // Get data from global variable from pwelements.php
//         global $pwe_fairs;

//         static $console_logged = false;

//         // Check if data is already in global variable
//         if (empty($pwe_fairs)) {
//             if (!$console_logged) {
//                 echo '<script>console.log("Brak danych o targach w globalnej zmiennej (dane CAP)")</script>';
//                 $console_logged = true; // Ustawienie flagi, aby nie powtarzać logowania
//             }
//             return null;
//         }

//         $cached_data = [];

//         // Transform the data into an associative array for faster access
//         foreach ($pwe_fairs as $fair) {
//             if (!isset($fair->fair_domain) || empty($fair->fair_domain)) {
//                 continue;
//             }
//             $cached_data[$fair->fair_domain] = (array) $fair;
//         }
//     }

//     // Domain definition
//     $current_domain = $specific_domain ?? $_SERVER['HTTP_HOST'];

//     return $cached_data[$current_domain] ?? null;
// }


function register_dynamic_shortcodes() {
    // Define shortcode function for each field
    function handle_fair_shortcode($atts, $field) {
        // Extract domain if provided
        $atts = shortcode_atts(['domain' => null], $atts);
        $fair_data = get_fair_data($atts['domain']);
        return esc_html($fair_data[$field] ?? 'Brak danych');
    }

    // Register each shortcode
    // add_shortcode('pwe_name_pl', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_name_pl');
    // });

    // add_shortcode('pwe_name_en', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_name_en');
    // });

    // add_shortcode('pwe_desc_pl', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_desc_pl');
    // });

    // add_shortcode('pwe_desc_en', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_desc_en');
    // });

    // add_shortcode('pwe_date_start', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_date_start');
    // });

    // add_shortcode('pwe_date_end', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_date_end');
    // });

    // add_shortcode('pwe_edition', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_edition');
    // });

    // add_shortcode('pwe_visitors', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_visitors');
    // });

    // add_shortcode('pwe_exhibitors', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_exhibitors');
    // });

    // add_shortcode('pwe_countries', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_countries');
    // });

    // add_shortcode('pwe_area', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_area');
    // });

    // add_shortcode('pwe_hall', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_hall');
    // });

    // add_shortcode('pwe_color_accent', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_color_accent');
    // });

    // add_shortcode('pwe_color_main2', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_color_main2');
    // });

    // add_shortcode('pwe_catalog', function($atts) {
    //     return handle_fair_shortcode($atts, 'fair_kw');
    // });

    add_shortcode('pwe_name_pl', function($atts) {
        return handle_fair_shortcode($atts, 'name_pl');
    });

    add_shortcode('pwe_name_en', function($atts) {
        return handle_fair_shortcode($atts, 'name_en');
    });

    add_shortcode('pwe_desc_pl', function($atts) {
        return handle_fair_shortcode($atts, 'desc_pl');
    });

    add_shortcode('pwe_desc_en', function($atts) {
        return handle_fair_shortcode($atts, 'desc_en');
    });

    add_shortcode('pwe_date_start', function($atts) {
        return handle_fair_shortcode($atts, 'date_start');
    });

    add_shortcode('pwe_date_end', function($atts) {
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

    add_shortcode('pwe_hall', function($atts) {
        return handle_fair_shortcode($atts, 'hall');
    });

    add_shortcode('pwe_color_accent', function($atts) {
        return handle_fair_shortcode($atts, 'color_accent');
    });

    add_shortcode('pwe_color_main2', function($atts) {
        return handle_fair_shortcode($atts, 'color_main2');
    });

}

add_action('init', 'register_dynamic_shortcodes');

add_filter('gform_replace_merge_tags', 'GF_dynamic_pwe_shortcodes', 10, 7);

function GF_dynamic_pwe_shortcodes($text, $form, $entry, $url_encode, $esc_html, $nl2br, $format) {
    // Pattern for detecting merge tags with optional `domain` parameter
    $pattern = '/\{(pwe_[a-z_]+)(?:\s+domain="([^"]+)")?\}/';

    $text = preg_replace_callback($pattern, function($matches) {
        $shortcode = $matches[1]; // np. "pwe_name_pl"
        $domain = !empty($matches[2]) ? $matches[2] : null; // np. "domena.com"

        // Assembling a shortcode with an optional parameter
        $shortcode_str = $domain ? "[{$shortcode} domain=\"{$domain}\"]" : "[{$shortcode}]";

        return do_shortcode($shortcode_str);
    }, $text);

    return $text;
}


