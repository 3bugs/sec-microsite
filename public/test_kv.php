<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

// Login
$client = new Client();
$request = $client->request(
  'POST',
  'https://login.microsoftonline.com/' . env('AZURE_AD_TENANT_ID') . '/oauth2/v2.0/token',
  [
    'form_params' => [
      'grant_type' => 'client_credentials',
      'client_id' => env('AZURE_AD_APPLICATION_ID'),
      'client_secret' => env('AZURE_AD_APPLICATION_SECRET'),
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
  'https://' . env('AZURE_KEY_VAULT') . '.vault.azure.net/secrets/' . env('AZURE_SECRET_NAME') . '?api-version=2016-10-01',
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
