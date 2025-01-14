<?php

class PWElementAdditionalLogotypes {

    public static function additionalArray() {
        return array(
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Layout', 'pwe_logotypes'),
                'param_name' => 'logotypes_layout',
                'save_always' => true,
                'value' => array(
                    'Flex' => 'flex',
                    'Grid' => 'grid',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'Aditional options',
                'heading' => __('Text-align title', 'pwe_logotypes'),
                'param_name' => 'logotypes_position_title',
                'description' => __('Default left, for header dafault center', 'pwe_logotypes'),
                'save_always' => true,
            ),
            array(
                'type' => 'textfield',
                'group' => 'Aditional options',
                'heading' => __('Min width logotypes (flex only)', 'pwe_logotypes'),
                'param_name' => 'logotypes_min_width_logo',
                'description' => __('Default min width for flex 140px', 'pwe_logotypes'),
                'save_always' => true,
            ),
            array(
                'type' => 'textfield',
                'group' => 'Aditional options',
                'heading' => __('Number of logotypes in slider', 'pwe_logotypes'),
                'param_name' => 'slides_to_show',
                'description' => __('Default 7', 'pwe_logotypes'),
                'save_always' => true,
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Aditional options',
                'heading' => __('Items shadow', 'pwe_logotypes'),
                'param_name' => 'logotypes_items_shadow',
                'description' => __('2px 2px 12px #cccccc', 'pwe_logotypes'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwe_logotypes') => 'true',),
            ),
            array(
                'type' => 'textfield',
                'group' => 'Aditional options',
                'heading' => __('Custom css of items', 'pwe_logotypes'),
                'param_name' => 'logotypes_items_custom_style',
                'save_always' => true,
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Aditional options',
                'heading' => __('Turn on full width', 'pwe_logotypes'),
                'param_name' => 'logotypes_slider_full_width',
                'description' => __('Turn on full width', 'pwe_logotypes'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwe_logotypes') => 'true',),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Aditional options',
                'heading' => __('Slider desktop', 'pwe_logotypes'),
                'param_name' => 'logotypes_slider_desktop',
                'description' => __('Check if you want to display in slider on desktop.', 'pwe_logotypes'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwe_logotypes') => 'true',),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Aditional options',
                'heading' => __('Grid mobile', 'pwe_logotypes'),
                'param_name' => 'logotypes_grid_mobile',
                'description' => __('Check if you want to display in grid on mobile.', 'pwe_logotypes'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwe_logotypes') => 'true',),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Aditional options',
                'heading' => __('Turn off dots', 'pwe_logotypes'),
                'param_name' => 'logotypes_dots_off',
                'description' => __('Check if you want to turn on dots.', 'pwe_logotypes'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwe_logotypes') => 'true',),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Aditional options',
                'heading' => __('Randomise logotypes', 'pwe_logotypes'),
                'param_name' => 'logotypes_display_random1',
                'description' => __('Check if you want to display logotypes random.', 'pwe_logotypes'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwe_logotypes') => 'true',),
            ),
            array(
                'type' => 'param_group',
                'group' => 'Links',
                'heading' => __('Add link', 'pwe_logotypes'),
                'param_name' => 'logotypes_files',
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Filename(ex. file.png)', 'pwe_logotypes'),
                        'param_name' => 'logotype_filename',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Link', 'pwe_logotypes'),
                        'param_name' => 'logotype_link',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Logo color', 'pwe_logotypes'),
                        'param_name' => 'logotype_color',
                        'save_always' => true,
                        'admin_label' => true,
                        'param_holder_class' => 'dropdown-checkbox',
                        'value' => array(
                            'No' => '',
                            'Yes' => 'true'
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Custom style', 'pwe_logotypes'),
                        'param_name' => 'logotype_style',
                        'save_always' => true,
                        'admin_label' => true,
                    ),
                ),
            ),
        );
    }

    public static function additionalOutput($atts, $el_id, $logotypes = null, $exhibitors_logotypes = null) {

        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);

        extract( shortcode_atts( array(
            'logotypes_media' => '',
            'logotypes_catalog' => '',
            'logotypes_layout' => '',
            'logotypes_title' => '',
            'logotypes_name' => '',
            'logotypes_exhibitors_on' => '',
            'logotypes_caption_on' => '',
            'logotypes_position_title' => '',
            'logotypes_min_width_logo' => '',
            'logotypes_slider_full_width' => '',
            'logotypes_slider_desktop' => '',
            'logotypes_grid_mobile' => '',
            'logotypes_dots_off' => '',
            'logotypes_display_random1' => '',
            'logotypes_slider_logo_white' => '',
            'logotypes_slider_logo_color' => '',
            'logotypes_items_shadow' => '',
            'logotypes_items_custom_style' => '',
            'logotypes_files' => '',
            'pwe_header_logotypes' => '',
            'conf_logotypes_catalog' => '',
            'slides_to_show' => '',
        ), $atts ));

        if ($logotypes_position_title == ''){
            $logotypes_position_title = 'left';
        }

        $output = '';

        if ($logotypes_media != '' || $logotypes_catalog != '' || !empty($pwe_header_logotypes) || !empty($conf_logotypes_catalog)){

            $logotypes_default_width = $mobile == 1 ? '80px' : '140px';
            $logotypes_min_width_logo = !empty($logotypes_min_width_logo) ? $logotypes_min_width_logo : $logotypes_default_width;
            $slides_to_show = !empty($slides_to_show) ? $slides_to_show : 7;
            $logotypes_items_shadow = $logotypes_items_shadow == true ? '2px 2px 12px #cccccc' : 'none';
            $slider_class = ($mobile != 1 && ($logotypes_slider_desktop == true) || $mobile == 1 && ($logotypes_grid_mobile != true || (!empty($header_logotypes_media_urls) && $header_logotypes_slider_off != true))) ? 'pwe-slides' : '';

            $output .= '
            <style>
                .pwelement_'. $el_id .' .pwe-container-logotypes-gallery {
                    z-index: 1;
                }
                .pwelement_'. $el_id .' .pwe-logo-item-container {
                    box-shadow: '. $logotypes_items_shadow .';
                    '. ($logotypes_items_shadow !== 'none' ? 'background-color: white;' : '') .'
                    border-radius: 10px;
                    overflow: hidden;
                    padding: 5px;
                    '. ($logotypes_items_shadow !== 'none' ? 'padding: 10px 0;' : '') .'
                    background-color: white !important;
                    '. ($logotypes_items_shadow !== 'none' ? 'min-width: 200px;' : '') .'
                }
                .pwelement_'. $el_id .' .pwe-logo-item {
                    max-width: '. $logotypes_min_width_logo .';
                    '. ($logotypes_items_shadow !== 'none' ? 'max-width: 100px;' : $logotypes_min_width_logo) .'
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    margin: 0 auto;
                }
                .pwelement_'. $el_id .' .pwe-logo-item p {
                    margin: 8px 0 0;
                    font-size: 14px;
                    font-weight: 500;
                }
                .pwelement_'. $el_id .' .slick-slide .pwe-logo-item {
                    max-width: 100%;
                }
                .pwelement_'. $el_id .' .pwe-logo-item img {
                    object-fit: contain;
                    aspect-ratio: 3 / 2;
                }
                .pwelement_'. $el_id .' .pwe-logotypes-title {
                    display: flex;
                    justify-content: '. $logotypes_position_title .';
                }
                .pwe-logotypes-title h4 {
                    margin: 0;
                }
                .row-parent:has(.pwelement_'. $el_id .' .pwe-full-width)  {
                    max-width: 100% !important;
                }
                .pwe-white-logotypes img,
                .pwe-header .pwe-logotypes-gallery-wrapper img {
                    filter: brightness(0) invert(1);
                    transition: all .3s ease;
                }
                .pwe-white-logotypes img:hover,
                .pwe-header .pwe-logotypes-gallery-wrapper img:hover {
                    filter: none;
                }
                .pwe-color-logotypes div[style*="background-image"] {
                    filter: none !important;
                }
                .pwelement_'. $el_id .' .pwe-header .pwe-logotypes-title {
                    justify-content: center;
                }

                .pwelement_'. $el_id .' .pwe-logo-item-container p {
                    text-transform: uppercase;
                    font-size: 12px;
                    font-weight: 700;
                    color: black;
                    white-space: break-spaces;
                    text-align: center;
                    line-height: 1.1 !important;
                    margin: 5px;
                }

                @media(max-width:920px){
                    .pwelement_'. $el_id .' .pwe-logo-item-container {
                        '. ($logotypes_items_shadow !== 'none' ? 'min-width: 135px;' : '') .'
                    }
                }
                @media(max-width:620px){
                    .pwelement_'. $el_id .' .pwe-logo-item-container {
                    '. ($logotypes_items_shadow !== 'none' ? 'max-width: 22% !important;' : '') .'
                    '. ($logotypes_items_shadow !== 'none' ? 'min-width: 22% !important;' : '') .'
                    '. ($logotypes_items_shadow !== 'none' ? 'padding: 5px !important;' : '') .'
                    }
                    .pwelement_'. $el_id .' .pwe-logo-item-container p {
                    '. ($logotypes_items_shadow !== 'none' ? 'font-size: 9px !important;' : '') .'
                    '. ($logotypes_items_shadow !== 'none' ? 'font-weight: 600 !important;' : '') .'
                    }
                }
            </style>';

            if ($slider_class !== 'pwe-slides') {

                if ($logotypes_layout == "" || $logotypes_layout == "flex") {
                    $output .= '
                    <style>
                    .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        flex-wrap: wrap;
                        gap: 10px;
                        margin-top: 18px;
                    }
                    </style>';
                } else {
                    $output .= '
                    <style>
                    .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper {
                        display: grid;
                        grid-template-columns: repeat(6, 1fr);
                        gap: 16px;
                    }
                    @media(max-width: 960px) {
                        .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper {
                            grid-template-columns: repeat(5, 1fr);
                            gap: 16px;
                        }
                        .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .pwe-logo-item {
                            margin: 0;
                            min-width: 100%;
                        }
                    }
    
                    @media(max-width: 550px) {
                        .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper {
                            grid-template-columns: repeat(4, 1fr);
                            gap: 10px !important;
                        }
                    }
                    @media(max-width: 450px) {
                        .pwelement_'. $el_id .' .pwe-logo-item-container p {
                            font-size: 10px;
                        }
                    }
                    @media(max-width: 380px) {
                        .pwelement_'. $el_id .' .pwe-logo-item-container p {
                            font-size: 8px;
                        }
                    }
                    </style>';
                }

            }

            $pwe_header_logotypes_urldecode = urldecode($pwe_header_logotypes);
            $pwe_header_logotypes_json = json_decode($pwe_header_logotypes_urldecode, true);
            $header_logotypes_media_urls = [];
            $header_logotypes_slider_off = '';

            if (is_array($pwe_header_logotypes_json)) {
                foreach ($pwe_header_logotypes_json as $logotypes_item) {
                    if (isset($logotypes)) {
                        $header_logotypes_url = $logotypes["logotypes_catalog"];
                        $header_logotypes_title = $logotypes["logotypes_title"];
                        $header_logotypes_name = $logotypes["logotypes_name"];
                        $header_logotypes_width = $logotypes["logotypes_width"];
                        $header_logotypes_media = $logotypes["logotypes_media"];
                        $header_logotypes_slider_off = $logotypes["logotypes_slider_off"];
                        $header_logotypes_caption_on = $logotypes["logotypes_caption_on"];
                        $header_logotypes_items_width = $logotypes["logotypes_items_width"];
                    } else {
                        $header_logotypes_url = $logotypes_item["logotypes_catalog"];
                        $header_logotypes_title = $logotypes_item["logotypes_title"];
                        $header_logotypes_name = $logotypes_item["logotypes_name"];
                        $header_logotypes_width = $logotypes_item["logotypes_width"];
                        $header_logotypes_media = $logotypes_item["logotypes_media"];
                        $header_logotypes_slider_off = $logotypes_item["logotypes_slider_off"];
                        $header_logotypes_caption_on = $logotypes_item["logotypes_caption_on"];
                        $header_logotypes_items_width = $logotypes_item["logotypes_items_width"];
                    }
                    $header_logotypes_media_ids = explode(',', $header_logotypes_media);
                }
            }

            if (isset($header_logotypes_media_ids)) {
                foreach ($header_logotypes_media_ids as $id) {
                    $url = wp_get_attachment_url($id);
                    if ($url) {
                        $header_logotypes_media_urls[] = $url;
                    }
                }
            }

            $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
            $domain = $_SERVER['HTTP_HOST'];
            $server_url = ($is_https ? 'https://' : 'http://') . $domain;

            $unique_id = rand(10000, 99999);
            $element_unique_id = 'pweLogotypes-' . $unique_id;

            if (!empty($conf_logotypes_catalog)) {
                $logotypes_catalog = $conf_logotypes_catalog;
            }

            if (!empty($pwe_header_logotypes)) {
                $logotypes_catalog = $header_logotypes_url;
                $logotypes_title = $header_logotypes_title;
                $logotypes_name = $header_logotypes_name;
            }

            $files = [];

            if ($logotypes_catalog == "partnerzy obiektu") {
                $files = glob($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/PWElements/media/partnerzy-obiektu/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
            } else if ($logotypes_catalog == "wspierają nas") {
                $files = glob($_SERVER['DOCUMENT_ROOT'] . '/wp-content/plugins/PWElements/media/wspieraja-nas/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
            } else if (($logotypes_catalog == "" && $logotypes_media == "") && $header_logotypes_media_urls !== "") {
                $files = $header_logotypes_media_urls;
            } else {
                $logotypes_media = explode(',', $logotypes_media);

                // Add media URLs if they exist
                if (!empty($logotypes_media)) {
                    foreach ($logotypes_media as $image_id) {
                        $logotype_url = wp_get_attachment_url($image_id);
                        if (!empty($logotype_url)) {
                            $files[] = $logotype_url;
                        }
                    }
                }

                // Processing logotypes_catalog
                if (!empty($logotypes_catalog)) {
                    // Sprawdzenie, czy "catalog" już istnieje w $logotypes_catalog
                    $logotypes_catalog = trim($logotypes_catalog, ','); // Usuwamy ewentualne nadmiarowe przecinki

                    $logotypes_catalogs = explode(',', $logotypes_catalog);
                    $logotypes_catalogs = array_map('trim', $logotypes_catalogs); // Usunięcie białych znaków dla każdego elementu


                    // Jeśli "catalog" nie istnieje, dodaj go na początku
                    if (!in_array('catalog', $logotypes_catalogs)) {
                        array_unshift($logotypes_catalogs, 'catalog'); // Dodajemy "catalog" na początek tablicy
                    }

                    $exhibitors_catalog = [];

                    // W przypadku, gdy $logotypes_exhibitors_on == true i $exhibitors_logotypes nie jest puste
                    if ($logotypes_exhibitors_on == true && !empty($exhibitors_logotypes)) {
                        foreach ($exhibitors_logotypes as $exhibitors_logotype) {
                            $exhibitors_catalog[] = $exhibitors_logotype['img'];
                        }
                    }

                    // Złącz ponownie katalogi w jeden ciąg znaków
                    $logotypes_catalog = implode(',', $logotypes_catalogs);

                    // Queue for processing directories
                    $directories_to_process = [];
                    foreach ($logotypes_catalogs as $catalog) {
                        $catalog = trim($catalog);

                        // Ignoring "/"
                        if ($catalog === '/') {
                            continue; // Skip this directory
                        }

                        $full_path = $_SERVER['DOCUMENT_ROOT'] . '/doc/' . $catalog;

                        // Check if it's a file
                        if (is_file($full_path)) {
                            // Adding a direct file to the image list
                            $files[] = substr($full_path, strpos($full_path, '/doc/'));
                        } else {
                            // If it's a folder, add it to process
                            $directories_to_process[] = $full_path;
                        }
                    }

                    // Check if 'catalog' was added and if so, add $exhibitors_catalog to $files
                    if (in_array('catalog', $logotypes_catalogs)) {
                        foreach ($exhibitors_catalog as $catalog_img) {
                            $files[] = $catalog_img;  // Dodaj obrazy z $exhibitors_catalog do $files
                        }
                    }

                    while (!empty($directories_to_process)) {
                        $current_directory = array_shift($directories_to_process);

                        // Add all images from the current directory
                        $catalog_urls = glob($current_directory . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);

                        foreach ($catalog_urls as $catalog_image_url) {
                            $files[] = substr($catalog_image_url, strpos($catalog_image_url, '/doc/'));
                        }

                        // Find subdirectories and add them to the queue
                        $sub_directories = glob($current_directory . '/*', GLOB_ONLYDIR);

                        // Sort subdirectories by creation date
                        usort($sub_directories, function($a, $b) {
                            return filemtime($a) - filemtime($b);
                        });

                        // Adding subdirectories to the queue
                        foreach ($sub_directories as $sub_directory) {
                            $directories_to_process[] = $sub_directory;
                        }
                    }
                }

            }

            if (count($files) > 0) {

                if($logotypes_display_random1){
                    shuffle($files);
                }

                // Calculate width for header logotypes
                if (isset($header_logotypes_width) && $header_logotypes_width . '%' !== '%') {
                    if ($header_logotypes_width >= 70 && $header_logotypes_width < 100) {
                        $header_logotypes_width  -= 3;
                    } else if ($header_logotypes_width >= 50 && $header_logotypes_width < 70) {
                        $header_logotypes_width  -= 2;
                    } else if ($header_logotypes_width >= 30 && $header_logotypes_width < 50) {
                        $header_logotypes_width  -= 1;
                    }
                    $output .= '<style>
                                    #'.$element_unique_id .' {
                                        width: '.$header_logotypes_width.'%;
                                    }
                                </style>';
                }

                if (empty($logotypes_title)) {
                    $output .= '<style>
                                    #'. $element_unique_id .' .pwe-logotypes-title {
                                        display: none !important;
                                    }
                                </style>';
                }

                $output .= '
                <div id="'. $element_unique_id .'" class="pwe-container-logotypes-gallery">
                    <div class="pwe-logotypes-title main-heading-text">';
                    $logotypes_title = str_replace(array('`{`', '`}`'), array('[', ']'), $logotypes_title);
                    $output .= '
                        <h4 class="pwe-uppercase"><span>'. $logotypes_title .'</span></h4>
                    </div>
                    <div class="'. $slider_class .' pwe-logotypes-gallery-wrapper'; $output .= ($logotypes_slider_logo_white == "true") ? ' pwe-white-logotypes' : '';
                                                                $output .= ($logotypes_slider_logo_color == "true") ? ' pwe-color-logotypes' : '';
                                                                $output .= (isset($logotypes_slider_full_width) && $logotypes_slider_full_width == "true") ? ' pwe-full-width' : '';
                                                                $output .= '">';

                    $images_url = array();
                    $urls_custom = array();

                    // Search all files and generate their URL paths
                    foreach ($files as $index => $file) {
                        $short_path = '';

                        // Deciding on the path structure depending on the directory
                        if ($logotypes_catalog == "partnerzy obiektu" || $logotypes_catalog == "wspierają nas") {
                            $short_path = substr($file, strpos($file, '/wp-content/'));
                        } else {
                            $short_path = substr($file, strpos($file, '/doc/'));
                        }

                        // Build the full path to the image
                        if ($header_logotypes_media_urls !== '') {
                            $full_path = $short_path;
                        } else {
                            $full_path = $server_url . $short_path;
                        }

                        // Add the generated path to the URL list
                        $images_url[] = $full_path;
                    }

                    // Decoding logo data from JSON format
                    $logotypes_files_urldecode = urldecode($logotypes_files);
                    $logotypes_files_json = json_decode($logotypes_files_urldecode, true);

                    // Encoding the data back to JSON
                    $logotypes_files_json_encode = json_encode($logotypes_files_json);

                    $updated_images_url = array();

                    // Processing each image and assign it the appropriate link, class and style
                    foreach ($images_url as $image) {
                        // Reset variable for each image
                        $site = '';
                        $class = '';
                        $style = '';
                        $target_blank = '';

                        // Search for the corresponding logo and set the properties
                        foreach ($logotypes_files_json as $logotype) {
                            if (strpos($image, $logotype["logotype_filename"]) !== false) {
                                $site = $logotype["logotype_link"];
                                $class = ($logotype["logotype_color"] === "true") ? 'pwe-logo-original' : '';
                                $style = ($logotype["logotype_style"] === "") ? '' : $logotype["logotype_style"];
                                $target_blank = (strpos($site, 'http') !== false) ? 'target="_blank"' : '';
                                break;
                            }
                        }

                        // Add the HTTPS protocol if it is not included in the link
                        if (!empty($site) && !preg_match("~^(?:f|ht)tps?://~i", $site) && (strpos($site, 'http') !== false)) {
                            $site = "https://" . $site;
                        }

                        // Extract folder name from the path
                        $folder_name = basename(dirname($image));

                        //Build the final data structure for the image
                        $updated_images_url[] = array(
                            "img"   => $image,
                            "site"  => $site,
                            "class" => $class,
                            "style" => $style,
                            "target_blank" => $target_blank,
                            "folder_name" => $folder_name,
                            "logotypes_name" => $logotypes_name
                        );
                    }

                    // List of translations
                    $translations = array(
                        "Partner Targów" => "Fair<br>Partner",
                        "Partner Targow" => "Fair<br>Partner",
                        "Partner Pokazów" => "Show<br>Partner",
                        "Partner Konferencji" => "Conference<br>Partner",
                        "Partner Merytoryczny" => "Content<br>Partner",
                        "Partner Strategiczny" => "Strategic<br>Partner",
                        "Partner Gold" => "Partner<br>Gold",
                        "Partner Platinum" => "Platinum<br>Partner",
                        "Partner Główny" => "Main<br>Partner",
                        "Partner Honorowy" => "Honorary<br>Partner",
                        "Targi Wspiera" => "Fair<br>Supports",
                        "Kraj Partnerski" => "Partner<br>Country",
                        "Oficjalny Partner Targów" => "Official Fair<br>Partner",
                        "Patron" => "Patron",
                        "Patron Medialny" => "Media<br>Patron",
                        "Patron Honorowy" => "Honorary<br>Patron",
                        "Patron Branżowy" => "Industry<br>Patron",
                        "Patron Medialny Branżowy" => "Industry Media<br>Patron",
                        "Patron Ambasady" => "Patronage<br>of the Embassy",
                        "Wystawca" => "Exhibitor"
                    );

                    $images_options = array();
                    $images_options[] = array(
                        "element_id" => $el_id,
                        "logotypes_caption_on" => $logotypes_caption_on,
                        "header_logotypes_caption_on" => isset($header_logotypes_caption_on) ? $header_logotypes_caption_on : '',
                        "logotypes_dots_off" => $logotypes_dots_off,
                        "caption_translations" => $translations
                    );

                    // Output logotypes
                    if (count($updated_images_url) > 0) {
                        foreach ($updated_images_url as $url) {

                            if (($logotypes_caption_on == true || (isset($header_logotypes_caption_on) && $header_logotypes_caption_on == true)) && empty($logotypes_name)) {
                                if (get_locale() == 'pl_PL') {
                                    if (strpos($url["img"], 'expoplanner.com') !== false) {
                                        $logo_caption_text = '<p>Wystawca</p>';
                                    } else {
                                        // Split folder_name into words and add <br> after the first word
                                        $logotypes_caption_words = explode(" ", $url["folder_name"]);
                                        if (count($logotypes_caption_words) > 1) {
                                            $logo_caption_text = '<p>' . $logotypes_caption_words[0] . '<br>' . implode(" ", array_slice($logotypes_caption_words, 1)) . '</p>';
                                        } else {
                                            $logo_caption_text = '<p>' . $url["folder_name"] . '</p>'; // When folder_name is one word
                                        }
                                    }
                                } else {
                                    if (strpos($url["img"], 'expoplanner.com') !== false) {
                                        $logo_caption_text = '<p>Exhibitor</p>';
                                    } else {
                                        if (array_key_exists($url["folder_name"], $translations)) {
                                            $logo_caption_text = '<p>'. $translations[$url["folder_name"]] .'</p>';
                                        } else {
                                            $logo_caption_text = '<p>'. $url["folder_name"] .'</p>';
                                        }
                                    }
                                }
                            } else {
                                $logo_caption_text = '<p>'. $logotypes_name .'</p>';
                            }

                            if (isset($header_logotypes_items_width) && $header_logotypes_items_width != '') {
                                $logotypes_items_width = 'min-width:'. $header_logotypes_items_width .';';
                            } else {
                                $logotypes_items_width = '';
                            }
                            $target_blank = (strpos($url["site"], 'http') !== false) ? 'target="_blank"' : '';
                            if (!empty($image)) {
                                if (!empty($url["site"])) {
                                    $output .= '
                                    <a class="pwe-logo-item-container" '. $target_blank .' href="'. $url["site"] .'" style="'. $logotypes_items_custom_style .'">
                                        <div class="pwe-logo-item '. $url["class"] .'" style="'. $url["style"] .' '. $logotypes_items_width .' '. $logotypes_items_custom_style .'">
                                            <img data-no-lazy="1" src="' . $url["img"] . '"/>
                                            '. $logo_caption_text .'
                                        </div>
                                    </a>';
                                } else  {
                                    $output .= '
                                    <div class="pwe-logo-item-container" style="'. $logotypes_items_custom_style .'">
                                        <div class="pwe-logo-item '. $url["class"] .'" style="'. $url["style"] .' '. $logotypes_items_width .'">
                                            <img data-no-lazy="1" src="' . $url["img"] . '"/>
                                            '. $logo_caption_text .'
                                        </div>
                                    </div>';
                                }
                            }
                        }
                    }

                    $output .= '
                    </div>
                </div>';

                if ($mobile != 1 && ($logotypes_slider_desktop == true) || $mobile == 1 && ($logotypes_grid_mobile != true || (!empty($header_logotypes_media_urls) && $header_logotypes_slider_off != true))) {

                    $opinions_dots_display = $logotypes_dots_off != true ? 'true' : '';

                    include_once plugin_dir_path(dirname(dirname(__DIR__))) . 'scripts/slider.php';
                    $output .= PWESliderScripts::sliderScripts('logotypes', '#'. $element_unique_id, $opinions_dots_display, $opinions_arrows_display = false, $slides_to_show);
                }

            }
        }

        return $output;
    }

}

?>