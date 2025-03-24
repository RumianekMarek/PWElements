<?php 

$output .= '
<!-- Spersonalizowane Smyczki -->
<div class="pwe-store__service-card pwe-store__service pwe-store__sold-out">
    <a href="#" data-featured="smycze">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/premium/smycze-z-logotypem.webp" alt="Smycze z logotypem">
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
<div class="pwe-store__service-card pwe-store__service pwe-store__limit">
    <a href="#" data-featured="logotyp">
        <div class="pwe-store__service-image">
            <img src="/wp-content/plugins/PWElements/media/store/premium/logotyp-na-identyfikatorach.webp" alt="Logotyp na identyfikatorach">
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
            <img src="/wp-content/plugins/PWElements/media/store/premium/sponsor-planu-targowego.webp" alt="Sponsor Planu Targowego">
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
            <img src="/wp-content/plugins/PWElements/media/store/premium/partner-vip-room.webp" alt="Partner VIP Room">
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
            <img src="/wp-content/plugins/PWElements/media/store/premium/sponsor-resturacji.webp" alt="Sponsor Restauracji">
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
            <img src="/wp-content/plugins/PWElements/media/store/premium/sponsor-gali.webp" alt="Sponsor Gali">
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
            <img src="'. ( self::lang_pl() ? '/wp-content/plugins/PWElements/media/store/premium/bilet-na-gale.webp' : '/wp-content/plugins/PWElements/media/store/premium/bilet-na-gale-en.webp' ) .'" alt="Bilet na Wieczór Branżowy">
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
            <img src="'. ( self::lang_pl() ? '/wp-content/plugins/PWElements/media/store/premium/bilet-vip-gold.webp' : '/wp-content/plugins/PWElements/media/store/premium/bilet-vip-gold-en.webp' ) .'" alt="VIP GOLD">
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
            <img src="/wp-content/plugins/PWElements/media/store/premium/sponsor-wkladki.webp" alt="Wkładka Reklamowa">
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
            <img src="/wp-content/plugins/PWElements/media/store/premium/sekcja-w-mailingu.webp" alt="Mailing">
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
            <img src="/wp-content/plugins/PWElements/media/store/premium/lokowanie-sms.webp" alt="SMS Marketing">
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
</div>';

return $output;