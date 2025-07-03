<?php

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
            font-size: 20px;
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

    if (count($pwe_header_partners_items) > 2) {
        $output .= '
        <style>
            .pwe-header-partners-container {
                max-width: 280px;
            }
            .pwe-header-partners__items {
                flex-wrap: wrap;
                flex-direction: row;
                gap: 8px;
            }
            .pwe-header-partners__item {
                max-width: 120px;
            }
            @media(max-width: 1200px) {
                .pwe-header-partners-container {
                    max-width: 240px;
                }
                .pwe-header-partners__items {
                    flex-wrap: wrap;
                    flex-direction: row;
                    gap: 8px;
                }
                .pwe-header-partners__item {
                    max-width: 100px;
                }
            }
            @media(max-width: 1100px) {
                .pwe-header-partners-container {
                    max-width: 280px;
                }
                .pwe-header-partners__item {
                    max-width: 120px;
                }
            }
        </style>';
    }

    $output .= ' 
    <div class="pwe-header-partners">
        <div class="pwe-header-partners-container">
            <div class="pwe-header-partners__title">
                <h3>'. $pwe_header_partners_title .'</h3>
            </div>
            <div class="pwe-header-partners__items">';
                foreach ($pwe_header_partners_items as $item) {
                    $partner_item_logo_url = wp_get_attachment_url($item);
                    $output .= '
                    <div class="pwe-header-partners__item">
                        <img src="'. $partner_item_logo_url .'" alt="partner logo">
                    </div>';
                }
            $output .= '
            </div>
        </div>';

        $other_partners_logotypes = self::json_decode($pwe_header_other_partners);
        if (is_array($other_partners_logotypes)) {
            foreach ($other_partners_logotypes as $item) {
                $pwe_header_other_partner_title = $item["pwe_header_partners_other_title"];
                $pwe_header_other_partner_logo_ids = $item["pwe_header_partners_other_logotypes"];
                $pwe_header_other_partner_logo_ids = explode(',', $pwe_header_other_partner_logo_ids);
        
                if (count($pwe_header_other_partner_logo_ids) > 2) {
                    $output .= '
                    <style>
                        .pwe-header-partners-container {
                            max-width: 280px;
                        }
                        .pwe-header-partners__items {
                            flex-wrap: wrap;
                            flex-direction: row;
                            gap: 8px;
                        }
                        .pwe-header-partners__item {
                            max-width: 120px;
                        }
                        @media(max-width: 1200px) {
                            .pwe-header-partners-container {
                                max-width: 240px;
                            }
                            .pwe-header-partners__items {
                                flex-wrap: wrap;
                                flex-direction: row;
                                gap: 8px;
                            }
                            .pwe-header-partners__item {
                                max-width: 100px;
                            }
                        }
                        @media(max-width: 1100px) {
                            .pwe-header-partners-container {
                                max-width: 280px;
                            }
                            .pwe-header-partners__item {
                                max-width: 120px;
                            }
                        }
                    </style>';
                }

                $output .= '
                <div class="pwe-header-partners-container">
                    <div class="pwe-header-partners__title">
                        <h5>'. $pwe_header_other_partner_title .'</h5>
                    </div>
                    <div class="pwe-header-partners__items">';
                        foreach ($pwe_header_other_partner_logo_ids as $logo_id) {
                            $pwe_header_other_partner_logo = wp_get_attachment_url($logo_id);
                            $output .= '
                            <div class="pwe-header-partners__item">
                                <img src="'. $pwe_header_other_partner_logo .'" alt="partner logo">
                            </div>';
                        } 
                    $output .= '
                    </div>
                </div>';  
            }
        }
        $output .= '
    </div>';


return $output;