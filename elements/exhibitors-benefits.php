<?php
/**
* Class PWElementExhibitors
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementExhibitors extends PWElements {

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
        $element_output = 
        array(
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Logo in color', 'pwelement'), 
                'param_name' => 'logo_color',
                'value' => '',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementExhibitors',
                )
            ),
        );
        return $element_output;
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';
        $btn_text_color = 'color:' . self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important; border-width: 0 !important;';
        $btn_color = 'background-color:' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color']) . '!important;';
        $btn_shadow_color = 'box-shadow: 9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black') . '!important;';

        $border_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black');
        
        $output = '';

        $output .= '
            <style>

            .pwelement_'. self::$rnd_id .' .image-shadow {
                box-shadow: 9px 9px 0px -6px ' . self::$fair_colors['Accent'] . ';
            }
            .pwelement_'. self::$rnd_id .' .pwe-container-exhibitors-benefits {
                margin: 0 auto;
            }
            .pwelement_'. self::$rnd_id .' .pwe-row-benefits {
                width: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .pwelement_'. self::$rnd_id .' .pwe-benefits {
                width: 100%;
                display: flex;
                gap: 36px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-benefit-item {
                width: 33%;
            }
            .pwelement_'. self::$rnd_id .' .pwe-benefit-img img {
                width: 100%;
                border-radius: 18px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-benefit-text p {
                padding:18px 0;
                ' . $text_color . '
            }
            .pwelement_'. self::$rnd_id .' .pwe-button {
                '.$btn_text_color 
                .$btn_color 
                .$btn_shadow_color.'
                box-shadow: unset !important;
                border-radius: 10px !important;
            }
            .pwelement_'. self::$rnd_id .' .pwe-border-top-left {
                box-shadow: -3px -3px ' . $border_color . ';
                margin-left: -18px;
                width: 170px !important;
                height: 40px;
            }

            .pwelement_'. self::$rnd_id .' .pwe-border-bottom-right {
                box-shadow: 3px 3px ' . $border_color . ';
                margin-right: -18px;
                width: 170px !important;
                height: 40px;
                float: right;
            }

            @media (max-width:570px) {
                .pwelement_'. self::$rnd_id .' .pwe-benefits {
                    flex-direction: column;
                }
                .pwelement_'. self::$rnd_id .' .pwe-benefit-item {
                    width: 100%;
                }  
            }
            </style>

            <div id="exhibitorsBenefits" class="pwe-container-exhibitors-benefits">

                <div id="main-content" class="pwe-row-border">
                    <div class="pwe-border-top-left"></div>
                </div>
                    <!-- benefit-container -->'.
                self::languageChecker(
                    <<<PL
                    <div class="pwe-row-benefits">
                        <div class="pwe-benefits" style="justify-content: center;">
                            <div class="pwe-benefit-item">
                                <div class="pwe-benefit-img">
                                    <img src="/wp-content/plugins/pwe-media/media/ulga_pl.png" alt="Strefa Networkingu">
                                </div>
                                <div class="pwe-btn-container" style="padding: 18px;">
                                    <span>
                                        <a class="pwe-button btn btn-accent btn-flat" href="https://warsawexpo.eu/dla-organizatorow/#ulga"  target="_blank">Zobacz szczegóły</a>
                                    </span>
                                </div>   
                            </div>
                        </div>
                    </div>
                    PL
                )
                .'<div class="pwe-row-benefits">
                    <div class="pwe-benefits">

                    <!-- benefit-item -->
                        <div class="pwe-benefit-item">
                            <div class="pwe-benefit-img">'.
                                self::languageChecker(
                                    <<<PL
                                    <img src="/wp-content/plugins/pwe-media/media/Strefa_Networkingu.png" alt="Strefa Networkingu">
                                    PL,
                                    <<<EN
                                    <img src="/wp-content/plugins/pwe-media/media/Networking_Zone.png" alt="Networking Zone">
                                    EN
                                )
                            .'</div>
                            <div class="pwe-benefit-text uncode_text_column pwe-align-left">
                                <p class="pwe-line-height">'.
                                self::languageChecker(
                                    <<<PL
                                    Podczas targów dostępna będzie, specjalnie wydzielona <strong>strefa networkingu</strong> – przestrzeń do wymiany doświadczeń i zacieśnienia kontaktów. Spotkania branżowe to idealna okazja do poszerzenia grona potencjalnych partnerów biznesowych, a także zbudowania bazy odbiorców.
                                    PL,
                                    <<<EN
                                    During the fair, a specially separated networking zone will be available - a space for exchanging experiences and strengthening contacts. Industry meetings are an ideal opportunity to expand the group of potential business partners, as well as build a pweer base.
                                    EN
                                )
                                .'</p>
                            </div>
                        </div>

                        <!-- benefit-item -->
                        <div class="pwe-benefit-item">
                            <div class="pwe-benefit-img">'.
                                self::languageChecker(
                                    <<<PL
                                    <img src="/wp-content/plugins/pwe-media/media/Panel_Edukacyjny.png" alt="Panel Edukacyjny">
                                    PL,
                                    <<<EN
                                    <img src="/wp-content/plugins/pwe-media/media/Educational_Panel.png" alt="Educational Panel">
                                    EN
                                )
                            .'</div>
                            <div class="pwe-benefit-text uncode_text_column pwe-align-left">
                                <p class="pwe-line-height">'.
                                self::languageChecker(
                                    <<<PL
                                    Liczne wystąpienia i konferencja branżowa prowadzona przez uznanych prelegentów – doświadczonych praktyków i znawców branży.
                                    PL,
                                    <<<EN
                                    Numerous speeches and an industry conference conducted by recognized speakers - experienced practitioners and industry experts.
                                    EN
                                )
                                .'</p>
                            </div>
                        </div>

                        <!-- benefit-item -->
                        <div class="pwe-benefit-item">
                            <div class="pwe-benefit-img">'.
                                self::languageChecker(
                                    <<<PL
                                    <img src="/wp-content/plugins/pwe-media/media/Pakiety_Powitalne.png" alt="Pakiety Powitalne">
                                    PL,
                                    <<<EN
                                    <img src="/wp-content/plugins/pwe-media/media/Welcome_Package.png" alt="Welcome Package">
                                    EN
                                )
                            .'</div>
                            <div class="pwe-benefit-text uncode_text_column pwe-align-left">
                                <p class="pwe-line-height">'.
                                self::languageChecker(
                                    <<<PL
                                    Przygotowanie identyfikatorów oraz indywidualnych pakietów powitalnych do wszystkich zarejestrowanych, które zostaną przesłane bezpośrednio pod adres podany w formularzu rejestracyjnym.
                                    PL,
                                    <<<EN
                                    Preparation of badges and individual welcome packages for all registered, which will be sent directly to the address provided in the registration form.
                                    EN
                                )
                                .'</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pwe-row-border">
                    <div class="pwe-border-bottom-right"></div>
                </div>
                
            </div>';

    return $output;
    }
}


