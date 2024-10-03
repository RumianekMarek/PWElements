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
                    background-color: #eaeaea;
                    visibility: hidden;
                    opacity: 0;
                    transition: opacity 0.5s ease-in-out;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__wrapper {
                    max-width: 1200px;
                    margin: 0 auto;
                    padding: 18px 0;
                    position: relative;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__title {
                    margin: 0 auto;
                    padding-top: 18px;
                    font-size: 24px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                    position: relative;
                    padding: 0 18px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item:not(:last-child)::after {
                    content: "";
                    position: absolute;
                    bottom: 0;
                    top: 0; 
                    right: 0;
                    width: 1px;
                    background-color: black;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-images {
                    display: flex;
                    justify-content: space-around;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-image-person {
                    width: 45%;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-image-person,
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-image-person img  {
                    object-fit: contain;
                    border-radius: 50%;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-image-company {
                    width: 45%;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-image-company,
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-image-company img {
                    object-fit: contain;
                    display: flex;
                    align-items: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-content :is(h3, h5, p) {
                    margin: 12px 0 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-content p {
                    font-size: 14px;
                    line-height: 1.4;
                }  
                .pwelement_'. self::$rnd_id .' .pwe-opinions__arrow {
                    cursor: pointer;
                    display: none !important;
                }
                @media (max-width: 1200px) {
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__items {
                        margin-left: -1px;
                    }
                }
                @media (max-width: 500px) {
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__items {
                        padding: 0 36px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__arrow {
                        display: block !important;
                        position: absolute;
                        top: 40%;
                        font-size: 74px;
                        font-weight: 700;
                        z-index: 1;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__arrow-prev {
                        left: 6px; 
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__arrow-next {
                        right: 6px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                        background-color: white;
                        padding: 18px;
                        margin: 0 9px;
                        border-radius: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item:not(:last-child)::after {
                        content: none;
                    }
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
                                $opinions_name = $opinion_item["opinions_name"];
                                $opinions_desc = $opinion_item["opinions_desc"];
                                $opinions_text = $opinion_item["opinions_text"];
                
                                $opinions_face_img_src = wp_get_attachment_url($opinions_face_img);  
                                $opinions_company_img_src = wp_get_attachment_url($opinions_company_img);  

                                $output .= '
                                <div class="pwe-opinions__item">
                                    <div class="pwe-opinions__item-images">';
                                        $output .= !empty($opinions_face_img) ? '<img class="pwe-opinions__item-image-person" src="'. $opinions_face_img_src .'">' : '';
                                        $output .= !empty($opinions_company_img) ?  '<img class="pwe-opinions__item-image-company" src="'. $opinions_company_img_src .'">' : '';
                                    $output .= '
                                    </div>
                                    <div class="pwe-opinions__item-content">
                                        <h3>'. $opinions_name .'</h3>
                                        <h5>'. $opinions_desc .'</h5>
                                        <p>„'. $opinions_text .'”</p>
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
                        $("#pweOpinions .pwe-opinions__items").slick({
                                infinite: true,
                                slidesToShow: 4,
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
                                                settings: { slidesToShow: 3, slidesToScroll: 1, }
                                        },
                                        {
                                                breakpoint: 960,
                                                settings: { slidesToShow: 2, slidesToScroll: 1, }
                                        },
                                        {
                                                breakpoint: 500,
                                                settings: { slidesToShow: 1, slidesToScroll: 1, }
                                        }  
                                ] 
                        });  
                        
                        $("#pweOpinions").css("visibility", "visible").animate({ opacity: 1 }, 500);
                });             
                </script>'; 

            }

        return $output;
    }
}