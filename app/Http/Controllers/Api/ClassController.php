<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\CalabozosApi;
use Exception;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{
    protected CalabozosApi $calabozosApi;

    public function __construct(CalabozosApi $calabozosApi)
    {
        $this->calabozosApi = $calabozosApi;
    }

    /**
     * Get all available classes from the API.
     */
    public function getClasses(): JsonResponse
    {
        try {
            $classes = $this->calabozosApi->getClasses();

            return response()->json([
                'status' => 'success',
                'data' => $classes,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to retrieve classes: '.$e->getMessage(),
            ], 500);
        }
    }
}
