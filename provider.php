<?php
// define('APP_URL', 'http://127.0.0.1:8000/api/store-xero/token');
// define('REDIRECT_URL', 'http://localhost:8888/callback.php');

define('REDIRECT_URL', 'https://xero.auswidetech.com/callback.php');
define('APP_URL', 'https://development.auswidetech.com/public/api/store-xero/token');


$provider = new \League\OAuth2\Client\Provider\GenericProvider([
  'clientId'                => 'EA7909D34C0C4471B0313AFCFB43E4BB',
  'clientSecret'            => '-87rHDqaD5emQzHgcP5DuGDkaSFVO7cfNzvhf1AXZhXUwto0',
  'redirectUri'             => REDIRECT_URL,
  'urlAuthorize'            => 'https://login.xero.com/identity/connect/authorize',
  'urlAccessToken'          => 'https://identity.xero.com/connect/token',
  'urlResourceOwnerDetails' => 'https://api.xero.com/api.xro/2.0/Organisation'
]);