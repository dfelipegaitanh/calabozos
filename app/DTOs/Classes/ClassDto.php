<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

use App\Models\ClassCharacter;

/**
 * Data Transfer Object for character class data.
 *
 * This DTO represents the core data structure for character classes,
 * providing immutable data transfer between layers of the application.
 */
readonly class ClassDto
{
    /**
     * Create a new ClassDto instance.
     *
     * @param  string  $index  The unique identifier for the class
     * @param  string  $name  The display name of the class
     * @param  string  $url  The API URL for the class
     */
    public function __construct(
        public string $index,
        public string $name,
        public string $url
    ) {}

    /**
     * Create a ClassDto from an array of data.
     *
     * @param  array  $data  Raw array data containing class information
     * @return self New ClassDto instance
     */
    public static function fromArray(array $data): self
    {
        return new self(
            index: $data['index'] ?? '',
            name: $data['name'] ?? '',
            url: $data['url'] ?? '',
        );
    }

    /**
     * Create a ClassDto from a ClassCharacter model.
     *
     * @param  ClassCharacter  $class  The model to convert to DTO
     * @return self New ClassDto instance
     */
    public static function fromModel(ClassCharacter $class): self
    {
        return new self(
            index: $class->index,
            name: $class->name,
            url: $class->url
        );
    }

    // Commented methods removed for clarity
}
