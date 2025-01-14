<?php 

/**
 * Class PWElementNumbers
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementNumbers extends PWElements {

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
                'heading' => __('Mode', 'pwe_element'),
                'param_name' => 'pwe_numbers_mode',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers', 
                ),
                'value' => array(
                    'Simple mode' => 'simple_mode',
                    'Footer mode' => 'footer_mode',
                ),
                
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Turn on footer section', 'pwe_display_info'),
                'param_name' => 'pwe_numbers_footer_section',
                'save_always' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'footer_mode',
                ),
            ),
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Icons color <a href="#" onclick="yourFunction(`pwe_number_color_icons_hidden`, `pwe_number_color_icons`)">CUSTOM</a>', 'pwe_element'),
                'param_name' => 'pwe_number_color_icons',
                'description' => __('Specify the thumbnail width for desktop.', 'pwe_element'),
                'save_always' => true,
                'value' => self::$fair_colors,
                'dependency' => array(
                    'element' => 'pwe_number_color_icons_hidden',
                    'value' => array(''),
                    'callback' => "hideEmptyElem",
                ),
            ), 
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Icons color <a href="#" onclick="yourFunction(`pwe_number_color_icons`, `pwe_number_color_icons_hidden`)">SELECT</a>', 'pwe_element'),
                'param_name' => 'pwe_number_color_icons_hidden',
                'param_holder_class' => 'pwe_dependent-hidden',
                'value' => '',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'simple_mode',
                ),
            ), 
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title first', 'pwe_element'),
                'param_name' => 'pwe_custom_title_first',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'simple_mode',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number first', 'pwe_element'),
                'param_name' => 'pwe_number_first',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'simple_mode',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title second', 'pwe_element'),
                'param_name' => 'pwe_custom_title_second',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'simple_mode',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number second', 'pwe_element'),
                'param_name' => 'pwe_number_second',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'simple_mode',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title third', 'pwe_element'),
                'param_name' => 'pwe_custom_title_third',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'simple_mode',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number third', 'pwe_element'),
                'param_name' => 'pwe_number_third',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_numbers_mode',
                    'value' => 'simple_mode',
                ),
            ), 
        );
        return $element_output;
    }    

    public static function output($atts) {  
        $pwe_number_color_icons_hidden = isset($atts['pwe_number_color_icons_hidden']) ? $atts['pwe_number_color_icons_hidden'] : null;
        $pwe_number_color_icons = self::findColor($pwe_number_color_icons_hidden, $atts['pwe_number_color_icons'], self::$accent_color);

        extract( shortcode_atts( array(
            'pwe_numbers_mode' => '',
            'pwe_numbers_footer_section' => '',
            'pwe_custom_title_first' => '',
            'pwe_number_first' => '',
            'pwe_custom_title_second' => '',
            'pwe_number_second' => '',
            'pwe_custom_title_third' => '',
            'pwe_number_third' => '',
        ), $atts )); 
        
        if ($pwe_numbers_mode == "simple_mode") {

            if (get_locale() == "pl_PL") {
                $pwe_custom_title_first = (empty($pwe_custom_title_first)) ? 'dni konferencji' : $pwe_custom_title_first;
                $pwe_custom_title_second = (empty($pwe_custom_title_second)) ? 'prelegentów' : $pwe_custom_title_second;
                $pwe_custom_title_third = (empty($pwe_custom_title_third)) ? 'uczestników' : $pwe_custom_title_third;
            } else {
                $pwe_custom_title_first = (empty($pwe_custom_title_first)) ? 'conference days' : $pwe_custom_title_first;
                $pwe_custom_title_second = (empty($pwe_custom_title_second)) ? 'speakers' : $pwe_custom_title_second;
                $pwe_custom_title_third = (empty($pwe_custom_title_third)) ? 'participants' : $pwe_custom_title_third;
            }
            
            $output = '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-numbers-row {
                    width: 100%;
                    text-align: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-numbers {
                    width: 100%;
                    display: flex;
                    justify-content: center;
                    gap: 36px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-numbers-item {
                    width: 33%;
                }
                .pwe-numbers-item-icon i {
                    color: '. $pwe_number_color_icons .' !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-numbers-item-heading h3 {
                    margin: 24px auto 0;
                }
                @media (max-width:768px) {
                    .pwelement_'. self::$rnd_id .' .pwe-numbers {
                        gap: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-numbers-item-heading h3 {
                        font-size: 16px;
                    }
                }
                @media (max-width:500px) {
                    .pwelement_'. self::$rnd_id .' .pwe-numbers {
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-numbers-item {
                        width: 100%;
                    }  
                    .pwelement_'. self::$rnd_id .' .pwe-numbers-item-heading h3 {
                        font-size: 20px;
                    }
                } 
            </style>

            <div id="pweNumbers"class="pwe-container-numbers">
                <div class="pwe-numbers-row">

                    <div class="pwe-numbers">

                        <div class="pwe-numbers-item">
                            <div class="pwe-numbers-item-icon">
                                <i class="fa fa-calendar fa-4x fa-fw"></i>
                            </div>
                            <div class="pwe-numbers-item-heading">
                                <h3>'. $pwe_number_first .' '. $pwe_custom_title_first .'</h3>
                            </div>
                        </div>
                        <div class="pwe-numbers-item">
                            <div class="pwe-numbers-item-icon">
                                <i class="fa fa-users2 fa-4x fa-fw"></i>
                            </div>
                            <div class="pwe-numbers-item-heading">
                                <h3>'. $pwe_number_second .' '. $pwe_custom_title_second .'</h3>
                            </div>
                        </div>
                        <div class="pwe-numbers-item">
                            <div class="pwe-numbers-item-icon">
                                <i class="fa fa-group fa-4x fa-fw"></i>
                            </div>
                            <div class="pwe-numbers-item-heading">
                                <h3>'. $pwe_number_third .' '. $pwe_custom_title_third .'</h3>
                            </div>
                        </div>

                    </div>

                </div>
            </div>';

        } else if ($pwe_numbers_mode == "footer_mode") {
            $output = '
            <style>
                .pwe-numbers {
                    max-width:1200px;
                    margin: 0 auto;
                    display: flex;
                    flex-direction: column;
                    gap:30px;
                }
                .pwe-numbers__title {
                    margin: 0 auto; 
                    font-size: 24px !important; 
                    text-align: center;
                    text-transform: uppercase;
                }
                .pwe-numbers__wrapper {
                    display: flex;
                    gap:30px;
                }
                .pwe-numbers__img {
                    flex: .5;
                    background-image: url(/wp-content/plugins/PWElements/media/bg-object.jpg);
                    background-repeat: no-repeat;
                    background-size: cover;
                    background-position: center;
                    width: 100%;
                    border-radius: 30px;
                }
                .pwe-numbers__container {
                    flex:.5;
                }
                .pwe-numbers__container-ufi {
                    display: flex;
                    justify-content: space-around;
                    border:1px solid rgba(0, 0, 0, 0.1);
                    border-radius: 30px;
                    margin-bottom: 20px;
                    max-width: 90%;
                    margin:0 auto;
                }
                .pwe-numbers__container-ufi img {
                    max-width: 45%;
                }
                .pwe-numbers__container-numbers {
                    display:flex;
                    justify-content: space-around;
                }
                .pwe-numbers__container-numbers div {
                    flex:.5;
                    display: flex;
                    align-items: center;
                    flex-direction: column;
                    margin:10px 0px;
                }
                .pwe-numbers__container-numbers img {
                    max-height: 50px;
                    object-fit: contain;
                }
                .pwe-numbers__container-numbers h3, .pwe-numbers__container-numbers p {
                    margin:4px 0;
                    line-height: 1.3;
                    text-align: center;
                }
                @media(max-width:900px){
                    .pwe-numbers__wrapper {
                        flex-direction: column;
                    }
                    .pwe-numbers__img {
                        min-height: 250px;
                    }
                }';
                if ($pwe_numbers_footer_section != true) {
                    $output .= '
                        .pwe-footer-bg,
                        .pwe-footer-images-bg {
                            display: none;
                        }
                    ';
                }
                $output .= '
            </style>

            <div id="pweNumbers" class="pwe-numbers">
                <h2 class="pwe-numbers__title">'. self::languageChecker('NAJWIĘKSZE CENTRUM TARGOWE  W EUROPIE ŚRODKOWO-WSCHODNIEJ', 'THE LARGEST TRADE FAIR CENTER IN CENTRAL AND EASTERN EUROPE') .'</h2>
                <div class="pwe-numbers__wrapper">
                    <div class="pwe-numbers__container">
                        <div class="pwe-numbers__container-ufi">
                            <img src="/wp-content/plugins/PWElements/media/numbers-el/certifed.webp" />
                            <img src="/wp-content/plugins/PWElements/media/numbers-el/ufi.webp" />
                        </div>

                        <div class="pwe-numbers__container-numbers">
                            <div>
                                <img src="/wp-content/plugins/PWElements/media/numbers-el/exhibitors.webp" />
                                <h3>20000</h3>
                                <p>'. self::languageChecker('Wystawców<br>rocznie', 'Exhibitors<br>per year') .'</p>
                            </div>
                            <div>
                                <img src="/wp-content/plugins/PWElements/media/numbers-el/visitors.webp" />
                                <h3>1mln+</h3>
                                <p>'. self::languageChecker('Odwiedzających<br>rocznie', 'Visitors<br>per year') .'</p>
                            </div>
                        </div>

                        <div class="pwe-numbers__container-numbers">
                            <div>
                                <img src="/wp-content/plugins/PWElements/media/numbers-el/fairs.webp" />
                                <h3>120+</h3>
                                <p>'. self::languageChecker('Targów B2B<br>rocznie', 'B2B fairs<br>per year') .'</p>
                            </div>
                            <div>
                                <img src="/wp-content/plugins/PWElements/media/numbers-el/area.webp" />
                                <h3>153k</h3>
                                <p>'. self::languageChecker('Powierzchni m<sup>2</sup>', 'Surface area m<sup>2</sup>') .'</p>
                            </div>
                        </div>
                    </div>
                    <div class="pwe-numbers__img"></div>
                </div>
            </div>';
        }

        return $output;
    }
}