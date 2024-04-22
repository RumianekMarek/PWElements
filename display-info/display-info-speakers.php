<?php 

/**
 * Class PWEDisplayInfoSpeakers
 * Extends PWEDisplayInfo class and defines a custom Visual Composer element.
 */
class PWEDisplayInfoSpeakers extends PWEDisplayInfo {

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
                'heading' => __('Speakers', 'pwe_display_info'),
                'group' => 'main',
                'type' => 'param_group',
                'param_name' => 'info_speakers_speakers',
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
                    'value' => 'PWEDisplayInfoSpeakers',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('Lecturers color', 'pwe_display_info'),
                'param_name' => 'info_speakers_lect_color',
                'description' => __('Color for lecturers names.', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoSpeakers',
                ),
            ),
            array(
                'type' => 'textfield',
                'group' => 'options',
                'heading' => __('BIO Img size', 'pwe_display_info'),
                'param_name' => 'info_speakers_modal_img_size',
                'description' => __('Size of the Img for "BIO" description. max 300px', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoSpeakers',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('BIO BTN Color', 'pwe_display_info'),
                'param_name' => 'info_speakers_bio_color',
                'description' => __('Color for buton "BIO".', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoSpeakers',
                ),
            ),
            array(
                'type' => 'colorpicker',
                'group' => 'options',
                'heading' => __('BIO BTN Text Color', 'pwe_display_info'),
                'param_name' => 'info_speakers_bio_text',
                'description' => __('Color for text on buton "BIO" .', 'pwe_display_info'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoSpeakers',
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'options',
                'heading' => __('Photo as square', 'pwe_display_info'),
                'param_name' => 'info_speakers_photo_squer',
                'description' => __('Check to show photos as square.', 'pwe_display_info'),
                'admin_label' => true,
                'value' => array(__('True', 'pwe_display_info') => 'true',),
                'dependency' => array(
                    'element' => 'display_info_format',
                    'value' => 'PWEDisplayInfoSpeakers',
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
    public static function output($atts, $content = null) {

        $rn = rand(10000, 99999);
        extract( shortcode_atts( array(
            'border_radius' => '',
            'border_style' => '',
            'border_color' => '',
            'info_speakers_lect_color' => '',
            'info_speakers_bio_color' => '',
            'title_color' => '',
            'info_speakers_photo_squer' => '',
        ), $atts ) );

        $locale = get_locale();

        $lecture_id = !empty($atts['lecture_id']) ? $atts['lecture_id'] : $rn;

        $speakers = urldecode($atts['info_speakers_speakers']);
        $speakers = json_decode($speakers);

        foreach ($speakers as $id => $speaker){
            $speakers[$id]->speaker_image = wp_get_attachment_image_src($speaker->speaker_image, 'full')[0];
        }

        $info_speakers_modal_img_size = !empty($atts['info_speakers_modal_img_size']) ? 'width: '.$atts['info_speakers_modal_img_size'].';' : 'width: 120px;';
        $info_speakers_bio_text = !empty($atts['info_speakers_bio_text']) ? 'color: '.$atts['info_speakers_bio_text'].'!important;' : '';
        
        $event_title = str_replace('``','"', $event_title);

        $uncode_options = get_option('uncode');

        $css_file = plugins_url('display-info.css', __FILE__);
        $css_version = filemtime(plugin_dir_url( __FILE__ ) . 'display-info.css');
        wp_enqueue_style('info_box-css', $css_file, array(), $css_version);

        $js_file = plugins_url('speakers-info.js', __FILE__);
        $js_version = filemtime(plugin_dir_url(__FILE__) . 'speakers-info.js');
        wp_enqueue_script('speakers_box-js', $js_file, array('jquery'), $js_version, true);
        wp_localize_script('speakers_box-js', 'speakers' , $speakers);

        $output = '<div id="speakersInfo-'.$rn.'" class="speakersInfo">';
        foreach($speakers as $id => $speak){
            $output .= '
                    <div class="custom-speaker '.$speak->speaker_name.'">
                        <img class="custom-speaker-img" src="'.$speak->speaker_image.'" style="'.$info_speakers_modal_img_size.'">
                        <h5 style="margin-top: 9px;">'.$speak->speaker_name.'</h5>';
                        if(!empty($speak->speaker_bio)){
                            $output .='<button class="speakers-bio btn btn-sm btn-default lecture-btn" data-target="'.$id.'" style="background-color:'.$info_speakers_bio_color.' !important; '.$info_speakers_bio_text.'">BIO</button>';
                        }
                    $output .='</div>';
        }
        $output .= '</div>';
        return $output;
            

    }
}

?>


