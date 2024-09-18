<?php 

class CatalogFunctions {

    /**
     * Check class for file if exists.
     *
     * @return array
     */
    public static function findClassElements() {
        // Array off class placement
        return array(
            'PWECatalogFull'   => 'classes/catalog_full.php',
            'PWECatalog21'     => 'classes/catalog_21.php',
            'PWECatalog10'     => 'classes/catalog_10.php',
            'PWECatalog7'      => 'classes/catalog_7.php',
        );
    }


    /**
     * Get logos for catalog
     * 
     * @param string $katalog_id fair id for api.
     * @param string $katalog_format format of display.
     * @return array
     */
    public static function logosChecker($katalog_id, $PWECatalogFull = 'PWECatalogFull'){
        $today = new DateTime();
        $formattedDate = $today->format('Y-m-d');
        $token = md5("#22targiexpo22@@@#".$formattedDate);
        $canUrl = 'https://export.www2.pwe-expoplanner.com/mapa.php?token='.$token.'&id_targow='.$katalog_id;
        
        if ( current_user_can( 'administrator' ) ) {
            echo '<script>console.log("'.$canUrl.'")</script>';
        }

        $json = file_get_contents($canUrl);
        $data = json_decode($json, true);

        $basic_wystawcy = reset($data)['Wystawcy'];
        $logos_array = array();

        if($basic_wystawcy != '') {
            $basic_wystawcy = array_reduce($basic_wystawcy, function($acc, $curr) {
                $name = $curr['Nazwa_wystawcy'];
                $existingIndex = array_search($name, array_column($acc, 'Nazwa_wystawcy'));
                if ($existingIndex === false) {
                    $acc[] = $curr;
                } else {
                    if($acc[$existingIndex]["Data_sprzedazy"] !== null && $curr["Data_sprzedazy"] !== null && strtotime($acc[$existingIndex]["Data_sprzedazy"]) < strtotime($curr["Data_sprzedazy"])){
                        $acc[$existingIndex] = $curr;
                    }
                }
                return $acc;
            }, []);            
        } else {
            $basic_wystawcy = [];
        }

        switch($PWECatalogFull) {
            case 'PWECatalogFull':
                $logos_array = $basic_wystawcy;
                echo '<script>console.log("exhibitors count -> '.count($logos_array).'")</script>';
                wp_localize_script('pwe-katalog-js', 'katalog_data', $logos_array);
                break;
            case 'PWECatalog21' :
                $i = 0;
                foreach($basic_wystawcy as $wystawca){
                    if($wystawca['URL_logo_wystawcy']){
                        $logos_array[] = $wystawca;
                        $i++;
                        if($i >=21){
                            break;
                        }
                    }
                }
                break;
            case 'PWECatalog10' :
                $i = 0;
                foreach($basic_wystawcy as $wystawca){
                    if($wystawca['URL_logo_wystawcy']){
                        $logos_array[] = $wystawca;
                        $i++;
                        if($i >=10){
                            break;
                        }
                    }
                }
                break;
            case 'PWECatalog7' :
                $i = 0;
                function compareDates($a, $b) {
                    $dateA = new DateTime($a['Data_sprzedazy']);
                    $dateB = new DateTime($b['Data_sprzedazy']);

                    if ($dateA == $dateB) {
                        return 0;
                    }
                    return ($dateA < $dateB) ? -1 : 1;
                }
                usort($basic_wystawcy, 'compareDates');

                foreach($basic_wystawcy as $wystawca){
                        $logos_array[] = $wystawca;
                        $i++;
                    if($i >=7){
                        break;
                    }
                }
                break;
        }
        return $logos_array;
    }
}


/**
 * Initialize VC Map PWECatalog.
 */
