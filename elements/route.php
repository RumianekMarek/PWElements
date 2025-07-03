<?php 

/**
 * Class PWElementRoute
 * Extends PWElements class and defines a pwe Visual Composer element for vouchers.
 */
class PWElementRoute extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    public static function output($atts, $content = '') {        
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';

        $output = '';
        
        $output .='
            <style>
                .pwelement_'. self::$rnd_id .' #dojazd :is(h4, h5, p){
                    ' . $text_color . '
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-title-wrapper h4 {
                    width: auto !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-transport-item-img {
                    display: flex;
                    align-items: center;
                    padding-right: 18px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-transport-item-img img {
                    width: 60px !important;
                    min-width: 60px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-image-bg {
                    aspect-ratio: 16/9;
                    background-position: center;
                    background-size: cover;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-image-bg h3 {
                    font-size: 22px !important;
                    max-width: 90%;
                    padding: 8px;
                    margin: 0;
                    color: white;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-area-wrapper {
                    padding-top: 36px;
                    display: flex;
                    gap: 36px;
                    flex-direction: column;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-area-block {
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    gap: 18px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-area-block img {
                    width: 80px;
                    padding: 0 18px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-area-item-text {
                    align-items: center;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-area-item-text h5 {
                    margin: 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-route-transport-block{
                    box-shadow: 9px 9px 0px -5px black;
                    border:2px solid;
                    padding:25px 25px !important;
                }
                
                @media (max-width:960px) {
                    .pwelement_'. self::$rnd_id .' #route {
                        padding: 36px 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-transport-wrapper, 
                    .pwelement_'. self::$rnd_id .' .pwe-route-area-wrapper {
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-half-width {
                        width: 100% !important;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-image-bg h3 {
                        font-size: 18px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-area-block {
                        padding: 36px 0;
                    }
                }
                @media (max-width:600px) {
                    .pwelement_'. self::$rnd_id .' .pwe-align-center {
                        font-size: 16px !important;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-transport-item {
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-transport-block h5{
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-transport-block img{
                        margin: 27px 0 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-transport-item-text {
                        text-align: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-transport-item-img,
                    .pwelement_'. self::$rnd_id .' .pwe-route-transport-item-text h5 {
                        padding: 0;
                        width: inherit !important;
                        justify-content: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-route-image-bg h3 {
                        font-size: 16px !important;
                    }
                }
            </style>

            <div id="dojazd" class="pwe-container-route">
                <div class="pwe-route-title-wrapper">
                    <h4 class="pwe-align-center">'.
                        self::languageChecker(
                            <<<PL
                                PTAK WARSAW EXPO  NAJLEPIEJ SKOMUNIKOWANE CENTRUM TARGOWE W POLSCE!
                            PL,
                            <<<EN
                                PTAK WARSAW EXPO  THE BESTCONNECTED TRADE FAIR CENTER IN POLAND!
                            EN
                        )
                    .'</h4>
                </div>
                <div class="pwe-route-transport-wrapper pwe-align-left single-top-padding pwe-full-gap">
                    <div class="pwe-route-map-block pwe-half-width">
                        <img class="pwe-full-width" src="/wp-content/plugins/PWElements/media/mapka-wawa.png">
                        <div class="pwe-route-area-wrapper pwe-align-left">
                            <div class="pwe-route-image-bg-block">
                                <div style="background-image: url(/wp-content/plugins/PWElements/media/ptak.jpg);" class="pwe-route-image-bg shadow-black">
                                    <h3>'.
                                        self::languageChecker(
                                            <<<PL
                                                Największy obiekt targowy w Polsce oraz Europie Środkowo-Wschodniej
                                            PL,
                                            <<<EN
                                                The largest fair facility in Poland and Central and Eastern Europe
                                            EN
                                        )
                                    .'</h3>
                                </div>
                            </div>
                            <div class="pwe-route-area-block pwe-route">
                                <div class="pwe-route-area-item pwe-flex">
                                    <div class="pwe-route-area-item-img">
                                        <img src="/wp-content/plugins/PWElements/media/entry.png">
                                    </div>
                                    <div class="pwe-route-area-item-text pwe-flex">
                                        <h5>'.
                                            self::languageChecker(
                                                <<<PL
                                                    143 000 m2 powierzchni wystawienniczej
                                                PL,
                                                <<<EN
                                                    143 000 m2 exhibition space
                                                EN
                                            )
                                        .'</h5>
                                    </div>
                                </div>

                                <div class="pwe-route-area-item pwe-flex">
                                    <div class="pwe-route-area-item-img">
                                        <img src="/wp-content/plugins/PWElements/media/leave.png">
                                    </div>
                                    <div class="pwe-route-area-item-text pwe-flex">
                                        <h5>'.
                                            self::languageChecker(
                                            <<<PL
                                                500 000 m2 powierzchni zewnętrznej
                                            PL,
                                            <<<EN
                                                500 000 m2 outer surface
                                            EN
                                            )
                                        .'</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="pwe-route-transport-block pwe-half-width pwe-route">
                        <div class="pwe-route-transport-item pwe-flex">
                            <div class="pwe-route-transport-item-img">
                                <img class="pwe-full-width" src="/wp-content/plugins/PWElements/media/samolot.png">
                            </div>
                            <div class="pwe-route-transport-item-text">'.
                                self::languageChecker(
                                    <<<PL
                                        <h4>SAMOLOTEM</h4>
                                        <p>Do Ptak Warsaw Expo z Międzynarodowego Portu Lotniczego im. Fryderyka Chopina dotrzeć można w niespełna 10 minut! Nasze Centrum jest również dogodnie położone względem <span>lotniska w Modlinie oraz Łodzi.</span></p>
                                    PL,
                                    <<<EN
                                        <h4>BY PLANE</h4>
                                        <p>To Ptak Warsaw Expo from the International Warsaw Chopin Airport in less than 10 minutes! Our Center is also conveniently located when travelling from the airports in Modlin and Lodz.</p>
                                    EN
                                )
                            .'</div>
                        </div>
                        <div class="pwe-route-transport-item pwe-flex">
                            <div class="pwe-route-transport-item-img">
                                <img class="pwe-full-width" src="/wp-content/plugins/PWElements/media/train.png">
                            </div>
                            <div class="pwe-route-transport-item-text">'.
                                self::languageChecker(
                                    <<<PL
                                        <h4>POCIĄGIEM</h4>
                                        <p>Warszawa posiada trzy stacje kolejowe dla pociągów dalekobieżnych: Dworzec Centralny (Warszawa Centralna), Dworzec Wschodni (Warszawa Wschodnia) oraz Dworzec Zachodni (Warszawa Zachodnia). <span>Z dworca</span> zachodniego do Ptak Warsaw Expo można dojechać samochodem już w 13 minut (wg Google).</p>
                                    PL,
                                    <<<EN
                                        <h4>BY TRAIN</h4>
                                        <p>Warsaw has three railway stations for long-distance trains: Central Railway Station (Central Warsaw), Eastern Railway Station (Eastern Warsaw) and Western Railway Station (Western Warsaw). Ptak Warsaw Expo can be reached by car from the western station in just 13 minutes (according to Google).</p>
                                    EN
                                )
                            .'</div>
                        </div>

                        <div class="pwe-route-transport-item pwe-flex">
                            <div class="pwe-route-transport-item-img">
                                <img class="pwe-full-width" src="/wp-content/plugins/PWElements/media/bus.png">
                            </div>
                            <div class="pwe-route-transport-item-text">'.
                                self::languageChecker(
                                    <<<PL
                                        <h4>AUTOBUSEM MIEJSKIM</h4>
                                        <p>Autobusy linii 703, 711 z zajezdni Krakowska P+R do przystanku „Paszków” lub autobus 733 do przystanku „Centrum Mody”. Uwaga! „Przystanek Paszków” <span>i „Centrum mody”</span> mieszczą się w II strefie biletowej. W bilety zaopatrzyć się można w większości kiosków, <span>w biletomatach</span> oraz autobusach.</p>
                                    PL,
                                    <<<EN
                                        <h4>BY CITY BUS</h4>
                                        <p>Buses 703, 711 from Krakowska P+R depot to the “Paszków” stop or bus 733 to the “Centrum Mody” stop. Please note that “Paszków” and “Centrum Mody” stops are located in the second ticket zone. Tickets can be purchased in most kiosks, ticket machines and buses.</p>
                                    EN
                                )
                            .'</div>
                        </div>

                        <div class="pwe-route-transport-item pwe-flex">
                            <div class="pwe-route-transport-item-img">
                                <img class="pwe-full-width" src="/wp-content/plugins/PWElements/media/sedan.png">
                            </div>
                            <div class="pwe-route-transport-item-text">'.
                                self::languageChecker(
                                    <<<PL
                                        <h4>SAMOCHODEM</h4>
                                        <p>Ptak Warsaw Expo znajduje się bezpośrednio przy trasie S8 w kierunku na Katowice. Zjazd Paszków. Dojazd z okolic lotniska Okęcie zajmie około 10 minut. <span>Z centrum</span> Warszawy – 15 minut. Z parkowaniem nie będzie problemu, nasze centrum dysponuje 15 000 miejsc parkingowych!</p>
                                    PL,
                                    <<<EN
                                        <h4>BY CAR</h4>
                                        <p>Ptak Warsaw Expo is located directly at the S8 route in the direction of Katowice, Paszków exit. It will take about 10 minutes to get here from the Warsaw Okęcie airport. From downtown Warsaw – 15 minutes. Parking is not a problem, our center has 15,000 parking spaces!</p>
                                    EN
                                )
                            .'</div>
                        </div>
                    </div>
                </div>
            </div>';

        return $output;
    }
}