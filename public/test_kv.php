<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/*$client = new Client([
  // Base URI is used with relative requests
  //'base_uri' => 'http://httpbin.org',
  // You can set any number of default request options.
  //'timeout'  => 2.0,
]);

$request = new Request('GET', 'http://httpbin.org/get');
$response = $client->send($request, ['timeout' => 2]);*/


// Login
$client = new Client();
$request = $client->request('POST', 'https://login.microsoftonline.com/' . env('0ad5298e-296d-45ab-a446-c0d364c5b18b') . '/oauth2/v2.0/token',
  [
    'form_params' => [
      'grant_type' => 'client_credentials',
      'client_id' => env('2035ec54-9f6b-4228-8ea1-99c4f2201357'),
      'client_secret' => env('.3_rguxkDadQ5m_oQNsvn8s_Lrj6~PPn8O'),
      'scope' => 'https://vault.azure.net/.default'
    ]
  ]
);

$response_api = $request->getBody()->getContents();
//$response_api = str_replace(" ","",substr($response_api,3));
$data_json = json_decode($response_api, true);

// Get Secrets
$request = $client->request('get', 'https://' . env('SWW003KVT801') . '.vault.azure.net/secrets/' . env('SEC-AZMSDB-SMEUSER-SMEMCDB') . '?api-version=2016-10-01', [
  'headers' => [
    'Authorization' => 'Bearer ' . $data_json['access_token']
  ]
]);

$response_api = $request->getBody()->getContents();
//$response_api = str_replace(" ","",substr($response_api,3));
$data_json = json_decode($response_api, true);

print_r($data_json);
?>
