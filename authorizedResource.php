<?php
ini_set('display_errors', 'On');
require __DIR__ . '/vendor/autoload.php';
require_once ('storage.php');
include('provider.php');

// Use this class to deserialize error caught
use XeroAPI\XeroPHP\AccountingObjectSerializer;

// Storage Classe uses sessions for storing token > extend to your DB of choice
$storage = new StorageClass();
$xeroTenantId = (string) $storage->getSession()['tenant_id'];

if ($storage->getHasExpired()) {
    include('provider.php');

    $newAccessToken = $provider->getAccessToken('refresh_token', [
        'refresh_token' => $storage->getRefreshToken()
    ]);

    // Save my token, expiration and refresh token
    $storage->setToken(
        $newAccessToken->getToken(),
        $newAccessToken->getExpires(),
        $xeroTenantId,
        $newAccessToken->getRefreshToken(),
        $newAccessToken->getValues()["id_token"]
    );

    echo '<pre>';
    echo 'Refreshed  token';
    print_r($storage->getSession());
    echo '</pre>';
    exit;
}


$sessionData = $storage->getSession();
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, APP_URL);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['session_data' => $sessionData]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    echo 'Redirecting....<br><br/>' . $response;
}
curl_close($ch);
