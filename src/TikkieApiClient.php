<?php
declare(strict_types = 1);

namespace Optios\Tikkie;

use Composer\CaBundle\CaBundle;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use League\Url\Url;
use Optios\Tikkie\Exception\TikkieApiException;
use Optios\Tikkie\Request\CreateRefund;
use Optios\Tikkie\Request\GetAllPaymentsForPaymentRequest;
use Optios\Tikkie\Request\GetPaymentPathVariables;
use Optios\Tikkie\Request\GetRefundPathVariables;
use Optios\Tikkie\Request\RequestInterface;
use Optios\Tikkie\Request\GetAllPaymentRequests;
use Optios\Tikkie\Request\SubscribeWebhookNotificationsRequest;
use Optios\Tikkie\Response\PaymentRequestResult;
use Optios\Tikkie\Request\CreatePaymentRequest;
use Optios\Tikkie\Response\GetAllPaymentRequestsResult;
use Optios\Tikkie\Response\GetAllPaymentsForPaymentRequestResult;
use Optios\Tikkie\Response\PaymentResult;
use Optios\Tikkie\Response\RefundResult;
use Optios\Tikkie\Response\SubscriptionResult;

/**
 * Class TikkieApiClient
 * @package Optios\Tikkie
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class TikkieApiClient
{
    public const  API_VERSION          = 'v2';
    public const  API_ENDPOINT         = 'https://api.abnamro.com/';
    public const  API_SANDBOX_ENDPOINT = 'https://api-sandbox.abnamro.com/';
    private const TIMEOUT              = 10;
    private const CONNECT_TIMEOUT      = 2;

    private string $apiKey;

    private ?string $appToken = null;

    private ClientInterface $httpClient;

    private bool $useProd;

    public function __construct(
        string $apiKey,
        ?string $appToken = null,
        ?ClientInterface $httpClient = null,
        bool $useProd = true
    ) {
        if (null === $httpClient) {
            $httpClient = new Client([
                RequestOptions::TIMEOUT => self::TIMEOUT,
                RequestOptions::CONNECT_TIMEOUT => self::CONNECT_TIMEOUT,
                RequestOptions::VERIFY => CaBundle::getBundledCaBundlePath(),
            ]);
        }

        $this->apiKey     = $apiKey;
        $this->appToken   = $appToken;
        $this->httpClient = $httpClient;
        $this->useProd    = $useProd;
    }

    public function createPaymentRequest(CreatePaymentRequest $request): PaymentRequestResult
    {
        try {
            $response = $this->httpClient->post(
                $this->getApiEndpointBase() . '/paymentrequests',
                $this->getRequestOptions($request)
            );

            return PaymentRequestResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function getPaymentRequest(string $paymentRequestToken): PaymentRequestResult
    {
        try {
            $response = $this->httpClient->get(
                $this->getApiEndpointBase() . '/paymentrequests/' . $paymentRequestToken,
                $this->getRequestOptions()
            );

            return PaymentRequestResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function getAllPaymentRequests(GetAllPaymentRequests $request): GetAllPaymentRequestsResult
    {
        $url = Url::createFromUrl($this->getApiEndpointBase() . '/paymentrequests');
        $url->getQuery()->modify($request->toArray());

        try {
            $response = $this->httpClient->get(
                $url->__toString(),
                $this->getRequestOptions()
            );

            return GetAllPaymentRequestsResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function getAllPaymentsForPaymentRequest(
        GetAllPaymentsForPaymentRequest $request
    ): GetAllPaymentsForPaymentRequestResult {
        $url = Url::createFromUrl(
            $this->getApiEndpointBase() . '/paymentrequests/' . $request->getPaymentRequestToken() . '/payments'
        );

        $url->getQuery()->modify($request->toArray());

        try {
            $response = $this->httpClient->get(
                $url->__toString(),
                $this->getRequestOptions()
            );

            return GetAllPaymentsForPaymentRequestResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function getPaymentFromPaymentRequest(GetPaymentPathVariables $pathVariables): PaymentResult
    {
        try {
            $response = $this->httpClient->get(
                sprintf(
                    '%s/paymentrequests/%s/payments/%s',
                    $this->getApiEndpointBase(),
                    $pathVariables->getPaymentRequestToken(),
                    $pathVariables->getPaymentToken()
                ),
                $this->getRequestOptions()
            );

            return PaymentResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function createRefund(CreateRefund $request): RefundResult
    {
        try {
            $response = $this->httpClient->post(
                sprintf(
                    '%s/paymentrequests/%s/payments/%s/refunds',
                    $this->getApiEndpointBase(),
                    $request->getPathVariables()->getPaymentRequestToken(),
                    $request->getPathVariables()->getPaymentToken()
                ),
                $this->getRequestOptions($request)
            );

            return RefundResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function getRefund(GetRefundPathVariables $pathVariables): RefundResult
    {
        try {
            $response = $this->httpClient->get(
                sprintf(
                    '%s/paymentrequests/%s/payments/%s/refunds/%s',
                    $this->getApiEndpointBase(),
                    $pathVariables->getPaymentRequestToken(),
                    $pathVariables->getPaymentToken(),
                    $pathVariables->getRefundToken()
                ),
                $this->getRequestOptions()
            );

            return RefundResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function subscribeWebhookNotifications(SubscribeWebhookNotificationsRequest $request): SubscriptionResult
    {
        try {
            $response = $this->httpClient->post(
                $this->getApiEndpointBase() . '/paymentrequestssubscription',
                $this->getRequestOptions($request)
            );

            return SubscriptionResult::createFromResponse($response);
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function deleteNotificationSubscription(): void
    {
        try {
            $this->httpClient->delete(
                $this->getApiEndpointBase() . '/paymentrequestssubscription',
                $this->getRequestOptions()
            );
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function getSandboxAppToken(): string
    {
        try {
            $uri      = $this->getApiEndpointBase() . '/sandboxapps';
            $response = $this->httpClient->post(
                $uri,
                [
                    RequestOptions::HEADERS => [
                        'API-Key' => $this->apiKey,
                    ],
                ]
            );

            $response = json_decode($response->getBody()->getContents(), true);

            return $response[ 'appToken' ];
        } catch (ClientException $e) {
            throw TikkieApiException::createFromClientException($e);
        }
    }

    public function getApiEndpointBase(): string
    {
        return ($this->useProd ? self::API_ENDPOINT : self::API_SANDBOX_ENDPOINT) . self::API_VERSION . '/tikkie';
    }

    public function getRequestOptions(?RequestInterface $request = null): array
    {
        $options = [
            RequestOptions::HEADERS => [
                'X-App-Token' => $this->appToken,
                'API-Key' => $this->apiKey,
            ],
        ];

        if (null !== $request) {
            $options[ RequestOptions::JSON ] = $request->toArray();
        }

        return $options;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getAppToken(): ?string
    {
        return $this->appToken;
    }
}
