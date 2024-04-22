<?php
class PWECatalog7 extends PWECatalog {

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
            <div id="recently7" class="custom-catalog main-heading-text">
                <h2 class="catalog-custom-title pwe-text-color" style="width: fit-content;">'.self::checkTitle($atts['title'], $atts['format']).'</h2>
                <div class="img-container-recently7">';
                    if (($atts["slider_desctop"] == 'true' && self::checkForMobile() != '1' ) || ($atts["grid_mobile"] != 'true' && self::checkForMobile() == '1' )){
                        $slider_array = array();
                        foreach($exhibitors as $exhibitor){
                            $slider_array[] = array(
                                'img' => $exhibitor['URL_logo_wystawcy'],
                                'site' => "https://" . preg_replace('/^(https?:\/\/(www\.)?|(www\.)?)/', '', $exhibitor['www'])
                            );
                        }                        
                        require_once plugin_dir_path(dirname( __FILE__ )) . 'scripts/logotypes-slider.php';
                        var_dump($slider_array);
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
                <div>
                    <span style="display: flex; justify-content: center;" class="btn-container">'.
                        self::languageChecker(
                            <<<PL
                                <a href="/katalog-wystawcow" class="custom-link btn border-width-0 btn-accent btn-square shadow-black" title="Katalog wystawców">Zobacz więcej</a>
                            PL,
                            <<<EN
                                <a href="/en/exhibitors-catalog/" class="custom-link btn border-width-0 btn-accent btn-square shadow-black" title="Exhibitor Catalog">See more</a>
                            EN
                        )
                    .'</span>
                </div>
            </div>';
            
        return $output;
    }
}