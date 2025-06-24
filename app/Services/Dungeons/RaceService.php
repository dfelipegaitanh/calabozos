<?php

declare(strict_types=1);

namespace App\Services\Dungeons;

use App\Services\Api\CalabozosApi;
use Exception;
use Illuminate\Http\Client\ConnectionException;

/**
 * Service responsible for managing race data from the Calabozos API.
 *
 * This service handles operations related to character races,
 * delegating API calls to the CalabozosApi service.
 */
readonly class RaceService
{
    public function __construct(
        private CalabozosApi $calabozosApi
    ) {}

    /**
     * Retrieve a specific race by its index identifier.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The race data or null if not found
     *
     * @throws Exception If any error occurs during the API request
     */
    public function getRace(string $index): ?array
    {
        return $this->calabozosApi->getRace($index);
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
        return $this->calabozosApi->getRaces();
    }

    /**
     * Retrieve subraces available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The subraces data or null if not found
     *
     * @throws Exception If any error occurs during the API request
     */
    public function getRaceSubraces(string $index): ?array
    {
        return $this->calabozosApi->getRaceSubraces($index);
    }
    
    /**
     * Retrieve proficiencies available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The proficiencies data or null if not found
     *
     * @throws Exception If any error occurs during the API request
     */
    public function getRaceProficiencies(string $index): ?array
    {
        return $this->calabozosApi->getRaceProficiencies($index);
    }
    
    /**
     * Retrieve traits available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return array|null The traits data or null if not found
     *
     * @throws Exception If any error occurs during the API request
     */
    public function getRaceTraits(string $index): ?array
    {
        return $this->calabozosApi->getRaceTraits($index);
    }
}
