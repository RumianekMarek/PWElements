<?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $domain = $_SERVER["HTTP_HOST"];
    $secret_key = '^GY0ZlZ!xzn1eM5';
    $hash = hash_hmac('sha256', $domain, $secret_key);

    if( $_POST['token'] ==  $hash){
        $new_url = str_replace('private_html','public_html',$_SERVER["DOCUMENT_ROOT"]) .'/wp-load.php';
           
        if (file_exists($new_url)) {
            require_once($new_url);
            if (class_exists('GFAPI')) {
                $data = '';
                $data = $_POST['data'];
                $all_forms = GFAPI::get_forms();
                $lang = $_POST['lang'];
                $fields = array();
                $all_entrys = array();
                $all_entrys_id = array();
                $full_form = '';

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

                foreach($data as $val){
                    if(filter_var(trim($val['email']), FILTER_VALIDATE_EMAIL)){
                        $entry = [
                            'form_id' => $form_id,
                            $fields['name'] => $val['name'],
                            $fields['email'] => $val['email'],
                            $fields['company'] => $_POST['company'],
                        ];

                        $entry_id = GFAPI::add_entry($entry);
                        $full_entry = GFAPI::get_entry($entry_id);

                        $notice = GFAPI::send_notifications( $full_form, $full_entry);

                        $all_entrys[] = true;
                    } else {
                        $all_entrys[] = false;
                    }
                }
                echo json_encode($all_entrys);
            }
        }     
    } else {
        echo 'error code 401';
        exit;
    }
} else {
    echo 'error code 401';
    exit;
}