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
                'heading' => __('Slider type', 'pwe_element'),
                'param_name' => 'opinions_slider_type',
                'save_always' => true,
                'std' => 'slick',
                'value' => array(
                    'Slick Slider' => 'slick',
                    'Swiper.js' => 'swiper',
                ),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementOpinions',
                ),
            ),
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
                    'Preset 5' => 'preset_5',
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
                'heading' => __('Remove display more button', 'pwe_display_info'),
                'param_name' => 'opinions_remove_display_more_button',
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
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Opinions to hide', 'pwe_display_info'),
                'param_name' => 'opinions_to_hide',
                'save_always' => true,
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

        $swiper_fields = array(
            array(
                'type' => 'checkbox',
                'group' => 'Swiper Settings',
                'heading' => __('Show arrows (navigation)', 'pwe_element'),
                'param_name' => 'opinions_arrows_display',
                'value' => array(__('Yes', 'pwe_element') => 'true'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'opinions_slider_type',
                    'value' => array('swiper'),
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'Swiper Settings',
                'heading' => __('Show scrollbar', 'pwe_element'),
                'param_name' => 'opinions_scrollbar_display',
                'value' => array(__('Yes', 'pwe_element') => 'true'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'opinions_slider_type',
                    'value' => array('swiper'),
                ),
            ),
            array(
                'type' => 'param_group',
                'group' => 'Swiper Settings',
                'heading' => __('Breakpoints (slidesPerView)', 'pwe_element'),
                'param_name' => 'opinions_breakpoints',
                'dependency' => array(
                    'element' => 'opinions_slider_type',
                    'value' => array('swiper'),
                ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Min. Width (px)', 'pwe_element'),
                        'param_name' => 'breakpoint_width',
                        'save_always' => true,
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Slides Per View', 'pwe_element'),
                        'param_name' => 'breakpoint_slides',
                        'save_always' => true,
                        'admin_label' => true,
                    ),
                ),
            ),
        );

        return array_merge($element_output, $swiper_fields);
    }

    public static function outputOpinionsSwiper($atts) {
        extract( shortcode_atts( array(
            'opinions_preset' => '',
            'opinions_dots_display' => '',
            'opinions_limit_width' => '',
            'opinions_items' => '',
            'opinions_remove_display_more_button' => '',
            'opinions_arrows_display' => '',
            'opinions_scrollbar_display' => '',
            'opinions_breakpoints' => '',
            'opinions_to_hide' => '',
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
                    margin: 0 auto;
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
                }
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text p {
                    font-size: 14px;
                    line-height: 1.3;
                    text-align: left;
                    display: inline-block;
                    margin: 0;
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
                        max-width: 50px;
                        aspect-ratio: 3 / 2;
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
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-info h4 {
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
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text,
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text p {
                        text-align: center;
                        font-size: 14px;
                        line-height: 1.3;
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
            } else if ($opinions_preset == 'preset_5') {

                $slides_to_show = 2;

                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                        display: flex !important;
                        flex-direction: column;
                        box-shadow: 0 0 12px -6px black;
                        padding: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-top {
                        width: 100%;
                        display: flex;
                        justify-content: space-between;
                        padding: 24px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container {
                        display: flex;
                        align-items: center;
                        gap: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container img{
                        object-fit: cover;
                        width: 100px;
                        border-radius: 50%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-bottom {
                        width: 100%;
                        padding: 24px;
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
                        font-size: 14px !important;
                        font-weight: 500;
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-name {
                        font-size: 20px;
                        font-weight: 700;
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-info-container {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: flex-end;
                        max-width: 200px;
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
                        text-align: left;
                        display: inline-block;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-see-more {
                        text-align: right;
                    }
                    .pwelement_'. self::$rnd_id .' .quote {
                        position: absolute;
                        width: 20px;
                        height: 20px;
                        fill: var(--accent-color);
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
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-top {
                            width: 100%;
                            flex-direction: column;
                            padding: 12px;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container {
                            flex-direction: column;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-bottom {
                            width: 100%;
                            padding: 18px;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container img{
                            width: 100%;
                            max-width: 160px;
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
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo img {
                            max-width: 120px;
                        }
                    }
                </style>';
            }

            $edition = do_shortcode('[trade_fair_edition]');

            // Loading JSON with default opinions
            $opinions_file = 'https://mr.glasstec.pl/doc/pwe-opinions.json';
            $opinions_data = json_decode(file_get_contents($opinions_file), true);

            $default_opinions = $opinions_data['default'] ?? [];

            if (strpos(strtolower($edition), "premier") !== false) {
                $default_opinions = array_merge($default_opinions, $opinions_data['premiere'] ?? []);
            } else {
                $default_opinions = array_merge($default_opinions, $opinions_data['no_premiere'] ?? []);
            }

            // Index the default opinions_order
            $opinions_indexed = [];
            foreach ($default_opinions as $opinion) {
                $order = $opinion['opinions_order'] ?? null;
                if ($order) {
                    $opinions_indexed[$order] = $opinion;
                }
            }

            // Get opinions from the database
            $data = PWECommonFunctions::get_database_fairs_data_opinions(); 
            if (!empty($data)) {
                // If there are 2 opinions in the summary – overwrite
                if (count($data) >= 2) {
                    $opinions_indexed = []; 
                }

                foreach ($data as $row) {
                    if (!empty($row->data)) {
                        $decoded = json_decode($row->data, true);

                        if ($decoded) {
                            $opinion = [
                                'opinions_slug'              => $row->slug ?? '',
                                'opinion_person_img'         => !empty($decoded['opinion_person_img'])
                                    ? 'https://cap.warsawexpo.eu/public/uploads/domains/' . str_replace('.', '-', $_SERVER['HTTP_HOST']) . '/opinions/' . $row->slug . '/' . $decoded['opinion_person_img']
                                    : '',
                                'opinion_company_img'        => !empty($decoded['opinion_company_img'])
                                    ? 'https://cap.warsawexpo.eu/public/uploads/domains/' . str_replace('.', '-', $_SERVER['HTTP_HOST']) . '/opinions/' . $row->slug . '/' . $decoded['opinion_company_img']
                                    : '',
                                'opinion_company_name_pl'    => $decoded['opinion_company_name_pl'] ?? '',
                                'opinion_company_name_en'    => $decoded['opinion_company_name_en'] ?? '',
                                'opinion_person_name'        => $decoded['opinion_person_name'] ?? '',
                                'opinion_person_position_pl' => $decoded['opinion_person_position_pl'] ?? '',
                                'opinion_person_position_en' => $decoded['opinion_person_position_en'] ?? '',
                                'opinion_text_pl'            => $decoded['opinion_text_pl'] ?? '',
                                'opinion_text_en'            => $decoded['opinion_text_en'] ?? '',
                                'opinions_order'             => $row->order ?? ''
                            ];

                            $order = $opinion['opinions_order'];
                            if (!empty($order)) {
                                if ($order == 99) {
                                    // dodaj na koniec tablicy (nie indeksowane po order)
                                    $opinions_indexed[] = $opinion;
                                } else {
                                    // normalnie indeksujemy po order
                                    $opinions_indexed[$order] = $opinion;
                                }
                            }
                        }
                    }
                }
            }

            // Final list for rendering – sorted by opinions_order (bez tych 99)
            ksort($opinions_indexed);

            // Build a score
            $opinions_to_render = [];

            // First, these are sorted out
            foreach ($opinions_indexed as $k => $op) {
                if (isset($op['opinions_order']) && $op['opinions_order'] != 99) {
                    $opinions_to_render[] = $op;
                }
            }

            // At the end all with order = 99
            foreach ($opinions_indexed as $k => $op) {
                if (isset($op['opinions_order']) && $op['opinions_order'] == 99) {
                    $opinions_to_render[] = $op;
                }
            }

                $output .= '
                <div id="pweOpinions" class="pwe-opinions">
                    <div class="pwe-posts-title main-heading-text">
                        <h4 class="pwe-opinions__title pwe-uppercase">'. self::languageChecker('REKOMENDACJE', 'RECOMMENDATIONS') .'</h4>
                    </div>
                    <div class="pwe-opinions__wrapper">
                        <div class="pwe-opinions__items swiper"> 
                            <div class="swiper-wrapper">';

                                foreach ($opinions_to_render as $opinion_item) {

                                    $opinions_face_img = $opinion_item['opinion_person_img'];
                                    $opinions_company_img = $opinion_item["opinion_company_img"];
                                    $opinions_company = PWECommonFunctions::lang_pl() ? $opinion_item['opinion_company_name_pl'] : $opinion_item['opinion_company_name_en'];
                                    $opinions_name = $opinion_item['opinion_person_name'];
                                    $opinions_desc = PWECommonFunctions::lang_pl() ? $opinion_item['opinion_person_position_pl'] : $opinion_item['opinion_person_position_en'];
                                    $opinions_text = PWECommonFunctions::lang_pl() ? $opinion_item['opinion_text_pl'] : $opinion_item['opinion_text_en'];

                                    $words = explode(' ', strip_tags($opinions_text));
                                    if (count($words) > 30) {
                                        $opinions_text = implode(' ', array_slice($words, 0, 30)) . '...';
                                    }

                                    $opinions_button = isset($opinion_item["opinions_button"]) ? $opinion_item["opinions_button"] : null;

                                    // // Splitting the text into 30 words and the rest
                                    // $words = explode(" ", $opinions_text);
                                    // if($opinions_remove_display_more_button){
                                    //     $short_text = $opinions_text;
                                    // } else {
                                    //     $short_text = implode(" ", array_slice($words, 0, 24));
                                    //     $remaining_text = implode(" ", array_slice($words, 24));
                                    // }

                                    if ($opinions_preset == 'preset_1') {
                                        $output .= '
                                        <div class="pwe-opinions__item swiper-slide">
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
                                                    <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                                    <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                                </div>
                                            </div>
                                            <div class="pwe-opinions__item-opinion">
                                                <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
                                                (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                                (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                            </div>
                                        </div>';
                                    } else if ($opinions_preset == 'preset_2') {
                                        $output .= '
                                        <div class="pwe-opinions__item swiper-slide">
                                            <div class="pwe-opinions__item-media">
                                                <div class="pwe-opinions__item-person-img">
                                                    <img data-no-lazy="1" src="' . $opinions_face_img . '">
                                                </div>
                                                <div class="pwe-opinions__item-company_logo">
                                                    <img data-no-lazy="1" src="' . $opinions_company_img . '">
                                                </div>
                                            </div>
                                            <div class="pwe-opinions__item-person-info">
                                                <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                                ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                                <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                            </div>
                                            <div class="pwe-opinions__item-opinion">
                                                <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
                                                (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                                (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                            </div>
                                        </div>';
                                    } else if ($opinions_preset == 'preset_3') {
                                        $output .= '
                                        <div class="pwe-opinions__item swiper-slide">';
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
                                                    <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                                    ' . (!empty($opinions_desc) ? '<h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>' : '<span></span>') . '
                                                    ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                                </div>
                                                <div class="pwe-opinions__item-opinion">
                                                    <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
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
                                        <div class="pwe-opinions__item swiper-slide">
                                            <div class="pwe-opinions__item-left">
                                                <div class="pwe-opinions__item-person-img">
                                                    <img data-no-lazy="1" src="' . $opinions_face_img . '">
                                                </div>
                                            </div>
                                            <div class="pwe-opinions__item-right">
                                                <div class="pwe-opinions__item-info-container">
                                                    <div class="pwe-opinions__item-person-info-container">
                                                        <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                                        <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
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
                                                    <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
                                                    (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                                    (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                                    <svg class="quote quote-left" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M119.472,66.59C53.489,66.59,0,120.094,0,186.1c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.135,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.829-6.389 c82.925-90.7,115.385-197.448,115.385-251.8C238.989,120.094,185.501,66.59,119.472,66.59z"></path> <path class="st0" d="M392.482,66.59c-65.983,0-119.472,53.505-119.472,119.51c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.136,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.828-6.389 C479.539,347.2,512,240.452,512,186.1C512,120.094,458.511,66.59,392.482,66.59z"></path> </g> </g></svg>
                                                </div>
                                            </div>
                                        </div>';
                                    } else if ($opinions_preset == 'preset_5') {
                                        $output .= '
                                        <div class="pwe-opinions__item swiper-slide">
                                            <div class="pwe-opinions__item-top">
                                                <div class="pwe-opinions__item-person-container">
                                                    <img data-no-lazy="1" src="' . $opinions_face_img . '">
                                                    <div class="pwe-opinions__item-person-info-container">
                                                        <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                                        <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                                    </div>
                                                </div>
                                                <div class="pwe-opinions__item-info-container">
                                                    <div class="pwe-opinions__item-company-info-container">
                                                        <div class="pwe-opinions__item-company_logo">
                                                            <img data-no-lazy="1" src="' . $opinions_company_img . '">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pwe-opinions__item-bottom">
                                                <div class="pwe-opinions__item-opinion">
                                                    <svg class="quote quote-right" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M119.472,66.59C53.489,66.59,0,120.094,0,186.1c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.135,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.829-6.389 c82.925-90.7,115.385-197.448,115.385-251.8C238.989,120.094,185.501,66.59,119.472,66.59z"></path> <path class="st0" d="M392.482,66.59c-65.983,0-119.472,53.505-119.472,119.51c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.136,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.828-6.389 C479.539,347.2,512,240.452,512,186.1C512,120.094,458.511,66.59,392.482,66.59z"></path> </g> </g></svg>
                                                    <div style="display: inline-block;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
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
                        </div>';
                        if ($opinions_scrollbar_display === 'true' || $opinions_arrows_display === 'true') {
                            $output .= '
                            <div class="swiper-navigation-container">';
                                if ($opinions_scrollbar_display === 'true') { $output .= '<div class="swiper-scrollbar"></div>'; }
                                $output .= '
                                <div class="swiper-arrows-container">';
                                    if ($opinions_arrows_display === 'true') { $output .= '
                                        <div class="swiper-button-prev"></div>
                                        <div class="swiper-button-next"></div>'; }
                                $output .= '
                                </div>
                            </div>';
                        }

                    $output .= '
                    </div>
                </div>';

            include_once plugin_dir_path(__FILE__) . '/../scripts/swiper.php';

            $output .= PWESwiperScripts::swiperScripts('opinions', '.pwelement_' . self::$rnd_id, $opinions_dots_display, $opinions_arrows_display, $opinions_scrollbar_display, $opinions_options, $opinions_breakpoints);

            $output .= '
            <script>
                jQuery(function ($) {

                    // Function to set equal height
                    function setEqualHeight() {
                        let maxHeight = 0;

                        // Reset the heights before calculations
                        $(".pwelement_'. self::$rnd_id .' .pwe-opinions__item").css("height", "auto");

                        // Calculate the maximum height
                        $(".pwelement_'. self::$rnd_id .' .pwe-opinions__item").each(function() {
                            const thisHeight = $(this).outerHeight();
                            if (thisHeight > maxHeight) {
                                maxHeight = thisHeight;
                            }
                        });

                        // Set the same height for all
                        $(".pwelement_'. self::$rnd_id .' .pwe-opinions__item").css("minHeight", maxHeight);
                    }

                    // Call the function after loading the slider
                    $(".pwelement_'. self::$rnd_id .' .pwe-opinions__items").on("init", function() {
                        setEqualHeight();
                    });

                    // Call the function when changing the slide
                    $(".pwelement_'. self::$rnd_id .' .pwe-opinions__items").on("afterChange", function() {
                        setEqualHeight();
                    });

                    // Call the function at the beginning
                    setEqualHeight();

                    $(".pwelement_'. self::$rnd_id .' #pweOpinions").css("visibility", "visible").animate({ opacity: 1 }, 500);
                });
            </script>';

        return $output;
    }

    public static function output($atts) {
        extract( shortcode_atts( array(
            'opinions_preset' => '',
            'opinions_dots_display' => '',
            'opinions_limit_width' => '',
            'opinions_items' => '',
            'opinions_remove_display_more_button' => '',
            'opinions_slider_type' => 'slick',
            'opinions_to_hide' => '',
        ), $atts ));

        if ($opinions_slider_type === 'swiper') {
            return self::outputOpinionsSwiper($atts);
        }

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
                .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text p {
                    font-size: 14px;
                    line-height: 1.3;
                    text-align: left;
                    display: inline-block;
                    margin: 0;
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
                        max-width: 50px;
                        aspect-ratio: 3 / 2;
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
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-speaker-info h4 {
                        width: 100%;
                        text-align: center;
                        font-size: 16px;
                        margin: 0 auto;
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
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text,
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-opinion-text p {
                        text-align: center;
                        font-size: 14px;
                        line-height: 1.3;
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
            }else if ($opinions_preset == 'preset_5') {
                $output .= '
                <style>
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item {
                        display: flex !important;
                        flex-direction: column;
                        box-shadow: 0 0 12px -6px black;
                        padding: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-top {
                        width: 100%;
                        height: 30%;
                        display: flex;
                        justify-content: space-between;
                        padding: 24px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container {
                        display: flex;
                        align-items: center;
                        gap: 18px;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container img{
                        object-fit: cover;
                        width: 100px;
                        border-radius: 50%;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-bottom {
                        width: 100%;
                        height: 70%;
                        padding: 24px;
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
                        font-size: 14px !important;
                        font-weight: 500;
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-info-name {
                        font-size: 20px;
                        font-weight: 700;
                        margin: 0;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company-info-container {
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: flex-end;
                        max-width: 200px;
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
                        width: 20px;
                        height: 20px;
                        fill: var(--accent-color);
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
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-top {
                            width: 100%;
                            flex-direction: column;
                            padding: 12px;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container {
                            flex-direction: column;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-bottom {
                            width: 100%;
                            padding: 18px;
                        }
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-person-container img{
                            width: 100%;
                            max-width: 160px;
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
                        .pwelement_'. self::$rnd_id .' .pwe-opinions__item-company_logo img {
                            max-width: 120px;
                        }
                    }
                </style>';
            }

            // $default_opinions = [

            //     [
            //         'opinions_face_img' => '/wp-content/plugins/pwe-media/media/default-opinions/Jerzy_Romanski.webp',
            //         'opinions_company_img' => '/wp-content/plugins/pwe-media/media/default-opinions/ofmisp-logo.webp',
            //         'opinions_company' => 'Ogólnopolska Federacja Małych i Średnich Przedsiębiorców',
            //         'opinions_name' => 'Jerzy Romański',
            //         'opinions_desc' => self::languageChecker('Wiceprezes', 'Vice President'),
            //         'opinions_text' => self::languageChecker(
            //             'Zbudowanie przyjaznej więzi pomiędzy organizatorem targów, firmą wystawiającą się i organizacjami wspierającymi jest kluczowe, by uniknąć błędów i w pełni wykorzystać potencjał wydarzenia.',
            //             'Building a friendly relationship between the trade fair organizer, the exhibiting company, and supporting organizations is key to avoiding mistakes and fully utilizing the potential of the event.')
            //     ],
            //     [
            //         'opinions_face_img' => '/wp-content/plugins/pwe-media/media/default-opinions/Krzysztof-Niczyporczuk.webp',
            //         'opinions_company_img' => '/wp-content/plugins/pwe-media/media/default-opinions/pio-logo.webp',
            //         'opinions_company' => 'Polska Izba Opakowań',
            //         'opinions_name' => 'Mgr inż. Krzysztof Niczyporuk',
            //         'opinions_desc' => '',
            //         'opinions_text' => self::languageChecker(
            //             'PTAK Warsaw Expo to wysokiej klasy organizator imprez targowych i konferencji. Polska Izba Opakowań pozytywnie ocenia współpracę z Ptak Warsaw Expo jako rzetelnym partnerem.',
            //             'PTAK Warsaw Expo is a high-quality organizer of trade fairs and conferences. The Polish Packaging Chamber positively evaluates cooperation with Ptak Warsaw Expo as a reliable partner.')
            //     ],
            //     [
            //         'opinions_face_img' => '/wp-content/plugins/pwe-media/media/default-opinions/Piotr-Fiejkiewicz.webp',
            //         'opinions_company_img' => '/wp-content/plugins/pwe-media/media/default-opinions/pts-logo.webp',
            //         'opinions_company' => 'POLSKIE TOWARZYSTWO STOMATOLOGICZNE',
            //         'opinions_name' => 'Piotr Flejszar',
            //         'opinions_desc' => self::languageChecker('Dyrektor Biura Zarządu', 'Director of the Management Office'),
            //         'opinions_text' => self::languageChecker(
            //             'PTAK Warsaw Expo jest największym centrum wystawienniczym, z jakim współpracujemy. Firma inwestuje w rozwój infrastruktury, co zwiększa jakość organizowanych wydarzeń.',
            //             'PTAK Warsaw Expo is the largest exhibition center we work with. The company invests in infrastructure development, which enhances the quality of organized events.')
            //     ],
            //     [
            //         'opinions_face_img' => '/wp-content/plugins/pwe-media/media/default-opinions/Pawel_Babski.webp',
            //         'opinions_company_img' => '/wp-content/plugins/pwe-media/media/default-opinions/kit-logo.webp',
            //         'opinions_company' => self::languageChecker('Krajowa Izba Targowa','National Chamber of Trade Fairs'),
            //         'opinions_name' => 'Paweł Babski',
            //         'opinions_desc' => self::languageChecker('Prezes', 'President'),
            //         'opinions_text' => self::languageChecker(
            //             'Nic nie zastąpi spotkania z producentem, wystawcą. Możliwość obserwowania i wpływania na kierunek, w którym rozwija się branża jest możliwa dzięki takim spotkaniom. Premierowe edycje targów dają właśnie taką możliwość.',
            //             'Nothing can replace a meeting with a manufacturer, an exhibitor. The possibility of observing and influencing the direction in which the industry is developing is possible thanks to such meetings. Premiere editions of trade fairs offer exactly that opportunity.')
            //     ]
            // ];

            // $edition = do_shortcode('[trade_fair_edition]');
            //     if (strpos(strtolower($edition) , "premier") !== false) {
            //         $premiere_edition_opinions = [
            //             [
            //                 'opinions_face_img' => '/wp-content/plugins/pwe-media/media/default-opinions/Marlena-Wronkowska.webp',
            //                 'opinions_company_img' => '/wp-content/plugins/pwe-media/media/default-opinions/wprost-logo.webp',
            //                 'opinions_company' => 'Wprost',
            //                 'opinions_name' => 'Marlena Wronkowska',
            //                 'opinions_desc' => self::languageChecker('Dyrektor Projektów Biznesowych', 'Director of Business Projects'),
            //                 'opinions_text' => self::languageChecker(
            //                     'Tygodnik „Wprost” z uznaniem odnosi się do premierowych wydarzeń targowych organizowanych w 2025 roku przez Ptak Warsaw Expo. Nowe inicjatywy, takie jak Clean Tech Expo, Composite Poland czy Wire Tech Poland, nie tylko wzbogacają kalendarz targowy, ale również odpowiadają na aktualne potrzeby poszczególnych branż, oferując platformę do prezentacji innowacyjnych rozwiązań i nawiązywania wartościowych kontaktów biznesowych.​ Ptak Warsaw Expo, poprzez organizację tych premierowych wydarzeń, potwierdza swoją pozycję jako lidera wśród centrów targowych w Europie Środkowo-Wschodniej, oferując platformę sprzyjającą rozwojowi innowacji i współpracy międzybranżowej.',
            //                     'The weekly magazine Wprost expresses appreciation for the premiere trade fair events organized in 2025 by Ptak Warsaw Expo. New initiatives such as Clean Tech Expo, Composite Poland, and Wire Tech Poland not only enrich the trade fair calendar but also respond to the current needs of specific industries by providing a platform for showcasing innovative solutions and fostering valuable business connections. By organizing these premiere events, Ptak Warsaw Expo reaffirms its position as a leader among trade fair centers in Central and Eastern Europe, offering an environment conducive to innovation and cross-industry collaboration.'
            //                 )
            //             ]
            //         ];

            //         $default_opinions = array_merge($default_opinions, $premiere_edition_opinions);

            //         $max_opinions = 5 + count($premiere_edition_opinions);
            //     } else {
            //         $no_premiere_edition_opinions = [
            //             [
            //                 'opinions_face_img' => '/wp-content/plugins/pwe-media/media/default-opinions/Radoslaw-Dziuba.webp',
            //                 'opinions_company_img' => '/wp-content/plugins/pwe-media/media/default-opinions/lukasiewicz-logo.webp',
            //                 'opinions_company' => 'Łukasiewicz – Łódzki Instytut Technologiczny',
            //                 'opinions_name' => 'dr Radosław Dziuba',
            //                 'opinions_desc' => self::languageChecker('Dyrektor Sieci Badawczej Łukasiewicz', 'Director of the Łukasiewicz Research Network'),
            //                 'opinions_text' => self::languageChecker(
            //                     'Ptak Warsaw Expo to partner, z którym wymieniamy się wiedzą i doświadczeniem w dziedzinach związanych z działalnością obydwu instytucji. Centrum targowo-wystawienniczym Ptak Warsaw Expo pozwala na nawiązywanie kluczowych kontaktów biznesowych, budowanie relacji z klientami oraz poznanie nowych trendów.',
            //                     'Ptak Warsaw Expo is a partner with whom we exchange knowledge and experience in areas related to the activities of both institutions. The Ptak Warsaw Expo exhibition center facilitates establishing key business contacts, building client relationships, and discovering new trends.'
            //                 )
            //             ]
            //         ];

            //         $default_opinions = array_merge($default_opinions, $no_premiere_edition_opinions);

            //     }

            //     $to_hide_raw = $opinions_to_hide ?? '';

            //     $companies_to_hide = array_map(function($val) {
            //         return mb_strtolower(trim($val));
            //     }, explode(',', $to_hide_raw));

            //     $default_opinions = array_filter($default_opinions, function ($opinion) use ($companies_to_hide) {
            //         return !in_array(mb_strtolower(trim($opinion['opinions_company'])), $companies_to_hide);
            //     });

            $edition = do_shortcode('[trade_fair_edition]');

            // Loading JSON with default opinions
            $opinions_file = 'https://mr.glasstec.pl/doc/pwe-opinions.json';
            $opinions_data = json_decode(file_get_contents($opinions_file), true);

            $default_opinions = $opinions_data['default'] ?? [];

            if (strpos(strtolower($edition), "premier") !== false) {
                $default_opinions = array_merge($default_opinions, $opinions_data['premiere'] ?? []);
            } else {
                $default_opinions = array_merge($default_opinions, $opinions_data['no_premiere'] ?? []);
            }

            // Index the default opinions_order
            $opinions_indexed = [];
            foreach ($default_opinions as $opinion) {
                $order = $opinion['opinions_order'] ?? null;
                if ($order) {
                    $opinions_indexed[$order] = $opinion;
                }
            }

            // Get opinions from the database
            $data = PWECommonFunctions::get_database_fairs_data_opinions(); 
            if (!empty($data)) {
                // If there are 2 opinions in the summary – overwrite
                if (count($data) >= 2) {
                    $opinions_indexed = []; 
                }

                foreach ($data as $row) {
                    if (!empty($row->data)) {
                        $decoded = json_decode($row->data, true);

                        if ($decoded) {
                            $opinion = [
                                'opinions_slug'              => $row->slug ?? '',
                                'opinion_person_img'         => !empty($decoded['opinion_person_img'])
                                    ? 'https://cap.warsawexpo.eu/public/uploads/domains/' . str_replace('.', '-', $_SERVER['HTTP_HOST']) . '/opinions/' . $row->slug . '/' . $decoded['opinion_person_img']
                                    : '',
                                'opinion_company_img'        => !empty($decoded['opinion_company_img'])
                                    ? 'https://cap.warsawexpo.eu/public/uploads/domains/' . str_replace('.', '-', $_SERVER['HTTP_HOST']) . '/opinions/' . $row->slug . '/' . $decoded['opinion_company_img']
                                    : '',
                                'opinion_company_name_pl'    => $decoded['opinion_company_name_pl'] ?? '',
                                'opinion_company_name_en'    => $decoded['opinion_company_name_en'] ?? '',
                                'opinion_person_name'        => $decoded['opinion_person_name'] ?? '',
                                'opinion_person_position_pl' => $decoded['opinion_person_position_pl'] ?? '',
                                'opinion_person_position_en' => $decoded['opinion_person_position_en'] ?? '',
                                'opinion_text_pl'            => $decoded['opinion_text_pl'] ?? '',
                                'opinion_text_en'            => $decoded['opinion_text_en'] ?? '',
                                'opinions_order'             => $row->order ?? ''
                            ];

                            $order = $opinion['opinions_order'];
                            if (!empty($order)) {
                                if ($order == 99) {
                                    // dodaj na koniec tablicy (nie indeksowane po order)
                                    $opinions_indexed[] = $opinion;
                                } else {
                                    // normalnie indeksujemy po order
                                    $opinions_indexed[$order] = $opinion;
                                }
                            }
                        }
                    }
                }
            }

            // Final list for rendering – sorted by opinions_order (bez tych 99)
            ksort($opinions_indexed);

            // Build a score
            $opinions_to_render = [];

            // First, these are sorted out
            foreach ($opinions_indexed as $k => $op) {
                if (isset($op['opinions_order']) && $op['opinions_order'] != 99) {
                    $opinions_to_render[] = $op;
                }
            }

            // At the end all with order = 99
            foreach ($opinions_indexed as $k => $op) {
                if (isset($op['opinions_order']) && $op['opinions_order'] == 99) {
                    $opinions_to_render[] = $op;
                }
            }

            $output .= '
            <div id="pweOpinions"class="pwe-opinions">
                <div class="pwe-posts-title main-heading-text">
                    <h3 class="pwe-opinions__title pwe-uppercase">'. self::languageChecker('REKOMENDACJE', 'RECOMMENDATIONS') .'</h3>
                </div>
                <div class="pwe-opinions__wrapper">
                    <div class="pwe-opinions__items pwe-slides">';

                    foreach ($opinions_to_render as $opinion_item) {

                        $opinions_face_img = $opinion_item['opinion_person_img'];
                        $opinions_company_img = $opinion_item["opinion_company_img"];
                        $opinions_company = PWECommonFunctions::lang_pl() ? $opinion_item['opinion_company_name_pl'] : $opinion_item['opinion_company_name_en'];
                        $opinions_name = $opinion_item['opinion_person_name'];
                        $opinions_desc = PWECommonFunctions::lang_pl() ? $opinion_item['opinion_person_position_pl'] : $opinion_item['opinion_person_position_en'];
                        $opinions_text = PWECommonFunctions::lang_pl() ? $opinion_item['opinion_text_pl'] : $opinion_item['opinion_text_en'];

                        $words = explode(' ', strip_tags($opinions_text));
                        if (count($words) > 30) {
                            $opinions_text = implode(' ', array_slice($words, 0, 30)) . '...';
                        }

                        $opinions_button = isset($opinion_item["opinions_button"]) ? $opinion_item["opinions_button"] : null;

                        // // Splitting the text into 30 words and the rest
                        // $words = explode(" ", $opinions_text);
                        // if($opinions_remove_display_more_button){
                        //     $short_text = $opinions_text;
                        // } else {
                        //     $short_text = implode(" ", array_slice($words, 0, 24));
                        //     $remaining_text = implode(" ", array_slice($words, 24));
                        // }

                        if ($opinions_preset == 'preset_1') {
                            $output .= '
                            <div class="pwe-opinions__item">
                                <div class="pwe-opinions__item-company">
                                    ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                    <div class="pwe-opinions__item-company_logo">
                                        <img data-no-lazy="1" src="' . $opinions_company_img . '" alt="Logo ' . $opinions_company . '">
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-person">
                                    <div class="pwe-opinions__item-person-img">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '" alt="Photo ' . $opinions_name . '">
                                    </div>
                                    <div class="pwe-opinions__item-person-info">
                                        <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                        <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-opinion">
                                    <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
                                    (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                    (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                </div>
                            </div>';
                        } else if ($opinions_preset == 'preset_2') {
                            $output .= '
                            <div class="pwe-opinions__item">
                                <div class="pwe-opinions__item-media">
                                    <div class="pwe-opinions__item-person-img">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '" alt="Photo ' . $opinions_name . '">
                                    </div>
                                    <div class="pwe-opinions__item-company_logo">
                                        <img data-no-lazy="1" src="' . $opinions_company_img . '" alt="Logo ' . $opinions_company . '">
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-person-info">
                                    <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                    ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                    <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                </div>
                                <div class="pwe-opinions__item-opinion">
                                    <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
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
                                        <img data-no-lazy="1" src="' . $opinions_company_img . '" alt="Logo ' . $opinions_company . '">
                                    </div>';
                                }

                                $output .= '
                                <div class="pwe-opinions__item-speaker-container">
                                    <div class="pwe-opinions__item-speaker-img">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '" alt="Photo ' . $opinions_name . '">
                                    </div>
                                    </div>

                                    <div class="pwe-opinions__item-speaker">
                                    <div class="pwe-opinions__item-speaker-info">
                                        <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                        ' . (!empty($opinions_desc) ? '<h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>' : '<span></span>') . '
                                        ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                    </div>
                                    <div class="pwe-opinions__item-opinion">
                                        <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
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
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '" alt="Photo ' . $opinions_name . '">
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-right">
                                    <div class="pwe-opinions__item-info-container">
                                        <div class="pwe-opinions__item-person-info-container">
                                            <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                            <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                        </div>
                                            <div class="pwe-opinions__item-company-info-container">
                                            <div class="pwe-opinions__item-company_logo">
                                                <img data-no-lazy="1" src="' . $opinions_company_img . '" alt="Logo ' . $opinions_company . '">
                                            </div>
                                            ' . (!empty($opinions_company) ? '<p class="pwe-opinions__item-company-name">' . $opinions_company . '</p>' : '<span></span>') . '
                                        </div>
                                    </div>
                                    <div class="pwe-opinions__item-opinion">
                                        <svg class="quote quote-right" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M119.472,66.59C53.489,66.59,0,120.094,0,186.1c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.135,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.829-6.389 c82.925-90.7,115.385-197.448,115.385-251.8C238.989,120.094,185.501,66.59,119.472,66.59z"></path> <path class="st0" d="M392.482,66.59c-65.983,0-119.472,53.505-119.472,119.51c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.136,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.828-6.389 C479.539,347.2,512,240.452,512,186.1C512,120.094,458.511,66.59,392.482,66.59z"></path> </g> </g></svg>
                                        <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
                                        (!empty($remaining_text) ? '<span class="pwe-opinions__item-opinion-text pwe-hidden-content" style="display: none;"> ' . $remaining_text . '</span>' : '') .
                                        (!empty($remaining_text) ? '<span style="display: block; margin-top: 6px; font-weight: 600;" class="pwe-opinions__item-opinion-text pwe-see-more">'. self::languageChecker('więcej...', 'more...') .'</span>' : '') . '
                                        <svg class="quote quote-left" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M119.472,66.59C53.489,66.59,0,120.094,0,186.1c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.135,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.829-6.389 c82.925-90.7,115.385-197.448,115.385-251.8C238.989,120.094,185.501,66.59,119.472,66.59z"></path> <path class="st0" d="M392.482,66.59c-65.983,0-119.472,53.505-119.472,119.51c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.136,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.828-6.389 C479.539,347.2,512,240.452,512,186.1C512,120.094,458.511,66.59,392.482,66.59z"></path> </g> </g></svg>
                                    </div>
                                </div>
                            </div>';
                        } else if ($opinions_preset == 'preset_5') {
                            $output .= '
                            <div class="pwe-opinions__item">
                                <div class="pwe-opinions__item-top">
                                    <div class="pwe-opinions__item-person-container">
                                        <img data-no-lazy="1" src="' . $opinions_face_img . '" alt="Photo ' . $opinions_name . '">
                                        <div class="pwe-opinions__item-person-info-container">
                                        <h4 class="pwe-opinions__item-person-info-name">' . $opinions_name . '</h4>
                                        <h4 class="pwe-opinions__item-person-info-desc">' . $opinions_desc . '</h4>
                                        </div>
                                    </div>
                                    <div class="pwe-opinions__item-info-container">
                                            <div class="pwe-opinions__item-company-info-container">
                                            <div class="pwe-opinions__item-company_logo">
                                                <img data-no-lazy="1" src="' . $opinions_company_img . '" alt="Logo ' . $opinions_company . '">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pwe-opinions__item-bottom">
                                    <div class="pwe-opinions__item-opinion">
                                        <svg class="quote quote-right" height="200px" width="200px" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path class="st0" d="M119.472,66.59C53.489,66.59,0,120.094,0,186.1c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.135,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.829-6.389 c82.925-90.7,115.385-197.448,115.385-251.8C238.989,120.094,185.501,66.59,119.472,66.59z"></path> <path class="st0" d="M392.482,66.59c-65.983,0-119.472,53.505-119.472,119.51c0,65.983,53.489,119.487,119.472,119.487 c0,0-0.578,44.392-36.642,108.284c-4.006,12.802,3.136,26.435,15.945,30.418c9.089,2.859,18.653,0.08,24.828-6.389 C479.539,347.2,512,240.452,512,186.1C512,120.094,458.511,66.59,392.482,66.59z"></path> </g> </g></svg>
                                        <div style="display: inline;" class="pwe-opinions__item-opinion-text">' . $opinions_text . ' </div>' .
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
            } else if ($opinions_preset == 'preset_5') {
                $output .= PWESliderScripts::sliderScripts('opinions-preset-5', '.pwelement_'. self::$rnd_id, $opinions_dots_display, $opinions_arrows_display, $slides_to_show = 2);
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
                        $(".pwelement_'. self::$rnd_id .' .pwe-opinions__item").css("height", "auto");

                        // Calculate the maximum height
                        $(".pwelement_'. self::$rnd_id .' .pwe-opinions__item").each(function() {
                            const thisHeight = $(this).outerHeight();
                            if (thisHeight > maxHeight) {
                                maxHeight = thisHeight;
                            }
                        });

                        // Set the same height for all
                        $(".pwelement_'. self::$rnd_id .' .pwe-opinions__item").css("minHeight", maxHeight);
                    }

                    // Call the function after loading the slider
                    $(".pwelement_'. self::$rnd_id .' .pwe-opinions__items").on("init", function() {
                        setEqualHeight();
                    });

                    // Call the function when changing the slide
                    $(".pwelement_'. self::$rnd_id .' .pwe-opinions__items").on("afterChange", function() {
                        setEqualHeight();
                    });

                    // Call the function at the beginning
                    setEqualHeight();

                    $(".pwelement_'. self::$rnd_id .' #pweOpinions").css("visibility", "visible").animate({ opacity: 1 }, 500);
                });
            </script>';

        return $output;
    }
}