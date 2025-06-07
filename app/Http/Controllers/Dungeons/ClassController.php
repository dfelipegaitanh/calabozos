<?php

declare(strict_types=1);

namespace App\Http\Controllers\Dungeons;

use App\Http\Controllers\Controller;
use App\Services\Dungeons\ClassService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

/**
 * Controller responsible for handling character class-related HTTP requests.
 *
 * This controller delegates business logic to the ClassService and is responsible
 * for converting service responses to appropriate HTTP responses.
 */
class ClassController extends Controller
{
public function __construct(
     protected readonly ClassService $classService
 ) {
 }

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
                return response()->json([
                    'status' => 'error',
                    'message' => 'Class not found',
                ], 404);
            }

            return response()->json([
                'status' => 'success',
                'data' => $class,
            ]);
        } catch (Exception $e) {
            Log::error('Error retrieving class details: '.$e->getMessage(), [
                'exception' => $e,
                'class_id' => $index,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve class details: '.$e->getMessage(),
            ], 500);
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

            return response()->json([
                'status' => 'success',
                'data' => $classes,
            ]);
        } catch (Exception $e) {
            Log::error('Error retrieving classes: '.$e->getMessage(), [
                'exception' => $e,
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve classes: '.$e->getMessage(),
            ], 500);
        }
    }
}
