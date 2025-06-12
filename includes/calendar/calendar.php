<?php

// Template single post 
function pwe_calendar_single_template($single_template) { 
    global $post;

    // If the post type is 'event', use the template 'single-calendar.php'
    if ($post->post_type == 'event') {
        $single_template = plugin_dir_path(__FILE__) . 'classes/single-calendar.php';
    }

    return $single_template;
}
add_filter('single_template', 'pwe_calendar_single_template');

// Add custom meta description to <head>
function custom_meta_description() {
    global $post;
    
    $meta_description = '';

    if ($post->post_type == 'event') {
        $website = get_post_meta($post->ID, 'web_page_link', true);
        if (!empty($website)) {
            $host = parse_url($website, PHP_URL_HOST);
            $domain = preg_replace('/^www\./', '', $host);
        }

        $shortcodes_active = empty(get_option('pwe_general_options', [])['pwe_dp_shortcodes_unactive']);

        if (!function_exists('get_translated_field')) {
            function get_translated_field($fair, $field_base_name) {
                // Get the language in the format e.g. "de", "pl"
                $locale = get_locale(); // ex. "de_DE"
                $lang = strtolower(substr($locale, 0, 2)); // "de"

                // Check if a specific translation exists (e.g. fair_name_{lang})
                $field_with_lang = "{$field_base_name}_{$lang}";

                if (!empty($fair[$field_with_lang])) {
                    return $fair[$field_with_lang];
                }

                // Fallback to English
                $fallback = "{$field_base_name}_en";
                return $fair[$fallback] ?? '';
            }
        }

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

        $translates = PWECommonFunctions::get_database_translations_data($domain);

        $shortcode_full_desc_pl = get_pwe_shortcode("pwe_full_desc_pl", $domain);
        $shortcode_full_desc_pl_available = check_available_pwe_shortcode($shortcodes_active, $shortcode_full_desc_pl);
        $fair_full_desc = $shortcode_full_desc_pl_available ? get_translated_field($translates[0], 'fair_full_desc') : '';

        if (!empty($fair_full_desc)) {
            $meta_description = strstr($fair_full_desc, '<br>', true);
            
            // If strstr returned false (i.e. no <br>), we assign the entire content
            if ($meta_description === false) {
                $meta_description = $fair_full_desc;
            }
        }
    } 
    
    // Add meta description to the <head> section
    echo '<meta name="description" content="' . esc_attr(strip_tags($meta_description)) . '">';
}
add_action('wp_head', 'custom_meta_description');

// Create new post type
function create_event_post_type() {
    $args = array(
        'labels' => array(
            'name' => 'Events',
            'singular_name' => 'Event',
            'add_new' => 'Add new event',
            'add_new_item' => 'Add new event',
            'edit_item' => 'Edit event',
            'new_item' => 'New event',
            'view_item' => 'See the event',
            'all_items' => 'All events',
            'search_items' => 'Search event',
            'not_found' => 'No events',
            'not_found_in_trash' => 'No events in the basket',
            'menu_name' => 'PWE Events'
        ),
        'public' => true,
        'has_archive' => false,
        'rewrite' => array('slug' => 'kalendarz-targowy'),
        'supports' => array('title', 'custom-fields'),
        'show_in_rest' => true,  // Gutenberg Support
        'menu_icon' => 'dashicons-calendar',
        'menu_position' => 3,
    );
    
    register_post_type('event', $args);

    // Registering a taxonomy (category) for a custom post type
    $taxonomy_args = array(
        'labels' => array(
            'name' => 'Event Categories',
            'singular_name' => 'Event Category',
            'search_items' => 'Search Categories',
            'all_items' => 'All Categories',
            'parent_item' => 'Parent Category',
            'parent_item_colon' => 'Parent Category:',
            'edit_item' => 'Edit Category',
            'update_item' => 'Update Category',
            'add_new_item' => 'Add New Category',
            'new_item_name' => 'New Category Name',
            'menu_name' => 'Categories',
        ),
        'hierarchical' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'event-category'),
    );
    
    register_taxonomy('event_category', 'event', $taxonomy_args);
}
add_action('init', 'create_event_post_type');

