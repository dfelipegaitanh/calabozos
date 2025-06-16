<?php

declare(strict_types=1);

namespace App\DTOs\Classes;

/**
 * Data Transfer Object for proficiency choice data.
 *
 * Used in: ClassService::getClassByIndex
 */
readonly class ProficiencyChoiceDto
{
    public function __construct(
        public string $desc,
        public int $choose,
        public string $type,
        public array $from
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            desc: $data['desc'] ?? '',
            choose: $data['choose'] ?? 0,
            type: $data['type'] ?? '',
            from: $data['from'] ?? []
        );
    }
}
