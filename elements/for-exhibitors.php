<?php
/**
* Class PWElementForExhibitors
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementForExhibitors extends PWElements {

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
        for($i=0; $i<6; $i++){
            $element_output[] = 
                array(
                    'type' => 'textarea',
                    'group' => 'PWE Element',
                    'heading' => __('Exhibitors text' . ($i+1), 'pwelement'),
                    'param_name' => 'exhibitor_text' . ($i+1),
                    'param_holder_class' => 'backend-textarea',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'pwe_element',
                        'value' => 'PWElementForExhibitors',
                    ),
                );
        }
        return $element_output;
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts, $content = '') {

        $all_images = self::findAllImages('/doc/galeria/zdjecia_wys_odw', 6);
        
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';
        // $img_shadow = 'box-shadow: 9px 9px 0px -6px ' . self::findColor(self::$main2_color,  self::$accent_color, 'black'). ' !important;';

        $output = '';
        
        $output .= '
            <style>
                .pwelement_' . self::$rnd_id . ' #forforExhibitors :is(h4, p){
                    ' . $text_color . '
                }

                .pwelement_'. self::$rnd_id .' .pwe-container-forexhibitors {
                    margin: 0 auto;
                }
                .pwelement_'. self::$rnd_id .' .pwe-content-forexhibitors-item{
                    width: 100%;
                    display:flex;
                    justify-content: center;
                    gap: 36px;
                    padding-bottom: 36px;
                }
                
                .pwelement_'. self::$rnd_id .' .pwe-forexhibitors-image-block, 
                .pwelement_'. self::$rnd_id .' .pwe-forexhibitors-text-block{
                    width: 50%;
                }
                .pwelement_'. self::$rnd_id .' .pwe-forexhibitors-image-block img {
                    width: 100%;
                    aspect-ratio: 16/9;
                    object-fit: cover;
                    box-shadow: 9px 9px 0px -6px [trade_fair_main2];
                }

                @media (max-width:768px) {
                    .pwelement_'. self::$rnd_id .' .pwe-content-forexhibitors-item{
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .column-reverse {
                        flex-direction: column-reverse !important;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-forexhibitors-image-block,
                    .pwelement_'. self::$rnd_id .' .pwe-forexhibitors-text-block {
                        width: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-forexhibitors-text {
                        padding: 18px 0;
                    }  
                }

            </style>

            <div id="for-exhibitors" class="pwe-container-forexhibitors">

                <div class="pwe-content-forexhibitors-item column-reverse pwe-align-left">
                    <div class="pwe-forexhibitors-text-block">
                        <div class="pwe-visitors-benefits-heading main-heading-text">'.
                            self::languageChecker(
                                <<<PL
                                    <h4>BĘDZIESZ CZĘŚCIĄ NAJSZYBCIEJ ROZWIJAJĄCYCH SIĘ TARGÓW</h4>
                                PL,
                                <<<EN
                                    <h4>YOU WILL BE PART OF THE FASTEST GROWING TRADE SHOW</h4>
                                EN
                            )
                        .'</div>
                        <div class="pwe-forexhibitors-text">
                            <p>';
                                if(!isset($atts['exhibitor_text1']) || $atts['exhibitor_text1'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            Targi w PTAK WARSAW EXPO to innowacyjne wydarzenia, w których udział biorą wystawcy z Polski i z zagranicy. Targi wyróżnia dostępność ogromnej, największej w Polsce powierzchni wystawienniczej, dającej wystawcom najlepsze, bo wręcz nieograniczone możliwości prezentacji swojej oferty.
                                        PL,
                                        <<<EN
                                            The fair at PTAK WARSAW EXPO is an innovative event featuring exhibitors from Poland and abroad. The fair is distinguished by the availability of a huge, the largest exhibition area in Poland, giving exhibitors the best, because almost unlimited opportunities to present their offer.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text1'];
                                }
                            $output .= '</p>
                        </div>
                    </div>
                    <div class="pwe-forexhibitors-image-block uncode-single-media-wrapper">      
                        <img src="' . $all_images[0] . '" alt="forexhibitors image 1">
                    </div>
                </div>
        
                <div class="pwe-content-forexhibitors-item pwe-align-left">
                    <div class="pwe-forexhibitors-image-block uncode-single-media-wrapper">              
                            <img src="' . $all_images[1] . '" alt="forexhibitors image 2">
                    </div>
                    <div class="pwe-forexhibitors-text-block">
                        <div class="pwe-visitors-benefits-heading main-heading-text">'.
                        self::languageChecker(
                            <<<PL
                                <h4>ZAPREZENTUJESZ SWOJE PRODUKTY I USŁUGI TYSIĄCOM KONSUMENTÓW</h4>
                            PL,
                            <<<EN
                                <h4>YOU WILL PRESENT YOUR PRODUCTS AND SERVICES TO THOUSANDS OF CONSUMERS</h4>
                            EN
                        )
                        .'</div>
                        <div class="pwe-forexhibitors-text">
                            <p>';
                                if(!isset($atts['exhibitor_text2']) || $atts['exhibitor_text2'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            To tysiące Twoich potencjalnych klientów! Biorąc udział w targach, w charakterze wystawcy, masz aż trzy targowe dni na pokazanie im swoich produktów i usług. A to nie wszystko. Dzięki szerokiej kampanii promocyjnej oraz dużemu zainteresowaniu mediów Twój brand dotrze także do setek tysięcy ludzi w Polsce i za granicą.
                                        PL,
                                        <<<EN
                                            That’s thousands of your potential customers! By participating in the fair, as an exhibitor, you have up to three fair days to show them your products and services. And that’s not all. Thanks to an extensive promotional campaign and a lot of media attention, your brand will also reach hundreds of thousands of people in Poland and abroad.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text2'];
                                }
                            $output .= '</p>
                        </div>
                    </div>
                </div>

                <!-- for-forexhibitors-item -->
                <div class="pwe-content-forexhibitors-item column-reverse pwe-align-left">
                    <div class="pwe-forexhibitors-text-block">
                        <div class="pwe-visitors-benefits-heading main-heading-text">'.
                        self::languageChecker(
                            <<<PL
                                <h4>ZDOBĘDZIESZ CENNĄ WIEDZĘ I POZNASZ NOWOŚCI RYNKU</h4>
                            PL,
                            <<<EN
                                <h4>YOU WILL GAIN VALUABLE KNOWLEDGE AND LEARN ABOUT THE NOVELTIES OF THE MARKET</h4>
                            EN
                        )
                        .'</div>
                        <div class="pwe-forexhibitors-text">
                            <p>';
                                if(!isset($atts['exhibitor_text3']) || $atts['exhibitor_text3'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            W biznesie nie możesz pozwolić sobie na stanie w miejscu. Podczas szkoleń, seminariów i konferencji branżowych zdobędziesz cenną wiedzę, którą będziesz mógł wykorzystać w praktyce, a odwiedzając nasze targi odkryjesz najnowsze rozwiązania sprzętowe i produktowe.
                                        PL,
                                        <<<EN
                                            In business, you can't afford to stand still. During training, seminars and industry conferences, you'll gain valuable knowledge that you can put into practice, and by visiting our trade shows you'll discover the latest equipment and product solutions.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text3'];
                                }
                            $output .= '</p>
                        </div>
                    </div>
                    <div class="pwe-forexhibitors-image-block uncode-single-media-wrapper">              
                            <img src="' . $all_images[2] . '" alt="forexhibitors image 3">
                    </div>
                </div>

                <!-- for-forexhibitors-item -->
                <div class="pwe-content-forexhibitors-item pwe-align-left">
                    <div class="pwe-forexhibitors-image-block uncode-single-media-wrapper">              
                            <img src="' . $all_images[3] . '" alt="forexhibitors image 4">
                    </div>
                    <div class="pwe-forexhibitors-text-block">
                        <div class="pwe-visitors-benefits-heading main-heading-text">'.
                        self::languageChecker(
                            <<<PL
                                <h4>NAWIĄŻESZ CENNE KONTAKTY BIZNESOWE</h4>
                            PL,
                            <<<EN
                                <h4>MAKE VALUABLE BUSINESS CONTACTS</h4>
                            EN
                        )
                        .'</div>
                        <div class="pwe-forexhibitors-text">
                            <p>';
                                if(!isset($atts['exhibitor_text4']) || $atts['exhibitor_text4'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            Podczas targów przeprowadzisz rozmowy i zbudujesz cenne relacje biznesowe, które zaowocują nowymi kontraktami. Targi to jedyna taka okazja by nie tylko zbudować bazę nowych klientów, ale także by usłyszeć o ich potrzebach, co pozwoli na jeszcze lepsze dopasowanie oferty do oczekiwań odbiorców, co w efekcie wpłynie na zwiększenie zysków firmy.
                                        PL,
                                        <<<EN
                                            During the fair you will hold discussions and build valuable business relationships that will result in new contracts. Trade fairs are a one-of-a-kind opportunity not only to build a base of new customers, but also to hear about their needs, which will allow you to tailor your offer even better to your customers' expectations, which will ultimately increase your company's profits.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text4'];
                                }
                            $output .= '</p>
                        </div>
                    </div>
                </div>

                <!-- for-forexhibitors-item -->
                <div class="pwe-content-forexhibitors-item column-reverse pwe-align-left">
                    <div class="pwe-forexhibitors-text-block">
                        <div class="pwe-visitors-benefits-heading main-heading-text">'.
                        self::languageChecker(
                            <<<PL
                                <h4>NAJWIĘKSZY OŚRODEK TARGOWY W POLSCE</h4>
                            PL,
                            <<<EN
                                <h4>THE LARGEST TRADE FAIR CENTER IN POLAND</h4>
                            EN
                        )
                        .'</div>
                        <div class="pwe-forexhibitors-text">
                            <p>';
                                if(!isset($atts['exhibitor_text5']) || $atts['exhibitor_text5'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            Ptak Warsaw Expo to największy i najnowocześniejszy kompleks targowy w Polsce, dedykowany wydarzeniom biznesowym, komercyjnym i rozrywkowym. Ideą jego powstania była organizacja targów, kongresów, szkoleń, imprez masowych i innych wydarzeń w oparciu o innowacyjny system wystawienniczy. Doskonała lokalizacja Ptak Warsaw Expo, usytuowanie obiektów 10 minut od największego w kraju portu lotniczego Lotnisko Chopina i 15 minut od ścisłego centrum Warszawy, sprawia, że PWE wypracowało sobie miano europejskiej stolicy biznesu.
                                        PL,
                                        <<<EN
                                            Ptak Warsaw Expo is the largest and most modern trade fair complex in Poland, dedicated to business, commercial and entertainment events. The idea behind its creation was to organize trade fairs, congresses, training courses, mass events and other events based on an innovative exhibition system. The excellent location of Ptak Warsaw Expo, situating the facilities 10 minutes from the country's largest airport, Chopin Airport, and 15 minutes from the very center of Warsaw, makes PWE earn its name as the European capital of business.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text5'];
                                }
                            $output .= '</p>
                        </div>
                    </div>
                    <div class="pwe-forexhibitors-image-block uncode-single-media-wrapper">              
                            <img src="' . $all_images[4] . '" alt="forexhibitors image 5">
                    </div>
                </div>

                <!-- for-forexhibitors-item -->
                <div class="pwe-content-forexhibitors-item pwe-align-left">
                    <div class="pwe-forexhibitors-image-block uncode-single-media-wrapper">              
                            <img src="' . $all_images[5] . '" alt="forexhibitors image 6">
                    </div>
                    <div class="pwe-forexhibitors-text-block">
                        <div class="pwe-visitors-benefits-heading main-heading-text">'.
                        self::languageChecker(
                            <<<PL
                                <h4>O ORGANIZATORZE</h4>
                            PL,
                            <<<EN
                                <h4>ABOUT THE ORGANISER</h4>
                            EN
                        )
                        .'</div>
                        <div class="pwe-forexhibitors-text">
                            <p>';
                                if(!isset($atts['exhibitor_text6']) || $atts['exhibitor_text6'] == ''){
                                    $output .= self::languageChecker(
                                        <<<PL
                                            Nasza silna sieć kontaktów branżowych pozwala nam przyciągać na targi wystawców i sponsorów, zapewniając Państwu dostęp do najnowszych i najbardziej innowacyjnych produktów i usług w swojej branży. Zawsze szukamy nowych i ekscytujących sposobów na zwiększenie wrażeń z targów, zapewniając, że są one świeże i ekscytujące dla uczestników.
                                            Nasz zespół jest elastyczny, potrafi dostosować się do zmieniających się okoliczności i nieprzewidzianych wyzwań, które mogą pojawić się podczas imprezy. Szybko podejmujemy decyzje i podejmujemy działania, aby targi przebiegły sprawnie i wszyscy mieli pozytywne doświadczenia.
                                        PL,
                                        <<<EN
                                            Our strong network of industry contacts allows us to attract forexhibitors and sponsors to the show, providing you with access to the latest and most innovative products and services in your industry. We are always looking for new and exciting ways to enhance the trade show experience, ensuring that it is fresh and exciting for attendees.
                                            Our team is flexible, able to adapt to changing circumstances and unforeseen challenges that may arise during an event. We are quick to make decisions and take action so that the trade show runs smoothly and everyone has a positive experience.
                                        EN
                                    );
                                } else {
                                    $output .= $atts['exhibitor_text6'];
                                }
                            $output .= '</p>
                        </div>
                    </div>
                </div>
            </div>';
        return $output;                
    }
}
