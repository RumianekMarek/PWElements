<?php 

/**
 * Class PWElementMedals
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementMedals extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }    

    public static function output($atts) {     
            
        $output = '
        <style>
            .pwe-medals {
            }
            .pwe-medals__wrapper {
                display: flex;
                flex-direction: column;
                box-shadow: 2px 2px 12px #cccccc;
                border-radius: 36px;
                padding: 36px;
                text-align: center;
                gap: 18px;
            }
            .pwe-medals__heading h4 {
                margin: 0 auto;
            }
            .pwe-medals__items {
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 10px;
            }
            @media(max-width: 650px) {
                .pwe-medals__wrapper {
                    padding: 18px;
                }
                .pwe-medals__text p {
                    line-height: 1.3;
                }
                .pwe-medals__items {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                }
                .pwe-medals__item {
                    max-width: 100px;
                }
                .pwe-medals__item img {
                    width: 100%;
                }
            }
        </style>

        <div id="pweMedals"class="pwe-medals">
            <div class="pwe-medals__wrapper">
                <div class="pwe-medals__heading">
                    <h4>ZDOBĄDŹ PRESTIŻOWĄ NAGRODĘ NA PTAK WARSAW EXPO!</h4>
                </div>
                <div class="pwe-medals__text">
                    <p>Dołącz do grona najlepszych na <strong>Targach Ptak Warsaw Expo</strong> i pokaż swoją firmę w świetle zwycięzców! <strong>Wyróżniamy liderów</strong>, którzy napędzają przyszłość i inspirują innych, przyznając <strong>prestiżowe nagrody</strong> w takich kategoriach jak:</p></div>
                <div class="pwe-medals__items">
                    <div class="pwe-medals__item"><img src="/wp-content/plugins/PWElements/media/medals/nowe-technologie.webp"/></div>
                    <div class="pwe-medals__item"><img src="/wp-content/plugins/PWElements/media/medals/innowacje-roku.webp"/></div>
                    <div class="pwe-medals__item"><img src="/wp-content/plugins/PWElements/media/medals/produkt-roku.webp"/></div>
                    <div class="pwe-medals__item"><img src="/wp-content/plugins/PWElements/media/medals/odkrycie-roku.webp"/></div>
                    <div class="pwe-medals__item"><img src="/wp-content/plugins/PWElements/media/medals/prezes-roku.webp"/></div>
                </div>
                <div class="pwe-medals__heading">
                    <h4>POKAŻ SIĘ ŚWIATU JAKO LIDER NA PTAK WARSAW EXPO!</h4>
                </div>

            </div>
        </div>';

        return $output;
    }
}