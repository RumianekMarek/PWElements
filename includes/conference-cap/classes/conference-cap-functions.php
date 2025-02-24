
<?php
class PWEConferenceCapFunctions extends PWEConferenceCap{

public static function connectToDatabase() {
        if ($_SERVER['SERVER_ADDR'] === '94.152.207.180') {
            $database_host = 'localhost';
            $database_name = 'automechanicawar_dodatkowa';
            $database_user = 'automechanicawar_admin-dodatkowa';
            $database_password = '9tL-2-88UAnO_x2e';
        }

        $cap_db = new wpdb($database_user, $database_password, $database_name, $database_host);

        // Check for errors errors
        if (!empty($cap_db->last_error)) {
            echo '<script>console.error("Błąd połączenia z bazą danych: '. $cap_db->last_error .'")</script>';
            return false;
        }

        // Additional connection test
        if (!$cap_db->dbh || mysqli_connect_errno()) {
            echo '<script>console.error("Błąd połączenia MySQL: '. mysqli_connect_error() .'")</script>';
            return false;
        }

        return $cap_db;
    }

    public static function getDatabaseDataConferences() {

        $cap_db = self::connectToDatabase();

        if (!$cap_db) {
            return [];
        }

        $results = $cap_db->get_results("SELECT * FROM conferences");
        // $results = $cap_db->get_results("SELECT conf_name, conf_slug, conf_data FROM conferences");

        // Debugging SQL errors
        if ($cap_db->last_error) {
            echo '<script>console.error("Błąd SQL: "'. $cap_db->last_error .'")</script>';
            return [];
        }

        return $results;
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