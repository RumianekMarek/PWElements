<?php 

class PWElementsUpdater {

    private $cache_key = 'pwelements_last_check';

    public function __construct() {
        $this->checkUpdateCondition();
    }

    private function checkUpdateCondition() {
        $current_time = current_time('timestamp');
        $last_check = get_option($this->cache_key);

        if ($last_check && ($current_time - $last_check) < 36) {
            return;
        }

        update_option($this->cache_key, $current_time);
        $this->pluginChecker();
    }

    private function pluginChecker() {
        $plugin_path = plugin_dir_path(__FILE__) . 'pwelements.php';
        $plugin_info = get_plugin_data($plugin_path);

        $url = $plugin_info['UpdateURI'];
        $current_version = $plugin_info["Version"];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');

        $response = curl_exec($ch);
        curl_close($ch);
        if ($response === FALSE) {
            // Obsługuje błąd
            error_log("Błąd podczas pobierania danych z GitHub");
        } else {
            $data = json_decode($response, true);
            if (isset($data['tag_name'])) {
                $auto_update_enabled = get_option('PWE Elements_auto_update', false);
                echo '<script>console.log("'.$auto_update_enabled.'")</script>';
                
                if ($current_version < $data['tag_name']){

                }
            } else {
                echo "Nie znaleziono informacji o release'ach.";
            }
        }
    }
}