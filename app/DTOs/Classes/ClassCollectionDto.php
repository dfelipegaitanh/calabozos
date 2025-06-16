<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

use App\Models\ClassCharacter;
use Illuminate\Support\Collection;

/**
 * Data Transfer Object for a collection of character classes.
 *
 * This DTO represents a collection of ClassDto objects, providing
 * an immutable container for transferring multiple class data objects
 * between layers of the application.
 */
readonly class ClassCollectionDto
{
    /**
     * Create a new ClassCollectionDto instance.
     *
     * @param  Collection<int, ClassDto>  $classes  Collection of ClassDto objects
     */
    public function __construct(
        public Collection $classes
    ) {}

    /**
     * Create a ClassCollectionDto from an array of class data.
     *
     * @param  array  $data  Array of raw class data
     * @return self  New ClassCollectionDto instance
     */
    public static function fromArray(array $data): self
    {
        $classes = collect($data)->map(function (array $classData) {
            return ClassDto::fromArray($classData);
        });

        return new self(classes: $classes);
    }

    /**
     * Create a ClassCollectionDto from a collection of ClassCharacter models.
     *
     * @param  Collection<int, ClassCharacter>  $classes  Collection of ClassCharacter models
     * @return self  New ClassCollectionDto instance
     */
    public static function fromModels(Collection $classes): self
    {
        $classDtos = $classes->map(function (ClassCharacter $class) {
            return ClassDto::fromModel($class);
        });

        return new self(classes: $classDtos);
    }

    /**
     * Get the count of classes in the collection.
     *
     * @return int  The number of classes in the collection
     */
    public function count(): int
    {
        return $this->classes->count();
    }

    /**
     * Check if the collection is empty.
     *
     * @return bool  True if the collection is empty, false otherwise
     */
    public function isEmpty(): bool
    {
        return $this->classes->isEmpty();
    }

    /**
     * Get the first class in the collection.
     *
     * @return ClassDto|null  The first ClassDto or null if collection is empty
     */
    public function first(): ?ClassDto
    {
        return $this->classes->first();
    }
}