// Create meta boxes
function add_event_meta_boxes() {
    // Metabox for links fields
    add_meta_box(
        'event_links', 
        'Event links', 
        'event_links_callback', 
        'event', // Typ postu
        'normal', // Pozycja
        'high' // Priorytet
    );
    // Metabox for desc fields
    add_meta_box(
        'event_desc',
        'Event description',
        'event_desc_callback',
        'event',
        'normal',
        'high'
    );
    // Metabox for dates fields
    add_meta_box(
        'event_dates',
        'Event dates',
        'event_dates_callback',
        'event',
        'normal',
        'high'
    );
    // Metabox for colors fields
    add_meta_box(
        'event_colors',
        'Event colors',
        'event_colors_callback',
        'event',
        'normal',
        'high'
    );

    // Metabox fo statistics fields
    add_meta_box(
        'event_statistics',
        'Statistics',
        'event_statistics_callback',
        'event',
        'normal',
        'high'
    );
    // Metabox for the organizer fields
    add_meta_box(
        'event_organizer',
        'Organizer information',
        'event_organizer_callback',
        'event',
        'normal',
        'high'
    );
    // Metabox for other fields
    add_meta_box(
        'event_other',
        'Other information',
        'event_other_callback',
        'event',
        'normal',
        'high'
    );
    // Featured Image
    add_meta_box(
        'featured_image_url',
        'Featured Image',
        'featured_image_meta_box_callback',
        'event',
        'side',
        'high'
    );

    // Secondary image
    add_meta_box(
        'secondary_image_url',
        'Secondary Image',
        'secondary_image_meta_box_callback',
        'event', 
        'side',
        'high'
    );
    // Metabox for header image
    add_meta_box(
        'header_image',
        'Header Image',
        'header_image_callback',
        'event',
        'side',
        'low'
    );
    // Metabox for logo image
    add_meta_box(
        'logo_image',
        'Logo Image',
        'logo_image_callback',
        'event',
        'side',
        'low'
    );
    // Metabox for gallery of partners
    add_meta_box(
        'partners_gallery',
        'Partners Gallery',
        'partners_gallery_callback', 
        'event',
        'side',
        'low'
    );
}
add_action('add_meta_boxes', 'add_event_meta_boxes');

// Hide secondary thumbnail meta box
function hide_secondary_thumbnail_meta_box() {
    echo '<style>.post-type-event #uncode-secondary-featured-image { display: none; }</style>';
}
add_action('admin_head', 'hide_secondary_thumbnail_meta_box');

// Functions for displaying fields in metaboxes
function event_links_callback($post) {
    wp_nonce_field('save_event_links', 'event_links_nonce');
    $lang = ICL_LANGUAGE_CODE;
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if (!empty($website)) {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);
        $web_page_link = 'https://'. $domain .'/';
    }
    $categories = get_the_terms($post->ID, 'event_category');

    if ($categories && !is_wp_error($categories)) {
        $category_names = wp_list_pluck($categories, 'name');
        $category_string = implode(', ', $category_names);
    }

    $exhibitor_registration_link = !empty($website) ? $web_page_link . ($lang === "pl" ? 'zostan-wystawca/' : 'en/become-an-exhibitor/') : '';
    if (strpos(strtolower($category_string), 'b2c') !== false) {
        $buy_ticket_link = !empty($website) ? $web_page_link . ($lang === "pl" ? 'kup-bilet/' : 'en/buy-ticket/') : '';
    } else {
        $visitor_registration_link = !empty($website) ? $web_page_link . ($lang === "pl" ? 'rejestracja/' : 'en/registration/') : '';
    }
    
    $visitor_registration_link = !empty(get_post_meta($post->ID, 'visitor_registration_link', true)) ? get_post_meta($post->ID, 'visitor_registration_link', true) : $visitor_registration_link;
    $exhibitor_registration_link = !empty(get_post_meta($post->ID, 'exhibitor_registration_link', true)) ? get_post_meta($post->ID, 'exhibitor_registration_link', true) : $exhibitor_registration_link;
    $buy_ticket_link = !empty(get_post_meta($post->ID, 'buy_ticket_link', true)) ? get_post_meta($post->ID, 'buy_ticket_link', true) : $buy_ticket_link;

    echo '
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input">
            <label for="web_page_link">Web Page Link: <span style="font-weight: 700;">(ENTER TO GET DATA FROM CAP)</span></label>
            <input type="text" id="web_page_link" name="web_page_link" class="pwe-calendar-full-width-input" placeholder="'. 'https://domain/' . ($lang === "pl" ? '' : 'en/') .'" value="'. $website .'" />
        </div>
    </div>

    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input one-third-width">
            <label for="visitor_registration_link">Visitor Registration Link: </label>
            <input type="text" id="visitor_registration_link" name="visitor_registration_link" class="pwe-calendar-full-width-input" placeholder="'. 'https://domain/' . ($lang === "pl" ? 'rejestracja/' : 'en/registration/') .'" value="'. $visitor_registration_link .'" />
        </div>
        <div class="pwe-calendar-input one-third-width">
            <label for="exhibitor_registration_link">Exhibitor Registration Link: </label>
            <input type="text" id="exhibitor_registration_link" name="exhibitor_registration_link" class="pwe-calendar-full-width-input" placeholder="'. 'https://domain/' . ($lang === "pl" ? 'zostan-wystawca/' : 'en/become-an-exhibitor/') .'" value="'. $exhibitor_registration_link .'" />
        </div>
        <div class="pwe-calendar-input one-third-width">
            <label for="buy_ticket_link">Buy Ticket Link: </label>
            <input type="text" id="buy_ticket_link" name="buy_ticket_link" class="pwe-calendar-full-width-input" placeholder="'. 'https://domain/' . ($lang === "pl" ? 'kup-bilet/' : 'en/buy-ticket/') .'" value="'. $buy_ticket_link .'" />
        </div>
    </div>';
}
 
