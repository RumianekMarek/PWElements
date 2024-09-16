<?php

class PWEExhibitorGenerator extends PWECommonFunctions {
    
    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    public static $fair_forms;

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        self::$rnd_id = rand(10000, 99999);
        self::$fair_forms = $this->findFormsGF();
        self::$fair_colors = $this->findPalletColors();
        self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

        foreach(self::$fair_colors as $color_key => $color_value){
            if(strpos($color_key, 'main2') != false){
                self::$main2_color = $color_value;
            }
        }
        
        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));

        add_action('init', array($this, 'initVCMapPWEExhibitorGenerator'));
        add_shortcode('pwe_exhibitor_generator', array($this, 'PWEExhibitorGeneratorOutput'));
    }

    /**
     * Initialize VC Map PWEExhibitorGenerator.
     */
    public function initVCMapPWEExhibitorGenerator() { 

            require_once plugin_dir_path(__FILE__) . 'classes/exhibitor-visitor-generator.php';
            require_once plugin_dir_path(__FILE__) . 'classes/exhibitor-worker-generator.php';
      
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map( array(
                'name' => __( 'PWE Exhibitor Generator', 'pwe_exhibitor_generator'),
                'base' => 'pwe_exhibitor_generator',
                'category' => __( 'PWE Elements', 'pwe_exhibitor_generator'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
                'params' => array_merge(
                    array( 
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Exhibitor Generator',
                            'heading' => __('Select form mode', 'pwe_exhibitor_generator'),
                            'param_name' => 'exhibitor_generator_mode',
                            'save_always' => true,
                            'value' => array(
                                'Exhibitor Visitor Generator' => 'PWEExhibitorVisitorGenerator',
                                'Exhibitor Worker Generator' => 'PWEExhibitorWorkerGenerator',
                            ),
                            'std' => 'PWEExhibitorVisitorGenerator',
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Exhibitor Generator',
                            'heading' => __('Select form', 'pwe_exhibitor_generator'),
                            'param_name' => 'exhibitor_generator_form_id',
                            'save_always' => true,
                            'value' => array_merge(
                                array('Wybierz' => ''),
                                self::$fair_forms,
                            ),
                        ),
                        array(
                            'type' => 'textarea_raw_html',
                            'group' => 'PWE Exhibitor Generator',
                            'heading' => __('Footer HTML Text', 'pwe_exhibitor_generator'),
                            'param_name' => 'exhibitor_generator_html_text',
                            'param_holder_class' => 'backend-textarea-raw-html',
                            'save_always' => true,
                        ),
                    ),
                ),
            ));
        }
    }

    /**
     * Check class for file if exists.
     *
     * @return array
     */
    private function findClassElements() {
        // Array off class placement
        return array(
            'PWEExhibitorVisitorGenerator'     => 'classes/exhibitor-visitor-generator.php',
            'PWEExhibitorWorkerGenerator'      => 'classes/exhibitor-worker-generator.php',
        );
    }

    /**
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('assets/exhibitor-generator-style.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/exhibitor-generator-style.css');
        wp_enqueue_style('pwe-exhibitor-generator-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts($atts){
        $js_file = plugins_url('assets/exhibitor-generator-skript.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/exhibitor-generator-skript.js');
        wp_enqueue_script('pwe-exhibitor-generator-js', $js_file, array('jquery'), $js_version, true);
    }  

    /**
     * Output method for pwe_exhibitor_generator shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Shortcode content.
     * @return string
     */
    public function PWEExhibitorGeneratorOutput($atts) {

        extract( shortcode_atts( array(
            'exhibitor_generator_mode' => '',
        ), $atts ));

        if ($this->findClassElements()[$exhibitor_generator_mode]){
            require_once plugin_dir_path(__FILE__) . $this->findClassElements()[$exhibitor_generator_mode];
            
            if (class_exists($exhibitor_generator_mode)) {
                $output_class = new $exhibitor_generator_mode;
                $output = $output_class->output($atts, $content);
            } else {
                // Log if the class doesn't exist
                echo '<script>console.log("Class '. $exhibitor_generator_mode .' does not exist")</script>';
                $output = '';
            }
        } else {
            echo '<script>console.log("File with class ' . $exhibitor_generator_mode .' does not exist")</script>';
        }
        
        $output = do_shortcode($output);

        $exhibitor_generator_id_word = $exhibitor_generator_mode == 'PWEExhibitorVisitorGenerator' ? 'Visitor' : 'Worker';
        $exhibitor_generator_class_word = $exhibitor_generator_mode == 'PWEExhibitorVisitorGenerator' ? 'visitor' : 'worker';

        $exhibitor_generator_id = 'pweExhibitor'. $exhibitor_generator_id_word .'Generator';
        $exhibitor_generator_class = 'pwe-exhibitor-'. $exhibitor_generator_class_word .'-generator';

        $output_html = '
        <div id="'. $exhibitor_generator_id .'" class="'. $exhibitor_generator_class .'">
            ' . $output . '
            <div style="text-align: center; display: flex; justify-content: center;" class="heading-text exhibitor-generator-tech-support">
                <h3>'.
                    self::languageChecker(
                        <<<PL
                            Potrzebujesz pomocy?<br>
                            Skontaktuj się z nami - <a href="mailto:info@warsawexpo.eu">info@warsawexpo.eu</a>
                        PL,
                        <<<EN
                            Need help?<br>
                            Contact us - <a href="mailto:info@warsawexpo.eu">info@warsawexpo.eu</a>
                        EN
                    )
                .'</h3>

            </div>
        </div>';

        return $output_html;
    }
}