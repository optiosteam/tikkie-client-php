<?php
declare(strict_types = 1);

namespace Tests\Optios\Tikkie;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Optios\Tikkie\Request\CreatePaymentRequest;
use Optios\Tikkie\Request\CreateRefund;
use Optios\Tikkie\Request\GetAllPaymentRequests;
use Optios\Tikkie\Request\GetAllPaymentsForPaymentRequest;
use Optios\Tikkie\Request\GetPaymentPathVariables;
use Optios\Tikkie\Request\GetRefundPathVariables;
use Optios\Tikkie\Request\RequestInterface;
use Optios\Tikkie\Request\SubscribeWebhookNotificationsRequest;
use Optios\Tikkie\TikkieApiClient;
use PHPUnit\Framework\TestCase;

class TikkieApiClientTest extends TestCase
{
    private TikkieApiClient $tikkieApiClient;

    private string $apiKey;

    private ?string $appToken = null;

    private ClientInterface $httpClient;

    private bool $useProd;

    public function setUp(): void
    {
        parent::setUp();

        $this->apiKey     = 'some-api-key';
        $this->appToken   = 'some-app-token';
        $this->httpClient = $this->createMock(Client::class);
        $this->useProd    = false;

        $this->tikkieApiClient = new TikkieApiClient(
            $this->apiKey,
            $this->appToken,
            $this->httpClient,
            $this->useProd
        );
    }

    public function test(): void
    {
        $this->assertEquals('some-api-key', $this->tikkieApiClient->getApiKey());
        $this->assertEquals('some-app-token', $this->tikkieApiClient->getAppToken());
    }

    public function testGetApiEndpointBase(): void
    {
        $this->assertEquals('https://api-sandbox.abnamro.com/v2/tikkie', $this->tikkieApiClient->getApiEndpointBase());
    }

    public function testGetRequestOptions(): void
    {
        $request = new CreatePaymentRequest('Some payment request description');
        $request->setAmountInCents(200);

        $array = [
            'headers' => [
                'X-App-Token' => 'some-app-token',
                'API-Key' => 'some-api-key',
            ],
            'json' => [
                'description' => 'Some payment request description',
                'amountInCents' => 200,
            ],
        ];

        $this->assertEquals($array, $this->tikkieApiClient->getRequestOptions($request));
    }

