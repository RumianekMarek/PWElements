<?php 

/**
 * Class PWElementGallerySlider
 * Extends PWElements class and defines a custom Visual Composer element for vouchers.
 */
class PWElementGallerySlider extends PWElements {

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
                'heading' => esc_html__('Gallery catalog', 'pwelement'),
                'param_name' => 'gallery_catalog',
                'description' => __('Put catalog name in /doc/ where are logotypes.', 'pwelement'),
                'save_always' => true,
                'dependency' => array(
                    'element' => 'pwe_element',
                    'value' => 'PWElementGallerySlider',
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

        extract( shortcode_atts( array(
            'gallery_catalog' => '',
        ), $atts ));

        $gallery_files = ($gallery_catalog == "") ? "/doc/galeria" : "/doc/" . $gallery_catalog;
        $files = self::findAllImages($gallery_files, false);

        $output = '
            <link href="/wp-content/plugins/PWElements/elements/css/fotorama.css" rel="stylesheet">

            <div id="pweSliderGallery" class="pwe-container-slider-gallery">
                <div class="pwe-slider-gallery-wrapper" style="margin: 0 auto; max-width: 1000px;">
                    <div 
                    id="galleryContainer"
                    class="fotorama" 
                    data-allowfullscreen="native" 
                    data-nav="thumbs" 
                    data-navposition="middle"
                    data-thumbwidth="144"
                    data-thumbheight="96"
                    data-transition="crossfade" 
                    data-loop="true" 
                    data-autoplay="true" 
                    data-arrows="true" 
                    data-click="true"
                    data-swipe="false"
                    data-thumbwidth="100px">';

                    foreach ($files as $file) { 
                        $output .= '<img src="' . $file . '" alt="galery image">';
                    }
                    
         $output .= '</div>
                </div>
            </div>

            <script src="/wp-content/plugins/PWElements/elements/js/fotorama.js"></script>';   

        return $output;

    }
}

?>
