<?php

declare(strict_types=1);

namespace App\Services\Api;

use Illuminate\Http\Client\ConnectionException;
use InvalidArgumentException;

/**
 * Client for interacting with the Calabozos D&D API.
 *
 * This class extends the base CalabozosApiClient to provide specific
 * endpoints for retrieving character class data from the API.
 */
class CalabozosApi extends CalabozosApiClient
{
    /**
     * Retrieve a specific character class by its index identifier.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The class data or null if not found
     *
     * @throws ConnectionException If API connection fails
     */
    public function getClass(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Class index cannot be empty');
        }

        $response = $this->get('/classes/'.$index);

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch class '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }

    /**
     * Retrieve all available character classes from the API.
     *
     * @return array The complete list of classes from the API
     *
     * @throws ConnectionException If API connection fails
     */
    public function getClasses(): array
    {
        $response = $this->get('/classes');

        return $response->json();
    }

    /**
     * Retrieve spellcasting information for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The spellcasting data or null if not found or the class doesn't have spellcasting
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If class index is empty
     */
    public function getClassSpellcasting(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Class index cannot be empty');
        }

        $response = $this->get('/classes/'.$index.'/spellcasting');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch spellcasting for class '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }

    /**
     * Retrieve multiclassing information for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The multiclassing data or null if not found or the class doesn't have multiclassing info
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If class index is empty
     */
    public function getClassMulticlassing(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Class index cannot be empty');
        }

        $response = $this->get('/classes/'.$index.'/multi-classing');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch multiclassing information for class '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }
}
