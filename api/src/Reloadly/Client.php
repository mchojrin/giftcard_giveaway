<?php

namespace App\Reloadly;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Client
{
    public const GRANT_TYPE = 'client_credentials';
    private HttpClientInterface $httpClient;
    private string $accessToken;
    private string $clientId;
    private string $secret;

    public function __construct(HttpClientInterface $httpClient, string $clientId, string $secret)
    {
        $this->httpClient = $httpClient;
        $this->clientId = $clientId;
        $this->secret = $secret;
    }

    public function sendGiftCard(string $email)
    {
        if (empty($this->accessToken)) {
            $this->accessToken = $this->getAccessToken();
        }

        $this->purchaseGiftCard();
    }

    private function getAccessToken(): string
    {
        $data = [
            'client_id' => $this->clientId,
            'client_secret' => $this->secret,
            'grant_type' => self::GRANT_TYPE,
            'audience' => 'https://giftcards.reloadly.com'
        ];

        $response = $this->httpClient
            ->request('POST', 'https://auth.reloadly.com/oauth/token',
            [
                'body' => json_encode($data),
                'headers' => [
                    'Content-Type: application/json',
                ]
            ])
            ;
        if (200 != $response->getStatusCode()) {

            throw new Exception('Couldn\'t obtain an access token: '.$response->getContent());
        }

        return $response->getContent();
    }

    private function purchaseGiftCard() : void
    {

    }
}
