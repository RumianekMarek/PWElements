<?php

$unique_id = PWECommonFunctions::id_rnd();

$pwe_header_partners_title_color = !empty($pwe_header_partners_title_color) ? $pwe_header_partners_title_color : 'black';
$pwe_header_partners_background_color = !empty($pwe_header_partners_background_color) ? $pwe_header_partners_background_color : 'rgb(190 190 190 / 80%)';

$pwe_header_partners_items = explode(',', $pwe_header_partners_items);

$output .= '
    <style>
        .pwe-header-partners {
            position: absolute;';
            if ($pwe_header_partners_position === 'top') {
                $output .= 'top: 18px;';
            } else if ($pwe_header_partners_position === 'bottom') {
                $output .= 'bottom: 18px;';
            } else {
                $output .= '
                top: 50%;
                transform: translate(0, -50%);';
            } $output .= '
            right: 18px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            background-color: '. $pwe_header_partners_background_color .';
            border-radius: 18px;
            padding: 10px;
            gap: 18px;
            z-index: 2;
        }
        .pwe-header-partners-container {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .pwe-header-partners__title {
            margin: 0 auto;
        }
        .pwe-header-partners__title h3 {
            color: '. $pwe_header_partners_title_color .' !important;
            text-transform: uppercase;
            max-width: 250px;
            text-align: center;
            margin: 16px auto 0;
            font-size: 18px;
        }
        .pwe-header-partners__items {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 18px;
        }
        .pwe-header-partners__item {
            max-width: 160px;
        }
        @media(max-width: 1100px) {
            .pwe-header-partners {
                position: static;
                top: unset;
                right: unset;
                transform: unset;
                margin: 18px auto 0;
                flex-direction: row;
                flex-wrap: wrap;
            }
            .pwe-header-partners__items {
                flex-direction: row;
                flex-wrap: wrap;
            }
        }
        @media(max-width: 650px) {
            .pwe-header-partners {
                flex-direction: column;
            }
        }
    </style>';

    $files = [];

    if (!empty($pwe_header_partners_items)) {
        foreach ($pwe_header_partners_items as $item) {
            $partner_item_logo_url = wp_get_attachment_url($item);
            $files[] = $partner_item_logo_url;
        }
    }

    if (count($files) > 0) {
        foreach ($files as &$file) {
            $file = [
                'url' => $file,
                'desc_pl' => basename(dirname($file)),
                'desc_en' => '',
                'link' => ''
            ];
        }
        unset($file);
    }

    $saving_paths = function (&$files, $logo_data) {
        // Get desc_pl & desc_en from meta_data
        $meta = json_decode($logo_data->meta_data, true);
        $desc_pl = $meta["desc_pl"] ?? '';
        $desc_en = $meta["desc_en"] ?? '';
        $link = $logo_data->logos_link;

        $element = [
            'url' => 'https://cap.warsawexpo.eu/public' . $logo_data->logos_url,
            'desc_pl' => $desc_pl,
            'desc_en' => $desc_en,
            'link' => $link
        ];

        // Adding logos_url to $files only if it is not already there
        if (!in_array($element, $files)) {
            $files[] = $element;
        }
    };

    $cap_logotypes_data = PWECommonFunctions::get_database_logotypes_data();
    if (!empty($cap_logotypes_data) && !empty($pwe_header_partners_catalog)) {
        $logotypes_catalogs_array = explode(',', $pwe_header_partners_catalog);
        foreach ($cap_logotypes_data as $logo_data) {
            if (in_array($logo_data->logos_type, $logotypes_catalogs_array)) {
                $saving_paths($files, $logo_data);
            }
        }
    }

    if (count($files) > 1) {
        $output .= '
        <style>
            .pwe-header-partners-container.partners-'. $unique_id .' {
                max-width: 280px;
            }
            .partners-'. $unique_id .' .pwe-header-partners__items {
                flex-wrap: wrap;
                flex-direction: row;
                gap: 8px;
            }
            .partners-'. $unique_id .' .pwe-header-partners__item {
                max-width: 120px;
            }
            @media(max-width: 1200px) {
                .pwe-header-partners-container.partners-'. $unique_id .' {
                    max-width: 240px;
                }
                .partners-'. $unique_id .' .pwe-header-partners__items {
                    flex-wrap: wrap;
                    flex-direction: row;
                    gap: 8px;
                }
                .partners-'. $unique_id .' .pwe-header-partners__item {
                    max-width: 100px;
                }
            }
            @media(max-width: 1100px) {
                .pwe-header-partners-container.partners-'. $unique_id .' {
                    max-width: 280px;
                }
                .partners-'. $unique_id .' .pwe-header-partners__item {
                    max-width: 120px;
                }
            }
        </style>';
    }

    $output .= ' 
    <div class="pwe-header-partners partners-'. $unique_id .'">
        <div class="pwe-header-partners-container">
            <div class="pwe-header-partners__title">
                <h3>'. $pwe_header_partners_title .'</h3>
            </div>
            <div class="pwe-header-partners__items">';
                foreach ($files as $item) {
                    if (!empty($item["link"])) {
                        $output .= '
                        <div class="pwe-header-partners__item">
                            <a href="'. $item["link"] .'" target"_blank"><img src="'. $item["url"] .'" alt="partner logo"></a>
                        </div>';
                    } else {
                        $output .= '
                        <div class="pwe-header-partners__item">
                            <img src="'. $item["url"] .'" alt="partner logo">
                        </div>';
                    }
                    
                }
            $output .= '
            </div> 
        </div>';

        // Check if $pwe_header_other_partners contains valid JSON
        $other_partners_logotypes = self::json_decode($pwe_header_other_partners);
        if (is_array($other_partners_logotypes)) {
            foreach ($other_partners_logotypes as $item) {
                $unique_id = PWECommonFunctions::id_rnd();

                $pwe_header_other_partner_title = $item["pwe_header_partners_other_title"];
                $pwe_header_other_partner_logo_ids = $item["pwe_header_partners_other_logotypes"];
                $pwe_header_partners_other_logotypes_catalog = $item["pwe_header_partners_other_logotypes_catalog"];

                // Ensure that the logotypes are properly exploded into an array
                $pwe_header_other_partner_logo_ids = explode(',', $pwe_header_other_partner_logo_ids);

                // Reinitialize $files for other partner logos
                $other_files = [];

                foreach ($pwe_header_other_partner_logo_ids as $logo_id) {
                    $pwe_header_other_partner_logo = wp_get_attachment_url($logo_id);
                    if ($pwe_header_other_partner_logo) {
                        $other_files[] = $pwe_header_other_partner_logo;
                    }
                }

                if (count($other_files) > 0) {
                    foreach ($other_files as &$file) {
                        $file = [
                            'url' => $file,
                            'desc_pl' => basename(dirname($file)),
                            'desc_en' => '',
                            'link' => ''
                        ];
                    }
                    unset($file);
                }

                // Ensure that $pwe_header_partners_other_logotypes_catalog is a valid, non-empty value
                if (!empty($cap_logotypes_data) && !empty($pwe_header_partners_other_logotypes_catalog)) {
                    $other_logotypes_catalogs_array = explode(',', $pwe_header_partners_other_logotypes_catalog);
                    foreach ($cap_logotypes_data as $logo_data) {
                        if (in_array($logo_data->logos_type, $other_logotypes_catalogs_array)) {
                            $saving_paths($other_files, $logo_data);
                        }
                    }
                }

                if (count($other_files) > 1) {
                    $output .= '
                    <style>
                        .pwe-header-partners-container.partners-'. $unique_id .' {
                            max-width: 280px;
                        }
                        .partners-'. $unique_id .' .pwe-header-partners__items {
                            flex-wrap: wrap;
                            flex-direction: row;
                            gap: 8px;
                        }
                        .partners-'. $unique_id .' .pwe-header-partners__item {
                            max-width: 120px;
                        }
                        @media(max-width: 1200px) {
                            .pwe-header-partners-container.partners-'. $unique_id .' {
                                max-width: 240px;
                            }
                            .partners-'. $unique_id .' .pwe-header-partners__items {
                                flex-wrap: wrap;
                                flex-direction: row;
                                gap: 8px;
                            }
                            .partners-'. $unique_id .' .pwe-header-partners__item {
                                max-width: 100px;
                            }
                        }
                        @media(max-width: 1100px) {
                            .pwe-header-partners-container.partners-'. $unique_id .' {
                                max-width: 280px;
                            }
                            .partners-'. $unique_id .' .pwe-header-partners__item {
                                max-width: 120px;
                            }
                        }
                    </style>';
                }

                $output .= '
                <div class="pwe-header-partners-container partners-'. $unique_id .'">
                    <div class="pwe-header-partners__title">
                        <h3>' . $pwe_header_other_partner_title . '</h3>
                    </div>
                    <div class="pwe-header-partners__items">';
                        foreach ($other_files as $item) {
                            if (!empty($item["link"])) {
                                $output .= '
                                <div class="pwe-header-partners__item">
                                    <a href="'. $item["link"] .'" target"_blank"><img src="'. $item["url"] .'" alt="partner logo"></a>
                                </div>';
                            } else {
                                $output .= '
                                <div class="pwe-header-partners__item">
                                    <img src="'. $item["url"] .'" alt="partner logo">
                                </div>';
                            }
                        }
                    $output .= '
                    </div>
                </div>';  
            }
        }
        $output .= '
    </div>';


return $output;