[![CI](https://github.com/optiosteam/tikkie-client-php/actions/workflows/tests.yaml/badge.svg?branch=main)](https://github.com/optiosteam/tikkie-client-php/actions/workflows/tests.yaml)
[![codecov](https://codecov.io/gh/optiosteam/tikkie-client-php/branch/main/graph/badge.svg?token=S62YDUXV7A)](https://codecov.io/gh/optiosteam/tikkie-client-php)

# PHP Tikkie API Client

Supported API version: v2.3

Development sponsored by [Optios](https://www.optios.net)

API Documentation: https://developer.abnamro.com/api-products/tikkie/reference-documentation

## Installation

**Requirement**: PHP version >=7.4

```
composer require optiosteam/tikkie-client-php
```

## Examples

### Get Sandbox (staging) app token

As a developer using the sandbox environment, you will need to create an app token before you call other endpoints.

```php
use Optios\Tikkie\TikkieApiClient;

$client   = new TikkieApiClient('your_api_key', null, null, false);
$appToken = $client->getSandboxAppToken();
var_dump($appToken);
```

### Create payment request

```php
use Optios\Tikkie\Request\CreatePaymentRequest;
use Optios\Tikkie\TikkieApiClient;

$client = new TikkieApiClient('your_api_key', 'your_app_token', null, false);

$paymentRequest = new CreatePaymentRequest('This is a description');
$paymentRequest->setAmountInCents(500);
$result = $client->createPaymentRequest($paymentRequest);
var_dump($result);
```

### Get payment request

```php
use Optios\Tikkie\TikkieApiClient;

$client = new TikkieApiClient('your_api_key', 'your_app_token', null, false);
$result = $client->getPaymentRequest('payment_request_token');
var_dump($result);
```

### Get all payment requests (search with paging and optional dates)

```php
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
var_dump($result);
```

### Get payment from payment request

```php
use Optios\Tikkie\Request\GetPaymentPathVariables;
use Optios\Tikkie\TikkieApiClient;

$client = new TikkieApiClient('your_api_key', 'your_app_token', null, false);
$result = $client->getPaymentFromPaymentRequest(
    new GetPaymentPathVariables('payment_request_token', 'payment_token')
);
var_dump($result);
```

### Get all payments for payment request (search with paging and optional dates)

```php
use Optios\Tikkie\Request\GetAllPaymentsForPaymentRequest;
use Optios\Tikkie\TikkieApiClient;

$client = new TikkieApiClient('your_api_key', 'your_app_token', null, false);
$result = $client->getAllPaymentsForPaymentRequest(
    new GetAllPaymentsForPaymentRequest(
        'payment_request_token',
        0,
        10,
        true
    )
);
var_dump($result);
```

### Create refund

```php
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
var_dump($result);
```

### Get refund
```php
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
var_dump($result);
```

## Contributing

Feel free to submit pull requests for improvements & bug fixes :)

MIT License
