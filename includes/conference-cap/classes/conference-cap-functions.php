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
        $lang = 'pl'; 

        if (strpos($_SERVER['REQUEST_URI'], '/en/') !== false) {
            $lang = 'en';
        }

        $results = $cap_db->get_results(
            $cap_db->prepare(
                "SELECT * FROM conferences WHERE conf_site_link LIKE %s AND RIGHT(conf_slug, 2) = %s",
                '%' . $domena . '%',
                $lang
            )
        );
    
        // SQL error checking
        if ($cap_db->last_error) {
            return [];
            if (current_user_can("administrator") && !is_admin()) {
                echo '<script>console.error("Błąd SQL: '. addslashes($cap_db->last_error) .'")</script>';
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
  }