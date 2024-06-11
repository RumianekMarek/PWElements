<?php
/**
* Class PWElementForVisitors
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementForVisitors extends PWElements {

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
        for($i=0; $i<6; $i++){
            $element_output[] = 
                array(
                    'type' => 'textarea',
                    'group' => 'PWE Element',
                    'heading' => __('Visitors text '.$i+1, 'pwelement'),
                    'param_name' => 'exhibitor_text'.$i+1,
                    'param_holder_class' => 'for-exhibitors',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'pwe_element',
                        'value' => 'PWElementforVisitors',
                    ),
                );
        }
        return $element_output;
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        $all_images = self::findAllImages('/doc/galeria/zdjecia_wys_odw', 2);
        
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';
        $btn_text_color = 'color:' . self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important; border-width: 0 !important;';
        $btn_color = 'background-color:' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . '!important;';
        $btn_shadow_color = 'box-shadow: 9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black') . '!important;';
        $btn_border = 'border: 1px solid ' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . '!important;';
        // $img_shadow = 'box-shadow: 9px 9px 0px -6px ' . self::findColor(self::$main2_color,  self::$accent_color, 'black'). ' !important;';


        $output = '';

        $output .= '
            <style>
                .pwelement_' . self::$rnd_id . ' #forVisitors p {
                    ' . $text_color . '
                }
                .pwelement_'.self::$rnd_id.' .pwe-btn {
                    '. $btn_text_color
                    . $btn_color
                    . $btn_shadow_color
                    . $btn_border .'
                }
                .pwelement_'. self::$rnd_id .' .pwe-content-visitors-item {
                    width: 100%;
                    display:flex;
                    justify-content: center;
                    gap: 36px;
                    padding-bottom: 36px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-visitors-image-block, 
                .pwelement_'. self::$rnd_id .' .pwe-visitors-text-block{
                    width: 50%;
                }
                .pwelement_'. self::$rnd_id .' .pwe-visitors-image-block img {
                    width: 100%;
                    aspect-ratio: 16/9;
                    object-fit: cover;
                    box-shadow: 9px 9px 0px -6px [trade_fair_main2]; 
                }
                @media (max-width:768px){
                    .pwelement_'. self::$rnd_id .' .pwe-content-visitors-item {
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-column-reverse{
                        flex-direction: column-reverse;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-visitors-image-block,
                    .pwelement_'. self::$rnd_id .' .pwe-visitors-text-block {
                        width: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-visitors-text {
                        padding: 18px 0;
                    }
                }
            </style>

            <div id="forVisitors"class="pwe-container-visitors">
                <div class="pwe-content-visitors-item pwe-align-left">
                    <div class="pwe-visitors-image-block uncode-single-media-wrapper">              
                        <img src="' . $all_images[0] . '" alt="visitors image 1">
                    </div>
                    <div class="pwe-visitors-text-block">
                        <div class="pwe-visitors-text">
                            <p>';
                                if($atts['exhibitor_text1'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            [trade_fair_name] to branżowe specjalistyczne wydarzenie odbywające się w Ptak Warsaw Expo, Największym Centrum Targowo – Kongresowym w Europie Środkowej. Mające na celu skupienie wszystkich gałęzi branży [trade_fair_opisbranzy] i stworzenie dogodnych warunków do profesjonalnych kontaktów biznesowych. [trade_fair_desc] pozwolą na znalezienie potencjalnych partnerów biznesowych dla twojej firmy.
                                        PL,
                                        <<<EN
                                            [trade_fair_name_eng] is an industry specialized event held at Ptak Warsaw Expo, the Largest Trade Fair and Congress Center in Central Europe. Aimed at bringing together all branches of the [trade_fair_opisbranzy_eng] industry and creating convenient conditions for professional business contacts. [trade_fair_desc_eng] will allow you to find potential business partners for your company.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text1'];
                                }
                            $output .= '</p>
                        </div>
                    </div>
                </div>

                <!-- for-visitors-item -->
                <div class="pwe-content-visitors-item pwe-column-reverse pwe-align-left column-reverse">
                    <div class="pwe-visitors-text-block">
                        <div class="pwe-visitors-text">
                            <p>';
                                if($atts['exhibitor_text1'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            [trade_fair_name] to doskonała okazja byś mógł porównać i dokładnie przeanalizować wszystkie dostępne na polskim rynku oferty dedykowane branży. Wydarzenie to stanowi również doskonałą okazję do uczestnictwa w konferencjach, warsztatach oraz kongresach branży [trade_fair_opisbranzy] rozwijających znajomość rynku oraz pokazujących działanie najnowszych technologii. Zarejestruj się i otrzymaj zaproszenie na targi.
                                        PL,
                                        <<<EN
                                            [trade_fair_name_eng] is an excellent opportunity for you to compare and carefully analyze all offers available on the Polish market dedicated to the industry. The event also provides an excellent opportunity to participate in conferences, workshops and congresses of the industry [trade_fair_opisbranzy_eng] developing knowledge of the market and showing the operation of the latest technologies. Register and receive an invitation to the fair.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text1'];
                                }
                            $output .= '</p>
                        </div>
                        <div class="pwe-btn-container">
                            <span>
                                <a class="pwe-link btn border-width-0 shadow-black btn-accent btn-flat" href='.
                                    self::languageChecker(
                                        <<<PL
                                            "/rejestracja/">Zarejestruj się<span style="display: block; font-weight: 300;">Odbierz darmowy bilet
                                        PL,
                                        <<<EN
                                            "/en/registration/">REGISTER<span style="display: block; font-weight: 300;">GET A FREE TICKET
                                        EN
                                    )
                                .'</a>
                            </span>
                        </div>
                    </div>
                    <div class="pwe-visitors-image-block uncode-single-media-wrapper">              
                        <img src="' . $all_images[1] . '"alt="visitors image 2">
                    </div>
                </div>
            </div>';

        return $output;
    }
}