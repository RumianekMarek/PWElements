<?php
class PWEConferenceCapFunctions extends PWEConferenceCap{

    private static function connectToDatabaseConferences() {
        // Initialize connection variables
        $cap_db = null;
        
        // Set connection data depending on the server
        if ($_SERVER['SERVER_ADDR'] === '94.152.207.180') {
            $database_host = 'localhost';
            $database_name = defined('PWE_DB_NAME_180') ? PWE_DB_NAME_180 : '';
            $database_user = defined('PWE_DB_USER_180') ? PWE_DB_USER_180 : '';
            $database_password = defined('PWE_DB_PASSWORD_180') ? PWE_DB_PASSWORD_180 : '';
        } else {
            $database_host = 'localhost';
            $database_name = defined('PWE_DB_NAME_93') ? PWE_DB_NAME_93 : '';
            $database_user = defined('PWE_DB_USER_93') ? PWE_DB_USER_93 : '';
            $database_password = defined('PWE_DB_PASSWORD_93') ? PWE_DB_PASSWORD_93 : '';
        }

        // Check if there is complete data for connection
        if ($database_user && $database_password && $database_name && $database_host) {
            try {
                $cap_db = new wpdb($database_user, $database_password, $database_name, $database_host);
            } catch (Exception $e) {
                return false;
                if (current_user_can("administrator") && !is_admin()) {
                    echo '<script>console.error("Błąd połączenia z bazą danych: '. addslashes($e->getMessage()) .'")</script>';
                }
            }
        } else {
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Nieprawidłowe dane połączenia z bazą danych.")</script>';
            }
            return false;
        }
    
