<?php

$pwe_header_partners_title_color = !empty($pwe_header_partners_title_color) ? $pwe_header_partners_title_color : 'black';
$pwe_header_partners_background_color = !empty($pwe_header_partners_background_color) ? $pwe_header_partners_background_color : 'rgb(190 190 190 / 80%)';

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
        .pwe-header-partners__title h5 {
            color: '. $pwe_header_partners_title_color .' !important;
            margin: 0 auto;
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
                position: relative;
                top: unset;
                right: unset;
                transform: unset;
                margin: 18px auto 0; 
            }
            .pwe-header-partners__items {
                flex-direction: row;
                flex-wrap: wrap;
            }
        }
    </style>';    

    $output .= '
    <div class="pwe-header-partners">
        <div class="pwe-header-partners__title">
            <h5>'. $pwe_header_partners_title .'</h5>
        </div>
        <div class="pwe-header-partners__items">';
            $pwe_header_partners_items = explode(',', $pwe_header_partners_items); 
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


return $output;