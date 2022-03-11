<?php

namespace App\Reloadly;

class Configuration
{
    private string $clientId;
    private string $secret;
    private bool $sandbox;
    private int $productId;
    private string $senderName;
    private int $unitPrice;

    public function __construct(string $clientId, string $secret, bool $sandbox, int $productId, string $senderName, int $unitPrice )
    {
        $this->clientId = $clientId;
        $this->secret = $secret;
        $this->sandbox = $sandbox;
        $this->productId = $productId;
        $this->senderName = $senderName;
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    /**
     * @return bool
     */
    public function isSandbox(): bool
    {
        return $this->sandbox;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @return string
     */
    public function getSenderName(): string
    {
        return $this->senderName;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }
}