function event_desc_callback($post) {
    wp_nonce_field('save_event_desc', 'event_desc_nonce');
    $lang = ICL_LANGUAGE_CODE;
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if (!empty($website)) {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);
    
        $event_desc = !empty(get_post_meta($post->ID, 'desc', true)) ? get_post_meta($post->ID, 'desc', true) : do_shortcode('[pwe_desc_'. ($lang === "pl" ? 'pl' : 'en') .' domain="' . $domain . '"]');
        $event_short_desc = !empty(get_post_meta($post->ID, 'short_desc', true)) ? get_post_meta($post->ID, 'short_desc', true) : do_shortcode('[pwe_short_desc_'. ($lang === "pl" ? 'pl' : 'en') .' domain="' . $domain . '"]');
    }
    echo '
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input">
            <label for="desc">Event desc</label>
            <input type="text" id="desc" name="desc" class="pwe-calendar-full-width-input" value="'. $event_desc .'" />
        </div>
    </div>
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input">
            <label for="short_desc">Short event desc </label>
            <input type="text" id="short_desc" name="short_desc" class="pwe-calendar-full-width-input" value="'. $event_short_desc .'" />
        </div>
    </div>';
}

function event_dates_callback($post) {
    wp_nonce_field('save_event_dates', 'event_dates_nonce');
    $shortcodes_active = empty(get_option('pwe_general_options', [])['pwe_dp_shortcodes_unactive']);
    $lang = ICL_LANGUAGE_CODE;
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if (!empty($website)) {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);

        $pwe_db_date_start = do_shortcode('[pwe_date_start domain="' . $domain . '"]');
        $pwe_db_date_end = do_shortcode('[pwe_date_end domain="' . $domain . '"]');
        $pwe_db_date_start_available = $shortcodes_active && !empty($pwe_db_date_start) && $pwe_db_date_start !== "";
        $pwe_db_date_end_available = $shortcodes_active && !empty($pwe_db_date_end) && $pwe_db_date_end !== "";

        $fair_date_start_cap = $pwe_db_date_start_available ? date("d-m-Y", strtotime(str_replace("/", "-", $pwe_db_date_start))) : "";
        $fair_date_end_cap = $pwe_db_date_end_available ? date("d-m-Y", strtotime(str_replace("/", "-", $pwe_db_date_end))) : "";

        $quarterly_date = ((empty($fair_date_start_cap) || empty($fair_date_end_cap)) && empty(get_post_meta($post->ID, 'quarterly_date', true))) ? ($lang === "pl" ? 'Nowa data wkrótce' : 'New date comming soon') : get_post_meta($post->ID, 'quarterly_date', true);
    }
    echo '
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input one-third-width">
            <label for="fair_date_start">Fair Date Start: </label>
            <input type="text" id="fair_date_start" name="fair_date_start" class="pwe-calendar-full-width-input" placeholder="'. (!empty($fair_date_start_cap) ? $fair_date_start_cap : 'empty') .' - (Date from CAP DB)" value="'. get_post_meta($post->ID, 'fair_date_start', true) .'" />
        </div>
        <div class="pwe-calendar-input one-third-width">
            <label for="fair_date_end">Fair Date End: </label>
            <input type="text" id="fair_date_end" name="fair_date_end" class="pwe-calendar-full-width-input" placeholder="'. (!empty($fair_date_end_cap) ? $fair_date_end_cap : 'empty') .' - (Date from CAP DB)" value="'. get_post_meta($post->ID, 'fair_date_end', true) .'" />
        </div>
        <div class="pwe-calendar-input one-third-width">
            <label for="quarterly_date">Quarterly Date: </label>
            <input type="text" id="quarterly_date" name="quarterly_date" class="pwe-calendar-full-width-input" placeholder="'. $quarterly_date .'" value="'. get_post_meta($post->ID, 'quarterly_date', true) .'" />
        </div>
    </div>';
}

function event_colors_callback($post) {
    wp_nonce_field('save_event_colors', 'event_colors_nonce');
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if (!empty($website)) {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);

        $main_color = !empty(get_post_meta($post->ID, 'main_color', true)) ? get_post_meta($post->ID, 'main_color', true) : do_shortcode('[pwe_color_accent domain="' . $domain . '"]');
        $main2_color = !empty(get_post_meta($post->ID, 'main2_color', true)) ? get_post_meta($post->ID, 'main2_color', true) : do_shortcode('[pwe_color_main2 domain="' . $domain . '"]');
    }
    echo '
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input half-width">
            <label for="main_color">Main Color: </label>
            <input type="text" id="main_color" name="main_color" class="pwe-calendar-full-width-input color-picker" value="'. $main_color .'" />
        </div>
        <div class="pwe-calendar-input half-width">
            <label for="main2_color">Main2 Color: </label>
            <input type="text" id="main2_color" name="main2_color" class="pwe-calendar-full-width-input color-picker" value="'. $main2_color .'" />
        </div>
    </div>';
}

