<?php 

/**
 * Class PWElementConfSection
 * Extends PWElements class and defines a pwe Visual Composer element.
 */
class PWElementConfSection extends PWElements {

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
                'heading' => __('Custom title first', 'pwelement'),
                'param_name' => 'pwe-conferences-section-tags',
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementConfSection',
                ),
            ),
        );
        return $element_output;
    }    

    public static function output($atts) {    
        extract( shortcode_atts( array(
            'pwe-conferences-section-tags' => '',
        ), $atts ));  
        
        $output ='
            <style>
                
            </style>

            <div id="pweConfSection" class="pwe-container-conferences-section" style="background-image: url(/wp-content/plugins/PWElements/media/conference-background.webp);">
                <div class="pwe-conferences-section-columns">
                    <div class="pwe-conferences-section-column">
                        <h5>[trade_fair_conferance]</h5>
                        <h2>MIĘDZYNARODOWA KONFERENCJA BRANŻY [trade_fair_opisbranzy]</h2>
                        <p>Rozwijaj swoje umiejętności z najlepszymi! Sprawdź ofertę wykładów i szkoleń przygotowaną specjalnie dla Ciebie.</p>
                        <p>#recycling #wastemanagement #recyrkulacja #nowości</p>
                    </div>
                    <div class="pwe-conferences-section-column">
                        <div class="pwe-conferences-section-logo">
                            <img src="/doc/logo.webp"alt="conference logo">
                        </div>
                        <div class="pwe-conferences-section-btn">
                            <div class="pwe-btn-container">
                                <a class="pwe-link btn pwe-btn" href="'. $profile_tickets_button_link .'"</a>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

        return $output;
    }