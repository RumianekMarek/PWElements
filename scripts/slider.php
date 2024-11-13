<?php

class PWESliderScripts {

        /**
         * Initializes the slider.
         */
        public function __construct() {}

        /**
         * Prepares and returns the scripts for the slider.
         * 
         */
        public static function sliderScripts($id = '', $pwe_element = '.pwelement', $dots_display = false, $arrows_display = false, $slides_to_show = 5) {
            wp_enqueue_style('slick-slider-css', plugins_url('../assets/slick-slider/slick.css', __FILE__));
            wp_enqueue_style('slick-slider-theme-css', plugins_url('../assets/slick-slider/slick-theme.css', __FILE__));
            wp_enqueue_script('slick-slider-js', plugins_url('../assets/slick-slider/slick.min.js', __FILE__), array('jquery'), null, true);

            include_once plugin_dir_path(__DIR__) . 'pwefunctions.php';
            $fair_colors = PWECommonFunctions::findPalletColorsStatic();

            $accent_color = ($fair_colors['Accent']) ? $fair_colors['Accent'] : '';
            foreach($fair_colors as $color_key => $color_value){
                if(strpos(strtolower($color_key), 'main2') !== false){
                    $main2_color = $color_value;
                }
            }

            if ($id == 'logotypes') {
                $responsive = ' 
                responsive: [
                    { breakpoint: 959, settings: { slidesToShow: 5 }},
                    { breakpoint: 600, settings: { slidesToShow: 3 }},
                    { breakpoint: 400, settings: { slidesToShow: 2 }}
                ]';
                $get_initial_slides_to_show = ' 
                return  elementWidth < 400 ? 2 :
                        elementWidth < 600 ? 3 :
                        elementWidth < 960 ? 5 :
                        slidesToShowSetting;
                ';
            } else if ($id == 'opinions') {
                $responsive = ' 
                responsive: [
                    { breakpoint: 1400, settings: { slidesToShow: 4 }},
                    { breakpoint: 1200, settings: { slidesToShow: 3 }},
                    { breakpoint: 960, settings: { slidesToShow: 2 }},
                    { breakpoint: 550, settings: { slidesToShow: 1 }}
                ] ';
                $get_initial_slides_to_show = ' 
                return  elementWidth < 550 ? 1 :
                        elementWidth < 960 ? 2 :
                        elementWidth < 1200 ? 3 :
                        elementWidth < 1400 ? 4 :
                        slidesToShowSetting;
                ';
            } else if ($id == 'posts') {
                $responsive = ' 
                responsive: [
                    { breakpoint: 1100, settings: { slidesToShow: 4 }},
                    { breakpoint: 900, settings: { slidesToShow: 3 }},
                    { breakpoint: 600, settings: { slidesToShow: 2 }},
                    { breakpoint: 400, settings: { slidesToShow: 1 }}
                ] ';
                $get_initial_slides_to_show = ' 
                return  elementWidth < 400 ? 1 :
                        elementWidth < 600 ? 2 :
                        elementWidth < 900 ? 3 :
                        elementWidth < 1100 ? 4 :
                        slidesToShowSetting;
                ';
            }
       
            $output = '
            <style>
                '. $pwe_element .' .pwe-arrow {
                    display: block;
                    position: absolute;
                    top: 40%;
                    font-size: 60px;
                    font-weight: 700;
                    z-index: 1;
                    cursor: pointer;
                }
                '. $pwe_element .' .pwe-arrow-prev {
                    left: 14px; 
                }
                '. $pwe_element .' .pwe-arrow-next {
                    right: 14px;
                }  
                '. $pwe_element .' .slick-dots {
                    position: relative;
                    width: 100%;
                    max-width: 90px;
                    overflow: hidden;
                    white-space: nowrap;
                    padding: 0 !important;
                    list-style: none;
                    margin: auto !important;
                }
                '. $pwe_element .' .slick-dots li {
                    width: 16px;
                    height: 16px;
                    margin: 0 7px;
                    background-color: #bbb;
                    border: none;
                    border-radius: 50%;
                }
                '. $pwe_element .' .slick-dots li button {
                    opacity: 0;
                }
                '. $pwe_element .' .slick-dots li.slick-active {
                    transform-origin: center;
                    background: '. $accent_color .';
                }
            </style>';

            $output .= '
            <script>
                jQuery(function ($) {     
                    const pweElement = $("'. $pwe_element .'");
                    const slickSlider = $("'. $pwe_element .' .pwe-slides");
                    const sliderArrows = $("'. $pwe_element .' .pwe-arrow");
                    const totalSlides = slickSlider.children().length;

                    const sliderDotsDisplay = "'. $dots_display .'";
                    const sliderArrowsDisplay = "'. $arrows_display .'";
                    const slidesToShowSetting = '. $slides_to_show .';

                    // Function to initialize Slick Slider
                    function initializeSlick(arrowsEnabled = false, dotsEnabled = false) {
                        slickSlider.slick ({
                            infinite: true,
                            slidesToShow: slidesToShowSetting,
                            slidesToScroll: 1,
                            arrows: arrowsEnabled,
                            nextArrow: $("'. $pwe_element .' .pwe-arrow-next"),
                            prevArrow: $("'. $pwe_element .' .pwe-arrow-prev"),
                            autoplay: true,
                            autoplaySpeed: 3000,
                            dots: dotsEnabled,
                            cssEase: "linear",
                            swipeToSlide: true,
                            '. $responsive .' 
                        });
                    }

                    // Ustawienia dla slidesToShow na podstawie breakpointów
                    function getInitialSlidesToShow() {
                        const elementWidth = pweElement.width();
                        '. $get_initial_slides_to_show .'
                    }

                    // Calculating `slidesToShow` before initialization
                    const currentSlidesToShow = getInitialSlidesToShow();

                    // Check if arrows and dots should be enabled
                    let dotsEnabled = totalSlides > currentSlidesToShow && sliderDotsDisplay === "true";
                    let arrowsEnabled = totalSlides > currentSlidesToShow && sliderArrowsDisplay === "true";

                    // Initializing of slider
                    initializeSlick(arrowsEnabled, dotsEnabled);

                    if (dotsEnabled) {
                        slickSlider.on("afterChange", function(event, slick, currentSlide) {
                            const $slickDots = $(event.target).find(".slick-dots");
                            const dotWidth = 30;

                            // Calculate the offset based on the currentSlide index
                            const scrollPosition = (currentSlide - 1) * dotWidth;

                            // Set scrollLeft directly on the .slick-dots container
                            $slickDots.animate({ scrollLeft: scrollPosition }, 300);
                        });

                    }

                    // Hide arrows if arrows disabled
                    if (!arrowsEnabled) {
                        sliderArrows.hide();
                    }
                });
            </script>';   
            
            return $output;
        }
} 

?>