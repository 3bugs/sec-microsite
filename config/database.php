<?php
//require '../vendor/autoload.php';

use Illuminate\Support\Str;
use GuzzleHttp\Client;
//use GuzzleHttp\Psr7\Request;

if (env('AZURE') == '1') {
  $azureKeyVault = env('AZURE_KEY_VAULT');
  $azureSecretName = env('AZURE_SECRET_NAME');
  $azureAdTenantId = env('AZURE_AD_TENANT_ID');
  $azureAdApplicationId = env('AZURE_AD_APPLICATION_ID');
  $azureAdApplicationSecret = env('AZURE_AD_APPLICATION_SECRET');

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

  $connectionConfigs = array();
  $connectionStringParts = explode(';', $jsonData['value']);
  foreach ($connectionStringParts as $keyValueItem) {
    if (!empty($keyValueItem)) {
      $keyValueItemParts = explode('=', $keyValueItem);
      $connectionConfigs[$keyValueItemParts[0]] = $keyValueItemParts[1];
    }
  }

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
}

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => env('AZURE') == '1' ? [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => $server, //env('DB_HOST', 'localhost'),
            'port' => $port, //env('DB_PORT', '1433'),
            'database' => $db, //env('DB_DATABASE', 'forge'),
            'username' => $uid, //env('DB_USERNAME', 'forge'),
            'password' => $pwd, //env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
        ] : [
          'driver' => 'sqlsrv',
          'url' => env('DATABASE_URL'),
          'host' => env('DB_HOST', 'localhost'),
          'port' => env('DB_PORT', '1433'),
          'database' => env('DB_DATABASE', 'forge'),
          'username' => env('DB_USERNAME', 'forge'),
          'password' => env('DB_PASSWORD', ''),
          'charset' => 'utf8',
          'prefix' => '',
          'prefix_indexes' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