function event_statistics_callback($post) {
    wp_nonce_field('save_event_statistics', 'event_statistics_nonce');
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if (!empty($website)) {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);

        $visitors = !empty(get_post_meta($post->ID, 'visitors', true)) ? get_post_meta($post->ID, 'visitors', true) : do_shortcode('[pwe_visitors domain="' . $domain . '"]');
        $exhibitors = !empty(get_post_meta($post->ID, 'visitors', true)) ? get_post_meta($post->ID, 'exhibitors', true) : do_shortcode('[pwe_exhibitors domain="' . $domain . '"]');
        $countries = !empty(get_post_meta($post->ID, 'countries', true)) ? get_post_meta($post->ID, 'countries', true) : do_shortcode('[pwe_countries domain="' . $domain . '"]');
        $area = !empty(get_post_meta($post->ID, 'area', true)) ? get_post_meta($post->ID, 'area', true) : do_shortcode('[pwe_area domain="' . $domain . '"]');
    }
    echo '
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input half-width">
            <label for="visitors">Number of visitors: </label>
            <input type="text" id="visitors" name="visitors" class="pwe-calendar-full-width-input"  value="'. $visitors .'" />
        </div>
        <div class="pwe-calendar-input half-width">
            <label for="exhibitors">Number of exhibitors: </label>
            <input type="text" id="exhibitors" name="exhibitors" class="pwe-calendar-full-width-input"  value="'. $exhibitors .'" />
        </div>
    </div>
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input half-width">
            <label for="countries">Participating countries: </label>
            <input type="text" id="countries" name="countries" class="pwe-calendar-full-width-input"  value="'. $countries .'" />
        </div>
        <div class="pwe-calendar-input half-width">
            <label for="area">Exhibition area: </label>
            <input type="text" id="area" name="area" class="pwe-calendar-full-width-input"  value="'. $area .'" />
        </div>
    </div>';
}

function event_organizer_callback($post) {
    wp_nonce_field('save_event_organizer', 'event_organizer_nonce');

    $organizer_website = !empty(get_post_meta($post->ID, 'organizer_website', true)) ? get_post_meta($post->ID, 'organizer_website', true) : "https://warsawexpo.eu/";
    $organizer_email = !empty(get_post_meta($post->ID, 'organizer_email', true)) ? get_post_meta($post->ID, 'organizer_email', true) : "info@warsawexpo.eu";
    $organizer_phone = !empty(get_post_meta($post->ID, 'organizer_phone', true)) ? get_post_meta($post->ID, 'organizer_phone', true) : "+48 518 739 124";
    $organizer_name = !empty(get_post_meta($post->ID, 'organizer_name', true)) ? get_post_meta($post->ID, 'organizer_name', true) : "Ptak Warsaw Expo";

    echo '
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input half-width">
            <label for="organizer_website">Organizer`s Website: </label>
            <input type="text" id="organizer_website" name="organizer_website" class="pwe-calendar-full-width-input" value="'. $organizer_website .'" />
        </div>
        <div class="pwe-calendar-input half-width">
            <label for="organizer_email">Organizer`s Email: </label>
            <input type="email" id="organizer_email" name="organizer_email" class="pwe-calendar-full-width-input" value="'. $organizer_email .'" />
        </div>
    </div>
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input half-width">
            <label for="organizer_phone">Organizer`s Phone Number: </label>
            <input type="text" id="organizer_phone" name="organizer_phone" class="pwe-calendar-full-width-input" value="'. $organizer_phone .'" />
        </div>
        <div class="pwe-calendar-input half-width">
            <label for="organizer_name">Organizer`s Name: </label>
            <input type="text" id="organizer_name" name="organizer_name" class="pwe-calendar-full-width-input" value="'. $organizer_name .'" />
        </div>
    </div>';
}

function event_other_callback($post) {
    wp_nonce_field('save_event_other', 'event_other_nonce');
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if (!empty($website)) {
        $host = parse_url($website, PHP_URL_HOST);
        $domain = preg_replace('/^www\./', '', $host);

        $edition = !empty(get_post_meta($post->ID, 'edition', true)) ? get_post_meta($post->ID, 'edition', true) : do_shortcode('[pwe_edition domain="' . $domain . '"]');
        $badge = !empty(get_post_meta($post->ID, 'badge', true)) ? get_post_meta($post->ID, 'badge', true) : do_shortcode('[pwe_badge domain="' . $domain . '"]');
    }
    echo '
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input half-width">
            <label for="edition">Edition: </label>
            <input type="text" id="edition" name="edition" class="pwe-calendar-full-width-input" value="'. $edition .'" />
        </div>
        <div class="pwe-calendar-input half-width">
            <label for="badge">Badge prefix: </label>
            <input type="text" id="badge" name="badge" class="pwe-calendar-full-width-input" value="'. $badge .'" />
        </div>
    </div>
    <div class="pwe-calendar-inputs-container">
        <div class="pwe-calendar-input">
            <label for="keywords">Words for search engine </label>
            <input type="text" id="keywords" name="keywords" class="pwe-calendar-full-width-input" value="'. get_post_meta($post->ID, 'keywords', true) .'" />
        </div>
    </div>';
}

