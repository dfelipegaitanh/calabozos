<?php

declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class CalabozosApiClient
{
    private const BASE_URL = 'https://www.dnd5eapi.co/api';

    protected readonly PendingRequest $client;

    public function __construct()
    {
        $this->client = Http::baseUrl(self::BASE_URL)
            ->acceptJson()
            ->timeout(30);
    }

    /**
     * @throws ConnectionException
     */
    protected function get(string $method, array $parameters = []): Response
    {
        $response = $this->client->get($method, [
            ...$parameters,
        ]);

        if ($response->failed()) {
            $this->handleApiError($response);
        }

        return $response;
    }

    private function handleApiError(Response $response): void
    {

        throw new RuntimeException($response->reason(), $response->status());
    }
}
