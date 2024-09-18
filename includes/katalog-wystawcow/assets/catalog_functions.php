<?php

class CatalogFunctions{

/**
     * Check class for file if exists.
     *
     * @return array
     */
    private function findClassElements() {
        // Array off class placement
        return array(
            'PWECatalogFull'   => 'classes/catalog_full.php',
            'PWECatalog21'     => 'classes/catalog_21.php',
            'PWECatalog10'     => 'classes/catalog_10.php',
            'PWECatalog7'      => 'classes/catalog_7.php',
        );
    }

    /**
     * Mobile displayer check
     * 
     * @return bool
     */
    public static function checkForMobile(){
        return (preg_match('/Mobile|Android|iPhone/i', $_SERVER['HTTP_USER_AGENT']));
    }

        /**
     * Adding Styles
     */
    public function addingStyles(){
        $css_file = plugins_url('assets/katalog.css', __FILE__);
        $css_version = filemtime(plugin_dir_path(__FILE__) . 'assets/katalog.css');
        wp_enqueue_style('pwe-katalog-css', $css_file, array(), $css_version);
    }

    /**
     * Adding Scripts
     */
    public function addingScripts($atts){
        $js_file = plugins_url('assets/katalog.js', __FILE__);
        $js_version = filemtime(plugin_dir_path(__FILE__) . 'assets/katalog.js');
        wp_enqueue_script('pwe-katalog-js', $js_file, array('jquery'), $js_version, true);
    }

    /**
     * Finding preset colors pallet.
     *
     * @return array
     */
    public static function findPalletColors(){
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
            return do_shortcode($pl);
        } else {
            return do_shortcode($en);
        }
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
     * Check Title for Exhibitors Catalog
     */
    // public static function initElements() {
    // }
    public static function checkTitle($title, $format) {
        
        if (substr($title, 0, 2) === "``") {
            $exhibitors_title = substr($title, 2, -2);
        } elseif($format == 'PWECatalogFull'){
            $exhibitors_title = self::languageChecker(
                <<<PL
                    Katalog wystawców 
                PL,
                <<<EN
                    Exhibitor Catalog 
                EN
            ) . $title;
        } elseif ($format == 'PWECatalog21' || $format == 'PWECatalog10'){
            $exhibitors_title = self::languageChecker(
                <<<PL
                    Wystawcy 
                PL,
                <<<EN
                    Exhibitors 
                EN
            ) . (($title) ? $title : do_shortcode('[trade_fair_catalog_year]'));
        } elseif ($format == 'PWECatalog7'){
            $exhibitors_title = self::languageChecker(
                <<<PL
                    Nowi wystawcy na targach 
                PL,
                <<<EN
                    New exhibitors at the fair 
                EN
            ) . $title;
        }
        return $exhibitors_title;
    }
}