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
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . '!important';
        $btn_border = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . '!important';
        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        $output = '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-btn {
                    color: '. $btn_text_color .';
                    background-color: '. $btn_color .';
                    border: 1px solid '. $btn_border .';
                }
                .pwelement_'. self::$rnd_id .' .pwe-btn:hover {
                    color: '. $btn_text_color .';
                    background-color: '. $darker_btn_color .'!important;
                    border: 1px solid '. $darker_btn_color .'!important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-min-media-wrapper img {
                    border-radius: 18px;
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
                    .pwelement_'. self::$rnd_id .' .hidden-mobile {
                        display:none;
                    }
                }
            </style>

            <div id="stand" class="pwe-container-stand">
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
                    $output .= '<p class="pwe-line-height hidden-mobile" style="color '. $text_color .';">'.
                        self::languageChecker(
                            <<<PL
                            Zobacz katalog stoisk targowych i przygotuj się na udział w targach w sposób jeszcze bardziej efektywny. Dzięki temu katalogowi będziesz miał dostęp do gotowych projektów stoisk, które ułatwią Ci przygotowanie się do targów i zyskasz cenną oszczędność czasu i pieniędzy. Wybierając już gotowy projekt stoiska, będziesz mógł skupić się na innych ważnych aspektach przygotowań do targów, takich jak przygotowanie oferty, zorganizowanie transportu czy zaplanowanie działań marketingowych.
                            PL,
                            <<<EN
                            Check out the trade show booth catalog and prepare for your trade show participation in an even more efficient way. With this catalog, you will have access to ready-made booth designs that will make it easier for you to prepare for the trade show and gain valuable savings in time and money. By choosing an already ready-made booth design, you will be able to focus on other important aspects of preparing for the fair, such as preparing your offer, arranging transportation or planning your marketing activities.
                            EN
                        )
                        .'</p>';
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
                    <img src="/wp-content/plugins/pwe-media/media/zabudowa.webp" alt="zdjęcie przykładowej zabudowy"/>
                </div>
            </div>';

        return $output;

    }
}