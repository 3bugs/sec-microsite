<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

$client = new Client([
  // Base URI is used with relative requests
  //'base_uri' => 'http://httpbin.org',
  // You can set any number of default request options.
  //'timeout'  => 2.0,
]);

$request = new Request('GET', 'http://httpbin.org/get');
$response = $client->send($request, ['timeout' => 2]);
?>
<h2>TEST GUZZLE</h2>
<table style="border: 1px solid #666; padding: 5px" cellpadding="5px">
  <tbody>
  <tr style="background-color: #e5ffd1">
    <td style="width: 120px">STATUS CODE:</td>
    <td><?= $response->getStatusCode() ?></td>
  </tr>
  <tr>
    <td>PHRASE:</td>
    <td><?= $response->getReasonPhrase() ?></td>
  </tr>
  <tr style="background-color: #e5ffd1">
    <td>BODY:</td>
    <td><?= $response->getBody() ?></td>
  </tr>
  </tbody>
</table>
