<?php

/**
 * Class PWETest
 * Extends maps class and defines a custom Visual Composer element for vouchers.
 */
class PWETest extends PWECommonFunctions {

    /**
     * Constructor method for initializing the plugin.
     */
    public function __construct() {
        add_action('init', array($this, 'initTest'));
        add_shortcode('pwe_test', array($this, 'PWETestOutput'));
    }

        /**
     * Initialize VC Map PWEMap.
     */
    public function initTest() {

        // Check if Visual Composer is available
        if (class_exists('Vc_Manager')) {
            vc_map( array(
                'name' => __( 'PWE Test', 'pwe_test'),
                'base' => 'pwe_test',
                'category' => __( 'PWE Elements', 'pwe_test'),
                'admin_enqueue_css' => plugin_dir_url(dirname( __DIR__ )) . 'backend/backendstyle.css',
            ));
        }
    }

    /**
     * Static method to generate the HTML output for the PWE Element.
     * Returns the HTML output as a string.
     *
     * @param array @atts options
     */
    public function PWETestOutput() {
        // $fairs = PWECommonFunctions::get_database_fairs_data();

        // $mh = curl_multi_init();
        // $curl_handles = [];

        // foreach ($fairs as $fair) {
        //     $domain = $fair->fair_domain;
        //     $api_url = 'https://' . $domain . '/wp-content/plugins/custom-element/other/pwe_api.php';
        //     $secretKey = defined('PWE_API_KEY_1') ? PWE_API_KEY_1 : '';
        //     $token = hash_hmac('sha256', parse_url($api_url, PHP_URL_HOST), $secretKey);

        //     $curl_handles[$domain] = curl_init();
        //     curl_setopt($curl_handles[$domain], CURLOPT_URL, $api_url);
        //     curl_setopt($curl_handles[$domain], CURLOPT_RETURNTRANSFER, true);
        //     curl_setopt($curl_handles[$domain], CURLOPT_HTTPHEADER, ["Authorization: $token"]);
        //     curl_setopt($curl_handles[$domain], CURLOPT_TIMEOUT, 10);

        //     curl_multi_add_handle($mh, $curl_handles[$domain]);
        // }

        // $running = null;
        // do {
        //     curl_multi_exec($mh, $running);
        // } while ($running > 0);

        // foreach ($curl_handles as $domain => $ch) {
        //     $response = curl_multi_getcontent($ch);
        //     $api_media = json_decode($response, true);
        //     if (!empty($api_media["doc"])) {
        //         // Filter files that contain "doc/Logotypes" in their path
        //         $filtered_files = array_filter($api_media["doc"], function ($file) {
        //             return strpos($file['path'], 'doc/Logotypy') !== false;
        //         });

        //         // Create an array with only "path"
        //         $fairs_catalogs[$domain] = array_map(function ($file) {
        //             return ['path' => $file['path']];
        //         }, array_values($filtered_files));
        //     }
        //     curl_multi_remove_handle($mh, $ch);
        // }

        // curl_multi_close($mh);

        // echo '
        // <script>
        //     var fairsCatalogs = ' . json_encode($fairs_catalogs) . ';
        //     console.log(fairsCatalogs);
        // </script>';


    }
}


