# Calabozos API

A Laravel-based API for managing Dungeons & Dragons character classes and related game data. This project implements a clean architecture approach with Actions, DTOs, and Services to provide a robust and maintainable codebase following SOLID principles and PSR-12 coding standards.

## Project Structure

```text
app/
├── Actions/
│   └── Classes/
│       ├── CreateClassAction.php        # Creates or retrieves a class character
│       └── FetchAndPersistClassesAction.php  # Fetches classes from API and persists them
├── DTOs/
│   └── Classes/
│       └── ClassDto.php                 # DTO for character class data
├── Http/
│   ├── Controllers/
│   │   ├── Api/
│   │   │   └── AuthController.php       # Handles authentication
│   │   └── Dungeons/
│   │       └── ClassController.php      # Manages character classes endpoints
│   └── Traits/
│       ├── ApiResponse.php             # Standardizes API responses format
│       └── LoggingTrait.php            # Standardizes logging across the application
├── Models/
│   ├── ClassCharacter.php              # Model for character classes
│   └── User.php                        # User model for authentication
├── Providers/
│   └── AppServiceProvider.php          # Service provider for app configuration
└── Services/
    ├── Api/
    │   ├── CalabozosApi.php            # Specific API endpoints for Calabozos
    │   └── CalabozosApiClient.php      # Base client for API communication
    └── Dungeons/
        └── ClassService.php            # Service for managing character classes
```

## API Routes Structure

### Current Implementation Example: Character Classes

This example demonstrates the routing pattern to be followed for all future API developments. The routes are organized under the `/calabozos` prefix and are protected by Sanctum authentication middleware.

```php
// Group for character classes endpoints
Route::prefix('/classes')
    ->group(function (): void {
        // GET /calabozos/classes - List all classes
        Route::get('/', [ClassController::class, 'getClasses']);

        // GET /calabozos/classes/{index} - Get a specific class
        Route::get('/{index}', [ClassController::class, 'getClass']);

        // GET /calabozos/classes/{index}/spellcasting - Get spellcasting info
        Route::get('/{index}/spellcasting', [ClassController::class, 'getClassSpellcasting']);
    });
```

### Pattern to Follow for New Features

For each new feature or resource, follow this structure:

1. Create a new route group under the `/calabozos` prefix
2. Group related endpoints under a meaningful prefix (plural noun)
3. Use RESTful naming conventions for routes and controller methods
4. Document each endpoint with a clear comment

Example for a new feature (e.g., Races):

```php
// Group for character races endpoints
Route::prefix('/races')
    ->group(function (): void {
        Route::get('/', [RaceController::class, 'index']);
        Route::get('/{index}', [RaceController::class, 'show']);
        // Additional race-related endpoints...
    });
```

## API Endpoints

The API provides the following endpoints:

### Authentication

- `POST /api/login` - Authenticate user and receive API token

### Character Classes

- `GET /api/calabozos/classes` - Get all character classes
- `GET /api/calabozos/classes/{index}` - Get a specific character class by index
- `GET /api/calabozos/classes/{index}/spellcasting` - Get spellcasting information for a specific class
- `GET /api/calabozos/classes/{index}/multiclassing` - Get multiclassing information for a specific class

All endpoints except login require authentication using Laravel Sanctum.

## Architecture Integration

The API routes integrate with the project architecture as follows:

1. **Routes** (`routes/api.php`) define the HTTP endpoints and connect to Controllers
2. **Controllers** handle HTTP requests and delegate business logic to Services
3. **Services** orchestrate business operations and use Actions for specific tasks
4. **Actions** perform single, focused business operations
5. **DTOs** transfer data between layers in a structured format
6. **Models** represent database entities and relationships
7. **Traits** provide reusable functionality across different components

This layered architecture ensures separation of concerns and follows the SOLID principles established in the project standards.

## Shared Components

### Traits

The application uses traits to share functionality across different components:

#### ApiResponse Trait

Located at `app/Http/Traits/ApiResponse.php`, this trait standardizes API responses across all controllers with methods like:

- `successResponse(array|object $data, ?string $message = null, int $code = 200)`: Returns a standardized success response
- `errorResponse(string $message, int $code = 500, ?array $errors = null)`: Returns a standardized error response
- `notFoundResponse(string $message = 'Resource not found')`: Returns a standardized 404 response

#### LoggingTrait

Located at `app/Http/Traits/LoggingTrait.php`, this trait provides consistent logging functionality with methods like:

- `logError(string $message, Exception $exception, array $context = [])`: Logs errors with enriched exception context
- `logInfo(string $message, array $context = [])`: Logs informational messages
- `logWarning(string $message, array $context = [])`: Logs warning messages
- `logDebug(string $message, array $context = [])`: Logs debug messages

These traits help maintain consistency across the application while reducing code duplication.

## External API Integration

The project integrates with an external D&D API through the `CalabozosApi` service, which provides methods to fetch character classes and other game data.

## Requirements

- PHP 8.3 or higher
- Laravel 12
- Composer

## License

This project is proprietary software. All rights reserved.
