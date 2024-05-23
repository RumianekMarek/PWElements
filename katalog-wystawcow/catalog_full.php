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
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white');
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color);
        $btn_shadow_color = '9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black');
        $btn_border = '1px solid ' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color);

        $exhibitors = self::logosChecker($identification, $atts['format']);

        $output = '';

        $bg_link = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/background.webp') ? '/doc/background.webp' : '/doc/background.jpg';
        
        $output .= '
            <style>
                #katalog-'. self::$rnd_id .' .pwe-text-color {
                    text-align: center;
                    ' . $text_color . '
                    ' . $text_shadow . '
                }
                .exhibitors__buttons {
                    display: flex;
                    justify-content: center;
                    gap: 18px;
                    padding-bottom: 36px;
                }
                .exhibitors__buttons .pwe-btn-container {
                    padding-top: 0;
                }
                #katalog-'. self::$rnd_id .' .pwe-btn {
                    color: '. $btn_text_color .';
                    background-color:'. $btn_color .';
                    box-shadow:'. $btn_shadow_color .';
                    border:'. $btn_border .';
                    padding: 18px 0;
                    font-size: 14px;
                    font-weight: 600;
                    text-transform: uppercase;
                    transition: .3s ease;
                    text-align: center;
                }
                #katalog-'. self::$rnd_id .' .pwe-btn:hover {
                    color: white !important;
                    background-color: black;
                    box-shadow: 9px 9px 0px -5px '. $btn_color .';
                    border: 1px solid black;
                }
                @media (min-width:960px) {
                    #katalog-'. self::$rnd_id .' #full {
                        margin-left: 36px 
                    }
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
                    </div>';

                    // Get wordpress menus
                    $menus = wp_get_nav_menus();
                    $menu_array = array();
                    
                    foreach ($menus as $menu) {
                        $menu_name_lower = strtolower($menu->name);
                        $patterns = ['1 pl', '1 en', '2 pl', '2 en', '3 pl', '3 en'];
                        foreach ($patterns as $pattern) {
                            if (strpos($menu_name_lower, $pattern) !== false) {
                                $varName = 'menu_' . str_replace(' ', '_', $pattern);
                                $$varName = $menu->term_id;
                                break;
                            }
                        }
                    }

                    $menu_3_pl_items = wp_get_nav_menu_items($menu_3_pl);
                    $menu_3_en_items = wp_get_nav_menu_items($menu_3_en);

                    $menu_3_pl_data = array();
                    $menu_3_en_data = array();

                    foreach ($menu_3_pl_items as $item) {
                        $menu_3_pl_data[] = array(
                            'title' => $item->title,
                            'url' => $item->url
                        );
                    }

                    foreach ($menu_3_en_items as $item) {
                        $menu_3_en_data[] = array(
                            'title' => $item->title,
                            'url' => $item->url
                        );
                    }

                    $output .='
                    <div class="exhibitors__buttons">
                        <span class="pwe-btn-container">';
                            if (get_locale() == "pl_PL") {
                                $output .='<a href="'. $menu_3_pl_data[0]["url"] .'" class="pwe-btn" target="_blank">Zostań wystawcą</a>';
                            } else {
                                $output .='<a href="'. $menu_3_en_data[0]["url"] .'" class="pwe-btn" target="_blank">Become an exhibitor</a>';
                            } $output .='    
                        </span>';
                        if (get_locale() == "en_US") {
                            $output .='
                                <span class="pwe-btn-container">
                                    <a href="https://warsawexpo.eu/en/forms-for-agents/" class="pwe-btn" target="_blank">Become an agent</a>
                                </span>';
                        } $output .='     
                    </div>

                </div>
            </div>';

        return $output;
    }
}