<?php 

/**
 * Class PWEProfileCards
 * Extends PWEProfile class and defines a custom Visual Composer element.
 */
class PWEProfileCards extends PWEProfile {

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
                'type' => 'textfield',
                'heading' => esc_html__('Title'),
                'param_name' => 'profile_cards_title',
                'description' => __('Set title to diplay over the profiles'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'profile_type',
                    'value' => 'PWEProfileCards', 
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Single card min width', 'pwe_profile'),
                'param_name' => 'profile_min_width_cards',
                'save_always' => true,
                'admin_label' => true,
                'dependency' => array(
                    'element' => 'profile_type',
                    'value' => 'PWEProfileCards', 
                ),
            ),
            array(
                'type' => 'textfield',
                'heading' => __('Single card border radius', 'pwe_profile'),
                'param_name' => 'profile_border_radius_cards',
                'save_always' => true,
                'admin_label' => true,
                'dependency' => array(
                    'element' => 'profile_type',
                    'value' => 'PWEProfileCards', 
                ),
            ),
            array(
                'type' => 'colorpicker',
                'heading' => __('Hover background color', 'pwe_profile'),
                'param_name' => 'profile_hover_bg_cards',
                'save_always' => true,
                'admin_label' => true,
                'dependency' => array(
                    'element' => 'profile_type',
                    'value' => 'PWEProfileCards', 
                ),
            ),
            array(
                'type' => 'param_group',
                'heading' => __('Items', 'pwe_profile'),
                'param_name' => 'profile_items_cards',
                'dependency' => array(
                    'element' => 'profile_type',
                    'value' => 'PWEProfileCards', 
                ),
                'params' => array(
                    array(
                        'type' => 'dropdown',
                        'heading' => __('Title', 'pwe_profile'),
                        'param_name' => 'profile_title_select_cards',
                        'save_always' => true,
                        'admin_label' => true,
                        'value' => array(
                            'Custom' => 'custom',
                            'PROFIL ODWIEDZAJĄCEGO' => 'profile_title_visitors',
                            'PROFIL WYSTAWCY' => 'profile_title_exhibitors',
                            'ZAKRES BRANŻOWY' => 'profile_title_scope',
                        ),
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Custom title', 'pwe_profile'),
                        'param_name' => 'profile_title_custom_cards',
                        'save_always' => true,
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Icon', 'pwe_profile'),
                        'param_name' => 'profile_icon_cards',
                        'save_always' => true,
                    ),
                    array(
                      'type' => 'textarea_raw_html',
                      'group' => 'PWE Element',
                      'heading' => __('Text', 'pwelement'),
                      'param_name' => 'profile_cards',
                      'save_always' => true,
                      'dependency' => array(
                          'element' => 'pwe_element',
                          'value' => 'PWElementProfile',
                      ),
                  ),
                  array(
                      'type' => 'textarea_raw_html',
                      'group' => 'PWE Element',
                      'heading' => __('Show more text', 'pwelement'),
                      'param_name' => 'profile_show_more_cards',
                      'description' => __('Hidden text', 'pwelement'),
                      'param_holder_class' => 'backend-textarea-raw-html',
                      'save_always' => true,
                      'dependency' => array(
                          'element' => 'pwe_element',
                          'value' => 'PWElementProfile',
                      ),
                  ),
                ),
            ),
        );

        return $element_output;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts) {

        extract( shortcode_atts( array(
            'profile_cards_title' => '',
            'profile_items_cards' => '',
            'profile_hover_bg_cards' => '',
        ), $atts ));

        $profile_hover_bg_cards = !empty($profile_hover_bg_cards) ? $profile_hover_bg_cards : self::$accent_color;          

        $profile_border_radius_cards = (!empty($atts['profile_border_radius_cards'])) ? $atts['profile_border_radius_cards'] : '18px';
        $profile_min_width_cards = (!empty($atts['profile_min_width_cards'])) ? $atts['profile_min_width_cards'] : '100%';

        $profile_items_cards_json = PWECommonFunctions::json_decode($profile_items_cards);

        $output = '
        <style>
            .profile-cards-'. self::$rnd_id .' .profile_cards_title {
                display: flex;
                justify-content: center;
            }
            .profile-cards-'. self::$rnd_id .' .profile_cards_title h4 {
                margin: 0;
                text-align: center;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__main-container-cards {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                align-items: flex-start;
                gap: 36px;
                margin-top: 18px;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item {
                width: 100%;
                max-width: '. $profile_min_width_cards .';
                min-width: 280px;
                padding: 18px;
                border-radius: '. $profile_border_radius_cards .';
                background: white;
                transition: 0.6s ease;
                box-shadow: 0px 30px 60px -30px rgba(0, 0, 0, .45);
                flex: 0.5;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item:hover {
                background: '. $profile_hover_bg_cards .';
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-icon img{
                width: 60px;
                aspect-ratio: 1/1;
                margin: 0 18px;
                filter: brightness(0);
                transition: 0.6s ease;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item:hover .pwe-profiles__cards-icon img{
                filter: unset;
            }
                .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-icon svg {
                margin: 0 18px;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-icon svg path{
                fill: '. $profile_hover_bg_cards .';
                margin: 0 18px;
                transition: 0.6s ease;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item:hover .pwe-profiles__cards-icon svg path{
                fill: #ffffff;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-title{
                margin: 12px 18px;
                color: black;
                transition: 0.6s ease;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item li{
                color: black;
                transition: 0.6s ease;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item .pwe-see-more{
                color: black;
                transition: 0.6s ease;
                font-weight: 600;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item:hover .pwe-profiles__cards-title, .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item:hover li, .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item:hover .pwe-see-more{
                color: white !important;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-line{
                width: 30%;
                border-color: '. $profile_hover_bg_cards .';
                border-top-width: 3px;
                border-radius: 100px;
                height: 0;
                margin: 12px 18px !important;
                max-width: 100px;
                transition: 0.6s ease;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item:hover .pwe-profiles__cards-line{
                border-color: white;
            }
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-content-hidden ul{
                margin-top: 0;
            }
            @media(max-width:600px){
            .profile-cards-'. self::$rnd_id .' .pwe-profiles__cards-item {
                flex: 1;
            }
            }
        </style>';

        include 'profile-icons-svg.php';

        if (!empty($profile_cards_title)) {
            $output .= '
            <div class="profile_cards_title main-heading-text">
                <h4 class="pwe-uppercase"><span>'. $profile_cards_title .'</span></h4>
            </div>';
        }
        $output .= '
        <div class="pwe-profiles__main-container-cards">';

        foreach ($profile_items_cards_json as $profile_item) {
          $profile_icon_svg = '';
          $profile_title_select_cards = '';
          $profile_icons_cards_icon = '';

          $profile_icon_nmb_cards = $profile_item["profile_icon_cards"];
          $profile_icon_src_cards = wp_get_attachment_url($profile_icon_nmb_cards);  

          $profile_cards = $profile_item["profile_cards"];
          $profile_content_cards = self::decode_clean_content($profile_cards);

          $profile_cards1 = $profile_item["profile_show_more_cards"];
          $profile_show_more_cards = self::decode_clean_content($profile_cards1);

          if ($profile_item["profile_title_select_cards"] == 'profile_title_visitors') {
            $profile_id = "visitorProfile";
            $profile_title = (get_locale() == 'pl_PL') ? "Profil odwiedzającego" : "Visitor profile"; 
          } else if ($profile_item["profile_title_select_cards"] == 'profile_title_exhibitors') {
            $profile_id = "exhibitorProfile";
            $profile_title = (get_locale() == 'pl_PL') ? "Profil wystawcy" : "Exhibitor profile";
          } else if ($profile_item["profile_title_select_cards"] == 'profile_title_scope') {
            $profile_id = "industryScope";
            $profile_title = (get_locale() == 'pl_PL') ? "Zakres branżowy" : "Industry scope";
          } else {
            $profile_id = "customProfile-" . self::$rnd_id;
            $profile_title = $profile_item["profile_title_custom_cards"];
          }

          
          if ($profile_title_select_cards == 'custom') {
            $profile_icons_cards_icon = '';
        } else {
          $profile_icons_cards_icon = !empty($profile_icon_src_cards) ? '<img src="' . $profile_icon_src_cards . '" alt="Icon">' : $default_profile_icons_svg[$profile_item["profile_title_select_cards"]];
        }

          $text_color = 'black';
          $showMore = get_locale() == "pl_PL" ? "więcej..." : "more...";
        $output .= '
            <div class="pwe-profiles__cards-item">
                <div class="pwe-profiles__cards-icon">
                    ' . $profile_icons_cards_icon . '
                </div>
                <div class="pwe-profile-text">
                    <h5 class="pwe-profiles__cards-title">'. $profile_title .'</h5>
                    <hr class="pwe-profiles__cards-line">
                    <div class="pwe-profiles__cards-content-visable">
                        '. $profile_content_cards .'
                    </div>
                </div>
                <div class="pwe-profiles__cards-content-hidden" style="display: none; color: '. $text_color .';">
                    '. $profile_show_more_cards .'
                </div>';
                if (!empty($profile_show_more_cards)) {
                    $output .= '
                    <p class="pwe-see-more" style="cursor: pointer; color: '. $text_color .';">'. $showMore .'</p>';
                }
        $output .= '
            </div>';
        }
        $output .= '
        </div>
                    <script>
                jQuery(function ($) {
                    // Funkcja ustawiająca równą wysokość dla elementów w obrębie każdego wiersza
                    function setEqualHeightByRow() {
                        const items = $(".pwe-profiles__cards-item");
                        let rowItems = [];
                        let currentTop = 0;
                        let maxHeight = 0;

                        // Resetuj wysokości przed obliczeniem
                        items.css("height", "auto");

                        items.each(function () {
                            const $this = $(this);
                            const itemTop = $this.offset().top;

                            // Jeśli element jest w tym samym wierszu, dodaj do listy
                            if (itemTop === currentTop) {
                                rowItems.push($this);
                                const thisHeight = $this.outerHeight();
                                if (thisHeight > maxHeight) {
                                    maxHeight = thisHeight;
                                }
                            } else {
                                // Ustaw maksymalną wysokość dla elementów w poprzednim wierszu
                                rowItems.forEach(item => item.css("minHeight", maxHeight + "px"));

                                // Rozpocznij nowy wiersz
                                rowItems = [$this];
                                currentTop = itemTop;
                                maxHeight = $this.outerHeight();
                            }
                        });

                        // Ustaw maksymalną wysokość dla ostatniego wiersza
                        rowItems.forEach(item => item.css("minHeight", maxHeight + "px"));
                    }

                    // Wywołaj funkcję po załadowaniu strony
                    $(document).ready(setEqualHeightByRow);

                    // Wywołaj funkcję przy zmianie rozmiaru okna
                    $(window).resize(function () {
                        setEqualHeightByRow();
                    });
                });
            </script>';

        return $output;
    }
}