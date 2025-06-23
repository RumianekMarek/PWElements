<!-- <?php

$katalog_id = '1169';
$secret = '#22targiexpo22@@@#';
$limit = 10;


if (!isset($_GET['logotyp'])) {
    $token = md5($secret . date('Y-m-d'));
    $api_url = 'https://export.www2.pwe-expoplanner.com/mapa.php?token=' . $token . '&id_targow=' . $katalog_id;

    $json = @file_get_contents($api_url);
    if ($json === false) {
        echo "<strong>Błąd:</strong> Nie udało się pobrać danych z API.";
        exit;
    }

    $data = json_decode($json, true);
    echo "<h2>Dane z API</h2><pre>";
    print_r($data);
    echo "</pre>";
    exit;
}


$requestedIndex = (int)$_GET['logotyp'] - 1;

if ($requestedIndex < 0 || $requestedIndex >= $limit) {
    sendPlaceholder();
}

// Token + API URL
$token = md5($secret . date('Y-m-d'));
$api_url = 'https://export.www2.pwe-expoplanner.com/mapa.php?token=' . $token . '&id_targow=' . $katalog_id;
$json = @file_get_contents($api_url);

if ($json === false) {
    sendPlaceholder();
}

$data = json_decode($json, true);
$wystawcy = reset($data)['Wystawcy'] ?? [];

$logotypy = [];


foreach ($wystawcy as $wystawca) {
    if (!empty($wystawca['URL_logo_wystawcy'])) {
        $logotypy[] = $wystawca['URL_logo_wystawcy'];
    }
    if (count($logotypy) >= $limit) break;
}


if (!isset($logotypy[$requestedIndex])) {
    sendPlaceholder();
}

$logoUrl = $logotypy[$requestedIndex];
$imageContent = @file_get_contents($logoUrl);

if ($imageContent === false) {
    sendPlaceholder();
}


$extension = strtolower(pathinfo($logoUrl, PATHINFO_EXTENSION));
$contentTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png'
];

header("Content-Type: " . ($contentTypes[$extension] ?? 'image/jpeg'));
echo $imageContent;
exit;



function sendPlaceholder() {
    http_response_code(404);
    header("Content-Type: image/png");
    readfile(__DIR__ . '/placeholder.png');
    exit;
} -->
