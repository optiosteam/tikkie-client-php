<?php
declare(strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . "../vendor/autoload.php";

use Optios\Tikkie\Request\GetRefundPathVariables;
use Optios\Tikkie\TikkieApiClient;

$client = new TikkieApiClient('your_api_key', 'your_app_token', null, false);
$result = $client->getRefund(
    new GetRefundPathVariables(
        'payment_request_token',
        'payment_token',
        'refund_token'
    )
);

echo '<pre>';
var_dump($result);
echo '</pre>';
