<?php 

/**
 * Class PWElementMainCountdown
 * Extends PWElements class and defines a pwe Visual Composer element for vouchers.
 */
class PWElementMainCountdown extends PWElements {
    public static $countdown_rnd_id;
    public static $today_date;
    /**
     * Constructor method.
     * Calls parent constructor and adds an action for initializing the Visual Composer map.
     */
    public function __construct() {
        date_default_timezone_set('Europe/Warsaw');
        self::$today_date = new DateTime();
        self::$countdown_rnd_id = rand(10000, 99999);
        parent::__construct();

        require_once plugin_dir_path(__FILE__) . 'js/countdown.php';
    }

    /**
     * Static method to initialize Visual Composer elements.
     * Returns an array of parameters for the Visual Composer element.
     */
    public static function initElements() {
        $element_output = array(
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Custom Timer', 'pwelement'),
                'param_name' => 'custom_timer',
                'description' => __('Enable to create custom timer'),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMainCountdown',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Turn off background', 'pwelement'),
                'param_name' => 'turn_off_timer_bg',
                'description' => __('Enable to create custom timer'),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMainCountdown',
                ),
                'save_always' => true,
                'admin_label' => true
            ),
            array(
                'type' => 'param_group',
                'group' => 'PWE Element',
                'heading' => __('Add countdown', 'pwelement'),
                'param_name' => 'countdowns',
                'param_holder_class' => 'main-param-group countdown-params',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => array('PWElementMainCountdown','PWElementHomeGallery'),
                ),
                'params' => array(
                    array(
                        'type' => 'textfield',
                        'heading' => __('Start', 'pwelement'),
                        'param_name' => 'countdown_start',
                        'description' => __('Format (Y/m/d h:m)', 'pwelement'),
                        'param_holder_class' => 'backend-textfield',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('End', 'pwelement'),
                        'param_name' => 'countdown_end',
                        'description' => __('Format (Y/m/d h:m)', 'pwelement'),
                        'param_holder_class' => 'backend-textfield',
                        'save_always' => true,
                        'admin_label' => true
                    ), 
                    array(
                        'type' => 'textfield',
                        'heading' => __('Placeholder text', 'pwelement'),
                        'param_name' => 'countdown_text',
                        'description' => __('Default: "Do targów pozostało/Until the start of the fair"', 'pwelement'),
                        'param_holder_class' => 'backend-textfield',
                        'save_always' => true,
                        'admin_label' => true
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Button Text', 'pwelement'),
                        'param_name' => 'countdown_btn_text',
                        'param_holder_class' => 'backend-textfield',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Button Url', 'pwelement'),
                        'param_name' => 'countdown_btn_url',
                        'param_holder_class' => 'backend-textfield',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Font size', 'pwelement'),
                        'param_name' => 'countdown_font_size',
                        'param_holder_class' => 'backend-textfield',
                    ),
                    array(
                        'type' => 'textfield',
                        'heading' => __('Font weight', 'pwelement'),
                        'param_name' => 'countdown_weight',
                        'param_holder_class' => 'backend-textfield',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Turn off placeholder text', 'pwelement'),
                        'param_name' => 'turn_off_countdown_text',
                        'value' => array(__('True', 'pwelement') => 'true',),
                        'param_holder_class' => 'backend-basic-checkbox',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Turn off button', 'pwelement'),
                        'param_name' => 'turn_off_countdown_button',
                        'value' => array(__('True', 'pwelement') => 'true',),
                        'param_holder_class' => 'backend-basic-checkbox',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Turn off background', 'pwelement'),
                        'param_name' => 'turn_off_countdown_bg',
                        'value' => array(__('True', 'pwelement') => 'true',),
                        'param_holder_class' => 'backend-basic-checkbox',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Limit width', 'pwelement'),
                        'param_name' => 'countdown_limit_width',
                        'value' => array(__('True', 'pwelement') => 'true',),
                        'param_holder_class' => 'backend-basic-checkbox',
                    ),
                    array(
                        'type' => 'checkbox',
                        'heading' => __('Row->Column', 'pwelement'),
                        'param_name' => 'countdown_column',
                        'value' => array(__('True', 'pwelement') => 'true',),
                        'param_holder_class' => 'backend-basic-checkbox',
                    ),
                ),
            ),
            array(
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Hide change register button', 'pwelement'),
                'param_name' => 'show_register_bar',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementMainCountdown',
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
    private static function getRightData($count) {
        foreach($count as $value){
            if ($value['countdown_start'] != ''){
                $start_date = new DateTime($value['countdown_start']);
            } else {
                $start_date = self::$today_date;
            }

            $end_date = new DateTime($value['countdown_end']);

            if($start_date > self::$today_date || $end_date < self::$today_date){
                array_shift($count);
            } else {
                break;
            }
        }
        return $count;
    }  

    /**
     * Set up default stats.
     * Returns array for timer display on main site.
     * 
     * @return array @main_timer options
     */
    public static function main_timer() {
        $output_time_start_def = array(
            'countdown_start' => '',
            'countdown_end' => do_shortcode('[trade_fair_datetotimer]'),
            'countdown_text' => self::languageChecker(
                <<<PL
                Do targów pozostało:
                PL,
                <<<EN
                Until the start of the fair:
                EN
            )
        );
        $output_time_end_def = array(
            'countdown_start' => '',
            'countdown_end' => do_shortcode('[trade_fair_enddata]'),
            'countdown_text' => self::languageChecker(
                <<<PL
                Do końca targów pozostało:
                PL,
                <<<EN
                Until the end of the fair:
                EN
            )
        );
        $countdown_next_year = substr(trim(do_shortcode('[trade_fair_datetotimer]')), 0, 4) + 1;
        $countdown_next_year .=  substr(do_shortcode('[trade_fair_datetotimer]'), 4);

        $output_time_start_next_year = array(
            'countdown_start' => '',
            'countdown_end' => $countdown_next_year,
            'countdown_text' => self::languageChecker(
                <<<PL
                Do targów pozostało:
                PL,
                <<<EN
                Until the start of the fair:
                EN
            )
        );

        $output_button = array(
            'countdown_btn_text' => self::languageChecker(
                <<<PL
                Zostań wystawcą
                PL,
                <<<EN
                Book a stand
                EN
            ),
             'countdown_btn_url' => self::languageChecker(
                <<<PL
                /zostan-wystawca/
                PL,
                <<<EN
                /en/become-an-exhibitor
                EN
            )
        );

        $output_default[0] = array_merge($output_time_start_def, $output_button);
        $output_default[1] = array_merge($output_time_end_def, $output_button);
        $output_default[2] = array_merge($output_time_start_next_year, $output_button);

        return $output_default;
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     */
    public static function output($atts, $content = '') {
        extract(shortcode_atts(array(
            'custom_timer' => '',
            'turn_off_timer_bg' => '',
            'add_timer' => '',
            'countdowns' => '',
        ), $atts ));

        $output = '';

        $countdown = vc_param_group_parse_atts($countdowns);

        foreach($countdown as $main_id => $main_value){
            if (($custom_timer || $add_timer) && $main_value["countdown_end"] == '') {
                $main_value["countdown_end"] = do_shortcode('[trade_fair_datetotimer]');
            }
            foreach($main_value as $id => $key){
                $countdown[$main_id][$id] = do_shortcode($key);     
            }
        }
        
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . '!important';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . '!important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], self::$main2_color) . '!important';
        $darker_btn_color = self::adjustBrightness($btn_color, -20);

        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);
        
        if(($custom_timer || $add_timer)){
            $right_countdown = self::getRightData($countdown);
        } else {
            $right_countdown = self::getRightData(self::main_timer());
        }

        $turn_off_countdown_bg = (isset($right_countdown[0]['turn_off_countdown_bg']) && !empty($right_countdown[0]['turn_off_countdown_bg'])) ? $right_countdown[0]['turn_off_countdown_bg'] : '';
        $countdown_limit_width = (isset($right_countdown[0]['countdown_limit_width']) && !empty($right_countdown[0]['countdown_limit_width'])) ? $right_countdown[0]['countdown_limit_width'] : '';
        $countdown_weight = (isset($right_countdown[0]['countdown_weight']) && !empty($right_countdown[0]['countdown_weight'])) ? $right_countdown[0]['countdown_weight'] : '';
        $countdown_column = (isset($right_countdown[0]['countdown_column']) && !empty($right_countdown[0]['countdown_column'])) ? $right_countdown[0]['countdown_column'] : '';

        $countdown_bg = ($turn_off_countdown_bg == 'true') ? 'inherit' : self::$accent_color;
        $countdown_width = ($countdown_limit_width == 'true') ? '1200px' : '100%';
        $countdown_font_weight = ($countdown_weight == '') ? '700' : $countdown_weight;

        if ($mobile != 1) {
            $countdown_font_size = (isset($right_countdown[0]['countdown_font_size']) && !empty($right_countdown[0]['countdown_font_size'])) ? $right_countdown[0]['countdown_font_size'] : '18px';
        } else {
            $countdown_font_size = (isset($right_countdown[0]['countdown_font_size']) && !empty($right_countdown[0]['countdown_font_size'])) ? $right_countdown[0]['countdown_font_size'] : '16px';
        }
        
        $countdown_font_size = str_replace("px", "", $countdown_font_size);
        
        $ending_date = new DateTime($right_countdown[0]['countdown_end']);
        
        $date_dif = self::$today_date->diff($ending_date);

        $flex_direction = ($countdown_column == true) ? 'flex-direction: column;' : '';

        // if ($atts['custom_timer'] == 'true' && $atts['countdown_end'] == '') {
        //     $countdown_end = do_shortcode('[trade_fair_enddata]');
        // }

        if ($atts['custom_timer'] != true) {
            $output = '';
            // $output .= '
            // <style>
            //     .row-parent:has(.pwelement_' . self::$rnd_id . ') {
            //         opacity: 0;
            //     }
            // </style>';
        }

        if ($atts['turn_off_timer_bg'] == true) {
            $output .= 
            '<style>
                .row-parent:has(.pwelement_' . self::$rnd_id . ') {
                    background: inherit;
                    max-width: ' . $countdown_width . ';
                    padding: 0 !important;
                }';
        } else {
            $output .= 
            '<style>
                .row-parent:has(.pwelement_' . self::$rnd_id . ') {
                    background: ' . $countdown_bg . ';
                    max-width: ' . $countdown_width . ';
                    padding: 0 !important;
                }';
        }
        
        if (count($right_countdown)){
            $output .= '
                .row-parent:has(.pwelement_' . self::$rnd_id . ') {
                    background: ' . $countdown_bg . '; 
                    max-width: ' . $countdown_width . ';
                    padding: 0 !important;
                }
                .pwelement_'. self::$rnd_id .' #main-timer p {
                    color: '. $text_color .';
                    margin: 9px auto;
                    font-size: ' . $countdown_font_size . 'px !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-btn {
                    color: '. $btn_text_color .';
                    background-color: '. $btn_color .';
                    border: 1px solid '. $btn_color .';
                    margin: 9px 18px; 
                    transform: scale(1) !important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-btn:hover {
                    color: '. $btn_text_color .';
                    background-color: '. $darker_btn_color .'!important;
                    border: 1px solid '. $darker_btn_color .'!important;
                }
                .pwelement_'. self::$rnd_id .' .pwe-timer-text {
                    font-weight: ' . $countdown_font_weight . ';
                    text-transform: uppercase;
                    margin: 9px auto;
                }
                .pwelement_'. self::$rnd_id .' .countdown-container {                    
                    display: flex;
                    justify-content: space-evenly;
                    flex-wrap: wrap;
                    ' . $flex_direction . '
                    align-items: center;
                    max-width: 1200px;
                    margin: 0 auto;
                }
                .pwelement_'. self::$rnd_id .' .pwe-countdown-timer {
                    min-width: 450px;
                    text-align: center;
                }
                @media (min-width: 300px) and (max-width: 1200px) {
                    .pwelement_'. self::$rnd_id .' #main-timer p {
                        font-size: calc(14px + (' . $countdown_font_size . ' - 14) * ( (100vw - 300px) / (1200 - 300) )) !important;
                    }
                }
                @media (max-width:570px){
                    .pwelement_'. self::$rnd_id .' .countdown-container {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: space-evenly;
                        align-items: baseline;
                        margin: 8px auto;
                    }
                    .pwelement_'. self::$rnd_id .' .pwe-countdown-timer {
                        min-width: 100%;
                    }  
                    .pwelement_'. self::$rnd_id .' #main-timer p {
                        margin: 0 auto;
                    }
                }';
                $output .= '
                @media (max-width:959px){
                    .wpb_column:has(.pwelement_'. self::$rnd_id .') {
                        padding-top: 0 !important;
                    }
                }';

            $output .= '</style>';
                
            $output .='<div id="main-timer" class="countdown-container" data-show-register-bar="'. $atts['show_register_bar'] .'">';

            $turn_off_countdown_text = isset($right_countdown[0]['turn_off_countdown_text']) ? $right_countdown[0]['turn_off_countdown_text'] : '';

            if ($turn_off_countdown_text != true && $right_countdown[0]['countdown_text'] != '') {    
                $output .='<p id="timer-header-text-' . self::$countdown_rnd_id . '" class="timer-header-text pwe-timer-text">' . $right_countdown[0]['countdown_text'] . '</p>';
            };
            if (get_locale() == "pl_PL") {
                $output .='<p id="pwe-countdown-timer-' . self::$countdown_rnd_id . '" class="pwe-countdown-timer pwe-timer-text">
                            ' . $date_dif->days . ' dni ' . $date_dif->h . ' godzin ' . $date_dif->i . ' minut ';
                            if(!$mobile){
                                $output .= $date_dif->s . ' sekund 
                                           </p>';
                            } else {
                                $output .= '</p>';
                            }
            } else {
                $output .='<p id="pwe-countdown-timer-' . self::$countdown_rnd_id . '" class="pwe-countdown-timer pwe-timer-text">
                            ' . $date_dif->days . ' days ' . $date_dif->h . ' hours ' . $date_dif->i . ' minutes ';
                            if(!$mobile){
                                $output .= $date_dif->s . ' seconds
                                        </p>';
                            } else {
                                $output .= '</p>';
                            }
            }
            $turn_off_countdown_button = isset($right_countdown[0]['turn_off_countdown_button']) ? $right_countdown[0]['turn_off_countdown_button'] : '';
            if ($turn_off_countdown_button != true && $right_countdown[0]['countdown_btn_text'] != '') {
                $output .='<a id="timer-button-' . self::$countdown_rnd_id . '" class="timer-button pwe-btn btn" href="' . $right_countdown[0]['countdown_btn_url'] . '">' . $right_countdown[0]['countdown_btn_text'] . '</a>';
            };
            $output .='</div>';
        
            PWECountdown::output($right_countdown, self::$countdown_rnd_id);
            
        } else {
            $output .= '</style>';
        }

        // $output .= '
        // <script>
        //     document.addEventListener("DOMContentLoaded", function() {
        //         if (document.querySelector(".row-parent:has(.pwelement_' . self::$rnd_id . ')")) {
        //             const countdownEl = document.querySelector(".row-parent:has(.pwelement_' . self::$rnd_id . ')");
        //             countdownEl.style.opacity = 1;
        //             countdownEl.style.transition = "opacity 0.3s ease";
        //         }
        //     });
        // </script>';

        return $output;
    }
}