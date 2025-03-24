<?php

class PWEStore extends PWECommonFunctions {

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        
        add_action('init', array($this, 'initVCMapPWEStore'));
        add_shortcode('pwe_store', array($this, 'PWEStoreOutput'));
    }

    /**
     * Initialize VC Map Elements.
     */
    public function initVCMapPWEStore() {
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __('PWE Store', 'pwe_store'),
                'base' => 'pwe_store',
                'category' => __('PWE Elements', 'pwe_store'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __DIR__ )) . 'backend/backendstyle.css',
                'admin_enqueue_js' => plugin_dir_url(dirname( __DIR__ )) . 'backend/backendscript.js',
            ));
        }
    }

    public function fairs_array() { 

        $edition_1 = [
            "mr.glasstec.pl",
            "bathceramicsexpo.com",
            "warsawstone.com",
            "smarthomeexpo.pl",
            "cleantechexpo.pl",
            "worldofbuildexpo.com",
            "safetyrescueexpo.com",
            "filtratecexpo.com",
            "medivisionforum.com",
            "automechanicawarsaw.com",
            "futureenergyweekpoland.com",
            "labotec.pl",
            "aluminiumtechexpo.com",
            "industrialbuildingexpo.pl",
            "cybersecurityexpo.pl",
            "chemtecpoland.com",
            "pneumaticswarsaw.com",
            "lasertechnicapoland.com",
            "isoltexexpo.com",
            "coldtechpoland.com",
            "coiltechexpo.com",
            "funeralexpo.pl",
            "pharmacyexpopoland.com",
            "polandsustainabilityexpo.com",
            "warsawoptiexpo.com",
            "coffeeeuropeexpo.com",
            "hairbarberweekpoland.com",
            "warsawwindowexpo.com",
            "glasstechpoland.com",
            "valvespumpsexpo.com",
            "grindtechexpo.com",
            "concreteexpo.pl",
            "fastechexpo.com",
            "cosmopharmpack.com",
            "aiindustryexpo.com",
            "worldofhydrogenexpo.com",
            "solidsexpopoland.com",
            "emobilityexpo.pl",
            "photonicsexpo.pl",
            "decarbonisationexpo.com",
            "warsawgardentech.com",
            "lightexpo.pl",
            "agrofarmaexpo.com",
            "veterinaryexpopoland.com",
            "globalfoodexpo.pl",
            "warsawfleetexpo.com",
            "waterexpopoland.com",
            "autotuningshow.com",
            "warsawliftexpo.com",
            "medinnovationsexpo.com",
            "huntingexpo.pl",
            "forumwarzywa.com",
            "biurotexexpo.com",
            "lingerietrends.pl",
            "warsawshopexpo.com"
        ];
        
        $edition_2 = [
            "warsawmetaltech.pl",
            "warsawplastexpo.com",
            "forumbhp.com",
            "weldexpopoland.com",
            "warsawprinttech.com",
            "heatingtechexpo.com",
            "recyclingexpo.pl",
            "warsawsweettech.com",
            "wodkantech.com",
            "gastroquickservice.com",
            "bioagropolska.com",
            "poultrypoland.com",
            "electroinstalexpo.com",
            "polandcoatings.com",
            "warsawsecurityexpo.com",
            "warsawmedicalexpo.com",
            "facadeexpo.pl",
            "roofexpo.pl",
            "fruitpolandexpo.com",
            "packagingpoland.pl",
            "intralogisticapoland.com",
            "warsawtoys.com",
            "esteticaexpo.com",
            "furnitechexpo.pl",
            "furniturecontractexpo.com",
            "batteryforumpoland.com",
            "floorexpo.pl",
            "door-tec.pl",
            "electronics-show.com",
            "winewarsawexpo.com",
            "beerwarsawexpo.com",
            "boattechnica.com",
            "automotive-expo.eu",
            "buildoutdoorexpo.com",
            "warsawtoolsshow.com",
            "warsawconstructionexpo.com",
            "foodtechexpo.pl",
            "labelingtechpoland.com",
            "woodwarsawexpo.com",
            "automaticaexpo.com",
            "targirehabilitacja.pl",
            "tubetechnicpoland.com",
            "wiretechpoland.com",
            "maintenancepoland.com",
            "controldrivespoland.com",
            "roboticswarsaw.com",
            "compositepoland.com"
        ];
        
        $edition_3 = [
            "warsawpack.pl",
            "industryweek.pl",
            "dentalmedicashow.pl",
            "warsawgardenexpo.com",
            "boatshow.pl",
            "campercaravanshow.com",
            "bioexpo.pl",
            "warsawfoodexpo.pl",
            "fasttextile.com",
            "centralnetargirolnicze.com",
            "motorcycleshow.pl",
            "mttsl.pl",
            "warsawgiftshow.com",
            "warsawbusexpo.eu",
            "eurogastro.com.pl",
            "remadays.com",
            "warsawhomefurniture.com",
            "warsawbuild.eu",
            "warsawhomekitchen.com",
            "warsawhomelight.com",
            "warsawhometextile.com",
            "warsawhomebathroom.com",
            "etradeshow.pl",
            "franczyzaexpo.pl",
            "worldhotel.pl",
            "beautydays.pl",
            "solarenergyexpo.com",
            "warsawhvacexpo.com",
            "warsawhome.eu"
        ];
        
        $edition_b2c = [
            "ttwarsaw.pl",
            "fiwe.pl",
            "animalsdays.eu",
            "warsawmotorshow.com",
            "oldtimerwarsaw.com"
        ];

        $editions = [
            "1"   => $edition_1,
            "2"   => $edition_2,
            "3"   => $edition_3,
            "b2c" => $edition_b2c
        ];
        
        $formatted_editions = [];
         
        foreach ($editions as $edition_key => $domains) {
            foreach ($domains as $domain) {
                $formatted_editions["edition_" . $edition_key][] = [
                    "domain"  => $domain,
                    "name"    => do_shortcode("[pwe_name_pl domain=\"$domain\"]"),
                    "desc"    => do_shortcode("[pwe_desc_pl domain=\"$domain\"]"),
                    "date"    => do_shortcode("[pwe_date_start domain=\"$domain\"]"),
                    "edition" => $edition_key
                ];
            }
        }

        return $formatted_editions;
    }

    /**
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('assets/style.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/style.css');
        wp_enqueue_style('pwe-store-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts(){
        $store_js_array = array(
            'trade_fair_name' => self::languageChecker(do_shortcode('[trade_fair_name]'), do_shortcode('[trade_fair_name_eng]'))
        );

        $js_file = plugins_url('assets/script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/script.js');
        wp_enqueue_script('pwe-store-js', $js_file, array('jquery'), $js_version, true);
        wp_localize_script( 'pwe-store-js', 'store_js', $store_js_array );
    }
    
    /**
     * Output method for PWEStore shortcode.
     *
     * @return string
     */ 
    public function PWEStoreOutput() {   

        $output = '
        <style>
            .pwe-store__sold-out .pwe-store__featured-image:before,
            .pwe-store__sold-out .pwe-store__service-image:before {
                content: "'. (self::lang_pl() ? 'WYPRZEDANE' : 'SOLD OUT') .'";
            }
            .pwe-store__limit .pwe-store__featured-image:before,
            .pwe-store__limit .pwe-store__service-image:before {
                content: "'. (self::lang_pl() ? 'OGRANICZONY LIMIT' : 'LIMITED') .'";
            }


            .pwe-store__service-header {
                background: #EDE4D5;
                padding: 18px;
            }
            .pwe-store__service-products {
                display: flex;
                flex-direction: column;
                gap: 10px;
                padding-bottom: 18px;
            }
            .pwe-store__product {
                display: flex;
                flex-direction: column;
                background: #F4F1F1;
                padding: 8px;
                font-weight: 600;
            }
            .pwe-store__product span {
                color: #747474;
                padding-bottom: 4px; 
            }
        </style>

        <div id="pweStore" class="pwe-store">
            
            <div class="pwe-store__main-section">
                <div class="pwe-store__main-section-header">
                    <img src="/wp-content/plugins/PWElements/media/store/header_store_pl.webp" alt="Header">
                </div> 
                <div class="pwe-store__main-section-text premium">
                    <h1>'. ( self::lang_pl() ? 'ZWIĘKSZ SWÓJ POTENCJAŁ NA TARGACH: USŁUGI PREMIUM!' : 'INCREASE YOUR POTENTIAL AT TRADE FAIRS: PREMIUM SERVICES!' ) .'</h1>
                    <p style="max-width: 700px;">
                    '. ( self::lang_pl() ? 
                    'Skorzystaj z wysokiej jakości rozwiązań, aby wyróżnić się wśród wystawców i przyciągnąć uwagę odwiedzających.' 
                    : 
                    'Take advantage of high-quality solutions to stand out among exhibitors and attract the attention of visitors.' ) .'
                    </p>
                </div>
                <div class="pwe-store__main-section-text marketing" style="display: none;">
                    <h1>'. ( self::lang_pl() ? 'ZWIĘKSZ SWOJĄ WIDOCZNOŚĆ NA TARGACH: USŁUGI MARKETINGOWE!' : 'INCREASE YOUR VISIBILITY AT TRADE FAIRS: MARKETING SERVICES!' ) .'</h1>
                    <p style="max-width: 1200px;">
                    '. ( self::lang_pl() ? 
                    'Skorzystaj z profesjonalnych strategii marketingowych, aby dotrzeć do większej liczby klientów, zwiększyć rozpoznawalność swojej marki i maksymalnie wykorzystać potencjał targów.' 
                    : 
                    'Use professional marketing strategies to reach more customers, increase your brand recognition and maximize the potential of trade fairs.' ) .'
                    </p>
                </div>
                <div class="pwe-store__main-section-text social-media" style="display: none;">
                    <h1>'. ( self::lang_pl() ? 'ZWIĘKSZ SWOJĄ WIDOCZNOŚĆ ONLINE: USŁUGI SOCIAL MEDIA!' : 'INCREASE YOUR ONLINE VISIBILITY: SOCIAL MEDIA SERVICES!' ) .'</h1>
                    <p style="max-width: 1200px;">
                    '. ( self::lang_pl() ? 
                    'Wykorzystaj potencjał mediów społecznościowych, aby dotrzeć do większej liczby klientów, budować zaangażowanie i skutecznie promować swoją obecność na targach.' 
                    : 
                    'Use the potential of social media to reach more customers, build engagement and effectively promote your presence at trade shows.' ) .'
                    </p>
                </div>
                <div class="pwe-store__main-section-text packages" style="display: none;">
                    <h1>'. ( self::lang_pl() ? 'MAKSYMALIZUJ SWOJE MOŻLIWOŚCI: PAKIETY PROMOCYJNE!' : 'MAXIMIZE YOUR POSSIBILITIES: PROMOTIONAL PACKAGES!' ) .'</h1>
                    <p style="max-width: 1000px;">
                    '. ( self::lang_pl() ? 
                    'Wybierz kompleksowe pakiety usług, które pomogą Ci skutecznie wyróżnić się na targach, zwiększyć zasięg i przyciągnąć więcej klientów.' 
                    : 
                    'Choose comprehensive service packages that will help you effectively stand out at trade fairs, increase your reach and attract more customers.' ) .'
                    </p>
                </div>
            </div> 

            <div class="pwe-store__hide-sections pwe-store__desc">

                <div id="premiumSectionHide" category="premium" class="pwe-store__premium-section-hide pwe-store__section-hide">
                    
                    <div class="pwe-store__category-header">
                        <div class="pwe-store__category-header-arrow">
                            <div class="pwe-store__category-header-arrow-el">
                                <span></span>
                            </div>
                        </div>
                        <div class="pwe-store__category-header-title">
                            <p>USŁUGI PREMIUM</p>
                        </div>
                    </div>';

                    require_once plugin_dir_path(__FILE__) . 'categories/premium/desc-section.php';

                $output .= '
                </div>

                <div id="marketingSectionHide" category="marketing" class="pwe-store__marketing-section-hide pwe-store__section-hide">
                    
                    <div class="pwe-store__category-header">
                        <div class="pwe-store__category-header-arrow">
                            <div class="pwe-store__category-header-arrow-el">
                                <span></span>
                            </div>
                        </div>
                        <div class="pwe-store__category-header-title">
                            <p>USŁUGI MARKETINGOWE</p>
                        </div>
                    </div>';

                    require_once plugin_dir_path(__FILE__) . 'categories/marketing/desc-section.php';

                $output .= '
                </div>

                <div id="socialMediaSectionHide" category="social-media" class="pwe-store__social-media-section-hide pwe-store__section-hide">

                    <div class="pwe-store__category-header">
                        <div class="pwe-store__category-header-arrow">
                            <div class="pwe-store__category-header-arrow-el">
                                <span></span>
                            </div>
                        </div>
                        <div class="pwe-store__category-header-title">
                            <p>USŁUGI SOCIAL MEDIA</p>
                        </div>
                    </div>';

                    require_once plugin_dir_path(__FILE__) . 'categories/social-media/desc-section.php';

                $output .= '
                </div>

                <div id="packagesSectionHide" category="packages" class="pwe-store__packages-section-hide pwe-store__section-hide">

                    <div class="pwe-store__category-header">
                        <div class="pwe-store__category-header-arrow">
                            <div class="pwe-store__category-header-arrow-el">
                                <span></span>
                            </div>
                        </div>
                        <div class="pwe-store__category-header-title">
                            <p>PAKIETY</p>
                        </div>
                    </div>

                    <!-- Marketing -->
                    <!-- Pakiet standard -->
                    <div class="pwe-store__featured-service pwe-store__service" id="marketing-package-standard">
                        <div class="pwe-store__featured-content">
                            <div class="pwe-store__featured-image">
                                <!-- Spersonalizowane Smyczki -->
                                <div class="pwe-store__service-card pwe-store__service">
                                    <a href="#" data-featured="smycze">
                                        <div class="pwe-store__service-image">
                                            <img src="/wp-content/plugins/PWElements/media/store/smycze-z-logotypem.webp" alt="Smycze z logotypem">
                                        </div>
                                        <div class="pwe-store__service-content">
                                            '. ( self::lang_pl() ? '
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPERSONALIZOWANE SMYCZKI Z TWOIM LOGO</h4>
                                            <h4 class="pwe-store__service-name">SPERSONALIZOWANE SMYCZKI Z TWOIM LOGO</h4>
                                            <p>Dystrybucja smyczy z logotypem Twojej firmy wśród uczestników Targów</p>
                                            ':'
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">PERSONALIZED LANYARDS WITH YOUR LOGO</h4>
                                            <h4 class="pwe-store__service-name">PERSONALIZED LANYARDS WITH YOUR LOGO</h4>
                                            <p>Distribution of lanyards with your company logo among Fair participants</p>
                                            ' ) .'
                                            
                                            <div class="pwe-store__service-footer">
                                                <div class="pwe-store__price">5500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                                            </div>

                                            <div class="pwe-store__btn-container">
                                                <span class="pwe-store__more-button" data-featured="smycze">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Logotyp na Identyfikatorach -->
                                <div class="pwe-store__service-card pwe-store__service">
                                    <a href="#" data-featured="logotyp">
                                        <div class="pwe-store__service-image">
                                            <img src="/wp-content/plugins/PWElements/media/store/logotyp-na-identyfikatorach.webp" alt="Logotyp na identyfikatorach">
                                        </div>
                                        <div class="pwe-store__service-content">
                                            '. ( self::lang_pl() ? '
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">LOGOTYP TWOJEJ FIRMY NA IDENTYFIKATORACH UCZESTNIKÓW</h4>
                                            <h4 class="pwe-store__service-name">LOGOTYP TWOJEJ FIRMY NA IDENTYFIKATORACH UCZESTNIKÓW</h4>
                                            <p>Logo Twojej Firmy na identyfikatorach wszystkich uczestników Targów</p>
                                            ':'
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">YOUR COMPANY LOGO ON PARTICIPANTS` ID BADGES</h4>
                                            <h4 class="pwe-store__service-name">YOUR COMPANY LOGO ON PARTICIPANTS` ID BADGES</h4>
                                            <p>Your Company Logo on ID BADGES of all Fair participants</p>
                                            ' ) .'
                                            
                                            <div class="pwe-store__service-footer">
                                                <div class="pwe-store__price">6500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>                    
                                            </div>

                                            <div class="pwe-store__btn-container">
                                                <span class="pwe-store__more-button" data-featured="logotyp">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Sponsor Planu Targowego -->
                                <div class="pwe-store__service-card pwe-store__service">
                                    <a href="#" data-featured="sponsor-planu">
                                        <div class="pwe-store__service-image">
                                            <img src="/wp-content/plugins/PWElements/media/store/sponsor-planu-targowego.webp" alt="Sponsor Planu Targowego">
                                        </div>
                                        <div class="pwe-store__service-content">
                                            '. ( self::lang_pl() ? '
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPONSOR PLANU TARGOWEGO</h4>
                                            <h4 class="pwe-store__service-name">SPONSOR PLANU TARGOWEGO</h4>
                                            <p>Reklama Twojej firmy w drukowanym Planie Targowym</p>
                                            ':'
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">TRADE FAIR PLAN SPONSOR</h4>
                                            <h4 class="pwe-store__service-name">TRADE FAIR PLAN SPONSOR</h4>
                                            <p>Advertise your company in the printed Trade Plan</p>
                                            ' ) .'
                                        
                                            <div class="pwe-store__service-footer">
                                                <div class="pwe-store__price">5000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div> 
                                            </div>

                                            <div class="pwe-store__btn-container">
                                                <span class="pwe-store__more-button" data-featured="sponsor-planu">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="pwe-store__featured-details">
                                <div class="pwe-store__featured-text">
                                    <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'PAKIET STANDARD' : 'STANDARD PACKAGE' ) .'</h3>
                                    <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'PAKIET STANDARD' : 'STANDARD PACKAGE' ) .'</span>
                                    '. ( self::lang_pl() ? '
                                        <p class="pwe-store__featured-description">Zostań <strong>Partnerem Strefy VIP</strong> podczas targów organizowanych w Ptak Warsaw Expo i zyskaj wyjątkową <strong>możliwość zaprezentowania swojej marki w ekskluzywnej przestrzeni</strong>.</p>                     
                                    ':'
                                        <p class="pwe-store__featured-description">Become a <strong>VIP Zone Partner</strong> during the fair organized at Ptak Warsaw Expo and gain a unique <strong>opportunity to present your brand in an exclusive space</strong>.</p>
                                    ' ) .' 
                                </div>
                                <div class="pwe-store__featured-footer">
                                    <span class="pwe-store__featured-pwe-store__price">'. ( self::lang_pl() ? '15 000,00zł' : '15 000,00zł' ) .'</span>
                                    <div class="pwe-store__featured-buttons">
                                        <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <!-- Social media -->
                    <!-- Pakiet standard -->
                    <div class="pwe-store__featured-service pwe-store__service" id="social-media-package-standard">
                        <div class="pwe-store__featured-content">
                            <div class="pwe-store__featured-image">
                                <!-- Spersonalizowane Smyczki -->
                                <div class="pwe-store__service-card pwe-store__service">
                                    <a href="#" data-featured="smycze">
                                        <div class="pwe-store__service-image">
                                            <img src="/wp-content/plugins/PWElements/media/store/smycze-z-logotypem.webp" alt="Smycze z logotypem">
                                        </div>
                                        <div class="pwe-store__service-content">
                                            '. ( self::lang_pl() ? '
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPERSONALIZOWANE SMYCZKI Z TWOIM LOGO</h4>
                                            <h4 class="pwe-store__service-name">SPERSONALIZOWANE SMYCZKI Z TWOIM LOGO</h4>
                                            <p>Dystrybucja smyczy z logotypem Twojej firmy wśród uczestników Targów</p>
                                            ':'
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">PERSONALIZED LANYARDS WITH YOUR LOGO</h4>
                                            <h4 class="pwe-store__service-name">PERSONALIZED LANYARDS WITH YOUR LOGO</h4>
                                            <p>Distribution of lanyards with your company logo among Fair participants</p>
                                            ' ) .'
                                            
                                            <div class="pwe-store__service-footer">
                                                <div class="pwe-store__price">5500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                                            </div>

                                            <div class="pwe-store__btn-container">
                                                <span class="pwe-store__more-button" data-featured="smycze">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Logotyp na Identyfikatorach -->
                                <div class="pwe-store__service-card pwe-store__service">
                                    <a href="#" data-featured="logotyp">
                                        <div class="pwe-store__service-image">
                                            <img src="/wp-content/plugins/PWElements/media/store/logotyp-na-identyfikatorach.webp" alt="Logotyp na identyfikatorach">
                                        </div>
                                        <div class="pwe-store__service-content">
                                            '. ( self::lang_pl() ? '
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">LOGOTYP TWOJEJ FIRMY NA IDENTYFIKATORACH UCZESTNIKÓW</h4>
                                            <h4 class="pwe-store__service-name">LOGOTYP TWOJEJ FIRMY NA IDENTYFIKATORACH UCZESTNIKÓW</h4>
                                            <p>Logo Twojej Firmy na identyfikatorach wszystkich uczestników Targów</p>
                                            ':'
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">YOUR COMPANY LOGO ON PARTICIPANTS` ID BADGES</h4>
                                            <h4 class="pwe-store__service-name">YOUR COMPANY LOGO ON PARTICIPANTS` ID BADGES</h4>
                                            <p>Your Company Logo on ID BADGES of all Fair participants</p>
                                            ' ) .'
                                            
                                            <div class="pwe-store__service-footer">
                                                <div class="pwe-store__price">6500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>                    
                                            </div>

                                            <div class="pwe-store__btn-container">
                                                <span class="pwe-store__more-button" data-featured="logotyp">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <!-- Sponsor Planu Targowego -->
                                <div class="pwe-store__service-card pwe-store__service">
                                    <a href="#" data-featured="sponsor-planu">
                                        <div class="pwe-store__service-image">
                                            <img src="/wp-content/plugins/PWElements/media/store/sponsor-planu-targowego.webp" alt="Sponsor Planu Targowego">
                                        </div>
                                        <div class="pwe-store__service-content">
                                            '. ( self::lang_pl() ? '
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPONSOR PLANU TARGOWEGO</h4>
                                            <h4 class="pwe-store__service-name">SPONSOR PLANU TARGOWEGO</h4>
                                            <p>Reklama Twojej firmy w drukowanym Planie Targowym</p>
                                            ':'
                                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">TRADE FAIR PLAN SPONSOR</h4>
                                            <h4 class="pwe-store__service-name">TRADE FAIR PLAN SPONSOR</h4>
                                            <p>Advertise your company in the printed Trade Plan</p>
                                            ' ) .'
                                        
                                            <div class="pwe-store__service-footer">
                                                <div class="pwe-store__price">5000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div> 
                                            </div>

                                            <div class="pwe-store__btn-container">
                                                <span class="pwe-store__more-button" data-featured="sponsor-planu">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="pwe-store__featured-details">
                                <div class="pwe-store__featured-text">
                                    <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'PAKIET STANDARD' : 'STANDARD PACKAGE' ) .'</h3>
                                    <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'PAKIET STANDARD' : 'STANDARD PACKAGE' ) .'</span>
                                    '. ( self::lang_pl() ? '
                                        <p class="pwe-store__featured-description">Zostań <strong>Partnerem Strefy VIP</strong> podczas targów organizowanych w Ptak Warsaw Expo i zyskaj wyjątkową <strong>możliwość zaprezentowania swojej marki w ekskluzywnej przestrzeni</strong>.</p>                     
                                    ':'
                                        <p class="pwe-store__featured-description">Become a <strong>VIP Zone Partner</strong> during the fair organized at Ptak Warsaw Expo and gain a unique <strong>opportunity to present your brand in an exclusive space</strong>.</p>
                                    ' ) .' 
                                </div>
                                <div class="pwe-store__featured-footer">
                                    <span class="pwe-store__featured-pwe-store__price">'. ( self::lang_pl() ? '15 000,00zł' : '15 000,00zł' ) .'</span>
                                    <div class="pwe-store__featured-buttons">
                                        <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pwe-store__sorting">
                <div class="pwe-store__sorting-wrapper">
                    <div class="pwe-store__sorting-text"><p>SORTUJ:</p></div>
                    <div class="pwe-store__sorting-items">
                        <div id="premium" class="pwe-store__sorting-item active"><p>USŁUGI PREMIUM</p></div>
                        <div id="marketing" class="pwe-store__sorting-item"><p>USŁUGI MARKETINGOWE</p></div>
                        <div id="social-media" class="pwe-store__sorting-item"><p>USŁUGI SOCIAL MEDIA</p></div>
                        <div id="packages" class="pwe-store__sorting-item"><p>PAKIETY</p></div>
                    </div>
                </div>
            </div>

            <div class="pwe-store__sections pwe-store__cards">

                <!-- PREMIUM CARDS SECTION <------------------------------------------------------------------------------------------>
                <div id="premiumSection" category="premium" class="pwe-store__premium-section pwe-store__section active"> 
                    <div class="pwe-store__services-cards">';

                        require_once plugin_dir_path(__FILE__) . 'categories/premium/cards-section.php';

                    $output .= '
                    </div>
                </div>

                <!-- MARKETING CARDS SECTION <------------------------------------------------------------------------------------------>
                <div id="marketingSection" category="marketing" class="pwe-store__marketing-section pwe-store__section">
                    <div class="pwe-store__services-cards">';

                        require_once plugin_dir_path(__FILE__) . 'categories/marketing/cards-section.php';

                    $output .= ' 
                    </div>
                </div>

                <!-- SOCIAL MEDIA CARDS SECTION <------------------------------------------------------------------------------------------>
                <div id="socialMediaSection" category="social-media" class="pwe-store__social-media-section pwe-store__section">
                    <div class="pwe-store__services-cards">';

                        require_once plugin_dir_path(__FILE__) . 'categories/social-media/cards-section.php';

                    $output .= ' 
                    </div>
                </div>

                <!-- PACKAGES CARDS SECTION <------------------------------------------------------------------------------------------>
                <div id="packagesSection" category="packages" class="pwe-store__packages-section pwe-store__section">

                    <div class="pwe-store__services-cards-header">
                        <h4>PAKIETY USŁUG MARKETINGOWYCH</h4>
                    </div>

                    <div class="pwe-store__services-cards" category="marketing">

                        <!-- Pakiet STANDARD -->
                        <div class="pwe-store__service-card pwe-store__service">
                            <a href="#" data-featured="marketing-package-standard">
                                <div class="pwe-store__service-header">
                                    <h4 class="pwe-store__service-name pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'PAKIET STANDARD': 'STANDARD PACKAGE' ) .'</h4>   
                                </div>
                                <div class="pwe-store__service-content">
                                    <div class="pwe-store__service-products">
                                        <div class="pwe-store__product">Komunikat w radiowęźle</div>
                                        <div class="pwe-store__product"><span>1 szt</span>Naklejki podłogowe</div>
                                        <div class="pwe-store__product">Dostęp do skanera wystawcy</div>
                                    </div>
                                    <div class="pwe-store__service-footer">
                                        <div class="pwe-store__price">7000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                                    </div>
                                </div>
                            </a>
                            <div class="pwe-store__btn-container">
                                <a href="#" class="pwe-store__more-button" data-featured="marketing-package-standard">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>

                    </div>

                    <div class="pwe-store__services-cards-header">
                        <h4>PAKIETY USŁUG SOCIAL MEDIA</h4>
                    </div>

                    <div class="pwe-store__services-cards" category="social-media">

                        <!-- Pakiet STANDARD -->
                        <div class="pwe-store__service-card pwe-store__service">
                            <a href="#" data-featured="social-media-package-standard">
                                <div class="pwe-store__service-header">
                                    <h4 class="pwe-store__service-name pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'PAKIET STANDARD': 'STANDARD PACKAGE' ) .'</h4>   
                                </div>
                                <div class="pwe-store__service-content">
                                    <div class="pwe-store__service-products">
                                        <div class="pwe-store__product">Komunikat w radiowęźle</div>
                                        <div class="pwe-store__product"><span>1 szt</span>Naklejki podłogowe</div>
                                        <div class="pwe-store__product">Dostęp do skanera wystawcy</div>
                                    </div>
                                    <div class="pwe-store__service-footer">
                                        <div class="pwe-store__price">7000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                                    </div>
                                </div>
                            </a>
                            <div class="pwe-store__btn-container">
                                <a href="#" class="pwe-store__more-button" data-featured="social-media-package-standard">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

            <div class="pwe-store__fairs">
                <div class="pwe-store__fairs-search">
                    <h4>Wyszukaj wydarzenie albo wybierz z listy</h4>
                    <input class="pwe-store__fairs-search-input" type="text">
                </div>
                <div class="pwe-store__fairs-items">';
                $all_editions = self::fairs_array();
                if (!empty($all_editions)) {

                    $all_fairs = array_merge($all_editions['edition_1'], $all_editions['edition_2'], $all_editions['edition_3'], $all_editions['edition_b2c']);

                    // Sorting the array based on date
                    usort($all_fairs, function ($a, $b) {
                        // If date is missing in one of the elements, this element goes to the end of the array
                        if (empty($a['date']) && !empty($b['date'])) {
                            return 1;
                        }
                        if (!empty($a['date']) && empty($b['date'])) {
                            return -1;
                        }
                
                        // If both dates exist, we compare them
                        $dateA = isset($a['date']) ? str_replace('/', '-', $a['date']) : '';
                        $dateB = isset($b['date']) ? str_replace('/', '-', $b['date']) : '';
                        
                        // Convert date to timestamp
                        $timestampA = strtotime($dateA);
                        $timestampB = strtotime($dateB);
                
                        return $timestampA - $timestampB;
                    });
    
                    foreach ($all_fairs as $fair) {
                        if (isset($fair['domain'], $fair['name'], $fair['desc'], $fair['date'], $fair['edition']) && 
                            !empty($fair['domain']) && $fair['domain'] !== "Brak danych" && 
                            !empty($fair['name']) && $fair['name'] !== "Brak danych" && 
                            !empty($fair['desc']) && $fair['desc'] !== "Brak danych" && 
                            !empty($fair['date']) && $fair['date'] !== "Brak danych" && 
                            !empty($fair['edition']) && $fair['edition'] !== "Brak danych") {
                        
                            $output .= '
                            <div 
                                class="pwe-store__fairs-item" 
                                id="'. preg_replace('/\.[^.]*$/', '', $fair['domain']) .'" 
                                data-name="'. $fair['name'] .'" 
                                data-tooltip="'. $fair['desc'] .'" 
                                data-date="'. $fair['date'] .'" 
                                data-edition="'. $fair['edition'] .'" 
                                data-domain="'. $fair['domain'] .'" 
                                style="background-image: url(&quot;https://'. $fair['domain'] .'/doc/kafelek.jpg&quot;);">
                            </div>';
                        } else {
                            if (current_user_can('administrator')) {
                                echo '<script>console.log("Brak danych dla: '. $fair['domain'] .'")</script>';
                            }
                        }
                    }
                    
                } else { $output .= '<p style="position: absolute; left: 50%; transform: translate(-50%, 0); text-align: center;">Przepraszamy, lista targów jest tymczasowo niedostępna. =(</p>'; }
                $output .= '
                </div>
            </div>
        </div>';
    
        $output = do_shortcode($output); 
        
        return $output;
    }  
}