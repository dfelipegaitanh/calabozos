<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dungeons;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\LoggingTrait;
use App\Services\Dungeons\RaceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Controller for handling race-related HTTP requests.
 *
 * This controller provides endpoints for retrieving race data from the Calabozos API.
 * All endpoints require authentication via Sanctum.
 */
class RaceController extends Controller
{
    use ApiResponse;
    use LoggingTrait;

    public function __construct(
        private readonly RaceService $raceService
    ) {}

    /**
     * Get a specific race by its index.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return JsonResponse JSON response containing the race data or an error message
     */
    public function getRace(string $index): JsonResponse
    {
        try {
            $race = $this->raceService->getRace($index);

            if ($race === null) {
                return $this->errorResponse(
                    message: "Race '{$index}' not found",
                    code: ResponseAlias::HTTP_NOT_FOUND
                );
            }

            return $this->successResponse(data: $race);
        } catch (InvalidArgumentException $e) {
            $this->logWarning("Invalid race index provided: {$index}", [
                'error' => $e->getMessage(),
                'index' => $index,
            ]);

            return $this->errorResponse(
                message: $e->getMessage(),
                code: ResponseAlias::HTTP_BAD_REQUEST
            );
        } catch (Exception $e) {

            $this->logError("Failed to fetch race '{$index}'", $e, [
                'race_id' => $index,
            ]);

            return $this->errorResponse(
                message: 'Failed to fetch race data. Please try again later.',
                code: ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * Get all available races.
     *
     * @return JsonResponse JSON response containing the list of all races or an error message
     */
    public function getRaces(): JsonResponse
    {
        try {
            $races = $this->raceService->getRaces();

            return $this->successResponse(['races' => $races]);
        } catch (Exception $e) {
            $this->logError('Error retrieving races', $e);

            return $this->errorResponse('Failed to retrieve races: '.$e->getMessage());
        }
    }

    /**
     * Get subraces available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return JsonResponse JSON response containing the subraces data or an error message
     */
    public function getRaceSubraces(string $index): JsonResponse
    {
        try {
            $subraces = $this->raceService->getRaceSubraces($index);

            if ($subraces === null) {
                return $this->errorResponse(
                    message: "Subraces for race '{$index}' not found",
                    code: ResponseAlias::HTTP_NOT_FOUND
                );
            }

            return $this->successResponse(data: $subraces);
        } catch (InvalidArgumentException $e) {
            Log::warning("Invalid race index provided for subraces: {$index}", [
                'error' => $e->getMessage(),
                'index' => $index,
            ]);

            return $this->errorResponse(
                message: $e->getMessage(),
                code: ResponseAlias::HTTP_BAD_REQUEST
            );
        } catch (Exception $e) {
            Log::error("Failed to fetch subraces for race '{$index}'", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'index' => $index,
            ]);

            return $this->errorResponse(
                message: 'Failed to fetch subraces data. Please try again later.',
                code: ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    
    /**
     * Get proficiencies available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return JsonResponse JSON response containing the proficiencies data or an error message
     */
    public function getRaceProficiencies(string $index): JsonResponse
    {
        try {
            $proficiencies = $this->raceService->getRaceProficiencies($index);

            if ($proficiencies === null) {
                return $this->errorResponse(
                    message: "Proficiencies for race '{$index}' not found",
                    code: ResponseAlias::HTTP_NOT_FOUND
                );
            }

            return $this->successResponse(data: $proficiencies);
        } catch (InvalidArgumentException $e) {
            $this->logWarning("Invalid race index provided for proficiencies: {$index}", [
                'error' => $e->getMessage(),
                'index' => $index,
            ]);

            return $this->errorResponse(
                message: $e->getMessage(),
                code: ResponseAlias::HTTP_BAD_REQUEST
            );
        } catch (Exception $e) {
            $this->logError("Failed to fetch proficiencies for race '{$index}'", $e, [
                'race_id' => $index,
            ]);

            return $this->errorResponse(
                message: 'Failed to fetch proficiencies data. Please try again later.',
                code: ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
    
    /**
     * Get traits available for a specific race.
     *
     * @param  string  $index  The unique identifier for the race in the API
     * @return JsonResponse JSON response containing the traits data or an error message
     */
    public function getRaceTraits(string $index): JsonResponse
    {
        try {
            $traits = $this->raceService->getRaceTraits($index);

            if ($traits === null) {
                return $this->errorResponse(
                    message: "Traits for race '{$index}' not found",
                    code: ResponseAlias::HTTP_NOT_FOUND
                );
            }

            return $this->successResponse(data: $traits);
        } catch (InvalidArgumentException $e) {
            $this->logWarning("Invalid race index provided for traits: {$index}", [
                'error' => $e->getMessage(),
                'index' => $index,
            ]);

            return $this->errorResponse(
                message: $e->getMessage(),
                code: ResponseAlias::HTTP_BAD_REQUEST
            );
        } catch (Exception $e) {
            $this->logError("Failed to fetch traits for race '{$index}'", $e, [
                'race_id' => $index,
            ]);

            return $this->errorResponse(
                message: 'Failed to fetch traits data. Please try again later.',
                code: ResponseAlias::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
