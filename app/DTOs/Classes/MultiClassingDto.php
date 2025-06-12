<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

/**
 * Data Transfer Object for multiclassing data.
 * 
 * Used in: ClassService::getClassMulticlassing
 */
readonly class MultiClassingDto
{
    public function __construct(
        public array $prerequisites,
        public array $proficiencies
    ) {}
    
    public static function fromArray(array $data): self
    {
        $prerequisites = [];
        foreach ($data['prerequisites'] ?? [] as $prerequisite) {
            $prerequisites[] = PrerequisiteDto::fromArray($prerequisite);
        }
        
        $proficiencies = [];
        foreach ($data['proficiencies'] ?? [] as $proficiency) {
            $proficiencies[] = ProficiencyReferenceDto::fromArray($proficiency);
        }
        
        return new self(
            prerequisites: $prerequisites,
            proficiencies: $proficiencies
        );
    }
}
