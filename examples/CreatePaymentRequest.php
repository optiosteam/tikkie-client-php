<?php
declare(strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . "../vendor/autoload.php";

use Optios\Tikkie\Request\CreatePaymentRequest;
use Optios\Tikkie\TikkieApiClient;

$client = new TikkieApiClient('your_api_key', 'your_app_token', null, false);

$paymentRequest = new CreatePaymentRequest('This is a description');
$paymentRequest->setAmountInCents(500);
$result = $client->createPaymentRequest($paymentRequest);

echo '<pre>';
var_dump($result);
echo '</pre>';
