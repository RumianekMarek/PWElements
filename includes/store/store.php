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
        <div id="pweStore" class="pwe-store">
            
            <!-- Spersonalizowane Smyczki -->
            <div class="pwe-store__featured-service pwe-store__service" id="smycze">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'SPERSONALIZOWANE SMYCZKI Z TWOIM LOGO – REKLAMA NA WYDARZENIACH PTAK WARSAW EXPO' : 'PERSONALIZED LANYARDS WITH YOUR LOGO – ADVERTISING AT PTAK WARSAW EXPO EVENTS' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'SPERSONALIZOWANE SMYCZKI Z TWOIM LOGO' : 'PERSONALIZED LANYARDS WITH YOUR LOGO' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/smycze-z-logotypem.webp" alt="Smyczki">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Zareklamuj swoją markę podczas największych targów w Polsce! Na każde targi Ptak Warsaw Expo wysyłamy od <strong>30 000 badge ze smyczkami do nawet 100 000 badge</strong>  – teraz możesz sprawić, że to <strong>Twoje logo</strong> znajdzie się na smyczkach trafiających do uczestników i wystawców. To doskonała okazja na zwiększenie widoczności Twojej firmy wśród liderów branży.</p>
                            
                            <div class="pwe-store__featured-info">
                                <h4>ELEMENTY OFERTY</h4>
                                
                                <p class="pwe-store__featured-title">Personalizowane smyczki z logo:</p>
                                <ul>
                                    <li>Twoje logo nadrukowane na smyczkach dostarczanych z badge`ami uczestników</li>
                                    <li>Profesjonalny design dostosowany do Twojej marki</li>
                                </ul>
                                <p class="pwe-store__featured-title">Ekspozycja marki:</p>
                                <ul>
                                    <li>Reklama widoczna na całym wydarzeniu – smyczki są noszone przez uczestników podczas targów, zapewniając szeroki zasięg Twojej marki</li>
                                </ul>
                                <p class="pwe-store__featured-title">Ogromny zasięg:</p>
                                <ul>
                                    <li>Smyczki docierają do 100 000 uczestników każdego wydarzenia, w tym do liderów branży, kluczowych decydentów i potencjalnych partnerów biznesowych</li>
                                </ul>
                                <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                                <ul>
                                    <li><strong>Skuteczna promocja:</strong> Twoje logo widoczne na największych wydarzeniach targowych w Polsce</li>
                                    <li><strong>Budowanie rozpoznawalności:</strong> Smyczki są nie tylko praktyczne, ale również stanowią element, który uczestnicy noszą i zabierają ze sobą</li>
                                    <li><strong>Prestiż i ekskluzywność:</strong> Liczba miejsc na sponsorów smyczek jest ograniczona, co gwarantuje wyjątkową widoczność Twojej marki</li>
                                    <li><strong>Bezpośredni kontakt z branżą:</strong> Doskonały sposób na dotarcie do kluczowych osób w nieformalny, skuteczny sposób</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-title"><strong>CENA I DOSTĘPNOŚĆ:</strong></p>
                            <p><strong>Koszt personalizacji smyczek:</strong> Cena ustalana indywidualnie w zależności od projektu i ilości.</p>
                            <p><strong>Dostępność:</strong> Liczba miejsc ograniczona – skontaktuj się z nami, aby zarezerwować swoją kampanię!</p>
                            <p class="pwe-store__featured-info"><strong>Nie czekaj!</strong> Spraw, aby Twoje logo było obecne na największych wydarzeniach biznesowych w Polsce z Ptak Warsaw Expo!</p>
                        ':'
                            <p class="pwe-store__featured-description">Advertise your brand during the largest trade fair in Poland! For each Ptak Warsaw Expo trade fair we send from <strong>30,000 badges with lanyards to up to 100,000 badges</strong> - now you can make sure that <strong>your logo</strong> is on the lanyards sent to participants and exhibitors. This is a great opportunity to increase your company`s visibility among industry leaders.</p>

                            <div class="pwe-store__featured-info">
                                <h4>Features of the offer</h4>

                                <p class="pwe-store__featured-title">Personalized lanyards with logo:</p>
                                <ul>
                                    <li>Your logo printed on lanyards supplied with participant badges</li>
                                    <li>Professional design tailored to your brand</li>
                                </ul>

                                <p class="pwe-store__featured-title">Brand exposure:</p>
                                <ul>
                                    <li>Advertisement visible throughout the event - lanyards are worn by participants during the trade show, providing a wide reach for your brand</li>
                                </ul>

                                <p class="pwe-store__featured-title">Huge reach:</p>
                                <ul>
                                    <li>The lanyards reach 100,000 participants each events, including industry leaders, key decision-makers and potential business partners</li>
                                </ul>

                                <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                                <ul>
                                    <li><strong>Effective promotion:</strong> Your logo visible at the largest trade fair events in Poland</li>
                                    <li><strong>Building recognition:</strong> Lanyards are not only practical, but also an element that participants wear and take with them</li>
                                    <li><strong>Prestige and exclusivity:</strong> The number of spots for lanyard sponsors is limited, which guarantees exceptional visibility of your brand</li>
                                    <li><strong>Direct contact with the industry:</strong> A great way to reach key people in an informal, effective way</li>
                                </ul>

                            </div>

                            <p class="pwe-store__featured-title"><strong>PRICE AND AVAILABILITY:</strong></p>
                            <p><strong>Cost of personalizing the lanyard:</strong> Price determined individually depending on the project and quantity.</p>
                            <p><strong>Availability:</strong> Limited number of places - contact us to book your campaign!</p>
                            <p class="pwe-store__featured-info"><strong>Don`t wait!</strong> Make your logo present at the largest business events in Poland with Ptak Warsaw Expo!</p>
                        ' ) .' 
                        </div>
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logotyp na Identyfikatorach -->
            <div class="pwe-store__featured-service pwe-store__service" id="logotyp">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'LOGOTYP TWOJEJ FIRMY NA IDENTYFIKATORACH UCZESTNIKÓW – WYJĄTKOWA ROZPOZNAWALNOŚĆ NA WYDARZENIACH PTAK WARSAW EXPO' : 'YOUR COMPANY LOGO ON PARTICIPANTS` BADGES - UNIQUE RECOGNITION AT PTAK WARSAW EXPO EVENTS' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'LOGOTYP TWOJEJ FIRMY NA IDENTYFIKATORACH UCZESTNIKÓW' : 'YOUR COMPANY LOGO ON PARTICIPANTS` BADGES' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/logotyp-na-identyfikatorach.webp" alt="Identyfikatory">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Zyskaj unikalną widoczność podczas największych wydarzeń targowych w Polsce! Każdego roku Ptak Warsaw Expo wysyła <strong>nawet do 100 000 identyfikatorów do wystawców i uczestników targów</strong>. Teraz masz możliwość umieszczenia <strong>logotypu swojej firmy</strong> na identyfikatorach, które będą noszone przez liderów branży oraz kluczowych gości wydarzeń.</p>
                            
                            <div class="pwe-store__featured-info">
                                <h4>ELEMENTY OFERTY</h4>
                                
                                <p class="pwe-store__featured-title">Logotyp na identyfikatorach:</p>
                                <ul>
                                    <li>Twoje logo widoczne na każdym identyfikatorze uczestników wydarzenia</li>
                                    <li>Profesjonalna personalizacja z wyeksponowaniem Twojej marki</li>
                                </ul>
                            
                                <p class="pwe-store__featured-title">Wyjątkowa widoczność:</p>
                                <ul>
                                    <li>Identyfikatory noszone przez uczestników przez cały czas trwania targów, co zapewnia Twojej firmie stałą i szeroką ekspozycję</li>
                                    <li>Twoja marka obecna w każdej ważnej rozmowie, sesji networkingowej i na zdjęciach z wydarzenia.</li>
                                </ul>
                            
                                <p class="pwe-store__featured-title">Ogromny zasięg:</p>
                                <ul>
                                    <li>Nawet do 100 000 identyfikatorów z Twoim logotypem, które trafiają bezpośrednio do liderów branży, decydentów i uczestników targów</li>
                                </ul>
                            </div>
                        
                            <p class="pwe-store__featured-title">Dlaczego warto?</p>
                            <ul>
                                <li><strong>Stała obecność Twojej marki:</strong> Identyfikatory to obowiązkowy element każdego uczestnika targów – Twoje logo będzie z nimi przez cały czas trwania wydarzenia</li>
                                <li><strong>Prestiż i ekskluzywność:</strong> Umieszczenie logotypu na identyfikatorach to gwarancja, że Twoja firma będzie zauważona przez kluczowych graczy w branży</li>
                                <li><strong>Efektywna reklama:</strong> Wysoka ekspozycja Twojej marki wśród uczestników z różnych sektorów biznesowych</li>
                                <li><strong>Doskonała okazja do promocji:</strong> Twoje logo stanie się częścią profesjonalnie zorganizowanego wydarzenia, które przyciąga uwagę tysięcy uczestników</li>
                            </ul>
                        
                            <p class="pwe-store__featured-title"><strong>CENA I DOSTĘPNOŚĆ:</strong></p>
                            <p><strong>Koszt personalizacji identyfikatorów:</strong> Cena ustalana indywidualnie w zależności od projektu.</p>
                            <p><strong>Dostępność:</strong> Liczba miejsc na sponsorów logotypów ograniczona – decyduje kolejność zgłoszeń.</p>
                            <p class="pwe-store__featured-info"><strong>Zamów już dziś!</strong> Nie przegap szansy na promocję swojej marki na jednym z największych wydarzeń biznesowych w Polsce. Pokaż się wśród liderów i zdobywaj nowych klientów z <strong>Ptak Warsaw Expo!</strong></p>
                        ':'
                            <p class="pwe-store__featured-description">Gain unique visibility during the largest trade fair events in Poland! Every year, Ptak Warsaw Expo sends <strong>up to 100,000 badges to exhibitors and trade fair participants</strong>. Now you have the opportunity to place <strong>your company logo</strong> on badges that will be worn by industry leaders and key event guests.</p>

                            <div class="pwe-store__featured-info">
                                <h4>OFFER ELEMENTS</h4>

                                <p class="pwe-store__featured-title">Logo on badges:</p>
                                <ul>
                                    <li>Your logo visible on every badge of event attendees</li>
                                    <li>Professional personalization with your brand highlighted</li>
                                </ul>

                                <p class="pwe-store__featured-title">Exceptional visibility:</p>
                                <ul>
                                    <li>Badges worn by attendees throughout the trade show, providing your company with constant and wide exposure</li>
                                    <li>Your brand present in every important conversation, networking session and in photos from the event.</li>
                                </ul>

                                <p class="pwe-store__featured-title">Huge reach:</p>
                                <ul>
                                    <li>Up to 100,000 badges with your logo that go directly to industry leaders, decision-makers and trade fair participants</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-title">Why is it worth it?</p>
                            <ul>
                                <li><strong>Constant presence of your brand:</strong> Badges are a must-have for every trade fair participant - your logo will be with them throughout the event</li>
                                <li><strong>Prestige and exclusivity:</strong> Placing your logo on badges is a guarantee that your company will be noticed by key players in the industry</li>
                                <li><strong>Effective advertising:</strong> High exposure of your brand among participants from various business sectors</li>
                                <li><strong>A great opportunity to promotion:</strong> Your logo will become part of a professionally organized event that attracts the attention of thousands of participants.</li>
                            </ul>

                            <p class="pwe-store__featured-title"><strong>PRICE AND AVAILABILITY:</strong></p>
                            <p><strong>Cost of personalizing badges:</strong> Price determined individually depending on the project.</p>
                            <p><strong>Availability:</strong> Limited number of places for logotype sponsors - the order of applications is decisive.</p>
                            <p class="pwe-store__featured-info"><strong>Order today!</strong> Don`t miss the chance to promote your brand at one of the largest business events in Poland. Show yourself among the leaders and gain new customers with <strong>Ptak Warsaw Expo!</strong></p>
                        ' ) .'
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sponsor Planu Targowego -->
            <div class="pwe-store__featured-service pwe-store__service" id="sponsor-planu">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'ZOSTAŃ SPONSOREM PLANU TARGOWEGO PTAK WARSAW EXPO' : 'BECOME A SPONSOR OF THE PTAK WARSAW EXPO TRADE PLAN' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'SPONSOR PLANU TARGOWEGO' : 'TRADE FAIR PLAN SPONSOR' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/sponsor-planu-targowego.webp" alt="Plan Targowy">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Promuj swoją markę w miejscu, które trafia w ręce każdego uczestnika! Podczas każdej edycji targów w <strong>Ptak Warsaw Expo</strong> drukujemy <strong>mapki targowe</strong>, niezbędne narzędzie dla odwiedzających i wystawców. Jako sponsor, Twoje logo znajdzie się w strategicznym miejscu na mapie, zapewniając doskonałą widoczność.</p>
                            
                            <div class="pwe-store__featured-info">
                                <p>Plan targowy to niezastąpione narzędzie dla każdego uczestnika - Twoje logo może być jego częścią!</p>
                                <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                <ul>
                                    <li><strong>Logotyp na mapce targowej:</strong> Eksponowane miejsce na mapie używanej przez uczestników podczas całego wydarzenia</li>
                                    <li><strong>Ogromny zasięg:</strong> Mapki są rozdawane wszystkim odwiedzającym przy wejściu, w punktach informacyjnych i dostępne online</li>
                                    <li><strong>Prestiżowe umiejscowienie:</strong> Twoje logo w sekcji „Sponsorzy Główni” lub na odwrocie mapy</li>
                                </ul>
                            
                                <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                                <ul>
                                    <li><strong>Stała widoczność:</strong> Mapki są używane przez uczestników przez cały czas targów</li>
                                    <li><strong>Prestiż:</strong> Podkreślenie pozycji Twojej marki jako kluczowego partnera</li>
                                    <li><strong>Efektywność:</strong> Dotarcie do liderów branży, wystawców i odwiedzających</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-title">CENA I DOSTĘPNOŚĆ:</p>
                            <p class="pwe-store__featured-info"><strong>Koszt sponsorstwa:</strong> Ustalany indywidualnie.</p>
                            <p class="pwe-store__featured-info"><strong>Liczba miejsc ograniczona!</strong></p>
                            <p class="pwe-store__featured-info"><strong>Zgłoś się już dziś!</strong> Wykorzystaj tę okazję, aby Twoja firma była widoczna dla tysięcy uczestników największych targów w Polsce!</p>
                        ':'
                            <p class="pwe-store__featured-description">Promote your brand in a place that reaches every participant! During each edition of the fair at <strong>Ptak Warsaw Expo</strong> we print <strong>trade fair maps</strong>, an essential tool for visitors and exhibitors. As a sponsor, your logo will be strategically placed on the map, ensuring excellent visibility.</p>

                            <div class="pwe-store__featured-info">
                                <p>The trade fair plan is an indispensable tool for every participant - your logo can be part of it!</p>

                                <p class="pwe-store__featured-title">FOR THE OFFER:</p>
                                <ul>
                                    <li><strong>Logo on the trade fair map:</strong> Prominent place on the map used by participants throughout the event</li>
                                    <li><strong>Huge reach:</strong> Maps are distributed to all visitors at the entrance, at information points and available online</li>
                                    <li><strong>Prestigious location:</strong> Your logo in the "Main Sponsors" section or on the back of the map</li>
                                </ul>

                                <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                                <ul>
                                    <li><strong>Constant visibility:</strong> Maps are used by participants throughout the fair</li>
                                    <li><strong>Prestige:</strong> Highlighting your brand`s position as a key partner</li>
                                    <li><strong>Effectiveness:</strong> Reaching industry leaders, exhibitors and visitors</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-title">PRICE AND AVAILABILITY:</p>
                            <p class="pwe-store__featured-info"><strong>Sponsorship cost:</strong> Determined individually.</p>
                            <p class="pwe-store__featured-info"><strong>Limited number of places!</strong></p>
                            <p class="pwe-store__featured-info"><strong>Apply today!</strong> Use this opportunity to make your company visible to thousands of participants of the largest fair in Poland!</p>
                        ' ) .'
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">5 000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partner VIP Room -->
            <div class="pwe-store__featured-service pwe-store__service" id="vip-room">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'PARTNER VIP ROOM' : 'VIP ROOM PARTNER' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'PARTNER VIP ROOM' : 'VIP ROOM PARTNER' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/partner-vip-room.webp" alt="VIP Room">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Zostań <strong>Partnerem Strefy VIP</strong> podczas targów organizowanych w Ptak Warsaw Expo i zyskaj wyjątkową <strong>możliwość zaprezentowania swojej marki w ekskluzywnej przestrzeni.</strong>    </p>

                            <div class="pwe-store__featured-info">
                                <p><strong>Strefa VIP</strong> to miejsce, w którym prowadzone są strategiczne rozmowy, nawiązywane wartościowe kontakty biznesowe oraz budowane relacje z osobami o realnym wpływie na decyzje w swoich firmach, takich jak <strong>OralB, Siemens, Still, Mextra.</strong>.</p>
                                <p><strong>Prestiżowa widoczność - Dotarcie do grupy VIP - Rozszerzenie zasięgu - Wzrost rozpoznawalności - Unikalna przestrzeń promocji – 500 gości każdego dnia targowego</strong></p>
                                <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                <ul>
                                    <li>Wysyłka kurierem dedykowanych pakietów, <strong>gwarantowane minimum 2000 zaproszeń VIP Gold</strong> z logotypem partnera</li>
                                    <li>Wzmianka o firmie w <strong>materiałach promocyjnych wydarzenia</strong>, takich jak e-mailingi i smsy, docierających do bazy dziesiątek tysięcy uczestników</li>
                                    <li>Ekspozycja marki na <strong>stronie internetowej targów</strong>, w sekcji dotyczącej strefy VIP</li>
                                    <li>Ekspozycja logotypu oraz <strong>materiału video na telewizorze</strong> przed wejściem do Vip Roomu</li>
                                    <li><strong>Podświetlane logo</strong> firmy widoczne na wejściu do strefy VIP oraz w jej wnętrzu</li>
                                    <li><strong>Branding strefy:</strong> roll upy, standy, konstrukcje reklamowe</li>
                                    <li>Dystrybucja <strong>materiałów promocyjnych</strong> (ulotki, katalogi, wizytówki) wśród gości VIP</li>
                                    <li><strong>Stanowisko w strefie VIP</strong>, które umożliwi prezentację produktów</li>
                                    <li><strong>Przestrzeń dla Partnera</strong> z wygodnymi kanapami i fotelami idealna do spotkań</li>
                                </ul>
                            </div>
                        ':'
                            <p class="pwe-store__featured-description">Become a <strong>VIP Zone Partner</strong> during the fair organized at Ptak Warsaw Expo and gain a unique <strong>opportunity to present your brand in an exclusive space.</strong></p>

                            <div class="pwe-store__featured-info">
                                <p><strong>VIP Zone</strong> is a place where strategic talks are held, valuable business contacts are established and relationships are built with people who have a real influence on decisions in their companies, such as <strong>OralB, Siemens, Still, Mextra.</strong>.</p>
                                <p><strong>Prestigious visibility - Reaching the VIP group - Expanding the reach - Increased recognition - Unique promotion space - 500 guests every day of the fair</strong></p>
                                <p class="pwe-store__featured-title">ELEMENTS OF THE OFFER:</p>
                                <ul>
                                    <li>Dedicated packages delivered by courier, <strong>guaranteed minimum of 2000 VIP Gold invitations</strong> with the partner`s logo</li>
                                    <li>Mentioning the company in <strong>event promotional materials</strong>, such as e-mails and text messages, reaching a database of tens of thousands of participants</li>
                                    <li>Brand exposure on the <strong>fair website</strong>, in the VIP zone section</li>
                                    <li>Logo and <strong>video display on the TV</strong> in front of the VIP Room entrance</li>
                                    <li><strong>Illuminated company logo</strong> visible at the entrance to the VIP zone and inside it</li>
                                    <li><strong>Zone branding:</strong> roll ups, stands, advertising structures</li>
                                    <li>Distribution of <strong>promotional materials</strong> (leaflets, catalogues, business cards) among VIP guests</li>
                                    <li><strong>A stand in the VIP zone</strong> that will allow for product presentation</li>
                                    <li><strong>Partner space</strong> with comfortable sofas and armchairs, ideal for meetings</li>
                                </ul>
                            </div>

                        ' ) .'  
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">15 000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sponsor Restauracji -->
            <div class="pwe-store__featured-service pwe-store__service" id="sponsor-restauracji">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'SPONSOR RESTAURACJI' : 'RESTAURANT SPONSOR' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'SPONSOR RESTAURACJI' : 'RESTAURANT SPONSOR' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/sponsor-resturacji.webp" alt="Restauracja">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Zostań <strong>Sponsorem Restauracji</strong> podczas targów organizowanych w Ptak Warsaw Expo i zyskaj wyjątkową możliwość zaprezentowania swojej marki w najbardziej uczęszczanym miejscu wydarzenia. Sponsorowanie restauracji to <strong>doskonały sposób na wyróżnienie swojej firmy i dotarcie do szerokiej grupy odbiorców</strong>, w tym liderów branży i kluczowych decydentów.</p>
                            <p>Restauracja to przestrzeń, w której uczestnicy targów odpoczywają, spotykają się na rozmowy biznesowe oraz budują relacje w swobodnej atmosferze. Sponsorowanie restauracji to <strong>doskonały sposób na wyróżnienie swojej firmy i dotarcie do szerokiej grupy odbiorców</strong>, w tym liderów branży i kluczowych decydentów.</p>
                            
                            <div class="pwe-store__featured-info">
                                <p><strong>Prestiżowa widoczność – Dotarcie do szerokiej grupy uczestników – Rozszerzenie zasięgu – Wzrost rozpoznawalności – Promocja w sercu wydarzenia – Tysiące gości każdego dnia targowego</strong></p>
                                <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                <ul>
                                    <li>Logo sponsora na wejściu do restauracji (roll-upy, standy, konstrukcje reklamowe)</li>
                                    <li>Możliwość personalizacji elementów wyposażenia, takich jak serwetki, podkładki na stoły, obrusy.</li>
                                    <li>Ekspozycja logotypu na ekranach digitalowych w restauracji.</li>
                                    <li>Wzmianka o sponsorze w materiałach promujących targi, takich jak e-mailingi i SMS-y, docierających do bazy dziesiątek tysięcy uczestników.</li>
                                    <li>Promocja na stronie internetowej targów w sekcji dotyczącej restauracji oraz w mediach społecznościowych.</li>
                                <li>Dystrybucja ulotek, katalogów lub wizytówek w restauracji wśród jej gości.</li>
                                <li>Dedykowana strefa umożliwiająca prezentację produktów i usług.</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                            <p class="pwe-store__featured-info">Pakiet Sponsor Restauracji to gwarancja ogromnej widoczności i budowania wizerunku Twojej firmy w jednym z najczęściej odwiedzanych miejsc podczas targów. To miejsce, gdzie goście spędzają czas, prowadzą rozmowy i nawiązują relacje – zapewnij swojej marce obecność w sercu tego doświadczenia. </p>                
                            <p class="pwe-store__featured-info">Każde z Naszych wydarzeń odwiedza od 5000 do nawet 70000 odwiedzjących bycie sponsorem restauracji gwarantuje widoczność na targach.</p>
                            <p class="pwe-store__featured-info pwe-store__bold">Oferta ograniczona do jednego sponsora, zapewniająca wyłączność i pełną widoczność marki w przestrzeni restauracji.</p>
                            <p class="pwe-store__featured-info">Daj się zauważyć w miejscu, w którym łączą się biznes, relacje i networking</p>
                        ':'
                            <p class="pwe-store__featured-description">Become a <strong>Restaurant Sponsor</strong> during the trade fair organized at Ptak Warsaw Expo and gain a unique opportunity to present your brand in the most frequented place of the event. Sponsoring a restaurant is an <strong>great way to distinguish your company and reach a wide audience</strong>, including industry leaders and key decision-makers.</p>
                            <p>A restaurant is a space where trade fair participants relax, meet for business talks and build relationships in a relaxed atmosphere. Sponsoring a restaurant is <strong>a great way to distinguish your company and reach a wide audience</strong>, including industry leaders and key decision-makers.</p>

                            <div class="pwe-store__featured-info">
                                <p><strong>Prestigious visibility - Reach a wide group of participants - Expand your reach - Increase your recognition - Promotion at the heart of the event - Thousands of guests every day of the fair</strong></p>
                                <p class="pwe-store__featured-title">ELEMENTS OF THE OFFER:</p>
                                <ul>
                                    <li>Sponsor`s logo at the entrance to the restaurant (roll-ups, stands, advertising structures)</li>
                                    <li>Possibility to personalize equipment elements such as napkins, table mats, tablecloths.</li>
                                    <li>Logo display on digital screens in the restaurant.</li>
                                    <li>Mention the sponsor in promotional materials for the fair, such as e-mails and text messages, reaching a database of tens of thousands of participants.</li>
                                    <li>Promotion on the trade fair website in the restaurant section and in social media.</li>
                                    <li>Distribution of leaflets, catalogues or business cards in the restaurant among its guests.</li>
                                    <li>A dedicated zone enabling the presentation of products and services.</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                            <p class="pwe-store__featured-info">The Restaurant Sponsor Package guarantees huge visibility and building the image of your company in one of the most frequently visited places during the trade fair. This is a place where guests spend time, have conversations and establish relationships - ensure your brand is present at the heart of this experience. </p>
                            <p class="pwe-store__featured-info">Each of our events is visited by 5,000 to even 70,000 visitors. Being a restaurant sponsor guarantees visibility at the fair.</p>
                            <p class="pwe-store__featured-info pwe-store__bold">Offer limited to one sponsor, ensuring exclusivity and full brand visibility in the restaurant space.</p>
                            <p class="pwe-store__featured-info">Get noticed in a place where business, relationships and networking meet.</p>
                        ' ) .'
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">15 000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sponsor Wieczoru Branżowego -->
            <div class="pwe-store__featured-service pwe-store__service" id="sponsor-wieczoru">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'SPONSOR WIECZORU BRANŻOWEGO' : 'INDUSTRY EVENING SPONSOR' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'SPONSOR WIECZORU BRANŻOWEGO' : 'INDUSTRY EVENING SPONSOR' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/sponsor-gali.webp" alt="Sponsor Wieczoru Branżowego">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Zostań Sponsor Wieczoru Branżowego dla Wystawców, organizowanej w prestiżowym klubie w Warszawie, i zyskaj wyjątkową możliwość zaprezentowania swojej marki podczas ekskluzywnego wydarzenia towarzyszącego targom.</p>
                            
                            <div class="pwe-store__featured-info">
                                <p>Wieczór Branżowy to wyjątkowe spotkanie łączące elementy biznesowe i rozrywkowe, gdzie wystawcy, liderzy branż, kluczowi decydenci oraz partnerzy targów spędzają czas w swobodnej atmosferze. W programie wydarzenia znajduje się koncert na żywo (np. Varius Manx lub Elektryczne Gitary), a całość wieczoru sprzyja networkingowi i budowaniu trwałych relacji biznesowych.</p>
                                <p><strong>Prestiżowa widoczność – Dotarcie do liderów branż – Rozszerzenie zasięgu – Wzrost rozpoznawalności – Promocja podczas ekskluzywnego wydarzenia – Setki gości z najwyższej półki biznesowej</strong></p>           
                                <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                <ul>
                                    <li>Logo sponsora na wejściu do klubu (roll-upy, standy, konstrukcje reklamowe)</li>
                                    <li>Ekspozycja logotypu na ekranach w przestrzeni klubu oraz podczas koncertu na żywo</li>
                                    <li>Wzmianka o sponsorze w materiałach promujących Wieczór Branżowy, takich jak e-mailingi i SMS-y, docierających do bazy uczestników targów</li>
                                    <li>Promocja na stronie internetowej targów w sekcji dotyczącej Wieczoru Branżowego oraz w mediach społecznościowych targów i partnerów</li>
                                    <li>Dystrybucja materiałów promocyjnych (ulotki, katalogi, wizytówki) wśród uczestników gali</li>
                                    <li>Dedykowana ścianka medialna z logotypem sponsora do zdjęć dla uczestników i gości gali</li>
                                    <li>Dedykowana loża sponsora w prestiżowej części klubu, idealna do prowadzenia rozmów biznesowych lub odpoczynku w trakcie wydarzenia</li>
                                </ul>
                            </div>
                        
                            <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                            <p class="pwe-store__featured-info">Pakiet Sponsor Wieczoru Branżowego to prestiżowa szansa na wyróżnienie swojej firmy podczas kluczowego wydarzenia targów, gdzie łączą się biznes, rozrywka i networking. Twoja marka zostanie zaprezentowana wśród liderów branży i kluczowych decydentów, co pozwoli na budowanie długofalowych relacji biznesowych i wzrost rozpoznawalności.</p>
                            <p class="pwe-store__featured-info pwe-store__bold">Oferta ograniczona do jednego sponsora, zapewniająca wyłączność i wyjątkową widoczność marki podczas Wieczoru Branżowego.</p>
                            <p class="pwe-store__featured-info">Daj się zauważyć tam, gdzie spotykają się liderzy biznesu, inspiracje i muzyka na żywo!</p>
                        ':'
                            <p class="pwe-store__featured-description">Become a Sponsor of the Industry Evening for Exhibitors, organized in a prestigious club in Warsaw, and gain a unique opportunity to present your brand during an exclusive event accompanying the fair.</p>

                            <div class="pwe-store__featured-info">
                                <p>The Industry Evening is a unique meeting combining business and entertainment elements, where exhibitors, industry leaders, key decision-makers and fair partners spend time in a relaxed atmosphere. The event program includes a live concert (e.g. Varius Manx or Electric Guitars), and the entire evening is conducive to networking and building lasting business relationships.</p>
                                <p><strong>Prestigious visibility - Reaching industry leaders - Expanding reach - Increased recognition - Promotion during an exclusive event - Hundreds of guests from the highest business shelf</strong></p>
                                <p class="pwe-store__featured-title">ELEMENTS OF THE OFFER:</p>
                                <ul>
                                    <li>Sponsor`s logo at the entrance to the club (roll-ups, stands, advertising structures)</li>
                                    <li>Logo display on screens in the club space and during the live concert</li>
                                    <li>Mention of the sponsor in materials promoting the Industry Evening, such as e-mails and text messages, reaching the trade fair participant database</li>
                                    <li>Promotion on the trade fair website in the section concerning the Industry Evening and in social media fairs and partners</li>
                                    <li>Distribution of promotional materials (leaflets, catalogues, business cards) to gala participants</li>
                                    <li>Dedicated media wall with sponsor`s logo for photos for gala participants and guests</li>
                                    <li>Dedicated sponsor`s box in the prestigious part of the club, ideal for conducting business talks or relaxing during the event</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                            <p class="pwe-store__featured-info">The Industry Evening Sponsor Package is a prestigious opportunity to distinguish your company during the key event of the fair, where business, entertainment and networking combine. Your brand will be presented to industry leaders and key decision-makers, allowing you to build long-term business relationships and increase recognition.</p>
                            <p class="pwe-store__featured-info pwe-store__bold">Offer limited to one sponsor, providing exclusivity and exceptional brand visibility during the Industry Evening.</p>
                            <p class="pwe-store__featured-info">Get noticed where business leaders, inspiration and live music meet!</p>
                        ' ) .'
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">20 000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bilet na Wieczór Branżowy -->
            <div class="pwe-store__featured-service pwe-store__service" id="bilet-na-wieczor">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'BILET NA WIECZÓR BRANŻOWY' : 'TICKET FOR THE INDUSTRY EVENING' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'BILET NA WIECZÓR BRANŻOWY' : 'TICKET FOR THE INDUSTRY EVENING' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="'. ( self::lang_pl() ? '/wp-content/plugins/PWElements/media/store/bilet-na-gale.webp' : '/wp-content/plugins/PWElements/media/store/bilet-na-gale-en.webp' ) .'" alt="Bilet na Wieczór Branżowy">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Weź udział w prestiżowej Gali Wieczornej organizowanej przez Ptak Warsaw Expo w prestiżowym klubie w Warszawie. To wyjątkowe wydarzenie dla liderów branży, wystawców i partnerów biznesowych, które łączy networking na najwyższym poziomie z niezapomnianą rozrywką.</p>
                            
                            <div class="pwe-store__featured-info">
                                
                                <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                <p class="pwe-store__featured-title">Wstęp na galę:</p>
                                <ul>
                                    <li>Udział w wydarzeniu w gronie liderów branży</li>
                                    <li>Swobodny networking w nieformalnej atmosferze</li>
                                </ul>
                                <p class="pwe-store__featured-title">Koncert na żywo:</p>
                                <ul>
                                    <li>Występ kultowego zespołu, np. Varius Manx lub Elektryczne Gitary</li>
                                </ul>
                                <p class="pwe-store__featured-title">Catering:</p>
                                <ul>
                                    <li>Wykwintne przekąski, ciepły bufet oraz napoje serwowane przez cały wieczór</li>
                                </ul>
                                <p class="pwe-store__featured-title">Networking i korzyści biznesowe:</p>
                                <ul>
                                    <li>Strefy dedykowane rozmowom z kluczowymi decydentami i przedstawicielami największych firm</li>
                                    <li>Możliwość zaprezentowania swojej firmy, wymiany wizytówek i budowania relacji w ekskluzywnym otoczeniu</li>
                                </ul>
                                <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                                <ul>
                                    <li>Limitowana liczba miejsc – ekskluzywność wydarzenia gwarantuje obecność kluczowych osób z branży</li>
                                    <li>Inspirująca atmosfera, wyjątkowa lokalizacja z widokiem na Warszawę i profesjonalnie zorganizowany wieczór</li>
                                    <li>Szansa na nawiązanie relacji, które mogą zaowocować wieloletnią współpracą</li>
                                </ul>
                            </div>
                            
                            <p class="pwe-store__featured-info"><strong>Rezerwuj już dziś!</strong> Liczba miejsc ograniczona!</p>
                        ':'
                            <p class="pwe-store__featured-description">Take part in the prestigious Evening Gala organized by Ptak Warsaw Expo in a prestigious club in Warsaw. This is a unique event for industry leaders, exhibitors and business partners, which combines top-level networking with unforgettable entertainment.</p>

                            <div class="pwe-store__featured-info">
                                <p class="pwe-store__featured-title">OFFER ELEMENTS:</p>

                                <p class="pwe-store__featured-title">Gala admission:</p>
                                <ul>
                                    <li>Participation in the event with industry leaders</li>
                                    <li>Casual networking in an informal atmosphere</li>
                                </ul>

                                <p class="pwe-store__featured-title">Live concert:</p>
                                <ul>
                                    <li>Performance by a cult band, e.g. Varius Manx or Elektryczne Gitary</li>
                                </ul>

                                <p class="pwe-store__featured-title">Catering:</p>
                                <ul>
                                    <li>Exquisite snacks, hot buffet and drinks served throughout the evening</li>
                                </ul>

                                <p class="pwe-store__featured-title">Networking and business benefits:</p>
                                <ul>
                                    <li>Zones dedicated to conversations with key decision-makers and representatives of the largest companies</li>
                                    <li>Opportunity to present your company, exchange business cards and build relationships in an exclusive environment</li>
                                </ul>

                                <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                                <ul>
                                    <li>Limited number of seats - the exclusivity of the event is guaranteed by the presence of key people from the industry</li>
                                    <li>Inspiring atmosphere, unique location with a view of Warsaw and a professionally organized evening</li>
                                    <li>A chance to establish relationships that can result in long-term cooperation</li>
                                </ul>
                            </div>

                            <p class="pwe-store__featured-info"><strong>Book today!</strong> Limited spaces!</p>
                        ' ) .'
                            
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bilet VIP GOLD -->
            <div class="pwe-store__featured-service pwe-store__service" id="bilet-vip-gold">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'BILET VIP GOLD – LUKSUSOWE DOŚWIADCZENIE NA TARGACH' : 'VIP GOLD TICKET – LUXURY EXPERIENCE AT THE FAIR' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'BILET VIP GOLD' : 'VIP GOLD TICKET' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="'. ( self::lang_pl() ? '/wp-content/plugins/PWElements/media/store/bilet-vip-gold.webp' : '/wp-content/plugins/PWElements/media/store/bilet-vip-gold-en.webp' ) .'" alt="VIP GOLD">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                        '. ( self::lang_pl() ? '
                            <p class="pwe-store__featured-description">Wybierz <strong>Bilet VIP Gold</strong> i ciesz się wygodą, prestiżem oraz wyjątkową obsługą podczas targów w Ptak Warsaw Expo.</p>
                            
                            <div class="pwe-store__featured-info">
                                <h4>ELEMENTY OFERTY</h4>
                                
                                <p class="pwe-store__featured-title">Dedykowane wejście:</p>
                                <ul>
                                    <li>Priorytetowy dostęp bez kolejek</li>
                                </ul>
                            
                                <p class="pwe-store__featured-title">Obsługa Concierge:</p>
                                <ul>
                                    <li>Profesjonalna pomoc w organizacji wizyty na targach</li>
                                </ul>

                                <p class="pwe-store__featured-title">Dostęp do VIP Roomu:</p>
                                <ul>
                                    <li>Ekskluzywna strefa relaksu z przekąskami i napojami, idealna na odpoczynek lub biznesowe rozmowy</li>
                                </ul>
                            
                                <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                                <ul>
                                    <li>Komfort i oszczędność czasu</li>
                                    <li>Prestiżowy dostęp do stref VIP</li>
                                    <li>Ułatwiony networking i relaks w jednym miejscu</li>
                                </ul>
                            </div>
                        ':'
                            <p class="pwe-store__featured-description">Choose <strong>VIP Gold Ticket</strong> and enjoy comfort, prestige and exceptional service during the fair at Ptak Warsaw Expo.</p>

                            <div class="pwe-store__featured-info">
                                <h4>OFFER ELEMENTS</h4>

                                <p class="pwe-store__featured-title">Dedicated entrance:</p>
                                <ul>
                                    <li>Priority access without queues</li>
                                </ul>

                                <p class="pwe-store__featured-title">Concierge service:</p>
                                <ul>
                                    <li>Professional assistance in organizing your visit to the fair</li>
                                </ul>

                                <p class="pwe-store__featured-title">Access to the VIP Room:</p>
                                <ul>
                                    <li>Exclusive relaxation zone with snacks and drinks, ideal for relaxation or business talks</li>
                                </ul>

                                <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                                <ul>
                                    <li>Comfort and time savings</li>
                                    <li>Prestigious access to VIP zones</li>
                                    <li>Easy networking and relaxation in one place</li>
                                </ul>
                            </div>
                        ' ) .' 
                        </div>
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">300 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sponsor Insertu Reklamowego -->
            <div class="pwe-store__featured-service pwe-store__service" id="sponsor-wkladki-reklamowej">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'ZOSTAŃ SPONSOREM INSERTU REKLAMOWEGO DO WYSYŁKI POCZTOWEJ' : 'BECOME A SPONSOR OF AN ADVERTISING INSERT FOR MAIL SHIPPING' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'SPONSOR INSERTU REKLAMOWEGO DO WYSYŁKI POCZTOWEJ' : 'ADVERTISING INSERT SPONSOR FOR MAIL SHIPPING' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/sponsor-wkladki.webp" alt="Wkładka Reklamowa">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                            '. ( self::lang_pl() ? '
                                <p class="pwe-store__featured-description">Zaprezentuj swoją firmę bezpośrednio w rękach 100 000 uczestników i liderów branży! Każdego roku na wydarzenia <strong>Ptak Warsaw Expo</strong> wysyłamy setki tysięcy listów do wystawców, partnerów i odwiedzających. Teraz możesz umieścić swoją <strong>wkładkę reklamową</strong> w naszych przesyłkach, docierając do kluczowych decydentów jeszcze przed rozpoczęciem targów!</p>
                            
                                <div class="pwe-store__featured-info">
                                    <p>Twoja reklama trafi bezpośrednio do potencjalnych klientów jeszcze przed wydarzeniem!</p>
                                    <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                    <ul>
                                        <li><strong>Wkładka reklamowa w przesyłkach:</strong> Twoja ulotka, broszura lub inny materiał reklamowy dołączony do każdego listu</li>
                                        <li><strong>Precyzyjne targetowanie:</strong> Docierasz do liderów branży, kluczowych decydentów, wystawców i odwiedzających zainteresowanych Twoją ofertą</li>
                                        <li><strong>Ogromny zasięg:</strong> Reklama w 100 000 listów wysyłanych na każde wydarzenie</li>
                                    </ul>
                                    <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                                    <ul>
                                        <li><strong>Bezpośredni kontakt:</strong> Twoja reklama trafi bezpośrednio w ręce potencjalnych klientów</li>
                                        <li><strong>Wysoka widoczność:</strong> Materiały reklamowe dostarczane wraz z oficjalnymi dokumentami targowymi mają większą szansę na przyciągnięcie uwagi</li>
                                        <li><strong>Skuteczna promocja:</strong> Doskonały sposób na poinformowanie o swojej ofercie jeszcze przed wydarzeniem</li>
                                    </ul>
                                </div>
                                
                                <p class="pwe-store__featured-title">CENA I DOSTĘPNOŚĆ:</p>
                                <p class="pwe-store__featured-info"><strong>Koszt wkładki reklamowej:</strong> Ustalany indywidualnie w zależności od formatu i nakładu.</p>
                                <p class="pwe-store__featured-info"><strong>Rezerwacja:</strong> Liczba miejsc na sponsorów wkładek ograniczona – zgłoś się już dziś!</p>
                                <p class="pwe-store__bold">Zarezerwuj miejsce na swoją wkładkę reklamową i dotrzyj do 100 000 uczestników targów Ptak Warsaw Expo!</p>
                            ':'
                                <p class="pwe-store__featured-description">Present your company directly in the hands of 100,000 attendees and industry leaders! Every year for <strong>Ptak Warsaw Expo</strong> events we send hundreds of thousands of letters to exhibitors, partners and visitors. Now you can place your <strong>advertising insert</strong> in our mailings, reaching key decision-makers even before the fair!</p>

                                <div class="pwe-store__featured-info">
                                    <p>Your advertising will reach potential customers directly before the event!</p>

                                    <p class="pwe-store__featured-title">OFFER ELEMENTS:</p>
                                    <ul>
                                        <li><strong>Advertising insert in mailings:</strong> Your leaflet, brochure or other advertising material attached to each letter</li>
                                        <li><strong>Precise targeting:</strong> You reach industry leaders, key decision-makers, exhibitors and visitors interested in your offer</li>
                                        <li><strong>Huge reach:</strong> Advertising in 100,000 letters sent to each event</li>
                                    </ul>

                                    <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                                    <ul>
                                        <li><strong>Direct contact:</strong> Your ad will go directly to potential customers</li>
                                        <li><strong>High visibility:</strong> Advertising materials delivered with official trade fair documents have a greater chance of attracting attention</li>
                                        <li><strong>Effective promotion:</strong> A great way to inform about your offer before the event</li>
                                    </ul>
                                </div>

                                <p class="pwe-store__featured-title">PRICE AND AVAILABILITY:</p>
                                <p class="pwe-store__featured-info"><strong>Advertising insert cost:</strong> Determined individually depending on the format and circulation.</p>
                                <p class="pwe-store__featured-info"><strong>Reservation:</strong> Number of spots for sponsors inserts limited - apply today!</p>
                                <p class="pwe-store__bold">Reserve a place for your advertising insert and reach 100,000 participants of the Ptak Warsaw Expo!</p>
                            ' ) .'
                        </div>
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sekcja w Mailingu -->
            <div class="pwe-store__featured-service pwe-store__service" id="sekcja-mailingu">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'WYKUP DEDYKOWANĄ SEKCJĘ W MAILINGU PTAK WARSAW EXPO' : 'BUY A DEDICATED SECTION IN THE PTAK WARSAW EXPO MAILING' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'DEDYKOWANA SEKCJA W MAILINGU' : 'DEDICATED SECTION IN MAILING' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/sekcja-w-mailingu.webp" alt="Mailing">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                            '. ( self::lang_pl() ? '
                                <p class="pwe-store__featured-description">Zaprezentuj swoją firmę w <strong>dedykowanej sekcji w mailingu</strong> wysyłanym do kilkuset tysięcy uczestników i wystawców największych targów w Polsce. Twoja marka i oferta trafią bezpośrednio do skrzynek mailowych kluczowych decydentów i liderów branży. To skuteczny sposób na zwiększenie widoczności i promocję jeszcze przed wydarzeniem.</p>
                            
                                <div class="pwe-store__featured-info">
                                    <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                    <ul>
                                        <li><strong>Dedykowana sekcja:</strong> Twoje logo, grafika, treść i link do strony internetowej w wybranej kampanii mailingowej</li>
                                        <li><strong>Precyzyjne targetowanie:</strong> Mailing wysyłany do bazy danych uczestników i wystawców zainteresowanych branżową ofertą</li>
                                        <li><strong>Szeroki zasięg:</strong> Setki tysięcy odbiorców z różnych sektorów biznesowych</li>
                                    </ul>
                                    <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                                    <ul>
                                        <li><strong>Skuteczna promocja:</strong> Twoja oferta widoczna w wyróżnionej sekcji maila</li>
                                        <li><strong>Bezpośredni kontakt:</strong> Twoja marka trafia prosto do potencjalnych klientów</li>
                                        <li><strong>Budowanie rozpoznawalności:</strong> Idealny sposób na wzmocnienie wizerunku przed wydarzeniem</li>
                                    </ul>
                                </div>
                                
                                <p class="pwe-store__featured-title">CENA I DOSTĘPNOŚĆ:</p>
                                <p class="pwe-store__featured-info"><strong>Koszt sekcji mailingowej:</strong> Ustalany indywidualnie w zależności od zasięgu i liczby wysyłek.</p>
                                <p class="pwe-store__featured-info"><strong>Rezerwacja:</strong> Liczba miejsc w mailingu ograniczona – decyduje kolejność zgłoszeń.</p>
                                <p class="pwe-store__bold">Zarezerwuj dedykowaną sekcję w mailingu Ptak Warsaw Expo i wyróżnij swoją firmę wśród liderów branży!</p>
                            ':'
                                <p class="pwe-store__featured-description">Present your company in <strong>a dedicated section in the mailing</strong> sent to several hundred thousand participants and exhibitors of the largest fairs in Poland. Your brand and offer will go directly to the mailboxes of key decision-makers and industry leaders. This is an effective way to increase visibility and promotion even before the event.</p>

                                <div class="pwe-store__featured-info">
                                    <p class="pwe-store__featured-title">OFFER ELEMENTS:</p>
                                    <ul>
                                        <li><strong>Dedicated section:</strong> Your logo, graphics, content and website link in the selected mailing campaign</li>
                                        <li><strong>Precise targeting:</strong> Mailing sent to a database of participants and exhibitors interested in the industry offer</li>
                                        <li><strong>Wide reach:</strong> Hundreds of thousands of recipients from various business sectors</li>
                                    </ul>
                                    
                                    <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                                    <ul>
                                        <li><strong>Effective promotion:</strong> Your offer visible in the highlighted section of the email</li>
                                        <li><strong>Direct contact:</strong> Your brand goes straight to potential customers</li>
                                        <li><strong>Building recognition:</strong> The perfect way to strengthen your image before the event</li>
                                    </ul>
                                </div>

                                <p class="pwe-store__featured-title">PRICE AND AVAILABILITY:</p>
                                <p class="pwe-store__featured-info"><strong>Cost of the mailing section:</strong> Determined individually depending on the reach and number of shipments.</p>
                                <p class="pwe-store__featured-info"><strong>Reservation:</strong> The number of places in the mailing is limited - the order of applications decides.</p>
                                <p class="pwe-store__bold">Reserve a dedicated section in the Ptak Warsaw Expo mailing and distinguish your company among the industry leaders!</p>
                            ' ) .'
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lokowanie w SMS -->
            <div class="pwe-store__featured-service pwe-store__service" id="lokowanie-w-sms">
                <h3 class="pwe-store__service-name">'. ( self::lang_pl() ? 'LOKOWANIE NAZWY FIRMY W SMSACH PTAK WARSAW EXPO' : 'PLACING COMPANY NAME IN SMS PTAK WARSAW EXPO' ) .'</h3>
                <span class="pwe-store__service-name-mailing">'. ( self::lang_pl() ? 'LOKOWANIE NAZWY FIRMY W SMSACH' : 'PLACING YOUR COMPANY NAME IN SMS' ) .'</span>
                <div class="pwe-store__featured-content">
                    <div class="pwe-store__featured-image">
                        <img src="/wp-content/plugins/PWElements/media/store/lokowanie-sms.webp" alt="SMS Marketing">
                    </div>
                    <div class="pwe-store__featured-details">
                        <div class="pwe-store__featured-text">
                            '. ( self::lang_pl() ? '
                                <p class="pwe-store__featured-description">Promuj swoją markę skutecznie i bezpośrednio dzięki lokowaniu nazwy w naszych kampaniach SMS! Wiadomości tekstowe to jedno z najskuteczniejszych narzędzi marketingowych, które dociera do odbiorców w czasie rzeczywistym. Wykorzystaj tę możliwość, aby zwiększyć widoczność swojej firmy wśród uczestników i wystawców największych targów w Polsce.</p>
                            
                                <div class="pwe-store__featured-info">                            
                                    <p class="pwe-store__featured-title">ELEMENTY OFERTY:</p>
                                    <p class="pwe-store__featured-info"><strong>Pojedyncze lokowanie:</strong></p>
                                    <ul>
                                        <li>Twoja nazwa firmy umieszczona w treści jednego SMS-a wysyłanego do naszej bazy odbiorców. (specyfika bazy do wyboru)</li>
                                    </ul>

                                    <p class="pwe-store__featured-info"><strong>Pakiet 3 SMS-ów:</strong></p>
                                    <ul>
                                        <li>Lokowanie nazwy firmy w serii trzech wiadomości wysyłanych na różnych etapach kampanii – przed, w trakcie lub po targach. (specyfika bazy do wyboru)</li>
                                    </ul>

                                    <p class="pwe-store__featured-title">CO ZYSKUJESZ?</p>
                                    <ul>
                                        <li><strong>Bezpośredni kontakt:</strong> Twoja marka w SMS-ach trafiających do tysięcy odbiorców</li>
                                        <li><strong>Szybka widoczność:</strong> SMS-y odczytywane niemal natychmiast po dostarczeniu (ponad 90% w ciągu kilku minut)</li>
                                        <li><strong>Skuteczna promocja:</strong> Wyjątkowy sposób na podkreślenie obecności Twojej firmy w komunikacji targowej</li>
                                    </ul>

                                    <p class="pwe-store__featured-title">DLACZEGO WARTO?</p>
                                    <ul>
                                        <li><strong>Duży zasięg:</strong> Docierasz do naszej bazy kontaktów, w tym liderów branży, wystawców i uczestników targów</li>
                                        <li><strong>Wysoka skuteczność:</strong> SMS-y to jedno z najbardziej angażujących narzędzi marketingowych</li>
                                        <li><strong>Elastyczność:</strong> Możliwość wyboru pojedynczej wiadomości lub pakietu 3 SMS-ów</li>
                                    </ul>
                                </div>

                                <p class="pwe-store__featured-title">CENA I DOSTĘPNOŚĆ:</p>
                                <p class="pwe-store__featured-info"><strong>Koszt lokowania:</strong> Ustalany indywidualnie w zależności od liczby SMS-ów i wielkości kampanii.</p>
                                <p class="pwe-store__featured-info"><strong>Rezerwacja:</strong> Ograniczona liczba lokowań – zarezerwuj miejsce już dziś!</p>
                                <p class="pwe-store__bold">Wykorzystaj kampanie SMS Ptak Warsaw Expo, aby zwiększyć widoczność swojej marki i dotrzeć bezpośrednio do kluczowych odbiorców!</p>
                            ':'
                                <p class="pwe-store__featured-description">Promote your brand effectively and directly by placing your name in our SMS campaigns! Text messages are one of the most effective marketing tools that reach recipients in real time. Use this opportunity to increase your company`s visibility among participants and exhibitors of the largest trade fairs in Poland.</p>

                                <div class="pwe-store__featured-info">
                                    <p class="pwe-store__featured-title">OFFER ELEMENTS:</p>

                                    <p class="pwe-store__featured-info"><strong>Single placement:</strong></p>
                                    <ul>
                                        <li>Your company name placed in the content of one SMS sent to our recipient database. (specific database to choose from)</li>
                                    </ul>

                                    <p class="pwe-store__featured-info"><strong>Package of 3 SMS messages:</strong></p>
                                    <ul>
                                        <li>Placing the company name in a series of three messages sent at different stages of the campaign - before, during or after the fair. (specific database to choose from)</li>
                                    </ul>

                                    <p class="pwe-store__featured-title">WHAT DO YOU GAIN?</p>
                                    <ul>
                                        <li><strong>Direct contact:</strong> Your brand in text messages reaching thousands of recipients</li>
                                        <li><strong>Fast visibility:</strong> Text messages read almost immediately after delivery (over 90% within a few minutes)</li>
                                        <li><strong>Effective promotion:</strong> A unique way to emphasize your company`s presence in trade fair communication</li>
                                    </ul>

                                    <p class="pwe-store__featured-title">WHY IS IT WORTH IT?</p>
                                    <ul>
                                        <li><strong>Wide reach:</strong> You reach our contact database, including industry leaders, exhibitors and trade fair participants</li>
                                        <li><strong>High effectiveness:</strong> SMS is one of the most engaging marketing tools</li>
                                        <li><strong>Flexibility:</strong> Possibility to choose a single message or a package of 3 SMS</li>
                                    </ul>
                                </div>

                                <p class="pwe-store__featured-title">PRICE AND AVAILABILITY:</p>
                                <p class="pwe-store__featured-info"><strong>Placement cost:</strong> Determined individually depending on the number of SMS and the size of the campaign.</p>
                                <p class="pwe-store__featured-info"><strong>Reservation:</strong> Limited number of placements - reserve your place today!</p>
                                <p class="pwe-store__bold">Use Ptak Warsaw Expo SMS campaigns to increase your brand`s visibility and reach key recipients directly!</p>
                            ' ) .'
                        </div>
                        
                        <div class="pwe-store__featured-footer">
                            <span class="pwe-store__featured-pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</span>
                            <div class="pwe-store__featured-buttons">
                                <a href="#" class="pwe-store__contact-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'KONTAKT' : 'CONTACT' ) .'</a>
                                <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sekcja pwe-store__services-cards -->
            <h1>'. ( self::lang_pl() ? 'ZWIĘKSZ SWÓJ POTENCJAŁ NA TARGACH: USŁUGI PREMIUM!' : 'INCREASE YOUR POTENTIAL AT TRADE FAIRS: PREMIUM SERVICES!' ) .'</h1>
            <div class="pwe-store__services-cards">

                <!-- Spersonalizowane Smyczki -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="smycze">
                        <div class="pwe-store__service-image">
                            <img src="/wp-content/plugins/PWElements/media/store/smycze-z-logotypem.webp" alt="Smycze z logotypem">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPERSONALIZOWANE SMYCZKI Z TWOIM LOGO</h4>
                            <p>Dystrybucja smyczy z logotypem Twojej firmy wśród uczestników Targów</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">PERSONALIZED LANYARDS WITH YOUR LOGO</h4>
                            <p>Distribution of lanyards with your company logo among Fair participants</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">5500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="smycze">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
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
                            <p>Logo Twojej Firmy na identyfikatorach wszystkich uczestników Targów</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">YOUR COMPANY LOGO ON PARTICIPANTS` ID BADGES</h4>
                            <p>Your Company Logo on ID BADGES of all Fair participants</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">6500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>                    
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="logotyp">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
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
                            <p>Reklama Twojej firmy w drukowanym Planie Targowym</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">TRADE FAIR PLAN SPONSOR</h4>
                            <p>Advertise your company in the printed Trade Plan</p>
                            ' ) .'
                        
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">5000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div> 
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="sponsor-planu">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>

                <!-- Partner VIP Room -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="vip-room">
                        <div class="pwe-store__service-image">
                            <img src="/wp-content/plugins/PWElements/media/store/partner-vip-room.webp" alt="Partner VIP Room">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">PARTNER VIP ROOM</h4>
                            <p>Ekskluzywna przestrzeń dla Twojej marki w strefie VIP, gdzie spotykają się liderzy branży</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">VIP ROOM PARTNER</h4>
                            <p>Exclusive space for your brand in the VIP zone, where industry leaders meet</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">15 000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="vip-room">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>

                <!-- Sponsor Restauracji -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="sponsor-restauracji">
                        <div class="pwe-store__service-image">
                            <img src="/wp-content/plugins/PWElements/media/store/sponsor-resturacji.webp" alt="Sponsor Restauracji">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPONSOR RESTAURACJI</h4>
                            <p>Wyjątkowa widoczność Twojej marki w najbardziej uczęszczanym miejscu wydarzenia</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">RESTAURANT SPONSOR</h4>
                            <p>Exceptional visibility for your brand in the most frequented event location</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">15 000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="sponsor-restauracji">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>

                <!-- Sponsor of the Industry Evening -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="sponsor-wieczoru">
                        <div class="pwe-store__service-image">
                            <img src="/wp-content/plugins/PWElements/media/store/sponsor-gali.webp" alt="Sponsor Gali">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPONSOR WIECZORU BRANŻOWEGO</h4>
                            <p>Prestiżowa promocja podczas ekskluzywnego wydarzenia w prestiżowym klubie w Warszawie</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">INDUSTRY EVENING SPONSOR</h4>
                            <p>A prestigious promotion during an exclusive event at a prestigious club in Warsaw</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">20 000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="sponsor-gali">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>

                <!-- Bilet na Wieczór Branżowy -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="bilet-na-wieczor">
                        <div class="pwe-store__service-image">
                            <img src="'. ( self::lang_pl() ? '/wp-content/plugins/PWElements/media/store/bilet-na-gale.webp' : '/wp-content/plugins/PWElements/media/store/bilet-na-gale-en.webp' ) .'" alt="Bilet na Wieczór Branżowy">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">BILET NA WIECZÓR BRANŻOWY</h4>
                            <p>Weź udział w ekskluzywnym wydarzeniu łączącym networking i rozrywkę na najwyższym poziomie</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">TICKET FOR THE INDUSTRY EVENING</h4>
                            <p>Take part in an exclusive event combining networking and entertainment at the highest level</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="bilet-na-wieczor">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>

                <!-- Bilet VIP GOLD -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="bilet-vip-gold">
                        <div class="pwe-store__service-image">
                            <img src="'. ( self::lang_pl() ? '/wp-content/plugins/PWElements/media/store/bilet-vip-gold.webp' : '/wp-content/plugins/PWElements/media/store/bilet-vip-gold-en.webp' ) .'" alt="VIP GOLD">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">BILET VIP GOLD</h4>
                            <p>Ekskluzywny dostęp i komfortowe warunki dla najbardziej wymagających gości</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">VIP GOLD TICKET</h4>
                            <p>Exclusive access and comfortable conditions for the most demanding guests</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">300 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="bilet-vip-gold">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>

                <!-- Sponsor Insertu Reklamowego -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="sponsor-wkladki-reklamowej">
                        <div class="pwe-store__service-image">
                            <img src="/wp-content/plugins/PWElements/media/store/sponsor-wkladki.webp" alt="Wkładka Reklamowa">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SPONSOR INSERTU REKLAMOWEGO DO WYSYŁKI POCZTOWEJ</h4>
                            <p>Dotrzyj do 100 000 uczestników poprzez wkładkę reklamową w oficjalnej korespondencji</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">ADVERTISING INSERT SPONSOR FOR MAIL SHIPPING</h4>
                            <p>Reach 100,000 participants with an advertising insert in official correspondence</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="sponsor-wkladki-reklamowej">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>

                <!-- Sekcja w Mailingu -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="sekcja-mailingu">
                        <div class="pwe-store__service-image">
                            <img src="/wp-content/plugins/PWElements/media/store/sekcja-w-mailingu.webp" alt="Mailing">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">DEDYKOWANA SEKCJA W MAILINGU</h4>
                            <p>Skuteczna promocja w oficjalnej komunikacji mailowej targów</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">DEDICATED SECTION IN MAILING</h4>
                            <p>Effective promotion in the official e-mail communication of the fair</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="sekcja-mailingu">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
                    </div>
                </div>
            
                <!-- Lokowanie w SMS -->
                <div class="pwe-store__service-card pwe-store__service">
                    <a href="#" data-featured="lokowanie-w-sms">
                        <div class="pwe-store__service-image">
                            <img src="/wp-content/plugins/PWElements/media/store/lokowanie-sms.webp" alt="SMS Marketing">
                        </div>
                        <div class="pwe-store__service-content">
                            '. ( self::lang_pl() ? '
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">LOKOWANIE NAZWY FIRMY W SMSACH</h4>
                            <p>Skuteczna promocja w kampaniach SMS z wysokim współczynnikiem odczytań</p>
                            ':'
                            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">PLACING YOUR COMPANY NAME IN SMS</h4>
                            <p>Effective promotion in SMS campaigns with a high read rate</p>
                            ' ) .'
                            
                            <div class="pwe-store__service-footer">
                                <div class="pwe-store__price">'. ( self::lang_pl() ? 'Cena ustalana indywidualnie' : 'Price determined individually' ) .'</div>
                            </div>
                        </div>
                    </a>
                    <div class="pwe-store__btn-container">
                        <a href="#" class="pwe-store__more-button" data-featured="lokowanie-w-sms">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
                        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
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