<?php
/**
 * Class PWENewsUpcoming
 * Szablon „News upcoming” ładowany przez PWENews.
 */
class PWENewsUpcoming extends PWENews {

    /**
     * Uwaga: NIE wywołujemy parent::__construct(), żeby nie dublować hooków.
     */
    public function __construct() {}

    /**
     * Definicje pól dla WPBakery (jeśli gdzieś je łączysz z vc_map).
     * Poprawione dependency -> 'news_template_type'.
     */
    public static function initElements() {
        $dep = array(
            'element' => 'news_template_type',
            'value'   => 'PWENewsUpcoming',
        );

        return array(
            array(
                'type' => 'textfield',
                'group' => 'News',
                'heading' => __('News Title', 'pwelement'),
                'param_name' => 'pwe_news_upcoming_title',
                'save_always' => true,
                'dependency' => $dep,
            ),
            array(
                'type' => 'textfield',
                'group' => 'News',
                'heading' => __('News Date', 'pwelement'),
                'param_name' => 'pwe_news_upcoming_date',
                'save_always' => true,
                'dependency' => $dep,
            ),
            array(
                'type' => 'textarea_raw_html',
                'group' => 'News',
                'heading' => __('News Description', 'pwelement'),
                'param_name' => 'pwe_news_upcoming_desc',
                'save_always' => true,
                'dependency' => $dep,
            ),
            array(
                'type' => 'param_group',
                'group' => 'News',
                'heading' => __('Fairs', 'pwelement'),
                'param_name' => 'pwe_news_upcoming_fairs',
                'dependency' => $dep,
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Fair Domain', 'pwelement'),
                        'param_name' => 'pwe_news_upcoming_fair_domain',
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Fair Title', 'pwelement'),
                        'param_name' => 'pwe_news_upcoming_fair_title',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textarea_raw_html',
                        'heading' => __('Fair Description', 'pwelement'),
                        'param_name' => 'pwe_news_upcoming_fair_desc',
                        'save_always' => true,
                    ),
                ),
            ),
            array(
                'type' => 'param_group',
                'group' => 'News',
                'heading' => __('Why worth', 'pwelement'),
                'param_name' => 'pwe_news_upcoming_worth',
                'dependency' => $dep,
                'params' => array(
                    array(
                        'type' => 'textarea_raw_html',
                        'heading' => __('Icon', 'pwelement'),
                        'param_name' => 'pwe_news_upcoming_worth_icon',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Title', 'pwelement'),
                        'param_name' => 'pwe_news_upcoming_worth_title',
                        'admin_label' => true,
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textarea_raw_html',
                        'heading' => __('Desc', 'pwelement'),
                        'param_name' => 'pwe_news_upcoming_worth_desc',
                        'save_always' => true,
                    ),
                ),
            ), 
        );
    }

    public static function output($atts) {

        extract( shortcode_atts( array(
            'pwe_news_upcoming_title'         => '',
            'pwe_news_upcoming_date'          => '',
            'pwe_news_upcoming_desc'          => '',
            'pwe_news_upcoming_fairs'         => '',
            'pwe_news_upcoming_worth'         => '',
            'pwe_news_upcoming_fair_domain'   => '',
            'pwe_news_upcoming_fair_title'    => '',
            'pwe_news_upcoming_fair_desc'     => '',
            'pwe_news_upcoming_worth_icon'    => '',
            'pwe_news_upcoming_worth_title'   => '',
            'pwe_news_upcoming_worth_desc'    => '',
            'pwe_news_upcoming_domain'        => '',
        ), $atts ));


        $pwe_news_upcoming_desc  = PWECommonFunctions::decode_clean_content($pwe_news_upcoming_desc);

        $fairs = vc_param_group_parse_atts( $pwe_news_upcoming_fairs );
        $worth = vc_param_group_parse_atts( $pwe_news_upcoming_worth );

        $icon_svg_handshake = '<i class="fa fa-handshake-o fa-5x fa-fw"></i>';
        $icon_svg_bulb = '<i class="fa fa-lightbulb2 fa-5x fa-fw"></i>';
        $icon_svg_book = '<i class="fa fa-book-open fa-5x fa-fw"></i>';

        $default_svgs = array($icon_svg_handshake, $icon_svg_bulb, $icon_svg_book);

        $output  = '';
        $output .= '
        <div class="pwe-news-upcoming" id="PWENewsUpcoming">
            <div class="pwe-news-upcoming__header">
                <h1 class="pwe-news-upcoming__header-title">' . $pwe_news_upcoming_title . '</h1>
                <p class="pwe-news-upcoming__header-date">' . $pwe_news_upcoming_date . ' | Ptak Warsaw Expo</p>
                <div class="pwe-news-upcoming__header-desc">' . $pwe_news_upcoming_desc . '</div>
                <hr class="pwe-news-upcoming__header-hr">
            </div>';

            // Sekcja Fairs
            $output .= '<div class="pwe-news-upcoming__fairs">';
                if (!empty($fairs)) {
                    foreach ( $fairs as $fair ) {

                        $fair_domain = isset($fair['pwe_news_upcoming_fair_domain']) ? $fair['pwe_news_upcoming_fair_domain'] : '';
                        $fair_title  = isset($fair['pwe_news_upcoming_fair_title'])  ? $fair['pwe_news_upcoming_fair_title']  : '';
                        $fair_desc   = isset($fair['pwe_news_upcoming_fair_desc'])   ? PWECommonFunctions::decode_clean_content($fair['pwe_news_upcoming_fair_desc']) : '';
                        $fair_accent_color = do_shortcode('[pwe_color_accent domain="' . $fair_domain . '"]');
                        $fair_main2_color = do_shortcode('[pwe_color_main2 domain="' . $fair_domain . '"]');

                        $output .= '
                        <div class="pwe-news-upcoming__single-fair">
                            <a class="pwe-news-upcoming__single-fair-logo-container" style="background-image: url(https://' . $fair_domain . '/doc/header_mobile.webp);" href="https://' . $fair_domain . self::languageChecker('', '/en') .'/?utm_source=warsawexpo&utm_medium=news&utm_campaign=refferal" target="_blank">
                                <img class="pwe-news-upcoming__single-fair-logo" src="https://' . $fair_domain . '/doc/logo.webp">
                            </a>
                            <div class="pwe-news-upcoming__single-fair-text-container">
                                <h2 class="pwe-news-upcoming__single-fair-text-title">' . $fair_title . '</h2>
                                <div class="pwe-news-upcoming__single-fair-text-desc">' . $fair_desc . '</div>
                                <div class="pwe-news-upcoming__single-fair-text-btn-container">
                                    <a class="pwe-news-upcoming__single-fair-text-btn" style="--fair-accent-color: ' . $fair_accent_color . ';" href="https://' . $fair_domain . self::languageChecker('/rejestracja/', '/en/registration/') .'?utm_source=warsawexpo&utm_medium=news&utm_campaign=refferal" target="_blank">Zarejestruj się</a>
                                    <a class="pwe-news-upcoming__single-fair-text-btn" style="--fair-accent-color: ' . $fair_main2_color . ';" href="https://' . $fair_domain . self::languageChecker('/wydarzenia/', '/en/conferences/') .'?utm_source=warsawexpo&utm_medium=news&utm_campaign=refferal" target="_blank">Sprawdź agendę wydarzenia</a>
                                </div>
                            </div>
                        </div>
                        <hr class="pwe-news-upcoming__single-fair-hr">';
                    }
                }
            $output .= '</div>';

            // Sekcja Why worth
            $output .= '<div class="pwe-news-upcoming__worth">';
                if (!empty($worth) && is_array($worth)) {
                    $i = 0;
                    $output .= '<h2 class="pwe-news-upcoming__worth-heading">Dlaczego warto?</h2>
                    <div class="pwe-news-upcoming__worth-card-container">';
                    foreach ($worth as $card) {
                        $card_title = isset($card['pwe_news_upcoming_worth_title']) ? esc_html($card['pwe_news_upcoming_worth_title']) : '';
                        $card_desc  = isset($card['pwe_news_upcoming_worth_desc']) ? PWECommonFunctions::decode_clean_content($card['pwe_news_upcoming_worth_desc']) : '';
                        $icon_html  = '';

                        if (!empty($card['pwe_news_upcoming_worth_icon'])) {
                            $icon_html = PWECommonFunctions::decode_clean_content($card['pwe_news_upcoming_worth_icon']);
                        }
                        if ($icon_html === '') {
                            // dobierz domyślną wg indeksu (rotacja 0..2)
                            $icon_html = $default_svgs[$i % 3];
                        }

                        $output .= '
                        <div class="pwe-news-upcoming__worth-card">
                            <div class="pwe-news-upcoming__worth-icon">'.$icon_html.'</div>
                            <h4 class="pwe-news-upcoming__worth-title">'.$card_title.'</h4>
                            <div class="pwe-news-upcoming__worth-desc">'.$card_desc.'</div>
                        </div>';

                        $i++;
                    }
                    $output .= '</div>';
                }
            $output .= '</div>
            <hr class="pwe-news-upcoming__header-hr">';

            // Sekcja Map
            $output .= '
            <div class="pwe-news-upcoming__map">
                <div class="pwe-news-upcoming__map-content">
                    <h2 class="pwe-news-upcoming__map-heading">Praktyczne informacje</h2>
                    <p class="pwe-news-upcoming__map-desc">
                        <strong>Data:</strong> ' . $pwe_news_upcoming_date . '<br>
                        <strong>Miejsce:</strong> Ptak Warsaw Expo, Nadarzyn k. Warszawy<br>
                        <strong>Godziny otwarcia:</strong> 10:00–17:00<br>
                        <strong>Hale wystawowe:</strong> Szczegółowe informacje o halach i wejściach dostępne są na stronie każdego wydarzenia.<br>
                    </p>
                </div>
                <div class="pwe-news-upcoming__map-img-container">
                    <img class="pwe-news-upcoming__map-img" src="/wp-content/plugins/pwe-media/media/pwe-map.webp">
                </div>
            </div>
            <hr class="pwe-news-upcoming__header-hr">';

            // LinkedIn (stały blok)
            $output .= '
                <div class="pwe-news-upcoming__linkedin">
                    <div class="pwe-news-upcoming__linkedin-content">
                        <img src="/wp-content/plugins/pwe-media/media/Dariusz_Drag.webp" alt="' . self::languageChecker('Dariusz Drąg – Ekspert rynku wystawienniczego', 'Dariusz Drąg – Exhibition market expert') . '">
                        <div class="pwe-news-upcoming__linkedin-content-text">
                            <h2 class="pwe-news-upcoming__linkedin-title">Dariusz Drąg</h2>
                            <h3 class="pwe-news-upcoming__linkedin-subtitle">' . self::languageChecker('Ekspert rynku wystawienniczego | Ptak Warsaw Expo', 'Exhibition market expert | Ptak Warsaw Expo') . '</h3>
                            <p class="pwe-news-upcoming__linkedin-desc">' . self::languageChecker('Kreatywny profesjonalista z dużym doświadczeniem w organizacji różnego rodzaju przedsięwzięć, zarządzaniu zespołem oraz prowadzeniu negocjacji.', 'Creative professional with extensive experience in organizing various types of events, managing a team and conducting negotiations.') . '</p>
                        </div>
                    </div>
                    <div class="pwe-news-upcoming__linkedin-footer">
                        <p class="pwe-news-upcoming__linkedin-thx">' . self::languageChecker('Dziękujemy, że przeczytałaś/eś nasz artykuł do końca.', 'Thank you for reading our article to the end.') . '</p>
                        <a class="pwe-news-upcoming__btn--black" target="_blank" href="https://www.linkedin.com/build-relation/newsletter-follow?entityUrn=7185929412658302977">' . self::languageChecker('Dołącz do Newslettera na LinkedIn', 'Join the newsletter on LinkedIn') . '</a>
                    </div>
                </div>
            </div>';

        $output .= '</div>';

        return $output;
    }

}
