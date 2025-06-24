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
     * @throws InvalidArgumentException If class index is empty
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
     * Retrieve features available for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The features data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If class index is empty
     */
    public function getClassFeatures(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Class index cannot be empty');
        }

        $response = $this->get('/classes/'.$index.'/features');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch features for class '{$index}': ".$response->status()
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

    /**
     * Retrieve proficiencies available for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The proficiencies data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If class index is empty
     */
    public function getClassProficiencies(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Class index cannot be empty');
        }

        $response = $this->get('/classes/'.$index.'/proficiencies');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch proficiencies for class '{$index}': ".$response->status()
            );
        }

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
     * Retrieve spells available for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The spells data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If class index is empty
     */
    public function getClassSpells(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Class index cannot be empty');
        }

        $response = $this->get('/classes/'.$index.'/spells');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch spells for class '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }

    /**
     * Retrieve subclasses available for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The subclasses data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If class index is empty
     */
    public function getClassSubclasses(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Class index cannot be empty');
        }

        $response = $this->get('/classes/'.$index.'/subclasses');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch subclasses for class '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }

    /**
     * Retrieve a specific race by its index.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The race data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If race index is empty
     */
    public function getRace(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Race index cannot be empty');
        }

        $response = $this->get('/races/'.$index);

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch race '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }

    /**
     * Retrieve all available races from the API.
     *
     * @return array|null The complete list of races from the API or null if not found
     *
     * @throws ConnectionException If API connection fails
     */
    public function getRaces(): ?array
    {
        $response = $this->get('/races');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                'Failed to fetch races: '.$response->status()
            );
        }

        return $response->json();
    }

    /**
     * Retrieve subraces available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The subraces data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If race index is empty
     */
    public function getRaceSubraces(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Race index cannot be empty');
        }

        $response = $this->get('/races/'.$index.'/subraces');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch subraces for race '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }
    
    /**
     * Retrieve proficiencies available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The proficiencies data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If race index is empty
     */
    public function getRaceProficiencies(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Race index cannot be empty');
        }

        $response = $this->get('/races/'.$index.'/proficiencies');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch proficiencies for race '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }
    
    /**
     * Retrieve traits available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The traits data or null if not found
     *
     * @throws ConnectionException If API connection fails
     * @throws InvalidArgumentException If race index is empty
     */
    public function getRaceTraits(string $index): ?array
    {
        if (in_array(mb_trim($index), ['', '0'], true)) {
            throw new InvalidArgumentException('Race index cannot be empty');
        }

        $response = $this->get('/races/'.$index.'/traits');

        if ($response->status() === 404) {
            return null;
        }

        if (! $response->successful()) {
            throw new ConnectionException(
                "Failed to fetch traits for race '{$index}': ".$response->status()
            );
        }

        return $response->json();
    }
}
