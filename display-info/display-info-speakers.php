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
                'heading' => __('Color name', 'pwe_display_info'),
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
                'heading' => __('Width element', 'pwe_display_info'),
                'param_name' => 'info_speakers_element_width',
                'description' => __('Width element', 'pwe_display_info'),
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
                'param_name' => 'info_speakers_photo_square',
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
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white');
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black');
        $btn_shadow_color = self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], '#777');
        $btn_border = '1px solid ' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black');

        $rnd = rand(10000, 99999);

        extract( shortcode_atts( array(
            'info_speakers_speakers' => '',
            'info_speakers_lect_color' => '',
            'info_speakers_element_width' => '',
            'info_speakers_photo_square' => '',
        ), $atts ) );

        $info_speakers_lect_color = empty($info_speakers_lect_color) ? 'black' : $info_speakers_lect_color;
        $info_speakers_element_width = empty($info_speakers_element_width) ? '150px' : $info_speakers_element_width;
        $info_speakers_photo_square = $info_speakers_photo_square != true ? '50%' : '0';

        $output = '
        <style>
            #info-speaker-'. self::$rnd_id .' {
                text-align: center;
                display: flex;
                justify-content: center;
                flex-wrap: wrap;
                gap: 18px;
            }
            #info-speaker-'. self::$rnd_id .' .pwe-speaker {
                width: '. $info_speakers_element_width .';
                min-width: 150px;
                display: flex;
                flex-direction: column;
                text-align: center;
                justify-content: space-between;
            }
            #info-speaker-'. self::$rnd_id .' .pwe-speaker-name {
                color: '. $info_speakers_lect_color .';
            }
            #info-speaker-'. self::$rnd_id .' .pwe-speaker-img {
                width: 100%;
                border-radius: '. $info_speakers_photo_square .';
                margin: 0 auto;
                aspect-ratio: 1/1;
                object-fit: cover;
            }
            #info-speaker-'. self::$rnd_id .' .pwe-speaker-btn {
                margin: 10px auto !important;
                box-shadow: 4px 4px 0px -1px '. $btn_shadow_color .';
                background-color: '. $btn_color .';
                color: '. $btn_text_color .';
                border: '. $btn_border .';
                padding: 6px 16px;
                font-weight: 600;
                width: 80px;
                transition: .3s ease;
            }
            #info-speaker-'. self::$rnd_id .' .pwe-speaker-btn:hover {
                box-shadow: 4px 4px 0px -1px black;
                color: black;
                background-color: white;
            }
            
            #pweSpeakerModal-'. $rnd .' {
                position: fixed;
                z-index: 9999;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                overflow: hidden;
                background-color: rgba(0, 0, 0, 0.7);
                display: flex;
                justify-content: center;
                align-items: center;
                visibility: hidden;
                transition: opacity 0.3s, visibility 0.3s;
            }
            #pweSpeakerModal-'. $rnd .' .pwe-speaker-modal-content {
                position: relative;
                background-color: #fefefe;
                margin: 15% auto;
                padding: 20px;
                border: 1px solid #888;
                border-radius: 20px;
                overflow-y: auto;
                width: 80%;
                max-width: 500px;
                max-height: 90%;
                transition: transform 0.3s;
                transform: scale(0);
            }
            #pweSpeakerModal-'. $rnd .' .pwe-speaker-modal-close {
                position: absolute;
                right: 18px;
                top: -6px;
                color: #000;
                float: right;
                font-size: 50px;
                font-weight: bold;
                transition: transform 0.3s;
                font-family: monospace;
            }
            #pweSpeakerModal-'. $rnd .' .pwe-speaker-modal-close:hover,
            #pweSpeakerModal-'. $rnd .' .pwe-speaker-modal-close:focus {
                color: black;
                text-decoration: none;
                cursor: pointer;
                transform: scale(1.2);
            }
            #pweSpeakerModal-'. $rnd .' .pwe-speaker-modal-title,
            #pweSpeakerModal-'. $rnd .' .pwe-speaker-modal-desc {
                margin: 18px 0 0;
            }
            
            #pweSpeakerModal-'. $rnd .'.is-visible {
                opacity: 1;
                visibility: visible;
            }
            #pweSpeakerModal-'. $rnd .'.is-visible .pwe-speaker-modal-content {
                transform: scale(1);
            }
            #pweSpeakerModal-'. $rnd .'.is-visible .pwe-speaker-modal-image {
                border-radius: 10px;
            }
        </style>';

        $speakers_urldecode = urldecode($info_speakers_speakers);
        $speakers_json = json_decode($speakers_urldecode, true);
        if (is_array($speakers_json)) {
            foreach ($speakers_json as $speaker){
                $speaker_image = $speaker["speaker_image"];
                $speaker_name = $speaker["speaker_name"];
                $speaker_bio = $speaker["speaker_bio"];

                $speaker_image_src = wp_get_attachment_url($speaker_image);   

                $item_speaker_id = 'pweSpeaker-' . $rnd;
                $output .= '<div id="'. $item_speaker_id .'" class="pwe-speaker">
                                <img class="pwe-speaker-img" src="'. $speaker_image_src .'">
                                <h5 class="pwe-speaker-name" style="margin-top: 9px;">'. $speaker_name .'</h5>
                                <p class="pwe-speaker-desc" style="display:none;">'. $speaker_bio .'</p>';
                                if(!empty($speaker_bio)){
                                    $output .='<button class="pwe-speaker-btn">BIO</button>';
                                }
                $output .='</div>';
            }
        } 

        $output .='
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const speakers = document.querySelectorAll("#'. $item_speaker_id .'");
                
                speakers.forEach((speaker) => {
                    const img = speaker.querySelector(".pwe-speaker-img");
                    const name = speaker.querySelector(".pwe-speaker-name");
                    const desc = speaker.querySelector(".pwe-speaker-desc");
                    const btn = speaker.querySelector(".pwe-speaker-btn");

                    if (!desc || desc.textContent.trim() === "" && desc.children.length === 0) {
                        speaker.style.justifyContent = "flex-start";
                    }
                    
                    if (btn) {
                        btn.addEventListener("click", function() {
                            const modalDiv = document.createElement("div");
                            modalDiv.className = "pwe-speaker-modal";
                            modalDiv.id = "pweSpeakerModal-'. $rnd .'";
                            modalDiv.innerHTML = `
                                <div class="pwe-speaker-modal-content" style="display:flex; flex-direction:column; align-items:center; padding:20px;">
                                    <span class="pwe-speaker-modal-close">&times;</span>
                                    <img class="pwe-speaker-modal-image" src="${img.src}" alt="Speaker Image" style="width:100%; max-width:150px;">
                                    <h5 class="pwe-speaker-modal-title">${name.innerHTML}</h5>
                                    <p class="pwe-speaker-modal-desc">${desc.innerHTML}</p>
                                </div>
                            `;
                            
                            document.body.appendChild(modalDiv);
                            requestAnimationFrame(() => {
                                modalDiv.classList.add("is-visible");
                            });
                            disableScroll();

                            // Close modal
                            modalDiv.querySelector(".pwe-speaker-modal-close").addEventListener("click", function() {
                                modalDiv.classList.remove("is-visible");
                                setTimeout(() => {
                                    modalDiv.remove();
                                    enableScroll();
                                }, 300); // Czekaj na zakończenie animacji przed usunięciem
                            });

                            modalDiv.addEventListener("click", function(event) {
                                if (event.target === modalDiv) {
                                    modalDiv.classList.remove("is-visible");
                                    setTimeout(() => {
                                        modalDiv.remove();
                                        enableScroll();
                                    }, 300);
                                }
                            });
                        });
                    }
                });
            });

            // Functions to turn scrolling off and on
            function disableScroll() {
                document.body.style.overflow = "hidden";
                document.documentElement.style.overflow = "hidden";
            }
            function enableScroll() {
                document.body.style.overflow = "";
                document.documentElement.style.overflow = "";
            }
        </script>';

        return $output;
    }
}

?>


