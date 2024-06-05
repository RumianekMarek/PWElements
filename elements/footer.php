<?php 

/**
 * Class PWElementFooter
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementFooter extends PWElements {

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
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Change the logo color to white?', 'pwelement'),
                'param_name' => 'footer_logo_color_invert',
                'description' => __('Check Yes to display footer logo color white.', 'pwelement'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementFooter',
                ),
            ),
        );
        return $element_output;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {   
        extract( shortcode_atts( array(
            'footer_logo_color_invert' => '',
        ), $atts ));
   
        $output = '
        <style>
            .row-parent:has(.pwe-footer) {
                max-width: 100%;
                padding: 0 !important;  
            }
            .wpb_column:has(.pwe-footer) {
                padding: 0 !important;  
            }
            .pwe-footer-bg {
                position: relative;
                padding: 36px;
                background-size: cover;
            }
            .pwe-footer-bg:after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.2);
                opacity: .4;
            }
            .pwe-footer-bg-wrapper {
                max-width: 1200px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 36px;
            }
            .pwe-footer-bg-limit {
                max-width: 950px;
                margin: 0 auto;
                display: flex;
                flex-direction: column;
                gap: 36px;
            }
            .pwe-footer-images-bg img {
                width: 100%;
                object-fit: contain;
            }
            .pwe-footer-bg, .pwe-footer-images-bg {
                background-position: center;
                background-repeat: no-repeat;
            }
            .pwe-footer-logo-pwe {
                width: 100%;
                display: flex;
                float: left;
            }
            .pwe-footer-logo-pwe img {
                width: 140px;
            }
            .pwe-footer-title-section h4 span {
                color: white;
                width: auto;
            }
            .pwe-footer-title-section h2 {
                margin: 0;
                width: auto !important;
            }
            .pwe-footer-title-pl {
                color: white;
                font-size: 96px;  
            }
            .pwe-footer-title-en {
                color: white;
                font-size: 84px; 
            }
            @media (min-width: 320px) and (max-width: 1200px) { 
                .pwe-footer-title-pl { 
                    font-size: calc(24px + (96 - 24) * ( (100vw - 320px) / ( 1200 - 320) )); 
                } 
                .pwe-footer-title-en { 
                    font-size: calc(24px + (84 - 24) * ( (100vw - 320px) / ( 1200 - 320) )); 
                } 
            }
            .pwe-footer-benefits {
                display: flex;
                justify-content: space-around;
            }
            .pwe-footer-benefits p {
                text-align: center;
                font-size: 14px;
                font-weight: 700;
                color: white;
                text-shadow: 0 0 10px black;
            }
            .pwe-footer-nav {
                background-color: black;
                padding: 36px;
            }
            .pwe-footer-nav-wrapper {
                display: flex;
                width: 100%;
                max-width: 1200px;
                margin: 0 auto;
                gap: 18px;
            }
            .pwe-footer-nav-left-column, 
            .pwe-footer-nav-right-column {
                display: flex;
                gap: 18px;
            }
            .pwe-footer-nav-left-column {
                width: 25%;
            }
            .pwe-footer-nav-right-column {
                width: 75%;
            }
            .pwe-footer-nav-logo-column {
                width: 100%;
            }
            .pwe-footer-nav-column {
                width: 33.333%;
            }
            .pwe-footer-nav-column h5 span {
                color: white;
            }
            .pwe-footer-nav-logo-top,
            .pwe-footer-nav-logo-bottom {
                max-width: 200px !important;
            }
            .pwe-footer-nav-logo-bottom img {
                padding: 8px;
                max-height: 150px;
                object-fit: contain;
            }
            .pwe-footer-nav-links ul {
                padding: 0 !important;
                list-style: none !important;
            }
            .pwe-footer-nav-links ul li a {
                color: white !important;
            }
            @media (max-width:1000px){
                .pwe-footer-benefits {
                    flex-direction: column;
                    justify-content: center;
                }
                .pwe-footer-nav-column h5 span {
                    font-size: 16px;
                }
                .pwe-footer-nav-left-column {
                    width: 30%;
                }
                .pwe-footer-nav-right-column {
                    width: 70%;
                    flex-wrap: wrap;
                    justify-content: space-between;
                }
                .pwe-footer-nav-column {
                    width: 47%;
                }
            }
            @media (max-width:720px) {
                .pwe-footer-nav-column h5 span {
                    font-size: 14px;
                }
                .pwe-footer-nav-links ul li a {
                    font-size: 14px;
                }
            }
            @media (max-width:640px) {
                .pwe-footer-nav-wrapper {
                    flex-direction: column;
                }
                .pwe-footer-nav-left-column {
                    width: 100%;
                }
                .pwe-footer-nav-logo-top,
                .pwe-footer-nav-logo-bottom {
                    margin: 0 auto;
                }
                .pwe-footer-nav-right-column {
                    width: 100%;
                }
            }
            @media (max-width:500px) {
                .pwe-footer-bg {
                    padding: 18px;
                }
                .pwe-footer-title-section h4 {
                    text-align: center;
                    width: auto;
                }
                .pwe-footer-title-section h4 span {
                    font-size: 16px;
                }
                .pwe-footer-nav-right-column {
                    flex-direction: column;
                }
                .pwe-footer-nav-column {
                    width: 200px;
                    margin-left: auto;
                    margin-right: auto;
                }
            }
        </style>

        <div id="customFooter" class="pwe-footer">

            <div class="pwe-footer-bg" style="background-image: url(/wp-content/plugins/PWElements/media/footer.webp)">
                <div class="pwe-footer-bg-wrapper">
                    <div class="pwe-footer-bg-limit">
                        <div class="pwe-footer-logo-pwe">
                            <img src="/wp-content/plugins/PWElements/media/logo_pwe.webp" alt="pwe logo">
                        </div>
                        <div class="pwe-footer-title-section">'. 
                            self::languageChecker(
                                <<<PL
                                <h4 class="pwe-align-left"><span>Targi / Konferencje / Eventy</span></h4>
                                <h2 class="pwe-align-center"><span class="pwe-uppercase pwe-footer-title-pl">Stolica Targów</span></h2>
                                PL,
                                <<<EN
                                <h4 class="pwe-align-left"><span>Trade Fairs / Conferences / Events</span></h4>
                                <h2 class="pwe-align-center"><span class="pwe-uppercase pwe-footer-title-en">Capital of the Fair</span></h2>
                                EN
                            )
                        .'</div>
                    </div>
                    <div class="pwe-footer-benefits">'. 
                        self::languageChecker(
                            <<<PL
                            <p class="pwe-uppercase">DOŚWIADCZONY ZESPÓŁ</p>
                            <p class="pwe-uppercase">PROFESJONALIZM I KOMPLEKSOWOŚĆ</p>
                            <p class="pwe-uppercase">DOSKONAŁA LOKALIZACJA</p>
                            <p class="pwe-uppercase">INNOWACYJNY SYSTEM WYSTAWIENNICZY</p>
                            PL,
                            <<<EN
                            <p class="pwe-uppercase">AN EXPERIENCED TEAM</p>
                            <p class="pwe-uppercase">PROFESSIONALISM AND COMPLEXITY</p>
                            <p class="pwe-uppercase">PERFECT LOCATION</p>
                            <p class="pwe-uppercase">INNOVATIVE EXHIBITION SYSTEM</p>
                            EN
                        )
                    .'</div>
                </div>
            </div>

            <div class="pwe-footer-images-bg">
                <img src="/wp-content/plugins/PWElements/media/footer-images.webp" alt="footer background">
            </div>';

            $menus = wp_get_nav_menus();
            $menu_array = array();

            foreach ($menus as $menu) {
                $menu_name_lower = strtolower($menu->name);
                $patterns = ['1 pl', '1 en', '2 pl', '2 en', '3 pl', '3 en'];
                foreach ($patterns as $pattern) {
                    if (strpos($menu_name_lower, $pattern) !== false) {
                        $varName = 'menu_' . str_replace(' ', '_', $pattern);
                        // $menu_1_pl, $menu_2_pl ...
                        $$varName = $menu->name;
                        break;
                    }
                }
            }      
            
            // // Dodanie nowej pozycji do menu $menu_3_en
            // $new_menu_item = (object) array(
            //     'title' => 'Become an agent',
            //     'url' => 'https://warsawexpo.eu/en/forms-for-agents/'
            // );
            // $menu_3_en_items = wp_get_nav_menu_items($menu_3_en);
            // array_push($menu_3_en_items, $new_menu_item);

            function generateFooterNav($locale, $menus, $footer_logo_color_invert) {
                $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
                $base_url .= "://".$_SERVER['HTTP_HOST'];
                $page_url = $locale == 'pl_PL' ? $base_url : $base_url . '/en';
                $logo_file_path = $locale == 'pl_PL' ? '/doc/logo' : '/doc/logo-en';
                $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . $logo_file_path . '.webp') ? $logo_file_path . '.webp' : (file_exists($_SERVER['DOCUMENT_ROOT'] . $logo_file_path . '.png') ? $logo_file_path . '.png' : '');
                $logo_class = ($footer_logo_color_invert != 'true' && !empty($logo_url)) ? "logo-trade-fair" : "logo-invert-white";
            
                $menu_titles = $locale == 'pl_PL' ? ['[trade_fair_name]', 'DLA ODWIEDZAJĄCYCH', 'DLA WYSTAWCÓW'] : ['[trade_fair_name_eng]', 'FOR VISITORS', 'FOR EXHIBITORS'];
            
                $output = '
                <div class="pwe-footer-nav">
                    <div class="pwe-footer-nav-wrapper">
                        <div class="pwe-footer-nav-left-column">
                            <div class="pwe-footer-nav-logo-column">
                                <div class="pwe-footer-nav-logo-top"><a href="' . $page_url . '"><img src="/wp-content/plugins/PWElements/media/logo_pwe_ufi.webp" alt="logo pwe & ufi"></a></div>
                                <div class="pwe-footer-nav-logo-bottom text-centered">
                                    <a href="' . $page_url . '">
                                        <span class="' . $logo_class . '"><img src="' . $logo_url . '" alt="logo-[trade_fair_name]"></span>
                                    </a>
                                </div>
                            </div>
                        </div>   
                        <div class="pwe-footer-nav-right-column">';
            
                foreach ($menus as $index => $menu) {
                    if (isset($menu)) { 
                        $output .= '
                        <!-- nav-column-item -->
                        <div class="pwe-footer-nav-column">
                            <h5><span class="pwe-uppercase">' . $menu_titles[$index] . '</span></h5>
                            <div class="pwe-footer-nav-links">' . wp_nav_menu(["menu" => $menu, "echo" => false]) . '</div>
                        </div>';
                    }
                }
            
                $output .= '</div></div></div>';
            
                return $output;
            }
            
            if (get_locale() == 'pl_PL' && isset($menu_1_pl, $menu_2_pl, $menu_3_pl)) {
                $output .= generateFooterNav('pl_PL', [$menu_1_pl, $menu_2_pl, $menu_3_pl], $footer_logo_color_invert);
            } elseif (isset($menu_1_en, $menu_2_en, $menu_3_en)) {
                $output .= generateFooterNav('en_US', [$menu_1_en, $menu_2_en, $menu_3_en], $footer_logo_color_invert);
            }

        $output .= '</div>';

        if (get_locale() == "en_US") {
            $output .= '
            <script>
                document.addEventListener("DOMContentLoaded", function() {

                    // Top main menu "For exhibitors"
                    const mainMenu = document.querySelector("ul.menu-primary-inner");
                    const secondChild = mainMenu.children[1];
                    const dropMenu = secondChild.querySelector("ul.drop-menu");

                    // Create new element li
                    const newMenuItem = document.createElement("li");
                    newMenuItem.id = "menu-item-99999";
                    newMenuItem.className = "menu-item menu-item-type-custom menu-item-object-custom menu-item-99999";
                    newMenuItem.innerHTML = `<a title="Become an agent" target="_blank" href="https://warsawexpo.eu/en/forms-for-agents/">Become an agent</a>`;

                    // Add new element
                    dropMenu.appendChild(newMenuItem);

                    // --------------------------------------------

                    // Bottom main menu "For exhibitors"
                    const footerMenu = document.querySelector(".pwe-footer-nav-right-column");
                    const footerThirdChild = footerMenu.children[2];
                    const footerMenuChild = footerThirdChild.querySelector(".pwe-footer-nav-column .menu");

                    // Create new element li
                    const newFooterMenuItem = document.createElement("li");
                    newFooterMenuItem.id = "menu-item-99999";
                    newFooterMenuItem.className = "menu-item menu-item-type-custom menu-item-object-custom menu-item-99999";
                    newFooterMenuItem.innerHTML = `<a title="Become an agent" target="_blank" href="https://warsawexpo.eu/en/forms-for-agents/">Become an agent</a>`;

                    // Add new element
                    footerMenuChild.appendChild(newFooterMenuItem);
                });
            </script>';
        }

        return $output;

    }
}

?>


