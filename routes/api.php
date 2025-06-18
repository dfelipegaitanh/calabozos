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
    ->name('calabozos.')
    ->middleware('auth:sanctum')
    ->group(function (): void {

        /**
         * Get all available character classes
         *
         * @return JsonResponse List of all character classes
         */
        Route::get('/classes', [ClassController::class, 'getClasses'])
            ->name('classes');

        /**
         * Get details of a specific class by its index
         *
         * @param  string  $index  The class identifier (e.g., 'wizard', 'fighter')
         * @return JsonResponse Class details
         */
        Route::get('/classes/{index}', [ClassController::class, 'getClass'])
            ->name('classes.index');

        /**
         * Get spellcasting information for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Spellcasting details
         */
        Route::get('/classes/{index}/spellcasting', [ClassController::class, 'getClassSpellcasting'])
            ->name('classes.spellcasting');

        /**
         * Get multiclassing information for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Multiclassing details
         */
        Route::get('/classes/{index}/multiclassing', [ClassController::class, 'getClassMulticlassing'])
            ->name('classes.multiclassing');

        /**
         * Get subclasses available for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Subclasses available for the class
         */
        Route::get('/classes/{index}/subclasses', [ClassController::class, 'getClassSubclasses'])
            ->name('classes.subclasses');

        /**
         * Get spells available for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Spells available for the class
         */
        Route::get('/classes/{index}/spells', [ClassController::class, 'getClassSpells'])
            ->name('classes.spells');

        /**
         * Get features available for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Features available for the class
         */
        Route::get('/classes/{index}/features', [ClassController::class, 'getClassFeatures'])
            ->name('classes.features');

        /**
         * Get proficiencies available for a specific class
         *
         * @param  string  $index  The class identifier
         * @return JsonResponse Proficiencies available for the class
         */
        Route::get('/classes/{index}/proficiencies', [ClassController::class, 'getClassProficiencies'])
            ->name('classes.proficiencies');

    });
