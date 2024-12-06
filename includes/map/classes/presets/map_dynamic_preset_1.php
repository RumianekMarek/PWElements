<?php  

if ($map_dynamic_3d == true) {

    $output .= '
    <div id="pweMap" class="pwe-map">
        <div class="pwe-map__wrapper">
            <div class="pwe-map__staticts">
                <h2 class="pwe-map__title text-accent-color">'. $map_custom_title .'</h2>
                <div class="pwe-map__rounded-stat">
                    <div class="pwe-map__rounded-element text-accent-color">
                        <p style="font-weight: 800; font-size: 21px;">
                            <span class="countup" data-count="'. $map_number_visitors .'">0</span>
                        </p>
                        <p style="font-size:12px">'. self::languageChecker('odwiedzających', 'visitors') .'</p>
                    </div>
                    <div class="pwe-map__rounded-element pwe-map__rounded-element-country">
                        <p style="font-weight: 800; font-size: 27px;">
                            <span class="countup" data-count="'. $map_number_countries .'">0</span>
                        </p>
                        <p style="font-size:12px">'. self::languageChecker('krajów', 'countries') .'</p>
                    </div>
                </div>
                <div class="pwe-map__stats-container">
                    <div class="pwe-map__stats-element">
                        <p class="text-accent-color pwe-map__stats-element-title">'.
                            self::languageChecker('Polska -', 'Poland -') .' 
                            <span class="countup" data-count="'. floor($map_number_visitors / 100 * $map_percent_polish_visitors) .'">0</span>
                        </p>
                        <p class="pwe-map__stats-element-desc"><span class="countup" data-count="'. $map_percent_polish_visitors .'">0</span> %</p>
                    </div>
                    <div class="pwe-map__stats-element">
                        <p class="text-accent-color pwe-map__stats-element-title">'.
                            self::languageChecker('Zagranica -', 'Abroad -').' 
                            <span class="countup" data-count="'. ($map_number_visitors - floor($map_number_visitors / 100 * $map_percent_polish_visitors)) .'">0</span>
                        </p>
                        <p class="pwe-map__stats-element-desc">
                        <span class="countup" data-count="'. (100 - $map_percent_polish_visitors) .'">0</span> %</p>
                    </div>
                    <div class="pwe-map__stats-element">
                        <p class="text-accent-color pwe-map__stats-element-title">
                            <span class="countup" data-count="'. $map_exhibition_space .'">0</span> m<sup>2</sup>
                        </p>
                        <p class="pwe-map__stats-element-desc">'. self::languageChecker('powierzchni<br>wystawienniczej', 'exhibition<br>space') .'</p>
                    </div>
                    <div class="pwe-map__stats-element">
                        <p class="text-accent-color pwe-map__stats-element-title">
                            <span class="countup" data-count="'. $map_number_exhibitors .'">0</span>
                        </p>
                        <p class="pwe-map__stats-element-desc">'. self::languageChecker('wystawców', 'exhibitors') .'</p>
                    </div>
                </div>
            </div>

            <div id="container-3d" class="pwe-map__container-3d"></div>

            <div class="pwe-map__logotypes">
                <div class="pwe-map__logo-container">'.
                    self::languageChecker('<img src="/doc/logo-color.webp"/>', '<img src="/doc/logo-color-en.webp"/>');
                    if (is_array($map_more_logotypes)){
                        foreach($map_more_logotypes as $single_logo){
                            $output .= '<img src="' . $single_logo . '"/>';
                        }
                        $output .= '<p class="pwe-map__logotypes-data" style="text-align: right;">'. $map_event_date .'</p>';
                    } else {
                        $output .= '<p class="pwe-map__logotypes-data" style="text-align: center;">'. $map_event_date .'</p>';
                    }
                    $output .= '
                </div>

            </div>
        </div>
    </div>';
} else {
    $output .= '
    <div id="mapa" class="pwe-container-mapa">
        <div class="pwe-mapa-staticts">
            <h2 class="text-accent-color">'. $map_custom_title .'</h2>
            <div class="pwe-mapa-rounded-stat">
                <div class="pwe-mapa-rounded-element text-accent-color">
                    <p style="font-weight: 800; font-size: 21px;">'. $map_number_visitors .'</p>
                    <p style="font-size:12px">'. self::languageChecker('odwiedzających', 'visitors') .'</p>
                </div>
                <div class="pwe-mapa-rounded-element pwe-mapa-rounded-element-country">
                    <p style="font-weight: 800; font-size: 27px;">'. $map_number_countries .'</p>
                    <p style="font-size:12px">'. self::languageChecker('krajów', 'countries') .'</p>
                </div>
            </div>
            <div class="pwe-mapa-stats-container">
                <div class="pwe-mapa-stats-element">
                    <p class="text-accent-color pwe-mapa-stats-element-title">'.
                        self::languageChecker('Polska -', 'Poland -') .' '. floor($map_number_visitors / 100 * $map_percent_polish_visitors) .'
                    </p>
                    <p class="pwe-mapa-stats-element-desc">'. $map_percent_polish_visitors .' %</p>
                </div>
                <div class="pwe-mapa-stats-element">
                    <p class="text-accent-color pwe-mapa-stats-element-title">'.
                        self::languageChecker('Zagranica -', 'Abroad -').' '. ($map_number_visitors - floor($map_number_visitors / 100 * $map_percent_polish_visitors)) .'
                    </p>
                    <p class="pwe-mapa-stats-element-desc">'. (100 - $map_percent_polish_visitors) .' %</p>
                </div>
                <div class="mobile-estymacje-image"></div>
                <div class="pwe-mapa-stats-element">
                    <p class="text-accent-color pwe-mapa-stats-element-title">'. $map_exhibition_space .' m<sup>2</sup></p>
                    <p class="pwe-mapa-stats-element-desc">'. self::languageChecker('powierzchni<br>wystawienniczej', 'exhibition<br>space') .'</p>
                </div>
                <div class="pwe-mapa-stats-element">
                    <p class="text-accent-color pwe-mapa-stats-element-title">'. $map_number_exhibitors .'</p>
                    <p class="pwe-mapa-stats-element-desc">'. self::languageChecker('wystawców', 'exhibitors') .'</p>
                </div>
            </div>
        </div>';
        
        $output .= '
        <div class="pwe-mapa-right">
            <div class="pwe-mapa-logo-container">'.
                self::languageChecker('<img src="/doc/logo-color.webp"/>', '<img src="/doc/logo-color-en.webp"/>');
                if (is_array($map_more_logotypes)){
                    foreach($map_more_logotypes as $single_logo){
                        $output .= '<img src="' . $single_logo . '"/>';
                    }
                    $output .= '<p class="pwe-mapa-right-data" style="text-align: right;">'. $map_event_date .'</p>';
                } else {
                    $output .= '<p class="pwe-mapa-right-data" style="text-align: center;">'. $map_event_date .'</p>';
                }
                $output .= '
            </div>
            <div class="pwe-mapa-rounded-element pwe-mapa-rounded-element-country-right">
                <p style="font-weight: 800; font-size: 24px;">'. $map_number_countries .'</p>
                <p style="font-size:12px">'. self::languageChecker('krajów', 'countries') .'</p>
            </div>
        </div>
    </div>';
}