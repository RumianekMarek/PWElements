<?php 

/**
 * Class PWElementAbout
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementAbout extends PWElements {

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
                'type' => 'textarea_raw_html',
                'group' => 'PWE Element',
                'heading' => __('Left text', 'pwelement'),
                'param_name' => 'pwe_about_left_text',
                'param_holder_class' => 'backend-textarea-raw-html backend-area-half-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementAbout',
                ),
            ),
            array(
                'type' => 'textarea_raw_html',
                'group' => 'PWE Element',
                'heading' => __('Right text (description)', 'pwelement'),
                'param_name' => 'pwe_about_right_text',
                'param_holder_class' => 'backend-textarea-raw-html backend-area-half-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementAbout',
                ),
            ),
        );
        return $element_output;
    }    

    public static function output($atts) {  

        extract( shortcode_atts( array(
            'pwe_about_left_text' => '',
            'pwe_about_right_text' => '',
        ), $atts ));

        if (PWECommonFunctions::lang_pl()) {
            $default_title_text = 'Odkryj rynkowe nowości i spotkaj liderów branż – wszystko w jednym miejscu i czasie!';
            $default_desc_text = '[trade_fair_name] to jedyne w Polsce wydarzenie dedykowane branży kabli, które łączy innowacje, technologie i ekspertów. Targi to doskonała okazja do nawiązywania kontaktów i odkrywania najnowszych trendów w tej dziedzinie.';
        } else {
            $default_title_text = 'Discover market news and meet industry leaders – all in one place and time!';
            $default_desc_text = '[trade_fair_name] is the only event in Poland dedicated to the cable industry, which combines innovation, technology and experts. The fair is a great opportunity to establish contacts and discover the latest trends in this field.';
        }
        
        $title_text = PWECommonFunctions::decode_clean_content($pwe_about_left_text);
        $desc_text = PWECommonFunctions::decode_clean_content($pwe_about_right_text);

        $title_text = !empty($title_text) ? $title_text : $default_title_text;
        $desc_text = !empty($desc_text) ? $desc_text : $default_desc_text;
        
        $output = '
        <style>
            .pwe-discover-btns .pwe-discover-btns__container_text h3,
            .pwe-discover-btns .pwe-discover-btns__container_text p {
                color: white;
                font-size: 32px;
            }
            .pwe-discover-btns .pwe-discover-btns__heading {
                display: flex;
                gap: 30px;
            }
            .pwe-discover-btns .pwe-discover-btns__heading_left {
                flex: .50;
            }
            .pwe-discover-btns .pwe-discover-btns__heading_left h3 {
                font-size: 28px; 
                color: black;
            }
            .pwe-discover-btns .pwe-discover-btns__heading_right {
                flex: .50;
            }
            .pwe-discover-btns .pwe-discover-btns__heading_right p {
                font-size: 17px;
                color: black;
                line-height: 1.4;
                font-weight: 600;
            }
            .pwe-discover-btns .pwe-discover-btns__container {
                margin-top: 40px;
                display: flex;
                gap: 20px;
            }
            .pwe-discover-btns__container_image {
                flex: .5;
                display: flex;
                justify-content: center;
                flex-direction: column;
                align-items: center;
                position: relative;
                overflow: hidden;
                border-radius: 30px;
            }
            .pwe-discover-btns__container_image img {
                padding: 6px 0;
            }
            .pwe-discover-btns__container_image_left,
            .pwe-discover-btns__container_image_right {
                transition: .3s ease;
            }
            .pwe-discover-btns__container_image:hover .pwe-discover-btns__container_image_left,
            .pwe-discover-btns__container_image:hover .pwe-discover-btns__container_image_right {
                transform: scale(1.1);
            } 
            .pwe-discover-btns__container_image_left,
            .pwe-discover-btns__container_image_right {
                background-size: cover !important;
                background-repeat: no-repeat !important;
                min-height: 500px;
                width: 100%;
                filter: brightness(70%);
                -webkit-filter: brightness(50%);
            }
            .pwe-discover-btns__container_image_left {
                background: url(https://piotrek.targibiurowe.com/wp-content/uploads/2023/05/DSA03787-1.jpg);
            }
            .pwe-discover-btns__container_image_right {
                background: url(https://piotrek.targibiurowe.com/wp-content/uploads/2023/05/DSA04389_1-1.jpg);
            }
            .pwe-discover-btns__container_text {
                position: absolute;
                top: 50%;
                left: 45%;
                transform: translate(-45%, -50%);
                display: flex;
                flex-direction: column;
                align-items: center;
            }
            .pwe-discover-btns__container_text a {
                transition: all .2s linear;
                text-align: center;
            }
            .pwe-discover-btns__container_text a:hover{
                background: white;
                color: black !important
            }
            .pwe-discover-btns__container_text p {
                text-transform: uppercase;
            }
            .pwe-discover-btns__container_image p {
                font-size: 24px;
                font-weight: 600;
                color: white;
                margin: 0;
                text-align: center;
                line-height: 1.2;
            }
            .pwe-discover-btns__container_image a {
                text-decoration: none;
                color: white;
                border: 1px solid white;
                padding: 10px 20px;
                border-radius: 10px;
                margin-top: 8px;
            }
            @media(max-width:960px) {
                .pwe-discover-btns__container_image_left, 
                .pwe-discover-btns__container_image_right {
                    min-height: 300px;
                }
            }
            @media(max-width:560px) {
                .pwe-discover-btns__heading,
                .pwe-discover-btns__container {
                    flex-direction: column;
                }
            }
        </style>
        
        <div id="pweDiscoverBtns" class="pwe-discover-btns">
            <div class="pwe-discover-btns__wrapper">
                <div class="pwe-discover-btns__heading">
                    <div class="pwe-discover-btns__heading_left">
                        <h3>'. $title_text .'</h3>
                    </div>
                    <div class="pwe-discover-btns__heading_right">
                        <p>'. $desc_text .'</p>
                    </div>
                </div>

                <div class="pwe-discover-btns__container">
                    <div class="pwe-discover-btns__container_image ">
                        <div class="pwe-discover-btns__container_image_left">
                        </div>
                        <div class="pwe-discover-btns__container_text">
                        <p>'. self::languageChecker('Poznaj Targi', 'Discover the Fair') .'</p>
                        <img src="/doc/logo.webp">
                        <a href="/poznaj-targi/">'. self::languageChecker('Dowiedz się więcej', 'Learn more') .'</a>
                        </div>
                    </div>
                    <div class="pwe-discover-btns__container_image ">
                        <div class="pwe-discover-btns__container_image_right"></div>
                        <div class="pwe-discover-btns__container_text">
                        <p>'. self::languageChecker('Poznaj Konferencje', 'Discover Conferences') .'</p>
                        <img src="/doc/kongres.webp">
                        <a href="'. self::languageChecker('/wydarzenia', '/en/conferences/') .'">'. self::languageChecker('Dowiedz się więcej', 'Learn more') .'</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
        

        return $output;
    }
}



