<?php
ini_set('display_errors', 'On');
require __DIR__ . '/vendor/autoload.php';
require_once ('storage.php');


function refreshAccessToken($clientId, $clientSecret, $refreshToken)
{

    try{
        include('provider.php');

        $newAccessToken = $provider->getAccessToken('refresh_token', [
            'refresh_token' => $refreshToken
        ]);

        $response = [
            'success' => true,
            'message' => 'Token refreshed successfully.',
            'data' => [
                'token' => $newAccessToken->getToken(),
                'expires' => $newAccessToken->getExpires(),
                'refresh_token' => $newAccessToken->getRefreshToken(),
                'id_token' => $newAccessToken->getValues()["id_token"]
            ]
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;

    }
      catch (\Exception $e) {
        $response = [
            'success' => false,
            'message' => 'Error refreshing token.',
            'error' => $e->getMessage()
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

}

$clientId = $_GET['client_id'] ?? null;
$clientSecret = $_GET['client_secret'] ?? null;
$refreshToken = $_GET['refresh_token'] ?? null;
// Call the function
refreshAccessToken($clientId, $clientSecret, $refreshToken);