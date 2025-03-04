<?php
header('Content-Type: application/json');
$report['status'] = 'false';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SERVER['HTTP_AUTHORIZATION']) || $_SERVER['HTTP_AUTHORIZATION'] !== 'qg58yn58q3yn5v') {
        http_response_code(403);
        echo json_encode(["message" => "Brak autoryzacji"]);
        exit;
    }

    require_once($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');

    $data = json_decode(file_get_contents("php://input"), true);

    if (!$data || !isset($data['formName'])) {
        http_response_code(400);
        echo json_encode(["message" => "Niepoprawne dane"]);
        exit;
    }

    function getFormIdByTitle($formName) {
        $forms = GFAPI::get_forms();
        foreach ($forms as $form) {
            if ($form['title'] === $formName) {
                return $form['id'];
            }
        }
        return null;
    }

    $form_id = getFormIdByTitle($data['formName']);
    $direction = $data['direction'];

    if (!$form_id) {
        echo json_encode(["message" => "Nie znaleziono formularza o podanej nazwie"]);
        exit;
    }

    $form = GFAPI::get_form($form_id);

    if (!$form) {
        echo json_encode(["message" => "Nie znaleziono formularza"]);
        exit;
    }

    if($direction == "registration"){
        $entry_id = $_SESSION['pwe_reg_entry']['entry_id'];
    } else {
        $entry_id = $_SESSION['pwe_exhibitor_entry']['entry_id'];
    }

    $entry = GFAPI::get_entry($entry_id);
    if (is_wp_error($entry)) {
        echo json_encode(["message" => "Nie znaleziono wpisu"]);
        exit;
    }

    function getFieldIdByAdminLabel($form, $admin_label) {
        foreach ($form['fields'] as $field) {
            if (isset($field->adminLabel) && $field->adminLabel === $admin_label) {
                return $field->id;
            }
        }
        return null;
    }

    if($direction == "registration"){
        $fields_to_update = [
            'name' => 'name',
            'street' => 'street',
            'house' => 'house',
            'post' => 'post',
            'city' => 'city'
        ];
    } else {
        $fields_to_update = [
            'name' => 'name',
            'area' => 'area',
            'company' => 'company',
        ];
    }

    foreach ($fields_to_update as $admin_label => $key) {
        $field_id = getFieldIdByAdminLabel($form, $admin_label);
        if ($field_id && !empty($data[$key])) {
            $entry[$field_id] = $data[$key];
        }
    }

    $result = GFAPI::update_entry($entry);

    if (is_wp_error($result)) {
        echo json_encode(["message" => "Błąd aktualizacji"]);
    } else {
        if ($direction !== "registration") {
            // Pobranie ID powiadomienia "Admin Notification Potwierdzenie"
            $notifications = $form['notifications'];
            $notification_id = null;

            $notification_names = ['Admin Notification Potwierdzenie'];

            foreach ($form["notifications"] as $id => &$key) {
                if (in_array($key['name'], $notification_names)) {
                    $key['isActive'] = true;
                } else {
                    $key['isActive'] = false;
                }
            }
            $result = GFAPI::send_notifications($form, $entry);
        }

        echo json_encode([
            "message" => "Dane zaktualizowane",
            "direction" => $notification_id,
            "test" => $test,
        ]);
    }
}
?>
