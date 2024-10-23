<?php 

/**
 * Class PWElementOpinions
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementOpinions extends PWElements {

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
                'type' => 'param_group',
                'group' => 'PWE Element',
                'param_name' => 'opinions_items',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOpinions',
                ),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Person image', 'pwelement'),
                        'param_name' => 'opinions_face_img',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Company image', 'pwelement'),
                        'param_name' => 'opinions_company_img',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Company name', 'pwelement'),
                        'param_name' => 'opinions_company',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Person name', 'pwelement'),
                        'param_name' => 'opinions_name',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Person description', 'pwelement'),
                        'param_name' => 'opinions_desc',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Person opinion', 'pwelement'),
                        'param_name' => 'opinions_text',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                ),
            ),
        );
        return $element_output;
    }    

    public static function output($atts) { 
        wp_enqueue_style('slick-slider-css', plugins_url('../assets/slick-slider/slick.css', __FILE__));
        wp_enqueue_style('slick-slider-theme-css', plugins_url('../assets/slick-slider/slick-theme.css', __FILE__));
        wp_enqueue_script('slick-slider-js', plugins_url('../assets/slick-slider/slick.min.js', __FILE__), array('jquery'), null, true);

        extract( shortcode_atts( array(
            'opinions_items' => '',
        ), $atts )); 

        $opinions_items_urldecode = urldecode($opinions_items);
        $opinions_items_json = json_decode($opinions_items_urldecode, true);

        $output = '';
        $output .= '
            <style>
                .row-parent:has(.pwelement_'. self::$rnd_id .' .pwe-opinions) {
                    max-width: 100% !important;
                    padding: 0 !important;  
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions {
                    visibility: hidden;
                    opacity: 0;
                    transition: opacity 0.5s ease-in-out;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__wrapper {
                    max-width: 100%;
                    margin: 0 auto;
                    padding: 18px 36px;
                    position: relative;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__title {
                    margin: 0 auto;
                    padding-top: 18px;
                    font-size: 24px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                    position: relative;
                    padding: 18px;
                    box-shadow: 0px 0px 12px #cccccc;
                    border-radius: 18px;
                    margin: 12px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company {
                    display: flex;
                    justify-content: space-between;
                    padding: 10px 0;
                    gap: 10px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company p {
                    margin: 0;
                    line-height: 1.2;
                    font-size: 14px;
                    font-weight: 600;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo {
                    max-width: 80px;
                    display: flex;
                    justify-content: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo img {
                    width: 100%;
                    object-fit: contain;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person {
                    display: flex;
                    gap: 10px;
                    padding: 10px 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img {
                    max-width: 50px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img img {
                    width: 100%;
                    border-radius: 50%;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info h3 {
                    margin: 0;
                    font-size: 14px;
                    color: cornflowerblue;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info h5 {
                    margin: 4px 0 0;
                    font-size: 12px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion {
                    padding: 10px 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion p {
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 0;
                } 
                .pwelement_'. self::$rnd_id .' .pwe-opinions__arrow {
                    display: block;
                    position: absolute;
                    top: 40%;
                    font-size: 60px;
                    font-weight: 700;
                    z-index: 1;
                    cursor: pointer;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__arrow-prev {
                    left: 6px; 
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__arrow-next {
                    right: 6px;
                }  
                
            </style>';

            if (is_array($opinions_items_json)) {

                $output .= '
                <div id="pweOpinions"class="pwe-opinions">
                    <h2 class="pwe-opinions__title">'. self::languageChecker('REKOMENDACJE', 'RECOMMENDATIONS') .'</h2>
                    <div class="pwe-opinions__wrapper">
                        <div class="pwe-opinions__items">';

                            foreach ($opinions_items_json as $opinion_item) {
                                $opinions_face_img = $opinion_item["opinions_face_img"];
                                $opinions_company_img = $opinion_item["opinions_company_img"];
                                $opinions_company = $opinion_item["opinions_company"];
                                $opinions_name = $opinion_item["opinions_name"];
                                $opinions_desc = $opinion_item["opinions_desc"];
                                $opinions_text = $opinion_item["opinions_text"];
                
                                $opinions_face_img_src = wp_get_attachment_url($opinions_face_img);  
                                $opinions_company_img_src = wp_get_attachment_url($opinions_company_img);  

                                $output .= '
                                <div class="pwe-opinions__item">
                                    <div class="pwe-opinions__item-company">
                                        ' . (!empty($opinions_company) ? '<p>' . $opinions_company . '</p>' : '<span></span>') . '
                                        <div class="pwe-opinions__item-company_logo">
                                            ' . (!empty($opinions_company_img) ? '<img src="' . $opinions_company_img_src . '">' : '') . '
                                        </div>
                                    </div>
                                    <div class="pwe-opinions__item-person">
                                        <div class="pwe-opinions__item-person-img">
                                            ' . (!empty($opinions_face_img) ? '<img src="' . $opinions_face_img_src . '">' : '') . '
                                        </div>
                                        <div class="pwe-opinions__item-person-info">
                                            <h3>' . $opinions_name . '</h3>
                                            <h5>' . $opinions_desc . '</h5>
                                        </div>
                                    </div>
                                    <div class="pwe-opinions__item-opinion">
                                        <p>' . $opinions_text . '</p>
                                    </div>
                                </div>';
                            }

                        $output .= '
                        </div>

                        <span class="pwe-opinions__arrow pwe-opinions__arrow-prev">‹</span>
                        <span class="pwe-opinions__arrow pwe-opinions__arrow-next">›</span>

                    </div>
                </div>';

                $output .= '
                <script>
                jQuery(function ($) {
                        const opinionsItems = $("#pweOpinions .pwe-opinions__items");
                        const opinionsArrows = $(".pwe-opinions__arrow");

                        opinionsItems.slick({
                                infinite: true,
                                slidesToShow: 5,
                                slidesToScroll: 1,
                                arrows: true,
                                nextArrow: $("#pweOpinions .pwe-opinions__arrow-next"),
                                prevArrow: $("#pweOpinions .pwe-opinions__arrow-prev"),
                                autoplay: true,
                                autoplaySpeed: 3000,
                                dots: false,
                                cssEase: "linear",
                                responsive: [
                                        {
                                            breakpoint: 1200,
                                            settings: { slidesToShow: 4 }
                                        },
                                        {
                                            breakpoint: 960,
                                            settings: { slidesToShow: 3 }
                                        },
                                        {
                                            breakpoint: 768,
                                            settings: { slidesToShow: 2 }
                                        },
                                        {
                                            breakpoint: 550,
                                            settings: { slidesToShow: 1 }
                                        }
                                ] 
                        });  

                        if (opinionsItems.children().length <= 5 && $(window).width() >= 1200) {
                            opinionsArrows.hide();
                        }

                        // Function to set equal height
                        function setEqualHeight() {
                            let maxHeight = 0;

                            // Reset the heights before calculations
                            $(".pwe-opinions__item").css("height", "auto");

                            // Calculate the maximum height
                            $(".pwe-opinions__item").each(function() {
                                const thisHeight = $(this).outerHeight();
                                if (thisHeight > maxHeight) {
                                    maxHeight = thisHeight;
                                }
                            });

                            // Set the same height for all
                            $(".pwe-opinions__item").css("height", maxHeight);
                        }

                        // Call the function after loading the slider
                        $(".pwe-opinions__items").on("init", function() {
                            setEqualHeight();
                        });

                        // Call the function when changing the slide
                        $(".pwe-opinions__items").on("afterChange", function() {
                            setEqualHeight();
                        });

                        // Call the function at the beginning
                        setEqualHeight();
                        
                        $("#pweOpinions").css("visibility", "visible").animate({ opacity: 1 }, 500);
                });             
                </script>'; 

            }

        return $output;
    }
}