<?php

class PWEHeader {
    public static $rnd_id;
    public static $fair_colors;
    public static $accent_color;
    public static $main2_color;
    public static $fair_forms;
    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        self::$fair_forms = $this->findFormsGF();
        self::$fair_colors = $this->findPalletColors();
        self::$accent_color = (self::$fair_colors['Accent']) ? self::$fair_colors['Accent'] : '';

        foreach(self::$fair_colors as $color_key => $color_value){
            if(strpos(strtolower($color_key), 'main2') !== false){
                self::$main2_color = $color_value;
            }
        }

        require_once plugin_dir_path(__FILE__) . '/../logotypes/logotypes-additional.php';
        require_once plugin_dir_path(__FILE__) . '/../elements/association.php';

        // Hook actions
        add_action('wp_enqueue_scripts', array($this, 'addingStyles'));
        add_action('wp_enqueue_scripts', array($this, 'addingScripts'));
        
        add_action('vc_before_init', array($this, 'inputRange'));
        add_action('vc_before_init', array($this, 'pweCheckbox'));

        add_action('init', array($this, 'initVCMapHeader'));
        add_shortcode('pwe_header', array($this, 'PWEHeaderOutput'));
    }

    /**
     * Initialize VC Map Elements.
     */
    public function initVCMapHeader() {
        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map(array(
                'name' => __('PWE Header', 'pwe_header'),
                'base' => 'pwe_header',
                'category' => __('PWE Elements', 'pwe_header'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
                'admin_enqueue_js' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendscript.js',
                'params' => array_merge(
                    array(
                        // colors setup
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select text color <a href="#" onclick="yourFunction(`text_color_manual_hidden`, `text_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'text_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select text color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'text_color_manual_hidden',
                                'value' => array(''),
                                'callback' => "hideEmptyElem",
                            ),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write text color <a href="#" onclick="yourFunction(`text_color`, `text_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for text color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select text shadow color <a href="#" onclick="yourFunction(`text_shadow_color_manual_hidden`, `text_shadow_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'text_shadow_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select shadow text color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'text_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write text shadow color <a href="#" onclick="yourFunction(`text_shadow_color`, `text_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'text_shadow_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for text shadow color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true,
                        ),                        
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select button color <a href="#" onclick="yourFunction(`btn_color_manual_hidden`, `btn_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'btn_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select button color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write button color <a href="#" onclick="yourFunction(`btn_color`, `btn_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'btn_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select button text color <a href="#" onclick="yourFunction(`btn_text_color_manual_hidden`, `btn_text_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'btn_text_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select button text color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_text_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write button text color <a href="#" onclick="yourFunction(`btn_text_color`, `btn_text_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'btn_text_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button text color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color_manual_hidden`, `btn_shadow_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'btn_shadow_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select button shadow color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'btn_shadow_color_manual_hidden',
                                'value' => array(''),
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color`, `btn_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'btn_shadow_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for button shadow color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true
                        ),    
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select main color <a href="#" onclick="yourFunction(`main_header_color_manual_hidden`, `main_header_color`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'main_header_color',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select main color for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'main_header_color_manual_hidden',
                                'value' => array(''),
                                'callback' => "hideEmptyElem",
                            ),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write main color <a href="#" onclick="yourFunction(`main_header_color`, `main_header_color_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'main_header_color_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for main color for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Select main color text <a href="#" onclick="yourFunction(`main_header_color_text_manual_hidden`, `main_header_color_text`)">Hex</a>', 'pwe_header'),
                            'param_name' => 'main_header_color_text',
                            'param_holder_class' => 'backend-fields backend-area-one-fifth-width',
                            'description' => __('Select main color text for the element.', 'pwe_header'),
                            'value' => $this->findPalletColors(),
                            'dependency' => array(
                                'element' => 'main_header_color_text_manual_hidden',
                                'value' => array(''),
                                'callback' => "hideEmptyElem",
                            ),
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'PWE Element',
                            'heading' => __('Write main color text <a href="#" onclick="yourFunction(`main_header_color_text`, `main_header_color_text_manual_hidden`)">Pallet</a>', 'pwe_header'),
                            'param_name' => 'main_header_color_text_manual_hidden',
                            'param_holder_class' => 'main-options pwe_dependent-hidden',
                            'description' => __('Write hex number for main color text for the element.', 'pwe_header'),
                            'value' => '',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Modes', 'pwe_header'),
                            'param_name' => 'pwe_header_modes', 
                            'admin_label' => true,
                            'value' => array(
                                'Default' => '',
                                'Simple mode' => 'simple_mode',
                                'Registration mode' => 'registration_mode',
                                'Coference mode' => 'conference_mode'
                            ),
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'PWE Element',
                            'heading' => __('Form id', 'pwelement'),
                            'param_name' => 'pwe_header_form_id',
                            'admin_label' => true,
                            'save_always' => true,
                            'value' => array_merge(
                              array('Wybierz' => ''),
                              self::$fair_forms,
                            ),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(
                                    'registration_mode',
                                    'conference_mode'
                                ),
                            ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'PWE Element',
                            'heading' => __('Conference mode', 'pwe_header'),
                            'param_name' => 'pwe_header_simple_conference',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(
                                    'simple_mode'
                                ),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Options',
                            'heading' => __('Conferece link', 'pwe_header'),
                            'description' => __('Default (/wydarzenia/ - PL), (/en/conferences/ - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_conference_link',
                            'save_always' => true,
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(
                                    'registration_mode',
                                    'conference_mode'
                                ),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Options',
                            'heading' => __('Conferece logo url', 'pwe_header'),
                            'description' => __('Default (/kongres/)', 'pwe_header'),
                            'param_name' => 'pwe_header_conference_logo_url',
                            'save_always' => true,
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(
                                    'registration_mode',
                                    'conference_mode'
                                ),
                            ),
                        ),
                        array(
                            'type' => 'dropdown',
                            'group' => 'Options',
                            'heading' => __('Background position', 'pwe_header'),
                            'param_name' => 'pwe_header_bg_position',
                            'value' => array(
                              'Top' => 'top',
                              'Center' => 'center',
                              'Bottom' => 'bottom'
                            ),
                            'std' => 'center',
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Options',
                            'heading' => __('Turn on buttons', 'pwe_header'),
                            'param_name' => 'pwe_header_button_on',
                            'description' => __('Select options to display button:', 'pwe_header'),
                            'save_always' => true,
                            'value' => array(
                              __('register', 'pwe_header') => 'register',
                              __('ticket', 'pwe_header') => 'ticket',
                              __('conference', 'pwe_header') => 'conference',
                            ),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(''),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Options',
                            'heading' => __('Tickets button link', 'pwe_header'),
                            'description' => __('Default (/bilety/ - PL), (/en/tickets/ - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_tickets_button_link',
                            'save_always' => true,
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(''),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Options',
                            'heading' => __('Register button link', 'pwe_header'),
                            'description' => __('Default (/rejestracja/ - PL), (/en/registration/ - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_register_button_link',
                            'save_always' => true,
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(''),
                            ),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Options',
                            'heading' => __('Conferences button link', 'pwe_header'),
                            'description' => __('Default (/wydarzenia/ - PL), (/en/conferences/ - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_conferences_button_link',
                            'save_always' => true,
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(''),
                            ),
                        ),
                        array(
                            'type' => 'textarea_raw_html',
                            'group' => 'Options',
                            'heading' => __('Conferences custom title', 'pwe_header'),
                            'description' => __('Default (Konferencje - PL), (Conferences - EN)', 'pwe_header'),
                            'param_name' => 'pwe_header_conferences_title',
                            'param_holder_class' => 'backend-textarea-raw-html',
                            'save_always' => true,
                            'value' => base64_encode($pwe_header_conferences_title),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(''),
                            ),
                        ),
                        array(
                            'type' => 'colorpicker',
                            'group' => 'Options',
                            'heading' => __('Overlay color', 'pwe_header'),
                            'param_name' => 'pwe_header_overlay_color',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'input_range',
                            'group' => 'Options',
                            'heading' => __('Overlay opacity', 'pwe_header'),
                            'param_name' => 'pwe_header_overlay_range',
                            'value' => '0',
                            'min' => '0',
                            'max' => '1',
                            'step' => '0.01',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'input_range',
                            'group' => 'Options',
                            'heading' => __('Max width logo (px)', 'pwe_header'),
                            'description' => __('Default 260px', 'pwe_header'),
                            'param_name' => 'pwe_header_logo_width',
                            'value' => '260',
                            'min' => '100',
                            'max' => '600',
                            'step' => '1',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Options',
                            'heading' => __('Main logo color', 'pwe_header'),
                            'param_name' => 'pwe_header_logo_color',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Options',
                            'heading' => __('Congress logo color', 'pwe_header'),
                            'param_name' => 'pwe_header_congress_logo_color',
                            'description' => __('Add kongres-color.webp', 'pwe_header'),
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(
                                    '',
                                    'registration_mode',
                                    'conference_mode'
                                ),
                            ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Options',
                            'heading' => __('Hide association', 'pwe_header'),
                            'param_name' => 'pwe_header_association_hide',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(
                                    '',
                                    'registration_mode',
                                    'conference_mode'
                                ),
                            ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Options',
                            'heading' => __('No margin&padding main logo', 'pwe_header'),
                            'param_name' => 'pwe_header_logo_marg_pag',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(''),
                            ),
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'Options',
                            'heading' => __('Additional buttons', 'pwe_header'),
                            'param_name' => 'pwe_header_buttons',
                            'params' => array(
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('URL', 'pwe_header'),
                                    'param_name' => 'pwe_header_button_link',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => __('Text', 'pwe_header'),
                                    'param_name' => 'pwe_header_button_text',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                            ),
                            'dependency' => array(
                                'element' => 'pwe_header_modes',
                                'value' => array(''),
                            ),
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'Logotypes',
                            'heading' => __('Logotypes', 'pwe_header'),
                            'param_name' => 'pwe_header_logotypes',
                            'params' => array(
                                array(
                                'type' => 'attach_images',
                                'heading' => __('Logotypes catalog', 'pwe_header'),
                                'param_name' => 'logotypes_media',
                                'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Logotypes catalog', 'pwe_header'),
                                    'param_name' => 'logotypes_catalog',
                                    'description' => __('Put catalog name in /doc/ where are logotypes.', 'pwe_header'),
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Logotypes Title', 'pwe_header'),
                                    'param_name' => 'logotypes_title',
                                    'description' => __('Set title to diplay over the gallery', 'pwe_header'),
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => esc_html__('Logotypes Name', 'pwe_header'),
                                    'param_name' => 'logotypes_name',
                                    'description' => __('Set custom name thumbnails', 'pwe_header'),
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'input_range',
                                    'heading' => __('Gallery width (%)', 'pwe_header'),
                                    'param_name' => 'logotypes_width',
                                    'value' => '100',
                                    'min' => '0',
                                    'max' => '100',
                                    'step' => '1',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Turn off slider', 'pwe_header'),
                                    'param_name' => 'logotypes_slider_off',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'checkbox',
                                    'heading' => __('Turn on captions', 'pwe_header'),
                                    'param_name' => 'logotypes_caption_on',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Logotypes width (___px)', 'pwe_header'),
                                    'param_name' => 'logotypes_items_width',
                                    'save_always' => true,
                                ),
                            ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Congress widget',
                            'heading' => __('Turn off widget', 'pwe_header'),
                            'param_name' => 'pwe_congress_widget_off',
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Title widget', 'pwe_header'),
                            'description' => __('Default (Konferencje - PL), (Conference - EN)', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_title',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Button text', 'pwe_header'),
                            'description' => __('Default (WEŹ UDZIAŁ - PL), (TAKE PART - EN)', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_button',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Button link', 'pwe_header'),
                            'description' => __('Default (/rejestracja/ - PL), (/en/registration/ - EN)', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_button_link',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'textfield',
                            'group' => 'Congress widget',
                            'heading' => __('Buttons width', 'pwe_header'),
                            'description' => __('Default 200px', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_buttons_width',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'colorpicker',
                            'group' => 'Congress widget',
                            'heading' => __('Congress accent color', 'pwe_header'),
                            'param_holder_class' => 'backend-area-one-fourth-width',
                            'param_name' => 'pwe_congress_widget_color',
                            'save_always' => true,
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'Congress widget',
                            'heading' => __('Congress items', 'pwe_header'),
                            'param_name' => 'pwe_congress_widget_items',
                            'params' => array(
                                array(
                                    'type' => 'attach_image',
                                    'heading' => __('Congress image', 'pwe_header'),
                                    'param_name' => 'congress_item_image',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Congress link', 'pwe_header'),
                                    'description' => __('Default (/wydarzenia/ - PL), (/en/conferences/ - EN)', 'pwe_header'),
                                    'param_name' => 'congress_item_link',
                                    'save_always' => true,
                                ),
                                array(
                                    'type' => 'textfield',
                                    'heading' => __('Caption text', 'pwe_header'),
                                    'description' => __('Default (Dowiedz się więcej - PL), (Find out more - EN)', 'pwe_header'),
                                    'param_name' => 'congress_item_caption',
                                    'save_always' => true,
                                ),
                            ),
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Aditional options',
                            'heading' => __('Logotypes color', 'pwe_header'),
                            'param_name' => 'logotypes_slider_logo_color',
                            'description' => __('Check if you want to change the logotypes white to color. ', 'pwe_header'),
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),   
                        ),
                        array(
                            'type' => 'checkbox',
                            'group' => 'Aditional options',
                            'heading' => __('Association fair logo color', 'pwe_header'),
                            'param_name' => 'association_fair_logo_color',
                            'description' => __('Check if you want to change the logotypes color to color. ', 'pwe_header'),
                            'save_always' => true,
                            'value' => array(__('True', 'pwe_header') => 'true',),
                        ),
                        array(
                            'type' => 'param_group',
                            'group' => 'Replace Strings',
                            'param_name' => 'pwe_replace',
                            'params' => array(
                                array(
                                    'type' => 'textarea',
                                    'heading' => __('Input HTML', 'pwelement'),
                                    'param_name' => 'input_replace_html',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                                array(
                                    'type' => 'textarea',
                                    'heading' => __('Output HTML', 'pwelement'),
                                    'param_name' => 'output_replace_html',
                                    'save_always' => true,
                                    'admin_label' => true
                                ),
                            ),
                        ),
                        // Add additional options from class extends
                        ...PWElementAdditionalLogotypes::additionalArray(),
                    )
                ),
            ));
        }
    }

    /**
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('css/style.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'css/style.css');
        wp_enqueue_style('pwelement-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts(){
        $js_file = plugins_url('js/script.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'js/script.js');
        wp_enqueue_script('pwelement-js', $js_file, array('jquery'), $js_version, true);
    }

    /**
     * Adding Styles
     */
    public static function findColor($primary, $secondary, $default = ''){
        if($primary != ''){
            return $primary;
        } elseif ($secondary != ''){
            return $secondary;
        } else {
            return $default;
        }
    }

    /**
     * Finding preset colors pallet.
     *
     * @return array
     */
    public function findPalletColors(){
        $uncode_options = get_option('uncode');
        $accent_uncode_color = $uncode_options["_uncode_accent_color"];
        $custom_element_colors = array();

        if (isset($uncode_options["_uncode_custom_colors_list"]) && is_array($uncode_options["_uncode_custom_colors_list"])) {
            $custom_colors_list = $uncode_options["_uncode_custom_colors_list"];
      
            foreach ($custom_colors_list as $color) {
                $title = $color['title'];
                $color_value = $color["_uncode_custom_color"];
                $color_id = $color["_uncode_custom_color_unique_id"];

                if ($accent_uncode_color != $color_id) {
                    $custom_element_colors[$title] = $color_value;
                } else {
                    $accent_color_value = $color_value;
                    $custom_element_colors = array_merge(array('Accent' => $accent_color_value), $custom_element_colors);
                }
            }
            $custom_element_colors = array_merge(array('Default' => ''), $custom_element_colors);
        }
        return $custom_element_colors;
    }

    /**
     * Laguage check for text
     * 
     * @param string $pl text in Polish.
     * @param string $pl text in English.
     * @return string 
     */
    public static function languageChecker($pl, $en = ''){
        if(get_locale() == 'pl_PL'){ 
            return $pl;
        } else {
            return $en;
        }
    }

    /**
     * Laguage check for text
     * 
     * @param bool $logo_color schould logo be in color.
     * @return string
     */
    public static function findBestLogo($logo_color = false){
        $filePaths = array(
            '/doc/logo-color-en.webp',
            '/doc/logo-color-en.png',
            '/doc/logo-color.webp',
            '/doc/logo-color.png',
            '/doc/logo-en.webp',
            '/doc/logo-en.png',
            '/doc/logo.webp',
            '/doc/logo.png'
        );
        
        switch (true){
            case(get_locale() == 'pl_PL'):
                if($logo_color){
                    foreach ($filePaths as $path) {
                        if (strpos($path, '-en.') === false && file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                } else {
                    foreach ($filePaths as $path) {
                        if ( strpos($path, 'color') === false && strpos($path, '-en.') === false && file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                }
                break;

            case(get_locale() == 'en_EN'):
                if($logo_color){
                    foreach ($filePaths as $path) {
                        if (file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                } else {
                    foreach ($filePaths as $path) {
                        if (strpos($path, 'color') === false && file_exists(ABSPATH . $path)) {
                            return '<img src="' . $path . '"/>';
                        }
                    }
                }
                break;
        }
    }

    /**
     * Finding URL of all images based on katalog
     */
    public static function findAllImages($firstPath, $image_count,  $secondPath = '/doc/galeria'){
        $firstPath = $_SERVER['DOCUMENT_ROOT'] . $firstPath;
        
        if (is_dir($firstPath) && !empty(glob($firstPath . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE))) {
            $exhibitorsImages = glob($firstPath . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
        } else {
            $secondPath = $_SERVER['DOCUMENT_ROOT'] . $secondPath;
            $exhibitorsImages = glob($secondPath . '/*.{jpeg,jpg,png,webp,JPEG,JPG,PNG,WEBP}', GLOB_BRACE);
        }
        $count = 0;
        foreach($exhibitorsImages as $image){
            if($count >= $image_count){
                break;
            } else {
                $exhibitors_path[] = substr($image, strpos($image, '/doc/'));
                $count++;
            }
        }

        return $exhibitors_path;
    }

    /**
     * Laguage check for text
     * 
     * @param bool $logo_color schould logo be in color.
     * @return string
     */
    public static function findBestFile($file_path){
        $filePaths = array(
            '.webp',
            '.jpg',
            '.png'
        );

        foreach($filePaths as $com){
            if(file_exists(ABSPATH . $file_path . $com)){
                return $file_path . $com;
            }
        }
    }

    /**
     * Adding element input[type="range"]
     */
    public static function inputRange() {
        if ( function_exists( 'vc_add_shortcode_param' ) ) {
            vc_add_shortcode_param( 'input_range', array('PWEHeader', 'input_range_field_html') );
        }
    }
    public static function input_range_field_html( $settings, $value ) {
        $id = uniqid('range_');
        return '<div class="pwe-input-range">'
            . '<input type="range" '
            . 'id="' . esc_attr( $id ) . '" '
            . 'name="' . esc_attr( $settings['param_name'] ) . '" '
            . 'class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" '
            . 'value="' . esc_attr( $value ) . '" '
            . 'min="' . esc_attr( $settings['min'] ) . '" '
            . 'max="' . esc_attr( $settings['max'] ) . '" '
            . 'step="' . esc_attr( $settings['step'] ) . '" '
            . 'oninput="document.getElementById(\'value_' . esc_attr( $id ) . '\').innerHTML = this.value" '
            . '/>'
            . '<span id="value_' . esc_attr( $id ) . '">' . esc_attr( $value ) . '</span>'
            . '</div>';
    }

    /**
     * Finding all GF forms
     *
     * @return array
     */
    public function findFormsGF(){
        $pwe_forms_array = array();
        if (method_exists('GFAPI', 'get_forms')) {
            $pwe_forms = GFAPI::get_forms();
            foreach ($pwe_forms as $form) {
                $pwe_forms_array[$form['id']] = $form['title'];
            }
        }
        return $pwe_forms_array;
    } 

    /**
     * Finding all target form id
     *
     * @param string $form_name 
     * @return string
     */
    public static function findFormsID($form_name){
        $pwe_form_id = '';
        if (method_exists('GFAPI', 'get_forms')) {
            $pwe_forms = GFAPI::get_forms();
            foreach ($pwe_forms as $form) {
                if ($form['title'] === $form_name){
                    $pwe_form_id = $form['id'];
                    break;
                }
            }
        }
        return $pwe_form_id;
    }

    /**
     * Adding custom checkbox element
     */
    function pweCheckbox() {
        if (function_exists('vc_add_shortcode_param')) {
            vc_add_shortcode_param('pwe_checkbox', array('PWEHeader', 'pwe_checkbox_html'));
        }
    }
    /**
     * Generate HTML for custom checkbox
     */
    public static function pwe_checkbox_html($settings, $value) {
        $checked = $value === 'true' ? 'checked' : '';
        $id = uniqid('pwe_checkbox_');
    
        return '<div class="pwe-checkbox">'
            . '<input type="checkbox" '
            . 'id="' . esc_attr($id) . '" '
            . 'name="' . esc_attr($settings['param_name']) . '" '
            . 'class="wpb_vc_param_value ' . esc_attr($settings['param_name']) . ' ' . esc_attr($settings['type']) . '_field" '
            . 'value="'.$value.'" '
            . $checked
            . ' onclick="this.value = this.checked ? \'true\' : \'\';" />'
            . '</div>';
    }

     /**
     * Trade fair date existance check
     * 
     * @return bool
     */
    public static function isTradeDateExist(){

        $seasons = ["nowa data", "wiosna", "lato", "jesień", "zima", "new date", "spring", "summer", "autumn", "winter"];
        $trade_date_lower = strtolower(do_shortcode('[trade_fair_date]'));

        // Przeszukiwanie tablicy w poszukiwaniu pasującego sezonu
        foreach ($seasons as $season) {
            if (strpos($trade_date_lower, strtolower($season)) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Function to change color brightness (taking color in hex format)
     *
     * @return array
     */
    public static function adjustBrightness($hex, $steps) {
        // Convert hex to RGB
        $hex = str_replace('#', '', $hex);
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        // Shift RGB values
        $r = max(0, min(255, $r + $steps));
        $g = max(0, min(255, $g + $steps));
        $b = max(0, min(255, $b + $steps));

        // Convert RGB back to hex
        return '#' . str_pad(dechex($r), 2, '0', STR_PAD_LEFT)
                . str_pad(dechex($g), 2, '0', STR_PAD_LEFT)
                . str_pad(dechex($b), 2, '0', STR_PAD_LEFT);
    }

    
    /**
     * Output method for PWelement shortcode.
     *
     * @param array $atts Shortcode attributes.
     * @param string $content Shortcode content.
     * @return string
     */
    public function PWEHeaderOutput($atts, $content = null) {
        $text_color = self::findColor($atts['text_color_manual_hidden'], $atts['text_color'], 'white') . ' !important';
        $btn_text_color = self::findColor($atts['btn_text_color_manual_hidden'], $atts['btn_text_color'], 'white') . ' !important; border-width: 0 !important';
        $btn_color = self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black') . '!important';
        $btn_border = '1px solid ' . self::findColor($atts['btn_color_manual_hidden'], $atts['btn_color'], 'black') . ' !important';

        if ($text_color == '' || $text_color == '#000000 !important' || $text_color == 'black !important') {
            $text_shadow = 'white !important;';
        } else {
            $text_shadow = 'black !important;';
        }

        $mobile = preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']);

        global $registration_button_text, $pwe_header_form_id;

        extract( shortcode_atts( array(
            'pwe_header_button_on' => '',
            'pwe_header_modes' => '',
            'pwe_header_form_id' => '',
            'pwe_header_simple_conference' => '',
            'pwe_header_conference_link' => '',
            'pwe_header_conference_logo_url' => '',
            'pwe_header_bg_position' => '',
            'pwe_header_tickets_button_link' => '',
            'pwe_header_register_button_link' => '',
            'pwe_header_conferences_button_link' => '',
            'pwe_header_buttons' => '',
            'pwe_header_conferences_title' => '',
            'pwe_header_logotypes' => '',
            'pwe_header_overlay_color' => '',
            'pwe_header_overlay_range' => '',
            'pwe_header_logo_width' => '',
            'pwe_header_logo_color' => '',
            'pwe_header_logo_marg_pag' => '',
            'pwe_header_congress_logo_color' => '',
            'association_fair_logo_color' => '',
            'pwe_congress_widget_off' => '',
            'pwe_congress_widget_title' => '',
            'pwe_congress_widget_button' => '',
            'pwe_congress_widget_button_link' => '',
            'pwe_congress_widget_buttons_width' => '',
            'pwe_congress_widget_color' => '',
            'pwe_congress_widget_items' => '',
            'pwe_header_association_hide' => '',
            'pwe_replace' => '',
        ), $atts ));

        // Replace strings
        $pwe_replace_urldecode = urldecode($pwe_replace);
        $pwe_replace_json = json_decode($pwe_replace_urldecode, true);
        $input_replace_array_html = array();
        $output_replace_array_html = array();
        foreach ($pwe_replace_json as $replace_item) {
            $input_replace_array_html[] = $replace_item["input_replace_html"];
            $output_replace_array_html[] = $replace_item["output_replace_html"];
        }

        if ($pwe_header_modes == "conference_mode") {
            $main_badge_color = self::$accent_color;
        } else {
            $main_badge_color = self::$main2_color;
        }

        $main_header_color = self::findColor($atts['main_header_color_manual_hidden'], $atts['main_header_color'], $main_badge_color) . '!important';
        $main_header_color_text = self::findColor($atts['main_header_color_text_manual_hidden'], $atts['main_header_color_text'], 'white') . '!important';
        
        $darker_btn_color = self::adjustBrightness($btn_color, -20);
        $darker_form_btn_color = self::adjustBrightness($main_header_color, -20);

        if ($pwe_header_modes == "conference_mode") {
            $pwe_header_overlay_color = empty($pwe_header_overlay_color) ? self::$main2_color : $pwe_header_overlay_color;
            $pwe_header_overlay_range = $pwe_header_overlay_range == 0 ? 0.7 : $pwe_header_overlay_range; 
        }

        $pwe_header_logo_width = ($pwe_header_logo_width == '') ? '260px' : $pwe_header_logo_width;
        $pwe_header_logo_width = str_replace("px", "", $pwe_header_logo_width);

        $output = '
            <style>
                .row-parent:has(.pwelement_'. SharedProperties::$rnd_id.' .pwe-header) {
                    max-width: 100%;
                    padding: 0 !important;  
                }
                .wpb_column:has(.pwelement_'. SharedProperties::$rnd_id.' .pwe-header) {
                    max-width: 100%;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                    min-height: 60vh;
                    max-width: 1200px;
                    margin: 0 auto;
                    display: flex;
                    z-index: 2;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo {
                    max-width: '. $pwe_header_logo_width .'px !important;
                    width: 100%;
                    height: auto;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-container:before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background-color: '. $pwe_header_overlay_color .';
                    opacity: '. $pwe_header_overlay_range .';
                    z-index: 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-background {
                    background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                    padding: 18px 0;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text :is(h1, h2), .pwe-header .pwe-logotypes-title h4 {
                    color: '. $text_color .';
                    text-transform: uppercase;
                    text-align: center;
                    width: auto;
                }             
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-logotypes-title {
                    justify-content: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-logotypes-title h4 {
                    box-shadow: 9px 9px 0px -6px '. $text_color .';
                }   
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h1 {
                    font-size: 30px;
                } 
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h2 {
                    font-size: 36px;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .slides div p,
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-logotypes-gallery-wrapper div p{
                    color: '. $text_color .';
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .dots-container {
                    display: none !important;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-header-logotypes,
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-association {
                    transition: .3s ease;
                    opacity: 0;
                }
                @media (min-width: 300px) and (max-width: 1200px) {
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header-text h1 {
                        font-size: calc(20px + (30 - 20) * ( (100vw - 300px) / (1200 - 300) ));
                    }
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header-text h2 {
                        font-size: calc(24px + (36 - 24) * ( (100vw - 300px) / (1200 - 300) ));
                    }
                }
                @media (max-width: 960px) {
                    .row-parent:has(.pwelement_'.SharedProperties::$rnd_id.' .pwe-header) {
                        padding: 0 !important;
                    }
                }
            </style>';

            if (glob($_SERVER['DOCUMENT_ROOT'] . '/doc/header_mobile.webp', GLOB_BRACE) && $pwe_header_modes != "conference_mode") {
                $output .= '
                <style>
                    @media (max-width: 569px) {
                        #pweHeader .pwe-header-container {
                            background-image: url(/doc/header_mobile.webp) !important;
                        }
                    }
                </style>';
            } 

        if ($pwe_header_modes != "registration_mode" && $pwe_header_modes != "conference_mode") {
            $output .= '
            <style>
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                    max-width: 750px;
                    justify-content: space-evenly;
                    align-items: center;
                    display: flex;
                    flex-direction: column;
                    padding: 36px 18px;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text :is(h1, h2), .pwe-header .pwe-logotypes-title h4 {
                    text-shadow: 2px 2px '. $text_shadow .';
                }   
                .pwelement_'. SharedProperties::$rnd_id .' .header-button a {
                    padding: 0 !important;
                    height: 70px;
                    display: flex;
                    flex-flow: column;
                    align-items: center;
                    justify-content: center;
                    text-transform: uppercase;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-buttons {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    gap: 20px;
                    padding: 18px 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-btn-container {
                    width: 320px;
                    height: 75px;
                    padding: 0;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-btn {
                    background-color: '. $btn_color .';
                    color: '. $btn_text_color .';
                    border: '. $btn_border .';
                    width: 100%;
                    height: 100%;
                    transform: scale(1) !important;
                    transition: .3s ease;
                    font-size: 15px;
                    font-weight: 600;
                    padding: 6px 18px !important;
                    letter-spacing: 0.1em;
                    text-align: center;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-btn:hover {
                    color: '. $btn_text_color .';
                    background-color: '. $darker_btn_color .'!important;
                    border: 1px solid '. $darker_btn_color .'!important;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-container-logotypes-gallery {
                    position: relative;
                    z-index: 1;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logotypes {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: center;
                    max-width: 1200px;
                    width: 100%;
                    margin: 0 auto;
                    padding: 0 18px 36px;
                    gap: 18px;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-association {
                    padding: 0 18px 36px;
                }
                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-header-curled-sheet {
                    z-index: 1;
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 400px;
                }
                @media (max-width: 1200px) {
                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-header-curled-sheet {
                        display: none;
                    }
                }
                @media (max-width: 960px) {
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header-logotypes .pwe-container-logotypes-gallery {
                        width: 100% !important;
                    }
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header .pwe-btn-container {
                        width: 260px;
                        height: 70px;
                    }
                    .pwelement_'.SharedProperties::$rnd_id.' .pwe-header .pwe-btn {
                        font-size: 13px;
                    }
                }
            </style>';
        }

        $partnerImages = glob($_SERVER['DOCUMENT_ROOT'] . '/doc/partnerzy/*.{jpeg,jpg,png,webp,JPG,PNG,JPEG,WEBP}', GLOB_BRACE);
        $base_url = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $base_url .= "://".$_SERVER['HTTP_HOST'];

        $trade_fair_name = (get_locale() == 'pl_PL') ? '[trade_fair_name]' : '[trade_fair_name_eng]';
        $trade_fair_date = (get_locale() == 'pl_PL') ? '[trade_fair_date]' : '[trade_fair_date_eng]';

        if ($pwe_header_modes == "simple_mode" &&  $pwe_header_simple_conference == true) {

            $trade_fair_desc = (get_locale() == 'pl_PL') ? '[trade_fair_conferance]' : '[trade_fair_conferance_eng]';

            if($pwe_header_logo_color != 'true') {
                $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/kongres.webp') ? '/doc/kongres.webp' : "/doc/logo.webp";
            } else {
                $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/kongres-color.webp') ? '/doc/kongres-color.webp' : '/doc/kongres.webp';
            }

        } else {

            $trade_fair_desc = (get_locale() == 'pl_PL') ? '[trade_fair_desc]' : '[trade_fair_desc_eng]';

            if($pwe_header_logo_color != 'true') {
                if (get_locale() == 'pl_PL') {
                    $logo_url = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo.webp') ? '/doc/logo.webp' : '/doc/logo.png');
                } else {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-en.webp') || file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-en.png')) {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-en.webp') ? "/doc/logo-en.webp" : "/doc/logo-en.png";
                    } else {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo.webp') ? "/doc/logo.webp" : "/doc/logo.png";
                    }  
                }
            } else {
                if (get_locale() == 'pl_PL') {
                    $logo_url = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color.webp') ? '/doc/logo-color.webp' : '/doc/logo-color.png');
                } else {
                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color-en.webp') || file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color-en.png')) {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color-en.webp') ? "/doc/logo-color-en.webp" : "/doc/logo-color-en.png";
                    } else {
                        $logo_url = file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/logo-color.webp') ? "/doc/logo-color.webp" : "/doc/logo-color.png";
                    }
                }
            }

        }

        $file_path_header_background = glob('doc/background.*');
        if (!empty($file_path_header_background)) {
            $file_path_header_background = $file_path_header_background[0];
            $file_url = $base_url . '/' . $file_path_header_background;
        }

        if ($pwe_header_modes == "simple_mode") {
            $output .= '
                <style>
                    .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                        padding: 36px;
                    }
                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                        min-height: auto !important;
                    }
                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                        display: flex;
                        flex-direction: column-reverse;
                    }
                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h2 {
                        font-size: calc(24px + (40 - 24) * ( (100vw - 300px) / (1200 - 300) ));
                    }
                    @media (min-width: 960px) {
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                            min-height: 350px !important;
                            height: 350px;
                        }
                        .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                            max-width: 1200px;
                            flex-direction: row;
                            gap: 60px;
                        }
                    }
                </style>';
        }

        if ($pwe_header_logo_marg_pag == 'true') {
            $output .= '
                <style>
                    .pwelement_'. SharedProperties::$rnd_id .' .header-wrapper-column {
                        padding: 0 18px 36px;
                    }
                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                        padding: 0 0 18px;
                    }
                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h1 {
                        margin: 0;
                    }
                </style>';
        }

        $positions = ['top', 'center', 'bottom'];
        foreach ($positions as $position) {
            if (in_array($position, explode(',', $pwe_header_bg_position))) {
                $output .= '
                    <style>
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-background {
                            background-position: '. $position .' !important;
                        } 
                    </style>';
                break;
            }
        } 

        if ($pwe_header_modes != "simple_mode") {

            // Accompanying Fairs
            if ($association_fair_logo_color != 'true') {
                $output .= '
                    <style>
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-association-logotypes .as-side .pwe-as-logo,
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-association-logotypes .slides div {
                            filter: brightness(0) invert(1);
                            transition: all .3s ease;
                        }
                        .pwelement_'. SharedProperties::$rnd_id .' .pwe-association-logotypes .slides .as-primary div {
                            filter: inherit;
                        }
                    </style>';
            }

        }
        
        $background_congress = $base_url . '/wp-content/plugins/PWElements/media/conference-background.webp';
        $background_header = ($pwe_header_modes == "conference_mode") ? $background_congress : $file_url;

        $output .= '<div id="pweHeader" class="pwe-header">

            <div style="background-image: url('. $background_header .');"  class="pwe-header-container pwe-header-background">
                <div class="pwe-header-wrapper">';
                    if ($pwe_header_modes != "registration_mode" && $pwe_header_modes != "conference_mode") {

                        $output .= '
                        <div class="header-wrapper-column">

                            <img class="pwe-header-logo" src="'. $logo_url .'" alt="logo-'. $trade_fair_name .'">

                            <div class="pwe-header-text">
                                <h1>'. $trade_fair_desc .'</h1>
                                <h2>'. $trade_fair_date .'</h2>
                            </div>';

                            if ($pwe_header_modes != "simple_mode") {

                                $output .= '<div class="pwe-header-buttons">';
                                    
                                    if (get_locale() == 'pl_PL') {
                                        $pwe_header_tickets_button_link = empty($pwe_header_tickets_button_link) ? "/bilety/" : $pwe_header_tickets_button_link;
                                        $pwe_header_register_button_link = empty($pwe_header_register_button_link) ? "/rejestracja/" : $pwe_header_register_button_link;
                                        $pwe_header_conferences_button_link = empty($pwe_header_conferences_button_link) ? "/wydarzenia/" : $pwe_header_conferences_button_link;
                                    } else {
                                        $pwe_header_tickets_button_link = empty($pwe_header_tickets_button_link) ? "/en/tickets/" : $pwe_header_tickets_button_link;
                                        $pwe_header_register_button_link = empty($pwe_header_register_button_link) ? "/en/registration/" : $pwe_header_register_button_link;
                                        $pwe_header_conferences_button_link = empty($pwe_header_conferences_button_link) ? "/en/conferences/" : $pwe_header_conferences_button_link;
                                    }
                                    
                                    $target_blank = (strpos($pwe_header_conferences_button_link, 'http') !== false) ? 'target="blank"' : '';

                                    if (in_array('register', explode(',', $pwe_header_button_on))) {
                                        $output .='<div id="pweBtnRegistration" class="pwe-btn-container header-button">';
                                            $output .= '<a class="pwe-link pwe-btn" href="'. $pwe_header_register_button_link .'" '. 
                                                            self::languageChecker(
                                                                <<<PL
                                                                alt="link do rejestracji">Zarejestruj się<span style="display: block; font-weight: 300;">Odbierz darmowy bilet</span>
                                                                PL,
                                                                <<<EN
                                                                alt="link to registration">Register<span style="display: block; font-weight: 300;">Get a free ticket</span>
                                                                EN
                                                            )
                                                        .'</a>';   
                                            $output .='</div>';
                                    }
                                    if (in_array('ticket', explode(',', $pwe_header_button_on))) {
                                        $output .= '<div id="pweBtnTickets" class="pwe-btn-container header-button">';
                                            $output .= '<a class="pwe-link pwe-btn" href="'. $pwe_header_tickets_button_link .'" '. 
                                                            self::languageChecker(
                                                                <<<PL
                                                                alt="link do biletów">Kup bilet
                                                                PL,
                                                                <<<EN
                                                                alt="link to tickets">Buy a ticket
                                                                EN
                                                            )
                                                        .'</a>';
                                        $output .= '</div>';
                                    }
                                    if (in_array('conference', explode(',', $pwe_header_button_on))) {
                                        if (empty($pwe_header_conferences_title)) {
                                            $pwe_header_conferences_title = (get_locale() == 'pl_PL') ? 'KONFERENCJE' : 'CONFERENCES';
                                        } else {
                                            $pwe_header_conferences_title = urldecode(base64_decode($pwe_header_conferences_title));
                                        }
                                        $output .= '<div id="pweBtnConferences" class="pwe-btn-container header-button">';
                                        $output .= '<a class="pwe-link pwe-btn" href="'. $pwe_header_conferences_button_link .'" '. $target_blank .' title="'.
                                                        self::languageChecker(
                                                            <<<PL
                                                            konferencje
                                                            PL,
                                                            <<<EN
                                                            conferences
                                                            EN
                                                        ).'">'. $pwe_header_conferences_title 
                                                    .'</a>';
                                        $output .= '</div>';
                                    }

                                    $pwe_header_buttons_urldecode = urldecode($pwe_header_buttons);
                                    $pwe_header_buttons_json = json_decode($pwe_header_buttons_urldecode, true);
                                    if (is_array($pwe_header_buttons_json)) {
                                        foreach ($pwe_header_buttons_json as $button) {
                                            $button_url = $button["pwe_header_button_link"];
                                            $button_text = $button["pwe_header_button_text"];

                                            $target_blank_aditional = (strpos($button_url, 'http') !== false) ? 'target="blank"' : '';
                                            if(!empty($button_url) && !empty($button_text) ) {
                                                $output .= '<div class="pwe-btn-container header-button">
                                                    <a class="pwe-link pwe-btn" href="'. $button_url .'" '. $target_blank_aditional .' alt="'. $button_url .'">'. $button_text .'</a>
                                                </div>';
                                            } 
                                        }
                                    }
                                
                                $output .= '</div>';
                            }

                        $output .= '</div>';

                        if ($pwe_header_modes != "simple_mode") {

                            if ($pwe_congress_widget_off != 'true') {
                                require_once plugin_dir_path(__FILE__) . '/../widgets/congress-widget.php';
                            }

                            if ($pwe_header_association_hide != true) {
                                // Accompanying Fairs
                                $output .= PWElementAssociates::output($atts);
                            }
                        }

                        $pwe_header_logotypes_urldecode = urldecode($pwe_header_logotypes);
                        $pwe_header_logotypes_json = json_decode($pwe_header_logotypes_urldecode, true);
                        if ($pwe_header_modes != "simple_mode") {
                            if (is_array($pwe_header_logotypes_json) && !empty($pwe_header_logotypes_json)) {
                                $output .= '<div class="pwe-header-logotypes">';
                                    foreach ($pwe_header_logotypes_json as $logotypes) {
                                        $logotypes_width = $logotypes["logotypes_width"];
                                        $logotypes_media = $logotypes["logotypes_media"];
                                        $logotypes_catalog = $logotypes["logotypes_catalog"];
                                        if(!empty($logotypes_catalog) || !empty($logotypes_media)) {
                                            // Adding the result from additionalOutput to $output
                                            $output .= PWElementAdditionalLogotypes::additionalOutput($atts, $logotypes);
                                        }
                                    }
                                $output .= '</div>';
                            }
                        }
                    
                        if ($pwe_header_modes != "simple_mode") {
                            require_once plugin_dir_path(__FILE__) . '/../widgets/parking-widget.php';
                            if (count($pwe_congress_widget_items_json) == 1 && !empty($congress_image_url)) {
                                $output .= '<div class="pwe-header-curled-sheet"><img src="/wp-content/plugins/PWElements/media/zawijas.png" alt="zawijas"></div>';
                            } 
                        }
 
                    } else if ($pwe_header_modes == "registration_mode" || $pwe_header_modes == "conference_mode") {
                        $start_date = do_shortcode('[trade_fair_datetotimer]');
                        $end_date = do_shortcode('[trade_fair_enddata]');

                        // Function to transform the date
                        function transform_dates($start_date, $end_date) {
                            // Convert date strings to DateTime objects
                            $start_date_obj = DateTime::createFromFormat('Y/m/d H:i', $start_date);
                            $end_date_obj = DateTime::createFromFormat('Y/m/d H:i', $end_date);

                            // Check if the conversion was correct
                            if ($start_date_obj && $end_date_obj) {
                                // Get the day, month and year from DateTime objects
                                $start_day = $start_date_obj->format('d');
                                $end_day = $end_date_obj->format('d');
                                $month = $start_date_obj->format('m');
                                $year = $start_date_obj->format('Y');

                                //Build the desired format
                                $formatted_date = "{$start_day}-{$end_day}|{$month}|{$year}";
                                return $formatted_date;
                            } else {
                                return "Invalid dates";
                            }
                        }

                        // Transform the dates to the desired format
                        $formatted_date = transform_dates($start_date, $end_date);

                        if (self::isTradeDateExist()) {
                            $actually_date = (get_locale() == 'pl_PL') ? '[trade_fair_date]' : '[trade_fair_date_eng]';
                        } else {
                            $actually_date = $formatted_date;  
                        }

                        if ($pwe_header_congress_logo_color != true) {
                            $congress_logo_url = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/kongres.webp') ? '/doc/kongres.webp' : '');
                        } else {
                            $congress_logo_url = (file_exists($_SERVER['DOCUMENT_ROOT'] . '/doc/kongres-color.webp') ? '/doc/kongres-color.webp' : '/doc/kongres.webp');
                        }
                        $pwe_header_conference_logo_url = (empty($pwe_header_conference_logo_url)) ? $congress_logo_url : $pwe_header_conference_logo_url;
                        $pwe_header_conference_link = empty($pwe_header_conference_link) 
                        ? (get_locale() == 'pl_PL' ? '/wydarzenia/' : '/en/conferences') 
                        : $pwe_header_conference_link;
                        $pwe_header_reg_logo = ($pwe_header_modes == "conference_mode") ? $pwe_header_conference_logo_url : $logo_url;
                        $pwe_header_reg_logo_link = ($pwe_header_modes == "conference_mode") ? $pwe_header_conference_link : $base_url; 

                        $trade_fair_edition_shortcode = do_shortcode('[trade_fair_edition]');
                        $trade_fair_edition_text = (get_locale() == 'pl_PL') ? ". edycja" : ". edition";
                        $trade_fair_edition_first = (get_locale() == 'pl_PL') ? "Edycja Premierowa" : "Premier Edition";
                        $trade_fair_edition = ($trade_fair_edition_shortcode == 1) ? $trade_fair_edition_first : $trade_fair_edition_shortcode . $trade_fair_edition_text;
                        
                        if ($pwe_header_modes == "registration_mode") {
                            $pwe_header_title = $trade_fair_desc;
                            $pwe_header_title_short = (get_locale() == 'pl_PL') ? "[trade_fair_desc_short]" : "[trade_fair_desc_short_eng]";
                        } else if ($pwe_header_modes == "conference_mode") {
                            $pwe_header_title = (get_locale() == 'pl_PL') ? "[trade_fair_conferance]" : "[trade_fair_conferance_eng]";
                            $pwe_header_title_short = (get_locale() == 'pl_PL') ? "[trade_fair_conferance]" : "[trade_fair_conferance_eng]";
                        }
                        
                        $output .= '
                        <style>
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                                position: relative;
                                display: flex;
                                padding: 0 18px 36px;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .header-info-column,
                            .pwelement_'. SharedProperties::$rnd_id .' .header-form-column {
                                width: 50%;
                                display: flex;
                                justify-content: center;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .header-info-column {
                                flex-direction: column;
                                align-items: center;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .header-form-column {
                                display: flex;
                                flex-direction: column;
                                justify-content: start;
                                align-items: center;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container {
                                position: relative;
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                align-items: center;
                                margin-top: 18px;
                                padding: 24px; 
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container:before {
                                content: "";
                                position: absolute;
                                top: 0;
                                right: 0;
                                bottom: 0;
                                left: 0;
                                border-radius: 16px;
                            } 
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container h1 {
                                text-transform: uppercase;
                                padding-top: 12px;
                                font-size: 22px !important;
                                margin: 0;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container :is(h1, h2, p) {
                                position: relative;
                                z-index: 2;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container :is(h1, h2, p:not(.pwe-header-edition)),
                            .pwelement_'. SharedProperties::$rnd_id .' .form-logo-container h2 {
                                color: '. $main_header_color_text .';
                                text-align: center;
                                font-weight: 700;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-edition,
                            #pweForm .form-edition {
                                text-align: center;
                                font-weight: 700;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-edition {
                                max-width: '. $pwe_header_logo_width .'px !important;
                                width: 100%;
                                background: white;
                                border-radius: 0;
                                color: '. $main_header_color .';
                                font-size: 28px;
                                margin: 0;
                                margin-top: 9px;
                                padding: 0;
                                line-height: 1.1;
                                text-transform: uppercase;
                            } 
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text :is(h1, h2), 
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-logotypes-title h4, 
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-association-title h2 {
                                text-shadow: 0 0 1px '. $text_shadow .';
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container h2 {
                                margin: 0;
                                font-size: 28px !important;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo {
                                max-width: '. $pwe_header_logo_width .'px !important;
                                margin: 0 20px;
                                position: relative;
                                z-index: 2;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .header-info-column .pwe-association {
                                margin-top: 36px;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .header-form-column .pwe-association {
                                display: none;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header .pwe-logotypes-title h4 {
                                box-shadow: none !important; 
                            } 
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logotypes {
                                margin-top: 36px;
                                width: 100%;
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' #pweForm .pwe-btn {
                                background-color: '. $main_header_color .';
                                border: 2px solid '. $main_header_color .';
                                color: '. $main_header_color_text .';
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' #pweForm .pwe-btn:hover {
                                color: '. $main_header_color_text .';
                                background-color: '. $darker_form_btn_color .'!important;
                                border: 2px solid '. $darker_form_btn_color .'!important;
                            }   
                            .pwelement_'. SharedProperties::$rnd_id .' #pweForm .form-container:before {
                                background-color: '. $main_header_color .';
                            }
                            .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container-mobile {
                                    display: none;
                            }
                            @media (max-width: 960px) {
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container-desktop,
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                                    display: none;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container-mobile {
                                    display: flex;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' #pweForm .form-logo-container {
                                    background-color: '. $main_header_color .';
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-wrapper {
                                    flex-direction: column-reverse; 
                                    padding: 0 18px 0;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .header-info-column,
                                .pwelement_'. SharedProperties::$rnd_id .' .header-form-column {
                                    width: 100%;
                                    padding-bottom: 18px;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .header-form-column {
                                    align-items: center;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .header-form-column .pwe-association {
                                    display: block;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text h1 {
                                    margin: 0;
                                    padding: 0 !important;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text {
                                    padding: 36px 0 !important;
                                }
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-text,
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container {
                                    max-width: 450px;
                                } 
                            }
                            @media (max-width: 450px) {
                                .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container h1 {
                                    font-size: 20px !important;
                                }
                            }
                        </style>';

                        if ($association_fair_logo_color != 'true') {
                            $output .= '
                                <style>
                                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-association-logotypes .image-container div,
                                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-association-logotypes .pwe-as-logo,
                                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-association-logotypes .slides div {
                                        filter: brightness(0) invert(1);
                                        transition: all .3s ease;
                                    }
                                </style>';
                        }

                        if ($pwe_header_modes == "conference_mode") {
                            $output .= '
                                <style>
                                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container:before {
                                        background-color: '. $main_header_color .';
                                    } 
                                </style>';
                        } else {
                            $output .= '
                                <style>
                                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-logo-container:before {
                                        background-color: '. $main_header_color .';
                                    } 
                                </style>';
                        }

                        if ($trade_fair_edition_shortcode == 1) {
                            $output .= '
                                <style>
                                    .pwelement_'. SharedProperties::$rnd_id .' .pwe-header-edition {
                                        font-size: 20px;
                                    } 
                                </style>';
                        }

                        $output .= '<div class="header-info-column">
                                        <div class="pwe-header-text">
                                            <h1>'. $pwe_header_title .'</h1>
                                        </div>
                                        <div class="pwe-header-logo-container pwe-header-logo-container-desktop">
                                            <img class="pwe-header-logo" src="'. $pwe_header_reg_logo .'" alt="logo-'. $trade_fair_name .'">';
                                            if (!empty($trade_fair_edition_shortcode) && $pwe_header_modes != "conference_mode") {
                                                $output .= '<p class="pwe-header-edition">'. $trade_fair_edition .'</p>';
                                            }
                                            $output .= '
                                            <h2>'. $actually_date .'</h2> 
                                            <p>Ptak Warsaw Expo</p>
                                        </div>'; 

                                        if ($pwe_header_association_hide != true) {
                                            // Accompanying Fairs 
                                            $output .= PWElementAssociates::output($atts, $logo_url, $pwe_header_modes, $pwe_header_conference_logo_url, $pwe_header_conference_link); 
                                        }
                                        
                                        if ($pwe_header_modes == "registration_mode" || $pwe_header_modes == "conference_mode") {
                                            $pwe_header_logotypes_urldecode = urldecode($pwe_header_logotypes);
                                            $pwe_header_logotypes_json = json_decode($pwe_header_logotypes_urldecode, true);
                                            if ($pwe_header_modes != "simple_mode") {
                                                if (is_array($pwe_header_logotypes_json) && !empty($pwe_header_logotypes_json)) {
                                                    $output .= '<div class="pwe-header-logotypes">';
                                                        foreach ($pwe_header_logotypes_json as $logotypes) {
                                                            $logotypes_width = $logotypes["logotypes_width"];
                                                            $logotypes_media = $logotypes["logotypes_media"];
                                                            $logotypes_catalog = $logotypes["logotypes_catalog"];
                                                            if(!empty($logotypes_catalog) || !empty($logotypes_media)) {
                                                                // Adding the result from additionalOutput to $output
                                                                $output .= PWElementAdditionalLogotypes::additionalOutput($atts, $logotypes);
                                                            }
                                                        }
                                                    $output .= '</div>';
                                                }
                                            }
                                        }
                        $output .= '</div>';

                        $output .= '<div class="header-form-column">';

                            $output .= '
                            <div class="pwe-header-logo-container pwe-header-logo-container-mobile">
                                <img class="pwe-header-logo" src="'. $pwe_header_reg_logo .'" alt="logo-'. $trade_fair_name .'">';
                                if (!empty($trade_fair_edition_shortcode) && $pwe_header_modes != "conference_mode") {
                                    $output .= '<p class="pwe-header-edition">'. $trade_fair_edition .'</p>';
                                }
                                $output .= '
                                <h2>'. $actually_date .'</h2> 
                                <h1 class="">'. $pwe_header_title_short .'</h1>
                            </div>';

                            include_once plugin_dir_path(__FILE__) . '/../elements/registration-header.php';
                            $output .= PWElementRegHeader::output($pwe_header_form_id, $pwe_header_modes, $pwe_header_reg_logo, $actually_date, $registration_name = "header");

                            if (get_locale() == 'pl_PL') {
                                $registration_button_text = ($registration_button_text == "") ? 'Zarejestruj się<span style="display: block; font-weight: 300;">Odbierz darmowy bilet</span>' : $registration_button_text;
                            } else {
                                $registration_button_text = ($registration_button_text == "") ? 'Register<span style="display: block; font-weight: 300;">Get a free ticket</span>' : $registration_button_text;
                            }
                    
                            if (class_exists('GFAPI')) {
                                function get_form_id_by_title($title) {
                                    $forms = GFAPI::get_forms();
                                    foreach ($forms as $form) {
                                        if ($form['title'] === $title) {
                                            return $form['id'];
                                        }
                                        
                                    }
                                    return null;
                                }
                                
                                function custom_gform_submit_button($button, $form) {
                                    global $registration_button_text, $pwe_header_form_id;
                                    $registration_form_id_nmb = get_form_id_by_title($pwe_header_form_id);
                                    
                                    if ($form['id'] == $registration_form_id_nmb) {
                                        $button = '<input type="submit" id="gform_submit_button_'.$registration_form_id_nmb.'" class="gform_button button" value="" onclick="if(window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]){return false;}  if( !jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity || jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity()){window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]=true;}  " onkeypress="if( event.keyCode == 13 ){ if(window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]){return false;} if( !jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity || jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;)[0].checkValidity()){window[&quot;gf_submitting_'.$registration_form_id_nmb.'&quot;]=true;}  jQuery(&quot;#gform_'.$registration_form_id_nmb.'&quot;).trigger(&quot;submit&quot;,[true]); }">
                                        <div class="pwe-btn-container">
                                            <button id="pweRegister" class="btn pwe-btn">'. $registration_button_text .'</button>
                                        </div>';
                                    }
                                    return $button;
                                }
                                add_filter('gform_submit_button', 'custom_gform_submit_button', 10, 2);  
                            }
                        $output .= '</div>';
                    } 
                $output .= '
                </div>
            </div>
        </div>';

        $output .= '
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const pweLogotypesElement = document.querySelector(".pwelement_'.SharedProperties::$rnd_id.' .pwe-header-logotypes");
                    const pweLogotypesAssociation = document.querySelector(".pwelement_'.SharedProperties::$rnd_id.' .pwe-association");

                    if ((pweLogotypesElement && pweLogotypesElement.children.length === 0)) {
                        pweLogotypesElement.classList.add("desktop-hidden", "tablet-hidden", "mobile-hidden");
                    } 

                    if (pweLogotypesElement) {
                        pweLogotypesElement.style.opacity = 1;  
                    }

                    if (pweLogotypesAssociation) {
                        pweLogotypesAssociation.style.opacity = 1;  
                    }
        
                    const allSliders = document.querySelectorAll(".pwe-header-logotypes");
                    if (allSliders) {
                        allSliders.forEach(function(slider) {
                            const sliderTitle = slider.querySelector(".main-heading-text");
                            
                            if (sliderTitle) {
                                const sliderTitletoLowerCase = sliderTitle.innerText.toLowerCase();

                                if (sliderTitletoLowerCase.includes("wydarzenia towarzyszące") || 
                                    sliderTitletoLowerCase.includes("targi towarzyszące") ||
                                    sliderTitletoLowerCase.includes("accompanying events") ||
                                    sliderTitletoLowerCase.includes("accompanying fairs") ||
                                    sliderTitletoLowerCase.includes("side events")) {
                                        slider.style.display = "none";
                                }
                            }            
                        }); 
                    }
                });
            </script>';


        $output = do_shortcode($output);

        $file_cont = '<div class="pwelement pwelement_'.SharedProperties::$rnd_id.'">' . $output . '</div>';
        
        if ($input_replace_array_html && $output_replace_array_html) {
            $file_cont = str_replace($input_replace_array_html, $output_replace_array_html, $file_cont);
        }

        return $file_cont;
    }
}
