<?php 

/**
 * Class PWEDisplayInfoBox
 * Extends PWEDisplayInfo class and defines a custom Visual Composer element.
 */
class PWEDisplayInfoBox extends PWEDisplayInfo {

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
                'group' => 'main',
                'heading' => __('Custom Id', 'pwe_display_info'),
                'param_name' => 'lecture_id',
                'description' => __('Custom ID will by added to main lecture ID.', 'pwe_display_info'),
                'admin_label' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'main',
                'heading' => __('Simple form', 'pwe_display_info'),
                'param_name' => 'simple_mode',
                'description' => __('To display in simpler form.', 'pwe_display_info'),
                'admin_label' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'main',
                'heading' => __('Title', 'pwe_display_info'),
                'param_name' => 'event_title',
                'save_always' => true,
                'admin_label' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'main',
                'heading' => __('Event time', 'pwe_display_info'),
                'param_name' => 'event_time',
                'save_always' => true,
                'admin_label' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textarea_html',
                'group' => 'main',
                'heading' => __('Description', 'pwe_display_info'),
                'param_name' => 'content',
                'description' => __('Put event description.', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'heading' => __('Speakers', 'pwe_display_info'),
                'group' => 'main',
                'type' => 'param_group',
                'param_name' => 'speakers',
                'save_always' => true,
                'params' => array(
                    array(
                        'type' => 'attach_image',
                        'heading' => __('Select Speaker Image', 'pwe_display_info'),
                        'param_name' => 'speaker_image',
                        'description' => __('Choose speaker image from the media library.', 'pwe_display_info'),
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Speaker Name', 'pwe_display_info'),
                        'param_name' => 'speaker_name',
                        'save_always' => true,
                        'admin_label' => true,
                    ),
                    array(
                        'type' => 'textarea',
                        'heading' => __('Bio', 'pwe_display_info'),
                        'param_name' => 'speaker_bio',
                    ),
                ),
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'options',
                'heading' => __('Border Radius', 'pwe_display_info'),
                'param_name' => 'border_radius',
                'description' => __('Outside border radius(px or %).', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'options',
                'heading' => __('Border Width', 'pwe_display_info'),
                'param_name' => 'border_width',
                'description' => __('Outside border width.', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'options',
                'heading' => __('Border Style', 'pwe_display_info'),
                'param_name' => 'border_style',
                'description' => __('Outside style (example -> solid).', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('Border Color', 'pwe_display_info'),
                'param_name' => 'border_color',
                'description' => __('Outside border color.', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('Lecturers color', 'pwe_display_info'),
                'param_name' => 'lect_color',
                'description' => __('Color for lecturers names.', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'options',
                'heading' => __('Shadow', 'pwe_display_info'),
                'param_name' => 'shadow',
                'description' => __('Check to display shadow. ONLY full catalog.', 'pwe_display_info'),
                'admin_label' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('Tile Color', 'pwe_display_info'),
                'param_name' => 'title_color',
                'description' => __('Color for buton lecture Title.', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'options',
                'heading' => __('Tile size', 'pwe_display_info'),
                'param_name' => 'title_size',
                'description' => __('Title font size.', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'options',
                'heading' => __('Tittle on top', 'pwe_display_info'),
                'param_name' => 'title_top',
                'description' => __('Check to move Title to top of Lecturers.', 'pwe_display_info'),
                'admin_label' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textarea',
                'group' => 'pop-UP',
                'heading' => __('Modal info for pictures', 'pwe_display_info'),
                'param_name' => 'event_modal',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'options',
                'heading' => __('BIO Img size', 'pwe_display_info'),
                'param_name' => 'modal_img_size',
                'description' => __('Size of the Img for "BIO" description. max 300px', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('BIO BTN Color', 'pwe_display_info'),
                'param_name' => 'bio_color',
                'description' => __('Color for buton "BIO".', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('BIO BTN Text Color', 'pwe_display_info'),
                'param_name' => 'bio_text',
                'description' => __('Color for text on buton "BIO" .', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'options',
                'heading' => __('Photo/Bio box', 'pwe_display_info'),
                'param_name' => 'photo_box',
                'description' => __('Check to show Photo/Bio box at left side.', 'pwe_display_info'),
                'admin_label' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
                ),
                ),
            array(
                'type' => 'checkbox',
                'group' => 'options',
                'heading' => __('Photo as square', 'pwe_display_info'),
                'param_name' => 'photo_squer',
                'description' => __('Check to show photos as square.', 'pwe_display_info'),
                'admin_label' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoBox',
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
    private static function speakerImageMini($speakers_images) {
        if (count($speakers_images) < 1){
            $speaker_html = '<div class="speakers"></div>';
        } else {
            $speaker_html = '<div class="speakers-img">';
            $haed_images = array_filter($speakers_images);
            $haed_images = array_values($haed_images);

            for ($i = 0; $i < count($haed_images); $i++) {    
                        
                if (isset($haed_images[$i])) {
                    $image_src = wp_get_attachment_image_src($haed_images[$i], 'full');

                    
                    if ($image_src) {
                        if (!$photo_squer){
                            $b_radius = 'border-radius: 50%;';
                        }
                        $z_index = (1 + $i);
                        $margin_top_index = '';
                        
                        $max_width_index = "35%";
                        
                        switch (count($haed_images)) {
                            case 1:
                                $top_index = "unset";
                                $left_index = "unset";
                                $max_width_index = "80%";
                                break;
                        
                            case 2:
                                switch ($i) {
                                    case 0:
                                        $margin_top_index = "margin-top : 20px";
                                        $max_width_index = "50%";
                                        $top_index = "-30px";
                                        $left_index = "10px";
                                        break;
                        
                                    case 1:
                                        $max_width_index = "50%";
                                        $top_index = "-10px";
                                        $left_index = "-10px";
                                        break;
                                }
                                break;
                        
                            case 3:
                                switch ($i) {
                                    case 0:
                                        $top_index = "15px";
                                        $left_index = "unset";
                                        break;
                        
                                    case 1:
                                        $top_index = "40px";
                                        $left_index = "-15px";
                                        break;
                        
                                    case 2:
                                        $top_index = "-15px";
                                        $left_index = "-30px";
                                        break;
                                }
                                break;
                            default:
                                switch ($i) {
                                    case 0:
                                        $margin_top_index = 'margin-top: 5px !important;';
                                        break;
                        
                                    case 1:
                                        $left_index = "-10px";
                                        break;

                                    default:
                                        $reszta = $i % 2;
                                        if ($reszta == 0) {
                                            $top_index = $i / 2 * -15 . "px";
                                            $left_index = "0";
                                        } else {
                                            $top_index = floor($i / 2) * -15 . "px";
                                            $left_index = "-10px";
                                        }
                                        break;
                                }
                        }
                        
                        $speaker_html .= '<img class="speaker" src="' . esc_url($image_src[0]) . '" alt="'.$speakers_names[$i].'-'.$i.' portrait" style="position:relative; '.$b_radius.' z-index:'.$z_index.'; top:'.$top_index.'; left:'.$left_index.'; max-width: '.$max_width_index.';'.$margin_top_index.';" />';
                    }
                }
            }
            $speaker_html .= '</div>';
        }
        return $speaker_html;
    }
    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts, $content = null) {

        $rn = rand(10000, 99999);

        extract( shortcode_atts( array(
            'simple_mode' => '',
            'event_time' => '',
            'event_title' => '',
            'border_radius' => '',
            'border_style' => '',
            'border_color' => '',
            'lect_color' => '',
            'bio_color' => '',
            'title_color' => '',
            'shadow' => '',
            'photo_box' => '',
            'photo_squer' => '',
            'title_top' => '',
            
        ), $atts ));

        $locale = get_locale();

        $lecture_id = !empty($atts['lecture_id']) ? $atts['lecture_id'] : $rn;

        $speakers = vc_param_group_parse_atts($atts['speakers']);

        $event_desc = wpb_js_remove_wpautop($content, true);

        $border_radius = ($atts['border_radius']) ? 'border-radius: '.$atts['border_radius'].';': '';
        $border_width = !empty($atts['border_width']) ? $atts['border_width'] : '0';
        $border_style = !empty($atts['border_style']) ? $atts['border_style'] : 'solid';
        $border_color = !empty($atts['border_color']) ? $atts['border_color'] : '#000000';
        $lect_color = !empty($atts['lect_color']) ? 'color: '.$atts['lect_color'].';' : 'color: #000000;';
        $bio_color = !empty($atts['bio_color']) ? $atts['bio_color'] : '#000000';
        $title_color = !empty($atts['title_color']) ? $atts['title_color'] : '#000000';
        $shadow = !empty($atts['shadow']) ? 'box-shadow: 4px 4px 7px 2px;' : '';
        $photo_box = !empty($atts['photo_box']) ? $atts['photo_box'] : '';
        $modal_img_size = !empty($atts['modal_img_size']) ? 'width: '.$atts['modal_img_size'].';' : 'width: 120px;';
        $bio_text = !empty($atts['bio_text']) ? 'color: '.$atts['bio_text'].'!important;' : 'color: white !important;';
        $title_size = !empty($atts['title_size']) ? ' font-size: '.$atts['title_size'].'!important; ' : '';
        
        
        $event_title = str_replace('``','"', $event_title);
        $event_time = str_replace('``','"', $event_time);
        $event_desc = str_replace('<script>','', $event_desc);

        $speakers_images = array('speaker');

        $uncode_options = get_option('uncode');

        foreach($speakers as $main_id => $speaker){
            foreach($speaker as $id => $key){
                if($id == 'speaker_name'){
                    $speakers_names[$main_id] = $key;
                }
                if($id == 'speaker_image'){
                    $speakers_images[$main_id] = $key;
                }
                if($id == 'speaker_bio'){
                    $speakers_bios[$main_id] = $key;
                }
            }
        }
        if (!$simple_mode){

            $modal_html = '<div class="modal-lecturers">';

            if($photo_box){
                foreach($speakers_bios as $id => $bio){
                    if(!empty($bio)){
                        $modal_desc = true;
                        $modal_lecturer_display = '';
                        $modal_html .= '<div class="lecturer" '.$modal_lecturer_display.'><div class="modal-image">';

                        if(!empty($speakers_images[$id])){
                            $image_src = wp_get_attachment_image_src($speakers_images[$id], 'full');
                            $modal_html .= '<img class="alignleft" src="'.$image_src[0].'" style="'.$modal_img_size.'">';
                        }

                        $modal_html .= '<h3 style="'.$lect_color.'">'.$speakers_names[$id].'</h3>';
                        $modal_html .= '<p style="text-align: unset; margin-left:18px;">'.$bio.'</p>';
                        $modal_html .= '</div></div>';
                    }
                }

                $output .= '<div id="lecture-'.$lecture_id.'" class="chevron-slide" style="'.$shadow.' border:'.$border_width.' '.$border_style.' '.$border_color.'; '.$border_radius.'">
                        <div class="head-container">
                        ' . self::speakerImageMini($speakers_images);
            
                if ($modal_desc){
                    if (count($speakers_images) < 3){
                        $output .=
                                '<button class="lecturers-bio btn btn-sm lecture-btn" style="background-color:'.$bio_color.' !important; '.$bio_text.'">BIO</button>';
                    } else {
                        $output .=
                                '<button class="lecturers-bio lecturers-triple btn btn-sm lecture-btn" style="background-color:'.$bio_color.' !important; '.$bio_text.'">BIO</button>';
                    }
                }
                $output .= '</div>';
                $output .= '<div class="text-container" style="width: 75%;">';
            } else {
                $output .= '<div id="lecture-'.$lecture_id.'" class="chevron-slide" style="'.$shadow.' border:'.$border_width.' '.$border_style.' '.$border_color.'; '.$border_radius.'">
                        <div class="text-container" style="width: 90%;">';
            }
            if($speakers_names){
                $speak_display = array_filter($speakers_names, function($value) {
                    return $value !== "";
                });
            
                $display_speakers = implode(', ', $speak_display);
                $display_speakers = str_replace(';,','<br>',$display_speakers);
            }

            if($title_top != ''){
                $output .= '<h4 class="lectur-time">' . $event_time . '</h4>
                        <h3 class="inside-title" style="'.$title_size.'color:'.$title_color.';">' . $event_title . '</h3>
                        <h5 class="lecturer-name" style="'.$lect_color.'">'.$display_speakers.'</h5>';
            } else {
                $output .= '<h4 class="lectur-time">' . $event_time . '</h4>
                <h5 class="lecturer-name" style="'.$lect_color.'">'.$display_speakers.'</h5> 
                <h3 class="inside-title" style="'.$title_size.'color:'.$title_color.';">' . $event_title . '</h3>';
            }

            if($event_desc != ''){
                $output .='<div class="inside-text" style="max-height: 120px;"><p>' . $event_desc . '</p></div>
                            <p class="open-desc" style="display:none"><i class="text-accent-color fa fa-chevron-down fa-1x fa-fw"></i>';
                                if ($locale == 'pl_PL') {
                                    $output .= 'Czytaj więcej';
                                } else {
                                    $output .= 'Read more';
                                }
                                $output .= '<i class="text-accent-color fa fa-chevron-down fa-1x fa-fw"></i>
                            </p>';        
            }
            $output .='</div>
                        <div id="info-modal" class="info-modal" style="display:none;">
                            <div class="info-modal-content">
                            '.$modal_html.'
                            </div>
                            <i class="fa fa-times-circle-o fa-2x fa-fw info-close"></i>
                        </div>
                    </div>
                </div>';
        } else {

            $simple_speakers = implode(', ', $speakers_names);
            
            $output .= '<div id="lecture-'.$lecture_id.'" class="simple-lecture">
                            <h5 class="simple-lecture-hour">'.$event_time.'</h5>
                            <div class="simple-lecture-text">
                                <h5>'.$event_title.'</h5>
                                <p class="text-accent-color">'.$simple_speakers.'</p>
                            </div>
                        </div>';
        }

        return $output;
    }
}

?>


