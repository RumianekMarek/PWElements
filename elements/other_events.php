<?php

/**
 * Class PWElementOtherEvents
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementOtherEvents extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }


    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Slider type', 'pwe_element'),
                'param_name' => 'other_events_slider_type',
                'save_always' => true,
                'std' => 'slick',
                'value' => array(
                    'Slick Slider' => 'slick',
                    'Swiper.js' => 'swiper',
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOtherEvents',
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Presets', 'pwe_element'),
                'param_name' => 'other_events_preset',
                'save_always' => true,
                'std'       => 'preset_1',
                'value' => array(
                    'Preset 1 (with descriptions)' => 'preset_1',
                    'Preset 2 (with names)' => 'preset_2',
                    'Preset 3 (with background)' => 'preset_3',
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOtherEvents',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Full background version', 'pwe_element'),
                'param_name' => 'full_background_version',
                'value' => array(__('Yes', 'pwe_element') => 'true'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'other_events_preset',
                    'value' => array('preset_3'),
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom items style', 'pwe_element'),
                'param_name' => 'other_events_style',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOtherEvents',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Show strip', 'pwe_element'),
                'param_name' => 'other_show_strip',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOtherEvents',
                ),
            ),
            array(
                'type' => 'param_group',
                'group' => 'PWE Element',
                'param_name' => 'other_events_items',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOtherEvents',
                ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Domain (domain.pl)', 'pwe_element'),
                        'param_name' => 'other_events_domain',
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textarea_raw_html',
                        'heading' => __('Text', 'pwe_element'),
                        'param_name' => 'other_events_text',
                        'param_holder_class' => 'backend-textarea-raw-html',
                        'save_always' => true,
                    ),
                ),
            ),
        );
        
        $swiper_fields = array(
            array(
                'type' => 'checkbox',
                'group' => 'Swiper Settings',
                'heading' => __('Show arrows (navigation)', 'pwe_element'),
                'param_name' => 'swiper_show_arrows',
                'value' => array(__('Yes', 'pwe_element') => 'true'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'other_events_slider_type',
                    'value' => array('swiper'),
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Swiper Settings',
                'heading' => __('Show scrollbar', 'pwe_element'),
                'param_name' => 'swiper_show_scrollbar',
                'value' => array(__('Yes', 'pwe_element') => 'true'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'other_events_slider_type',
                    'value' => array('swiper'),
                ),
            ),
        );

        return array_merge($element_output, $swiper_fields);
    }

    public static function outputOtherEventsSwiper($atts) {

        extract( shortcode_atts( array(
            'other_events_preset' => '',
            'other_events_style' => '',
            'other_events_items' => '',
            'other_show_strip' => '',
            'swiper_show_arrows' => '',
            'swiper_show_scrollbar' => '',
            'full_background_version' => '',
        ), $atts ));

        $other_events_items_urldecode = urldecode($other_events_items);
        $other_events_items_json = json_decode($other_events_items_urldecode, true);

        $is_empty = true;

        if (!empty($other_events_items_json[0]["other_events_domain"])) {
            foreach ($other_events_items_json as $other_events_item) {
                if (!empty($other_events_item['other_events_domain'])) {
                    $is_empty = false;
                    break;
                }
            }
        }

        // Get current domain
        $current_domain = do_shortcode('[trade_fair_domainadress]');

        // Fair dates
        $trade_fair_start = do_shortcode('[trade_fair_datetotimer]');
        $trade_fair_end = do_shortcode('[trade_fair_enddata]');

        // Converting dates to timestamps
        $trade_fair_start_timestamp = strtotime($trade_fair_start);
        $trade_fair_end_timestamp = strtotime($trade_fair_end);

        // Get JSON
        $fairs_json = PWECommonFunctions::json_fairs();

        // Check if there is any data entered into the element
        if (empty($other_events_items_json[0]["other_events_domain"])) {
            $other_events_items_json = [];

            foreach ($fairs_json as $fair) {
                // Getting start and end dates
                $date_start = isset($fair['date_start']) ? strtotime($fair['date_start']) : null;
                $date_end = isset($fair['date_end']) ? strtotime($fair['date_end']) : null;

                // Checking if the date is in the range
                if ($date_start && $date_end) {
                    if ((($date_start >= $trade_fair_start_timestamp && $date_start <= $trade_fair_end_timestamp) ||
                        ($date_end >= $trade_fair_start_timestamp && $date_end <= $trade_fair_end_timestamp)) &&
                        strpos($fair['domain'], $current_domain) === false) {
                        $other_events_items_json[] = [
                            "other_events_domain" => $fair["domain"],
                            "other_events_text" => PWECommonFunctions::languageChecker($fair["desc_pl"], $fair["desc_en"])
                        ];
                    }
                }
            }
        }

        if (!empty($other_events_items_json[0])) {

            $output = '
            <style>
                :root {
                --swiper-navigation-sides-offset: -36px;
                --swiper-scrollbar-size: 8px;
                --swiper-scrollbar-bottom: -12px;
                }
                .pwelement_'. self::$rnd_id .' .swiper {
                    width: 100%;
                    padding: 10px;
                }

                .pwelement_'. self::$rnd_id .' .swiper-wrapper {
                    overflow: visible !important; /* UWAGA: kluczowe */
                }

                .pwelement_'. self::$rnd_id .' .swiper-slide {
                    flex-shrink: 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__wrapper {
                    display: flex;
                    flex-direction: column;
                    gap: 36px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__heading h4 {
                    margin: 0 auto;
                    text-align: center;
                    text-transform: uppercase;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    text-align: center;
                    align-items: center;
                    gap: 6px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo {
                    height: 80px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic img {
                    max-width: 140px;
                    height: 100%;
                    object-fit: contain;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers-block {
                    display: flex;
                    flex-direction: column;
                    gap: 6px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-number {
                    font-weight: 700;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-name {
                    font-size: 12px;
                    font-weight: 500;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                    line-height: 1.3;
                }
            </style>';

            if ($other_events_preset == 'preset_1') {
                $slides_to_show = 2;

                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item a {
                        display: flex;
                        gap: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        text-align: center;
                        align-items: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic img {
                        max-width: 100px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers-block {
                        display: flex;
                        flex-direction: column;
                        gap: 6px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-number {
                        font-weight: 700;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-name {
                        font-size: 12px;
                        font-weight: 500;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                        margin: 0;
                    }
                    @media(max-width: 960px) {
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                            flex-direction: column;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                            justify-content: space-evenly;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                            font-size: 14px;
                        }
                    }
                    @media(max-width: 550px) {
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__items {
                            flex-direction: column;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                            width: 100%;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                            flex-direction: column;
                            justify-content: center;
                        }
                    }
                </style>';
            } else if ($other_events_preset == 'preset_3') {
                $slides_to_show = 4;

                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                        padding: 16px;
                        box-shadow: 2px 2px 5px #cccccc;
                        border-radius: 18px;
                        transition: .3s ease;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo {
                        height: 180px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo img{
                        object-fit: cover;
                        height: 160px;
                        border-radius: 12px;
                        width: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text {
                        text-align: left;
                        font-weight: 600;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item a {
                        display: flex;
                        flex-direction: column;
                        gap: 18px;
                        height: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item:hover {
                        transform: scale(0.95);
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text,
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                        font-weight: 500;
                        text-align: left;
                        margin: 0;
                        text-transform: uppercase;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                        align-items: flex-start !important;
                        text-align: left !important;
                        justify-content: space-between;
                        height: 60%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers-block {
                        width: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers {
                        padding: 4px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers:nth-child(odd){
                        background: #F4F4F4;
                    }
                    .pwelement_'. self::$rnd_id .' .slick-track {
                        display: flex !important;
                        align-items: stretch;
                    }
                </style>';

                if ($full_background_version === 'true') {
                    $output .= '
                    <style>
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                            overflow: hidden;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo {
                            height: 160px;
                            overflow: hidden;
                            margin: -16px -16px 0;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo img {
                            border-radius: 0;
                        }
                    </style>';
                }
            } else {
                $slides_to_show = 4;

                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                        padding: 18px;
                        box-shadow: 2px 2px 5px #cccccc;
                        border-radius: 18px;
                        transition: .3s ease;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item a {
                        display: flex;
                        flex-direction: column;
                        gap: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item:hover {
                        transform: scale(0.95);
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text,
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                        font-weight: 500;
                        text-align: center;
                        margin: 0;
                        text-transform: uppercase;
                    }
                </style>';
            }

            if ($swiper_show_scrollbar === 'true' && $swiper_show_arrows === 'true') { 

                $output .= '
                <style>
                    .swiper-scrollbar.swiper-scrollbar-horizontal {
                        position: inherit;
                    }
                    .swiper-button-prev, .swiper-button-next {
                        position: inherit;
                        background: var(--accent-color);
                        color: white;
                        padding: 6px 24px;
                        border-radius: 36px;
                        min-width: 100px;
                    }
                    .swiper-button-next:after, .swiper-button-prev:after {
                        font-size: 22px;
                    }
                    .swiper-navigation-container {
                        display: flex;
                        gap: 36px;
                    }
                    .swiper-arrows-container {
                        display: flex;
                        gap: 18px;
                    }
                    .swiper-scrollbar-drag:before {
                        content: "";
                    }
                </style>';
            }

            $output .= '
            <div id="pweOtherEvents" class="pwe-other-events">
                <div class="pwe-other-events__wrapper">
                    <div class="pwe-other-events__heading">
                        <h4>'. PWECommonFunctions::languageChecker('Inne wydarzenia podczas targów', 'Other events during the fair') .'</h4>
                    </div>
                    <div class="swiper pwe-other-events__items pwe-slides">
                        <div class="swiper-wrapper">';

                            // Generating HTML
                            foreach ($other_events_items_json as $other_events_item) {
                                $other_events_domain = $other_events_item["other_events_domain"];
                                $other_events_text = $other_events_item["other_events_text"];
                                $other_events_text_content = $is_empty ? $other_events_text : PWECommonFunctions::decode_clean_content($other_events_text);

                                $other_events_text_content = !empty($other_events_text_content) ? $other_events_text_content : '<p>[pwe_desc_' . PWECommonFunctions::languageChecker('pl', 'en') . ' domain="' . $other_events_domain . '"]</p>';
                                if (strpos($other_events_domain, $current_domain) === false) {
                                    $output .= '
                                        <div class="pwe-other-events__item swiper-slide" style="'. $other_events_style .'">
                                            <a href="https://'. $other_events_domain .''. PWECommonFunctions::languageChecker('/', '/en/') .'" target="_blank">';
                                            if ($other_events_preset == 'preset_3') {
                                                $output .= '
                                                <div class="pwe-other-events__item-logo">
                                                    <img data-no-lazy="1" src="https://'. $other_events_domain .'/doc/kafelek.jpg"/>
                                                </div>
                                                <div class="pwe-other-events__item-statistic">
                                                    <div class="pwe-other-events__item-text">'. $other_events_text_content .'</div>
                                                    <div class="pwe-other-events__item-statistic-numbers-block">
                                                        <div class="pwe-other-events__item-statistic-numbers">
                                                            <div class="pwe-other-events__item-statistic-number">[pwe_visitors domain="'. $other_events_domain .'"]</div>
                                                            <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('odwiedzających', 'visitors') .'</div>
                                                        </div>
                                                        <div class="pwe-other-events__item-statistic-numbers">
                                                            <div class="pwe-other-events__item-statistic-number">[pwe_exhibitors domain="'. $other_events_domain .'"]</div>
                                                            <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('wystawców', 'exhibitors') .'</div>
                                                        </div>
                                                        <div class="pwe-other-events__item-statistic-numbers">
                                                            <div class="pwe-other-events__item-statistic-number">[pwe_area domain="'. $other_events_domain .'"] m2</div>
                                                            <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('powierzchni<br>wystawienniczej', 'exhibition space') .'</div>
                                                        </div>
                                                    </div>
                                                </div>';
                                            }else {
                                                $output .= '
                                                <div class="pwe-other-events__item-statistic">
                                                    <div class="pwe-other-events__item-logo">
                                                        <img data-no-lazy="1" src="https://'. $other_events_domain .'/doc/logo-color.webp"/>
                                                    </div>
                                                    <div class="pwe-other-events__item-statistic-numbers-block">
                                                        <div class="pwe-other-events__item-statistic-numbers">
                                                            <div class="pwe-other-events__item-statistic-number">[pwe_visitors domain="'. $other_events_domain .'"]</div>
                                                            <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('odwiedzających', 'visitors') .'</div>
                                                        </div>
                                                        <div class="pwe-other-events__item-statistic-numbers">
                                                            <div class="pwe-other-events__item-statistic-number">[pwe_exhibitors domain="'. $other_events_domain .'"]</div>
                                                            <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('wystawców', 'exhibitors') .'</div>
                                                        </div>
                                                        <div class="pwe-other-events__item-statistic-numbers">
                                                            <div class="pwe-other-events__item-statistic-number">[pwe_area domain="'. $other_events_domain .'"] m2</div>
                                                            <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('powierzchni<br>wystawienniczej', 'exhibition space') .'</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="pwe-other-events__item-text">'. $other_events_text_content .'</div>';
                                            }
                                            $output .= '
                                            </a>
                                        </div>
                                    ';
                                }
                            }

                        $output .= '
                        </div>';
                        $output .= '</div>';
                        if ($swiper_show_scrollbar === 'true' && $swiper_show_arrows === 'true') { $output .= '<div class="swiper-navigation-container">'; }
                            if ($swiper_show_scrollbar === 'true') { $output .= '<div class="swiper-scrollbar"></div>'; }
                            if ($swiper_show_arrows === 'true') { $output .= '<div class="swiper-arrows-container"><div class="swiper-button-prev"></div><div class="swiper-button-next"></div></div>'; }
                        if ($swiper_show_scrollbar === 'true' && $swiper_show_arrows === 'true') { $output .= '</div>'; }

                    $other_events_options[] = array(
                        "other_events_preset" => $other_events_preset,
                    );
                    $other_events_arrows_display = 'false';

                    $output .= '
                </div>
            </div>';

            $output .= '
            <script>
                jQuery(function ($) {

                    // Function to set equal height
                    function setEqualHeight() {
                        let maxHeight = 0;

                        // Reset the heights before calculations
                        $(".pwe-other-events__item").css("height", "auto");

                        // Calculate the maximum height
                        $(".pwe-other-events__item").each(function() {
                            const thisHeight = $(this).outerHeight();
                            if (thisHeight > maxHeight) {
                                maxHeight = thisHeight;
                            }
                        });

                        // Set the same height for all
                        $(".pwe-other-events__item").css("minHeight", maxHeight);
                    }

                    // Call the function after loading the slider
                    $(".pwe-other-events__items").on("init", function() {
                        setEqualHeight();
                    });

                    // Call the function when changing the slide
                    $(".pwe-other-events__items").on("afterChange", function() {
                        setEqualHeight();
                    });

                    // Call the function at the beginning
                    setEqualHeight();
                });
            </script>';

            $slides_count = count($other_events_items_json);
            $loop_enabled = $slides_count > $slides_to_show ? 'true' : 'false';

            if ($loop_enabled === 'false') {
                $output .= '<style>
                    .pwelement_'. self::$rnd_id .' .swiper-wrapper {
                        justify-content: center;
                    }
                </style>';
            }

            $output .= '<script>
                    document.addEventListener("DOMContentLoaded", function () {
                        const swiper = new Swiper(".pwelement_'. self::$rnd_id .' .swiper", {
                            slidesPerView: '. $slides_to_show .',
                            spaceBetween: 20,
                            loop: ' . $loop_enabled . ',
                            grabCursor: true,
                            autoplay: {
                                delay: 3000,
                                disableOnInteraction: false,
                                pauseOnMouseEnter: true,
                            },';

                if ($swiper_show_arrows === 'true') {
                    $output .= '
                            navigation: {
                                nextEl: ".swiper-button-next",
                                prevEl: ".swiper-button-prev"
                            },';
                }

                if ($swiper_show_scrollbar === 'true') {
                    $output .= '
                            scrollbar: {
                                el: ".swiper-scrollbar",
                                draggable: false,
                            },';
                }

                $output .= '
                            pagination: {
                                el: ".swiper-pagination",
                                clickable: true
                            },
                            breakpoints: {
                                320: { slidesPerView: 1 },
                                768: { slidesPerView: 2 },
                                1024: { slidesPerView: '. $slides_to_show .' }
                            }
                        });
                    });
            </script>';

        } else { $output = '<style>.row-container:has(.pwelement_'. self::$rnd_id .') {display: none !important;}</style>'; }

        return $output;
    }

    public static function output($atts) {

        extract( shortcode_atts( array(
            'other_events_preset' => '',
            'other_events_style' => '',
            'other_events_items' => '',
            'other_show_strip' => '',
            'other_events_slider_type' => 'slick',
            'full_background_version' => '',
        ), $atts ));

        if ($other_events_slider_type === 'swiper') {
            return self::outputOtherEventsSwiper($atts);
        }

        $other_events_items_urldecode = urldecode($other_events_items);
        $other_events_items_json = json_decode($other_events_items_urldecode, true);

        $is_empty = true;

        if (!empty($other_events_items_json[0]["other_events_domain"])) {
            foreach ($other_events_items_json as $other_events_item) {
                if (!empty($other_events_item['other_events_domain'])) {
                    $is_empty = false;
                    break;
                }
            }
        }

        // Get current domain
        $current_domain = do_shortcode('[trade_fair_domainadress]');

        // Fair dates
        $trade_fair_start = do_shortcode('[trade_fair_datetotimer]');
        $trade_fair_end = do_shortcode('[trade_fair_enddata]');

        // Converting dates to timestamps
        $trade_fair_start_timestamp = strtotime($trade_fair_start);
        $trade_fair_end_timestamp = strtotime($trade_fair_end);

        // Get JSON
        $fairs_json = PWECommonFunctions::json_fairs();

        // Check if there is any data entered into the element
        if (empty($other_events_items_json[0]["other_events_domain"])) {
            $other_events_items_json = [];

            foreach ($fairs_json as $fair) {
                // Getting start and end dates
                $date_start = isset($fair['date_start']) ? strtotime($fair['date_start']) : null;
                $date_end = isset($fair['date_end']) ? strtotime($fair['date_end']) : null;

                // Checking if the date is in the range
                if ($date_start && $date_end) {
                    if ((($date_start >= $trade_fair_start_timestamp && $date_start <= $trade_fair_end_timestamp) ||
                        ($date_end >= $trade_fair_start_timestamp && $date_end <= $trade_fair_end_timestamp)) &&
                        strpos($fair['domain'], $current_domain) === false) {
                        $other_events_items_json[] = [
                            "other_events_domain" => $fair["domain"],
                            "other_events_text" => PWECommonFunctions::languageChecker($fair["desc_pl"], $fair["desc_en"])
                        ];
                    }
                }
            }
        }

        if (!empty($other_events_items_json[0])) {

            $output = '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-other-events__wrapper {
                    display: flex;
                    flex-direction: column;
                    gap: 36px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__heading h4 {
                    margin: 0 auto;
                    text-align: center;
                    text-transform: uppercase;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                    margin: 10px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    text-align: center;
                    align-items: center;
                    gap: 6px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo {
                    height: 80px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic img {
                    max-width: 140px;
                    height: 100%;
                    object-fit: contain;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers-block {
                    display: flex;
                    flex-direction: column;
                    gap: 6px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-number {
                    font-weight: 700;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-name {
                    font-size: 12px;
                    font-weight: 500;
                }
                .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                    line-height: 1.3;
                }
            </style>';

            if ($other_events_preset == 'preset_1') {
                $slides_to_show = 2;

                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item a {
                        display: flex;
                        gap: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        text-align: center;
                        align-items: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic img {
                        max-width: 100px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers-block {
                        display: flex;
                        flex-direction: column;
                        gap: 6px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-number {
                        font-weight: 700;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-name {
                        font-size: 12px;
                        font-weight: 500;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                        margin: 0;
                    }
                    @media(max-width: 960px) {
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                            flex-direction: column;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                            justify-content: space-evenly;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                            font-size: 14px;
                        }
                    }
                    @media(max-width: 550px) {
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__items {
                            flex-direction: column;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                            width: 100%;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                            flex-direction: column;
                            justify-content: center;
                        }
                    }
                </style>';
            } else if ($other_events_preset == 'preset_3') {
                $slides_to_show = 4;

                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                        padding: 16px;
                        box-shadow: 2px 2px 5px #cccccc;
                        border-radius: 18px;
                        transition: .3s ease;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo {
                        height: 180px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-logo img{
                        object-fit: cover;
                        height: 160px;
                        border-radius: 12px;
                        width: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text {
                        text-align: left;
                        font-weight: 600;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item a {
                        display: flex;
                        flex-direction: column;
                        gap: 18px;
                        height: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item:hover {
                        transform: scale(0.95);
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text,
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                        font-weight: 500;
                        text-align: left;
                        margin: 0;
                        text-transform: uppercase;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic {
                        align-items: flex-start !important;
                        text-align: left !important;
                        justify-content: space-between;
                        height: 60%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers-block {
                        width: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers {
                        padding: 4px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-statistic-numbers:nth-child(odd){
                        background: #F4F4F4;
                    }
                    .pwelement_'. self::$rnd_id .' .slick-track {
                        display: flex !important;
                        align-items: stretch;
                    }
                </style>';
            } else {
                $slides_to_show = 4;

                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item {
                        padding: 18px;
                        box-shadow: 2px 2px 5px #cccccc;
                        border-radius: 18px;
                        transition: .3s ease;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item a {
                        display: flex;
                        flex-direction: column;
                        gap: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item:hover {
                        transform: scale(0.95);
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text,
                    .pwelement_'. self::$rnd_id .' .pwe-other-events__item-text p {
                        font-weight: 500;
                        text-align: center;
                        margin: 0;
                        text-transform: uppercase;
                    }
                </style>';
            }



            $output .= '
            <div id="pweOtherEvents" class="pwe-other-events">
                <div class="pwe-other-events__wrapper">
                    <div class="pwe-other-events__heading">
                        <h4>'. PWECommonFunctions::languageChecker('Inne wydarzenia podczas targów', 'Other events during the fair') .'</h4>
                    </div>
                    <div class="pwe-other-events__items pwe-slides">';

                    // Generating HTML
                    foreach ($other_events_items_json as $other_events_item) {
                        $other_events_domain = $other_events_item["other_events_domain"];
                        $other_events_text = $other_events_item["other_events_text"];
                        $other_events_text_content = $is_empty ? $other_events_text : PWECommonFunctions::decode_clean_content($other_events_text);

                        $other_events_text_content = !empty($other_events_text_content) ? $other_events_text_content : '<p>[pwe_desc_' . PWECommonFunctions::languageChecker('pl', 'en') . ' domain="' . $other_events_domain . '"]</p>';
                        if (strpos($other_events_domain, $current_domain) === false) {
                            $output .= '
                                <div class="pwe-other-events__item" style="'. $other_events_style .'">
                                    <a href="https://'. $other_events_domain .''. PWECommonFunctions::languageChecker('/', '/en/') .'" target="_blank">';
                                    if ($other_events_preset == 'preset_3') {
                                        $output .= '
                                        <div class="pwe-other-events__item-logo">
                                            <img data-no-lazy="1" src="https://'. $other_events_domain .'/doc/kafelek.jpg"/>
                                            </div>
                                            <div class="pwe-other-events__item-statistic">
                                            <div class="pwe-other-events__item-text">'. $other_events_text_content .'</div>
                                            <div class="pwe-other-events__item-statistic-numbers-block">
                                                <div class="pwe-other-events__item-statistic-numbers">
                                                    <div class="pwe-other-events__item-statistic-number">[pwe_visitors domain="'. $other_events_domain .'"]</div>
                                                    <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('odwiedzających', 'visitors') .'</div>
                                                </div>
                                                <div class="pwe-other-events__item-statistic-numbers">
                                                    <div class="pwe-other-events__item-statistic-number">[pwe_exhibitors domain="'. $other_events_domain .'"]</div>
                                                    <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('wystawców', 'exhibitors') .'</div>
                                                </div>
                                                <div class="pwe-other-events__item-statistic-numbers">
                                                    <div class="pwe-other-events__item-statistic-number">[pwe_area domain="'. $other_events_domain .'"] m2</div>
                                                    <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('powierzchni<br>wystawienniczej', 'exhibition space') .'</div>
                                                </div>
                                            </div>
                                        </div>';
                                    }else {
                                        $output .= '
                                        <div class="pwe-other-events__item-statistic">
                                            <div class="pwe-other-events__item-logo">
                                                <img data-no-lazy="1" src="https://'. $other_events_domain .'/doc/logo-color.webp"/>
                                            </div>
                                            <div class="pwe-other-events__item-statistic-numbers-block">
                                                <div class="pwe-other-events__item-statistic-numbers">
                                                    <div class="pwe-other-events__item-statistic-number">[pwe_visitors domain="'. $other_events_domain .'"]</div>
                                                    <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('odwiedzających', 'visitors') .'</div>
                                                </div>
                                                <div class="pwe-other-events__item-statistic-numbers">
                                                    <div class="pwe-other-events__item-statistic-number">[pwe_exhibitors domain="'. $other_events_domain .'"]</div>
                                                    <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('wystawców', 'exhibitors') .'</div>
                                                </div>
                                                <div class="pwe-other-events__item-statistic-numbers">
                                                    <div class="pwe-other-events__item-statistic-number">[pwe_area domain="'. $other_events_domain .'"] m2</div>
                                                    <div class="pwe-other-events__item-statistic-name">'. PWECommonFunctions::languageChecker('powierzchni<br>wystawienniczej', 'exhibition space') .'</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pwe-other-events__item-text">'. $other_events_text_content .'</div>';
                                    }
                                    $output .= '
                                    </a>
                                </div>
                            ';
                        }
                    }

                    $output .= '
                    </div>';

                    $other_events_options[] = array(
                        "other_events_preset" => $other_events_preset,
                    );
                    $other_events_arrows_display = 'false';

                    include_once plugin_dir_path(__FILE__) . '/../scripts/slider.php';
                    $output .= PWESliderScripts::sliderScripts('other-events', '.pwelement_'. self::$rnd_id, $other_events_dots_display = 'true', $other_events_arrows_display, $slides_to_show, $other_events_options);


                    if($other_show_strip){
                        $event_count = count($other_events_items_json);

                        $slider_id = 'pwelement_' . self::$rnd_id . ' .pwe-slides';
                        $output .= '
                        <input type="range" id="test" class="slider-range_' . self::$rnd_id . '" min="0" step="1">
                        <script>
                        jQuery(document).ready(function ($) {
                            const $slider = $(".'.$slider_id.'");
                            const $range = $(".slider-range_' . self::$rnd_id . '");

                            $slider.on("init", function (event, slick) {
                                $range.attr("max", slick.slideCount - 1);
                                $range.val(slick.currentSlide);
                            });
                            function updateSliderBackground($el) {
                                const val = ($el.val() - $el.attr("min")) / ($el.attr("max") - $el.attr("min"));
                                const percent = val * 100;
                                $el.css("background", `linear-gradient(to right, black 0%, black ${percent}%, #ccc ${percent}%, #ccc 100%)`);
                            }
                            $slider.on("init", function (event, slick) {
                                $range.attr("max", slick.slideCount - 1);
                                $range.val(slick.currentSlide);
                                updateSliderBackground($range);
                            });

                            $range.on("input", function () {
                                const slideIndex = parseInt($(this).val(), 10);
                                $slider.slick("slickGoTo", slideIndex);
                                updateSliderBackground($range);
                            });

                            $slider.on("afterChange", function (event, slick, currentSlide) {
                                $range.val(currentSlide);
                                updateSliderBackground($range);
                            });
                        });
                        </script>
                        <style>

                            .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . ' {
                                width: 100%;
                                margin-top: 16px;
                                height: 10px;
                                border-radius: 5px;
                                background: black;
                                appearance: none;
                                -webkit-appearance: none;
                                overflow: hidden;
                                cursor: pointer;
                                transition: background 0.3s ease;
                            }
                            .pwelement_'. self::$rnd_id .' .slick-dots {
                                visibility: hidden;
                            }
                            .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . '::-webkit-slider-thumb {
                                appearance: none;
                                -webkit-appearance: none;
                                height: 0; /* lub 1px jeśli musisz */
                                width: 0;
                                background: transparent;
                                box-shadow: none;
                            }
                            .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . '::-moz-range-thumb {
                                height: 0;
                                width: 0;
                                background: transparent;
                                border: none;
                            }

                            .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . '::-ms-thumb {
                                height: 0;
                                width: 0;
                                background: transparent;
                                border: none;
                            }
                            .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . '::-webkit-slider-thumb:hover {
                                background: black !important;
                            }
                            .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . ' {
                                display:none;
                            }


                        </style>';
                        if ($event_count === 1 || $event_count === 2) {
                            $output .='
                                <style>
                                     @media(max-width:470px){
                                        .pwelement_'. self::$rnd_id .'  .pwe-other-events__items {
                                            margin-bottom: 0 !important;
                                        }
                                        .pwelement_'. self::$rnd_id .'  .slick-dots {
                                            display:none !important;
                                        }
                                        .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . ' {
                                            display:block !important;
                                        }
                                    }
                                </style>
                            ';
                        } else if($event_count>4 || $event_count===4){
                            $output .='
                            <style>
                                 @media(max-width:960px){
                                    .pwelement_'. self::$rnd_id .'  .pwe-other-events__items {
                                        margin-bottom: 0 !important;
                                    }
                                    .pwelement_'. self::$rnd_id .'  .slick-dots {
                                        display:none !important;
                                    }
                                    .pwelement_'. self::$rnd_id .' .slider-range_' . self::$rnd_id . ' {
                                        display:block !important;
                                    }
                                }
                            </style>
                            ';
                        }
                    }
                    $output .= '
                </div>
            </div>';

            $output .= '
            <script>
                jQuery(function ($) {

                    // Function to set equal height
                    function setEqualHeight() {
                        let maxHeight = 0;

                        // Reset the heights before calculations
                        $(".pwe-other-events__item").css("height", "auto");

                        // Calculate the maximum height
                        $(".pwe-other-events__item").each(function() {
                            const thisHeight = $(this).outerHeight();
                            if (thisHeight > maxHeight) {
                                maxHeight = thisHeight;
                            }
                        });

                        // Set the same height for all
                        $(".pwe-other-events__item").css("minHeight", maxHeight);
                    }

                    // Call the function after loading the slider
                    $(".pwe-other-events__items").on("init", function() {
                        setEqualHeight();
                    });

                    // Call the function when changing the slide
                    $(".pwe-other-events__items").on("afterChange", function() {
                        setEqualHeight();
                    });

                    // Call the function at the beginning
                    setEqualHeight();
                });
            </script>';

        } else { $output = '<style>.row-container:has(.pwelement_'. self::$rnd_id .') {display: none !important;}</style>'; }

        return $output;
    }
}