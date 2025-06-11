<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dungeons;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponse;
use App\Http\Traits\LoggingTrait;
use App\Services\Dungeons\ClassService;
use Exception;
use Illuminate\Http\JsonResponse;

/**
 * Controller responsible for handling character class-related HTTP requests.
 *
 * This controller delegates business logic to the ClassService and is responsible
 * for converting service responses to appropriate HTTP responses.
 */
class ClassController extends Controller
{
    use ApiResponse;
    use LoggingTrait;

    public function __construct(
        protected readonly ClassService $classService
    ) {}

    /**
     * Retrieve a specific character class by its index identifier.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return JsonResponse HTTP response containing the class data or error message
     */
    public function getClass(string $index): JsonResponse
    {
        try {
            $class = $this->classService->getClassByIndex($index);

            if ($class === null || $class === []) {
                return $this->notFoundResponse('Class not found');
            }

            return $this->successResponse(['class' => $class]);
        } catch (Exception $e) {
            $this->logError('Error retrieving class details', $e, [
                'class_id' => $index,
            ]);

            return $this->errorResponse('Failed to retrieve class details: '.$e->getMessage());
        }
    }

    /**
     * Retrieve and synchronize all character classes from the API.
     *
     * This endpoint fetches all classes from the external API and ensures
     * they are stored in the local database through the ClassService.
     *
     * @return JsonResponse HTTP response containing all classes or error message
     */
    public function getClasses(): JsonResponse
    {
        try {
            $classes = $this->classService->getAllClasses();

            return $this->successResponse(['classes' => $classes]);
        } catch (Exception $e) {
            $this->logError('Error retrieving classes', $e);

            return $this->errorResponse('Failed to retrieve classes: '.$e->getMessage());
        }
    }

    /**
     * Retrieve multiclassing information for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return JsonResponse HTTP response containing the multiclassing data or error message
     */
    public function getClassMulticlassing(string $index): JsonResponse
    {
        try {
            $multiclassing = $this->classService->getClassMulticlassing($index);

            return $this->successResponse(['multiclassing' => $multiclassing]);
        } catch (Exception $e) {
            $this->logError('Error retrieving multiclassing information', $e, [
                'class_id' => $index,
            ]);

            return $this->errorResponse('Failed to retrieve multiclassing information: '.$e->getMessage());
        }
    }

    /**
     * Retrieve spellcasting information for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return JsonResponse HTTP response containing the spellcasting data or error message
     */
    public function getClassSpellcasting(string $index): JsonResponse
    {
        try {
            $spellcasting = $this->classService->getClassSpellcasting($index);

            return $this->successResponse(['spellcasting' => $spellcasting]);
        } catch (Exception $e) {
            $this->logError('Error retrieving spellcasting information', $e, [
                'class_id' => $index,
            ]);

            return $this->errorResponse('Failed to retrieve spellcasting information: '.$e->getMessage());
        }
    }

    /**
     * Retrieve subclasses available for a specific character class.
     *
     * @param  string  $index  The unique identifier for the class in the API
     * @return JsonResponse HTTP response containing the subclasses data or error message
     */
    public function getClassSubclasses(string $index): JsonResponse
    {
        try {
            $subclasses = $this->classService->getClassSubclasses($index);

            return $this->successResponse(['subclasses' => $subclasses]);
        } catch (Exception $e) {
            $this->logError('Error retrieving subclasses information', $e, [
                'class_id' => $index,
            ]);

            return $this->errorResponse('Failed to retrieve subclasses information: '.$e->getMessage());
        }
    }
}
