<?php

$new_url = str_replace('private_html','public_html',$_SERVER["DOCUMENT_ROOT"]) .'/wp-load.php';
require_once($new_url);

if (isset($_POST['value']) && isset($_POST['csrf_token'])) {
    if (!isset($_SESSION['csrf_token']) || $_SESSION['csrf_token'] !== $_POST['csrf_token']) {
        echo json_encode(['error' => 'Invalid CSRF token']);
        echo 'failcsrf';
        exit;
    }
    $erorreo = '';
    $id = $_POST['id'];
    $email = sanitize_email($_POST['value']);
    $form_id = $_POST['form_id'];

    $email = sanitize_email($_POST['value']);

    $search_criteria = [
        'field_filters' => [
            [
                'key'   => $id,
                'value' => $email
            ]
        ]
    ];
    
    $entries = GFAPI::get_entries($form_id, $search_criteria);
    
    if (!empty($entries)) {
        echo json_encode(['exists' => true]);
    } else {
        echo json_encode(['exists' => false]);
    }
}
