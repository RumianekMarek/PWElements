<?php 

/**
 * Class PWElementHomeGallery
 * Extends PWElements class and defines a pwe Visual Composer element for vouchers.
 */
class PWElementHomeGallery extends PWElements {
    public static $countdown_rnd_id;
    public static $today_date;

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();

        self::$countdown_rnd_id = rand(10000, 99999);
        self::$today_date = new DateTime();
        
        require_once plugin_dir_path(__FILE__) . 'countdown.php';
    }

    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Header text', 'pwelement'),
                'param_name' => 'header_text',
                'description' => __('Set up a pwe hader text'),
                'param_holder_class' => 'backend-textfield',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Registration button text', 'pwelement'),
                'param_name' => 'button_text',
                'description' => __('Set up a pwe button text'),
                'param_holder_class' => 'backend-textfield',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Registration button URL', 'pwelement'),
                'param_name' => 'button_url',
                'description' => __('Set up a pwe button url'),
                'param_holder_class' => 'backend-textfield',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'textarea',
                'group' => 'PWE Element',
                'heading' => __('Text for desktop', 'pwelement'),
                'param_name' => 'desktop_text',
                'description' => __('Set up a pwe desktop description'),
                'param_holder_class' => 'backend-textarea',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'textarea',
                'group' => 'PWE Element',
                'heading' => __('Text for mobile', 'pwelement'),
                'param_name' => 'mobile_text',
                'description' => __('Set up a pwe mobile description'),
                'param_holder_class' => 'backend-textarea',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Hide Button', 'pwelement'),
                'param_name' => 'hide_button',
                'description' => __('Turn on to hide registration button'),
                'param_holder_class' => 'backend-basic-checkbox',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Add timer', 'pwelement'),
                'param_name' => 'add_timer',
                'description' => __('Add countdown timer to element'),
                'param_holder_class' => 'backend-basic-checkbox',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('6 thumbnails', 'pwelement'),
                'param_name' => 'gallery_thumbnails_more',
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementHomeGallery',
                ),
                'save_always' => true,
                'admin_label' => true
            ),

        );
        return $element_output;
    }

    /**
     * Static private method to remove from JS out of date timer variables.
     *      * 
     * @param array @right_date array off only new timers
     */
    private static function mainText() {
        if(self::checkForMobile()){
            return self::languageChecker(
                <<<PL
                    [trade_fair_name] to wydarzenie branżowe, którego celem jest zgromadzenie czołowych firm, ekspertów technicznych i praktyków związanych z sektorem w Polsce i całym regionie środkowo wschodniej Europy.
                PL,
                <<<EN
                    [trade_fair_name_eng] is a industry event that aims to bring together leading companies, technical experts and practitioners from Poland and the entire Central and Eastern European region.
                EN
            );
        } else {
            return self::languageChecker(
                <<<PL
                    [trade_fair_name] to wydarzenie branżowe, którego celem jest zgromadzenie czołowych firm, ekspertów technicznych i praktyków związanych z sektorem w Polsce i całym regionie środkowo wschodniej Europy. Targi oferują doskonałą okazję do nawiązania relacji biznesowych, prezentacji innowacyjnych technologii oraz wymiany wiedzy i doświadczeń. [trade_fair_name] to miejsce, gdzie innowacje spotykają się z praktycznym zapotrzebowaniem, a potencjał branży jest wykorzystywany do maksimum.
                PL,
                <<<EN
                    [trade_fair_name_eng] is a industry event that aims to bring together leading companies, technical experts and practitioners from Poland and the entire Central and Eastern European region. The fair offers an excellent opportunity to establish business relationships, showcase innovative technologies and exchange knowledge and experience. [trade_fair_name_eng] is a place where innovation meets practical demand, and the potential of the industry is exploited to the maximum.
                EN
            );
        }
    }
    /**
     * Static private method to remove from JS out of date timer variables.
     *
     * @param array @right_date array off only new timers
     */
    public static function output($atts, $content = '') {
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important;';
        $btn_text_color = 'color:' . self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important; border-width: 0 !important;';
        $btn_color = 'background-color:' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black') . '!important;';
        $btn_shadow_color = 'box-shadow: 9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'white') . '!important;';
        $btn_border = 'border: 1px solid ' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';

        $gallery_title = ($atts['header_text'] != '') ? $atts['header_text'] : self::languageChecker('[trade_fair_desc]','[trade_fair_desc_eng]');

        extract( shortcode_atts( array('gallery_thumbnails_more' => ''), $atts ));

        if(self::checkForMobile()){
            $gallery_text = ($atts['mobile_text'] != '') ? $atts['mobile_text'] : self::mainText();
        } else {
            $gallery_text = ($atts['desktop_text'] != '') ? $atts['desktop_text'] : self::mainText();
        }

        $btn_gallery_text = ($atts['button_text'] != '') 
            ? $atts['button_text'] 
            : self::languageChecker(
                <<<PL
                    Zarejestruj się<span style="display: block; font-weight: 300;">Odbierz darmowy bilet</span>
                PL,
                <<<EN
                    Register<span style="display: block; font-weight: 300;">Get a free ticket</span>
                EN    
            );

        $btn_gallery_url = ($atts['button_text'] != '') ? $atts['button_text'] : self::languageChecker('/rejestracja/', '/en/registration/');

        $all_images = ($gallery_thumbnails_more == 'true') ? self::findAllImages('/doc/galeria/mini', 6) : self::findAllImages('/doc/galeria/mini', 4);

        $output = '';

        $output .= '
            <style>
            .pwelement_'. self::$rnd_id .' .pwe-btn {
                ' . $btn_text_color . '
                ' . $btn_color . '
                ' . $btn_shadow_color . '
                ' . $btn_border . '
                margin: auto 0; 
            }
            .pwelement_'. self::$rnd_id .' .pwe-btn:hover {
                color: #000000 !important;
                background-color: #ffffff !important;
                border: 1px solid #000000 !important;
            }
            .row-parent:has(.pwelement_'. self::$rnd_id .' .pwe-container-gallery) {
                background: ' . self::$accent_color . ';
                max-width: 100%;
                padding: 0 !important;
            }
            .pwelement_'. self::$rnd_id .' .pwe-gallery-wrapper {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 36px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-gallery-section {
                width: 100%;
                display: flex;
                justify-content: center;
                gap: 36px;
            }
            .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-wrapper, .pwe-gallery-desc-wrapper{
                width: 50%;
            }
            .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs {
                display: flex;
                flex-direction: column;
                width: 100%;
            }
            .pwelement_'. self::$rnd_id .' .pwe-gallery-desc {
                background-color: #eaeaea;
            }
            .pwelement_'. self::$rnd_id .' .pwe-gallery-desc-wrapper .pwe-btn-container, 
            .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-wrapper .pwe-btn-container {
                display: flex;
                justify-content: left;
                text-align: center;
            } 
            .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-top, 
            .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-bottom {
                display: flex;
                flex-wrap: wrap;
                width: 100%;
            }
            .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-top img, 
            .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-bottom img {
                width: 50%;
                padding: 5px;
            }
            @media (max-width: 960px) {
                .pwelement_'. self::$rnd_id .' .pwe-gallery-section {
                    flex-direction: column;
                }
                .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-wrapper {
                    width: 100%;
                }
                .pwelement_'. self::$rnd_id .' .pwe-gallery-desc-wrapper {
                    width: 100%;
                }
            }
            @media (max-width: 500px) {
                .pwelement_'. self::$rnd_id .' .pwe-gallery-desc-wrapper .pwe-btn-container, 
                .pwelement_'. self::$rnd_id .' .pwe-gallery-thumbs-wrapper .pwe-btn-container {
                    justify-content: center;
                }
            }
            </style>
            
            <div id="pweGallery" class="pwe-container-gallery style-accent-bg">
                <div class="pwe-gallery-wrapper double-bottom-padding single-top-padding">
                    <div class="pwe-row-border">
                        <div class="pwe-box-top-left-white"></div>
                    </div>
                    <div class="pwe-gallery-section">
                        <div class="pwe-gallery-thumbs-wrapper">
                            <div class="pwe-gallery-thumbs">
                                <div class="pwe-gallery-thumbs-top">
                                    <img class="mini-img" src="' . $all_images[0] . '" alt="mini galery picture">   
                                    <img class="mini-img" src="' . $all_images[1] . '" alt="mini galery picture">   
                                </div>
                                <div class="pwe-gallery-thumbs-bottom">';
                                    if ($gallery_thumbnails_more == 'true') {
                                        $output .='
                                            <img class="mini-img" src="' . $all_images[2] . '" alt="mini galery picture">
                                            <img class="mini-img" src="' . $all_images[3] . '" alt="mini galery picture"> 
                                            <img class="mini-img" src="' . $all_images[4] . '" alt="mini galery picture">
                                            <img class="mini-img" src="' . $all_images[5] . '" alt="mini galery picture">';
                                    } else {
                                        $output .='
                                            <img class="mini-img" src="' . $all_images[2] . '" alt="mini galery picture">
                                            <img class="mini-img" src="' . $all_images[3] . '" alt="mini galery picture">';
                                    }
                                    $output .='
                                </div>
                                <div class="pwe-btn-container gallery-link-btn">
                                    <span>'.
                                        self::languageChecker(
                                            <<<PL
                                                <a class="pwe-link btn pwe-btn" href="/galeria/" alt="link do galerii">Przejdź do galerii</a>
                                            PL,
                                            <<<EN
                                                <a class="pwe-link btn pwe-btn" href="/en/gallery/" alt="link to gallery">Go to gallery</a>
                                            EN
                                        )
                                .'</span>
                                </div>
                            </div>
                        </div>
            
                        <div class="pwe-gallery-desc-wrapper">
                            <div class="pwe-gallery-desc shadow-black">
                                <div class="pwe-gallery-desc-content single-block-padding pwe-align-left">
                                    <h3 style="margin: 0;"> ' .$gallery_title . ' </h3>
                                    <p>' . $gallery_text . '</p>';
                                    if ($atts['hide_button'] != 'true') {
                                        $output .= '<a style="margin-top: 18px;" class="pwe-link btn shadow-black btn-accent" href="' . $btn_gallery_url . '" alt="link do rejestracji">' . $btn_gallery_text . '</a>';
                                    }
                                $output .= '
                                </div>
                            </div>';
                            
                            if($atts['add_timer']){
                                $output .='<div class="uncode-wrapper uncode-countdown timer-countdown" id="timerToGallery">';
                                    $output .= PWElementMainCountdown::output($atts);
                                $output .= '</div>';
                            }
                            
                            $output .= '</div>
                        </div>
                    <div class="pwe-row-border">
                        <div class="pwe-box-bottom-right-white"></div>
                    </div>
                </div>
            </div>';

    return $output;
    }
}