function header_image_callback($post) {
    wp_nonce_field('save_header_image', 'header_image_nonce');
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if ($website) {
        $header_image_url = !empty(get_post_meta($post->ID, '_header_image', true)) ? get_post_meta($post->ID, '_header_image', true) : '';
    }
    echo '
    <div class="pwe-calendar-input">
        <label for="header_image">Upload Header Image:</label>
        <div class="header-image-url-container">
            <input type="text" id="header_image" name="header_image" value="' . esc_attr($header_image_url) . '" style="width:100%;" />
        </div>
        <input type="button" class="button-secondary" value="Select Image" id="header_image_button" />
        <div id="header_image_preview" style="margin-top: 10px;">';
            if (!empty($header_image_url)) {
                echo '<img src="' . esc_url($header_image_url) . '" style="max-width: 250px; width: 100%;" />';
            }
        echo '
        </div>
    </div>';

    ?>
    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;

            $('#header_image_button').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Initializing the uploader
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Header Image',
                    button: {
                        text: 'Select Image'
                    },
                    multiple: false
                });

                // After selecting the image, insert the URL into the field
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();

                    $('.header-image-url-container').html('<input type="text" id="header_image" name="header_image" value="' + attachment.url + '" style="width:100%;" />');
                    $('#header_image_preview').html('<img src="' + attachment.url + '" style="max-width: 250px; width: 100%;" />');
                });

                mediaUploader.open();
            });
        });
    </script>
    <?php 
}

function logo_image_callback($post) {
    wp_nonce_field('save_logo_image', 'logo_image_nonce');
    $website = get_post_meta($post->ID, 'web_page_link', true);
    if ($website) {
        $logo_image_url = !empty(get_post_meta($post->ID, '_logo_image', true)) ? get_post_meta($post->ID, '_logo_image', true) : '';
    }
    echo '
    <div class="pwe-calendar-input">
        <label for="logo_image">Upload Logo Image:</label>
        <div class="logo-image-url-container">
            <input type="text" id="logo_image" name="logo_image" value="' . esc_attr($logo_image_url) . '" style="width:100%;" />
        </div>
        <input type="button" class="button-secondary" value="Select Image" id="logo_image_button" />
        <div id="logo_image_preview" style="margin-top: 10px; background: #c6c6c6;">';
            if (!empty($logo_image_url)) {
                echo '<img src="' . esc_url($logo_image_url) . '" style="max-width: 250px; width: 100%;" />';
            }
        echo '
        </div>
    </div>';

    ?>
    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;

            $('#logo_image_button').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Initialization uploader
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Logo Image',
                    button: {
                        text: 'Select Image'
                    },
                    multiple: false
                });

                // After selecting the image, insert the URL into the field
                mediaUploader.on('select', function() {
                    var attachment = mediaUploader.state().get('selection').first().toJSON();

                    $('.logo-image-url-container').html('<input type="text" id="logo_image" name="logo_image" value="' + attachment.url + '" style="width:100%;" />');
                    $('#logo_image_preview').html('<img src="' + attachment.url + '" style="max-width: 250px; width: 100%;" />');
                });

                // Otwórz uploader
                mediaUploader.open();
            });
        });
    </script>
    <?php
}

function partners_gallery_callback($post) {
    wp_nonce_field('save_partners_gallery', 'partners_gallery_nonce');

    $partners_images = get_post_meta($post->ID, '_partners_gallery', true);

    if (!$partners_images) {
        $partners_images = array();
    }

    echo '
    <div class="pwe-calendar-input">
        <label for="partners_gallery">Select Partner Images:</label>
        <input type="hidden" id="partners_gallery" name="partners_gallery" value="' . esc_attr(implode(',', $partners_images)) . '" />
        <input type="button" class="button-secondary" value="Select Images" id="partners_gallery_button" />
    </div>';

    echo '<div id="partners_gallery_images">';
    if (!empty($partners_images)) {
        foreach ($partners_images as $image_url) {
            echo '<div class="partner-image" data-url="' . esc_attr($image_url) . '">';
            echo '<img src="' . esc_url($image_url) . '" style="width: 50px; margin-right: 10px;"/>';
            echo '<button class="remove-image-button">Remove</button>';
            echo '</div>';
        }
    }
    echo '</div>';

    ?>
    <script>
        jQuery(document).ready(function($) {
            var mediaUploader;

            $('#partners_gallery_button').click(function(e) {
                e.preventDefault();

                if (mediaUploader) {
                    mediaUploader.open();
                    return;
                }

                // Initialization uploader
                mediaUploader = wp.media.frames.file_frame = wp.media({
                    title: 'Select Partner Images',
                    button: {
                        text: 'Select Images'
                    },
                    multiple: true,
                    library: {
                        type: 'image'
                    }
                });

                // Pre-select already selected images in media uploader
                mediaUploader.on('open', function() {
                    var selection = mediaUploader.state().get('selection');
                    // Convert PHP to JSON to pass data to JS
                    var selected = <?php echo json_encode($partners_images); ?>;
                    
                    selected.forEach(function(url) {
                        var attachment = wp.media.attachment(url);
                        attachment.fetch();
                        selection.add(attachment);
                    });
                });

                // After selecting the image, insert the URL into the field
                mediaUploader.on('select', function() {
                    var selection = mediaUploader.state().get('selection');
                    var imageUrls = [];

                    // Adding image URL
                    selection.each(function(attachment) {
                        imageUrls.push(attachment.attributes.url); 
                    });

                    // Inserting the images URL into the hidden field and showing the thumbnail
                    $('#partners_gallery').val(imageUrls.join(','));
                    updateImagesPreview(imageUrls);
                });

                mediaUploader.open();
            });

            // Function to update thumbnail image preview
            function updateImagesPreview(imageUrls) {
                var previewDiv = $('#partners_gallery_images');
                previewDiv.empty(); // Clear current thumbnails

                // Adding thumbnail images
                imageUrls.forEach(function(url) {
                    previewDiv.append('<div class="partner-image" data-url="' + url + '"><img src="' + url + '" style="width: 50px; margin-right: 10px;"/><button class="remove-image-button">Remove</button></div>');
                });
            }

            // Deleting selected image
            $('#partners_gallery_images').on('click', '.remove-image-button', function() {
                var imageUrl = $(this).closest('.partner-image').data('url');
                var currentImages = $('#partners_gallery').val().split(',');

                // Removing an image from the list
                currentImages = currentImages.filter(function(item) {
                    return item !== imageUrl;
                });

                // Update the hidden field
                $('#partners_gallery').val(currentImages.join(','));

                // Remove the thumbnail of the image
                $(this).closest('.partner-image').remove();
            });
        });
    </script>
    <?php
}

