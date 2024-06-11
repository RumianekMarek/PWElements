<?php
class PWECatalog10 extends PWECatalog {

    /**
     * Constructor method.
    * Calls parent constructor and adds an action for initializing the Visual Composer map.
    */
    public function __construct() {
        parent::__construct();
    }

    public static function output($atts, $identification) {
        
        $exhibitors = self::logosChecker($identification, $atts['format']);

        $output = '';

        $output .= '
        <style>
            .row-container:has(.pwe-registration) .exhibitors-catalog {
                border: 2px solid #564949 !important;
                margin-top: 0 !important;
            }
            .row-container:has(.pwe-registration) :is(.wpb_column, .uncol, .uncoltable, .uncont, .exhibitors-catalog, .custom-catalog){
                height: inherit !important;
            }
            .row-container:has(.pwe-registration) #top10 .catalog-custom-title {
                margin-top: 45px !important;
            }
            .row-container:has(.pwe-registration) .img-container-top10 {
                height: 80%;
            }
            .pwe-text-color{
                text-align: center;
                ' . $text_color . '
                ' . $text_shadow . '
            }
            .custom-catalog-bg {
                width: 100%;
                height: 100%;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .custom-catalog-bg img {
                max-width: 300px;
                padding: 18px 0;
            }
        </style>

        <div id="top10" class="custom-catalog main-heading-text">';
            if (count($exhibitors) < 10) {
                $logo_file_path = get_locale() == 'pl_PL' ? '/doc/logo' : '/doc/logo-en';
                $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . $logo_file_path . '.webp') ? $logo_file_path . '.webp' : (file_exists($_SERVER['DOCUMENT_ROOT'] . $logo_file_path . '.png') ? $logo_file_path . '.png' : '');
                $bg_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/header_mobile.webp') ? '/doc/header_mobile.webp' : (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/header_mobile.jpg') ? '/doc/header_mobile.jpg' : '');
                $output .= '
                <div class="custom-catalog-bg" style="background-image: url('. $bg_url .');">
                    <img src="'. $logo_url .'" alt="logo-[trade_fair_name]">
                </div>';
            } else {
                $output .= '
                <h2 class="catalog-custom-title" style="width: fit-content;">'.self::checkTitle($atts['title'], $atts['format']).'</h2>
                <div class="img-container-top10">';
                    if (($atts["slider_desktop"] == 'true' && self::checkForMobile() != '1' ) || ($atts["grid_mobile"] != 'true' && self::checkForMobile() == '1' )){
                        $slider_array = array();
                        foreach($exhibitors as $exhibitor){
                            $slider_array[] = array(
                                'img' => $exhibitor['URL_logo_wystawcy'],
                                'site' => "https://" . preg_replace('/^(https?:\/\/(www\.)?|(www\.)?)/', '', $exhibitor['www'])
                            );
                        }                        
                        require_once plugin_dir_path(dirname( __FILE__ )) . 'scripts/logotypes-slider.php';
                        $output .= PWELogotypesSlider::sliderOutput($slider_array);
    
                    } else { 
                        foreach ($exhibitors as $exhibitor){
                            $exhibitorsUrl = "https://" . preg_replace('/^(https?:\/\/(www\.)?|(www\.)?)/', '', $exhibitor['www']);
                            $output .= '
                                <a target="_blank" href="'. $exhibitorsUrl .'">
                                    <div style="background-image: url(' . $exhibitor['URL_logo_wystawcy'] . ');"></div>
                                </a>';
                        }
                    }
            $output .= '</div>';
            }
        $output .= '</div>';

        return $output;
    }
}