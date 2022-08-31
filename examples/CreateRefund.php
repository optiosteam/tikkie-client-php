<?php
declare(strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . "../vendor/autoload.php";

use Optios\Tikkie\Request\CreateRefund;
use Optios\Tikkie\Request\GetPaymentPathVariables;
use Optios\Tikkie\TikkieApiClient;

$client = new TikkieApiClient('your_api_key', 'your_app_token', null, false);
$result = $client->createRefund(
    new CreateRefund(
        new GetPaymentPathVariables('payment_request_token', 'payment_token'),
        'Refund of € 1.5',
        150
    )
);

echo '<pre>';
var_dump($result);
echo '</pre>';
