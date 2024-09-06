<?php
/**
* Class PWElementGroups
* Extends PWElements class and defines a pwe Visual Composer element.
*/
class PWElementGroups extends PWElements {

    /**
     * Constructor method.
    * Calls parent constructor and adds an action for initializing the Visual Composer map.
    */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Static method to generate the HTML output for the PWE Element.
    * Returns the HTML output as a string.
    * 
    * @return string @output 
    */
    public static function output($atts) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . ' !important';

        $output = '
            <style>
                .pwelement_'. self::$rnd_id .' .pwe-container-grupy :is(h4, p , a){
                    color:' . $text_color . ';
                }
                .pwelement_'. self::$rnd_id .' .pwe-container-grupy h4 {
                    padding: 0 10px 5px 0;
                    box-shadow: 9px 9px 0px -6px ' . $text_color . ';
                }
                .pwelement_'. self::$rnd_id .' #pweGroupsLink {
                    text-decoration: underline;
                    color:' . $text_color . ';
                }
                @media (max-width:960px) {
                    .row:has(.pwelement_'. self::$rnd_id .') {
                        padding: 0 18px !important;
                    } 
                }
            </style>
            
            <div class="pwe-container-grupy style-accent-bg shadow-black single-block-padding">
                <div class="heading-text el-text text-uppercase">
                    <h4>'.
                        self::languageChecker(
                            <<<PL
                            Kontakt dla grup zorganizowanych
                            PL,
                            <<<EN
                            Contact for organized groups
                            EN
                        )
                    .'</h4>
                </div>

                <div>
                    <p>'.
                        self::languageChecker(
                        <<<PL
                            W celu zapewnienia państwu komfortowego udziału w naszych wydarzeniach, wstęp dla grup zorganizowanych możliwy jest tylko ostatniego dnia targowego. Przed wcześniejszym przybyciem zachęcamy do kontaktu przez formularz dostępny na stronie: <a id="pweGroupsLink" href="https://warsawexpo.eu/grupy" alt="link do rejestracji grup zorganizowanych" target="_blank">warsawexpo.eu/grupy</a>.
                            Pozostawienie plecaków oraz walizek w szatni jest obligatoryjne.
                        Na targach obowiązuje business dress code.
                        PL,
                        <<<EN
                            To ensure your comfortable participation in our events, admission for organized groups is only possible on the last day of the fair. Before your arrival, we encourage you to contact us through the form available on the website:  <a id="pweGroupsLink" href="https://warsawexpo.eu/en/groups" alt="link to group registration" target="_blank">warsawexpo.eu/en/groups</a>.
                            Leaving backpacks and suitcases in the cloakroom is mandatory.
                            A business dress code is required at the fair.
                        EN
                        )
                    .'</p>   
                </div>
            </div>';

        return $output;
    }
}