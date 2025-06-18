<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web\Dungeon;

use App\DTOs\Classes\ClassCollectionDto;
use App\Http\Controllers\Controller;
use App\Services\Dungeons\ClassService;
use Exception;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller for displaying Dungeons & Dragons class data in web views.
 *
 * This controller is responsible for fetching class data from the API
 * and displaying it in web views.
 */
class ClassDisplayController extends Controller
{
    public function __construct(
        protected readonly ClassService $classService,
        protected readonly ClassCollectionDto $classCollectionDto,
    ) {}

    /**
     * Display all available character classes.
     *
     * This method fetches class data from the API endpoint and
     * renders the Clases page with the data.
     * @throws Exception
     */
    public function index(): Response
    {
        $classes = $this->classService->getAllClasses();

        return Inertia::render('Calabozos/ClasesList', [
            'classes' => $classes,
        ]);
    }
}
