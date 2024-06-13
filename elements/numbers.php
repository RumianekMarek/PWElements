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
                'heading' => __('Icons color <a href="#" onclick="yourFunction(`pwe_number_color_icons_hidden`, `pwe_number_color_icons`)">CUSTOM</a>', 'pwelement'),
                'param_name' => 'pwe_number_color_icons',
                'description' => __('Specify the thumbnail width for desktop.', 'pwelement'),
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
                'heading' => __('Icons color <a href="#" onclick="yourFunction(`pwe_number_color_icons`, `pwe_number_color_icons_hidden`)">SELECT</a>', 'pwelement'),
                'param_name' => 'pwe_number_color_icons_hidden',
                'param_holder_class' => 'pwe_dependent-hidden',
                'value' => '',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers',
                ),
            ), 
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title first', 'pwelement'),
                'param_name' => 'pwe_custom_title_first',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number first', 'pwelement'),
                'param_name' => 'pwe_number_first',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title second', 'pwelement'),
                'param_name' => 'pwe_custom_title_second',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number second', 'pwelement'),
                'param_name' => 'pwe_number_second',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title third', 'pwelement'),
                'param_name' => 'pwe_custom_title_third',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number third', 'pwelement'),
                'param_name' => 'pwe_number_third',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementNumbers',
                ),
            ),
        );
        return $element_output;
    }    

    public static function output($atts) {  
        $pwe_number_color_icons = self::findColor($atts['pwe_number_color_icons_hidden'], $atts['pwe_number_color_icons'], self::$accent_color);

        extract( shortcode_atts( array(
            'pwe_custom_title_first' => '',
            'pwe_number_first' => '',
            'pwe_custom_title_second' => '',
            'pwe_number_second' => '',
            'pwe_custom_title_third' => '',
            'pwe_number_third' => '',
        ), $atts ));  
        
        if (get_locale() == "pl_PL") {
            $pwe_custom_title_first = (empty($pwe_custom_title_first)) ? 'dni konferencji' : $pwe_custom_title_first;
            $pwe_custom_title_second = (empty($pwe_custom_title_second)) ? 'prelegentów' : $pwe_custom_title_second;
            $pwe_custom_title_third = (empty($pwe_custom_title_third)) ? 'uczestników' : $pwe_custom_title_third;
        } else {
            $pwe_custom_title_first = (empty($pwe_custom_title_first)) ? 'conference days' : $pwe_custom_title_first;
            $pwe_custom_title_second = (empty($pwe_custom_title_second)) ? 'speakers' : $pwe_custom_title_second;
            $pwe_custom_title_third = (empty($pwe_custom_title_third)) ? 'participants' : $pwe_custom_title_third;
        }
        
        $output ='
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

        return $output;
    }
}