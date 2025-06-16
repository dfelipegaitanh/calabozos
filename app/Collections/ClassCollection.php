<?php

declare(strict_types=1);

namespace App\Collections;

use App\DTOs\Classes\ClassDto;
use App\Models\ClassCharacter;
use Illuminate\Support\Collection;

/**
 * Collection Value Object for character classes.
 *
 * This class represents a specialized collection of ClassDto objects, providing
 * an immutable container for working with multiple class data objects
 * across the application.
 */
readonly class ClassCollection
{
    /**
     * Create a new ClassCollection instance.
     *
     * @param  Collection<int, ClassDto>  $items  Collection of ClassDto objects
     */
    public function __construct(
        public Collection $items
    ) {}

    /**
     * Create a ClassCollection from an array of class data.
     *
     * @param  array  $data  Array of raw class data
     * @return self  New ClassCollection instance
     */
    public static function fromArray(array $data): self
    {
        $classes = collect($data)->map(function (array $classData) {
            return ClassDto::fromArray($classData);
        });

        return new self(items: $classes);
    }

    /**
     * Create a ClassCollection from a collection of ClassCharacter models.
     *
     * @param  Collection<int, ClassCharacter>  $classes  Collection of ClassCharacter models
     * @return self  New ClassCollection instance
     */
    public static function fromModels(Collection $classes): self
    {
        $classDtos = $classes->map(function (ClassCharacter $class) {
            return ClassDto::fromModel($class);
        });

        return new self(items: $classDtos);
    }

    /**
     * Get the count of classes in the collection.
     *
     * @return int  The number of classes in the collection
     */
    public function count(): int
    {
        return $this->items->count();
    }

    /**
     * Check if the collection is empty.
     *
     * @return bool  True if the collection is empty, false otherwise
     */
    public function isEmpty(): bool
    {
        return $this->items->isEmpty();
    }

    /**
     * Get the first class in the collection.
     *
     * @return ClassDto|null  The first ClassDto or null if collection is empty
     */
    public function first(): ?ClassDto
    {
        return $this->items->first();
    }
    
    /**
     * Map over each item in the collection.
     *
     * @param  callable  $callback  Function to apply to each item
     * @return Collection  The transformed collection
     */
    public function map(callable $callback): Collection
    {
        return $this->items->map($callback);
    }
    
    /**
     * Convert the collection to an array.
     *
     * @return array<int, ClassDto>
     */
    public function toArray(): array
    {
        return $this->items->toArray();
    }
}
