<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Dungeons\ClassController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);
/**
 * Routes for Dungeons & Dragons data management
 *
 * This group contains all endpoints related to D&D game data management.
 */
Route::prefix('/calabozos')
    ->middleware('auth:sanctum')
    ->group(function (): void {

        /**
         * Get all available character classes
         *
         * @return JsonResponse List of all character classes
         */
        Route::get('/classes', [ClassController::class, 'getClasses']);

        /**
         * Get details of a specific class by its index
         *
         * @param  string  $index  The class identifier (e.g., 'wizard', 'fighter')
         * @return JsonResponse Class details
         */
        Route::get('/classes/{index}', [ClassController::class, 'getClass']);

        /**
         * Get spellcasting information for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Spellcasting details
         */
        Route::get('/classes/{index}/spellcasting', [ClassController::class, 'getClassSpellcasting']);

        /**
         * Get multiclassing information for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Multiclassing details
         */
        Route::get('/classes/{index}/multiclassing', [ClassController::class, 'getClassMulticlassing']);

    });
