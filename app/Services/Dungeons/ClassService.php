<?php

declare(strict_types=1);

namespace App\Services\Dungeons;

use App\Actions\Classes\FetchAndPersistClassesAction;
use App\Services\Api\CalabozosApi;
use Exception;

/**
 * Service responsible for managing character class data from the Calabozos API.
 *
 * This service orchestrates the actions related to character classes,
 * delegating specific business operations to dedicated Action classes.
 */
readonly class ClassService
{
    public function __construct(
        private FetchAndPersistClassesAction $fetchAndPersistClassesAction,
        private CalabozosApi $calabozosApi
    ) {}

    /**
     * Retrieve all character classes and ensure they are stored in the database.
     *
     * This method delegates the fetch and persist operations to the FetchAndPersistClassesAction.
     *
     * @return array The complete API response containing all classes
     *
     * @throws Exception If any error occurs during the process
     */
    public function getAllClasses(): array
    {
        return $this->fetchAndPersistClassesAction->handle();
    }

    /**
     * Retrieve a specific character class by its index identifier.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The class data or null if not found
     *
     * @throws Exception If any error occurs during the API request
     */
    public function getClassByIndex(string $index): ?array
    {
        return $this->calabozosApi->getClass($index);
    }

    /**
     * Retrieve spellcasting information for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The spellcasting information or null if not found or the class doesn't have spellcasting
     *
     * @throws Exception If any error occurs during the API request
     */
    public function getClassSpellcasting(string $index): ?array
    {
        return $this->calabozosApi->getClassSpellcasting($index);
    }

    /**
     * Retrieve multiclassing information for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return array|null The multiclassing information or null if not found or the class doesn't have multiclassing info
     *
     * @throws Exception If any error occurs during the API request
     */
    public function getClassMulticlassing(string $index): ?array
    {
        return $this->calabozosApi->getClassMulticlassing($index);
    }
}
