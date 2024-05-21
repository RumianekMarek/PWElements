<?php 

/**
 * Class PWElementVideos
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementVideos extends PWElements {

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
                'group' => 'PWE Element',
                'heading' => __('Custom title element', 'pwelement'),
                'param_name' => 'pwe_video_custom_title',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementVideos',
                ),
              ),
              array(
                'type' => 'param_group',
                'group' => 'PWE Element',
                'heading' => __('Youtube iframes', 'pwelement'),
                'param_name' => 'pwe_videos_iframe',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementVideos',
                ),
                'params' => array(
                  array(
                    'type' => 'textfield',
                    'heading' => __('Title', 'pwelement'),
                    'param_name' => 'video_title',
                    'save_always' => true,
                    'admin_label' => true
                  ),
                  array(
                    'type' => 'textarea',
                    'heading' => __('Iframe', 'pwelement'),
                    'param_name' => 'video_iframe',
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
        $btn_text_color = 'color:' . self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color']) . '!important; border-width: 0 !important;';
        $btn_color = 'background-color:' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color']) . '!important;';
        $btn_shadow_color = 'box-shadow: 9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color']) . '!important;';

        extract( shortcode_atts( array(
            'pwe_video_custom_title' => '',
            'pwe_videos_iframe' => '',
        ), $atts ));

        $videos_urldecode = urldecode($pwe_videos_iframe);
        $videos_json = json_decode($videos_urldecode, true);
        foreach ($videos_json as $video) {
            $video_iframe = $video["video_iframe"];
        }

        if (!empty($video_iframe)) {
            if ($video_custom_title == "") {
                $pwe_video_custom_title = (get_locale() == 'pl_PL') ? "Zobacz jak było na poprzednich edycjach" : "Check previous editions";
            }
        } else $pwe_video_custom_title = (get_locale() == 'pl_PL') ? "ZOBACZ JAK WYGLĄDAJĄ NASZE POZOSTAŁE TARGI" : "SEE WHAT OUR OTHER TRADE FAIRS LOOK LIKE";     
        

        $output = '
            <style>
                .pwelement_'. self::$rnd_id .' .custom-container-videos {
                    display: flex;
                    flex-direction: column;
                    gap: 36px;
                }
                .pwelement_'. self::$rnd_id .' .custom-videos-title h4 {
                    margin: 0;
                }
                .pwelement_'. self::$rnd_id .' .custom-videos {
                    display: flex;
                    justify-content: space-around;
                    flex-wrap: wrap;
                    gap: 36px;
                }
                .pwelement_'. self::$rnd_id .' .custom-video-item {
                    width: 47%;
                }
                .pwelement_'. self::$rnd_id .' .custom-video-item p {
                    font-size: 18px;
                }
                @media (max-width:960px) {
                    .pwelement_'. self::$rnd_id .' .custom-videos {
                        flex-direction: column;
                    }
                    .pwelement_'. self::$rnd_id .' .custom-video-item {
                        width: 100%;
                    }
                }
            </style>

            <div id="customVideos" class="custom-container-videos">
                <div class="custom-videos-title main-heading-text">
                    <h4 class="custom-uppercase"><span>'. $pwe_video_custom_title .'</span></h4>
                </div>  
                <div class="custom-videos">';
                    if (!empty($video_iframe)) {
                        foreach ($videos_json as $video) {
                            $video_title = $video["video_title"];
                            $video_iframe = $video["video_iframe"];

                            $output .= '<div class="custom-video-item">'. $video_iframe .'<p>'. $video_title .'</p></div>';
                        }
                    } else {
                        $output .= '<div class="custom-video-item">
                            <iframe class="iframe-shadow" width="560" height="315" data-src="https://www.youtube.com/embed/TgHh38jvkAY?si=pc01x3a22VkL-qoh" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            <p>Ptak Warsaw Expo | 2023</p>
                        </div>';

                        $output .= '<div class="custom-video-item">
                            <iframe class="iframe-shadow" width="560" height="315" data-src="https://www.youtube.com/embed/-RmRpZN1mHA?si=2QHfOrz0TUkNIJwP" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                            <p>'. 
                                self::languageChecker(
                                    <<<PL
                                    Stolica Targów i Eventów w Polsce - Ptak Warsaw Expo
                                    PL,
                                    <<<EN
                                    The Capital of Fairs and Events in Poland - Ptak Warsaw Expo
                                    EN
                                )
                            .'</p>
                        </div>';
                    }
        $output .= '</div>
        </div>';

        return $output;

    }
}

?>
