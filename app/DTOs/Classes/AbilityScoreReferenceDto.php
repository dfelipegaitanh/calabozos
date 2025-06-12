<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

/**
 * Data Transfer Object for ability score reference data.
 * 
 * Used in: ClassService::getClassByIndex
 */
readonly class AbilityScoreReferenceDto
{
    public function __construct(
        public string $index,
        public string $name,
        public string $url
    ) {}
    
    public static function fromArray(array $data): self
    {
        return new self(
            index: $data['index'] ?? '',
            name: $data['name'] ?? '',
            url: $data['url'] ?? ''
        );
    }
}
