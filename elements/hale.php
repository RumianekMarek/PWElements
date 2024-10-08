<?php
/**
* Class PWElementHale
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementHale extends PWElements {

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
    */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Dispaly Logo Color', 'pwelement'),
                'param_name' => 'logo_color_hala',
                'description' => __('Check Yes to display logo color.', 'pwelement'),
                'value' => 'true',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHale',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Hale', 'pwelement'),
                'param_name' => 'hale_text',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHale',
                ),
            ),
        );
        return $element_output;
    }
    public static function output($atts) {

        

        extract( shortcode_atts( array(
            'logo_color_hala' => '',
            'hale_text' => '',
        ), $atts ));

        $logo_href = '';
        $logo_color = self::findBestLogo($logo_color_hala);
        $logo_color_array = explode('"', $logo_color);
        foreach($logo_color_array as $href){
            if(strpos(strtolower($href), '/doc/') !== false){
                $logo_href = $href;
            }
        }

        $output = '';

        $output .= '
            <style>
                .hale-'. self::$rnd_id .' {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }
                .hale-'. self::$rnd_id .' .hale_info img {
                    max-width:250px;
                }
                .hale-'. self::$rnd_id .' .hale_info .information p {
                    margin-top: 0px;
                    font-size: 18px;
                }
                .hale-'. self::$rnd_id .' .hale_info .upper{
                    text-transform: uppercase;
                }
                .hale-'. self::$rnd_id .' .hale_info .location {
                    margin-top: 20px !important;
                    font-size: 13px;
                }
                .hale-'. self::$rnd_id .' .hale-img {
                    max-width:70%;
                }
                @media(max-width:680px){
                    .hale-'. self::$rnd_id .' {
                        flex-direction:column;
                    }
                    .hale-'. self::$rnd_id .' .hale-img {
                        margin-top:20px;
                        max-width:100%;
                    }
                }
            </style>
            <div id="hale" class="hale-'. self::$rnd_id .'">
                <div class="hale_info">
                    <img src="'. $logo_href .'" />
                    <div class="information">
                        <p class="upper"><strong>'.
                            self::languageChecker(
                                <<<PL
                                    [trade_fair_date]
                                PL,
                                <<<EN
                                    [trade_fair_date_eng]
                                EN
                            )
                            .'</strong></p>
                        <p>'. $hale_text .'</p>
                        <p>10:00-17:00</p>
                        <p class="upper">'.
                            self::languageChecker(
                                <<<PL
                                    DARMOWY PARKING
                                PL,
                                <<<EN
                                    FREE PARKING
                                EN
                            )
                            .'</p>
                    </div>
                    <div class="location">
                        <i class="fa fa-location2 fa-1x fa-fw"></i>
                        Al. Katowicka 62,05-830 Nadarzyn
                    </div>
                </div>
                <div class="hale-img">
                    <img src="/doc/hale.png">
                </div>
           </div>';

    return $output;
    }
}
