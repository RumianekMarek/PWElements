<?php

$pwe_congress_widget_buttons_width = ($pwe_congress_widget_buttons_width == '') ? '200px' : $pwe_congress_widget_buttons_width;

if (get_locale() == 'pl_PL') {
    $pwe_congress_widget_title = ($pwe_congress_widget_title == '') ? 'Konferencje' : $pwe_congress_widget_title;
    $pwe_pwe_congress_widget_button_link = ($pwe_pwe_congress_widget_button_link == '') ? '/wydarzenia/' : $pwe_pwe_congress_widget_button_link;
    $pwe_congress_widget_button = ($pwe_congress_widget_button == '') ? 'Dowiedz się więcej' : $pwe_congress_widget_button;
} else {
    $pwe_congress_widget_title = ($pwe_congress_widget_title == '') ? 'Conference' : $pwe_congress_widget_title;
    $pwe_pwe_congress_widget_button_link = ($pwe_pwe_congress_widget_button_link == '') ? '/en/conferences/' : $pwe_pwe_congress_widget_button_link;
    $pwe_congress_widget_button = ($pwe_congress_widget_button == '') ? 'Find out more' : $pwe_congress_widget_button;
}

$output .= '
    <style>
        .header-conference {
            position: absolute;
            top: 36px;
            right: 36px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            gap: 0;
        }
        .header-conference-items {
            padding: 18px;
            gap: 18px;
            display: flex;
            justify-content: center;
            flex-direction: column;
            align-items: end;
        }
        .header-conference-item {
            width: '. $pwe_congress_widget_buttons_width .';
        }
        .header-conference-item img {
            width; 100%;
            border-radius: 10px;
        }
        .header-conference-title,
        .header-conference-caption {
            align-self: center;
        }
        .header-conference-caption,
        .header-conference-item {
            transition: .3s ease;
        }
        .header-conference-caption:hover,
        .header-conference-item:hover {
            transform: scale(1.05);
        }
        .header-conference-title h2,
        .header-conference-caption h2 {
            color: white;
            margin: 0;
            font-size: 22px;
        }
        .header-conference-caption h2 {
            border: 2px solid white;
            border-radius: 25px;
            padding: 5px 10px;
            font-size: 16px;
        }

        @media (max-width:1200px) {
            .header-conference {
                position: relative;
                top: 0;
                right: 0;
                gap: 0;
                padding-bottom: 36px; 
            }
            .header-conference-items {
                flex-direction: row !important;
            }
        }
        @media (max-width:1200px) {
            .header-conference {
                position: relative;
                top: 0;
                right: 0;
                gap: 0;
                padding-bottom: 36px; 
            }
            .header-conference-items {
                flex-direction: row;
                flex-wrap: wrap;
            }
        }
    </style>';

    $pwe_congress_widget_items_urldecode = urldecode($pwe_congress_widget_items);
    $pwe_congress_widget_items_json = json_decode($pwe_congress_widget_items_urldecode, true);
    if (is_array($pwe_congress_widget_items_json) && !empty($pwe_congress_widget_items_json[0]['congress_item_image'])) {

        $output .= '
        <div class="header-conference">
            <div class="header-conference-title">
                <h2 style="text-transform: uppercase;">'. $pwe_congress_widget_title .'</h2>
            </div>
            <div class="header-conference-items">';
            
                foreach ($pwe_congress_widget_items_json as $item) {
                    $congress_item_image = $item["congress_item_image"];
                    $congress_item_link = $item["congress_item_link"];

                    $congress_image_url = wp_get_attachment_url($congress_item_image);

                    $output .= '
                        <div class="header-conference-item">
                            <a href="'. $congress_item_link .'">
                                <img src="'. $congress_image_url .'" alt="congress button">
                            </a>
                        </div>'; 
                }  
                
            $output .= '    
            </div>
            <div class="header-conference-caption">
                <a href="'. $pwe_congress_widget_button_link .'">
                    <h2 style="text-transform: uppercase;">'. $pwe_congress_widget_button .'</h2>
                </a>
            </div>
        </div>';
    }

return $output;
?>