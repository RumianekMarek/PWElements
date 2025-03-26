<?php 

$output .= '
<!-- Post promocyjny -->
<div class="pwe-store__service-card pwe-store__service">
    <a class="pwe-store__service-card-wrapper" href="#" data-featured="post-promocyjny">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/social-media/post-promocyjny.webp" alt="Post promocyjny">
        </div>
        <div class="pwe-store__service-content">
            '. ( self::lang_pl() ? '
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">POST PROMOCYJNY</h4>
            <ul>
                <li>Grafika promocyjna zostanie opublikowana wraz z oznaczeniem firmy na Facebooku oraz Instagramie danego projektu targowego, w ustalonym terminie przed targami.</li>
                <li>Możliwość przesłania 2-3 zdań od klienta, które mają się pojawić w publikacji.</li>
            </ul>
            ':'
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">PROMOTIONAL POST</h4>
            <ul>
                <li>Promotional graphics will be published along with the company`s tag on Facebook and Instagram of the given trade fair project, on a set date before the trade fair.</li>
                <li>Possibility to send 2-3 sentences from the client that are to appear in the publication.</li>
            </ul>
            ' ) .'
            
            <div class="pwe-store__service-footer">
                <div class="pwe-store__price">1500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
            </div>
        </div>
    </a>
    <div class="pwe-store__btn-container">
        <a href="#" class="pwe-store__more-button" data-featured="post-promocyjny">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
    </div>
</div>

<!-- Udostępnienie publikacji klienta -->
<div class="pwe-store__service-card pwe-store__service">
    <a class="pwe-store__service-card-wrapper" href="#" data-featured="udostepnienie-publikacji">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/social-media/udostepnienie-publikacji.webp" alt="Udostępnienie publikacji klienta">
        </div>
        <div class="pwe-store__service-content">
            '. ( self::lang_pl() ? '
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">UDOSTĘPNIENIE PUBLIKACJI KLIENTA</h4>
            <p>Udostępnienie treści opublikowanej na koncie klienta na oficjalnym profilu społecznościowym wybranego projektu targowego.</p>
            ':'
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">SHARING CUSTOMER PUBLICATIONS</h4>
            <p>Sharing content published on the client`s account on the official social media profile of the selected trade fair project.</p>
            ' ) .'
            <div class="pwe-store__service-footer">
                <div class="pwe-store__price">1000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
            </div>
        </div>
    </a>
    <div class="pwe-store__btn-container">
        <a href="#" class="pwe-store__more-button" data-featured="udostepnienie-publikacji">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
    </div>
</div>

<!-- 10 zdjęć stoiska -->
<div class="pwe-store__service-card pwe-store__service">
    <a class="pwe-store__service-card-wrapper" href="#" data-featured="zdjecia-stoiska">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/social-media/10x-zdjecia-stoiska.webp" alt="10 zdjęć stoiska">
        </div>
        <div class="pwe-store__service-content">
            '. ( self::lang_pl() ? '
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">10 ZDJĘĆ STOISKA</h4>
            <p>Profesjonalne zdjęcia Twojego stoiska z publikacją w mediach społecznościowych po targach!</p>
            ':'
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">10 STAND PHOTOS</h4>
            <p>Professional photos of your stand with publication on social media after the fair!</p>
            ' ) .'
            <div class="pwe-store__service-footer">
                <div class="pwe-store__price">1000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
            </div>
        </div>
    </a>
    <div class="pwe-store__btn-container">
        <a href="#" class="pwe-store__more-button" data-featured="zdjecia-stoiska">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
    </div>
</div>

