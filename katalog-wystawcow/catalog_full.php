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
        $stand = isset($atts['stand']) ? $atts['stand'] : false;

        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important';
        $text_shadow = self::findColor($atts['text_shadow_color_manual_hidden'], $atts['text_shadow_color'], 'black') . '!important';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white');
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$accent_color);
        $btn_shadow_color = self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black');
        $btn_border = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], self::$accent_color);

        $divContainerExhibitors = '';
        
        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        $exhibitors = self::logosChecker($identification, $atts['format']);

        $output = '';

        $bg_link = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/background.webp') ? '/doc/background.webp' : '/doc/background.jpg';
        
        $output .= '
            <style>
                #katalog-'. self::$rnd_id .' .pwe-text-color {
                    text-align: center;
                    color: '. $text_color .';
                    text-shadow: 2px 2px '. $text_shadow .';
                }
                .exhibitors__buttons {
                    display: flex;
                    flex-wrap: wrap;
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
                    border: 1px solid '. $btn_border .';
                    padding: 18px 0;
                    font-size: 14px;
                    font-weight: 600;
                    text-transform: uppercase;
                    transition: .3s ease;
                    text-align: center;
                    box-shadow: unset !important;
                    border-radius: 10px !important;
                }
                #katalog-'. self::$rnd_id .' .pwe-btn:hover {
                    color: '. $btn_text_color .';
                    background-color: '. $darker_btn_color .'!important;
                    border: 1px solid '. $darker_btn_color .'!important;
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
                    echo '<script>console.log("'.get_locale().'")</script>';
                    
                    if (get_locale() == 'pl_PL'){
                        $menu_3_data = wp_get_nav_menu_items($menu_3_pl);
                    } else {
                        $menu_3_data = wp_get_nav_menu_items($menu_3_en);
                    }

                    $menu_3 = array();

                    foreach ($menu_3_data as $item) {
                        $menu_3[] = array(
                            'title' => $item->title,
                            'url' => $item->url
                        );
                    }
                    
                    $output .='
                    <div class="exhibitors__buttons">
                        <span class="pwe-btn-container">';
                            if (get_locale() == "pl_PL") {
                                $output .='<a href="'. $menu_3[0]["url"] .'" class="pwe-btn">Zostań wystawcą</a>';
                            } else {
                                $output .='<a href="'. $menu_3[0]["url"] .'" class="pwe-btn">Become an exhibitor</a>';
                            } $output .='    
                        </span>';

                        if (get_locale() == "en_US") {
                            $output .='
                                <span class="pwe-btn-container">
                                    <a href="https://warsawexpo.eu/en/forms-for-agents/" class="pwe-btn" target="_blank">Become an agent</a>
                                </span>';
                        } 
                        
                        $output .='     
                    </div>
                </div>
            </div>';

        return $output;
    }
}