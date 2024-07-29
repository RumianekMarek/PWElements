<?php

class PWElementAdditionalLogotypes extends SharedProperties {
    
    public static function additionalArray() {
        return array(
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
                'heading' => __('Min width logotypes', 'pwe_logotypes'),
                'param_name' => 'logotypes_min_width_logo',
                'description' => __('Default min width for grid 140px', 'pwe_logotypes'),
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
                        'type' => 'checkbox',
                        'heading' => __('Logo color', 'pwe_logotypes'),
                        'param_name' => 'logotype_color',
                        'save_always' => true,
                        'admin_label' => true,
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

    public static function additionalOutput($atts, $logotypes = null) {

        $el_id = SharedProperties::$rnd_id;

        include_once plugin_dir_path(__FILE__) . '/../scripts/logotypes-slider.php';

        extract( shortcode_atts( array(
            'logotypes_media' => '',
            'logotypes_catalog' => '',
            'logotypes_title' => '',
            'logotypes_name' => '',
            'logotypes_caption_on' => '',
            'logotypes_position_title' => '',
            'logotypes_min_width_logo' => '',
            'logotypes_slider_full_width' => '',
            'logotypes_slider_desktop' => '',
            'logotypes_grid_mobile' => '',
            'logotypes_dots_off' => '',
            'logotypes_slider_logo_white' => '',
            'logotypes_slider_logo_color' => '',
            'logotypes_files' => '',
            'pwe_header_logotypes' => '', 
            'conf_logotypes_catalog' => '',   
        ), $atts )); 
 
        if ($logotypes_position_title == ''){
            $logotypes_position_title = 'left';
        } 

        $output .= '
            <style>
                .pwe-container-logotypes-gallery {
                    z-index: 1;
                }
                .pwe-logotypes-gallery-wrapper {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 10px;
                    margin-top: 18px;
                }
                .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .pwe-logo-item,
                .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .pwe-logo-item div,
                .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .slides div,
                .pwe-conferences .pwe-logotypes-gallery-wrapper .pwe-logo-item,
                .pwe-conferences .pwe-logotypes-gallery-wrapper .pwe-logo-item div,
                .pwe-conferences .pwe-logotypes-gallery-wrapper .slides div {
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;';
                    if ($logotypes_min_width_logo != '') {
                        $output .= 'min-width: '. $logotypes_min_width_logo .' !important;';
                    } else {
                        $output .= 'min-width: 140px;';
                    }
                    $output .= '
                    align-self: flex-start;
                    height: fit-content;
                    aspect-ratio: 3/2;
                    margin: 5px;
                }
                .pwelement_'. $el_id .' .pwe-logotypes-title {
                    display: flex;
                    justify-content: '. $logotypes_position_title .';
                }
                .pwe-logotypes-title h4 {
                    margin: 0;
                }
                .pwe-full-width .pwe_element_catalog_slider {
                    overflow: visible !important;
                }
                .pwe-white-logotypes div[style*="background-image"],
                .pwe-header .pwe-logotypes-gallery-wrapper div[style*="background-image"] {
                    filter: brightness(0) invert(1);
                    transition: all .3s ease;
                }
                .pwe-white-logotypes div[style*="background-image"]:hover,
                .pwe-header .pwe-logotypes-gallery-wrapper div[style*="background-image"]:hover {
                    filter: none;
                }
                .pwe-color-logotypes div[style*="background-image"] {
                    filter: none !important;
                }
                .pwelement_'. $el_id .' .pwe-header .pwe-logotypes-title { 
                    justify-content: center;
                }
            </style>';

            if ($logotypes_caption_on == true || $header_logotypes_caption_on == true) {
                $output .= '
                <style>
                    .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .pwe-logo-item,
                    .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .pwe-logo-item div {
                        display: block;
                    }
                    .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .pwe-logo-item p,
                    .pwelement_'. $el_id .' .pwe-logotypes-gallery-wrapper .pwe-logo-item div p {
                        width: 100%;
                        text-transform: uppercase;
                        font-size: 12px;
                        font-weight: 700;
                        color: black;
                        white-space: break-spaces;
                        text-align: center;
                        line-height: 1.1 !important;
                        margin: 5px;
                        padding: 8px 16px;
                    }
                </style>';
            }

            if ($logotypes_media != '' || $logotypes_catalog != '' || !empty($pwe_header_logotypes) || !empty($conf_logotypes_catalog)){
                
                $pwe_header_logotypes_urldecode = urldecode($pwe_header_logotypes);
                $pwe_header_logotypes_json = json_decode($pwe_header_logotypes_urldecode, true);
                $header_logotypes_media_urls = [];

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
                        $header_logotypes_caption_on = $logotypes["logotypes_caption_on"];
                        $header_logotypes_items_width = $logotypes_item["logotypes_items_width"];
                    }   
                    $header_logotypes_media_ids = explode(',', $header_logotypes_media);  
                }
        
                foreach ($header_logotypes_media_ids as $id) {
                    $url = wp_get_attachment_url($id); 
                    if ($url) {
                        $header_logotypes_media_urls[] = $url;
                    }
                }

                $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
                $domain = $_SERVER['HTTP_HOST'];
                $server_url = ($is_https ? 'https://' : 'http://') . $domain;
                $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);
        
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
                        $logotypes_catalogs = explode(',', $logotypes_catalog);

                        // Queue for processing directories
                        $directories_to_process = [];
                        foreach ($logotypes_catalogs as $catalog) {
                            $catalog = trim($catalog);
                            $directories_to_process[] = $_SERVER['DOCUMENT_ROOT'] . '/doc/' . $catalog;
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
        
                    // Calculate width for header logotypes
                    if ($header_logotypes_width . '%' !== '%') {
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
            
                    $output .= '<div id="'. $element_unique_id .'" class="pwe-container-logotypes-gallery">
                                <div class="pwe-logotypes-title main-heading-text">
                                    <h4 class="pwe-uppercase"><span>'. $logotypes_title .'</span></h4>
                                </div>
                                <div class="pwe-logotypes-gallery-wrapper'; $output .= ($logotypes_slider_logo_white == "true") ? ' pwe-white-logotypes' : '';
                                                                            $output .= ($logotypes_slider_logo_color == "true") ? ' pwe-color-logotypes' : '';
                                                                            $output .= (isset($logotypes_slider_full_width) && $logotypes_slider_full_width == "true") ? ' pwe-full-width' : '';
                                                                            $output .= '">';

                                $images_url = array();
                                $urls_custom = array();

                                // Search all files and generate their URL paths
                                foreach ($files as $index => $file) {
                                    $short_path = '';
                                    
                                    // Deciding on the path structure depending on the directory
                                    if ($logotypes_catalog == "partnerzy obiektu") {
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
                                        "logotypes_name" => $logotypes_name,
                                        "thumbnail_caption" => $thumbnail_caption        
                                    );
                                }

                                $images_options = array();
                                $images_options[] = array(
                                    "element_id" => $el_id,
                                    "logotypes_caption_on" => $logotypes_caption_on,
                                    "header_logotypes_caption_on" => $header_logotypes_caption_on,
                                    "logotypes_dots_off" => $logotypes_dots_off
                                );

                                // Output logotypes
                                if (count($updated_images_url) > 0) {
                                    if ($mobile != 1 && ($logotypes_slider_desktop != true) || 
                                        $mobile == 1 && (count($updated_images_url) <= 2 || $logotypes_grid_mobile == true || $header_logotypes_slider_off == true)) {
                                
                                        foreach ($updated_images_url as $url) { 

                                            if (($logotypes_caption_on == true || $header_logotypes_caption_on == true) && empty($logotypes_name)) {
                                                $logo_caption_text = '<p>'. $url["folder_name"] .'</p>';
                                            } else {
                                                $logo_caption_text = '<p>'. $logotypes_name .'</p>';
                                            }

                                            if ($header_logotypes_items_width != '') {
                                                $logotypes_items_width = 'min-width:'. $header_logotypes_items_width .';';
                                            }
                                            $target_blank = (strpos($url["site"], 'http') !== false) ? 'target="_blank"' : '';
                                            if (!empty($image)) {
                                                if (!empty($url["site"])) {
                                                    $output .= '<a '. $target_blank .' href="'. $url["site"] .'"><div class="pwe-logo-item '. $url["class"] .'" style="background-image: url(\'' . $url["img"] . '\'); '. $url["style"] .' '. $logotypes_items_width .'">'. $logo_caption_text .'</div></a>';
                                                } else  {
                                                    $output .= '<div class="pwe-logo-item '. $url["class"] .'" style="background-image: url(\'' . $url["img"] . '\'); '. $url["style"] .' '. $logotypes_items_width .'">'. $logo_caption_text .'</div>';
                                                }
                                            } 
                                        }
                                    } else {
                                        $output .= PWELogotypesSlider::sliderOutput($updated_images_url, 3000, $images_options);
                                    }
                                }
                                      
                                    
                        $output .= '</div>
                    </div>';
            
                
                }
            }
        
        return $output;
    }
    
}

?>