<!-- Wideo promocyjne -->
<div class="pwe-store__service-card pwe-store__service">
    <a class="pwe-store__service-card-wrapper" href="#" data-featured="wideo-promocyjne">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/social-media/wideo-promocyjne.webp" alt="Wideo promocyjne">
        </div>
        <div class="pwe-store__service-content">
            '. ( self::lang_pl() ? '
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">WIDEO PROMOCYJNE</h4>
            <ul>
                <li>Wideo stoiska targowego z podkładem muzycznym do 30 sekund, które zostanie opublikowane wraz z oznaczeniem firmy na Facebooku oraz Instagramie danego projektu targowego podczas wydarzenia.</li>
                <li>Możliwość przesłania 2-3 zdań od klienta, które mają się pojawić w publikacji.</li>
                <li>Klient otrzymuje wideo po wydarzeniu targowym.</li>
            </ul>
            ':'
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">PROMOTIONAL VIDEO</h4>
            <ul>
                <li>A video of a trade fair stand with background music up to 30 seconds long, which will be published along with the company`s tag on Facebook and Instagram of the trade fair project during the event.</li>
                <li>Ability to send 2-3 sentences from the client that are to appear in the publication.</li>
                <li>The client receives the video after the trade fair event.</li>
            </ul>
            ' ) .'
            <div class="pwe-store__service-footer">
                <div class="pwe-store__price">2000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
            </div>
        </div>
    </a>
    <div class="pwe-store__btn-container">
        <a href="#" class="pwe-store__more-button" data-featured="wideo-promocyjne">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
    </div>
</div>

<!-- Relacja -->
<div class="pwe-store__service-card pwe-store__service">
    <a class="pwe-store__service-card-wrapper" href="#" data-featured="relacja">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/social-media/relacja.webp" alt="Relacja">
        </div>
        <div class="pwe-store__service-content">
            '. ( self::lang_pl() ? '
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">RELACJA</h4>
            <p>Relacja z oznaczeniem firmy do 10 sekund, która zostanie opublikowane na Facebooku oraz Instagramie danego projektu targowego podczas wydarzenia.</p>
            ':'
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">RELATION</h4>
            <p>A report with a company tag of up to 10 seconds, which will be published on Facebook and Instagram of a given trade fair project during the event.</p>
            ' ) .'
            <div class="pwe-store__service-footer">
                <div class="pwe-store__price">500,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
            </div>
        </div>
    </a>
    <div class="pwe-store__btn-container">
        <a href="#" class="pwe-store__more-button" data-featured="relacja">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
    </div>
</div>

<!-- Wywiad -->
<div class="pwe-store__service-card pwe-store__service">
    <a class="pwe-store__service-card-wrapper" href="#" data-featured="wywiad">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/social-media/wywiad.webp" alt="Wywiad">
        </div>
        <div class="pwe-store__service-content">
            '. ( self::lang_pl() ? '
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">WYWIAD</h4>
            <ul>
                <li>Wywiad z wybranym przez klienta przedstawicielem firmy na stoisku targowym, który zostanie opublikowany na Facebooku oraz Instagramie danego projektu targowego podczas wydarzenia. </li>
                <li>Czas trwania materiału będzie wynosił 1-2 minuty.</li>
                <li>Możliwość przesłania 2-3 zdań od klienta, które mają się pojawić w publikacji.</li>
                <li>Klient otrzymuje wywiad po wydarzeniu targowym</li>
            </ul>
            ':'
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">INTERVIEW</h4>
            <ul>
                <li>Interview with a company representative selected by the client at the trade fair stand, which will be published on Facebook and Instagram of the given trade fair project during the event. </li>
                <li>The duration of the material will be 1-2 minutes.</li>
                <li>Possibility to send 2-3 sentences from the client, which are to appear in the publication.</li>
                <li>The client receives the interview after the trade fair event.</li>
            </ul>
            ' ) .'
            <div class="pwe-store__service-footer">
                <div class="pwe-store__price">3000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
            </div>
        </div>
    </a>
    <div class="pwe-store__btn-container">
        <a href="#" class="pwe-store__more-button" data-featured="wywiad">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
    </div>
</div>

<!-- Współtworzony post na instagranie -->
<div class="pwe-store__service-card pwe-store__service">
    <a class="pwe-store__service-card-wrapper" href="#" data-featured="wspoltworzony-post">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/social-media/wspoltworzony-post.webp" alt="Współtworzony post na instagranie">
        </div>
        <div class="pwe-store__service-content">
            '. ( self::lang_pl() ? '
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">WSPÓŁTWORZONY POST NA INSTAGRAMIE</h4>
            <ul>
                <li>Za opracowanie postu odpowiada klient</li>
                <li>Post zostanie zaakceptowany na Instagramie danego projektu targowego</li>
            </ul>
            ':'
            <h4 class="pwe-store__service-name pwe-store__service-name-mailing">CO-CREATE INSTAGRAM POST</h4>
            <ul>
                <li>The client is responsible for creating the post</li>
                <li>The post will be accepted on the Instagram of the given trade fair project</li>
            </ul>
            ' ) .'
            <div class="pwe-store__service-footer">
                <div class="pwe-store__price">1000,00 zł '. ( self::lang_pl() ? 'netto' : 'net' ) .'</div>
            </div>
        </div>
    </a>
    <div class="pwe-store__btn-container">
        <a href="#" class="pwe-store__more-button" data-featured="wspoltworzony-post">'. ( self::lang_pl() ? 'WIĘCEJ' : 'MORE' ) .'</a>
        <a href="#" class="pwe-store__buy-button pwe-store__redirect-button" target="_blank">'. ( self::lang_pl() ? 'ZAREZERWUJ' : 'BOOK NOW' ) .'</a>
    </div>
</div>';

return $output;