function initVCMapPWECatalog() {
    // Check if Visual Composer is available
    if (class_exists('Vc_Manager')) {
        vc_map( array(
            'name' => __( 'PWE Katalog wystawców 1', 'pwe_katalog1'),
            'base' => 'pwe_katalog1',
            'category' => __( 'PWE Elements', 'pwe_katalog1'),
            'admin_enqueue_css' => plugin_dir_url(dirname( __FILE__ )) . 'backend/backendstyle.css',
            //Add all vc_map PWECatalog files
            'params' => array(
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Enter ID', 'pwe_katalog1'),
                    'param_name' => 'identification',
                    'description' => __( 'Enter trade fair ID number.', 'pwe_katalog1'),
                    'param_holder_class' => 'backend-textfield',
                    'save_always' => true,
                    'admin_label' => true
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Enter Archive Year <br>or Title in "..." ', 'pwe_katalog1'),
                    'param_name' => 'katalog_year',
                    'description' => __( 'Enter year for display in catalog title or us "" to change full title.', 'pwe_katalog1'),
                    'param_holder_class' => 'backend-textfield',
                    'save_always' => true,
                    'admin_label' => true
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __( 'Catalog format', 'pwe_katalog1'),
                    'param_name' => 'format',
                    'description' => __( 'Select catalog format.', 'pwe_katalog1'),
                    'param_holder_class' => 'backend-textfield',
                    'value' => array(
                    'Select' => '',
                    'Full' => 'PWECatalogFull',
                    'Top21' => 'PWECatalog21',
                    'Top10' => 'PWECatalog10',
                    'Recently7' => 'PWECatalog7'
                    ),
                    'save_always' => true,
                    'admin_label' => true
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Logos changer', 'pwe_katalog1'),
                    'param_name' => 'file_changer',
                    'description' => __( 'Changer for logos divided by ";" try to put names <br> change places "name<=>name or position";<br> move to position "name=>>name or position";', 'pwe_katalog1'),
                    'save_always' => true,
                    'dependency' => array(
                    'element' => 'format',
                    'value' => array('','PWECatalogFull', 'PWECatalog21', 'PWECatalog10'),
                    ),
                ),
                // colors setup
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select text color <a href="#" onclick="yourFunction(`text_color_manual_hidden`, `text_color`)">Hex</a>', 'pwe_katalog1'),
                    'param_name' => 'text_color',
                    'param_holder_class' => 'main-options',
                    'description' => __('Select text color for the element.', 'pwe_katalog1'),
                    'value' => PWECommonFunctions::findPalletColorsStatic(),
                    'dependency' => array(
                        'element' => 'text_color_manual_hidden',
                        'value' => array(''),
                        'callback' => "hideEmptyElem",
                    ),
                    'save_always' => true,
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Write text color <a href="#" onclick="yourFunction(`text_color`, `text_color_manual_hidden`)">Pallet</a>', 'pwe_katalog1'),
                    'param_name' => 'text_color_manual_hidden',
                    'param_holder_class' => 'main-options pwe_dependent-hidden',
                    'description' => __('Write hex number for text color for the element.', 'pwe_katalog1'),
                    'value' => '',
                    'save_always' => true,
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select text shadow color <a href="#" onclick="yourFunction(`text_shadow_color_manual_hidden`, `text_shadow_color`)">Hex</a>', 'pwe_katalog1'),
                    'param_name' => 'text_shadow_color',
                    'param_holder_class' => 'main-options',
                    'description' => __('Select shadow text color for the element.', 'pwe_katalog1'),
                    'value' => PWECommonFunctions::findPalletColorsStatic(),
                    'dependency' => array(
                        'element' => 'text_shadow_color_manual_hidden',
                        'value' => array(''),
                    ),
                    'save_always' => true,
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Write text shadow color <a href="#" onclick="yourFunction(`text_shadow_color`, `text_shadow_color_manual_hidden`)">Pallet</a>', 'pwe_katalog1'),
                    'param_name' => 'text_shadow_color_manual_hidden',
                    'param_holder_class' => 'main-options pwe_dependent-hidden',
                    'description' => __('Write hex number for text shadow color for the element.', 'pwe_katalog1'),
                    'value' => '',
                    'save_always' => true,
                ),                        
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select button color <a href="#" onclick="yourFunction(`btn_color_manual_hidden`, `btn_color`)">Hex</a>', 'pwe_katalog1'),
                    'param_name' => 'btn_color',
                    'param_holder_class' => 'main-options',
                    'description' => __('Select button color for the element.', 'pwe_katalog1'),
                    'value' => PWECommonFunctions::findPalletColorsStatic(),
                    'dependency' => array(
                        'element' => 'btn_color_manual_hidden',
                        'value' => array(''),
                    ),
                    'save_always' => true
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Write button color <a href="#" onclick="yourFunction(`btn_color`, `btn_color_manual_hidden`)">Pallet</a>', 'pwe_katalog1'),
                    'param_name' => 'btn_color_manual_hidden',
                    'param_holder_class' => 'main-options pwe_dependent-hidden',
                    'description' => __('Write hex number for button color for the element.', 'pwe_katalog1'),
                    'value' => '',
                    'save_always' => true
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select button text color <a href="#" onclick="yourFunction(`btn_text_color_manual_hidden`, `btn_text_color`)">Hex</a>', 'pwe_katalog1'),
                    'param_name' => 'btn_text_color',
                    'param_holder_class' => 'main-options',
                    'description' => __('Select button text color for the element.', 'pwe_katalog1'),
                    'value' => PWECommonFunctions::findPalletColorsStatic(),
                    'dependency' => array(
                        'element' => 'btn_text_color_manual_hidden',
                        'value' => array(''),
                    ),
                    'save_always' => true
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Write button text color <a href="#" onclick="yourFunction(`btn_text_color`, `btn_text_color_manual_hidden`)">Pallet</a>', 'pwelement'),
                    'param_name' => 'btn_text_color_manual_hidden',
                    'param_holder_class' => 'main-options pwe_dependent-hidden',
                    'description' => __('Write hex number for button text color for the element.', 'pwelement'),
                    'value' => '',
                    'save_always' => true
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => __('Select button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color_manual_hidden`, `btn_shadow_color`)">Hex</a>', 'pwelement'),
                    'param_name' => 'btn_shadow_color',
                    'param_holder_class' => 'main-options',
                    'description' => __('Select button shadow color for the element.', 'pwelement'),
                    'value' => PWECommonFunctions::findPalletColorsStatic(),
                    'dependency' => array(
                        'element' => 'btn_shadow_color_manual_hidden',
                        'value' => array(''),
                    ),
                    'save_always' => true
                ),
                array(
                    'type' => 'textfield',
                    'heading' => __('Write button shadow color <a href="#" onclick="yourFunction(`btn_shadow_color`, `btn_shadow_color_manual_hidden`)">Pallet</a>', 'pwelement'),
                    'param_name' => 'btn_shadow_color_manual_hidden',
                    'param_holder_class' => 'main-options pwe_dependent-hidden',
                    'description' => __('Write hex number for button shadow color for the element.', 'pwelement'),
                    'value' => '',
                    'save_always' => true
                ),
                // color END
                array(
                    'type' => 'textfield',
                    'heading' => __( 'Export link', 'pwe_katalog1'),
                    'param_name' => 'export_link',
                    'description' => __( 'Export link', 'pwe_katalog1'),
                    'save_always' => true,
                    'admin_label' => true
                ),
                // array(
                //     'type' => 'checkbox',
                //     'heading' => __('Hide details', 'pwe_katalog1'),
                //     'param_name' => 'details',
                //     'description' => __('Check to use to hide details. ONLY full catalog.', 'pwe_katalog1'),
                //     'param_holder_class' => 'backend-basic-checkbox',
                //     'admin_label' => true,
                //     'value' => array(__('True', 'pwe_katalog1') => 'true',),
                // ),
                // array(
                //     'type' => 'checkbox',
                //     'heading' => __('Hide stand', 'pwe_katalog1'),
                //     'param_name' => 'stand',
                //     'description' => __('Check to use to hide stand. ONLY full catalog.', 'pwe_katalog1'),
                //     'param_holder_class' => 'backend-basic-checkbox',
                //     'admin_label' => true,
                //     'value' => array(__('True', 'pwe_katalog1') => 'true',),
                // ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Registration', 'pwe_katalog1'),
                    'param_name' => 'ticket',
                    'description' => __('Default height logotypes 110px. ONLY top10.', 'pwe_katalog1'),
                    'param_holder_class' => 'backend-basic-checkbox',
                    'admin_label' => true,
                    'value' => array(__('True', 'pwe_katalog1') => 'true',),
                    'dependency' => array(
                    'element' => 'format',
                    'value' => array('top10')
                    ),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Slider desktop', 'pwe_katalog1'),
                    'param_name' => 'slider_desktop',
                    'description' => __('Check if you want to display in slider on desktop.', 'pwe_katalog1'),
                    'param_holder_class' => 'backend-basic-checkbox',
                    'admin_label' => true,
                    'save_always' => true,
                    'value' => array(__('True', 'pwe_katalog1') => 'true',),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Grid mobile', 'pwe_katalog1'),
                    'param_name' => 'grid_mobile',
                    'description' => __('Check if you want to display in grid on mobile.', 'pwe_katalog1'),
                    'param_holder_class' => 'backend-basic-checkbox',
                    'admin_label' => true,
                    'save_always' => true,
                    'value' => array(__('True', 'pwe_katalog1') => 'true',),
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => __('Turn off dots', 'pwe_katalog1'),
                    'param_name' => 'slider_dots_off',
                    'description' => __('Check if you want to turn off dots.', 'pwe_katalog1'),
                    'admin_label' => true,
                    'save_always' => true,
                    'value' => array(__('True', 'pwe_katalog1') => 'true',),
                ), 
            ),
        ));
    }
}

add_action( 'vc_before_init', 'initVCMapPWECatalog' );