<?php
/**
* Class PWElementContact
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementContact extends PWElements {

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
            $element_output[] = 
                array(
                    'type' => 'checkbox',
                    'group' => 'PWE Element',
                    'heading' => __('Horizontal display', 'pwelement'),
                    'param_name' => 'horizontal',
                    'value' => '',
                    'dependency' => array(
                        'element' => 'pwe_element',
                        'value' => 'PWElementContact',
                    ),
                );
        return $element_output;
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        $all_images = self::findAllImages('/doc/galeria/zdjecia_wys_odw', 2);
        
        $text_color = 'color:' . self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'black') . '!important;';
        $img_shadow = 'box-shadow: 9px 9px 0px -6px ' . self::findColor(self::$main2_color,  self::$accent_color, 'black'). ' !important;';

        $output = '';

        $output .= '
            <style>
                .raw-pwe-container{
                    display:flex; 
                    align-items: center;
                    gap: 18px;
                }
                .pwe-container-contact img{
                    max-width:150px !important;
                }

                .pwelement_' . self::$rnd_id . ' .uncode_text_column :is(p, a),
                .pwelement_' . self::$rnd_id . ' .heading-text h4{
                    ' . $text_color . '
                }
                .pwe-container-contact .main-heading-text {
                padding-top: 0;
                }
                @media (max-width:860px){
                    .uncell:has(.pwe-container-contact) {
                        padding: 36px 18px 36px 18px !important;
                    }
                    .raw-pwe-container{
                        flex-wrap: wrap;
                        justify-content: center;
                        text-align: center;
                        flex-direction: column;
                    }
                    .raw-pwe-container p{ 
                        min-width: 160px;
                    }
                }';

        if ($atts["horizontal"] == "true") {
            $output .= '
                .pwe-container-contact-items {
                    display: flex; 
                    flex-wrap: wrap;
                    justify-content: space-evenly;
                }

                .raw-pwe-container {
                    flex-direction: column;
                    text-align: center;
                    flex: 1;
                }
                .half-block-padding{
                    padding: 9px 0;
                }';
        }

        $output .= '
            </style>

            <div id="kontakty" class="pwe-container-contact">
                <div class="heading-text el-text main-heading-text half-block-padding">
                    <h4>'.
                    self::languageChecker(
                        <<<PL
                            Masz pytania?
                        PL,
                        <<<EN
                            Do you have any questions?
                        EN
                        )
                    .'</h4>
                </div>

                <div class="pwe-container-contact-items">
                    <div class="raw-pwe-container half-block-padding" pwe-image-shadow>
                        <img src="/wp-content/plugins/PWElements/media/WystawcyZ.jpg" alt="grafika wystawcy">
                        <div class="uncode_text_column">
                            <p>'.
                            self::languageChecker(
                                <<<PL
                                    Zostań wystawcą<br><a href="tel:48 517 121 906">+48 517 121 906</a>
                                PL,
                                <<<EN
                                    Become an Exhibitor<br><a href="tel:48 517 121 906">+48 517 121 906</a>
                                EN
                            )
                            .'</p>
                        </div>
                    </div>
                        
                    <div class="raw-pwe-container half-block-padding pwe-image-shadow">
                        <img src="/wp-content/plugins/PWElements/media/Odwiedzajacy.jpg" alt="grafika odwiedzajacy">
                        <div class="uncode_text_column">
                            <p>'.
                                self::languageChecker(
                                    <<<PL
                                        Odwiedzający<br><a href="tel:48 513 903 628">+48 513 903 628</a>
                                    PL,
                                    <<<EN
                                        Visitors<br><a href="tel:48 513 903 628">+48 513 903 628</a>
                                    EN
                                )
                            .'</p>
                        </div>
                    </div>
                        
                    <div class="raw-pwe-container half-block-padding pwe-image-shadow">
                        <img src="/wp-content/plugins/PWElements/media/Media.jpg"  alt="grafika media">
                        <div class="uncode_text_column">
                            <p>'.
                                self::languageChecker(
                                    <<<PL
                                        Współpraca z mediami<br><a href="mailto:media@warsawexpo.eu">media@warsawexpo.eu</a>
                                    PL,
                                    <<<EN
                                        For Media<br><a href="mailto:media@warsawexpo.eu">media@warsawexpo.eu</a>
                                    EN
                                )
                            .'</p>
                        </div>
                    </div>
                        
                    <div class="raw-pwe-container half-block-padding pwe-image-shadow">
                        <img src="/wp-content/plugins/PWElements/media/WystawcyO.jpg" alt="grafika obsluga">
                        <div class="uncode_text_column">
                            <p>'.
                            self::languageChecker(
                                <<<PL
                                    Obsługa Wystawców<br><a href="tel:48 501 239 338">+48 501 239 338</a>
                                PL,
                                <<<EN
                                    Exhibitor service<br><a href="tel:48 501 239 338">+48 501 239 338</a>
                                EN
                            )
                            .'</p>
                        </div>
                    </div>
                    
                    <div class="raw-pwe-container half-block-padding pwe-image-shadow">
                        <img src="/wp-content/plugins/PWElements/media/Technicy.jpg" alt="grafika technicy">
                        <div class="uncode_text_column" style="overflow-wrap: anywhere;">
                            <p>';
                                if ($atts["horizontal"] != "true") {
                                    $output .= self::languageChecker(
                                        <<<PL
                                            Obsługa techniczna wystawców<br>
                                        PL,
                                        <<<EN
                                            Technical service of exhibitors<br>
                                        EN
                                    );
                                };
                                $output .= '<a href="mailto:konsultanttechniczny@warsawexpo.eu"><span style="display:block;"> konsultanttechniczny</span><span style="display:block;">@warsawexpo.eu</span></a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>';         

    return $output;
    }
}
