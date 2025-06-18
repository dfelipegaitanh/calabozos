<?php

declare(strict_types=1);

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\Dungeon\ClassDisplayController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('calabozos')->group(function (): void {
        Route::get('classes', [ClassDisplayController::class, 'index']);
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
