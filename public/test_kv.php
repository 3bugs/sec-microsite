<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;
//use GuzzleHttp\Psr7\Request;

$azureKeyVault = 'SWW003KVT201'; // env('AZURE_KEY_VAULT');
$azureSecretName = 'SEC-AZMSDB-SMEUSER-SMEMCDB'; // env('AZURE_SECRET_NAME');
$azureAdTenantId = '0ad5298e-296d-45ab-a446-c0d364c5b18b'; // env('AZURE_AD_TENANT_ID');
$azureAdApplicationId = 'eb75d2cf-f9c3-49fd-8087-410c6ce33e6b'; // env('AZURE_AD_APPLICATION_ID');
$azureAdApplicationSecret = '04uI5J7xZOEm.N.CNfNLC~mUZ3vOv~G0WU'; // env('AZURE_AD_APPLICATION_SECRET');

// Login
$client = new Client();
$request = $client->request(
  'POST',
  "https://login.microsoftonline.com/${azureAdTenantId}/oauth2/v2.0/token",
  [
    'form_params' => [
      'grant_type' => 'client_credentials',
      'client_id' => $azureAdApplicationId,
      'client_secret' => $azureAdApplicationSecret,
      'scope' => 'https://vault.azure.net/.default'
    ]
  ]
);

$apiResponse = $request->getBody()->getContents();
//$response_api = str_replace(" ","",substr($response_api,3));
$jsonData = json_decode($apiResponse, true);

// Get Secrets
$request = $client->request(
  'GET',
  "https://${azureKeyVault}.vault.azure.net/secrets/${azureSecretName}?api-version=2016-10-01",
  [
    'headers' => [
      'Authorization' => 'Bearer ' . $jsonData['access_token']
    ]
  ]
);

$apiResponse = $request->getBody()->getContents();
//$response_api = str_replace(" ","",substr($response_api,3));
$jsonData = json_decode($apiResponse, true);

print_r($jsonData);
?>
