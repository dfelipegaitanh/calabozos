# Calabozos API

A Laravel-based API for managing Dungeons & Dragons character classes and related game data. This project implements a clean architecture approach with Actions, DTOs, and Services to provide a robust and maintainable codebase.

## Project Structure

```
app/
├── Actions/
│   └── Classes/
│       ├── CreateClassAction.php        # Creates or retrieves a class character
│       └── FetchAndPersistClassesAction.php  # Fetches classes from API and persists them
├── DTOs/
│   └── Classes/
│       └── ClassDto.php                 # DTO for character class data
├── Http/
│   └── Controllers/
│       ├── Api/
│       │   └── AuthController.php       # Handles authentication
│       └── Dungeons/
│           └── ClassController.php      # Manages character classes endpoints
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

## API Endpoints

The API provides the following endpoints:

### Authentication
- `POST /api/login` - Authenticate user and receive API token

### Character Classes
- `GET /api/calabozos/classes` - Get all character classes
- `GET /api/calabozos/classes/{id}` - Get a specific character class by ID

All endpoints except login require authentication using Laravel Sanctum.

## External API Integration

The project integrates with an external D&D API through the `CalabozosApi` service, which provides methods to fetch character classes and other game data.

## Requirements

- PHP 8.3 or higher
- Laravel 12
- Composer

## License

This project is proprietary software. All rights reserved.
