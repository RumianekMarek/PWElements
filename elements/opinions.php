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
            }

            $default_opinions = [
                [
                    'default_opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Radoslaw-Dziuba.webp',
                    'default_opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/lukasiewicz-logo.webp',
                    'default_opinions_company' => 'Łukasiewicz – Łódzki Instytut Technologiczny',
                    'default_opinions_name' => 'dr Radosław Dziuba',
                    'default_opinions_desc' => self::languageChecker('Dyrektor Sieci Badawczej Łukasiewicz', 'Director of the Łukasiewicz Research Network'),
                    'default_opinions_text' => self::languageChecker(
                        'Ptak Warsaw Expo to partner, z którym wymieniamy się wiedzą i doświadczeniem w dziedzinach związanych z działalnością obydwu instytucji. Centrum targowo-wystawienniczym Ptak Warsaw Expo pozwala na nawiązywanie kluczowych kontaktów biznesowych, budowanie relacji z klientami oraz poznanie nowych trendów.',
                        'Ptak Warsaw Expo is a partner with whom we exchange knowledge and experience in areas related to the activities of both institutions. The Ptak Warsaw Expo exhibition center facilitates establishing key business contacts, building client relationships, and discovering new trends.'
                    )
                ],
                [
                    'default_opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Jakub-Tyczkowski.webp',
                    'default_opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/rekpol-logo.webp',
                    'default_opinions_company' => 'Rekopol Organizacja Odzysku Opakowań',
                    'default_opinions_name' => 'Jakub Tyczkowski',
                    'default_opinions_desc' => self::languageChecker('Prezes Rekopol', 'President of Rekopol'),
                    'default_opinions_text' => self::languageChecker(
                        'Rekopol Organizacja Odzysku Opakowań współpracuje z Ptak Warsaw Expo od samego początku. Nasze projekty cechuje zaangażowanie, dobra organizacja konferencji oraz świetna komunikacja.',
                        'Rekopol Packaging Recovery Organization has been cooperating with Ptak Warsaw Expo from the very beginning. Our projects are characterized by commitment, good conference organization, and excellent communication.')
                ],
                [
                    'default_opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Krzysztof-Niczyporczuk.webp',
                    'default_opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/pio-logo.webp',
                    'default_opinions_company' => 'Polska Izba Opakowań',
                    'default_opinions_name' => 'Mgr inż. Krzysztof Niczyporuk',
                    'default_opinions_desc' => '',
                    'default_opinions_text' => self::languageChecker(
                        'PTAK Warsaw Expo to wysokiej klasy organizator imprez targowych i konferencji. Polska Izba Opakowań pozytywnie ocenia współpracę z Ptak Warsaw Expo jako rzetelnym partnerem.',
                        'PTAK Warsaw Expo is a high-quality organizer of trade fairs and conferences. The Polish Packaging Chamber positively evaluates cooperation with Ptak Warsaw Expo as a reliable partner.')
                ],
                [
                    'default_opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Piotr-Fiejkiewicz.webp',
                    'default_opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/pts-logo.webp',
                    'default_opinions_company' => 'POLSKIE TOWARZYSTWO STOMATOLOGICZNE',
                    'default_opinions_name' => 'Piotr Fiejkiewicz',
                    'default_opinions_desc' => self::languageChecker('Dyrektor Biura Zarządu', 'Director of the Management Office'),
                    'default_opinions_text' => self::languageChecker(
                        'PTAK Warsaw Expo jest największym centrum wystawienniczym, z jakim współpracujemy. Firma inwestuje w rozwój infrastruktury, co zwiększa jakość organizowanych wydarzeń.',
                        'PTAK Warsaw Expo is the largest exhibition center we work with. The company invests in infrastructure development, which enhances the quality of organized events.')
                ],
                [
                    'default_opinions_face_img' => '/wp-content/plugins/PWElements/media/default-opinions/Janusz-Poulakowski.webp',
                    'default_opinions_company_img' => '/wp-content/plugins/PWElements/media/default-opinions/evoluma-logo.webp',
                    'default_opinions_company' => 'Klaster Obróbki Metali',
                    'default_opinions_name' => 'Janusz Poulakowski',
                    'default_opinions_desc' => self::languageChecker('Dyrektor Operacyjny', 'Operational Director'),
                    'default_opinions_text' => self::languageChecker(
                        'Klaster Obróbki Metali współpracuje z Ptak Warsaw Expo od samego początku. Cenimy profesjonalizm, innowacyjność oraz stabilność współpracy z Ptak Warsaw Expo.',
                        'The Metalworking Cluster has been cooperating with Ptak Warsaw Expo from the very beginning. We value professionalism, innovation, and stability in our cooperation with Ptak Warsaw Expo.')
                ]
            ];

            $output .= '
            <div id="pweOpinions"class="pwe-opinions">
                <div class="pwe-posts-title main-heading-text">
                    <h4 class="pwe-opinions__title pwe-uppercase">'. self::languageChecker('REKOMENDACJE', 'RECOMMENDATIONS') .'</h4>
                </div> 
                <div class="pwe-opinions__wrapper">
                    <div class="pwe-opinions__items pwe-slides">';

                    $show_default = true;

                    if (is_array($opinions_items_json) && !empty($opinions_items_json)) {
                        foreach ($opinions_items_json as $opinion_item) {
                            if (!empty($opinion_item['opinions_text'])) {
                                $show_default = false;
                                break;
                            }
                        }
                    }

                    // If $opinions_items_json is empty or has empty values ​​-> show default
                    $opinions_to_display = $show_default ? $default_opinions : $opinions_items_json;

                    foreach ($opinions_to_display as $opinion_item) {
                        $opinions_face_img_media = isset($opinion_item['opinions_face_img']) ? $opinion_item['opinions_face_img'] : null;
                        $opinions_company_img_media = isset($opinion_item['opinions_company_img']) ? $opinion_item['opinions_company_img'] : null;
                        $opinions_face_img_src_media = $opinions_face_img_media ? wp_get_attachment_url($opinions_face_img_media) : '';
                        $opinions_company_src_media = $opinions_company_img_media ? wp_get_attachment_url($opinions_company_img_media) : '';

                        $opinions_face_img_src_catalog = isset($opinion_item["opinions_company_img_src"]) ? $opinion_item["opinions_company_img_src"] : null;
                        $opinions_company_img_src_catalog = isset($opinion_item["opinions_face_img_src"]) ? $opinion_item["opinions_face_img_src"] : null;

                        $opinions_face_img_src = !empty($opinions_face_img_src_catalog) ? $opinions_face_img_src_catalog : $opinions_face_img_src_media;
                        $opinions_company_img_src = !empty($opinions_company_img_src_catalog) ? $opinions_company_img_src_catalog : $opinions_company_src_media;
        
                        // Default values ​​or values ​​from JSON
                        $opinions_face_img = $show_default ? $opinion_item['default_opinions_face_img'] : $opinions_face_img_src;
                        $opinions_company_img = $show_default ? $opinion_item['default_opinions_company_img'] : $opinions_company_img_src;
                        $opinions_company = $show_default ? $opinion_item['default_opinions_company'] : $opinion_item['opinions_company'];
                        $opinions_name = $show_default ? $opinion_item['default_opinions_name'] : $opinion_item['opinions_name'];
                        $opinions_desc = $show_default ? $opinion_item['default_opinions_desc'] : $opinion_item['opinions_desc'];
                        $opinions_text = $show_default ? $opinion_item['default_opinions_text'] : $opinion_item['opinions_text'];
        
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
            $output .= PWESliderScripts::sliderScripts('opinions', '.pwelement_'. self::$rnd_id, $opinions_dots_display, $opinions_arrows_display, $slides_to_show);

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