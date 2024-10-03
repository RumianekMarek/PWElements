<?php 

/**
 * Class PWElementDonwload
 * Extends PWElements class and defines a pwe Visual Composer element for vouchers.
 */
class PWElementDonwload extends PWElements {

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
     * @param array @atts options
     */
    public static function output($atts) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white');

        $filter = ($text_color != 'white') ? '.pwelement_'.self::$rnd_id.' #download img { filter: invert(100%); }' : '';

        $output = '';   

        $output .= '
        <style>
            #download {
                display:flex;
                align-items: center;
                color:white; 
                border: 0;
                max-width: 500px;
                margin: auto;
                border-radius: 18px;
            }
            .pwelement_'.self::$rnd_id.' #download :is(h3, a){
                color: '.$text_color.' !important;
            }

            ' . $filter . '

            @media (max-width:959px){
                .t-m-display-none{
                    display:none;
                }
            }
        </style>
        
        <div id="download" class="pwe-download-container style-accent-bg single-block-padding">
            <div class="single-media-wrapper wpb_column t-m-display-none half-block-padding" style="flex:1;">
                <img src="/wp-content/plugins/PWElements/media/download-icon.png" alt="ikonka pobierania"/>
            </div>
            
            <div style="flex:5">
                <div class="heading-text el-text text-centered">'.
                self::languageChecker(
                    <<<PL
                    <h3 class="pl_PL">Dokumenty do pobrania:</h3>
                    PL,
                    <<<EN
                    <h3 class="en_US">Documents for Download</h3>
                    EN
                )
                .'</div>

                <div>
                    <p class="text-centered">'.
                    self::languageChecker(
                        <<<PL
                        <a href="https://warsawexpo.eu/docs/Regulamin-targow-pwe-2022.pdf" target="_blank" rel="noopener noreferrer">Regulamin targów</a><br>
                        <a href="https://warsawexpo.eu/docs/regulamin_obiektu.pdf" target="_blank" rel="noopener noreferrer">Regulamin obiektu</a><br>
                        <a href="https://warsawexpo.eu/docs/regulamin_zabudowy.pdf" target="_blank" rel="noopener noreferrer">Regulamin zabudowy</a><br>
                        <a href="https://warsawexpo.eu/docs/Regulamin na Voucher_2023.pdf" target="_blank" rel="noopener noreferrer">Regulamin Voucherów</a>
                        PL,
                        <<<EN
                        <a href="https://warsawexpo.eu/docs/regulamin_targ%C3%B3w_2021_en.pdf" target="_blank" rel="noopener noreferrer">Fair regulations</a><br>
                        <a href="https://warsawexpo.eu/docs/regulamin_obiektu_en.pdf" target="_blank" rel="noopener noreferrer">Facility regulations</a><br>
                        <a href="https://warsawexpo.eu/docs/building_regulations.pdf" target="_blank" rel="noopener noreferrer">Building regulations</a>
                        EN
                    )
                    .'</p> 
                </div> 
            </div>
        </div>';

        return $output;
    }
  }