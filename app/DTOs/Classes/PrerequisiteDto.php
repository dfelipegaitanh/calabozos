<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

/**
 * Data Transfer Object for prerequisite data.
 *
 * Used in: ClassService::getClassMulticlassing
 */
readonly class PrerequisiteDto
{
    public function __construct(
        public AbilityScoreReferenceDto $abilityScore,
        public int $minimumScore
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            abilityScore: AbilityScoreReferenceDto::fromArray($data['ability_score'] ?? []),
            minimumScore: $data['minimum_score'] ?? 0
        );
    }
}