function featured_image_meta_box_callback($post) {
    wp_nonce_field('save_featured_image', 'featured_image_nonce');
    $featured_image_url = get_post_meta($post->ID, '_featured_image_url', true);
    
    echo '
    <label for="featured_image_url">Featured Image URL:</label>
    <div class="featured-image-url-container">
        <input type="text" id="featured_image_url" name="featured_image_url" class="featured-image-url pwe-calendar-full-width-input" value="' . esc_attr($featured_image_url) . '" />
    </div>
    <br>
    <input type="button" class="button-secondary" value="Select Image" id="featured_image_button" />
    <div id="featured_image_preview" style="margin-top: 10px;">';
        if (!empty($featured_image_url)) {
            echo '<img src="' . esc_url($featured_image_url) . '" style="max-width: 250px; width: 100%;" />';
        }
    echo '
    </div>';
    
    ?>
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#featured_image_button').click(function(e) {
            e.preventDefault();

            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Initialization uploader
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Select Featured Image',
                button: {
                    text: 'Select Image'
                },
                multiple: false
            });
            
            // After selecting the image, insert the URL into the field
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();

                $('.featured-image-url-container').html('<input type="text" id="featured_image_url" name="featured_image_url" class="featured-image-url pwe-calendar-full-width-input" value="' + attachment.url + '" />');
                $('#featured_image_preview').html('<img src="' + attachment.url + '" style="max-width: 250px; width: 100%;" />');
            });

            mediaUploader.open();
        });
    });
    </script>
    <?php
}

function secondary_image_meta_box_callback($post) {
    wp_nonce_field('save_secondary_image', 'secondary_image_nonce');
    $secondary_image_url = get_post_meta($post->ID, '_secondary_image_url', true);
    
    echo '
    <label for="secondary_image_url">Secondary Image URL:</label>
    <div class="secondary-image-url-container">
        <input type="text" id="secondary_image_url" name="secondary_image_url" class="secondary-image-url pwe-calendar-full-width-input" value="' . esc_attr($secondary_image_url) . '" />
    </div>
    <br>
    <input type="button" class="button-secondary" value="Select Image" id="secondary_image_button" />
    <div id="secondary_image_preview" style="margin-top: 10px;">';
        if (!empty($secondary_image_url)) {
            echo '<img src="' . esc_url($secondary_image_url) . '" style="max-width: 250px; width: 100%;" />';
        }
    echo '
    </div>';
    
    ?>
    <script>
    jQuery(document).ready(function($) {
        var mediaUploader;
        
        $('#secondary_image_button').click(function(e) {
            e.preventDefault();
            
            // Jeśli uploader istnieje, otwieramy go
            if (mediaUploader) {
                mediaUploader.open();
                return;
            }

            // Initialization uploader
            mediaUploader = wp.media.frames.file_frame = wp.media({
                title: 'Select Secondary Image',
                button: {
                    text: 'Select Image'
                },
                multiple: false
            });

            // After selecting the image, insert the URL into the field
            mediaUploader.on('select', function() {
                var attachment = mediaUploader.state().get('selection').first().toJSON();
                $('.secondary-image-url-container').html('<input type="text" id="secondary_image_url" name="secondary_image_url" class="secondary-image-url pwe-calendar-full-width-input" value="' + attachment.url + '" />');
                $('#secondary_image_preview').html('<img src="' + attachment.url + '" style="max-width: 250px; width: 100%;" />'); // Wyświetlamy podgląd
            });

            mediaUploader.open();
        });
    });
    </script>
    <?php
}

