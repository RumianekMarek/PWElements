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
            array(
                'type' => 'param_group',
                'group' => 'PWE Element',
                'heading' => __('Side events logotypes', 'pwelement'),
                'param_name' => 'hale_logotypes',
                'params' => array(
                    array(
                    'type' => 'attach_image',
                    'heading' => __('Event logotype', 'pwelement'),
                    'param_name' => 'logotype_media',
                    'save_always' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Event link', 'pwelement'),
                        'param_name' => 'logotype_link',
                        'save_always' => true
                    ),
                ),
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
            'hale_text' => '',
            'hale_logotypes' => '',
        ), $atts ));

        $map_href_pl = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/hale.webp') ? '/doc/hale.webp' : "/doc/hale.png";
        $map_href_en = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/hale-en.webp') ? '/doc/hale-en.webp' : "/doc/hale-en.png";

        if (PWECommonFunctions::lang_pl()) {
            $logo_href = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color.webp') ? '/doc/logo-color.webp' : "/doc/logo.webp";
            $map_href = $map_href_pl;
        } else {
            $logo_href = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color-en.webp') ? '/doc/logo-color-en.webp' : "/doc/logo-color-en.webp";
            $map_href = file_exists($_SERVER['DOCUMENT_ROOT'] . $map_href_en) ? $map_href_en : $map_href_pl;   
        }

        $hale_logotypes_urldecode = urldecode($hale_logotypes);
        $hale_logotypes_json = json_decode($hale_logotypes_urldecode, true);
        foreach ($hale_logotypes_json as $logotype) {
            $logotypes_media[] = $logotype["logotype_media"];
        }

        $output = '';

        $output .= '
            <style>
                .hale-'. self::$rnd_id .' {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    position: relative;
                }
                .hale-'. self::$rnd_id .' .hale_info img {
                    max-width:250px;
                }
                .hale-'. self::$rnd_id .' .hale_info .information {
                    margin-top: 18px;
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
                    max-width: 70%;
                }
                .hale-'. self::$rnd_id .' .hale_info .side-events-title  {
                    text-align: center;
                    font-size: 14px;
                }
                .hale-'. self::$rnd_id .' .hale_info .side-events-logotypes  {
                    display: flex;
                    gap: 18px;
                    padding-top: 10px;
                }
                .hale-'. self::$rnd_id .' .hale_info .side-events-logotypes a  {
                    display: flex;
                }
                .hale-'. self::$rnd_id .' .hale_info .side-events-logotypes img  {
                    max-width: 120px;
                    width:: 100%;
                    object-fit: contain;
                }

                @media(min-width:681px){
                    .hale-'. self::$rnd_id .' .hale_info .side-events {
                        position: absolute;
                        right: 0;
                        bottom: -20px;
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                    }
                }
                @media(max-width:680px){
                    .hale-'. self::$rnd_id .' {
                        flex-direction:column;
                    }
                    .hale-'. self::$rnd_id .' .hale-img {
                        margin-top:20px;
                        max-width:100%;
                    }
                    .hale-'. self::$rnd_id .' .hale_info .side-events-logotypes  {
                        justify-content: space-around;
                    }
                }
            </style>

            <div id="hale" class="hale-'. self::$rnd_id .'">
                <div class="hale_info">
                    <div class="hale_info-container">
                        <img src="'. $logo_href .'"/>
                        <div class="information">
                            <p class="upper"><strong>'. self::languageChecker('[trade_fair_date]', '[trade_fair_date_eng]') .'</strong></p>
                            <p>'. $hale_text .'</p>
                            <p>10:00-17:00</p>
                            <p class="upper">'. self::languageChecker('DARMOWY PARKING', 'FREE PARKING') .'</p>
                        </div>
                        <div class="location">
                            <i class="fa fa-location2 fa-1x fa-fw"></i>
                            Al. Katowicka 62,05-830 Nadarzyn
                        </div>
                    </div>';

                    if (is_array($hale_logotypes_json) && !empty($logotypes_media[0])) {
                        $output .= '<div class="side-events">
                            <h5 class="side-events-title">'. self::languageChecker('Inne wydarzenia podczas targów', 'Other events during the fair') .'</h5>
                            <div class="side-events-logotypes">';
                                foreach ($hale_logotypes_json as $logotype) {
                                    $logotype_media = $logotype["logotype_media"];
                                    $logotype_url = wp_get_attachment_url($logotype_media);
                                    $logotype_link = $logotype["logotype_link"];

                                    $output .= '<a target="_blank" href="'. $logotype_link .'"><img src="'. $logotype_url .'" /></a>';
                                }    
                            $output .= '
                            </div>
                        </div>';
                    }
                    $output .= '
                </div>
                <div class="hale-img">
                    <img src="'. $map_href .'">
                </div>
           </div>';

    return $output;
    }
}
