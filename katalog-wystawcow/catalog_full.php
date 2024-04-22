<?php
class PWECatalogFull extends PWECatalog {

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
    // public static function initElements() {
    // }
    public static function output($atts, $identification) {     
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important;';
        $text_shadow = 'text-shadow: 2px 2px ' . self::findColor($atts['text_shadow_color_manual_hidden'], $atts['text_shadow_color'], 'black') . '!important;';

        $exhibitors = self::logosChecker($identification, $atts['format']);

        $output = '';

        $bg_link = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/background.webp') ? '/doc/background.webp' : '/doc/background.jpg';
        
        $output .= '
            <style>
                .pwe-text-color{
                    text-align: center;
                    ' . $text_color . '
                    ' . $text_shadow . '
                }
            </style>

            <div id="full">
                <div class="exhibitors">
                    <div class="exhibitor__header" style="background-image: url(&quot;'. $bg_link .'&quot;);">
                        <div>
                            <h1 class="pwe-text-color fontsize-">'. self::checkTitle($atts['katalog_year'], $atts['format']) .'</h1>
                            <h2 class="pwe-text-color">'.
                                self::languageChecker(
                                    <<<PL
                                        [trade_fair_name]
                                    PL,
                                    <<<EN
                                        [trade_fair_name_eng]
                                    EN
                                )
                            .'</h2>
                        </div>
                        <input id="search" placeholder="'.
                            self::languageChecker(
                                <<<PL
                                Szukaj
                                PL,
                                <<<EN
                                Search
                                EN
                            )
                        .'"/>
                    </div>
                    
                    <div class="exhibitors__container">';
                        //WYSTAWCY
                        foreach ($exhibitors as $exhibitor) {
                            $singleExhibitor = '<div class="exhibitors__container-list">';
                            if ($exhibitor['URL_logo_wystawcy']) {
                                $singleExhibitor .= '<div class="exhibitors__container-list-img" style="background-image: url(' . $exhibitor['URL_logo_wystawcy'] . ')"></div>';
                            }
                            if ($stand !== 'true') {
                                $singleExhibitor .= '<div class="exhibitors__container-list-text">
                                                        <h2 class="exhibitors__container-list-text-name">' . $exhibitor['Nazwa_wystawcy'] . '</h2>
                                                        <p>' . $exhibitor['Numer_stoiska'] . '</p>
                                                    </div>';
                            } else {
                                $singleExhibitor .= '<h2 class="exhibitors__container-list-text-name">' . $exhibitor['Nazwa_wystawcy'] . '</h2>';
                            }
                            $singleExhibitor .= '</div>';
                            $divContainerExhibitors .= $singleExhibitor;
                        }

                        $output .= $divContainerExhibitors;

                        $output .='
                    </div>
                </div>
            </div>';

        return $output;
    }
}