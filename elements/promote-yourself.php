<?php
/**
* Class PWElementPromot
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementPromot extends PWElements {

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
                'heading' => __('Hide Baners To Download', 'pwelement'),
                'param_name' => 'show_banners',
                'description' => __('Check Yes to hide download options for baners.', 'pwelement'),
                'value' => '',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementPromot',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Dispaly Different Logo Color', 'pwelement'),
                'param_name' => 'logo_color',
                'description' => __('Check Yes to display different logo color.', 'pwelement'),
                'value' => '',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementPromot',
                ),
            ),
        );
        return $element_output;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        $show_banners = isset($atts['show_banners']) ? $atts['show_banners'] : false;
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$fair_colors['Accent']) . '!important';
        $btn_border = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$fair_colors['Accent']) . '!important';
        
        $darker_btn_color = self::adjustBrightness($btn_color, -20);
        
        $logo_href = '';
        $logo_color = self::findBestLogo($atts["logo_color"]); 
        $logo_color_array = explode('"', $logo_color);
        foreach($logo_color_array as $href) {
            if(strpos(strtolower($href), '/doc/') !== false) {
                $logo_href = $href;
            }
        }
        $output = '';

        $promoteImage = self::findAllImages('/doc/galeria', 1);
        
        $output .= 
            '<style>
                .pwe-image-container {
                    position: relative;
                    max-width: 45%;
                    float: right;
                }
                .download-hover {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    background-color: rgba(0, 0, 0, 1);
                    color: white;
                    padding: 10px 20px;
                    border-radius: 5px;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                    cursor: pointer;
                }
                .download-uslug:hover .download-hover,
                .download-social:hover .download-hover {
                    opacity: 1;
                }
                .pwe-promote-text-block img{
                    max-width: 45%;
                    margin:18px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-btn {
                    color:' . $btn_text_color .';
                    background-color: '. $btn_color .';
                    border: 1px solid '. $btn_border .';
                }
                .pwelement_'. self::$rnd_id .' .pwe-btn:hover {
                    color: '. $btn_text_color .';
                    background-color: '. $darker_btn_color .'!important;
                    border: 1px solid '. $darker_btn_color .'!important;
                }
                .pwe-content-promote-item {
                    flex-wrap: wrap;
                    margin: 36px auto;
                    justify-content: space-around;
                }
                .pwe-border-element {
                    border: 2px solid '. $btn_color .';
                    border-radius: 10px;
                }
                .pwe-content-promote-item .btn-icon-right {
                    color:white !important;
                }
                .pwe-content-promote-item .pwe-content-promote-element {
                    margin: 18px;
                    flex:1;
                    justify-content: space-between;
                    align-items: center;
                    max-width: 250px;
                    display:flex !important;
                    gap: 5px;
                }
                .pwe-content-promote-item .pwe-content-promote-element h3 {
                    margin:0;
                }
                .pwe-content-promote-item .pwe-content-promote-element img {
                    max-height: 150px;
                    object-fit: contain;
                }
                .pwe-content-promote-item div .btn {
                    transform: none !important;
                    white-space: unset !important;
                    font-size: 16px;
                }
                .pwe-content-promote-item div .btn-container {
                    display: flex;
                    justify-content: center;
                }
                .pwe-content-promote-item__help {
                    width: 80%;
                    max-width: 860px;
                    margin: auto;
                }
                .pwe-content-promote-item__help h2 { 
                    margin-top: 0;
                    color:' . $text_color . ';
                }
                .pwe-content-promote-item__help div {
                    margin-top: 18px;
                }
                .pwe-content-promote-item__help a{
                    font-weight: 600;
                    color:' . $text_color . ';
                }
                .pwe-hide-promote {
                    width: 66%;
                    margin: 0 auto;
                }
                .pwe-content-promote-item__help :is(h2, a) {
                    font-size: 24px !important;
                }
                @media(max-width:960px) {
                    .pwe-image-container,
                    .pwe-promote-text-block {
                        max-width:100% !important;
                    }
                    .pwe-image-container {
                        float: unset;
                        margin-top: 18px;
                    }
                    .pwe-promote-top-container {
                        display: flex;
                        flex-direction: column-reverse;
                    }
                    .download-hover {
                        opacity: 1;
                        top: 75%;
                        padding: 5px 5px;
                    }
                    .pwe-content-promote-item__help {
                        padding: 9px !important;
                        text-align: center;
                        width: 100%;
                    }
                    .pwe-hide-promote {
                        width: 100%;
                    }
                }
                @media (max-width:600px) {
                    .promote-img-contener {
                        order: 2;
                        text-align: center;
                    }
                    .pwe-promote-text-block img {
                        float: unset;
                        max-width: 90%;
                    }
                    .pwe-promote-text-block {
                        display: flex;
                        flex-direction: column;
                    }
                    .pwe-content-promote-item.pwe-flex {
                        flex-direction: column;
                        align-items: center;
                    }
                    .pwelement .h2.mobile-kons-email {
                        font-size: calc(7px + 3vw) !important;
                    }
                }
                .promote-element-background-element {
                    background: lightgrey;
                }
            </style>

            <div id="promoteYourself" >
                <div class="pwe-content-promote-item pwe-promote-top-container column-reverse pwe-align-left">
                    <div class="pwe-image-container">
                        <div class="promote-img-contener" style="display: flex; gap: 20px;">
                            <div style="margin: 0 18px;" class="pwe-image-container download-uslug">'.
                                self::languageChecker(
                                    <<<PL
                                    <img class="" src="/wp-content/plugins/custom-element/media/Katalog-uslug-marketingowych.webp">
                                    <div class="download-hover">
                                        <a style="color: white;" target="_blank" href="https://warsawexpo.eu/docs/Katalog-uslug-marketingowych.pdf">
                                            <i class="fa fa-inbox2"></i>Pobierz
                                        </a>
                                    </div> 
                                    PL,
                                    <<<EN
                                    <img class="" src="/wp-content/plugins/custom-element/media/Katalog-uslug-marketingowych-en.webp">
                                    <div class="download-hover">
                                        <a style="color: white;" target="_blank" href="https://warsawexpo.eu/docs/Katalog-uslug-marketingowych-EN.pdf">
                                            <i class="fa fa-inbox2"></i>Download
                                        </a>
                                    </div>
                                    EN
                                ).'</div>
                                <div style="margin: 0 18px;" class="pwe-image-container download-social">'.
                                self::languageChecker(
                                    <<<PL
                                    <img class="" src="/wp-content/plugins/custom-element/media/Katalog-uslug-social-media.webp">
                                    <div class="download-hover">
                                        <a style="color: white;" target="_blank" href="https://warsawexpo.eu/docs/Katalog-uslug-social-media.pdf">
                                            <i class="fa fa-inbox2"></i>Pobierz
                                        </a>
                                    </div>
                                    PL,
                                    <<<EN
                                    <img class="" src="/wp-content/plugins/custom-element/media/Katalog-uslug-social-media-en.webp">
                                    <div class="download-hover">
                                        <a style="color: white;" target="_blank" href="https://warsawexpo.eu/docs/Katalog-uslug-social-media-EN.pdf">
                                            <i class="fa fa-inbox2"></i>Download
                                        </a>
                                    </div>
                                    EN
                                ).'
                                </div>
                            </div>
                        </div>
                    <div class="pwe-promote-text-block">'.
                            self::languageChecker(
                                <<<PL
                                    <h3>Wypromuj się na [trade_fair_name]!</h3>
                                    <p>Drogi Wystawco!</p>
                                    <p>[trade_fair_desc] – to niepowtarzalna okazja do wypromowania Twojej firmy! Chcesz by Twoje stoisko odwiedziło jak najwięcej osób? Pomożemy Ci sprawić, że Twoi klienci dowiedzą się, że jesteś częścią [trade_fair_name]!</p>
                                    <p>Poniżej KROK po KROKU wyjaśniamy jak sprawić, by o Twojej obecności na Targach dowiedzieli się Twoi klienci!</p>
                                PL,
                                <<<EN
                                    <h3>Promote yourself at the [trade_fair_name_eng]!</h3>
                                    <p>Dear Exhibitor!</p>
                                    <p>[trade_fair_desc_eng] - is a unique opportunity to promote your company! You want your stand to visit how the most people? We will help you make your clients know that you are part of [trade_fair_name_eng].</p>
                                    <p>Below we explain STEP by STEP how to make your presence at the Fair known to your pweers!</p>
                                EN
                            )
                    .'</div>
                </div>

                <div class="pwe-content-promote-item pwe-align-left">'.
                    self::languageChecker(
                        <<<PL
                            <ol>
                                <li>Zamieść nasz baner w swojej stopce mailowej oraz w stopkach pracowników Twojej firmy</li>
                                <li>Zamieść w swoich kanałach Social Media oraz na www informację, że będziesz na Targach [trade_fair_name] i sukcesywnie o tym przypominaj!</li>
                                <li>Wyślij mailing do bazy swoich klientów, że będą mogli zobaczyć Twoją firmę na [trade_fair_name].</li>
                                <li>Poinformuj swoich klientów za pomocą swoich kanałów Social Media o tym, co na nich czeka na Twoim stoisku! (jakie brandy? jakie innowacyjne produkty i usługi? jakie atrakcje?)</li>
                                <li>Przygotuj ofertę specjalną na targi i poinformuj o niej swoich klientów za pomocą kanałów Social Media oraz mailingu.</li>
                                <li>Umieść na swojej stronie podlinkowany baner [trade_fair_name].</li>
                                <li class="link-text-underline">Podziel się wszystkim tym, co przygotowałeś na [trade_fair_name] z naszym zespołem! Wyślij nam listę atrakcji i ambasadorów obecnych na Twoim stoisku oraz poinformuj nas o premierach, promocjach i rabatach, które przygotowałeś na targi, a my zamieścimy to w naszych kanałach Social Media. (wszelkie materiały wysyłaj na adres mailowy: <a href="mailto:konsultantmarketingowy@warsawexpo.eu"><span style="display:inline-block;">konsultantmarketingowy</span><span style="display:inline-block;">@warsawexpo.eu</span></a>)</li>
                                <li>Jeśli potrzebujesz materiałów o naszych targach, poniżej znajduje się lista plików do pobrania.</li>
                            </ol>
                            <p>Gdybyś potrzebował więcej, napisz do nas, a my postaramy się pomóc! Tylko działając razem jesteśmy w stanie osiągnąć sukces.</p>
                        PL,
                        <<<EN
                            <ol>
                                <li>Place our banner in your e-mail footer and in the footers of your company's employees</li>
                                <li>Include in your Social Media channels and on the website information that you will be at the [trade_fair_name_eng] and keep reminding about it!</li>
                                <li>Send a mailing to your pweer base that they will be able to see your company on [trade_fair_name_eng].</li>
                                <li>Inform your pweers through your Social Media channels about what is waiting for them at your stand! (what brands? what innovative products and services? what attractions?)</li>
                                <li>Prepare a special offer for the fair and inform your pweers about it using Social Media channels and mailing.</li>
                                <li>Place the linked banner [trade_fair_name_eng] on your website.</li>
                                <li class="link-text-underline">Share everything you've prepared on [trade_fair_name_eng] with our team! Send us a list of attractions and ambassadors present at your stand and inform us about the premieres, promotions and discounts that you have prepared for the fair, and we will post it in our Social Media channels. (all materials should be sent to the following e-mail address: <a href="mailto:konsultantmarketingowy@warsawexpo.eu"><span style="display:inline-block;">konsultantmarketingowy</span><span style="display:inline-block;">@warsawexpo.eu</span></a>)</li>
                                <li>If you need materials about our fair, below is a list of files to download.</li>
                            </ol>
                            <p>If you need more, write to us and we will try to help! Only by working together are we able to achieve success.</p>
                        EN
                    )
                .'</div>
                <div class="pwe-flex pwe-content-promote-item pwe-border-element">';

                if ($show_banners != 'true') {
                    $promoteBaners = self::findAllImages('/doc/wypromuj', 4);
                    
                    foreach($promoteBaners as $baner){
                        switch(true){
                            case(strpos($baner, '800_pl') != false):
                                $baner800pl = $baner;
                                break;
                            case(strpos($baner, '800_en') != false):
                                $baner800en = $baner;
                                break;
                            case(strpos($baner, '1200_pl') != false):
                                $baner1200pl = $baner;
                                break;
                            case(strpos($baner, '1200_en') != false):
                                $baner1200en = $baner;
                                break;
                        }
                    }

                    $output .='
                        <div class="pwe-column pwe-content-promote-element">
                            <h3>'.
                                self::languageChecker(
                                    <<<PL
                                        Pobierz banery
                                    PL,
                                    <<<EN
                                        Download banners
                                    EN
                                )
                            .'</h3>
                            <p>800×800</p>
                            <span class="btn-container">
                                <a href="'.
                                self::languageChecker(
                                    <<<PL
                                        $baner800pl
                                    PL,
                                    <<<EN
                                        $baner800en
                                    EN
                                )
                                .'" class="pwe-link btn pwe-btn" target="_blank" rel="nofollow" title="800x800" >'.
                                    self::languageChecker(
                                        <<<PL
                                            Pobierz
                                        PL,
                                        <<<EN
                                            Download
                                        EN
                                    )
                                .'<i class="fa fa-inbox2"></i></a>
                            </span>
                            <p>1200x200</p>
                            <span class="btn-container">
                                <a href="'.
                                self::languageChecker(
                                    <<<PL
                                        $baner1200pl
                                    PL,
                                    <<<EN
                                        $baner1200en
                                    EN
                                )
                                .'" class="pwe-link btn pwe-btn" target="_blank" rel="nofollow" title="1200x200" >'.
                                    self::languageChecker(
                                        <<<PL
                                            Pobierz
                                        PL,
                                        <<<EN
                                            Download
                                        EN
                                    )
                                .'<i class="fa fa-inbox2"></i></a>
                            </span>
                        </div>';
                }
                
                $output .= '
                    <div class="pwe-column pwe-content-promote-element">
                        <h3>'.
                            self::languageChecker(
                                <<<PL
                                    Pobierz logo
                                PL,
                                <<<EN
                                    Download logo
                                EN
                            )
                        .'</h3>
                        ' . $logo_color . '
                        <span class="btn-container">
                            <a href="' . $logo_href . '" class="pwe-link btn pwe-btn" target="_blank" rel="nofollow" title="[trade_fair_name] logo" >'.
                                self::languageChecker(
                                    <<<PL
                                        Pobierz
                                    PL,
                                    <<<EN
                                        Download
                                    EN
                                )
                                .'<i class="fa fa-inbox2"></i>
                            </a>
                        </span>
                    </div>
                        <div class="pwe-column pwe-content-promote-element">
                            <h3>'.
                                self::languageChecker(
                                    <<<PL
                                        Pobierz logo
                                    PL,
                                    <<<EN
                                        Download logo
                                    EN
                                )
                            .'</h3>
                            <img src="/wp-content/plugins/PWElements/media/logo_pwe_black.webp" alt="PWE-logo"/>
                            <div>
                                <span class="btn-container">
                                    <a href="https://warsawexpo.eu/docs/Logo_PWE.zip" class="pwe-link btn pwe-btn" target="_blank" rel="nofollow" title="PWE-logo">'.
                                        self::languageChecker(
                                            <<<PL
                                                Pobierz
                                            PL,
                                            <<<EN
                                                Download
                                            EN
                                        )
                                        .'<i class="fa fa-inbox2"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="pwe-border-element style-accent-bg pwe-content-promote-item__help pwe-block-padding">
                        <h2>'.
                            self::languageChecker(
                                <<<PL
                                    Gdybyś potrzebował więcej napisz do nas, a my postaramy się pomóc! Tylko działając razem jesteśmy w stanie osiągnąć sukces.
                                PL,
                                <<<EN
                                    If you need more, write to us and we will try to help! Only by working together can we be successful.
                                EN
                            )                           
                        .'</h2>
                        <div class="text-centered link-text-underline">
                            <a class="h2 mobile-kons-email" href="mailto:konsultantmarketingowy@warsawexpo.eu"><span style="display:inline-block;">konsultantmarketingowy</span><span style="display:inline-block;">@warsawexpo.eu</span></a>
                        </div>
                    </div>
                </div>';

        return $output;
    }
}