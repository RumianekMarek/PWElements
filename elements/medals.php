<?php

/**
 * Class PWElementMedals
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementMedals extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

        public static function initElements() {
        $element_output = array(
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Presets', 'pwe_element'),
                'param_name' => 'medals_preset',
                'save_always' => true,
                'std'       => 'default',
                'value' => array( 
                    'Default' => 'default',
                    'Stacked version' => 'stacked',
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMedals',
                ),
            ),
        );
        return $element_output;
    }

    public static function output($atts) {
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color) . '!important';
        $btn_border = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color) . '!important';

        extract( shortcode_atts( array(
            'medals_preset' => '',
        ), $atts ));

        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        $medals = [
            'innowacyjnosc' => [
                'pl' => '/wp-content/plugins/PWElements/media/medals/innowacyjnosc.webp',
                'en' => '/wp-content/plugins/PWElements/media/medals/innowacyjnosc-en.webp'
            ],
            'premiera-targowa' => [
                'pl' => '/wp-content/plugins/PWElements/media/medals/premiera-targowa.webp',
                'en' => '/wp-content/plugins/PWElements/media/medals/premiera-targowa-en.webp'
            ],
            'produkt-targowy' => [
                'pl' => '/wp-content/plugins/PWElements/media/medals/produkt-targowy.webp',
                'en' => '/wp-content/plugins/PWElements/media/medals/produkt-targowy-en.webp'
            ],
            'ekspozycja-targowa' => [
                'pl' => '/wp-content/plugins/PWElements/media/medals/ekspozycja-targowa.webp',
                'en' => '/wp-content/plugins/PWElements/media/medals/ekspozycja-targowa-en.webp'
            ]
        ];

        $trade_fair_edition = do_shortcode('[trade_fair_edition]');

        if (trim($trade_fair_edition) === "Premierowa" || trim($trade_fair_edition) === "Premier") {
            $output = '
                <style>
                .pwe-medals__wrapper {
                    display: flex;
                    flex-direction: column;
                    box-shadow: 2px 2px 12px #cccccc;
                    border-radius: 36px;
                    padding: 36px;
                    text-align: center;
                    gap: 18px;
                }
                .pwe-medals__heading h4 {
                    margin: 0 auto;
                }
                .pwe-medals__items-container {
                    display: flex;
                    align-items: center;
                    max-width: 800px;
                    margin: 0 auto;
                    flex-wrap: wrap;
                }
                .pwe-medals__items {
                    width: 50%;
                }
                .pwe-medals__text {
                    max-width: 800px;
                    margin: 0 auto;
                }
                .pwe-medals__items-text {
                    text-align: left;
                }
                .pwe-medals__wrapper .pwe-medals__items_mobile {
                    display: none;
                }
                .pwe-medals__wrapper .pwe-button-link {
                    transform-origin: center !important;
                }
                @media(max-width: 650px) {
                    .pwe-medals__wrapper {
                        padding: 18px;
                    }
                    .pwe-medals__text p {
                        line-height: 1.3;
                        text-align: center;
                    }
                    .pwe-medals__items-text {
                        text-align: center;
                        margin: 0 auto;
                    }
                    .pwe-medals__items {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                    }
                    .pwe-medals__item img {
                        width: 100%;
                    }
                    .pwe-medals__wrapper .pwe-medals__items_mobile {
                        display: block;
                    }
                    .pwe-medals__wrapper .pwe-medals__items {
                        width: 100%;
                    }
                }
                .pwe-medals .pwe-button-link {
                    color: white;
                    background-color: ' . self::$accent_color . ';
                    border: 1px solid ' . self::$accent_color . ';
                    border-radius: 10px;
                    min-width: 240px;
                }
                .pwe-medals .pwe-button-link:hover {
                    color: white !important;
                    background-color: '. $darker_btn_color .'!important;
                    border: 1px solid '. $darker_btn_color .'!important;
                }
            </style>
            

                <div id="pweMedals" class="pwe-medals">
                    <div class="pwe-medals__wrapper">
                        <div class="pwe-medals__heading">
                            <h4>'. self::languageChecker('ZDOBĄDŹ PRESTIŻOWĄ NAGRODĘ W PTAK WARSAW EXPO!', 'WIN A PRESTIGIOUS AWARD AT PTAK WARSAW EXPO!') .'</h4>
                        </div>
                        <div class="pwe-medals__text">'.
                            self::languageChecker(
                                <<<PL
                                    <p>Dołącz do najlepszych na Targach Ptak Warsaw Expo i pokaż swoją firmę jako lidera! Zdobądź prestiżowy medal przyznawany przez Krajową Izbę Targową i Ptak Warsaw Expo.</p>
                                PL,
                                <<<EN
                                    <p>Join the best at Ptak Warsaw Expo and showcase your company as a leader! Earn the prestigious medal awarded by the National Chamber of Exhibitions and Ptak Warsaw Expo.</p>
                                EN
                            )
                        .'</div>
                        <div class="pwe-medals__text">'.
                            self::languageChecker(
                                <<<PL
                                    <p><strong>Honorujemy wyjątkowych partnerów w dwóch kategoriach:</strong></p>
                                PL,
                                <<<EN
                                    <p><strong>We honor exceptional partners in two categories:</strong></p>
                                EN
                            )
                        .'</div>
                        <div class="pwe-medals__items-container">
                            <div class="pwe-medals__items">
                                <div class="pwe-medals__item"><img src="'. self::languageChecker('/wp-content/plugins/PWElements/media/medals/premier-fair.webp', '/wp-content/plugins/PWElements/media/medals/premier-fair-en.webp') .'"/></div>
                            </div>
                            <div class="pwe-medals__items-text">
                                <p>'. self::languageChecker('Dla Izb i Stowarzyszeń:<br><strong>„Kluczowy Partner Targów”</strong>', 'For Chambers and Associations:<br><strong>“Key Partner of the Fair”</strong>') .'</p>
                                <p>'. self::languageChecker('Dla Firm:<br><strong>„Współtwórca Sukcesu Targów”</strong>', 'For Companies:<br><strong>“Co-Creator of Fair Success”</strong>') .'</p>
                            </div>
                        </div>';

                        $output .= '
                        <div class="pwe-medals__button">
                            <a class="pwe-button-link btn" href="' . self::languageChecker('/zostan-wystawca/', '/en/become-an-exhibitor/') . '">'. self::languageChecker('Zostań wystawcą', 'Book a stand') .'</a>
                        </div>

                    </div>
                </div>';

        } else {
            if ($medals_preset == 'default' || empty($medals_preset)) {
                $output = '
                <style>
                    .pwe-medals__wrapper {
                        display: flex;
                        flex-direction: column;
                        box-shadow: 2px 2px 12px #cccccc;
                        border-radius: 36px;
                        padding: 36px;
                        text-align: center;
                        gap: 18px;
                    }
                    .pwe-medals__heading h4 {
                        margin: 0 auto;
                        text-transform: uppercase;
                    }
                    .pwe-medals__items {
                        display: grid;
                        grid-template-columns: repeat(4, 1fr);
                        gap: 10px;
                    }
                    .pwe-medals__wrapper .pwe-medals__items {
                        display: grid;
                    }
                    .pwe-medals__wrapper .pwe-medals__items_mobile {
                        display: none;
                    }
                    .pwe-medals__wrapper .pwe-button-link {
                        transform-origin: center !important;
                    }
                    @media(max-width: 650px) {
                        .pwe-medals__wrapper {
                            padding: 18px;
                        }
                        .pwe-medals__text p {
                            line-height: 1.3;
                            text-align: left;
                        }
                        .pwe-medals__items {
                            display: flex;
                            flex-wrap: wrap;
                            justify-content: center;
                        }
                        .pwe-medals__item {
                            max-width: 100px;
                        }
                        .pwe-medals__item img {
                            width: 100%;
                        }
                        .pwe-medals__wrapper .pwe-medals__items_mobile {
                            display: block;
                        }
                        .pwe-medals__wrapper .pwe-medals__items {
                            display: none;
                        }
                    }
                    .pwe-medals .pwe-button-link {
                        color: white;
                        background-color: ' . self::$accent_color . ';
                        border: 1px solid ' . self::$accent_color . ';
                        border-radius: 10px;
                        min-width: 240px;
                    }
                    .pwe-medals .pwe-button-link:hover {
                        color: white !important;
                        background-color: '. $darker_btn_color .'!important;
                        border: 1px solid '. $darker_btn_color .'!important;
                    }
                </style>';
            } else if ($medals_preset == 'stacked') {
                $output = '
                <style>
                    .pwe-medals__wrapper {
                        display: flex;
                        flex-direction: column;
                        border-radius: 36px;
                        padding: 36px;
                        text-align: center;
                        gap: 18px;
                    }
                    .pwe-medals__heading h4 {
                        margin: 0 auto;
                        font-weight: 800;
                    }
                    .pwe-medals__items {
                        position: relative;
                        height: 300px;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                    }
                    .pwe-medals__wrapper .pwe-medals__items_mobile {
                        display: none;
                    }
                    .pwe-medals__wrapper .pwe-button-link {
                        transform-origin: center !important;
                    }
                    @media(min-width:650px) {
                        .pwe-medals__heading:first-of-type h4 {
                            font-size: 30px;
                        }
                        .pwe-medals__text p {
                            max-width: 900px;
                            margin: 18px auto 0;
                        }
                        .pwe-medals__item {
                            position: absolute;
                        }
                        .pwe-medals__item:nth-child(1) {
                            z-index: 4;
                            left: 5%;
                        }
                        .pwe-medals__item:nth-child(2) {
                            z-index: 3;
                            left: 25%;
                            filter: brightness(0.8);
                        }
                        .pwe-medals__item:nth-child(3) {
                            z-index: 2;
                            left: 45%;
                            filter: brightness(0.7);
                        }
                        .pwe-medals__item:nth-child(4) {
                            z-index: 1;
                            left: 65%;
                            filter: brightness(0.6);
                        }

                        .pwe-medals__item img {
                            width: 25vw;
                            max-width: 300px;
                            height: auto;
                        }
                    }
                    @media(max-width: 650px) {
                        .pwe-medals__wrapper {
                            padding: 18px;
                        }
                        .pwe-medals__text p {
                            line-height: 1.3;
                            text-align: left;
                        }
                        .pwe-medals__items {
                            display: flex;
                            flex-wrap: wrap;
                            justify-content: center;
                        }
                        .pwe-medals__item {
                            max-width: 100px;
                        }
                        .pwe-medals__item img {
                            width: 100%;
                        }
                        .pwe-medals__wrapper .pwe-medals__items_mobile {
                            display: block;
                        }
                        .pwe-medals__wrapper .pwe-medals__items {
                            display: none;
                        }
                    }
                    .pwe-medals .pwe-button-link {
                        color: ' . $btn_text_color . ';
                        background-color: ' . $btn_color . ';
                        border: 1px solid ' . $btn_border . ';
                        border-radius: 36px;
                        min-width: 240px;
                    }
                    .pwe-medals .pwe-button-link:hover {
                        color: white !important;
                        background-color: '. $darker_btn_color .'!important;
                        border: 1px solid '. $darker_btn_color .'!important;
                    }
                </style>';
            }

            $output .= '
            <div id="pweMedals" class="pwe-medals">
                <div class="pwe-medals__wrapper">
                    <div class="pwe-medals__heading">
                        <h4>'. self::languageChecker('Zdobądź prestiżową nagrodę w Ptak Warsaw Expo!', 'Win a prestigious award at Ptak Warsaw Expo!') .'</h4>
                    </div>
                    <div class="pwe-medals__text">'.
                        self::languageChecker(
                            <<<PL
                                <p>Dołącz do grona najlepszych na <strong>Targach Ptak Warsaw Expo</strong> i pokaż swoją firmę w świetle zwycięzców! Nagrody są przyznawane przez <strong>Krajową Izbę Targową</strong> oraz <strong>Ptak Warsaw Expo</strong>  – wyróżnij się i zdobądź uznanie!</p>
                            PL,
                            <<<EN
                                <p>Join the ranks of the best at <strong>Ptak Warsaw Expo</strong> and showcase your company as a winner! Awards are granted by the <strong>National Chamber of Trade Fairs</strong> and <strong>Ptak Warsaw Expo</strong> – stand out and gain recognition!</p>
                            EN
                        )
                    .'</div>
                    <div class="pwe-medals__items">
                        <div class="pwe-medals__item"><img src="'. self::languageChecker('/wp-content/plugins/PWElements/media/medals/innowacyjnosc.webp', '/wp-content/plugins/PWElements/media/medals/innowacyjnosc-en.webp') .'"/></div>
                        <div class="pwe-medals__item"><img src="'. self::languageChecker('/wp-content/plugins/PWElements/media/medals/premiera-targowa.webp', '/wp-content/plugins/PWElements/media/medals/premiera-targowa-en.webp') .'"/></div>
                        <div class="pwe-medals__item"><img src="'. self::languageChecker('/wp-content/plugins/PWElements/media/medals/produkt-targowy.webp', '/wp-content/plugins/PWElements/media/medals/produkt-targowy-en.webp') .'"/></div>
                        <div class="pwe-medals__item"><img src="'. self::languageChecker('/wp-content/plugins/PWElements/media/medals/ekspozycja-targowa.webp', '/wp-content/plugins/PWElements/media/medals/ekspozycja-targowa-en.webp') .'"/></div>
                    </div>';

                    $output .= '<div class="pwe-medals__items_mobile pwe-slides">';

                    foreach ($medals as $key => $paths) {
                        $img_src = self::languageChecker($paths['pl'], $paths['en']);
                        $output .= '<img data-no-lazy="1" src="' . htmlspecialchars($img_src, ENT_QUOTES, 'UTF-8') . '" alt="Medal ' . $key . '"/>';
                    }
                    $output .= '</div>';

                    // Dodanie slidera
                    include_once plugin_dir_path(__FILE__) . '/../scripts/slider.php';
                    $output .= PWESliderScripts::sliderScripts(
                        'pwe-medals__items_mobile',
                        '#pweMedals',
                        $opinions_dots_display = 'true',
                        $opinions_arrows_display = false,
                        5
                    );

                    $output .= '
                    <div class="pwe-medals__heading">
                        <h4>'. self::languageChecker('POKAŻ SIĘ ŚWIATU JAKO LIDER W PTAK WARSAW EXPO!', 'SHOWCASE YOURSELF AS A LEADER AT PTAK WARSAW EXPO!') .'</h4>
                    </div>
                    <div class="pwe-medals__button">
                        <a class="pwe-button-link btn" href="' . self::languageChecker('/zostan-wystawca/', '/en/become-an-exhibitor/') . '">'. self::languageChecker('Zostań wystawcą', 'Book a stand') .'</a>
                    </div>

                </div>
            </div>';
            }

        return $output;
    }
}