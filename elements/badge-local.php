<?php 

/**
 * Class PWBadgeElement
 * Extends PWElements class and defines a custom Visual Composer element.
 */
class PWBadgeElement extends PWElements {

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
                'heading' => __('Badge Form ID', 'pwelement'),
                'param_name' => 'badge_form_id',
                'value' => '',
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWBadgeElement',
                )
            ),
        );
        return $element_output;
    }

    /**
     * Static method to generate mass bages.
     * 
     * @param number @badge_form_id form id for Qr codes
     */
    public static function massGenerator($badge_form_id) {
        
        if (isset($_POST["submit"]) && !empty($_POST['input_6']) && isset($_POST['input_3'])){
            echo '<script>
            jQuery(function ($) {
                const gfMessage = $(".gform_confirmation_message a");
                if (gfMessage.length) {
                    const urlMessage = gfMessage.eq(0).attr("href")+"?parametr=masowy";
                    gfMessage.eq(0).attr("href", urlMessage)
                    gfMessage.eq(1).hide();
                    window.open(gfMessage.eq(1).attr("href"));
                }
            });
            </script>';
            $multi_badge = array();
            $multi_badge['form_id'] = $badge_form_id;
            
            foreach ($_POST as $key => $value) {
                
                if (strpos(strtolower($key), 'input') !== false) {
                    preg_match_all('/\d+/', $key, $id);
                    $filed = $id[0][0];
                    $multi_badge[$filed] = $value;
                }
            }
            
            for($i=1; $i<$_POST['multi_send']; $i++){  
                $entry_id = GFAPI::add_entry($multi_badge);
                $meta_key = '';
                for ($j=0; $j<=300;$j++){
                    if(gform_get_meta($entry_id , 'qr-code_feed_' . $j . '_url') != ''){
                        $meta_key = 'qr-code_feed_' . $j . '_url';
                        break;
                    }
                }
                $qr_code_url = (gform_get_meta($entry_id, $meta_key));
                $badge_url = 'https://warsawexpo.eu/assets/badge/local/loading.html?category='.$multi_badge[3].'&getname='.$multi_badge[1].'&firma='.$multi_badge[2].'&qrcode='.$qr_code_url;
                echo '<script>window.open("'.$badge_url.'");</script>';
            }
        }
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     * 
     * @param array @atts options
     * @return string @output
     */
    public static function output($atts) {
            $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';
            $btn_text_color = 'color:' . self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'black') . '!important; border-width: 0 !important;';
            $btn_color = 'background-color:' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'white') . '!important;';
            $btn_shadow_color = 'box-shadow: 9px 9px 0px -5px ' . self::findColor($atts['btn_shadow_color_manual_hidden'], $atts['btn_shadow_color'], 'black') . '!important;';
            
            $output = '';

            $output .= '<style>
                #badge-generator{
                    max-width: 800px;
                }
                #badge-generator :is(.gform_heading p, .gfield :is(input, legend), .gfield_radio label){
                    '.$text_color.'
                    opacity: 1;
                }
                #badge-generator .gform_footer input{
                    '.$btn_color
                    .$btn_text_color
                    .$btn_shadow_color.'
                    border: 2px solid black !important;
                }
                #badge-generator ::placeholder, .gform-field-label, .gform-field-label span{
                    color:black !important;
                    opacity: 1;
                }
            </style>';

            $output .= '<div id="badge-generator">[gravityform id="'.$atts['badge_form_id'].'" title="false" description="false" ajax="false"]</div>';
            
            if ($_GET['parametr'] === 'masowy') {
                self::massGenerator($atts['badge_form_id']);
            };

            $output .= '<script>
                jQuery(function ($) {
                    const gfWraper = $("#gform_wrapper_' . $atts['badge_form_id'] . '");
                    const gfFields = gfWraper.find(".gform_fields");
                    const gfButton = gfWraper.find(".gform_button");
                    gfButton.attr("name", "submit");
                    const multiInput = $("<input>", {
                        placeholder: "ilość identyfikatorów",
                        type: "text",
                        id: "multi_send",
                        name: "multi_send"
                    });
                    gfFields.append(multiInput);
                });
            </script>';
        return $output;
    }
}