// Function of saving data from metaboxes
function save_event_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return $post_id;

    if (isset($_POST['event_desc_nonce']) && wp_verify_nonce($_POST['event_desc_nonce'], 'save_event_desc')) {
        update_post_meta($post_id, 'desc', sanitize_text_field($_POST['desc']));
        update_post_meta($post_id, 'short_desc', sanitize_text_field($_POST['short_desc']));
    }

    if (isset($_POST['event_links_nonce']) && wp_verify_nonce($_POST['event_links_nonce'], 'save_event_links')) {
        update_post_meta($post_id, 'web_page_link', sanitize_text_field($_POST['web_page_link']));
        update_post_meta($post_id, 'visitor_registration_link', sanitize_text_field($_POST['visitor_registration_link']));
        update_post_meta($post_id, 'exhibitor_registration_link', sanitize_text_field($_POST['exhibitor_registration_link']));
        update_post_meta($post_id, 'buy_ticket_link', sanitize_text_field($_POST['buy_ticket_link']));
    }

    if (isset($_POST['event_dates_nonce']) && wp_verify_nonce($_POST['event_dates_nonce'], 'save_event_dates')) {
        update_post_meta($post_id, 'fair_date_start', sanitize_text_field($_POST['fair_date_start']));
        update_post_meta($post_id, 'fair_date_end', sanitize_text_field($_POST['fair_date_end']));
        update_post_meta($post_id, 'quarterly_date', sanitize_text_field($_POST['quarterly_date']));
    }

    if (isset($_POST['event_colors_nonce']) && wp_verify_nonce($_POST['event_colors_nonce'], 'save_event_colors')) {
        update_post_meta($post_id, 'main_color', sanitize_text_field($_POST['main_color']));
        update_post_meta($post_id, 'main2_color', sanitize_text_field($_POST['main2_color']));
    } 

    if (isset($_POST['event_statistics_nonce']) && wp_verify_nonce($_POST['event_statistics_nonce'], 'save_event_statistics')) {
        update_post_meta($post_id, 'visitors', sanitize_text_field($_POST['visitors']));
        update_post_meta($post_id, 'exhibitors', sanitize_text_field($_POST['exhibitors']));
        update_post_meta($post_id, 'countries', sanitize_text_field($_POST['countries']));
        update_post_meta($post_id, 'area', sanitize_text_field($_POST['area']));
    }

    if (isset($_POST['event_organizer_nonce']) && wp_verify_nonce($_POST['event_organizer_nonce'], 'save_event_organizer')) {
        update_post_meta($post_id, 'organizer_website', sanitize_text_field($_POST['organizer_website']));
        update_post_meta($post_id, 'organizer_email', sanitize_email($_POST['organizer_email']));
        update_post_meta($post_id, 'organizer_phone', sanitize_text_field($_POST['organizer_phone']));
        update_post_meta($post_id, 'organizer_name', sanitize_text_field($_POST['organizer_name']));
    }

    if (isset($_POST['event_other_nonce']) && wp_verify_nonce($_POST['event_other_nonce'], 'save_event_other')) {
        update_post_meta($post_id, 'edition', sanitize_text_field($_POST['edition']));
        update_post_meta($post_id, 'badge', sanitize_text_field($_POST['badge']));
        update_post_meta($post_id, 'keywords', sanitize_text_field($_POST['keywords']));
    }

    if (isset($_POST['header_image_nonce']) && wp_verify_nonce($_POST['header_image_nonce'], 'save_header_image')) {
        if (isset($_POST['header_image'])) {
            update_post_meta($post_id, '_header_image', sanitize_text_field($_POST['header_image']));
        }
    }

    if (isset($_POST['logo_image_nonce']) && wp_verify_nonce($_POST['logo_image_nonce'], 'save_logo_image')) {
        if (isset($_POST['logo_image'])) {
            update_post_meta($post_id, '_logo_image', sanitize_text_field($_POST['logo_image']));
        }
    }

    if (isset($_POST['partners_gallery_nonce']) && wp_verify_nonce($_POST['partners_gallery_nonce'], 'save_partners_gallery')) {
        if (isset($_POST['partners_gallery'])) {
            // Separating image URLs written in a string (separated by commas) and saving as an array
            $image_urls = explode(',', sanitize_text_field($_POST['partners_gallery']));
            update_post_meta($post_id, '_partners_gallery', $image_urls);
        }
    }

    if (isset($_POST['featured_image_nonce']) && wp_verify_nonce($_POST['featured_image_nonce'], 'save_featured_image')) {
        if (isset($_POST['featured_image_url'])) {
            update_post_meta($post_id, '_featured_image_url', sanitize_text_field($_POST['featured_image_url']));
        }
    }
    
    if (isset($_POST['secondary_image_nonce']) && wp_verify_nonce($_POST['secondary_image_nonce'], 'save_secondary_image')) {
        if (isset($_POST['secondary_image_url'])) {
            update_post_meta($post_id, '_secondary_image_url', sanitize_text_field($_POST['secondary_image_url']));
        }
    }
}
add_action('save_post', 'save_event_meta');

