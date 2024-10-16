<?php

class PWEExhibitorGenerator{
    
    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    public static $fair_forms;

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        $pweComonFunction = new PWECommonFunctions;
        self::$rnd_id = rand(10000, 99999);
        self::$fair_forms = $pweComonFunction->findFormsGF('id');
        self::$fair_colors = $pweComonFunction->findPalletColors();
        self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

        foreach(self::$fair_colors as $color_key => $color_value){
            if(strpos($color_key, 'main2') != false){
                self::$main2_color = $color_value;
            }
        }
        add_action('init', array($this, 'initVCMapPWEExhibitorGenerator'));
        add_shortcode('pwe_exhibitor_generator', array($this, 'PWEExhibitorGeneratorOutput'));
        
        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));

    }

    /**
     * Initialize VC Map PWEExhibitorGenerator.
     */
    public function initVCMapPWEExhibitorGenerator() { 

        require_once plugin_dir_path(__FILE__) . 'classes/exhibitor-visitor-generator.php';
        require_once plugin_dir_path(__FILE__) . 'classes/exhibitor-worker-generator.php';
      
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __( 'PWE Exhibitor Generator', 'pwe_exhibitor_generator'),
                'base' => 'pwe_exhibitor_generator',
                'category' => __( 'PWE Elements', 'pwe_exhibitor_generator'),
                'admin_enqueue_css' => plugin_dir_url(dirname(__DIR__)) . 'backend/backendstyle.css',
                'class' => 'costam',
                'params' => array( 
                    array(
                        'type' => 'dropdown',
                        'group' => 'PWE Element',
                        'heading' => __('Select form', 'pwelement'),
                        'param_name' => 'generator_form_id',
                        'save_always' => true,
                        'value' => array_merge(
                            array('Wybierz' => ''),
                            self::$fair_forms,
                        ),
                    ),
                    array(
                        'type' => 'dropdown',
                        'group' => 'PWE Element',
                        'heading' => __('Select form mode', 'pwelement'),
                        'param_name' => 'exhibitor_generator_mode',
                        'save_always' => true,
                        'value' => array(
                            'Generator gości wystawców' => 'PWEExhibitorVisitorGenerator',
                            'Generator pracowników wystawców' => 'PWEExhibitorWorkerGenerator',
                        ),
                        'std' => 'PWEExhibitorVisitorGenerator',
                    ),
                    array(
                        'type' => 'textarea_raw_html',
                        'group' => 'PWE Element',
                        'heading' => __('Footer HTML Text', 'pwelement'),
                        'param_name' => 'generator_html_text',
                        'param_holder_class' => 'backend-textarea-raw-html',
                        'save_always' => true,

                    ),
                    array(
                        'type' => 'checkbox',
                        'group' => 'PWE Element',
                        'heading' => __('Połączeni z Katalogiem wystawców', 'pwelement'),
                        'param_name' => 'generator_catalog',
                        'save_always' => true,
                    ),
                    array(
                        'type' => 'param_group',
                        'group' => 'PWE Element',
                        'heading' => __('Personalizowanie Pod wystawce', 'pwelement'),
                        'description' => __('Dodaj wystawce do grupy i sprawdź na stronie pod parametrem <br> ?wysatwca=...', 'pwelement'),
                        'param_name' => 'company_edition',
                        'params' => array(
                            array(
                                'type' => 'textfield',
                                'heading' => __('UNIKALNY! token  do adresu url <br> ?wystawca=', 'pwelement'),
                                'param_name' => 'exhibitor_token',
                                'save_always' => true,
                                'admin_label' => true,
                                'value' => '',
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Header Custom', 'pwelement'),
                                'param_name' => 'exhibitor_heder',
                                'save_always' => true,
                                'admin_label' => true,
                                'value' => '',
                            ),
                            array(
                                'type' => 'attach_image',
                                'heading' => __('Logo Wystawcy', 'pwelement'),
                                'param_name' => 'exhibitor_logo',
                                'save_always' => true,
                            ),
                            array(
                                'type' => 'textfield',
                                'heading' => __('Nazwa Wystawcy', 'pwelement'),
                                'param_name' => 'exhibitor_name',
                                'save_always' => true,
                                'admin_label' => true,
                                'value' => '',
                            ),
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
            'PWEExhibitorVisitorGenerator' => 'classes/exhibitor-visitor-generator.php',
            'PWEExhibitorWorkerGenerator'  => 'classes/exhibitor-worker-generator.php',
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
        $send_data = [
            'send_file' => plugins_url('assets/mass_vip.php', __FILE__ ),
            'secret' =>  hash_hmac('sha256', $_SERVER["HTTP_HOST"], '^GY0ZlZ!xzn1eM5'),
        ];
        
        $js_file = plugins_url('assets/exhibitor-generator-script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/exhibitor-generator-script.js');
        wp_enqueue_script('pwe-exhibitor-generator-js', $js_file, array('jquery'), $js_version, true);
        wp_localize_script( 'exclusions-js', 'send_data', $send_data );
    }  

    /**
     * Static method to hide specjal input.
     * Returns form for GF filter.
     *
     * @param array @form object
     */
    public static function hide_field_by_label( $form, $com_name ) {
        $label_to_hide = ['FIRMA ZAPRASZAJĄCA', 'FIRMA', 'INVITING COMPANY', 'COMPANY'];

        foreach( $form['fields'] as &$field ) {
            if( in_array($field->label, $label_to_hide) ) {
                $field->cssClass .= ' gf_hidden';
                $field->defaultValue = $com_name;
            }
        }
        return $form;
    }

    /**
     * Static method to create data for generator personalization.
     * Returns data in array format.
     *
     * @param array @exhibitor_id string
     */
    public static function catalog_data($exhibitor_id) {
        $katalog_id = do_shortcode('[trade_fair_catalog]');
        
        $today = new DateTime();
        $formattedDate = $today->format('Y-m-d');
        $token = md5("#22targiexpo22@@@#".$formattedDate);
        $canUrl = 'https://export.www2.pwe-expoplanner.com/mapa.php?token='.$token.'&id_targow='.$katalog_id;
        $json = file_get_contents($canUrl);
        if ($json !== null){
            $search_id = $exhibitor_id . '.00';
            $data_array = json_decode($json, true);
            $exhibitors_data = reset($data_array)['Wystawcy'];
            $exhibitor =  $exhibitors_data[$search_id];
            return  $exhibitor;
        };
        return null;
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
                $output = $output_class->output($atts);
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
                    PWECommonFunctions::languageChecker(
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
        </div>
        <div class="modal__element">
            <div class="inner">
                <span class="btn-close">x</span>
                <p style="max-width:90%;">'.
                    PWECommonFunctions::languageChecker(
                        <<<PL
                        Uzupełnij poniżej nazwę firmy zapraszającej oraz wgraj plik (csv, xls, xlsx) z danymi osób, które powinny otrzymać zaproszenia VIP GOLD. Przed wysyłką zweryfikuj zgodność danych.
                        PL,
                        <<<EN
                        Fill in below the name of the inviting company and the details of the people who should receive VIP GOLD invitations. Verify the accuracy of the data before sending.
                        EN
                    )
                .'</p>
                <input type="text" class="company" placeholder="'.
                    PWECommonFunctions::languageChecker(
                        <<<PL
                        Firma Zapraszająca (wpisz nazwę swojej firmy)
                        PL,
                        <<<EN
                        Inviting Company (your company's name)
                        EN
                    )
                .'"></input>
                <div class="file-uloader">
                    <label for="fileUpload">Wybierz plik z danymi</label>
                    <input type="file" id="fileUpload" name="fileUpload" accept=".csv, .xls, .xlsx">
                    <p class="under-label">Dozwolone rozszerzenia .csv, .xls, .xlsx</p>
                </div>
                <button class="wyslij btn-gold">'.
                    PWECommonFunctions::languageChecker(
                        <<<PL
                        Wyślij
                        PL,
                        <<<EN
                        Send
                        EN
                    )
                .'</button>
            <div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        ';

        return $output_html;
    }
}