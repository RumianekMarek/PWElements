<?php
// Check if request method is POST.
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Get wp-load.php location to import wordpress functions.
    $new_url = str_replace('private_html','public_html',$_SERVER["DOCUMENT_ROOT"]) .'/wp-load.php';
    if (file_exists($new_url)) {
        require_once($new_url);

        // Collect information for HASH token,
        $domain = $_SERVER["HTTP_HOST"];
        $secret_key = AUTH_KEY;
        $hash = hash_hmac('sha256', $domain, $secret_key);
        $response = "false";

        //Chek token sended.
        if( $_POST['token'] ==  $hash){

            // Check if gravity forms class GFAPI is loded,
            if (class_exists('GFAPI')) {

                // Initialize variables.
                $data = '';
                $data = $_POST['data'];
                $all_forms = GFAPI::get_forms();
                $lang = $_POST['lang'];
                $fields = array();
                $all_entrys = array();
                $all_not_valid = array();
                $all_entrys_id = array();
                $full_form = '';
                
                // Find "rejestracja gości wystawców" form ID with chosen language,
                foreach($all_forms as $form){
                    if(strpos(strtolower($form['title']), ('rejestracja gości wystawców ' . $lang)) !== false){
                        $form_id = $form['id'];
                        $all_fields = $form['fields'];
                        $full_form = $form;
                        foreach($all_fields as $field){
                            if(strpos(strtolower($field['label']), 'name') !== false || strpos(strtolower($field['label']), 'nazwisko') !== false){
                                $fields['name'] = $field['id'];
                            } elseif(strpos(strtolower($field['label']), 'e-mail') !== false){
                                $fields['email'] = $field['id'];
                            } elseif(strpos(strtolower($field['label']), 'firma') !== false || strpos(strtolower($field['label']), 'company') !== false){
                                $fields['company'] = $field['id'];
                            }
                        }
                        break;
                    }
                }

                // Process entry data.
                foreach($data as $val){
                    $entry = [
                        'form_id' => $form_id,
                        $fields['name'] => $val['name'],
                        $fields['email'] => $val['email'],
                        $fields['company'] => $_POST['company'],
                    ];

                    // Add entry to form.
                    $entry_id = GFAPI::add_entry($entry);

                    // Add entry ID to entry_id ARRAY.
                    if(filter_var(trim($val['email']), FILTER_VALIDATE_EMAIL)){
                        $all_entrys_id[] = $entry_id;
                    } else {
                        $all_not_valid[] = $entry_id;
                    }
                }
            }

            // Check if any valid entry was added,
            if(count($all_entrys_id) > 0 ){
                global $wpdb;
                $table_name = $wpdb->prefix . 'mass_exhibitors_invite_query';

                // Chech if table exists, create if it doesn't.
                if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name}'") != $table_name) {
                    $charset_collate = $wpdb->get_charset_collate();

                    $sql = "CREATE TABLE $table_name (
                        id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                        gf_entry_id BIGINT(20) UNSIGNED,
                        status VARCHAR(20) DEFAULT 'new',
                        PRIMARY KEY (id)
                    ) $charset_collate;";

                    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
                    dbDelta($sql);
                }

                // Insert all valid entries IDs in to database as "new"
                foreach($all_entrys_id as $single_id){
                    $wpdb->insert(
                        $table_name,
                        array(
                            'gf_entry_id' => $single_id,
                        ),
                        array(
                            '%d',
                        )
                    );
                }
                // Insert all not valid entries IDs in to database as "error"
                foreach($all_not_valid as $single_id){
                    $wpdb->insert(
                        $table_name,
                        array(
                            'gf_entry_id' => $single_id,
                            'status' => "error"
                        ),
                        array(
                            '%d',
                            '%s'
                        )
                    );
                }
                $response = 'true';
            }
        }

        // Send response back to exhibitors generator page
        echo json_decode($response);
    } else {

        // Wrong token send back 401 - Acces Denied
        echo json_decode('error code 401');
        exit;
    }
} else {
    // Wrong request method send back 401 - Acces Denied
    echo json_decode('error code 401');
    exit;
}