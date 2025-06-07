# Monster Hunter Project Development Guidelines

This document provides essential information for developers working on the Calaboosproject.

## General Principles

- This project uses PHP 8.3, Laravel 12, TypeScript, ReactJs, Pest, and Tailwind
- All variables, methods, and classes must be named in English
- Every Controller and Component must work with its own dedicated Service
- Business logic must be encapsulated in Services or Actions, not in Controllers or Components
- All documentation, comments, and text content must be in English
- Follow SOLID principles and PSR-12 coding standards
- **IMPORTANT**: This project requires PHP 8.3 or higher. All code must be compatible with PHP 8.3 features and syntax

## Build/Configuration Instructions

### Prerequisites

1. PHP 8.3 or higher
2. Composer
3. Node.js and npm
4. SQLite (for testing)

### Initial Setup
1. Clone the repository
2. Install PHP dependencies:

```bash
composer install
```

1. Install JavaScript dependencies:

```bash
npm install
```

1. Create environment file:
```bash
cp .env.example .env
php artisan key:generate
```

1. Create SQLite database (for development):

```bash
touch database/database.sqlite
```

1. Run migrations:

```bash
php artisan migrate
```

### Development Environment

Run the development server with:

```bash
composer dev
```

This command runs multiple services concurrently:
- Laravel server
- Queue worker
- Log viewer (Pail)
- Vite development server

For SSR (Server-Side Rendering) development:
```bash
composer dev:ssr
```

## Architecture Patterns

### Action Pattern

- Use for single, focused business operations
- Place in `app/Actions` directory
- Must be `readonly` classes
- Use dependency injection in constructor
- Must implement a single `handle()` method
- Name with verb + noun + Action (e.g., `CreateUserAction`)

### Data Transfer Objects (DTOs)

- Use for transferring structured data between layers
- Place in `app/DTOs` directory
- Must be `readonly` classes
- Use constructor property promotion
- Include static factory methods for common conversions
- Name with noun + Dto (e.g., `UserDto`)
- **STRICT**: DTOs must NEVER contain null values, with the ONLY exception of numeric fields where null represents a specific business meaning

### Enums

- Use for fixed sets of related values
- Place in `app/Enums` directory
- Use backed enums for database storage
- Name with descriptive noun (e.g., `UserStatus`)
- Include helper methods when needed

### Services

- Handle business logic and orchestration
- Place in `app/Services` directory
- Use dependency injection
- Name with noun + Service (e.g., `UserService`)
- Should be focused and follow Single Responsibility Principle

## Testing Information

### Testing Configuration

The project uses Pest PHP (a wrapper around PHPUnit) for testing. Tests are configured in:

- `phpunit.xml` - Main configuration file
- `tests/Pest.php` - Pest-specific configuration

The testing environment uses:
- SQLite in-memory database
- Array cache driver
- Sync queue connection

### Running Tests
Run all tests:
```bash
composer test
```

Run a specific test file:
```bash
php artisan test tests/Feature/ExampleTest.php
```

Run tests with coverage report:
```bash
php artisan test --coverage
```

### Creating Tests
Tests are organized in two main directories:
- `tests/Feature/` - For feature/integration tests
- `tests/Unit/` - For unit tests

## Code Style

### Formatting

- Use consistent indentation (4 spaces)
- Keep line lengths reasonable (120 characters maximum)
- Use method chaining on new lines

### Type Declarations

- Always use strict typing (`declare(strict_types=1)`)
- Use return type declarations for all methods
- Use property type declarations
- Use union types where appropriate
- Never use `mixed` type; be as specific as possible

## Code Quality Tools

### PHP Code Style (Laravel Pint)
The project uses Laravel Pint for PHP code style. Configuration is in `pint.json`.

Run Pint on all files:
```bash
composer pint-dirty
```

Run Pint only on changed files:
```bash
composer php-lint
```

### PHP Code Refactoring (Rector)
The project uses Rector for PHP code refactoring. Configuration is in `rector.php`.

Run Rector on all files:
```bash
composer rector
```

Run Rector with dry-run (no changes):
```bash
composer rector-dry
```

### Static Analysis (PHPStan)
The project uses PHPStan for static analysis. Configuration is in `phpstan.neon`.

Run PHPStan:
```bash
composer phpstan
```

### JavaScript/TypeScript Linting
The project uses ESLint for JavaScript/TypeScript linting. Configuration is in `eslint.config.js`.

Run ESLint:
```bash
npm run lint
```

### Code Formatting
Format all code (PHP, JavaScript, TypeScript, CSS):
```bash
composer lint
```

Format only JavaScript/TypeScript/CSS:
```bash
npm run format
```

## Project Structure

The project follows the standard Laravel structure with React integration:

- `app/` - PHP application code
  - `Actions/` - Single-purpose business operations
  - `DTOs/` - Data Transfer Objects
  - `Enums/` - Typed enumerations
  - `Exceptions/` - Custom exception classes
  - `Services/` - Business logic and orchestration
- `config/` - Configuration files
- `database/` - Database migrations, seeders, and factories
- `resources/` - Frontend assets (React components, CSS, etc.)
- `routes/` - Route definitions
- `tests/` - Test files
- `vendor/` - Composer dependencies
- `node_modules/` - npm dependencies

### Key Components

#### Controllers

- Keep controllers thin
- Use method injection for dependencies
- Return appropriate HTTP responses
- Use FormRequest classes for validation
- Name with singular resource name + Controller (e.g., `UserController`)

#### Models

- Use Laravel's naming conventions (singular, PascalCase)
- Define relationships clearly
- Avoid `$fillable`; instead use explicit attribute assignment in services or actions
- Use `Model::query()` instead of `DB::` facade
- Document properties with PHPDoc

## Error Handling

- Use custom exceptions for business logic errors
- Log all unexpected errors
- Return appropriate HTTP status codes
- Provide meaningful error messages
- Use try-catch blocks only when you can handle the exception
- Create custom exception classes in `app/Exceptions`

## Performance Considerations

- Use eager loading to prevent N+1 queries
- Implement caching where appropriate
- Use pagination for large datasets
- Optimize database queries
- Use queue for time-consuming tasks
- Monitor and optimize memory usage

## Documentation Standards

- Document complex business logic
- Use PHPDoc for all classes and methods
- Keep documentation up-to-date
- Include examples for complex functionality
- Document API endpoints using OpenAPI/Swagger
- Add README files for complex modules

## Code Review

- Review for security vulnerabilities
- Check for performance issues
- Ensure code follows these standards
- Look for code smells and anti-patterns
- Suggest improvements and optimizations

## Maintenance

- Keep dependencies updated
- Remove unused code
- Refactor when necessary
- Keep documentation up-to-date
- Monitor application performance
- Address technical debt regularly
