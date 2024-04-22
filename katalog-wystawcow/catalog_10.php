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
            .pwe-text-color{
                text-align: center;
                ' . $text_color . '
                ' . $text_shadow . '
            }
        </style>
            <div id="top10" class="custom-catalog main-heading-text">
                <h2 class="catalog-custom-title" style="width: fit-content;">'.self::checkTitle($atts['title'], $atts['format']).'</h2>
                <div class="img-container-top10">';
                    if (($atts["slider_desctop"] == 'true' && self::checkForMobile() != '1' ) || ($atts["grid_mobile"] != 'true' && self::checkForMobile() == '1' )){
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
        $output .= '
                </div>
            </div>';
        return $output;
    }
}