<?php

class PWESwiperScripts {

        /**
         * Initializes the slider.
         */
        public function __construct() {}

        /**
         * Prepares and returns the scripts for the slider.
         */
        public static function swiperScripts($id = '', $pwe_element = '.pwelement', $dots_display = false, $arrows_display = false, $scrollbar_display = false, $options = null, $breakpoints_raw = '') {
            wp_enqueue_style('pwe-swiper-css', plugins_url('../assets/swiper-slider/swiper-bundle.min.css', __FILE__));
            wp_enqueue_script('pwe-swiper-js', plugins_url('../assets/swiper-slider/swiper-bundle.min.js', __FILE__), array('jquery'), null, true);

            include_once plugin_dir_path(__DIR__) . 'pwefunctions.php';
            $fair_colors = PWECommonFunctions::findPalletColorsStatic();

            $accent_color = ($fair_colors['Accent']) ? $fair_colors['Accent'] : '';
            foreach($fair_colors as $color_key => $color_value){
                if(strpos(strtolower($color_key), 'main2') !== false){
                    $main2_color = $color_value;
                }
            }

            $breakpoints = [];

            if (!empty($breakpoints_raw)) {
                $decoded = json_decode(urldecode($breakpoints_raw), true);
                if (is_array($decoded)) {
                    foreach ($decoded as $item) {
                        $width = intval($item['breakpoint_width'] ?? 0);
                        $slides = intval($item['breakpoint_slides'] ?? 1);
                        if ($width > 0 && $slides > 0) {
                            $breakpoints[$width] = $slides;
                        }
                    }
                    ksort($breakpoints);
                }
            }

            $output = '
            <style>

                :root {
                    --swiper-navigation-sides-offset: -24px;
                }

                ' . $pwe_element . ' {
                    opacity: 0;
                    visibility: hidden;
                    transition: opacity 0.6s ease;
                }
                ' . $pwe_element . '.pwe-visible {
                    opacity: 1;
                    visibility: visible;
                }

                ' . $pwe_element . ' .swiper {
                    width: 100%;
                    padding: 14px;
                    margin: 14px 0 0;
                }

                ' . $pwe_element . ' .swiper-wrapper {

                }

                ' . $pwe_element . ' .swiper-slide {
                    
                }

                @media(max-width: 400px) {

                    ' . $pwe_element . ' .swiper-navigation-container {
                        display: none !important;
                    }

                }

            ';
                if ($arrows_display === "true" && $scrollbar_display === "true") { 
                    $output .= '

                        ' . $pwe_element . ' .swiper-scrollbar.swiper-scrollbar-horizontal {
                            position: inherit;
                            height: 8px;
                        }
                        ' . $pwe_element . ' .swiper-button-prev, 
                        ' . $pwe_element . ' .swiper-button-next {
                            position: inherit;
                            background: var(--accent-color);
                            color: white;
                            padding: 6px 24px;
                            border-radius: 36px;
                            min-width: 100px;
                            margin: 0;
                        }
                        ' . $pwe_element . ' .swiper-button-next:after,
                            ' . $pwe_element . ' .swiper-button-prev:after {
                            font-size: 22px;
                        }
                        ' . $pwe_element . ' .swiper-navigation-container {
                            display: flex;
                            align-items: center;
                            padding: 12px;
                            gap: 36px;
                        }
                        ' . $pwe_element . ' .swiper-arrows-container {
                            display: flex;
                            gap: 18px;
                        }';
                } else if (empty($arrows_display) && $scrollbar_display === "true") {

                     $output .= '

                        ' . $pwe_element . ' .swiper-scrollbar.swiper-scrollbar-horizontal {
                            position: inherit;
                            height: 8px;
                        }';

                } else {
                    $output .= '

                        ' . $pwe_element . ' .swiper-button-next, 
                        ' . $pwe_element . ' .swiper-button-prev {
                            color: var(--accent-color);
                        }';

                }
                
            $output .= '
            </style>';

            if (!empty($breakpoints)) {
                $swiper_breakpoints = '';
                foreach ($breakpoints as $width => $slides) {
                    $swiper_breakpoints .= $width . ': { slidesPerView: ' . $slides . ' },';
                }
            } else {
                $swiper_breakpoints = '
                    400: { slidesPerView: 1 },
                    650: { slidesPerView: 2 },
                    960: { slidesPerView: 3 },
                    1100: { slidesPerView: 4 }';
            }

            $output .= '
            <script>
                jQuery(function ($) {
                    const wrapper = document.querySelector("' . $pwe_element . '");
                    const container = wrapper.querySelector(".swiper");
                    const slides = container.querySelectorAll(".swiper-slide");
                    const slidesCount = slides.length;
                    const containerWidth = container.clientWidth;

                    const breakpoints = {
                        ' . rtrim($swiper_breakpoints, ',') . '
                    };

                    let slidesPerView = 1;
                    Object.keys(breakpoints).sort((a, b) => a - b).forEach(function(bp) {
                        const bpInt = parseInt(bp);
                        if (containerWidth >= bpInt && typeof breakpoints[bp] === "object" && breakpoints[bp].slidesPerView) {
                            slidesPerView = breakpoints[bp].slidesPerView;
                        }
                    });

                    const shouldLoop = slidesCount > slidesPerView;

                    const swiperConfig = {
                        loop: shouldLoop,
                        spaceBetween: 20,
                        grabCursor: true,
                        observer: true,
                        observeParents: true,
                        ';
                        if (isset($options['autoplay']) && $options['autoplay'] === false) {
                            $output .= 'autoplay: false,';
                        } else {
                            $output .= 'autoplay: {
                                delay: 3000,
                                disableOnInteraction: false,
                                pauseOnMouseEnter: true
                            },';
                        }

                        $output .= '
                        breakpoints: breakpoints,
                        on: {
                            init: function () {
                                setTimeout(() => {
                                    wrapper.classList.add("pwe-visible");
                                }, 500);

                                if (!shouldLoop) {
                                    const swiperWrapper = container.querySelector(".swiper-wrapper");
                                    if (swiperWrapper) {
                                        swiperWrapper.style.justifyContent = "center";
                                    }
                                }
                            }
                        }
                    };';

                    // Dodaj warunki dynamiczne do konfiguracji Swipera
                    if ($dots_display === "true") {
                        $output .= '
                    swiperConfig.pagination = {
                        el: "' . $pwe_element . ' .swiper-pagination",
                        clickable: true,
                        dynamicBullets: true,
                        dynamicMainBullets: 3
                    };';
                    }

                    if ($arrows_display === "true") {
                        $output .= '
                    swiperConfig.navigation = {
                        nextEl: "' . $pwe_element . ' .swiper-button-next",
                        prevEl: "' . $pwe_element . ' .swiper-button-prev"
                    };';
                    }

                    if ($arrows_display === "true" && $scrollbar_display === "true") {
                        $output .= '
                    swiperConfig.scrollbar = {
                        el: "' . $pwe_element . ' .swiper-scrollbar",
                        draggable: false
                    };';
                    } else if (empty($arrows_display) && $scrollbar_display === "true") {
                        $output .= '
                    swiperConfig.scrollbar = {
                        el: "' . $pwe_element . ' .swiper-scrollbar",
                        draggable: true
                    };';
                    }

                $output .= '

                    const swiper = new Swiper(container, swiperConfig);

                });
            </script>';

            return $output;
        }
}

?>