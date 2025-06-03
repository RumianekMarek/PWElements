<?php  

$svg_icon_growth = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m136-240-56-56 296-298 160 160 208-206H640v-80h240v240h-80v-104L536-320 376-480 136-240Z"/></svg>';

$svg_icon_arrow_right = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M647-440H160v-80h487L423-744l57-56 320 320-320 320-57-56 224-224Z"/></svg>';

$svg_icon_exhibitors = '<svg class="pwe-map__big-icon pwe-map__icon-visitor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="var(--accent-color)"><path d="M360-80v-529q-91-24-145.5-100.5T160-880h80q0 83 53.5 141.5T430-680h100q30 0 56 11t47 32l181 181-56 56-158-158v478h-80v-240h-80v240h-80Zm120-640q-33 0-56.5-23.5T400-800q0-33 23.5-56.5T480-880q33 0 56.5 23.5T560-800q0 33-23.5 56.5T480-720Z"></path></svg>';

$svg_icon_visitors = '<svg class="pwe-map__big-icon pwe-map__icon-exhibitor" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="var(--accent-color)"><path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z"></path></svg>';

$svg_icon_area = '<svg class="pwe-map__big-icon pwe-map__icon-area" viewBox="4 6 16 12" xmlns="http://www.w3.org/2000/svg">
<path d="M11 19.475L6 16.6C5.68333 16.4167 5.4375 16.175 5.2625 15.875C5.0875 15.575 5 15.2417 5 14.875V9.125C5 8.75833 5.0875 8.425 5.2625 8.125C5.4375 7.825 5.68333 7.58333 6 7.4L11 4.525C11.3167 4.34167 11.65 4.25 12 4.25C12.35 4.25 12.6833 4.34167 13 4.525L18 7.4C18.3167 7.58333 18.5625 7.825 18.7375 8.125C18.9125 8.425 19 8.75833 19 9.125V14.875C19 15.2417 18.9125 15.575 18.7375 15.875C18.5625 16.175 18.3167 16.4167 18 16.6L13 19.475C12.6833 19.6583 12.35 19.75 12 19.75C11.65 19.75 11.3167 19.6583 11 19.475ZM11 17.175V12.575L7 10.25V14.875L11 17.175ZM13 17.175L17 14.875V10.25L13 12.575V17.175ZM12 10.85L15.95 8.525L12 6.25L8.05 8.525L12 10.85Z" fill="var(--accent-color)"></path>
</svg>';

$output .= '
<div id="pweMap" class="pwe-map">
    <div class="pwe-map__wrapper">

        <div class="pwe-map__stats-section">            
            <div class="pwe-map__stats-number-container">

              <div class="pwe-map__stats-number-card">
                <div class="pwe-map__title-section">
                    <h2 class="pwe-map__title">'. $map_custom_title .'</h2>
                    <strong><p class="pwe-map__edition">' . $map_custom_current_edition . '</p></strong>
                    <p class="pwe-map__year">' . $map_year . '</p> 
                    '. self::languageChecker(
                        '<a href="/rejestracja/" class="pwe-map__button-link pwe-button-link">Zarejestruj się ' . $svg_icon_arrow_right . '</a>', 
                        '<a href="/en/registration/" class="pwe-map__button-link pwe-button-link">Registration ' . $svg_icon_arrow_right . '</a>') .'
                </div>
                <div class="pwe-map__stats-number-box">
                    <h2><span class="countup" data-count="'. $map_number_exhibitors .'">0</span></h2>
                    <div class="pwe-map__stats-number-box-text">
                        <p>'. self::languageChecker('wystawców', 'exhibitors') .'</p>
                    </div>
                    <div class="pwe-map__stats-number-increase">
                        <p>' . $map_number_exhibitors_increase . '%</p>
                        ' . $svg_icon_growth . '
                    </div>
                    ' . $svg_icon_exhibitors . '
                </div>
              </div>

              <div class="pwe-map__stats-number-card">
                <div class="pwe-map__stats-number-box">
                    <h2><span class="countup" data-count="'. $map_number_visitors .'">0</span></h2>
                    <div class="pwe-map__stats-number-box-text">
                        <p>'. self::languageChecker('odwiedzających', 'visitors') .'</p>
                    </div>
                    <div class="pwe-map__stats-number-increase">
                        <p>' . $map_number_visitors_increase . '%</p>
                        ' . $svg_icon_growth . '
                    </div>
                    <hr class="pwe-map__divider">
                    <h2><span class="countup" data-count="'. $map_number_abroad_visitors .'">0</span></h2>
                    <div class="pwe-map__stats-number-box-text">
                        <p>'. self::languageChecker('w tym z zagranicy', 'of which from abroad') .'</p>
                    </div>
                    ' . $svg_icon_visitors . '
                </div>
              </div>
                
              <div class="pwe-map__stats-number-card">
                <div class="pwe-map__logo-section">
                    '. self::languageChecker(
                        '<img src="/doc/logo-x-pl.webp" alt="Logo targów">', 
                        '<img src="/doc/logo-x-en.webp" alt="Fair logo">') .'
                </div>
                <div class="pwe-map__stats-number-box">
                    <h2><span class="countup" data-count="'. $map_exhibition_space .'">0</span> m<sup>2</sup></h2>
                    <div class="pwe-map__stats-number-box-text">
                        <p>'. self::languageChecker('powierzchni wystawienniczej', 'exhibition space') .'</p>
                    </div>
                    ' . $svg_icon_area . '
                </div>
              </div>
            </div>
        </div>
    </div>
</div>';