function load_datepicker_styles() {
    ?>
    <style>
        /* Customize styles for jQuery UI Datepicker */
        .ui-datepicker {
            background: #fff !important;
            border: 1px solid #ccc !important;
            z-index: 9999 !important;
        }
        .ui-datepicker-header {
            background: #f1f1f1 !important;
            color: #333 !important;
        }
        .ui-datepicker td, .ui-datepicker th {
            color: #333 !important;
        }
        .ui-datepicker .ui-state-highlight {
            background: #5cb85c !important;
            color: white !important;
        }
        .ui-datepicker .ui-state-active {
            background: #0275d8 !important;
            color: white !important;
        }
        .ui-datepicker .ui-state-hover {
            background: #d9534f !important;
            color: white !important;
        }
        .ui-datepicker .ui-datepicker-prev, 
        .ui-datepicker .ui-datepicker-next {
            width: auto;
        }
        .ui-datepicker .ui-datepicker-prev-hover, 
        .ui-datepicker .ui-datepicker-next-hover {
            background: inherit !important;
            color: red !important;
        }
        .ui-datepicker .ui-datepicker-prev span, 
        .ui-datepicker .ui-datepicker-next span {
            position: static;
            margin-left: 0;
            margin-top: 3px;
        }
        .ui-icon {
            text-indent: 0 !important; 
            cursor: pointer;
        }
    </style>
    <?php
}
add_action('admin_head', 'load_datepicker_styles');

// Loading jQuery UI Datepicker
function load_datepicker_scripts($hook) {
    // Check if we're on the post editing page and it's the 'event' post type
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }

    // Make sure we're on the 'event' post type page
    if ('event' !== get_post_type()) {
        return;
    }

    // Enqueue jQuery UI Datepicker
    wp_enqueue_script('jquery-ui-datepicker');
    wp_enqueue_style('jquery-ui-datepicker');

    // Enqueue jQuery (it may already be loaded, but this ensures it's loaded)
    wp_enqueue_script('jquery');

    // Add inline script to initialize Datepicker on specific inputs
    wp_add_inline_script('jquery-ui-datepicker', "
        jQuery(document).ready(function($) {
            // Initialize Datepicker for fair date inputs
            $('#fair_date_start, #fair_date_end').datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    ");
}
add_action('admin_enqueue_scripts', 'load_datepicker_scripts');

// Loading scripts and styles for color picker in the admin panel
function load_color_picker_script($hook) {
    // Checking if this is an 'event' post editing page
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }

    // Load scripts and styles for color picker
    wp_enqueue_style('wp-color-picker'); 
    wp_enqueue_script('wp-color-picker');

    // Add jQuery if not already loaded
    wp_enqueue_script('jquery');

    // Loading a script that will depend on jQuery and wp-color-picker
    wp_add_inline_script('wp-color-picker', "
        jQuery(document).ready(function($) {
            $('.color-picker').wpColorPicker();
        });
    ");
}
add_action('admin_enqueue_scripts', 'load_color_picker_script');

// Function to load custom styles in the admin panel
function load_admin_styles($hook) {
    // Checking if this is an 'event' post editing page
    if ('post.php' !== $hook && 'post-new.php' !== $hook) {
        return;
    }

    // Load styles in the admin panel
    wp_enqueue_style('calendar-admin-style', false);
    ?>
    <style>
        .pwe-calendar-inputs-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }
        .pwe-calendar-input {
            display: flex;
            flex-direction: column;
            width: 100%;
            gap: 6px;
        }
        .pwe-calendar-input.half-width {
            width: 49%;
        }
        .pwe-calendar-input.one-third-width {
            width: 32%;
        }
        /* Stylowanie inputów */
        .pwe-calendar-full-width-input {
            width: 100%; /* Ustawiamy szerokość na 100% */
            padding: 8px;
            font-size: 14px;
            box-sizing: border-box; /* Upewniamy się, że padding nie wpłynie na szerokość */
        }
        #partners_gallery_images {
            margin-top: 10px;
        }
    </style>
    <?php
}
add_action('admin_enqueue_scripts', 'load_admin_styles');

// Function to add content editor at the bottom of the form
function move_content_editor_to_bottom() {
    if (get_post_type() != 'event') {
        return;
    }
    // Adding content editor after all metaboxes
    add_action('edit_form_after_editor', 'add_content_editor_to_bottom');
}
add_action('do_meta_boxes', 'move_content_editor_to_bottom');

// Function adding content editor
function add_content_editor_to_bottom() {
    global $post;
    
    if ($post->post_type == 'event') {
        wp_editor( 
            $post->post_content, 
            'content', 
            array(
                'textarea_name' => 'content', 
                'editor_height' => 200
            ) 
        );
    }
}

// Displaying the fair calendar
require_once plugin_dir_path(__FILE__) . 'classes/loop-calendar.php';