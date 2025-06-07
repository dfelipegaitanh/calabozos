<?php

declare(strict_types=1);

namespace App\Actions\Classes;

use App\DTOs\Classes\ClassDto;
use App\Services\Api\CalabozosApi;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Action responsible for fetching all character classes from the API
 * and persisting them to the database.
 *
 * This action encapsulates the complete business operation of synchronizing
 * class data between the external API and our local database.
 */
readonly class FetchAndPersistClassesAction
{
    public function __construct(
        private CalabozosApi $calabozosApi,
        private CreateClassAction $createClassAction
    ) {}

    /**
     * Fetches all classes from the API and persists them to the database.
     *
     * For each class retrieved from the API, this method:
     * 1. Validates that the class data is an array
     * 2. Converts the raw data to a ClassDto
     * 3. Uses CreateClassAction to persist the class data
     * 4. Logs any errors that occur during processing of individual classes
     *
     * @return array The original response from the CalabozosApi
     *
     * @throws Exception If the API response is invalid or missing the results array
     */
    public function handle(): array
    {
        $apiResponse = $this->calabozosApi->getClasses();

        if (isset($apiResponse['results']) && is_array($apiResponse['results'])) {
            foreach ($apiResponse['results'] as $classData) {
                try {
                    if (!is_array($classData)) {
                        continue; // Skip invalid entries
                    }
                    $classDto = ClassDto::fromArray($classData);
                    $this->createClassAction->handle($classDto);
                } catch (\Exception $e) {
                    // Log the error but continue processing other classes
                    \Log::warning('Failed to process class data', [
                        'class_data' => $classData,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } else {
            throw new \Exception('Invalid API response: missing or invalid results array');
        }

        return $apiResponse;
    }
}
