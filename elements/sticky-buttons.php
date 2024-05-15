<?php 

/**
 * Class PWElementStickyButtons
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementStickyButtons extends PWElements {

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
                'type' => 'colorpicker',
                'group' => 'PWE Element',
                'heading' => __('Background kolor (default akcent)', 'pwelement'),
                'param_name' => 'sticky_buttons_cropped_background',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Aspect ratio (default 21/9)', 'pwelement'),
                'param_name' => 'sticky_buttons_aspect_ratio',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Font size buttons (default 12px)', 'pwelement'),
                'param_name' => 'sticky_buttons_font_size',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Width buttons (default 170px)', 'pwelement'),
                'param_name' => 'sticky_buttons_width',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'PWE Element',
                'heading' => __('Background full size kolor (default white)', 'pwelement'),
                'param_name' => 'sticky_buttons_full_size_background',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Aspect ratio full size (default 1/1)', 'pwelement'),
                'param_name' => 'sticky_buttons_aspect_ratio_full_size',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Font size full size buttons (default 16px)', 'pwelement'),
                'param_name' => 'sticky_buttons_font_size_full_size',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Width full width buttons (default 170px)', 'pwelement'),
                'param_name' => 'sticky_full_width_buttons_width',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Hide all sections except the first one', 'pwelement'),
                'param_name' => 'sticky_hide_sections',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Show dropdown buttons', 'pwelement'),
                'param_name' => 'sticky_buttons_dropdown',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Show full size buttons', 'pwelement'),
                'param_name' => 'sticky_buttons_full_size',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'description' => __('Turn on full size images', 'pwelement'),
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Turn off auto scrolling', 'pwelement'),
                'param_name' => 'sticky_buttons_scroll',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'description' => __('Turn on full size images', 'pwelement'),
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'PWE Element',
                'heading' => __('Name parameter for sections & rows', 'pwelement'),
                'description' => __('Default "konferencja". Enter this name into a section or row as a class (Ex. link "domain/wydarzenia/?konferencja=szkolenie")', 'pwelement'),
                'param_name' => 'sticky_buttons_parameter',
                'param_holder_class' => 'backend-area-one-fourth-width',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementStickyButtons',
                ),
            ),
            array(
                'type' => 'param_group',
                'group' => 'PWE Element',
                'param_name' => 'sticky_buttons',
                'heading' => __('Buttons', 'pwelement'),
                'dependency' => array(
                  'element' => 'pwe_element',
                  'value' => 'PWElementStickyButtons',
                ),
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Select Image', 'pwelement'),
                        'param_name' => 'sticky_buttons_images',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Select Full Size Image', 'pwelement'),
                        'param_name' => 'sticky_buttons_full_size_images',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'colorpicker',
                        'heading' => __('Background color button', 'pwelement'),
                        'description' => __('Jeżeli jest dodatkowo dodany obrazek to ma większy priorytet', 'pwelement'),
                        'param_name' => 'sticky_buttons_color_bg',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Button text', 'pwelement'),
                        'param_name' => 'sticky_buttons_color_text',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Button link', 'pwelement'),
                        'param_name' => 'sticky_buttons_link',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Button id (PRZECZYTAJ!)', 'pwelement'),
                        'description' => __('Wpisując tutaj ID musisz dodać taki sam ID w elemencie który chcesz ukryć.', 'pwelement'),
                        'param_name' => 'sticky_buttons_id',
                        'save_always' => true,
                        'admin_label' => true
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
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';

        extract( shortcode_atts( array(
            'sticky_buttons' => '',
            'sticky_buttons_dropdown' => '',
            'sticky_buttons_full_size' => '',
            'sticky_buttons_cropped_background' => '',
            'sticky_buttons_full_size_background' => '',
            'sticky_buttons_aspect_ratio' => '',
            'sticky_buttons_aspect_ratio_full_size' => '',
            'sticky_hide_sections' => '',
            'sticky_buttons_font_size' => '',
            'sticky_buttons_font_size_full_size' => '',
            'sticky_buttons_width' => '',
            'sticky_full_width_buttons_width' => '',
            'sticky_buttons_parameter' => '',
            'sticky_buttons_scroll' => '',
        ), $atts ));   
        
        $sticky_buttons_width = ($sticky_buttons_width == '') ? '170px' : $sticky_buttons_width;
        $sticky_full_width_buttons_width = ($sticky_full_width_buttons_width == '') ? '170px' : $sticky_full_width_buttons_width;
        $sticky_buttons_font_size_full_size = ($sticky_buttons_font_size_full_size == '') ? '16px' : $sticky_buttons_font_size_full_size;
        $sticky_buttons_font_size = ($sticky_buttons_font_size == '') ? '12px' : $sticky_buttons_font_size; 

        $sticky_buttons_parameter = ($sticky_buttons_parameter == '') ? 'konferencja' : $sticky_buttons_parameter;

        $output = '
            <style>
                .pwelement_'.self::$rnd_id.' {
                    opacity: 0;
                    transition: opacity 0.3s ease;
                }
                #page-header {
                    position: relative;
                    z-index: 11;
                }
                .row-parent:has(.custom-container-sticky-buttons) {
                    padding: 0 !important;
                    max-width: 100% !important;
                }
                .custom-sticky-buttons-full-size, .custom-sticky-buttons-cropped {
                    position: relative;
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    padding: 28px 18px;
                    width: 100%;
                    gap: 24px;
                }
                .custom-sticky-buttons-full-size {
                    background-color: white;
                    z-index: 11;
                }
                .custom-sticky-buttons-cropped-container {
                    flex-direction: column;
                    width: 100%;
                    top: 0;
                    z-index: 10;
                }
                .custom-sticky-head-container {
                    padding: 10px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    text-align: center;
                    cursor: pointer;
                }
                .custom-sticky-head-container * {
                    margin: 0;
                }
                .custom-sticky-button-item {
                    text-align: center;
                    z-index: 8;

                    .active{
                        transform: scale(1.1);
                    }
                }
                .custom-sticky-buttons-cropped .custom-sticky-button-item {
                    max-width: ' . $sticky_buttons_width . ' !important;
                }
                .custom-sticky-buttons-full-size .custom-sticky-button-item {
                    max-width: ' . $sticky_full_width_buttons_width . ' !important;
                }
                .custom-sticky-button-item:hover {
                    transform: scale(1.1);
                }
                .custom-sticky-button-item span {
                    padding: 5px;
                }
                .custom-sticky-button-item img,
                .custom-sticky-button-item div {
                    border-radius: 8px;
                    width: 100%;
                    object-fit: cover;
                    cursor: pointer;
                    text-transform: uppercase;
                    font-size: 12px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    ' . $text_color . ';
                    font-weight: 600;
                }
                .custom-sticky-buttons-full-size .custom-sticky-button-item div {
                    font-size: ' . $sticky_buttons_font_size_full_size . ' !important;
                }
                .custom-sticky-buttons-cropped .custom-sticky-button-item div {
                    font-size: ' . $sticky_buttons_font_size . ' !important;
                }
                .custom-button-cropped {
                    aspect-ratio: 21/9;
                }
                .custom-button-full-size {
                    aspect-ratio: 1/1;
                }
                .custom-container-sticky-buttons .fa-chevron-down {
                    transition: 0.3s ease !important;
                }
                @media (max-width: 600px) {
                    .custom-sticky-buttons-full-size {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: center;
                        margin: 0 auto;
                        gap: 20px;
                    }
                    
                    .custom-sticky-buttons-cropped .custom-sticky-button-item {
                        max-width: 150px !important;
                    }
                    .custom-sticky-buttons-full-size .custom-sticky-button-item {
                        max-width: 150px !important;
                    }
                    .custom-sticky-button-item:hover {
                        transform: unset;
                    }
                }
                .custom-sticky-button-item {
                    transition: ease .3s;
                }
                .sticky-pin {
                    position: fixed !important;
                    top: 0;
                    right: 0;
                    left: 0;
                }
                .konferencja {
                    display: none;
                    scroll-margin-top: 36px;
                }
            </style>';

            if ($sticky_buttons_dropdown === "true") {
                $output .= '<style>
                                .custom-sticky-buttons-cropped:before {
                                    content: "";
                                    background-color: rgba(255, 255, 255, 0.1);
                                    width: 100%;
                                    height: 100%;
                                    position: absolute;
                                    top: 0;
                                    left: 0;
                                    z-index: 7;
                                }
                            </style>';
            }
            if ($sticky_buttons_full_size === "true") {
                $output .= '<style>
                                .custom-sticky-buttons-cropped-container {
                                    position: absolute;
                                }
                            </style>';
            }

            $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);

            $sticky_buttons_urldecode = urldecode($sticky_buttons);
            $sticky_buttons_json = json_decode($sticky_buttons_urldecode, true);

            $buttons_urls = array();
            $full_size_buttons_urls = array();
            $buttons_id = array();
            $buttons_links = array();

            $output .= '<div id="stickyButtons" class="custom-container-sticky-buttons">';
                if ($sticky_buttons_full_size === "true") {
                    $output .= '<div class="custom-sticky-buttons-full-size" background-color:'. $sticky_buttons_full_size_background .'!important;">';
                    
                    if (is_array($sticky_buttons_json)) {
                        foreach ($sticky_buttons_json as $sticky_button) {

                            $attachment_full_size_img_id = $sticky_button["sticky_buttons_full_size_images"];
                            $link = $sticky_button["sticky_buttons_link"];
                            $button_id = $sticky_button["sticky_buttons_id"];
                            $button_color = $sticky_button["sticky_buttons_color_bg"];
                            $button_text = $sticky_button["sticky_buttons_color_text"];
                            $image_full_size_url = wp_get_attachment_url($attachment_full_size_img_id);
                            $full_size_buttons_urls[] = $image_full_size_url;

                            $target_blank = (strpos($link, 'http') !== false) ? 'target="blank"' : '';

                            $section_id = str_replace("-btn", "", $button_id);

                            $output .= '<style>
                                #'. $section_id .' {
                                    opacity: 0;
                                }
                            </style>';


                            if (!empty($image_full_size_url)) {
                                if (!empty($link)) {
                                    $output .= '<div class="custom-sticky-button-item">
                                                    <a href="'. $link .'" '. $target_blank .'><img style="aspect-ratio:'. $sticky_buttons_aspect_ratio_full_size .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-full-size" src="' . esc_url($image_full_size_url) . '" alt="sticky-button-'. $attachment_full_size_img_id .'"></a>
                                                </div>';
                                } else {
                                    $output .= '<div class="custom-sticky-button-item">
                                                    <img style="aspect-ratio:'. $sticky_buttons_aspect_ratio_full_size .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-full-size" src="' . esc_url($image_full_size_url) . '" alt="sticky-button-'. $attachment_full_size_img_id .'">
                                                </div>';
                                }
                            } else {
                                if (!empty($link)) {
                                    $output .= '<div class="custom-sticky-button-item">
                                                    <a href="'. $link .'" '. $target_blank .'><div style="background-color:'. $button_color .'; aspect-ratio:'. $sticky_buttons_aspect_ratio_full_size .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-full-size"><span>'. $button_text .'</span></div></a>
                                                </div>';
                                } else {
                                    $output .= '<div class="custom-sticky-button-item">
                                                    <div style="background-color:'. $button_color .'; aspect-ratio:'. $sticky_buttons_aspect_ratio_full_size .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-full-size"><span>'. $button_text .'</span></div>
                                                </div>';
                                }
                            }
                        }
                    } else {
                        $output .= 'Invalid JSON data.';
                    }

                    $output .= '</div>';
                }
                $output .= '
                <div class="sticky custom-sticky-buttons-cropped-container">
                    <div class="custom-sticky-head-container style-accent-bg" background-color:'. $sticky_buttons_cropped_background .'!important">
                        <h4 class="custom-sticky-head-text" style="'. $text_color .' !important;">Wybierz kongres &nbsp;</h4>
                        <i class="fa fa-chevron-down fa-1x fa-fw" style="'. $text_color .' !important;"></i>
                    </div>
                    <div class="custom-sticky-buttons-cropped style-accent-bg" background-color:'. $sticky_buttons_cropped_background .'!important">';

                        if (is_array($sticky_buttons_json)) {
                            foreach ($sticky_buttons_json as $sticky_button) {

                                $attachment_img_id = $sticky_button["sticky_buttons_images"];
                                $link = $sticky_button["sticky_buttons_link"];
                                $button_id = $sticky_button["sticky_buttons_id"];
                                $button_color = $sticky_button["sticky_buttons_color_bg"];
                                $button_text = $sticky_button["sticky_buttons_color_text"];
                                $image_url = wp_get_attachment_url($attachment_img_id);
                                $buttons_urls[] = $image_url;
                                $buttons_colors[] = $button_color;
                                $buttons_id[] = $button_id;
                                $buttons_links[] = $link;

                                $target_blank = (strpos($link, 'http') !== false) ? 'target="blank"' : '';

                                $section_id = str_replace("-btn", "", $button_id);

                                $output .= '<style>
                                    #'. $section_id .' {
                                        opacity: 0;
                                    }
                                </style>';

                                if (!empty($image_url)) {
                                    if (!empty($link)) {
                                        $output .= '<div class="custom-sticky-button-item">';
                                            $output .= '<a href="'. $link .'" '. $target_blank .'><img style="aspect-ratio:'. $sticky_buttons_aspect_ratio .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-cropped" src="' . esc_url($image_url) . '" alt="sticky-button-'. $attachment_img_id .'"></a>';
                                        $output .= '</div>';
                                    } else {
                                        $output .= '<div class="custom-sticky-button-item">';
                                            $output .= ' <img style="aspect-ratio:'. $sticky_buttons_aspect_ratio .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-cropped" src="' . esc_url($image_url) . '" alt="sticky-button-'. $attachment_img_id .'">';
                                        $output .= '</div>';
                                    }
                                } else {
                                    if (!empty($link)) {
                                        $output .= '<div class="custom-sticky-button-item">';
                                            $output .= '<a href="'. $link .'"'. $target_blank .'><div style="background-color:'. $button_color .'; aspect-ratio:'. $sticky_buttons_aspect_ratio .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-cropped"><span>'. $button_text .'</span></div></a>';
                                        $output .= '</div>';
                                    } else {
                                        $output .= '<div class="custom-sticky-button-item">';
                                            $output .= '<div style="background-color:'. $button_color .'; aspect-ratio:'. $sticky_buttons_aspect_ratio .';" id="' . $button_id . '-btn" class="custom-image-button custom-button-cropped"><span>'. $button_text .'</span></div>';
                                        $output .= '</div>';
                                    }   
                                }
                            }
                        } else {
                            $output .= 'Invalid JSON data.';
                        }

                        if ($mobile == 1) {
                            // $output .= '<style>.custom-sticky-buttons-cropped {gap: 10px;}</style>';
                            // if (count($buttons_urls) > 3) {
                                $sticky_buttons_dropdown = "true";
                            // }
                        }    

                        $output .= '</div>
                    </div>
                </div>';

            $buttons_id_json = json_encode($buttons_id);
            $buttons_links_json = json_encode($buttons_id);

            $buttons_cropped_image = json_encode($buttons_urls);
            $buttons_cropped_color = json_encode($buttons_colors);

            $output .= '<script>

                window.onload = function() {
                    const pweElement = document.querySelector(".pwelement_'.self::$rnd_id.'");
                    const stickyScroll = "'. $sticky_buttons_scroll .'";
                    const btnLinks = ' . json_encode($buttons_links_json) . ';
                    const btnsId = ' . json_encode($buttons_id_json) . ';
                    const stickyButtonsDropdown = ' . json_encode($sticky_buttons_dropdown) . ';
                    const stickyButtonsFullSize = ' . json_encode($sticky_buttons_full_size) . ';
                    const tilesCroppedContainer = pweElement.querySelector(".custom-sticky-buttons-cropped-container");
                    const tilesCropped = pweElement.querySelector(".custom-sticky-buttons-cropped");
                    const tilesFullSize = pweElement.querySelector(".custom-sticky-buttons-full-size");
                    const stickyHeadContainer = pweElement.querySelector(".custom-sticky-head-container");
                    const containerMasthead = document.querySelector("#masthead .menu-container");
                    const containerPageHeader = document.querySelector("#page-header");
                    const containerCustomHeader = document.querySelector("#pweHeader");
                    const adminBar = document.querySelector("#wpadminbar");
                    const desktop = ' . json_encode($mobile === 0) . ';
                    const mobile = ' . json_encode($mobile === 1) . ';
                    
                    pweElement.style.opacity = 1;

                    const hideElement = (element) => {
                        element.style.display = "none";
                    };
                    const showElement = (element, displayValue = "flex") => {
                        element.style.display = displayValue;
                    };
                    const setElementPosition = (element, position) => {
                        element.style.position = position;
                    };

                    const buttonsCroppedImage = ' . $buttons_cropped_image . ';
                    const buttonsCroppedColor = ' . $buttons_cropped_color . ';
                    const combinedArray = buttonsCroppedImage.concat(buttonsCroppedColor);
                    if (combinedArray.every(value => value === false || value === "")) {
                        hideElement(tilesCroppedContainer);
                    }

                    if (stickyButtonsDropdown !== "true") {
                        hideElement(stickyHeadContainer);
                        if (stickyButtonsFullSize === "true") { // dropdown on full size on
                            setElementPosition(tilesCroppedContainer, "absolute");
                            showElement(tilesCropped);
                            showElement(tilesFullSize);
                        } else { // dropdown on full size off
                            showElement(tilesCropped);
                        }
                    } else if (stickyButtonsDropdown === "true") {
                        showElement(stickyHeadContainer);
                        if (stickyButtonsFullSize === "true") { // dropdown off full size on
                            setElementPosition(tilesCroppedContainer, "absolute");
                            showElement(stickyHeadContainer);
                            hideElement(tilesCropped);
                            showElement(tilesFullSize);
                        } else { // dropdown off full size off
                            showElement(tilesCroppedContainer);
                            
                        }
                    }

                    const stickyElement = document.querySelector(".sticky");
                    const stickyClass = "sticky-pin";
                    let stickyPos;
                    let stickyHeight;

                    // Create a negative margin to prevent content "jumps":
                    var jumpPreventDiv = document.createElement("div");
                    jumpPreventDiv.className = "jumps-prevent";
                    stickyElement.parentNode.insertBefore(jumpPreventDiv, stickyElement.nextSibling);

                    if (containerMasthead && desktop) {
                        stickyPos = stickyElement.getBoundingClientRect().top + window.scrollY - containerMasthead.offsetHeight;
                    } else {
                        stickyPos = stickyElement.getBoundingClientRect().top + window.scrollY;
                    }
                    function jumpsPrevent() {
                        stickyHeight = stickyElement.offsetHeight;
                        stickyElement.style.marginBottom = "-" + stickyHeight + "px";
                        stickyElement.nextElementSibling.style.paddingTop = stickyHeight + "px";
                    }
                    if (!tilesFullSize) {
                        jumpsPrevent(); // Run

                        // Function trigger:
                        window.addEventListener("resize", function () {
                            jumpsPrevent();
                        });
                    }
                    
                    // Sticker function:
                    function stickerFn() {
                        const isStuckMasthead = document.querySelector("#masthead").classList.contains("is_stuck");
                        const stickyElementFixed = document.querySelector(".sticky-pin");
                        const winTop = window.scrollY;
                        // Check element position:
                        if (winTop >= stickyPos) {
                            stickyElement.classList.add(stickyClass);
                            if (stickyElement) {
                                if (containerMasthead && adminBar && desktop) {
                                    stickyElement.style.top = containerMasthead.offsetHeight + adminBar.offsetHeight + "px";
                                } else if (containerMasthead && !adminBar && desktop) {
                                    stickyElement.style.top = containerMasthead.offsetHeight + "px";
                                } else if (isStuckMasthead && mobile) {
                                    stickyElement.style.top = containerMasthead.offsetHeight + "px";
                                } else {
                                    stickyElement.style.top = "0px";
                                }
                            }
                        } else {
                            stickyElement.classList.remove(stickyClass);
                            if (tilesFullSize) {
                                stickyElement.style.top = "0px";
                            }
                        }
                    }

                    stickerFn(); // Run

                    // Function trigger:
                    window.addEventListener("scroll", function () {
                        stickerFn();
                    });

                    if (btnsId && typeof btnsId === "string") {
                        try {
                            const btnsIdArray = JSON.parse(btnsId);
                            if (Array.isArray(btnsIdArray)) {
                                btnsIdArray.forEach(function(btnId) {
                                    const trimmedBtnId = btnId.trim();
                                    const vcRow = document.getElementById(trimmedBtnId);
                                    vcRow.classList.add("sticky-section");
                                    if (vcRow) {
                                        vcRow.classList.add("hide-section");
                                    }
                                });
                            } else {
                                console.error("Nie udało się przekształcić btnsId w tablicę.");
                            }
                        } catch (error) {
                            console.error("Błąd podczas parsowania JSON w btnsId:", error);
                        }
                    }

                    if (btnsId !== "") {
                        document.querySelectorAll(".custom-image-button").forEach(function(button, index) {

                            button.style.transition = ".3s ease";

                            var hideSections = document.querySelectorAll(".page-wrapper .vc_row.row-container.hide-section");

                            // Ukrywamy wszystkie sekcje oprócz pierwszej
                            if ("' . $sticky_hide_sections . '" === "true") {
                                for (var i = 1; i < hideSections.length; i++) {
                                    hideSections[i].style.display = "none";
                                }
                                if (index === 0 && button) {
                                    button.style.transform = "scale(1.1)";
                                }
                            } else {
                                for (var i = 0; i < hideSections.length; i++) {
                                    hideSections[i].style.display = "none";
                                }
                            }
                            
                            button.addEventListener("click", function() {
                                var targetId = button.id.replace("-btn", "");

                                // Ukrywamy wszystkie elementy .vc_row.row-container
                                hideSections.forEach(function(section) {
                                    section.style.display = "none";
                                });
                                
                                // Wyświetlamy elementy
                                var targetElement = document.getElementById(targetId);
                                if (targetElement) {
                                    targetElement.style.display = "block";
                                }
                                
                                if (button) {
                                    button.style.transform = "scale(1.1)";
                                }
                                document.querySelectorAll(".custom-image-button").forEach(function(otherButton) {
                                    if (otherButton !== button) {
                                        otherButton.style.transform = "scale(1)";
                                    }
                                });
                            });
                            
                        });
                    }

                    if (stickyScroll !== "true") {
                        document.querySelectorAll(".custom-image-button").forEach(function(button) {
                            let customScrollTop;
                
                            if (containerPageHeader) {
                                customScrollTop = containerPageHeader.offsetHeight;
                            } else if (containerCustomHeader) {
                                customScrollTop = containerCustomHeader.offsetHeight;
                            } else {
                                customScrollTop = 0;
                            }

                            customScrollTop += pweElement.offsetHeight;
            
                            if (document.querySelectorAll("header.menu-transparent").length > 0 && desktop) {
                                customScrollTop -= containerMasthead.offsetHeight;
                            }
            
                            customScrollTop += "px";
                            
                            const scrollTopValue = parseInt(customScrollTop);
                            button.addEventListener("click", function() {
                                window.scrollTo({ top: scrollTopValue, behavior: "smooth" });
                                // button.scrollIntoView({ behavior: "smooth" });
                            });
                        });
                    }
                    
                    if (stickyButtonsDropdown === "true") {

                        jQuery(document).ready(function($) {
                            var $congressMenuSlide = $(".custom-sticky-buttons-cropped-container");

                            // Funkcja do sprawdzania, czy kliknięcie/najechanie nastąpiło poza .custom-container-sticky-buttons
                            $(document).on("click", function (event) {
                                if (!$(event.target).closest(".custom-sticky-buttons-cropped-container").length) {
                                    $(".custom-sticky-buttons-cropped").slideUp();
                                    $(".custom-sticky-buttons-cropped-container .custom-sticky-head-container i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
                                }
                            });

                            // Obsługa kliknięcia w .custom-sticky-head-container
                            $congressMenuSlide.find(".custom-sticky-head-container").click(function () {
                                toggleMenu($(this));
                            });

                            function toggleMenu($container) {
                                $container.closest(".custom-sticky-buttons-cropped-container").find(".custom-sticky-buttons-cropped").slideToggle();
                                $container.find("i").toggleClass("fa-chevron-down fa-chevron-up");
                            }

                            // Obsługa zmiany rozmiaru okna przeglądarki
                            $(window).on("resize", function () {
                                if ($(window).width() >= 1300) {
                                    $congressMenuSlide.find(".custom-sticky-head-container").off("mouseenter"); // Wyłącz poprzedni event handler
                                    $congressMenuSlide.find(".custom-sticky-head-container").mouseenter(function () {
                                        if (!$(this).closest(".custom-sticky-buttons-cropped-container").find(".custom-sticky-buttons-cropped").is(":visible")) {
                                            toggleMenu($(this));
                                        }
                                    });
                                } else {
                                    $congressMenuSlide.find(".custom-sticky-head-container").off("mouseenter"); // Wyłącz event handler dla węższego ekranu
                                }
                            });

                            // Obsługa przewijania strony
                            $(window).on("scroll", function() {
                                $(".custom-sticky-buttons-cropped").slideUp();
                                $(".custom-sticky-buttons-cropped-container .custom-sticky-head-container i").removeClass("fa-chevron-up").addClass("fa-chevron-down");
                            });
                        });

                    } else {
                        document.querySelector(".custom-sticky-head-container").style.display = "none";
                        
                    }

                    const stickySections = document.querySelectorAll(".sticky-section");
                    stickySections.forEach(function (section) {
                        section.style.opacity = 1;  
                    })

                }

                // Parameter for anchor
                function handleQueryParam() {
                    setTimeout(() => {
                        // Get the parameter from the current URL
                        var urlParams = new URLSearchParams(window.location.search);
                        var conferenceParam = urlParams.get("'. $sticky_buttons_parameter .'");

                        // Check if parameter exists
                        if (conferenceParam) {
                            // Show elements class with the appropriate id, hide the rest
                            var allElements = document.querySelectorAll(".'. $sticky_buttons_parameter .'");
                            allElements.forEach(function (element) {
                                if (element.id === conferenceParam) {
                                    element.style.display = "block";
                                    element.classList.remove("hide-section");
                                    setTimeout(() => {
                                        element.style.opacity = 1;  
                                    }, 100);
                                    if ("'. $sticky_buttons_scroll .'" !== "true") {
                                        // Scroll to the element with id from the anchor
                                        element.scrollIntoView({ behavior: "smooth" });
                                    }
                                } else {
                                    element.style.display = "none"; 
                                }
                            });

                            // Add a .active class to the element with anchor id + -btn
                            var activeBtn = document.getElementById(conferenceParam + "-btn");
                            if (activeBtn) {
                                activeBtn.classList.add("active");
                            }
                        }
                    }, 500);
                }

                // Call the handler function when the page is loaded
                document.addEventListener("DOMContentLoaded", handleQueryParam);
                // Listen for changes to the conference parameter in the URL
                window.addEventListener("popstate", handleQueryParam);

            </script>';

        return $output;

    }
}

?>
