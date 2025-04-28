<?php

/**
 * Class PWElementOpinions
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementOpinions extends PWElements {

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
        $element_output = array(
            array(
                'type' => 'dropdown',
                'group' => 'PWE Element',
                'heading' => __('Presets', 'pwe_element'),
                'param_name' => 'opinions_preset',
                'save_always' => true,
                'std'       => 'preset_1',
                'value' => array(
                    'Preset 1' => 'preset_1',
                    'Preset 2' => 'preset_2',
                    'Preset 3' => 'preset_3',
                    'Preset 4' => 'preset_4',
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOpinions',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Display dots', 'pwe_display_info'),
                'param_name' => 'opinions_dots_display',
                'save_always' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOpinions',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Limit width', 'pwe_display_info'),
                'param_name' => 'opinions_limit_width',
                'save_always' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOpinions',
                ),
            ),
            array(
                'type' => 'param_group',
                'group' => 'PWE Element',
                'param_name' => 'opinions_items',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOpinions',
                ),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Person image', 'pwelement'),
                        'param_name' => 'opinions_face_img',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Person image src', 'pwelement'),
                        'param_name' => 'opinions_face_img_src',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Company image', 'pwelement'),
                        'param_name' => 'opinions_company_img',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Company image src', 'pwelement'),
                        'param_name' => 'opinions_company_img_src',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Company name', 'pwelement'),
                        'param_name' => 'opinions_company',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Person name', 'pwelement'),
                        'param_name' => 'opinions_name',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Person description', 'pwelement'),
                        'param_name' => 'opinions_desc',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Person opinion', 'pwelement'),
                        'param_name' => 'opinions_text',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Button link', 'pwelement'),
                        'param_name' => 'opinions_button',
                        'save_always' => true,
                    ),
                ),
            ),
        );
        return $element_output;
    }

    public static function output($atts) {
        extract( shortcode_atts( array(
            'opinions_preset' => '',
            'opinions_dots_display' => '',
            'opinions_limit_width' => '',
            'opinions_items' => '',
        ), $atts ));

        $opinions_items_urldecode = urldecode($opinions_items);
        $opinions_items_json = json_decode($opinions_items_urldecode, true);

        $opinions_width_element = ($opinions_limit_width == true) ? '1200px' : '100%';
        $slides_to_show = ($opinions_limit_width == true) ? 4 : 5;

        $output = '';
        $output .= '
            <style>
                .row-parent:has(.pwelement_'. self::$rnd_id .' .pwe-opinions) {
                    max-width: '. $opinions_width_element .' !important;
                    padding: 0 !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions {
                    visibility: hidden;
                    opacity: 0;
                    transition: opacity 0.5s ease-in-out;
                    padding: 18px 0;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__wrapper {
                    max-width: 100%;
                    margin: 0 auto;
                    padding: 18px 36px;
                    position: relative;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__title {
                    margin: 0 auto;
                    padding-top: 18px;
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                    position: relative;
                    padding: 18px;
                    margin: 12px;
                }

            </style>';

            if ($opinions_preset == 'preset_1') {
                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                        box-shadow: 0px 0px 12px #cccccc;
                        border-radius: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company {
                        display: flex;
                        justify-content: space-between;
                        padding: 10px 0;
                        gap: 10px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo {
                        max-width: 80px;
                        display: flex;
                        justify-content: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo img {
                        height: 50px;
                        max-width: 100%;
                        object-fit: contain;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person {
                        display: flex;
                        gap: 10px;
                        padding: 10px 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img {
                        max-width: 50px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img img {
                        width: 100%;
                        border-radius: 50%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-name {
                        margin: 0;
                        line-height: 1.2;
                        font-size: 14px;
                        font-weight: 600;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-name {
                        margin: 0;
                        font-size: 14px;
                        color: cornflowerblue;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-desc {
                        margin: 4px 0 0;
                        font-size: 12px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion {
                        padding: 10px 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text {
                        font-size: 14px;
                        line-height: 1.4;
                        margin: 0;
                    }
                </style>';
            } else if ($opinions_preset == 'preset_2') {
                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                        margin-top: 80px;
                        box-shadow: 0px 0px 12px #cccccc;
                        border-radius: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-media {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        gap: 10px;
                        margin-top: -80px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img {
                        max-width: 120px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img img {
                        width: 100%;
                        border-radius: 50%;
                        border: 4px solid '. self::$accent_color .';
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo {
                        max-width: 200px;
                        display: flex;
                        justify-content: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo img {
                        height: 60px;
                        width: 100%;
                        max-width: 160px;
                        object-fit: contain;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info {
                        text-align: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-name {
                        margin: 0;
                        line-height: 1.2;
                        font-size: 14px;
                        font-weight: 500;
                        padding: 4px 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-name {
                        width: auto;
                        margin: 0;
                        font-size: 14px;
                        color: '. self::$accent_color .';
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-desc {
                        width: auto;
                        text-align: center;
                        margin: 8px 0 0;
                        font-size: 14px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion {
                        padding: 10px 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text {
                        font-size: 14px;
                        line-height: 1.2;
                        margin: 0;
                    }
                </style>';
            } else if ($opinions_preset == 'preset_3') {
                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                        position: relative;
                        padding: 8px;
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo {
                        display: flex;
                        justify-content: center;
                        box-shadow: 2px 2px 12px #cccccc !important;
                        background: white;
                        border-radius: 18px;
                        padding: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo img {
                        height: 80px;
                        width: 100%;
                        max-width: 160px;
                        object-fit: contain;

                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-container {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        margin-top: 18px;
                        margin-bottom: -50px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker {
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        box-shadow: 2px 2px 12px #cccccc !important;
                        background: white;
                        border-radius: 18px;
                        padding: 60px 10px 10px;
                        min-height: 260px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-img {
                        max-width: 120px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-img img {
                        width: 100%;
                        border-radius: 50%;
                        aspect-ratio: 1 / 1;
                        object-fit: cover;
                        object-position: top;
                        border: 1px solid #3d3d3d;
                    }

                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-info {
                        text-align: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-info h5 {
                        width: 100%;
                        text-align: center;
                        font-size: 16px;
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-name {
                        margin: 0;
                        line-height: 1.2;
                        font-size: 14px;
                        font-weight: 500;
                        padding: 4px 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-info-name {
                        width: auto;
                        margin: 0;
                        font-size: 14px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-info-desc {
                        width: auto;
                        text-align: center;
                        margin: 8px 0 0;
                        font-size: 14px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion {
                        padding: 10px 0;
                        text-align: center;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text {
                        text-align: center;
                        font-size: 12px;
                        line-height: 1.2;
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-btn {
                        margin-top: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-btn a {
                        color: white !important;
                        display: flex;
                        justify-content: center;
                        width: 100%;
                        text-align: center;
                        background-color: #3d3d3d;
                        padding: 10px;
                        border-radius: 10px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-btn a:hover {
                        color: white !important;
                    }
                </style>';
            } else if ($opinions_preset == 'preset_4') {
                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                        display: flex !important;
                        box-shadow: 0 0 12px -6px black;
                        padding: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-left {
                        width: 40%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img {
                        height: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img img{
                        object-fit: cover;
                        height: 100%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-right {
                        width: 60%;
                        padding: 36px;
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-start;
                        gap: 24px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-info-container {
                        display: flex;
                        justify-content: space-between;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-container {
                        display: flex;
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-desc {
                        font-size: 12px !important;
                         margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-name {
                        font-size: 12px;
                        margin: 0;
                        color: var(--accent-color);
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-info-container {
                        display: flex;
                        flex-direction: column;
                        align-items: flex-end;
                        max-width: 200px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-name {
                        font-size: 12px;
                        margin: 0;
                        text-align: right;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo img {
                        max-width: 100px;
                        margin-left: auto;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion {
                        position: relative;
                        padding: 18px;
                        margin: auto;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text {
                        font-size: 14px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-see-more {
                        text-align: right;
                    }
                    .pwelement_'. self::$rnd_id .' .quote {
                        position: absolute;
                        width: 30px;
                        height: 30px;
                        fill: var(--accent-color);
                        filter: drop-shadow(0px 0px 1px black);
                    }
                    .pwelement_'. self::$rnd_id .' .quote-right {
                        right: -2%;
                        top: -12px;
                    }
                    .pwelement_'. self::$rnd_id .' .quote-left {
                        left: -2%;
                        bottom: -12px;
                    }
                    @media(max-width:600px){
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                            flex-direction: column;
                            padding-top: 40px;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-left {
                            width: 100%;
                        } 
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-right {
                            width: 100%;
                            padding: 18px;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-img img{
                            width: 100%;
                            max-width: 160px;
                            margin: -80px auto 0;
                            box-shadow: 0px 0px 10px -4px black;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-info-container {
                            flex-direction: column;
                            align-items: center;
                            max-width: 100%;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-name,
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-desc,
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-name {
                            text-align: center;
                            width: 100%;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo {
                            margin: 10px auto;
                        }
                        .pwelement_'. self::$rnd_id .' .slick-list {
                            overflow: visible;
                        }
                    }
                </style>';
            }

            $default_opinions = [
                [
                    'opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Radoslaw-Dziuba.webp',
                    'opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/lukasiewicz-logo.webp',
                    'opinions_company' => 'Łukasiewicz – Łódzki Instytut Technologiczny',
                    'opinions_name' => 'dr Radosław Dziuba',
                    'opinions_desc' => self::languageChecker('Dyrektor Sieci Badawczej Łukasiewicz', 'Director of the Łukasiewicz Research Network'),
                    'opinions_text' => self::languageChecker(
                        'Ptak Warsaw Expo to partner, z którym wymieniamy się wiedzą i doświadczeniem w dziedzinach związanych z działalnością obydwu instytucji. Centrum targowo-wystawienniczym Ptak Warsaw Expo pozwala na nawiązywanie kluczowych kontaktów biznesowych, budowanie relacji z klientami oraz poznanie nowych trendów.',
                        'Ptak Warsaw Expo is a partner with whom we exchange knowledge and experience in areas related to the activities of both institutions. The Ptak Warsaw Expo exhibition center facilitates establishing key business contacts, building client relationships, and discovering new trends.'
                    )
                ],
                [
                    'opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Jerzy_Romanski.webp',
                    'opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/ofmisp-logo.webp',
                    'opinions_company' => 'Ogólnopolska Federacja Małych i Średnich Przedsiębiorców',
                    'opinions_name' => 'Jerzy Romański',
                    'opinions_desc' => self::languageChecker('Wiceprezes', 'Vice President'),
                    'opinions_text' => self::languageChecker(
                        'Zbudowanie przyjaznej więzi pomiędzy organizatorem targów, firmą wystawiającą się i organizacjami wspierającymi jest kluczowe, by uniknąć błędów i w pełni wykorzystać potencjał wydarzenia.',
                        'Building a friendly relationship between the trade fair organizer, the exhibiting company, and supporting organizations is key to avoiding mistakes and fully utilizing the potential of the event.')
                ],
                [
                    'opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Krzysztof-Niczyporczuk.webp',
                    'opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/pio-logo.webp',
                    'opinions_company' => 'Polska Izba Opakowań',
                    'opinions_name' => 'Mgr inż. Krzysztof Niczyporuk',
                    'opinions_desc' => '',
                    'opinions_text' => self::languageChecker(
                        'PTAK Warsaw Expo to wysokiej klasy organizator imprez targowych i konferencji. Polska Izba Opakowań pozytywnie ocenia współpracę z Ptak Warsaw Expo jako rzetelnym partnerem.',
                        'PTAK Warsaw Expo is a high-quality organizer of trade fairs and conferences. The Polish Packaging Chamber positively evaluates cooperation with Ptak Warsaw Expo as a reliable partner.')
                ],
                [
                    'opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Piotr-Fiejkiewicz.webp',
                    'opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/pts-logo.webp',
                    'opinions_company' => 'POLSKIE TOWARZYSTWO STOMATOLOGICZNE',
                    'opinions_name' => 'Piotr Flejszar',
                    'opinions_desc' => self::languageChecker('Dyrektor Biura Zarządu', 'Director of the Management Office'),
                    'opinions_text' => self::languageChecker(
                        'PTAK Warsaw Expo jest największym centrum wystawienniczym, z jakim współpracujemy. Firma inwestuje w rozwój infrastruktury, co zwiększa jakość organizowanych wydarzeń.',
                        'PTAK Warsaw Expo is the largest exhibition center we work with. The company invests in infrastructure development, which enhances the quality of organized events.')
                ],
                [
                    'opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Pawel_Babski.webp',
                    'opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/kit-logo.webp',
                    'opinions_company' => self::languageChecker('Krajowa Izba Targowa','National Chamber of Trade Fairs'),
                    'opinions_name' => 'Paweł Babski',
                    'opinions_desc' => self::languageChecker('Prezes', 'President'),
                    'opinions_text' => self::languageChecker(
                        'Nic nie zastąpi spotkania z producentem, wystawcą. Możliwość obserwowania i wpływania na kierunek, w którym rozwija się branża jest możliwa dzięki takim spotkaniom. Premierowe edycje targów dają właśnie taką możliwość.',
                        'Nothing can replace a meeting with a manufacturer, an exhibitor. The possibility of observing and influencing the direction in which the industry is developing is possible thanks to such meetings. Premiere editions of trade fairs offer exactly that opportunity.')
                ]
            ];

            $edition = do_shortcode('[trade_fair_edition]');
                if (strpos(strtolower($edition) , "premier") !== false) {
                    $premiere_edition_opinions = [
                        [
                            'opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Marlena-Wronkowska.webp',
                            'opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/wprost-logo.webp',
                            'opinions_company' => 'Wprost',
                            'opinions_name' => 'Marlena Wronkowska',
                            'opinions_desc' => self::languageChecker('Dyrektor Projektów Biznesowych', 'Director of Business Projects'),
                            'opinions_text' => self::languageChecker(
                                'Tygodnik „Wprost” z uznaniem odnosi się do premierowych wydarzeń targowych organizowanych w 2025 roku przez Ptak Warsaw Expo. Nowe inicjatywy, takie jak Clean Tech Expo, Composite Poland czy Wire Tech Poland, nie tylko wzbogacają kalendarz targowy, ale również odpowiadają na aktualne potrzeby poszczególnych branż, oferując platformę do prezentacji innowacyjnych rozwiązań i nawiązywania wartościowych kontaktów biznesowych.​ Ptak Warsaw Expo, poprzez organizację tych premierowych wydarzeń, potwierdza swoją pozycję jako lidera wśród centrów targowych w Europie Środkowo-Wschodniej, oferując platformę sprzyjającą rozwojowi innowacji i współpracy międzybranżowej.',
                                'The weekly magazine Wprost expresses appreciation for the premiere trade fair events organized in 2025 by Ptak Warsaw Expo. New initiatives such as Clean Tech Expo, Composite Poland, and Wire Tech Poland not only enrich the trade fair calendar but also respond to the current needs of specific industries by providing a platform for showcasing innovative solutions and fostering valuable business connections. By organizing these premiere events, Ptak Warsaw Expo reaffirms its position as a leader among trade fair centers in Central and Eastern Europe, offering an environment conducive to innovation and cross-industry collaboration.'
                            )
                        ]
                    ];

                    $default_opinions = array_merge($default_opinions, $premiere_edition_opinions);

                    $max_opinions = 5 + count($premiere_edition_opinions);
                }

            $output .= '
            <div id="pweOpinions"class="pwe-opinions">
                <div class="pwe-posts-title main-heading-text">
                    <h4 class="pwe-opinions__title pwe-uppercase">'. self::languageChecker('REKOMENDACJE', 'RECOMMENDATIONS') .'</h4>
                </div>
                <div class="pwe-opinions__wrapper">
                    <div class="pwe-opinions__items pwe-slides">';

                    if (empty($max_opinions)) {
                        $max_opinions = 5; // Maximum number of reviews displayed together
                    }
                    $user_opinions = [];

                    // Analyze user feedback and collect non-empty
                    if (is_array($opinions_items_json) && !empty($opinions_items_json)) {
                        foreach ($opinions_items_json as $opinion_item) {
                            if (!empty($opinion_item['opinions_text'])) {
                                $user_opinions[] = $opinion_item;
                            }
                        }
                    }

                    // If the number of user reviews is greater than the maximum number of reviews
                    if (count($user_opinions) > $max_opinions) {
                        $opinions_to_display = array_slice($user_opinions, 0, 15);
                    } else {
                        $remaining_slots = $max_opinions - count($user_opinions);
                        $default_opinions_to_add = array_slice($default_opinions, 0, $remaining_slots);
                        $opinions_to_display = array_merge($user_opinions, $default_opinions_to_add);
                    }

                    foreach ($opinions_to_display as $opinion_item) {

                        // Person image
                        if (!empty($opinion_item['opinions_face_img'])) {
                            if (is_numeric($opinion_item['opinions_face_img'])) {
                                $opinions_face_img_src = wp_get_attachment_url($opinion_item['opinions_face_img']);
                            } else {
                                $opinions_face_img_src = $opinion_item['opinions_face_img'];
                            }
                        } else {
                            $opinions_face_img_src = $opinion_item["opinions_face_img_src"];
                        }

                        // Company image
                        if (!empty($opinion_item['opinions_company_img'])) {
                            if (is_numeric($opinion_item['opinions_company_img'])) {
                                $opinions_company_img_src = wp_get_attachment_url($opinion_item['opinions_company_img']);
                            } else {
                                $opinions_company_img_src = $opinion_item['opinions_company_img'];
                            }
                        } else {
                            $opinions_company_img_src = $opinion_item["opinions_company_img_src"];
                        }

                        $opinions_face_img =  $opinions_face_img_src;
                        $opinions_company_img =  $opinions_company_img_src;
                        $opinions_company = $opinion_item['opinions_company'];
                        $opinions_name = $opinion_item['opinions_name'];
                        $opinions_desc = $opinion_item['opinions_desc'];
                        $opinions_text = $opinion_item['opinions_text'];

                        $opinions_button = isset($opinion_item["opinions_button"]) ? $opinion_item["opinions_button"] : null;

                        // Splitting the text into 30 words and the rest
                        $words = explode(" ", $opinions_text);
                        $short_text = implode(" ", array_slice($words, 0, 24));
                        $remaining_text = implode(" ", array_slice($words, 24));

                        if ($opinions_preset == 'preset_1') {
                            $output .= '
                            <div class="pwe-opinions__item">
                                <div class="pwe-opinions__item-company">
                                    ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                    <div class="pwe-opinions__item-company_logo">
                                        <img data-no-lazy="1" src="' . $opinions_company_img . '">
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-person">
                                    <div class="pwe-opinions__item-person-img">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '">
                                    </div>
                                    <div class="pwe-opinions__item-person-info">
                                        <h3 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h3>
                                        <h5 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h5>
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-opinion">
                                    <p style="display: inline;" class="pwe-opinions__item-opinion-text">' . $short_text . ' </p>' .
                                    (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                    (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                </div>
                            </div>';
                        } else if ($opinions_preset == 'preset_2') {
                            $output .= '
                            <div class="pwe-opinions__item">
                                <div class="pwe-opinions__item-media">
                                    <div class="pwe-opinions__item-person-img">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '">
                                    </div>
                                    <div class="pwe-opinions__item-company_logo">
                                        <img data-no-lazy="1" src="' . $opinions_company_img . '">
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-person-info">
                                    <h5 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h5>
                                    ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                    <h3 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h3>
                                </div>
                                <div class="pwe-opinions__item-opinion">
                                    <p style="display: inline;" class="pwe-opinions__item-opinion-text">' . $short_text . ' </p>' .
                                    (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                    (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                </div>
                            </div>';
                        } else if ($opinions_preset == 'preset_3') {
                            $output .= '
                            <div class="pwe-opinions__item">';
                                if (!empty($opinions_company_img)) {
                                    $output .= '
                                    <div class="pwe-opinions__item-company_logo">
                                        <img data-no-lazy="1" src="' . $opinions_company_img . '">
                                    </div>';
                                }

                                $output .= '
                                <div class="pwe-opinions__item-speaker-container">
                                    <div class="pwe-opinions__item-speaker-img">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '">
                                    </div>
                                    </div>

                                    <div class="pwe-opinions__item-speaker">
                                    <div class="pwe-opinions__item-speaker-info">
                                        <h5 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h5>
                                        ' . (!empty($opinions_desc) ? '<h5 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h5>' : '<span></span>') . '
                                        ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                    </div>
                                    <div class="pwe-opinions__item-opinion">
                                        <p style="display: inline;" class="pwe-opinions__item-opinion-text">' . $short_text . ' </p>' .
                                        (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                        (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                    </div>
                                </div>';
                                if (!empty($opinions_button)) {
                                    $output .= '
                                    <div class="pwe-opinions__item-btn">
                                        <a href="'. $opinions_button .'">'. self::languageChecker('ZOBACZ WIĘCEJ', 'SEE MORE') .'</a>
                                    </div>';
                                }
                            $output .= '
                            </div>';
                        } else if ($opinions_preset == 'preset_4') {
                            $output .= '
                            <div class="pwe-opinions__item">
                                <div class="pwe-opinions__item-left">
                                    <div class="pwe-opinions__item-person-img">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '">
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-right">
                                    <div class="pwe-opinions__item-info-container">
                                        <div class="pwe-opinions__item-person-info-container">
                                            <h5 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h5>
                                            <h3 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h3>
                                        </div>
                                            <div class="pwe-opinions__item-company-info-container">
                                            <div class="pwe-opinions__item-company_logo">
                                                <img data-no-lazy="1" src="' . $opinions_company_img . '">
                                            </div>
                                            ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                        </div>
                                    </div>
                                    <div class="pwe-opinions__item-opinion">
                                        <svg class="quote quote-right" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M119.472,66.59C53.489,66.59,0,120.094,0,186.1c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.135,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.829-6.389 c82.925-90.7,115.385-197.448,115.385-251.8C238.989,120.094,185.501,66.59,119.472,66.59z"></path> <path class="st0" d="M392.482,66.59c-65.983,0-119.472,53.505-119.472,119.51c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.136,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.828-6.389 C479.539,347.2,512,240.452,512,186.1C512,120.094,458.511,66.59,392.482,66.59z"></path> </g> </g></svg>
                                        <p style="display: inline;" class="pwe-opinions__item-opinion-text">' . $short_text . ' </p>' .
                                        (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                        (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                        <svg class="quote quote-left" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M119.472,66.59C53.489,66.59,0,120.094,0,186.1c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.135,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.829-6.389 c82.925-90.7,115.385-197.448,115.385-251.8C238.989,120.094,185.501,66.59,119.472,66.59z"></path> <path class="st0" d="M392.482,66.59c-65.983,0-119.472,53.505-119.472,119.51c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.136,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.828-6.389 C479.539,347.2,512,240.452,512,186.1C512,120.094,458.511,66.59,392.482,66.59z"></path> </g> </g></svg>
                                    </div>
                                </div>
                            </div>';
                        }
                    }

                    $output .= '
                    </div>

                    <span class="pwe-opinions__arrow pwe-opinions__arrow-prev pwe-arrow pwe-arrow-prev">‹</span>
                    <span class="pwe-opinions__arrow pwe-opinions__arrow-next pwe-arrow pwe-arrow-next">›</span>

                </div>
            </div>';

            $opinions_arrows_display = 'true';

            include_once plugin_dir_path(__FILE__) . '/../scripts/slider.php';

            if ($opinions_preset == 'preset_4') {
                $opinions_options[] = array(
                    "center_mode" => $center_mode = true,
                );
                $output .= PWESliderScripts::sliderScripts('opinions-preset-4', '.pwelement_'. self::$rnd_id, $opinions_dots_display, $opinions_arrows_display, $slides_to_show = 1, $opinions_options);
            } else {
                $output .= PWESliderScripts::sliderScripts('opinions', '.pwelement_'. self::$rnd_id, $opinions_dots_display, $opinions_arrows_display, $slides_to_show);
            }

            $output .= '
            <script>
                jQuery(function ($) {

                    // Function to set equal height
                    function setEqualHeight() {
                        let maxHeight = 0;

                        // Reset the heights before calculations
                        $(".pwe-opinions__item").css("height", "auto");

                        // Calculate the maximum height
                        $(".pwe-opinions__item").each(function() {
                            const thisHeight = $(this).outerHeight();
                            if (thisHeight > maxHeight) {
                                maxHeight = thisHeight;
                            }
                        });

                        // Set the same height for all
                        $(".pwe-opinions__item").css("minHeight", maxHeight);
                    }

                    // Call the function after loading the slider
                    $(".pwe-opinions__items").on("init", function() {
                        setEqualHeight();
                    });

                    // Call the function when changing the slide
                    $(".pwe-opinions__items").on("afterChange", function() {
                        setEqualHeight();
                    });

                    // Call the function at the beginning
                    setEqualHeight();

                    $("#pweOpinions").css("visibility", "visible").animate({ opacity: 1 }, 500);
                });
            </script>';

        return $output;
    }
}