<?php
/**
* Class PWElementAssociates
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementAssociates extends PWElements {

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
                'type' => 'checkbox',
                'group' => 'PWE Element',
                'heading' => __('Association fair logo white', 'pwelement'),
                'param_name' => 'association_fair_logo_white',
                'description' => __('Check if you want to change the logotypes color to white. ', 'pwelement'),
                'admin_label' => true,
                'save_always' => true,
                'value' => array(__('True', 'pwelement') => 'true',),
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementAssociates',
                ),
            ),
            
        );
        return $element_output;
    }
    
    /**
    * Creating the connection to data dase.
    * 
    * @return wpdb Obiekt bazy danych
    */
    private static function connectToDatabase() {
        if ($_SERVER['SERVER_ADDR'] != '94.152.207.180') {
            $database_host = 'localhost';
            $database_name = 'warsawexpo_dodatkowa';
            $database_user = 'warsawexpo_admin-dodatkowy';
            $database_password = 'N4c-TsI+I4-C56@q';
        } else {
            $database_host = 'localhost';
            $database_name = 'automechanicawar_dodatkowa';
            $database_user = 'automechanicawar_admin-dodatkowa';
            $database_password = '9tL-2-88UAnO_x2e';
        }
        $custom_db = new wpdb($database_user, $database_password, $database_name, $database_host);
        return $custom_db;
    }

    /**
    * Static method to get associates fairs from central data base.
    * 
    * @return array @output 
    */
    private static function assosciateData($name) {
        $custom_db = self::connectToDatabase();

        $as_fair_data = array();

        $prepared_query = $custom_db->prepare("SELECT * FROM associates WHERE side1 = %s OR side2 = %s OR side3 = %s OR side4 = %s OR side5 = %s OR side6 = %s OR primary_fair = %s LIMIT 1", $name, $name, $name, $name, $name, $name, $name, $name);

        $results = $custom_db->get_results($prepared_query);

        foreach($results[0] as $fair){
            if($fair === null){
                return $as_fair_data;
            } elseif (strlen($fair) > 5 && !($as_fair_data['primary'])) {
                $prepared_query = $custom_db->prepare("SELECT fair_name, fair_logo, fair_logo_en, fair_web FROM fairs WHERE fair_name = %s", $fair);
                $as_fair_data['primary'] = $custom_db->get_results($prepared_query);
            } elseif (strlen($fair) > 5) {
                $prepared_query = $custom_db->prepare("SELECT fair_name, fair_logo, fair_logo_en, fair_web FROM fairs WHERE fair_name = %s", $fair);
                $as_fair_data[] = $custom_db->get_results($prepared_query);
            }
        }
    }

    /**
    * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        extract( shortcode_atts( array(
            'association_fair_logo_white' => '',
        ), $atts ));

        $output = '';
        $sorted = array();

        $name = do_shortcode('[trade_fair_name]');
        
        $unsorted = self::assosciateData($name);

        foreach($unsorted as $id => $to_sort){
            if(is_null($to_sort[0]->fair_logo_en)){
                $img_en_source = $img_source = 'https://' . $to_sort[0]->fair_web . '/doc/' . $to_sort[0]->fair_logo;
            } else {
                $img_en_source = 'https://' . $to_sort[0]->fair_web . '/doc/' . $to_sort[0]->fair_logo_en;
                $img_source = 'https://' . $to_sort[0]->fair_web . '/doc/' . $to_sort[0]->fair_logo;
            }
            if($to_sort[0]->fair_name != $name){
                if($id !== 'primary'){
                    $sorted[] = array(
                        'img' => self::languageChecker($img_source, $img_en_source),
                        'site'=> $to_sort[0]->fair_web
                    );
                } else {
                    $sorted['primary'] = array(
                        'img' => self::languageChecker($img_source, $img_en_source),
                        'site'=> $to_sort[0]->fair_web
                    );
                }
            }
        }

        $unique_id = rand(10000, 99999);
        $element_unique_id = 'pweAssociation-' . $unique_id;

        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') .' !important';
        
        if ($text_color == "" || $text_color == "#000000 !important" || $text_color == "black !important") {
            $text_shadow = "white";
        } else {
            $text_shadow = "black";
        }

        if (!empty($sorted)) {
            $output .= 
            '<style>
                .row-container:has(#'. $element_unique_id .') {
                    background-color: '. self::$fair_colors['Accent'] .';
                }
                .pwe-association {
                    position: relative;
                    width: 100%;
                }
                .pwe-association-title {
                    display: flex;
                    justify-content: center;
                }
                #'. $element_unique_id .' .pwe-association-title h2 {
                    color: '. $text_color .';
                    text-shadow: 2px 2px '. $text_shadow .';
                    box-shadow: 9px 9px 0px -6px '. $text_color .';
                    margin: 0;
                }
                .pwe-association-logotypes {
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 10px;
                }
                .pwe-association-logotypes .pwe-as-logo,
                .pwe-association-logotypes .slides div {
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                    min-width: 140px;
                    height: fit-content;
                    aspect-ratio: 3/2;
                    margin: 5px;
                }
                .pwe-association-logotypes .as-primary .pwe-as-logo {
                    min-width: 200px;
                }
                
            </style>';

            if ($association_fair_logo_white == 'true') {
                $output .= '<style>
                                .pwe-association-logotypes .as-side .pwe-as-logo,
                                .pwe-association-logotypes .slides div {
                                    filter: brightness(0) invert(1);
                                    transition: all .3s ease;
                                }
                                .pwe-association-logotypes .slides .as-primary div {
                                    filter: inherit;
                                }
                            </style>';
            }
            
            $output .= '
                <div id="'. $element_unique_id .'" class="pwe-association">
                    <div class="main-heading-text pwe-association-title">
                        <h2>'. 
                            self::languageChecker(
                                <<<PL
                                Wydarzenia Towarzyszące
                                PL,
                                <<<EN
                                Accompanying Events
                                EN
                            )
                        .'</h2>
                    </div>
                    <div class="pwe-association-logotypes">';
                        if (self::checkForMobile() == '1'){
                            $slider_array = array();
                            foreach($sorted as $id => $logo){
                                if(get_locale() == 'pl_PL') {
                                    $slider_array[] = array(
                                        'id'   => $id,
                                        'img'  => $logo['img'],
                                        'site' => "https://" . preg_replace('/^(https?:\/\/(www\.)?|(www\.)?)/', '', $logo['site'])
                                    );
                                } else {
                                    $slider_array[] = array(
                                        'id'   => $id,
                                        'img' => $logo['img'],
                                        'site' => "https://" . preg_replace('/^(https?:\/\/(www\.)?|(www\.)?)/', '', $logo['site']) . "/en"
                                    );
                                }
                            }   
                                                 
                            require_once plugin_dir_path(dirname( __FILE__ )) . 'scripts/logotypes-slider.php';
                            $output .= PWELogotypesSlider::sliderOutput($slider_array);

                        } else { 
                            foreach ($sorted as $id => $logo){
                                if(get_locale() == 'pl_PL') {
                                    $logosUrl = "https://" . preg_replace('/^(https?:\/\/(www\.)?|(www\.)?)/', '', $logo['site']);
                                } else $logosUrl = "https://" . preg_replace('/^(https?:\/\/(www\.)?|(www\.)?)/', '', $logo['site']) . "/en";
                                if($id === 'primary'){
                                    $output .= '
                                        <a class="as-primary" target="_blank" href="'. $logosUrl .'">
                                            <div class="pwe-as-logo" style="background-image: url(' . $logo['img'] . ');"></div>
                                        </a>';
                                } else {
                                    $output .= '
                                        <a class="as-side" target="_blank" href="'. $logosUrl .'">
                                            <div class="pwe-as-logo" style="background-image: url(' . $logo['img'] . ');"></div>
                                        </a>';
                                }
                            }
                        }
            $output .= '
                    </div>
                </div>';
        } 

        $output .= '
            <script>
            {
                document.addEventListener("DOMContentLoaded", function() {
                    let pweElement = document.querySelector(".pwelement_'. self::$rnd_id .'");
                    let pweElementRow = document.querySelector(".row-container:has(.pwelement_'. self::$rnd_id .')");
                    let pweAssociation = document.querySelector(".pwelement_'. self::$rnd_id .' .pwe-association") !== null;
                    let isInPweHeader = pweElementRow !== null && pweElementRow.closest(".pwe-header") !== null;
    
                    if (pweElementRow !== null && pweAssociation == false && !isInPweHeader) {
                        pweElementRow.classList.add("desktop-hidden", "tablet-hidden", "mobile-hidden");
                    }
                });
            }
            </script>';

        return $output;
    }
}
