<?php

if (get_locale() == 'pl_PL') {
    $pwe_congress_widget_title = ($pwe_congress_widget_title == '') ? 'Konferencje' : $pwe_congress_widget_title;
    $pwe_congress_widget_button_link = ($pwe_congress_widget_button_link == '') ? '/rejestracja/' : $pwe_congress_widget_button_link;
    $pwe_congress_widget_button = ($pwe_congress_widget_button == '') ? 'WEŹ UDZIAŁ' : $pwe_congress_widget_button;
} else {
    $pwe_congress_widget_title = ($pwe_congress_widget_title == '') ? 'Conference' : $pwe_congress_widget_title;
    $pwe_congress_widget_button_link = ($pwe_congress_widget_button_link == '') ? '/en/registration/' : $pwe_congress_widget_button_link;
    $pwe_congress_widget_button = ($pwe_congress_widget_button == '') ? 'TAKE PART' : $pwe_congress_widget_button;
}

$pwe_congress_widget_buttons_width = ($pwe_congress_widget_buttons_width == '') ? '200px' : $pwe_congress_widget_buttons_width;
$pwe_congress_widget_color = $pwe_congress_widget_color == '' ? $btn_color : $pwe_congress_widget_color;

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
            opacity: 0;
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
            background: white;
            border-radius: 22px;
            border: 2px solid '. $pwe_congress_widget_color .';
        }
        .header-conference-item a {
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center; 
            padding: 0 0 4px;
        }
        .header-conference-item img {
            width: 150px;
        }
        .header-conference-caption {
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            color: '. $pwe_congress_widget_color .';
        }
        .header-conference-title,
        .header-conference-button {
            align-self: center;
        }
        .header-conference-button,
        .header-conference-button h2,
        .header-conference-item {
            transition: .3s ease;
        }
        .header-conference-item:hover {
            transform: scale(1.05);
        }
        .header-conference-title h2,
        .header-conference-button h2 {
            margin: 0;
        }
        .header-conference-title h2 {
            color: '. $text_color .';
            text-shadow: 2px 2px '. $text_shadow .';
            font-size: 20px;
        }
        .header-conference-button {
            background-color: '. $btn_color .';
            box-shadow: '. $btn_shadow_color .';
            border: '. $btn_color .'; 
            border-radius: 0 !important;
            padding: 5px 10px;
        }
        .header-conference-button h2 {
            font-size: 18px;
            color: '. $btn_text_color .';
        }
        .header-conference-button:hover {
            background-color: #ffffff !important;
            border: 1px solid #000000 !important;
            box-shadow: 9px 9px 0px -5px '. $btn_color .';
            h2 {
                color: #000000 !important;
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

    $target_blank_form = (strpos($pwe_congress_widget_button_link, 'http') !== false) ? 'target="blank"' : '';

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
                    $congress_item_caption = $item["congress_item_caption"];

                    $congress_image_url = wp_get_attachment_url($congress_item_image);
                    $target_blank_congress = (strpos($congress_item_link, 'http') !== false) ? 'target="blank"' : '';

                    if (get_locale() == 'pl_PL') {
                        $congress_item_caption = ($congress_item_caption == '') ? 'Dowiedz się więcej' : $congress_item_caption;
                        $congress_item_link = ($congress_item_link == '') ? '/wydarzenia/' : $congress_item_link;
                    } else {
                        $congress_item_caption = ($congress_item_caption == '') ? 'Find out more' : $congress_item_caption;
                        $congress_item_link = ($congress_item_link == '') ? '/en/conferences/' : $congress_item_link;
                    }

                    $output .= '
                    <div class="header-conference-item">
                        <a href="'. $congress_item_link .'"'. $target_blank_congress .'>
                            <img src="'. $congress_image_url .'" alt="congress button">
                            <span class="header-conference-caption">'. $congress_item_caption .'</span>
                        </a>
                    </div>'; 
                }  
                
            $output .= '    
            </div>
            <div class="header-conference-button">
                <a href="'. $pwe_congress_widget_button_link .'"'. $target_blank_form .'>
                    <h2 style="text-transform: uppercase;">'. $pwe_congress_widget_button .'</h2>
                </a>
            </div>
        </div>';

        $output .= '
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const pweHeaderWidget = document.querySelector(".header-conference");
                    pweHeaderWidget.style.opacity = 1;
                    pweHeaderWidget.style.transition = "opacity 0.3s ease";
                });
            </script>';
    }

return $output;
?>