    public function testCreatePaymentRequest(): void
    {
        $request = new CreatePaymentRequest('Some payment request description');
        $request->setAmountInCents(200);

        $this->httpClient
            ->expects($this->once())
            ->method('post')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals('https://api-sandbox.abnamro.com/v2/tikkie/paymentrequests', $uri);
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                        'json' => [
                            'description' => 'Some payment request description',
                            'amountInCents' => 200,
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'paymentRequestToken' => 'qzdnzr8hnVWTgXXcFRLUMc',
                            'url' => 'https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc',
                            'amountInCents' => 200,
                            'description' => 'Some payment request description',
                            'createdDateTime' => '2022-08-31 11:22:33',
                            'expiryDate' => '2022-09-14',
                            'status' => 'OPEN',
                            'numberOfPayments' => 0,
                            'totalAmountPaidInCents' => 0,
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->createPaymentRequest($request);

        $this->assertEquals('qzdnzr8hnVWTgXXcFRLUMc', $result->getPaymentRequestToken());
        $this->assertEquals('https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc', $result->getUrl());
        $this->assertEquals(200, $result->getAmountInCents());
        $this->assertEquals('Some payment request description', $result->getDescription());
    }

    public function testGetPaymentRequest(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequests/qzdnzr8hnVWTgXXcFRLUMc',
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'paymentRequestToken' => 'qzdnzr8hnVWTgXXcFRLUMc',
                            'url' => 'https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc',
                            'amountInCents' => 200,
                            'description' => 'Some payment request description',
                            'createdDateTime' => '2022-08-31 11:22:33',
                            'expiryDate' => '2022-09-14',
                            'status' => 'OPEN',
                            'numberOfPayments' => 0,
                            'totalAmountPaidInCents' => 0,
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->getPaymentRequest('qzdnzr8hnVWTgXXcFRLUMc');

        $this->assertEquals('qzdnzr8hnVWTgXXcFRLUMc', $result->getPaymentRequestToken());
        $this->assertEquals('https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc', $result->getUrl());
        $this->assertEquals(200, $result->getAmountInCents());
        $this->assertEquals('Some payment request description', $result->getDescription());
    }

    public function testGetAllPaymentRequest(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequests?pageNumber=0&pageSize=50',
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode([
                            'totalElementCount' => 2,
                            'paymentRequests' => [
                                [
                                    'paymentRequestToken' => 'qzdnzr8hnVWTgXXcFRLUMc',
                                    'url' => 'https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc',
                                    'amountInCents' => 200,
                                    'description' => 'Some payment request description',
                                    'createdDateTime' => '2022-08-31 11:22:33',
                                    'expiryDate' => '2022-09-14',
                                    'status' => 'OPEN',
                                    'numberOfPayments' => 0,
                                    'totalAmountPaidInCents' => 0,
                                ],
                                [
                                    'paymentRequestToken' => 'xxx',
                                    'url' => 'https://tikkie.me/pay/Tikkie/xxx',
                                    'amountInCents' => 300,
                                    'description' => 'Some text',
                                    'createdDateTime' => '2022-09-01 11:22:33',
                                    'expiryDate' => '2022-09-14',
                                    'status' => 'OPEN',
                                    'numberOfPayments' => 0,
                                    'totalAmountPaidInCents' => 0,
                                ],
                            ],
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->getAllPaymentRequests(new GetAllPaymentRequests());

        $this->assertEquals(2, $result->getTotalElementCount());
        $this->assertEquals(
            'qzdnzr8hnVWTgXXcFRLUMc',
            $result->getPaymentRequests()[ 0 ]->getPaymentRequestToken()
        );
        $this->assertEquals(
            'https://tikkie.me/pay/Tikkie/qzdnzr8hnVWTgXXcFRLUMc',
            $result->getPaymentRequests()[ 0 ]->getUrl()
        );
        $this->assertEquals(200, $result->getPaymentRequests()[ 0 ]->getAmountInCents());
        $this->assertEquals('Some payment request description', $result->getPaymentRequests()[ 0 ]->getDescription());
    }

    public function testGetAllPaymentsForPaymentRequest(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    //phpcs:disable
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequests/qzdnzr8hnVWTgXXcFRLUMc/payments?pageNumber=0&pageSize=50&includeRefunds=true',
                    //phpcs:enable
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'totalElementCount' => 1,
                            'payments' => [
                                [
                                    'paymentToken' => '132465',
                                    'tikkieId' => 10233456,
                                    'counterPartyName' => 'Optios',
                                    'counterPartyAccountNumber' => 'NL01ABNA1234567890',
                                    'amountInCents' => 600,
                                    'description' => 'payment description',
                                    'createdDateTime' => '2022-08-31 11:22:33',
                                ],
                            ],
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->getAllPaymentsForPaymentRequest(
            new GetAllPaymentsForPaymentRequest('qzdnzr8hnVWTgXXcFRLUMc')
        );

        $this->assertEquals(1, $result->getTotalElementCount());
        $this->assertEquals('132465', $result->getPayments()[ 0 ]->getPaymentToken());
        $this->assertEquals('10233456', $result->getPayments()[ 0 ]->getTikkieId());
        $this->assertEquals('Optios', $result->getPayments()[ 0 ]->getCounterPartyName());
        $this->assertEquals('NL01ABNA1234567890', $result->getPayments()[ 0 ]->getCounterPartyAccountNumber());
        $this->assertEquals(600, $result->getPayments()[ 0 ]->getAmountInCents());
        $this->assertEquals('payment description', $result->getPayments()[ 0 ]->getDescription());
        $this->assertEquals(
            '2022-08-31 11:22:33',
            $result->getPayments()[ 0 ]->getCreatedDateTime()->format('Y-m-d H:i:s')
        );
    }

    public function testGetPaymentFromPaymentRequest(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    //phpcs:disable
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequests/qzdnzr8hnVWTgXXcFRLUMc/payments/132465',
                    //phpcs:enable
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'paymentToken' => '132465',
                            'tikkieId' => 10233456,
                            'counterPartyName' => 'Optios',
                            'counterPartyAccountNumber' => 'NL01ABNA1234567890',
                            'amountInCents' => 600,
                            'description' => 'payment description',
                            'createdDateTime' => '2022-08-31 11:22:33',
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->getPaymentFromPaymentRequest(
            new GetPaymentPathVariables('qzdnzr8hnVWTgXXcFRLUMc', '132465')
        );

        $this->assertEquals('132465', $result->getPaymentToken());
        $this->assertEquals('10233456', $result->getTikkieId());
        $this->assertEquals('Optios', $result->getCounterPartyName());
        $this->assertEquals('NL01ABNA1234567890', $result->getCounterPartyAccountNumber());
        $this->assertEquals(600, $result->getAmountInCents());
        $this->assertEquals('payment description', $result->getDescription());
        $this->assertEquals(
            '2022-08-31 11:22:33',
            $result->getCreatedDateTime()->format('Y-m-d H:i:s')
        );
    }

    public function testCreateRefund(): void
    {
        $request = new CreateRefund(
            new GetPaymentPathVariables(
                'qzdnzr8hnVWTgXXcFRLUMc',
                '132465'
            ),
            'Some payment request description',
            200
        );

        $this->httpClient
            ->expects($this->once())
            ->method('post')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    //phpcs:disable
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequests/qzdnzr8hnVWTgXXcFRLUMc/payments/132465/refunds',
                    //phpcs:enable
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                        'json' => [
                            'description' => 'Some payment request description',
                            'amountInCents' => 200,
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'refundToken' => '123456abc',
                            'amountInCents' => 200,
                            'description' => 'Some payment request description',
                            'createdDateTime' => '2022-08-31 11:22:33',
                            'status' => 'PENDING',
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->createRefund($request);

        $this->assertEquals('123456abc', $result->getRefundToken());
        $this->assertEquals(200, $result->getAmountInCents());
        $this->assertEquals('Some payment request description', $result->getDescription());
        $this->assertEquals('2022-08-31 11:22:33', $result->getCreatedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('PENDING', $result->getStatus());
        $this->assertNull($result->getReferenceId());
    }

    public function testGetRefund(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('get')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    //phpcs:disable
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequests/qzdnzr8hnVWTgXXcFRLUMc/payments/132465/refunds/123456abc',
                    //phpcs:enable
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'refundToken' => '123456abc',
                            'amountInCents' => 200,
                            'description' => 'Some payment request description',
                            'createdDateTime' => '2022-08-31 11:22:33',
                            'status' => 'PENDING',
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->getRefund(
            new GetRefundPathVariables('qzdnzr8hnVWTgXXcFRLUMc', '132465', '123456abc')
        );

        $this->assertEquals('123456abc', $result->getRefundToken());
        $this->assertEquals(200, $result->getAmountInCents());
        $this->assertEquals('Some payment request description', $result->getDescription());
        $this->assertEquals('2022-08-31 11:22:33', $result->getCreatedDateTime()->format('Y-m-d H:i:s'));
        $this->assertEquals('PENDING', $result->getStatus());
        $this->assertNull($result->getReferenceId());
    }

    public function testSubscribeWebhookNotifications(): void
    {
        $request = new SubscribeWebhookNotificationsRequest('https://www.mywebsite.com/tikkie/webhook');

        $this->httpClient
            ->expects($this->once())
            ->method('post')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequestssubscription',
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                        'json' => [
                            'url' => 'https://www.mywebsite.com/tikkie/webhook',
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'subscriptionId' => 'sub123456xyz',
                        ]
                    )
                );
            });

        $result = $this->tikkieApiClient->subscribeWebhookNotifications($request);
        $this->assertEquals('sub123456xyz', $result->getSubscriptionId());
    }

    public function testDeleteNotificationSubscription(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('delete')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals(
                    'https://api-sandbox.abnamro.com/v2/tikkie/paymentrequestssubscription',
                    $uri
                );
                $this->assertEquals(
                    [
                        'headers' => [
                            'X-App-Token' => 'some-app-token',
                            'API-Key' => 'some-api-key',
                        ],
                    ],
                    $options
                );

                return new Response(200);
            });

        $this->tikkieApiClient->deleteNotificationSubscription();
    }

    public function testGetSandboxAppToken(): void
    {
        $this->httpClient
            ->expects($this->once())
            ->method('post')
            ->willReturnCallback(function($uri, array $options) {
                $this->assertEquals('https://api-sandbox.abnamro.com/v2/tikkie/sandboxapps', $uri);
                $this->assertEquals(
                    [
                        'headers' => [
                            'API-Key' => 'some-api-key',
                        ],
                    ],
                    $options
                );

                return new Response(
                    200,
                    [],
                    json_encode(
                        [
                            'appToken' => 'some-app-token',
                        ]
                    )
                );
            });

        $appToken = $this->tikkieApiClient->getSandboxAppToken();
        $this->assertEquals('some-app-token', $appToken);
    }
}
