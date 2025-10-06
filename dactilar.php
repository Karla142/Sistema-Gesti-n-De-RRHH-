<?php
// URL del servicio Java
$apiUrl = "http://localhost:8080/captureFingerprint";

// Inicializar cURL
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_RETURNTRANSFER => true,
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode === 200) {
    // Decodificar imagen en Base64
    echo '<h3>Huella Capturada:</h3>';
    echo '<img src="data:image/png;base64,' . $response . '" />';
} else {
    echo '<h3>Error:</h3>';
    echo 'No se pudo capturar la huella desde el servicio Java.';
}
?>
