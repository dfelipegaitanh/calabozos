<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Dungeons\ClassController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::prefix('/calabozos')
    ->middleware('auth:sanctum')
    ->group(function (): void {

        Route::prefix('/classes')
            ->group(function (): void {
                Route::get('/', [ClassController::class, 'getClasses']);
                Route::get('/{index}', [ClassController::class, 'getClass']);
                Route::get('/{index}/spellcasting', [ClassController::class, 'getClassSpellcasting']);
                Route::get('/{index}/multiclassing', [ClassController::class, 'getClassMulticlassing']);
            });

    });
