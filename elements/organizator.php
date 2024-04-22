<?php
/**
* Class PWElementOrganizer
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementOrganizer extends PWElements {

    /**
     * Constructor method.
    * Calls parent constructor and adds an action for initializing the Visual Composer map.
    */
    public function __construct() {
        parent::__construct();
        require_once plugin_dir_path(__FILE__) . 'calendarApple.php';
        require_once plugin_dir_path(__FILE__) . 'calendarGoogle.php';
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important;';

        $border_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white');

        $output = '';

        $output .= '
            <style>
            .row-parent:has(.pwelement_' . self::$rnd_id . ' #organizator) {
                max-width: 100%;
                padding: 0 !important;
            }
            .custom-organizator-video {
                height:500px;
                position: relative;
                overflow: hidden;
            }
            .custom-organizator-video iframe {
                min-width: 180%; 
                height:120vh; 
                position: absolute;
                top:50%;
                left:50%;
                transform: translate(-50%, -50%);
            }
            .custom-organizator-text {
                position: relative;
                padding: 1px 36px 50px 36px !important;
            }
            .pwelement_' . self::$rnd_id . ' :is(.custom-organizator-text, .custom-inner-mobile-text) :is(h5, p) {
                ' . $text_color . '
            }
            .custom-inner-organizator {
                max-width:1200px;
                margin: auto;
            }
            .custom-organizator-header {
                margin:0;
            }
            .custom-inner-mobile-text {
                padding: 0 36px 36px 36px;
            }
            .pwelement_' . self::$rnd_id . ' .organizator-box-shadow-left {
                margin-left: -18px;
                margin-bottom: -20px;
                box-shadow: -3px -3px ' . $border_color .';
                width: 170px !important;
                height: 40px;
            }
            .pwelement_' . self::$rnd_id . ' .organizator-box-shadow-right {
                margin-right: -18px;
                margin-top: -20px;
                box-shadow: 3px 3px ' . $border_color .';
                width: 170px !important;
                height: 40px;
                float: right;
            }
            @media (max-width:959px){
                #organizator:has(.custom-inner-organizator) {
                    padding: 0 36px 36px 36px;
                }
                .custom-box-bottom-right-white {
                    margin: -9px -18px 24px 0;
                }
            }
            </style>

            <div id="organizator" class="custom-container-organizator style-accent-bg text-centered">';

            if (!preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT'])) {
                $output .= '
                <div class="custom-organizator-video">
                    <iframe title="YouTube video player" frameborder="0" marginwidth="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share; muted" 
                    data-src="https://www.youtube.com/embed/dZJblpIVrcQ?autoplay=1&mute=1&loop=1&playlist=dZJblpIVrcQ&controls=0&showinfo=0"></iframe>
                </div>
                <div class="custom-organizator-text">
                    <div class="custom-inner-organizator text-left">
                        <p class="organizator-box-shadow-left">&nbsp;</p>
                        <h5 class="custom-organizator-header">'.
                                self::languageChecker(
                                    <<<PL
                                        O organizatorze
                                    PL,
                                    <<<EN
                                        About the organizer
                                    EN
                                )
                        .'</h5>
                        <p>'.
                            self::languageChecker(
                                <<<PL
                                    Ptak Warsaw Expo to przede wszystkim gwarancja doświadczenia. Już od blisko dekady organizujemy ponad 70 imprez rocznie na 143 000 m2 powierzchni wystawienniczej 6 nowoczesnych hal oraz 500 000 m2 powierzchni zewnętrznej. To pozycjonuje nas jako lidera branży targowej, dysponującego najbardziej innowacyjnym zapleczem organizacyjnym.
                                    <br> To jednak nie wszystko. Zdobyte doświadczenie i wysoka jakość aranżowanych wydarzeń przełożyła się na zbudowanie silnej sieci kontaktów biznesowych. Ta gwarantuje uczestnikom poszczególnych eventów dostęp do nowoczesnych rozwiązań - zarówno znanych na polskim rynku, jak i podbijających branże na polu międzynarodowym. To sprawia, że imprezy Ptak Warsaw Expo otwierają odwiedzających na nowe możliwości biznesowe. Dowodem zdobytego zaufania są rekordowe liczby - 1 000 000 odwiedzających i 10 000 wystawców.
                                    <br> Największą siłą Ptak Warsaw Expo jest jednak nasz zespół. To doświadczona grupa pełnych pasji ludzi, która za cel stawia sobie wyjście naprzeciw oczekiwaniom odwiedzających i wystawców. Elastyczne podejście, umiejętność znalezienia odpowiedzi na zmieniające się okoliczności i otwartość na potrzeby uczestników wydarzeń - te cechy sprawiają, że nasze eventy docenia się ze względu na profesjonalną obsługę.
                                    <br> Te wszystkie czynniki składają się na to, że Ptak Warsaw Expo stało się europejską stolicą targów, organizującą niezapomniane imprezy branżowe i komercyjne. Zachęcamy do kontaktu już dziś, aby dowiedzieć się jak konkretnie możemy pomóc osiągnąć twoje cele i sprawić, że firma otworzy się na nowe możliwości biznesowe.
                                PL,
                                <<<EN
                                    Ptak Warsaw Expo is first and foremost a guarantee of experience. For nearly a decade now, we have been organizing more than 70 events a year on 143,000 sqm of exhibition space of 6 modern halls and 500,000 sqm of outdoor space. This positions us as a leader in the trade fair industry with the most innovative organizational facilities.
                                    <br> However, that's not all. The experience we have gained and the high quality of the events we arrange have translated into building a strong network of business contacts. This guarantees the participants of individual events access to modern solutions - both those known on the Polish market and those conquering the industry on the international field. This makes Ptak Warsaw Expo events open visitors to new business opportunities. Proof of the trust gained is the record numbers - 1,000,000 visitors and 10,000 exhibitors.
                                    <br> However, the greatest strength of Ptak Warsaw Expo is our team. It is an experienced group of passionate people who aim to meet the expectations of visitors and exhibitors. Flexible approach, ability to find answers to changing circumstances and openness to the needs of event participants - these qualities make our events appreciated for their professional service.
                                    <br> All these factors contribute to the fact that Ptak Warsaw Expo has become the European capital of trade fairs, organizing unforgettable industry and commercial events. We encourage you to contact us today to find out how specifically we can help you achieve your goals and make your company open to new business opportunities.
                                EN
                            )
                        .'</p>
                        <p class="organizator-box-shadow-right">&nbsp;</p>
                    </div>
                </div>
            </div>';

            } else {
            $output .= '<div class="custom-inner-organizator-mobile">
                <img src="/wp-content/plugins/custom-element/media/ptak.jpg"/>
                <div class="custom-inner-mobile-text text-left">
                    <p class="organizator-box-shadow-left">&nbsp;</p>
                    <h5 class="custom-organizator-header">'.
                        self::languageChecker(
                            <<<PL
                                O organizatorze
                            PL,
                            <<<EN
                                About the organizer
                            EN
                        )
                    .'</h5>
                    <p>'.
                        self::languageChecker(
                            <<<PL
                                Ptak Warsaw Expo to największe centrum targowokongresowe w Polsce i Europie Środkowo-Wschodniej, które zlokalizowane jest na przedmieściach Warszawy. Posiada 143 000 m2 powierzchni wystawienniczej w 6 nowoczesnych pawilonach oraz 500 000 m2 powierzchni zewnętrznej. To miejsce stworzone do organizacji imprez targowych.
                            PL,
                            <<<EN
                                Ptak Warsaw Expo is the largest trade fair and congress centre in Poland and Central and Eastern Europe, located on the outskirts of Warsaw. It has 143,000 m2 of exhibition space in 6 modern pavilions and 500,000 m2 of outdoor space. It is a venue created for trade fairs.
                            EN
                        )
                    .'</p>
                    <p class="organizator-box-shadow-right">&nbsp;</p>
                </div>
            </div>';
            }

        return $output;
    }
}
