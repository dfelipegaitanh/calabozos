<?php

declare(strict_types=1);

namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;

/**
 * Trait para estandarizar respuestas API en controladores.
 * 
 * Este trait proporciona métodos consistentes para generar respuestas
 * de éxito y error con códigos de estado y formato apropiados.
 */
trait ApiResponse
{
    /**
     * Generate a standardized success response.
     *
     * @param array|object $data The data to include in the response
     * @param string|null $message Optional success message
     * @param int $code HTTP status code
     * @return JsonResponse
     */
    protected function successResponse(array|object $data, ?string $message = null, int $code = 200): JsonResponse
    {
        $response = ['data' => $data];
        
        if ($message !== null) {
            $response['message'] = $message;
        }
        
        return response()->json($response, $code);
    }

    /**
     * Generate a standardized error response.
     *
     * @param string $message Error message
     * @param int $code HTTP status code
     * @param array|null $errors Additional error details
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $code = 500, ?array $errors = null): JsonResponse
    {
        $response = ['message' => $message];
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        return response()->json($response, $code);
    }

    /**
     * Generate a not found response.
     *
     * @param string $message Custom not found message
     * @return JsonResponse
     */
    protected function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return $this->errorResponse($message, 404);
    }
}
