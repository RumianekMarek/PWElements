<?php

/**
 * Class PWElementMapa
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementMapa extends PWElements {

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
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Custom title first', 'pwelement'),
                'param_name' => 'pwe_custom_title',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMapa',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number of visitors', 'pwelement'),
                'param_name' => 'pwe_number_visitors',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMapa',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number of exhibitors', 'pwelement'),
                'param_name' => 'pwe_number_exhibitors',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMapa',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Number of countries', 'pwelement'),
                'param_name' => 'pwe_number_countries',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMapa',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Percent of polish visitors', 'pwelement'),
                'param_name' => 'pwe_percent_polish_visitors',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMapa',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Date of events', 'pwelement'),
                'param_name' => 'pwe_event_date',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMapa',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Exhibition space', 'pwelement'),
                'param_name' => 'pwe_exhibition_space',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMapa',
                ),
            ),
        );
        return $element_output;
    }

    public static function output($atts) {

        extract( shortcode_atts( array(
            'pwe_custom_title' => '',
            'pwe_number_visitors' => '',
            'pwe_number_exhibitors' => '',
            'pwe_number_countries' => '',
            'pwe_percent_polish_visitors' => '',
            'pwe_event_date' => '',
            'pwe_exhibition_space' => '',
        ), $atts ));

        $pwe_number_visitors = !empty($pwe_number_visitors) ? $pwe_number_visitors : 0;
        $pwe_percent_polish_visitors = !empty($pwe_percent_polish_visitors) ? $pwe_percent_polish_visitors : 0;
        $pwe_number_countries = !empty($pwe_number_countries) ? $pwe_number_countries : 15;

        $output = '
        <style>
            .pwe-mapa-staticts {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
            }
            .pwe-mapa-staticts h2 {
                margin-top: 0;
                text-transform: uppercase;
                font-size: 40px;
                max-width: 550px;
            }
            .pwe-container-mapa {
                display:flex;
                justify-content:space-between;
                min-height:50vh;
            }
            .pwe-mapa-rounded-stat {
                display: flex;
                gap: 15px;
            }
            .pwe-mapa-rounded-element {
                width: 120px;
                min-height: 120px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                border:5px solid;
                border-radius:100%;
                text-align: center;
            }
            .pwe-mapa-rounded-element p {
                margin-top:0px;
                line-height: 1;
            }
            .pwe-mapa-stats-element-title {
                font-weight: 700;
                font-size: 28px;
            }
            .pwe-mapa-stats-element-desc {
                font-size: 25px;
            }
            .pwe-mapa-stats-element-title, .pwe-mapa-stats-element-desc {
                line-height: 1;
            }
            .pwe-mapa-stats-element {
                margin:20px 0;
            }
            .pwe-mapa-stats-element p {
                margin-top:0px !important;
            }
            .pwe-container-mapa {
                background-image:url(/doc/mapka.webp);
                background-position: center;
                background-size: contain;
                background-repeat: no-repeat;
                display:flex;
                justify-content: space-between;
            }
            .pwe-mapa-stats-element-mobile {
                display:none;
            }
            .pwe-mapa-logo-container img {
                max-width: 250px;
            }
            .pwe-mapa-right {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                align-items: flex-end;
            }
            .pwe-mapa-right-data {
                margin-top:0;
                font-weight:750;
                font-size: 20px;
            }
            .pwe-mapa-rounded-element-country-right {
                display:none;
            }
            @media (min-width: 1200px){
                .pwe-container-mapa {
                    height: 670px;
                }
            }
            @media(max-width:1100px){
                .pwe-mapa-rounded-element-country-right {
                    display:flex;
                }
                .pwe-mapa-logo-container img {
                    max-width: 200px;
                }
                .pwe-mapa-stats-element-title, .pwe-mapa-stats-element-desc {
                    font-size: 20px;
                }
                .pwe-mapa-staticts h2 {
                    font-size: 25px;
                    max-width: 550px;
                }
                .pwe-mapa-rounded-element {
                    width: 120px;
                    min-height: 120px;
                    border: 3px solid;
                    margin-left: 15px;
                }
                .pwe-mapa-rounded-element-country {
                    display:none;
                }
            }
            @media (max-width: 599px){
                .pwe-mapa-staticts {
                    width: 100%;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                }
                .pwe-mapa-right {
                    display:none;
                }
                .pwe-mapa-stats-element-mobile, .pwe-mapa-rounded-element-country  {
                    display:flex;
                }
                .pwe-container-mapa {
                    background-image:none;
                    justify-content: center;
                }
                .pwe-mapa-rounded-stat {
                    margin: 20px 0 15px;
                }
                .pwe-mapa-stats-container {
                    width:100%;
                }
                .pwe-mapa-staticts .mobile-estymacje-image {
                    margin-top:0 !important;
                    height:230px;
                    background-image:url(/doc/mapka_mobile.webp);
                    background-position: center;
                    background-size: contain;
                    background-repeat: no-repeat;
                }
                .pwe-mapa-stats-element {
                    margin: 10px 0 0;
                }
            }
        </style>

        <div id="pweMapa" class="pwe-container-mapa">
            <div class="pwe-mapa-staticts">
                <h2 class="text-accent-color">'. $pwe_custom_title .'</h2>
                <div class="pwe-mapa-rounded-stat">
                    <div class="pwe-mapa-rounded-element text-accent-color">
                        <p style="font-weight: 800; font-size: 21px;">'. $pwe_number_visitors .'</p>
                        <p style="font-size:12px">'.
                            self::languageChecker(
                            <<<PL
                            odwiedzających
                            PL,
                            <<<EN
                            visitors
                            EN
                            )
                        .'</p>
                    </div>
                    <div class="pwe-mapa-rounded-element pwe-mapa-rounded-element-country">
                        <p style="font-weight: 800; font-size: 27px;">'. $pwe_number_countries .'</p>
                        <p style="font-size:12px">'.
                            self::languageChecker(
                            <<<PL
                            krajów
                            PL,
                            <<<EN
                            countries
                            EN
                            )
                        .'</p>
                    </div>
                </div>
                <div class="pwe-mapa-stats-container">
                    <div class="pwe-mapa-stats-element">
                        <p class="text-accent-color pwe-mapa-stats-element-title">'.
                            self::languageChecker(
                                <<<PL
                                Polska -
                                PL,
                                <<<EN
                                Poland -
                                EN
                            ).' '. floor($pwe_number_visitors / 100 * $pwe_percent_polish_visitors) .'</p>
                        <p class="pwe-mapa-stats-element-desc">'. $pwe_percent_polish_visitors .' %</p>
                    </div>
                    <div class="pwe-mapa-stats-element">
                        <p class="text-accent-color pwe-mapa-stats-element-title">'.
                        self::languageChecker(
                            <<<PL
                            Zagranica -
                            PL,
                            <<<EN
                            Abroad -
                            EN
                        ).' '. ($pwe_number_visitors-floor($pwe_number_visitors / 100 * $pwe_percent_polish_visitors)) .'</p>
                        <p class="pwe-mapa-stats-element-desc">'. (100 - $pwe_percent_polish_visitors) .' %</p>
                    </div>
                    <div class="mobile-estymacje-image"></div>
                    <div class="pwe-mapa-stats-element">
                        <p class="text-accent-color pwe-mapa-stats-element-title">'. $pwe_exhibition_space .' m<sup>2</sup></p>
                        <p class="pwe-mapa-stats-element-desc">'.
                            self::languageChecker(
                                <<<PL
                                powierzchni<br>wystawienniczej
                                PL,
                                <<<EN
                                exhibition<br>space
                                EN
                            )
                        .'</p>
                    </div>
                    <div class="pwe-mapa-stats-element">
                        <p class="text-accent-color pwe-mapa-stats-element-title">'. $pwe_number_exhibitors .'</p>
                        <p class="pwe-mapa-stats-element-desc">'.
                            self::languageChecker(
                                <<<PL
                                wystawców
                                PL,
                                <<<EN
                                exhibitors
                                EN
                            )
                        .'</p>
                    </div>
                </div>
            </div>
            <div class="pwe-mapa-right">
                <div class="pwe-mapa-logo-container">'.
                    self::languageChecker(
                    <<<PL
                    <img src="/doc/logo-color.webp"/>
                    PL,
                    <<<EN
                    <img src="/doc/logo-color-en.webp"/>
                    EN
                    )
                    .'<p class="pwe-mapa-right-data" style="text-align: center;">'. $pwe_event_date .'</p>
                </div>

            <div class="pwe-mapa-rounded-element pwe-mapa-rounded-element-country-right">
                <p style="font-weight: 800; font-size: 24px;">'. $pwe_number_countries .'</p>
                <p style="font-size:12px">
                    '.
                    self::languageChecker(
                    <<<PL
                    krajów
                    PL,
                    <<<EN
                    countries
                    EN
                    )
                .'</p>
            </div>
            </div>
        </div>';

        return $output;
    }
}