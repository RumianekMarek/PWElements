<?php 

/**
 * Class PWElementStand
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementStand extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';
        $btn_text_color = 'color:' . self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important; border-width: 0 !important;';
        $btn_color = 'background-color:' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . '!important;';
        $btn_shadow_color = 'box-shadow: 9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black') . '!important;';
        $btn_border = 'border: 1px solid ' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . '!important;';
        
        $output = '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-btn {
                    '. $btn_text_color
                    . $btn_color
                    . $btn_shadow_color
                    . $btn_border .'
                }
                .pwelement_'. self::$rnd_id .' .pwe-btn:hover {
                    color: #000000 !important;
                    background-color: #ffffff !important;
                    border: 1px solid #000000 !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-min-media-wrapper {
                    box-shadow: 9px 9px 0px -6px [trade_fair_main2];
                }
                .pwelement_'. self::$rnd_id .' .pwe-container-stand {
                    display:flex;
                    flex-wrap: wrap;
                    justify-content: center;
                }
                @media (max-width:960px) {
                    .pwelement_'. self::$rnd_id .' .pwe-container-stand {
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-container-stand .pwe-block-1 {
                        order:2;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-container-stand .pwe-block-2 {
                        order:1;
                    }
                }
            </style>

            <div id="PWEstand" class="pwe-container-stand">
                <div class="pwe-block-1 half-block-padding" style="flex:1;">
                    <div class="heading-text el-text main-heading-text text-centered">
                    <h4>'. 
                        self::languageChecker(
                            <<<PL
                            DEDYKOWANA ZABUDOWA TARGOWA
                            PL,
                            <<<EN
                            DESIGNED EXHIBITION STANDS
                            EN
                        )
                    .'</h4>
                    </div>';
                    if (!preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT'])) {
                        $output .= '<p class="pwe-line-height" style="' . $text_color . '">'. 
                        self::languageChecker(
                            <<<PL
                            Zobacz katalog stoisk targowych i przygotuj się na udział w targach w sposób jeszcze bardziej efektywny. Dzięki temu katalogowi będziesz miał dostęp do gotowych projektów stoisk, które ułatwią Ci przygotowanie się do targów i zyskasz cenną oszczędność czasu i pieniędzy. Wybierając już gotowy projekt stoiska, będziesz mógł skupić się na innych ważnych aspektach przygotowań do targów, takich jak przygotowanie oferty, zorganizowanie transportu czy zaplanowanie działań marketingowych.
                            PL,
                            <<<EN
                            Check out the trade show booth catalog and prepare for your trade show participation in an even more efficient way. With this catalog, you will have access to ready-made booth designs that will make it easier for you to prepare for the trade show and gain valuable savings in time and money. By choosing an already ready-made booth design, you will be able to focus on other important aspects of preparing for the fair, such as preparing your offer, arranging transportation or planning your marketing activities.
                            EN
                        )
                        .'</p>';
                    }
                    $output .= '<div class="pwe-btn-container">
                        <span>
                            <a class="pwe-link btn pwe-btn" target="_blank"'. 
                                self::languageChecker(
                                    <<<PL
                                    href="https://warsawexpo.eu/zabudowa-targowa">Zobacz Więcej
                                    PL,
                                    <<<EN
                                    href="https://warsawexpo.eu/en/exhibition-stands">See more
                                    EN
                                )
                            .'</a>
                        </span>
                        <span>
                            <a class="pwe-link btn pwe-btn" target="_blank"'. 
                                self::languageChecker(
                                    <<<PL
                                    href="https://warsawexpo.eu/katalog-zabudowy">Katalog Zabudowy
                                    PL,
                                    <<<EN
                                    href="https://warsawexpo.eu/en/katalog-zabudowy">Exhibition Stand
                                    EN
                                )
                            .'</a>
                        </span>
                    </div>
                </div>

                <div class="pwe-block-2 single-media-wrapper half-block-padding pwe-min-media-wrapper" style="flex:1;">
                    <img src="/wp-content/plugins/PWElements/media/zabudowa.webp" alt="zdjęcie przykładowej zabudowy"/>
                </div>
            </div>';

        return $output;

    }
}

?>
