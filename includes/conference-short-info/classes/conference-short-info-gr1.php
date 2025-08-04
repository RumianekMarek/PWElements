<?php

class PWEConferenceShortInfoGr1 {

    public static function initElements() {
        return [];
    }

    public static function output($atts, $all_conferences, $rnd_class) {
        $output = '';

        // Styl
        $output .= '<style>
            .pwe-conf-short-info-gr1__wrapper {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: stretch;
            }

            .pwe-conf-short-info-gr1__wrapper:before {
                content: "";
                width: 100%;
                height: 20px;
                position: absolute;
                bottom: 0;
                left: 0;
                background: #EFEFEF;
                z-index: 1;
            }

            .pwe-conf-short-info-gr1__left {
                flex: 1 1 50%;
                z-index: 2;
            }
                
            .pwe-conf-short-info-gr1__left img {
                height: 100%;
                border-radius: 22px;
                object-fit: cover;
            }

            .pwe-conf-short-info-gr1__right {
                flex: 1 1 50%;
                padding: 48px 36px 0;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                gap: 36px;
                z-index: 2;
            }

            .pwe-conf-short-info-gr1__right-content {
                display: flex;
                flex-direction: column;
                gap: 16px;
            }

            .pwe-conf-short-info-gr1__title {
                font-size: 32px;
                font-weight: 800;
            }

            .pwe-conf-short-info-gr1__subtitle {
                font-weight: 600;
            }

            .pwe-conf-short-info-gr1__btn-container {
                display: flex;
                flex-direction: row;
                justify-content: space-around;
                align-items: center;
                flex-wrap: wrap;
                gap: 14px;
            }

            .pwe-conf-short-info-gr1__btn {
                min-width: 220px;
                text-align: center;
                font-weight: 600;
                padding: 13px 29px;
                background: black;
                color: white !important;
                border-radius: 36px;
            }

            .pwe-conf-short-info-gr1__btn_accent {
                background: var(--accent-color);
            }

            .pwe-conf-short-info-gr1__logo {
                display: flex;
                justify-content: center;
                align-items: center;
                background: #EFEFEF;
                padding: 18px;
                border-radius: 22px;
            }

            .pwe-conf-short-info-gr1__logo img {
                max-width: 240px;
                max-height: 80px;
                object-fit: contain;
                width: 100%;
            }

            @media(max-width:760px) {

                .row.limit-width.row-parent:has(#PWEConferenceShortInfo) {
                    padding: 0;
                }
                .pwe-conf-short-info-gr1__wrapper {
                    flex-direction: column-reverse;
                }
                .pwe-conf-short-info-gr1__left {
                    padding: 18px;
                    padding-top: 42px;
                    margin-top: -34px;
                    background: #EFEFEF;
                }
                .pwe-conf-short-info-gr1__right {
                    flex: 1 1 100%;
                    width: 100%;
                    padding: 0;
                    text-align: center;
                    gap: 18px;
                }
                .pwe-conf-short-info-gr1__right-content {
                    padding: 36px;
                }
                .pwe-conf-short-info-gr1__logo {
                    z-index: 1;
                    margin: 0 36px;
                    padding: 18px;
                }
                .pwe-conf-short-info-gr1__logo img {
                    max-width: 180px;
                }
            }

        </style>';

        // Layout
        $output .= '<div class="pwe-conf-short-info-gr1__wrapper">
            <div class="pwe-conf-short-info-gr1__left">
                <img src="/doc/new_template/conference_img.webp" alt="Publiczność konferencji">
            </div>
            <div class="pwe-conf-short-info-gr1__right">
                <div class="pwe-conf-short-info-gr1__right-content">
                    <div class="pwe-conf-short-info-gr1__title">' . PWECommonFunctions::languageChecker('KONFERENCJA', 'CONFERENCE') . '</div>
                    <div class="pwe-conf-short-info-gr1__subtitle">Inspiracje i wiedza dla liderów branży fasad!</div>
                    <div class="pwe-conf-short-info-gr1__desc">
                        Konferencja Innovations in Facade Design Conference to wyjątkowa okazja do poznania najnowszych trendów w branży fasad i elewacji. Eksperci podzielą się wiedzą i doświadczeniem, inspirując do tworzenia nowoczesnych rozwiązań. Dołącz już dziś!
                    </div>
                    <div class="pwe-conf-short-info-gr1__btn-container">
                        <a href="' . PWECommonFunctions::languageChecker('/wydarzenia/', '/en/conferences/') . '" class="pwe-conf-short-info-gr1__btn">' . PWECommonFunctions::languageChecker('Szczegóły', 'Details') . '</a>
                        <a href="' . PWECommonFunctions::languageChecker('/rejestracja/', '/en/registration/') . '" class="pwe-conf-short-info-gr1__btn pwe-conf-short-info-gr1__btn_accent">' . PWECommonFunctions::languageChecker('Zarejestruj się', 'Registration') . '</a>
                    </div>
                </div>
                <div class="pwe-conf-short-info-gr1__logo">
                    <img src="/doc/kongres-color.webp" alt="Congress logo">
                </div>
            </div>
        </div>';

        return $output;
    }
}