        // Check for connection errors
        if (!$cap_db->dbh || mysqli_connect_errno()) {
            return false;
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd połączenia MySQL: '. addslashes(mysqli_connect_error()) .'")</script>';
            }
        }
    
        return $cap_db;
    }
    
    public static function getDatabaseDataConferences() {
        // Database connection
        $cap_db = self::connectToDatabaseConferences();
        // If connection failed, return empty array
        if (!$cap_db) {
            return [];
            if (current_user_can('administrator') && !is_admin()) {
                echo '<script>console.error("Brak połączenia z bazą danych.")</script>';
            }
        }


        $domena = $_SERVER['HTTP_HOST'];

        // Pobieramy dane bez względu na język
        $results = $cap_db->get_results(
            $cap_db->prepare(
                "SELECT * FROM conferences WHERE conf_site_link LIKE %s",
                '%' . $domena . '%'
            )
        );
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
            }
        }

        foreach ($results as &$row) {
            if (!empty($row->conf_data)) {
                $decoded = html_entity_decode($row->conf_data);
        
                // Czyścimy WSZYSTKIE wystąpienia font-family z atrybutów style (w tym wieloliniowe!)
                $decoded = preg_replace_callback('/style="([^"]+)"/is', function ($match) {
                    $style = $match[1];
                    $style = preg_replace('/font-family\s*:\s*[^;"]+("[^"]+"[, ]*)*[^;"]*;?/i', '', $style);
                    $style = trim(preg_replace('/\s*;\s*/', '; ', $style), '; ');
                    return $style ? 'style="' . $style . '"' : '';
                }, $decoded);
        
                // Sprawdzamy poprawność JSON
                $test = json_decode($decoded, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $row->conf_data = $decoded;
                } else {
                    error_log("❌ Błąd JSON w conf_data: " . json_last_error_msg());
                }
            }
        }
            
        return $results;
    }    

    public static function findConferenceMode($new_class) {

        switch ($new_class){
            case 'PWEConferenceCapSimpleMode' : 
                return array (
                'php' => 'classes/conference-cap-simple-mode/conference-cap-simple-mode.php',
                'css' => 'classes/conference-cap-simple-mode/conference-cap-simple-mode-style.css',
                );
            case 'PWEConferenceCapMedalCeremony' : 
                return array (
                    'php' => 'classes/conference-cap-medal-ceremony/conference-cap-medal-ceremony.php',
                    'css' => 'classes/conference-cap-medal-ceremony/conference-cap-medal-ceremony-style.css',
                );
            default :
                return array (
                    'php' => 'classes/conference-cap-full-mode/conference-cap-full-mode.php',
                    'css' => 'classes/conference-cap-full-mode/conference-cap-full-mode-style.css',
                );
        };
    }

    public static function speakerImageMini($speaker_images) { 
        // Filtrowanie pustych wartości
        $head_images = array_filter($speaker_images);
        // Resetowanie indeksów tablicy
        $head_images = array_values($head_images); 
        
        // Jeśli nie ma obrazów, zwracamy pusty string
        if (empty($head_images)) {
            return ''; 
        }
    
        // Inicjalizacja kontenera na obrazy
        $speaker_html = '<div class="pwe-box-speakers-img">';
    
        // Pętla po obrazach i dynamiczne ustawianie ich pozycji
        foreach ($head_images as $i => $image_src) {    
            if (!empty($image_src)) {
                $z_index = (1 + $i);
                $margin_top_index = '';
                $max_width_index = "50%";
    
                // Ustawienia pozycji w zależności od liczby prelegentów
                switch (count($head_images)) {
                    case 1:
                        $top_index = "unset";
                        $left_index = "unset";
                        $max_width_index = "80%";
                        break;
    
                    case 2:
                        switch ($i) {
                            case 0:
                                $margin_top_index = "margin-top: 20px";
                                $max_width_index = "50%";
                                $top_index = "-20px";
                                $left_index = "10px";
                                break;
                            case 1:
                                $max_width_index = "50%";
                                $top_index = "0";
                                $left_index = "-10px";
                                break;
                        }
                        break;
    
                    case 3:
                        switch ($i) {
                            case 0:
                                $top_index = "0";
                                $left_index = "15px";
                                break;
                            case 1:
                                $top_index = "40px";
                                $left_index = "-15px";
                                break;
                            case 2:
                                $top_index = "-15px";
                                $left_index = "-30px";
                                break;
                        }
                        break;
    
                    default:
                        switch ($i) {
                            case 0:
                                $margin_top_index = 'margin-top: 5px !important;';
                                break;
                            case 1:
                                $left_index = "-10px";
                                break;
                            default:
                                $reszta = $i % 2;
                                if ($reszta == 0) {
                                    $top_index = ($i / 2 * -15) . "px";
                                    $left_index = "0";
                                } else {
                                    $top_index = (floor($i / 2) * -15) . "px";
                                    $left_index = "-10px";
                                }
                                break;
                        }
                }
    
                // Generowanie HTML obrazów
                $speaker_html .= '<img class="pwe-box-speaker" src="'. esc_url($image_src) .'" alt="speaker portrait" 
                    style="position:relative; z-index:'.$z_index.'; top:'.$top_index.'; left:'.$left_index.'; max-width: '.$max_width_index.';'.$margin_top_index.';" />';
            }
        }
    
        $speaker_html .= '</div>';
    
        return $speaker_html;
    }

    public static function pwe_convert_rgb_to_hex($content) {
        return preg_replace_callback('/rgb\s*\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*\)/i', function ($matches) {
            // Zabezpieczenie: ogranicz zakres wartości
            $r = max(0, min(255, (int)$matches[1]));
            $g = max(0, min(255, (int)$matches[2]));
            $b = max(0, min(255, (int)$matches[3]));
            return sprintf("#%02x%02x%02x", $r, $g, $b);
        }, $content);
    }

    public static function copySpeakerImgByStructure(array $json): array {
        if (!isset($json['PL'], $json['EN'])) {
            return $json;
        }

        /* -------- 1.   iteracja po dniach wg pozycji -------- */
        $plDayKeys = array_keys($json['PL']);
        $enDayKeys = array_keys($json['EN']);
        $maxDays   = min(count($plDayKeys), count($enDayKeys));

        for ($d = 0; $d < $maxDays; $d++) {

            $plSessions = $json['PL'][$plDayKeys[$d]];
            $enSessions = &$json['EN'][$enDayKeys[$d]];

            /* -------- 2.   iteracja po prelekcjach (tylko 'pre‑X') -------- */
            foreach ($plSessions as $preKey => $plPre) {

                if (strpos($preKey, 'pre-') !== 0 || !is_array($plPre)) {
                    continue;
                }
                if (!isset($enSessions[$preKey]) || !is_array($enSessions[$preKey])) {
                    continue;
                }

                $enPre = &$enSessions[$preKey];

                /* -------- 3.   legent‑Y – kopiuj url gdy w EN pusto -------- */
                foreach ($plPre as $fieldKey => $plField) {
                    if (strpos($fieldKey, 'legent-') !== 0 || !is_array($plField)) {
                        continue;
                    }

                    if (!isset($enPre[$fieldKey]) || !is_array($enPre[$fieldKey])) {
                        continue;
                    }

                    if (empty($enPre[$fieldKey]['url']) && !empty($plField['url'])) {
                        $enPre[$fieldKey]['url'] = $plField['url'];
                    }
                }
            }
        }

        return $json;
    }

    protected static function debugConferencesConsole( array $database_data ) {

        if ( ! is_user_logged_in() || ! current_user_can( 'administrator' ) ) {
            return;
        }
    
        $debug = array_map(
            static function ( $conf ) {
                return array(
                    'slug'       => $conf->conf_slug,
                    'updated'    => $conf->updated ?? null,
                    'updated_at' => $conf->updated_at ?? null,
                );
            },
            $database_data
        );
    
        wp_register_script( 'pwe-conference-cap-debug', '' );
        wp_add_inline_script(
            'pwe-conference-cap-debug',
            'console.groupCollapsed("PWEConferenceCap – recent changes");' .
            'console.table(' . wp_json_encode( $debug ) . ');' .
            'console.groupEnd();'
        );
        wp_enqueue_script( 'pwe-conference-cap-debug' );
    }

  }