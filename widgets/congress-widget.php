<?php

$pwe_congress_widget_buttons_width = ($pwe_congress_widget_buttons_width == '') ? '200px' : $pwe_congress_widget_buttons_width;

if (get_locale() == 'pl_PL') {
    $pwe_congress_widget_title = ($pwe_congress_widget_title == '') ? 'Konferencje' : $pwe_congress_widget_title;
    $pwe_pwe_congress_widget_button_link = ($pwe_pwe_congress_widget_button_link == '') ? '/wydarzenia/' : $pwe_pwe_congress_widget_button_link;
    $pwe_congress_widget_button = ($pwe_congress_widget_button == '') ? 'WEŹ UDZIAŁ' : $pwe_congress_widget_button;
} else {
    $pwe_congress_widget_title = ($pwe_congress_widget_title == '') ? 'Conference' : $pwe_congress_widget_title;
    $pwe_pwe_congress_widget_button_link = ($pwe_pwe_congress_widget_button_link == '') ? '/en/conferences/' : $pwe_pwe_congress_widget_button_link;
    $pwe_congress_widget_button = ($pwe_congress_widget_button == '') ? 'TAKE PART' : $pwe_congress_widget_button;
}
$pwe_congress_widget_color = ($pwe_congress_widget_color == '') ? '' : $pwe_congress_widget_color;

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
        .header-conference-item {
            transition: .3s ease;
            
        }
        .header-conference-item:hover {
            transform: scale(1.05);
        }
        .header-conference-title h2,
        .header-conference-button h2 {
            color: white;
            margin: 0;
        }
        .header-conference-title h2 {
            text-shadow: 0 0 5px black;
            font-size: 18px;
        }
        .header-conference-button {
            border: unset !important;
            border-radius: 0 !important;
            background-color: '. $pwe_congress_widget_color .';
            padding: 5px 10px;
            box-shadow: 7px 7px 0px -5px white !important;
        }
        .header-conference-button h2 {
            font-size: 18px;
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
                    $congress_item_caption_off = $item["congress_item_caption_off"];

                    $congress_image_url = wp_get_attachment_url($congress_item_image);
                    $target_blank_congress = (strpos($congress_item_link, 'http') !== false) ? 'target="blank"' : '';

                    if (get_locale() == 'pl_PL') {
                        $congress_item_caption = ($congress_item_caption == '') ? 'Dowiedz się więcej' : $congress_item_caption;
                    } else {
                        $congress_item_caption = ($congress_item_caption == '') ? 'Find out more' : $congress_item_caption;
                    }

                    $output .= '
                        <div class="header-conference-item">
                            <a href="'. $congress_item_link .'"'. $target_blank_congress .'>
                                <img src="'. $congress_image_url .'" alt="congress button">';
                                if ($congress_item_caption_off != true) {
                                    $output .= '<span class="header-conference-caption">'. $congress_item_caption .'</span>';
                                }
                                $output .= '
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

        if ($pwe_congress_widget_color == '') {
            $output .= '
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const pweHeaderButton = document.querySelector("#pweBtnRegistration a");
                    if (pweHeaderButton) {
                        const pweHeaderButtonColor = window.getComputedStyle(pweHeaderButton).backgroundColor;
                
                        const conferenceItems = document.querySelectorAll(".header-conference-item");
                        conferenceItems.forEach(item => {
                            item.style.borderColor = pweHeaderButtonColor;
                        });
                
                        const conferenceCaptions = document.querySelectorAll(".header-conference-caption");
                        conferenceCaptions.forEach(caption => {
                            caption.style.color = pweHeaderButtonColor;
                        });
                
                        const conferenceButton = document.querySelector(".header-conference-button");
                        conferenceButton.style.backgroundColor = pweHeaderButtonColor;
                    }

                    const pweHeaderWidget = document.querySelector(".header-conference");
                    pweHeaderWidget.style.opacity = 1;
                    pweHeaderWidget.style.transition = "opacity 0.3s ease";
                });
            </script>
            ';  
        }
    }

return $output;
?>