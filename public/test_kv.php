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

//print_r($jsonData);
?>

<h2>Connection String</h2>
<p><pre><strong><?= $jsonData['value'] ?></strong></pre></p>
<?php
$connectionConfigs = array();
$connectionStringParts = explode(';', $jsonData['value']);
foreach ($connectionStringParts as $keyValueItem) {
  if (!empty($keyValueItem)) {
    $keyValueItemParts = explode('=', $keyValueItem);
    $connectionConfigs[$keyValueItemParts[0]] = $keyValueItemParts[1];
  }
}

echo '<table border="1px" cellpadding="10px" cellspacing="0">';
foreach ($connectionConfigs as $key => $value) {
  echo "<tr><td>$key</td><td><pre><strong>$value</strong></pre></td></tr>\n";
}
echo '</table>';
?>

<h2>Test Connection</h2>
<?php
$serverNamePart = explode(',', str_replace('tcp:', '', $connectionConfigs['Server']));
$server = $serverNamePart[0];
$port = $serverNamePart[1];
$db = $connectionConfigs['Initial Catalog'];
$uid = $connectionConfigs['User ID'];
$pwd = $connectionConfigs['Password'];

$connectionOptions = array(
  "database" => $db,
  "uid" => $uid,
  "pwd" => $pwd,
);

// Establishes the connection
$conn = sqlsrv_connect($server, $connectionOptions);
if ($conn === false) {
  die(formatErrors(sqlsrv_errors()));
}

$sql = "SELECT @@Version AS SQL_VERSION";
$stmt = sqlsrv_query($conn, $sql);

// Error handling
if ($stmt === false) {
  die(formatErrors(sqlsrv_errors()));
}
?>

<pre><strong>Connection OK!</strong></pre>

<?php
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
  echo $row['SQL_VERSION'] . PHP_EOL;
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

function formatErrors($errors)
{
  // Display errors
  echo "Error information: <br/>";
  foreach ($errors as $error) {
    echo "SQLSTATE: " . $error['SQLSTATE'] . "<br/>";
    echo "Code: " . $error['code'] . "<br/>";
    echo "Message: " . $error['message'] . "<br/>";
  }
}

?>
