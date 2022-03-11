<?php

namespace App\Reloadly;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    public const GRANT_TYPE = 'client_credentials';
    public const SANDBOX_MODIFIER = '-sandbox';
    const OAUTH_TOKEN_ENDPOINT = 'https://auth.reloadly.com/oauth/token';
    const SEND_GIFTCARD_ENDPOINT = '/orders';
    const HTTP_ACCEPT_HEADER = 'application/com.reloadly.giftcards-v1+json';

    private HttpClientInterface $httpClient;
    private string $accessToken;
    private string $baseUrl;
    private Configuration $configuration;

    public function __construct(HttpClientInterface $httpClient, Configuration $configuration)
    {
        $this->httpClient = $httpClient;
        $this->configuration = $configuration;
        $this->baseUrl = 'https://giftcards' . ($configuration->isSandbox() ? self::SANDBOX_MODIFIER : '') . '.reloadly.com';
    }

    public function sendGiftCardTo(string $email)
    {
        if (empty($this->accessToken)) {
            $this->accessToken = $this->getAccessToken();
        }

        $this->purchaseGiftCardFor($email);
    }

    private function getAccessToken(): string
    {
        $data = [
            'client_id' => $this->configuration->getClientId(),
            'client_secret' => $this->configuration->getSecret(),
            'grant_type' => self::GRANT_TYPE,
            'audience' => $this->baseUrl,
        ];

        $response = $this->httpClient
            ->request('POST', self::OAUTH_TOKEN_ENDPOINT,
                [
                    'body' => json_encode($data),
                    'headers' => [
                        'Content-Type: application/json',
                    ]
                ]);
        if (200 != $response->getStatusCode()) {

            throw new Exception('Couldn\'t obtain an access token: ' . $response->getContent());
        }

        $responseElements = json_decode($response->getContent(), true);

        return $responseElements['access_token'];
    }

    private function purchaseGiftCardFor(string $recipientEmail): void
    {
        $data = [
            "productId" => $this->configuration->getProductId(),
            "quantity" => 1,
            "unitPrice" => $this->configuration->getUnitPrice(),
            "senderName" => $this->configuration->getSenderName(),
            "recipientEmail" => $recipientEmail,
        ];

        $response = $this->httpClient
            ->request('POST', $this->baseUrl . self::SEND_GIFTCARD_ENDPOINT, [
                'headers' => [
                    'Authorization: Bearer ' . $this->accessToken,
                    'Content-Type: application/json',
                    'Accept: ' . self::HTTP_ACCEPT_HEADER
                ],
                'body' => json_encode($data),
            ]);
    }
}
