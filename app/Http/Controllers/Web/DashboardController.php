<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\Dungeons\ClassService;
use Exception;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controller for the dashboard page.
 *
 * This controller is responsible for rendering the dashboard page
 * and providing the necessary data for the dashboard components.
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected readonly ClassService $classService,
    ) {}

    /**
     * Display the dashboard page.
     *
     * This method fetches the necessary data for the dashboard components
     * and renders the dashboard page with that data.
     *
     * @throws Exception
     */
    public function index(): Response
    {
        $classes = $this->classService->getAllClasses()->toArray();

        return Inertia::render('dashboard', [
            'classes' => $classes,
        ]);
    }
}
