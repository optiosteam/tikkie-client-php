<?php
declare(strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . "../vendor/autoload.php";

use Optios\Tikkie\TikkieApiClient;

$client   = new TikkieApiClient('your_api_key', null, null, false);
$appToken = $client->getSandboxAppToken();

echo '<pre>';
var_dump($appToken);
echo '</pre>';
