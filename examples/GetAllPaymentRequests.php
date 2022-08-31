<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . "../vendor/autoload.php";

use Carbon\Carbon;
use Optios\Tikkie\Request\GetAllPaymentRequests;
use Optios\Tikkie\TikkieApiClient;

$client  = new TikkieApiClient('your_api_key', 'your_app_token', null, false);
$request = new GetAllPaymentRequests(
    0,
    50
);
$request->setFromDateTime(Carbon::now()->subHours(2));

$result = $client->getAllPaymentRequests($request);

echo '<pre>';
var_dump($result);
echo '</pre>';
