<?php

/**
 * Class PWElementTwoCols
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementTwoCols extends PWElements {

    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        parent::__construct();
    }

    public function catalogFunctions() {
        require_once plugin_dir_path(__FILE__) . 'classes/catalog_functions.php';
    }

    public function pweProfileButtons() {
        require_once plugin_dir_path(__FILE__) . 'profile/classes/profile-buttons.php';
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
                'heading' => __('Background image', 'pwelement'),
                'param_name' => 'pwe_two_cols_backgroundimage',
                'param_holder_class' => 'backend-area-half-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Background heading', 'pwelement'),
                'param_holder_class' => 'backend-area-half-width',
                'param_name' => 'pwe_two_cols_heading',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Heading', 'pwelement'),
                'param_name' => 'pwe_two_cols_small_heading',
                'param_holder_class' => 'backend-area-half-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'textarea_raw_html',
                'group' => 'PWE Element',
                'heading' => __('Description', 'pwelement'),
                'param_name' => 'pwe_two_cols_text',
                'param_holder_class' => 'backend-textarea-raw-html backend-area-half-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Image src', 'pwelement'),
                'param_name' => 'pwe_two_cols_img_src',
                'param_holder_class' => 'backend-area-half-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Left button text', 'pwelement'),
                'param_name' => 'pwe_two_cols_button_left',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Right button text', 'pwelement'),
                'param_name' => 'pwe_two_cols_button_right',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Left button link', 'pwelement'),
                'param_name' => 'pwe_two_cols_link_left',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
              'type' => 'colorpicker',
              'group' => 'PWE Element',
              'heading' => __('Button left color', 'pwe_map'),
              'param_name' => 'pwe_two_cols_button_left_color',
              'description' => __('Button left custom color', 'pwe_map'),
              'param_holder_class' => 'backend-area-one-fourth-width',
              'save_always' => true,
              'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementTwoCols',
              ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Right button link', 'pwelement'),
                'param_name' => 'pwe_two_cols_link_right',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
              'type' => 'colorpicker',
              'group' => 'PWE Element',
              'heading' => __('Button right color', 'pwe_map'),
              'param_name' => 'pwe_two_cols_button_right_color',
              'description' => __('Button right custom color', 'pwe_map'),
              'param_holder_class' => 'backend-area-one-fourth-width',
              'save_always' => true,
              'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementTwoCols',
              ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Column reverse', 'pwelement'),
                'param_holder_class' => 'backend-area-one-fifth-width',
                'param_name' => 'pwe_two_cols_reverse',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Column reverse mobile', 'pwelement'),
                'param_holder_class' => 'backend-area-one-fifth-width',
                'param_name' => 'pwe_two_cols_reverse_mobile',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Show conference logo', 'pwelement'),
                'param_holder_class' => 'backend-area-one-fifth-width',
                'param_name' => 'pwe_two_cols_show_logocongres',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Show exhibitors logo', 'pwelement'),
                'param_holder_class' => 'backend-area-one-fifth-width',
                'param_name' => 'pwe_two_cols_show_exhibitors',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Show patrons logo', 'pwelement'),
                'param_holder_class' => 'backend-area-one-fifth-width',
                'param_name' => 'pwe_two_cols_show_mediapatrons',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Show media slider', 'pwelement'),
                'param_holder_class' => 'backend-area-one-fifth-width',
                'param_name' => 'pwe_two_cols_slider',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Background title in column', 'pwelement'),
                'param_holder_class' => 'backend-area-one-fifth-width',
                'param_name' => 'pwe_two_cols_title_in_row',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementTwoCols',
                ),
            ),
        );
        return $element_output;
    }

    public static function output($atts) {

        extract( shortcode_atts( array(
            'pwe_two_cols_heading'       => '',
            'pwe_two_cols_small_heading' => '',
            'pwe_two_cols_text'          => '',
            'pwe_two_cols_img_src'       => '',
            'pwe_two_cols_backgroundimage' => '',
            'pwe_two_cols_button_left'   => '',
            'pwe_two_cols_button_right'  => '',
            'pwe_two_cols_link_right'    => '',
            'pwe_two_cols_link_left'    => '',
            'pwe_two_cols_button_left_color' => '',
            'pwe_two_cols_button_right_color' => '',
            'pwe_two_cols_reverse'         => '',
            'pwe_two_cols_show_logocongres'=> '',
            'pwe_two_cols_show_exhibitors' => '',
            'pwe_two_cols_show_mediapatrons' => '',
            'pwe_two_cols_slider' => '',
            'pwe_two_cols_reverse_mobile' => '',
            'pwe_two_cols_title_in_row' => '',
        ), $atts ));

        $colas_text = PWECommonFunctions::decode_clean_content($pwe_two_cols_text);

        $pwe_two_cols_img_src = (!empty($pwe_two_cols_img_src)) ? $pwe_two_cols_img_src : '/wp-content/plugins/PWElements/media/poznaj-targi.jpg';

        $pwe_two_cols_button_left_color = (!empty($pwe_two_cols_button_left_color)) ? $pwe_two_cols_button_left_color : self::$fair_colors['Accent'];

        $pwe_two_cols_button_darker = self::adjustBrightness($pwe_two_cols_button_left_color, -30);

        $pwe_two_cols_button_right_color = (!empty($pwe_two_cols_button_right_color)) ? $pwe_two_cols_button_right_color : $pwe_two_cols_button_darker;

        $unique_id = rand(10000, 99999);
        $element_unique_id = 'twocols-' . $unique_id;

        if (PWECommonFunctions::lang_pl()) {
            $pwe_two_cols_button_right = (!empty($pwe_two_cols_button_right)) ? $pwe_two_cols_button_right : 'DOŁĄCZ DO NAS';
            $pwe_two_cols_button_left = (!empty($pwe_two_cols_button_left)) ? $pwe_two_cols_button_left : 'GALERIA';

            $pwe_two_cols_link_left = (!empty($pwe_two_cols_link_left)) ? $pwe_two_cols_link_left : '/galeria/';
            $pwe_two_cols_link_right = (!empty($pwe_two_cols_link_right)) ? $pwe_two_cols_link_right : '/rejestracja/';
        } else {
            $pwe_two_cols_button_right = (!empty($pwe_two_cols_button_right)) ? $pwe_two_cols_button_right : 'JOIN US';
            $pwe_two_cols_button_left = (!empty($pwe_two_cols_button_left)) ? $pwe_two_cols_button_left : 'GALLERY';

            $pwe_two_cols_link_left = (!empty($pwe_two_cols_link_left)) ? $pwe_two_cols_link_left : '/en/gallery/';
            $pwe_two_cols_link_right = (!empty($pwe_two_cols_link_right)) ? $pwe_two_cols_link_right : '/en/registration/';
        }

        /* Patroni */

        if($pwe_two_cols_show_mediapatrons || $pwe_two_cols_slider){
          $base_directory = '/doc/Logotypy/Rotator 2';
          $patronImages = PWEProfileButtons::getImagesFromDirectory($base_directory, $limit = 9);
          $logotypy = array_slice($patronImages, 0, 10);
        }

        /* End Patroni */

        /* Wystawcy */

        if($pwe_two_cols_show_exhibitors){

          $identification = do_shortcode('[trade_fair_catalog]');
          $exhibitors = ($identification) ? CatalogFunctions::logosChecker($identification, "PWECatalog10") : 0;

          $logotypy = array_map(function ($exhibitor) {
              return $exhibitor['URL_logo_wystawcy'];
          }, $exhibitors);

          $logotypy = array_slice($logotypy, 0, 10);
        }



      $output = '
      <style>
        .wpb_column:has(#'. $element_unique_id .'){
          padding-top:0 !important;
        }
        #'. $element_unique_id .' .info-image-container {
          display: flex;
          justify-content: center;
          gap: 25px;
          align-items: stretch;
        }

        #'. $element_unique_id .' .info-image-box,
        #'. $element_unique_id .' .info-text-box {
          display: flex;
          flex: 1;
          flex-direction: column;
          justify-content: space-between;
          position: relative;
          margin-bottom: 55px;
        }

        #'. $element_unique_id .' .info-image-box img {
          border-radius: 30px;
          height: 100%;
          object-fit: cover;
        }
        #'. $element_unique_id .' .info-text-box h2 {
          font-size:29px;
        }
        #'. $element_unique_id .' .info-text-box h6 {
          text-align: center;
          display: block;
          margin: 12px auto 8px;
          font-size: 13px;
        }
        #'. $element_unique_id .' .info-text-box .logo-kongres {
          max-width: 50%;
          margin: 0 auto;
          display: block;
        }
        #'. $element_unique_id .' .two-cols-logotypes {
          max-width: 500px;
          margin: 0 auto;
        }
        #'. $element_unique_id .' .two-cols-logotypes img {
          padding: 5px;
        }
        #'. $element_unique_id .' .akcent {
          background-color: '. $pwe_two_cols_button_left_color .'
        }

        #'. $element_unique_id .' .main-2 {
          background-color: '. $pwe_two_cols_button_right_color .'
        }

        #'. $element_unique_id .' a {
          color: white !important;
          min-width: 200px;
          padding: 10px 20px;
          display: block;
          margin: 0 auto;
          border-radius: 10px;
          margin-top: 20px;
          text-align: center;
          transition: all 0.3s ease-in-out;
          font-weight: 500;
        }
        #'. $element_unique_id .' .slick-dots {
            transform: scale(.7) !important;
            bottom: 0px !important;
        }
        #'. $element_unique_id .' .background-title {
          font-size: clamp(8rem, 15vw, 8rem);
          text-align: center;
          font-weight: 900;
          line-height: 1;
          white-space: nowrap;
          width: 100%;
          overflow: hidden;
          margin-top: 0px;
          color: '. $pwe_two_cols_button_left_color .';
          opacity: .5;
          text-align: center;
          text-transform: uppercase;
        }

        #'. $element_unique_id .' .main-2:hover {
          background-color: '. $pwe_two_cols_button_left_color .';
        }

        #'. $element_unique_id .' .akcent:hover {
          background-color: '. $pwe_two_cols_button_right_color .';
        }
        #'. $element_unique_id .' .background-image {
          display:flex;
          justify-content: center;
        }
        #'. $element_unique_id .' .background-image img {
          width: 100%;
        }
        #'. $element_unique_id .' .logo-exhibitors {
          padding: 15px;
          border-radius: 30px;
          -webkit-box-shadow: 4px 17px 30px -7px rgba(66, 68, 90, 1);
          -moz-box-shadow: 4px 17px 30px -7px rgba(66, 68, 90, 1);
          box-shadow: 4px 17px 30px -7px rgba(66, 68, 90, 1);
        }
        #'. $element_unique_id .' .logo-exhibitors div {
          display: flex;
          flex-wrap: wrap;
          justify-content: space-around;
        }
        #'. $element_unique_id .' .logo-exhibitors h3 {
          display: block;
          margin: 10px auto;
          font-size: 20px;
          text-transform: uppercase;
        }
        #'. $element_unique_id .' .logo-exhibitors div img {
          display:none;
        }
        #'. $element_unique_id .' .logo-exhibitors div img:nth-child(-n+9) {
          display: block;
          width: 30%;
          aspect-ratio: 3 / 2;
          object-fit: contain;
          height:auto;
        }
        #'. $element_unique_id .' .background-title-column {
          font-size: 69px !important;
          margin-bottom: -20px;
        }';
        if(!$pwe_two_cols_reverse){
        $output .= '
            #'. $element_unique_id .' .info-image-container {
              flex-direction: row-reverse;
            }
            ';
        }
      $output .='
        @media(max-width:1200px) {
          #'. $element_unique_id .' .background-title {
            font-size: 90px !important;
          }
          #'. $element_unique_id .' .background-title-column {
            font-size: 60px !important;
          }
        }

        @media(max-width:920px) {
          #'. $element_unique_id .' .logo-exhibitors div img:nth-child(-n+9) {
            width: 46%;
          }
          #'. $element_unique_id .' .info-image-container {
            flex-direction: column;
          }

          #'. $element_unique_id .' .background-title {
            font-size: 63px !important;
          }

          #'. $element_unique_id .' .info-image-box,
          #'. $element_unique_id .' .info-text-box {
            margin-bottom: 10px;
          }
        }';
        if(!$pwe_two_cols_reverse_mobile){
          $output .= '
            @media(max-width:920px){
              #'. $element_unique_id .' .info-image-container {
                flex-direction: column-reverse;
              }
            }
            ';
        }
        $output .= '
        @media(max-width:570px) {
          #'. $element_unique_id .' .background-title {
            font-size: 36px !important;
          }
          #'. $element_unique_id .' .info-text-box .logo-kongres {
            margin:15px auto !important;
          }
        }
      </style>';

      $output .= '

      <div id="'. $element_unique_id .'">';
        if($pwe_two_cols_heading && !$pwe_two_cols_title_in_row){
          $output .= '
            <div class="background-title">
              '. $pwe_two_cols_heading .'
            </div>';
        };
        if($pwe_two_cols_backgroundimage){
          $output .= '
            <div class="background-image">
              <img src="'. $pwe_two_cols_backgroundimage .'" />
            </div>';
        }
        $output .= '<div class="info-image-container">
          <div class="info-text-box">';
            if($pwe_two_cols_heading && $pwe_two_cols_title_in_row){
              $output .= '
                <div class="background-title background-title-column">
                  '. $pwe_two_cols_heading .'
                </div>';
            }
          $output .= '
            <div>
              <h2>'. $pwe_two_cols_small_heading .'</h2>
              '. $colas_text .'';

              /* logo kongres */
              if($pwe_two_cols_show_logocongres){
                $output .= '
                <img class="logo-kongres" src="/doc/kongres-color.webp" />';
              }

              /* slider */
              if($pwe_two_cols_slider){
                $output .= '
                  <h6>'. self::languageChecker('PATRONI I PARTNERZY', 'PATRONS AND PARTNERS') .'</h6>
                  <div class="two-cols-logotypes pwe-slides">';

                foreach ($logotypy as $logo) {
                    $output .= '<img data-no-lazy="1" src="' . htmlspecialchars($logo, ENT_QUOTES, 'UTF-8') . '" alt="Logo wystawcy"/>';

                }
                $output .= '</div>';
                include_once plugin_dir_path(__FILE__) . '/../scripts/slider.php';
                $output .= PWESliderScripts::sliderScripts('two-cols-logotypes', '#'. $element_unique_id, $opinions_dots_display = 'true', $opinions_arrows_display = false, 5);
              }

            $output .= '
            </div>
            <a class="main-2" href="'. $pwe_two_cols_link_right .'">'. $pwe_two_cols_button_right .'</a>
          </div>
          <div class="info-image-box">';

          /* Zdjęcie */
          if(!$pwe_two_cols_show_exhibitors && !$pwe_two_cols_show_mediapatrons){
            $output .= '<img data-no-lazy="1" src="'. $pwe_two_cols_img_src .'" />';
          }

          /* Wystawcy */
          if($pwe_two_cols_show_exhibitors){
            $output .= '<div class="logo-exhibitors">
              <h3>'. self::languageChecker('Wystawcy', 'Exhibitors') .'</h3> <div class="logotypes-container">';


            foreach ($logotypy as $logo) {

              $output .= '<img data-no-lazy="1" src="' . htmlspecialchars($logo, ENT_QUOTES, 'UTF-8') . '" alt="Logo wystawcy">';
            }
            $output .= '</div></div>';
          }

          /* Medialni */
          if($pwe_two_cols_show_mediapatrons){
            $output .= '<div class="logo-exhibitors">
              <h3>'. self::languageChecker('Patroni', 'Patrons') .'</h3><div class="logotypes-container">';

            foreach ($logotypy as $logo) {

              $output .= '<img data-no-lazy="1" src="' . htmlspecialchars($logo, ENT_QUOTES, 'UTF-8') . '" alt="Logo wystawcy">';
            }
            $output .= '</div></div>';
          }


          $output .= '
            <a class="akcent" href="'. $pwe_two_cols_link_left .'">'. $pwe_two_cols_button_left .'</a>
          </div>
        </div>
      </div>';



        return $output;
    }
}



